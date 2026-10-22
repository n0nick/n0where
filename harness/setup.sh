#!/usr/bin/env bash
# One-time local setup. Safe to re-run.
set -euo pipefail
cd "$(dirname "$0")/.."

mkdir -p templates_c cache configs
chmod 777 templates_c cache configs   # bind-mounted; www-data inside must write

if [[ ! -f inc/local.ini.php ]]; then
  cp harness/local.ini.php inc/local.ini.php
  echo "created inc/local.ini.php (gitignored) -- reconcile with prod's sagim.ini.php"
else
  echo "inc/local.ini.php already exists, left alone"
fi

if ! ls harness/seed/*.sql >/dev/null 2>&1; then
  echo
  echo "MISSING SEED. Extract n0db from the dump:"
  echo "  sed -n '2306,2770p' /tmp/alldb/all-databases-2026-10-22.sql > harness/seed/01-n0db.sql"
  exit 1
fi

echo "ok -- now: docker compose -f harness/compose.yml up -d --build"
