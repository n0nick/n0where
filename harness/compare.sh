#!/usr/bin/env bash
# Replay urls.txt on PHP 8.3 and compare against the 7.4 goldens.
# Exit 0 only when every URL matches status + body and emits no fatal.
# Deprecations/warnings are reported as a delta, not an automatic failure --
# 7.4 already emits 11 of them, and they are the roadmap, not the bug.
set -uo pipefail
cd "$(dirname "$0")"

[[ -d golden && -n "$(ls -A golden 2>/dev/null)" ]] || {
  echo "no goldens -- run ./capture.sh 8074 golden on UNMODIFIED code first"; exit 2; }

./capture.sh 8083 candidate >/dev/null

fail=0
for g in golden/*.body; do
  name="$(basename "$g" .body)"
  url="$(cut -d' ' -f2- < "golden/$name.http")"
  c="candidate/$name.body"

  [[ -f "$c" ]] || { echo "MISSING  $url"; fail=1; continue; }

  gcode="$(cut -d' ' -f1 < "golden/$name.http")"
  ccode="$(cut -d' ' -f1 < "candidate/$name.http")"

  if grep -qE 'Fatal error|Parse error' "candidate/$name.errors"; then
    echo "FATAL    $url"
    sed 's/^/           /' "candidate/$name.errors" | grep -E 'Fatal|Parse'
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

  gn=$(awk '{s+=$1} END{print s+0}' "golden/$name.errors")
  cn=$(awk '{s+=$1} END{print s+0}' "candidate/$name.errors")
  if [[ "$cn" -gt 0 ]]; then
    echo "ok(warn) $url   diagnostics 7.4=$gn  8.3=$cn"
  else
    echo "ok       $url   diagnostics 7.4=$gn  8.3=0"
  fi
done

[[ $fail -eq 0 ]] && echo "PASS" || echo "FAIL"
exit $fail
