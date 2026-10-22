#!/usr/bin/env bash
# Capture output from one port, splitting PHP diagnostics from rendered body.
#   ./capture.sh 8074 golden      <- the PHP 7.4 reference
#   ./capture.sh 8083 candidate   <- the PHP 8.3 run
# Produces per URL:  <slug>.http (status)  <slug>.body (normalised HTML)
#                    <slug>.errors (PHP diagnostics, deduped with counts)
set -euo pipefail
cd "$(dirname "$0")"

PORT="${1:-8074}"
OUT="${2:-golden}"
mkdir -p "$OUT"
rm -f "$OUT"/*.http "$OUT"/*.body "$OUT"/*.errors 2>/dev/null || true

urls=()
while IFS= read -r url; do
  [[ -z "$url" || "$url" == \#* ]] && continue
  urls+=("$url")
done < urls.txt

# Each PHP version has its own templates_c/cache named volume, so the two can
# never execute each other's compiled templates. Still clear before capturing:
# Smarty recompiles when a .tpl changes but has no idea the COMPILER changed,
# so edits to Smarty_Compiler.class.php would otherwise run against stale output.
SVC="php${PORT#80}"

# Guard: assert the port really serves the PHP version its name claims.
# nginx caches fastcgi upstream DNS at startup, so a container rebuild can
# silently swap which version answers which port -- and then golden and
# candidate describe the wrong things while still looking plausible.
want="${SVC#php}"; want="${want:0:1}.${want:1}"
got="$(curl -s "http://localhost:$PORT/__phpver" || true)"
if [[ "$got" != "$want" ]]; then
  echo "ABORT: port $PORT should serve PHP $want but serves '${got:-<no answer>}'" >&2
  echo "       (try: docker compose -f compose.yml restart web)" >&2
  exit 3
fi
docker compose -f compose.yml exec -T "$SVC" \
  sh -c 'rm -rf /var/www/html/n0/templates_c/* /var/www/html/n0/cache/*' 2>/dev/null || true

# Warm pass: compile templates and let any compile-time diagnostics land
# here rather than in the recorded run.
for url in "${urls[@]}"; do curl -s -o /dev/null "http://localhost:$PORT$url"; done

for url in "${urls[@]}"; do
  slug="$(printf '%s' "$url" | sed -e 's#^/##' -e 's#[^A-Za-z0-9._-]#_#g')"
  [[ -z "$slug" ]] && slug="root"

  docker compose -f compose.yml exec -T "$SVC" sh -c ': > /tmp/php-errors.log'

  code="$(curl -s -o "$OUT/$slug.raw" -w '%{http_code}' "http://localhost:$PORT$url")"
  printf '%s %s\n' "$code" "$url" > "$OUT/$slug.http"

  docker compose -f compose.yml exec -T "$SVC" cat /tmp/php-errors.log 2>/dev/null \
    | sed -E 's#^\[[^]]*\] ##; s#PHP (Deprecated|Warning|Notice|Fatal error|Parse error):#\1:#' \
    | sed -E 's# in /var/www/html/n0/# in #; s#templates_c/%%[^ ]*%%#templates_c/<COMPILED>#' \
    | sed -E 's#, referer:.*##' | sort | uniq -c > "$OUT/$slug.errors" || true

  ./normalize.sh < "$OUT/$slug.raw" > "$OUT/$slug.body"
  rm -f "$OUT/$slug.raw"

  nerr=$(awk '{s+=$1} END{print s+0}' "$OUT/$slug.errors")
  printf '  %s  %-28s %s diagnostic(s)\n' "$code" "$url" "$nerr"
done

echo "captured -> $OUT/"
