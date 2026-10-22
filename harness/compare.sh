#!/usr/bin/env bash
# Replay urls.txt on PHP 8.3 and compare against the 7.4 goldens.
# Exit 0 only when every URL matches status + body and emits no fatal.
# Deprecations/warnings are reported as a delta, not an automatic failure --
# 7.4 already emits 11 of them, and they are the roadmap, not the bug.
set -uo pipefail
cd "$(dirname "$0")"

# compare.sh [urls-file] [golden-dir] [candidate-dir]
URLS="${1:-urls.txt}"
GOLD="${2:-golden}"
CAND="${3:-candidate}"

[[ -d $GOLD && -n "$(ls -A "$GOLD" 2>/dev/null)" ]] || {
  echo "no goldens in $GOLD -- run ./capture.sh 8074 $GOLD $URLS first"; exit 2; }

./capture.sh 8083 "$CAND" "$URLS" >/dev/null

fail=0
for g in "$GOLD"/*.body; do
  name="$(basename "$g" .body)"
  url="$(cut -d' ' -f2- < "$GOLD/$name.http")"
  c="$CAND/$name.body"

  [[ -f "$c" ]] || { echo "MISSING  $url"; fail=1; continue; }

  gcode="$(cut -d' ' -f1 < "$GOLD/$name.http")"
  ccode="$(cut -d' ' -f1 < "$CAND/$name.http")"

  if grep -qE 'Fatal error|Parse error' "$CAND/$name.errors"; then
    echo "FATAL    $url"
    sed 's/^/           /' "$CAND/$name.errors" | grep -E 'Fatal|Parse'
    fail=1; continue
  fi

  if [[ "$gcode" != "$ccode" ]]; then
    echo "STATUS   $url   7.4=$gcode  8.3=$ccode"; fail=1; continue
  fi

  if ! diff -q "$g" "$c" >/dev/null; then
    echo "DIFF     $url"
    diff -u "$g" "$c" | sed -n '3,40p' | sed 's/^/           /'
    fail=1; continue
  fi

  gn=$(awk '{s+=$1} END{print s+0}' "$GOLD/$name.errors")
  cn=$(awk '{s+=$1} END{print s+0}' "$CAND/$name.errors")
  if [[ "$cn" -gt 0 ]]; then
    echo "ok(warn) $url   diagnostics 7.4=$gn  8.3=$cn"
  else
    echo "ok       $url   diagnostics 7.4=$gn  8.3=0"
  fi
done

[[ $fail -eq 0 ]] && echo "PASS" || echo "FAIL"
exit $fail
