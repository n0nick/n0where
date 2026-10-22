#!/usr/bin/env bash
# Snapshot live production output, then diff a later snapshot against it.
# Run BEFORE touching anything, and again after each deploy step.
#
#   ./prodcheck.sh before
#   ...deploy...
#   ./prodcheck.sh after && ./prodcheck.sh diff
#
# Normalisation matches normalize.sh so the page's own benchmark timer and
# timestamps do not show up as false changes.
set -uo pipefail
cd "$(dirname "$0")"

BASE="${PRODCHECK_BASE:-https://n0where.n0nick.net}"
MODE="${1:-before}"

snap() {
  local out="prod_$1"; mkdir -p "$out"; rm -f "$out"/*
  while IFS= read -r url; do
    [[ -z "$url" || "$url" == \#* ]] && continue
    local slug; slug="$(printf '%s' "$url" | sed -e 's#^/##' -e 's#[^A-Za-z0-9._-]#_#g')"
    [[ -z "$slug" ]] && slug=root
    local code; code="$(curl -s -o "$out/$slug.raw" -w '%{http_code}' "$BASE$url")"
    printf '%s %s\n' "$code" "$url" > "$out/$slug.http"
    ./normalize.sh < "$out/$slug.raw" > "$out/$slug.body"
    rm -f "$out/$slug.raw"
    printf '  %s  %s\n' "$code" "$url"
  done < urls.txt
  echo "snapshot -> $out/"
}

case "$MODE" in
  before|after) snap "$MODE" ;;
  diff)
    [[ -d prod_before && -d prod_after ]] || { echo "need both snapshots"; exit 2; }
    fail=0
    for b in prod_before/*.body; do
      n="$(basename "$b" .body)"; url="$(cut -d' ' -f2- < "prod_before/$n.http")"
      bc="$(cut -d' ' -f1 < "prod_before/$n.http")"; ac="$(cut -d' ' -f1 < "prod_after/$n.http" 2>/dev/null || echo MISSING)"
      if [[ "$bc" != "$ac" ]]; then echo "STATUS  $url  before=$bc after=$ac"; fail=1; continue; fi
      if ! diff -q "$b" "prod_after/$n.body" >/dev/null 2>&1; then
        echo "DIFF    $url"; diff -u "$b" "prod_after/$n.body" | sed -n '3,20p' | sed 's/^/          /'; fail=1
      else echo "ok      $url  ($bc)"; fi
    done
    [[ $fail -eq 0 ]] && echo "PROD UNCHANGED" || echo "PROD CHANGED"
    exit $fail ;;
  *) echo "usage: $0 before|after|diff"; exit 2 ;;
esac
