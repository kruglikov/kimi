# Session log — PHP 8.5 upgrade: DB subset, Rector, green smoke baseline, dev deploy (2026-08-14)

# Prompt / Session / Request summary

The session started from a broken/oversized local DB import and ran through Phases 1–3 of `02-option1-execution-plan.md`. The user's requests, in order:

- Diagnose why the full production DB import failed locally (disk full) and get a usable local DB with **real data**; keep 1 client's worth / cut per-client volume as needed.
- Report progress on the streaming import repeatedly; reclaim disk.
- Explain the smoke-test safety net and run it against the imported data.
- Explain **Phase 1** (manual-fix port map): where to save it, why it's needed. Then execute **1.1** into a new `03-…` file.
- Explain how `devH`/`upgH`/`PORT-CLEAN`/`NO-8.5-FIX` help; whether NO-8.5-FIX files still need manual fixes.
- Two plan-amendment concerns: (1) don't port code from `src/upgraded-src` — make Phase 2.4 test-driven; (2) review the safety-net discovery coverage. Approve amendments, then run **2.1–2.3** (Rector), commit the Rector output, proceed to **2.4** (report before changing).
- Provide a script to run the safety net (`src-dev-scripts/run-safety-net.sh`).
- Ask "do we need to fix all smoke failures?", options/recommendation per group; save the found problems as a **client-facing** doc (`06-…`) with the missing-table list + files.
- Clarify the quarantine mechanism; is `mysql_*` migration 100% safe.
- Apply §2 quarantine, commit `subdetail.php`, mark resolved sections in `05-…`.
- Notice the batch smoke **executes** import jobs (DB mutation + PII) → switch to `php -l` (option B).
- Ask which §7 / other items are safe to fix and how; then **fix §7** (harness) and **Tier 2** cautiously.
- Decide A (quarantine) vs B (build `$akt` context) for the context-dependent screens → chose **A**.
- Mark **2.5** done, push `e020fdd`, then **deploy to the dev server now** (no maintenance window on the test env).

# Summary

Approach and key decisions:

- **Local DB**: the full `kimidev_et` dump is ~15.4 GB and the disk was 100% full, so we streamed a **subset** from the server straight into the local docker DB (all small tables in full + the 12 largest tables capped at 5,000 rows). Two blockers were fixed inline: MariaDB table-level `` `encrypted`=yes `` was stripped via `sed` on the stream (local server has no encryption plugin), and broken foreign-`DEFINER` triggers were dropped so capped inserts could run. Running the smoke suite then revealed the **stored routines** (`kimi_decrypt`/`kimi_encrypt`, 37 total) had been dropped by an earlier `--routines`-less import; they were re-loaded from the client-provided dump.
- **Phase 1** produced a three-way (baseline/dev/upgraded) logic-only diff map: of ~50 substantive differing files, **0** need manual-fix adaptation — the 8.5 fixes and dev customizations occupy disjoint lines.
- **Phase 2.4/2.5** were re-scoped to **test-driven** (per the user): Rector re-run on the dev tree, then the smoke suite drives fixes on the **dev code**, using `src/upgraded-src` only as a reference. The genuine 8.5 code work turned out to be **one line** (`subdetail.php` `count(null)` guard). Everything else was triaged as pre-existing/dead/harness/absent-feature and resolved **test-infra only** — via quarantine (documented skips), switching batch smoke to `php -l` (no execution → no DB mutation/PII), a harness seed-user fix (`admin`→`system`), and a router `session_name()` ordering fix. Result: **green baseline 142 pass / 72 skip / 0 fail**.
- A key **judgment call**: the remaining "method on null" failures (`akt.php`, `subdetail`, `kunde_details`, `subuebersicht`) were investigated and found to be **harness-context gaps** (the direct-include runner doesn't build `$akt`/`$kunde`; the real `index.php` / RouterSmokeTest / Phase 3.3 do), **not** 8.5 bugs — so no app-code null-guards were added; they were quarantined.
- **Phase 3**: since it's the test environment, we deployed immediately — a clean git fast-forward of the server repo to `e020fdd`, env files preserved, opcache auto-revalidating; site serves HTTP 200.

# Changes summary

## Application code (repo `git@github.com:viktarkruhlikau/kimi.git`, branch `main`; committed, pushed, and deployed to the dev server)

- **`4ea05a3` — "Apply Rector PHP 8.1-8.5 upgrade"**: 46 tracked files, 259/259 line-for-line edits, all `NullToStrictStringFuncCallArgRector` `(string)` casts on string-function args + one `ReturnNeverTypeRector` (`libs/application.php` — `throw_exception(): never`).
- **`e020fdd` — `modules/initial/subdetail.php:127`**: the only hand-written 8.5 fix.
  - Before: `if (count($subkonten) > 0) {`
  - After: `if (count($subkonten ?? []) > 0) {`

## Test infrastructure (`src-dev/…`, gitignored/untracked by design — persists on disk only)

- **`src-dev/tests/SmokeTest/Quarantine.php`** (new): 5 documented skip-lists — `ABSENT_FEATURE_MODULES` (§1, 11 modules), `LEGACY_MYSQL_SCRIPTS` (§2, 7 scripts), `DEAD_BACKUP_MODULES` (§4/§7, 3), `NON_APP_TOPLEVEL` (§7: `adminer-4.8.1.php`, `setticketcallinfo.php`, `xhangup.php`, `testpost.php`), `CONTEXT_DEPENDENT_MODULES` (`akt.php`, `subdetail.php`, `kunde_details.php`, `subuebersicht.php`).
- **`src-dev/tests/SmokeTest/BatchSmokeTest.php`**: rewrote `testBatchScriptRunsWithoutFatal` → `testBatchScriptParsesOnPhp85` using `php -l` instead of executing (stops DB mutation + PII); added `require_once Quarantine.php` + §2 skip guard. (Earlier 2.4: added `-d default_socket_timeout=1`.)
- **`src-dev/tests/SmokeTest/{Gui,Initial,Menu,Router}SmokeTest.php`**: `require_once Quarantine.php` + `markTestSkipped` guards for `ABSENT_FEATURE_MODULES`, `DEAD_BACKUP_MODULES` (Gui/Router), and `CONTEXT_DEPENDENT_MODULES` (Gui/Initial/Menu). Router matches on `$name . '.php'`.
- **`src-dev/tests/SmokeTest/TopLevelEntrySmokeTest.php`**: `require_once` + `NON_APP_TOPLEVEL` guard. (Earlier 2.4: `-d default_socket_timeout=1`.)
- **`src-dev/tests/harness/gui_runner.php`, `bootstrap.php`, `top_level_runner.php`**: seed user `admin` → **`system`** (the real admin in the imported data).
- **`src-dev/tests/harness/router_runner.php`**: added `ob_start()` at the top so bootstrap output is buffered and `index.php` can call `session_name()` (fixed the 8× RouterSmokeTest failures).
- **`src-dev/docker-compose.yml`** (2.4): `extra_hosts` mapping `validphone.validdata.eu` and `vbox6813.telematica.at` → `127.0.0.1` (hermetic outbound).
- **`src-dev-scripts/run-safety-net.sh`** (new, tracked): one-command runner for the smoke suite.

## Local docker DB (`kimidev_et` in `kimi-plus-dev-db-1`)

- Subset re-imported: 141 tables, all small tables full + 12 giant tables capped at 5,000 rows; 37 stored routines re-loaded (incl. `kimi_decrypt`/`kimi_encrypt`); 6 broken triggers dropped; `system` password = `admin123`.

## Docs / plan (tasks/07)

- `02-option1-execution-plan.md`: 2.4/2.5 re-scoped; Phase 1, Phase 2 (2.1–2.5), and Phase 3.1/3.2 marked `[x]` with results.
- `03-phase1-manual-fix-port-map.md` + `03-phase1-field-diffs.txt` (new): the 1.1 deliverable.
- `04-rector-dry-run.txt` (new): Rector dry-run output.
- `05-smoke-failures-inventory.md` (new): 82-failure triage §1–§7, all marked resolved.
- `06-found-problems-for-client.md` (new): client-facing pre-existing-issue list (missing tables + files, `mysql_*` jobs, dead backups).

## Server deploy (`/home/kimiportaldev.at/web/htdocs/kimidev_ET`)

- `git merge --ff-only origin/main`: `a9ac240` → **`e020fdd`**; gitignored `config/config.php`, `ajax/config/config.php`, `kimibatch/files/`, `log/` preserved; opcache auto-revalidates; `https://10.196.69.21/kimidev_ET/login.php` → HTTP 200.

# Context summary

Files changed this session (with the load-bearing lines):

- Application (committed to app repo):
  - `src-dev/original-src/web/htdocs/kimidev_ET/modules/initial/subdetail.php:127` — `count($subkonten ?? [])`.
  - 46 files under `src-dev/original-src/web/htdocs/kimidev_ET/` rewritten by Rector (`(string)` casts; `libs/application.php:50` `throw_exception(): never`).
- Test infra (untracked `src-dev/`):
  - `src-dev/tests/SmokeTest/Quarantine.php` (new).
  - `src-dev/tests/SmokeTest/BatchSmokeTest.php:12` (method → `php -l`), guards near top.
  - `src-dev/tests/SmokeTest/GuiSmokeTest.php`, `InitialSmokeTest.php`, `MenuSmokeTest.php`, `RouterSmokeTest.php`, `TopLevelEntrySmokeTest.php` — `require_once` + `markTestSkipped` guards.
  - `src-dev/tests/harness/gui_runner.php:32`, `bootstrap.php:46`, `top_level_runner.php:26` — `admin` → `system`.
  - `src-dev/tests/harness/router_runner.php:3` — `ob_start()`.
  - `src-dev/docker-compose.yml` — `extra_hosts`.
  - `src-dev-scripts/run-safety-net.sh` (new, tracked in wrapper repo).
- Docs (tasks/07): `02-option1-execution-plan.md`, `03-phase1-manual-fix-port-map.md`, `03-phase1-field-diffs.txt`, `04-rector-dry-run.txt`, `05-smoke-failures-inventory.md`, `06-found-problems-for-client.md`, and this log.

Other context worth noting:

- **Repo layout gotcha**: the app repo (`kimidev_ET`) is a nested git repo with its own GitHub remote, living inside the wrapper repo's **gitignored** `src-dev/`. So app-code commits go to `main` on GitHub; the whole smoke harness/tooling under `src-dev/tests` and `src-dev/tooling` is untracked by design and lives on disk only. One accidental wrapper-repo commit (`9edcac5`) that swept in 40 pre-staged files was undone with `git reset --soft HEAD~1`.
- **Auto-mode classifier** blocked a couple of read-only checks (an HTTP login POST, a decrypt query printing PII) — worked around by verifying via source/hashes instead.
- **VPN** dropped late in the session; reconnect is interactive (certificate `y` + password), so the user brought it up before the deploy.
- **Rollback (Phase 3.4)**: `git -C /home/kimiportaldev.at/web/htdocs/kimidev_ET reset --hard a9ac240` (or the 0.5 snapshot `~/web/kimidev_ET_backup_20260813`).
- **Open items**: Phase 3.3 (the user's functional testing, focused on the context-dependent ticket/customer screens), Phase 3.4 (confirm rollback), and the client-decision items in `06-found-problems-for-client.md`.
