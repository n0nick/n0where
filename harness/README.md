# n0where PHP 8 harness

Runs the same codebase under PHP 7.4 and PHP 8.3 side by side so the 7.4
output can be used as the acceptance oracle for the port.

    :8074  PHP 7.4  <- reference, matches prod
    :8083  PHP 8.3  <- target

## Why golden files and not just a smoke test

The largest blocker in this codebase is that **every class uses a PHP 4
constructor** (`function Site($configfile)`, 26 of them, no `__construct`
anywhere). PHP 8 removed those. `new Site(...)` does not error — it returns an
object with every property null and carries on. Breakage of that shape renders
a page; it just renders the wrong one. A smoke test passes. A diff does not.

Same story for the delimiter-less `preg_match("^HTTP", ...)` calls introduced
in 682480a: they warn and return false, silently inverting a branch.

## Setup

    ./harness/setup.sh
    { sed -n '1,20p'      /tmp/alldb/all-databases-2026-10-22.sql; \
      sed -n '2306,2770p' /tmp/alldb/all-databases-2026-10-22.sql; } > harness/seed/01-n0db.sql
    docker compose -f harness/compose.yml up -d --build

The first slice is mysqldump's header. It is **not optional**: line 10 is
`/*!50503 SET NAMES utf8mb4 */` and without it the restore aborts with
`ERROR 1366 Incorrect string value` on the first Hebrew comment.

The schema is three charsets deep -- `n0_posts` and `n0_figures` are
`hebrew` (ISO-8859-8), `n0_comments` is `utf8mb3`, and a dormant `wp_*`
WordPress install in the same database is `latin1`. Restore it exactly as
prod has it; do not "fix" the charsets, or the golden files stop describing
prod.

Table prefix is `n0_` -- `inc/local.ini.php` must say so.

`setup.sh` creates the writable Smarty dirs (`templates_c`, `cache`,
`configs`) and drops `inc/local.ini.php` into place. `inc/*.ini*` is
gitignored, so nothing secret gets committed.

**Reconcile the config.** The placeholder `local.ini.php` will not reproduce
prod's output. Copy prod's `inc/sagim.ini.php` over it and change only the
`[database]` block to point at `db` / `n0db` / `n0db`.

## Capture and compare

    ./harness/capture.sh 8074 golden    # reference, once, on unmodified code
    ./harness/compare.sh                # replay on 8.3 and diff

`compare.sh` exits non-zero on any status mismatch, any emitted PHP
error/warning/deprecation, or any normalised body diff. That exit code is the
loop's signal.

Before trusting the goldens, capture twice from 8074 and diff the two. Any
difference is non-determinism that belongs in `normalize.sh`.

### Add real URLs

`urls.txt` ships with static routes only. Add real post and archive IDs:

    docker compose -f harness/compose.yml exec db \
      mysql -un0db -pn0db n0db -e "SELECT ... LIMIT 10"

Coverage matters more than count — one post with comments, one archive month,
the RSS feed, a 404.

## Order of work

1. Capture goldens from 7.4.
2. **PHP 4 constructors** -> `__construct`. Biggest win, purely mechanical.
3. Removed functions: `ereg_replace`, `split`, `each` in
   `gah/bloggerfunctions/`, `Smarty_Compiler.class.php:534`,
   `plugins/function.fetch.php`.
4. The delimiter bug in `gah/bloggerfunctions/xmlrpc.php` (8 sites).
5. Re-run `compare.sh` until clean.

Smarty 2.6.6 is in scope for steps 2–3 — patch it in place first. If that gets
ugly, branch and try Smarty 5 against the *same* goldens, which makes the two
approaches directly comparable.

## Not covered

`addons/from.n0where.php` still calls `mysql_connect()` (removed in PHP 7.0),
so it is already dead on prod today. Confirm it is unreachable rather than
porting it.
