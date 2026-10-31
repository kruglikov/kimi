# Plan — delete the 11 obsolete batch scripts and backup/variant files approved by the client

## Context (reference, not a checklist)

Franz Tausch approved the removal of two groups of files in the shared Google Doc, downloaded verbatim to `docs/16-additional-feedback-from-franz/google-doc-preexisting-issues-with-franz-answers.md`:

- **"Problem 2 — Batch scripts using a database API removed in PHP 7.0"** (7 files) — *"Answer: These batch jobs are no longer in use and can therefore be removed"*.
- **"Problem 3 — Old backup / variant copies of modules"** (4 files) — *"Answer: These backup/variant files can be deleted"*.

**Decision (26 Aug 2026):** all **11** approved files are deleted, **and** the links pointing at them are deleted with them. The alternative of keeping the six scripts that the batch menu links to was considered and rejected — keeping them would preserve six menu entries that fatal on every click, since all seven Problem-2 scripts use the `mysql_*` API removed in PHP 7.0. So `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/kimibatchtree.php` is edited in the same change (Task 3).

**Decision on the sibling backups (26 Aug 2026):** during execution we found further copies of the same dated backups that Franz did **not** name — `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/ticketsuch_sich20150208.php`, `src-dev/original-src/web/htdocs/kimidev_ET/modules/initial/ticket_sich20150208.php`, `src-dev/original-src/web/htdocs/kimidev_ET/modules/menu/ticketsuch_sich20150208.php` — plus two undated variants, `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/ticket_sich20150414.php` and `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/ticket_sich.php`. **These five files are left in place.** The approval is not extended to them and Franz is not asked about them for now; the three quarantined ones stay quarantined, the two undated variants keep passing the suite as they do today.

Scope of this plan is exactly those **11 files**, all inside the app repo working copy `src-dev/original-src/web/htdocs/kimidev_ET/`. Out of scope, deliberately: the ~33 insurance/claims module files of **"Problem 1 — Modules that query database tables which do not exist"**. Franz's answer there is *"they can be safely ignored or removed"* — "ignored" is already achieved by the smoke-test quarantine, and removing 33 files across `modules/gui/`, `modules/initial/` and `modules/menu/` touches the live portal menu, so that is a separate decision and a separate plan.

The 11 files, with the sizes measured in `src-dev/original-src/web/htdocs/kimidev_ET/`:

| # | File | Size | Group |
|---|---|---|---|
| 1 | `kimibatch/inko201604_status_offen_auf_inA_setzen.php` | 1 251 B | Problem 2 |
| 2 | `kimibatch/inkode04_status_offen_auf_inA_setzen.php` | 1 247 B | Problem 2 |
| 3 | `kimibatch/inkodeexp_new.php` | 13 447 B | Problem 2 |
| 4 | `kimibatch/oko04_status_offen_auf_inA_setzen.php` | 1 242 B | Problem 2 |
| 5 | `kimibatch/oko04_status_offen_vortage_auf_inA_setzen.php` | 1 266 B | Problem 2 |
| 6 | `kimibatch/oko_inA_outbound_elsbeth.php` | 8 044 B | Problem 2 |
| 7 | `kimibatch/okoexpzwb.php` | 8 330 B | Problem 2 |
| 8 | `modules/gui/ticket_201502071142.php` | 31 549 B | Problem 3 |
| 9 | `modules/gui/ticket_sich20150208.php` | 31 390 B | Problem 3 |
| 10 | `modules/initial/ticketsuch_sich20150208.php` | 3 370 B | Problem 3 |
| 11 | `kimibatch/inkodeimp2x.php` | 13 456 B | Problem 3 |

### What already references these files (measured, not assumed)

- **`src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/kimibatchtree.php`** — the batch menu — links **6 of the 7** Problem-2 scripts as `<li><a href="./…">` entries, at `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/kimibatchtree.php:66` (INKODE Status OFFEN auf IN BEARBEITUNG setzen), `:67` (EXPORT INKODE TEST Schnittstelle), `:101` (INKO2016 Status OFFEN auf IN BEARBEITUNG setzen), `:135` (OKO Status OFFEN ALLE auf IN BEARBEITUNG setzen), `:136` (OKO Status OFFEN VORTAGE auf IN BEARBEITUNG setzen) and `:137` (EXPORT Schnittstelle OKO-SCB ZWISCHENBERICHT). Deleting the scripts without removing these six `<li>` entries would leave dead links in the batch menu.
- **`kimibatch/oko_inA_outbound_elsbeth.php` is NOT linked from the batch menu.** Its name appears only as a display label inside an `echo` in three *other* scripts that stay: `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/oko01_daten_inA_fuer_elsbeth_import.php:11`, `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/oko01_daten_inA_fuer_elsbeth_import_telefon1.php:11` and `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/oko01_daten_inA_fuer_elsbeth_import_telefon2.php:11`. Those are `echo "<b>…</b>"` strings, **not** `include`/`require`, so deleting the file does not break the three scripts.
- **The 4 Problem-3 files have no references at all** anywhere in the application.
- **Smoke-test safety net** — `src-dev/tests/SmokeTest/Quarantine.php` names 10 of the 11: the 7 Problem-2 scripts in `Quarantine::LEGACY_MYSQL_SCRIPTS` (`src-dev/tests/SmokeTest/Quarantine.php:37-43`) and three of the Problem-3 files in `Quarantine::DEAD_BACKUP_MODULES` (`src-dev/tests/SmokeTest/Quarantine.php:48-50`). `kimibatch/inkodeimp2x.php` is not referenced by any test. In addition, `src-dev/tests/SmokeTest/InitialSmokeTest.php:50` and `src-dev/tests/SmokeTest/MenuSmokeTest.php:50` each carry a filter closure `fn(string $f): bool => basename($f) !== 'ticketsuch_sich20150208.php'` that becomes dead code once the file is gone.

### Why deletion is low-risk and reversible

Every one of the 11 files is tracked in the app repo `git@github.com:viktarkruhlikau/kimi.git`, so the deletion is one commit and the rollback is `git revert`. The deploy to the dev server is `git pull` in `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` (see `.claude/skills/kimi-connect-dev-server/SKILL.md`), which removes the files there as part of the same commit. No database object and no data is touched.

### Explicitly NOT touched

`src/original-src/web/htdocs/kimi_ET/` is the pristine client-delivered original and stays byte-for-byte as delivered — it is the reference we diff against. The deletion happens only in the app repo working copy `src-dev/original-src/web/htdocs/kimidev_ET/`.

---

## Task tracker

- [x] Task 0 — Pre-flight verification on the dev server
- [x] Task 1 — Record the smoke-test baseline before any change
- [x] Task 2 — Delete the 11 files
- [x] Task 3 — Remove the 6 dead menu entries in `kimibatchtree.php`
- [x] Task 4 — Clean up the smoke-test quarantine and the two filter closures
- [x] Task 5 — Re-run the safety net and record the new baseline
- [x] Task 6 — Commit, push and deploy to the dev server
- [ ] Task 7 — Verify on the dev server and update the memory bank (dev-server verification done; memory bank + client notification still open)

---

## Task 0 — Pre-flight verification on the dev server

- [x] Bring up the FortiClient VPN (`scripts/vpn-kimi.sh`) — reconnected by the user; `forticlient vpn status` reports `Connected`, route `10.196.69.21 dev fctvpn33541457`
- [x] Confirm all 11 files are present in `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` — **11 of 11 present**; server working copy is on commit `823fda7` ("Preserve selected Mandant/campaign across login.php reloads"), i.e. in sync with the repo
- [x] Read the crontab of `kimiportaldev.at@10.196.69.21` (`crontab -l`) and confirm **none** of the 11 file names appears there — result: **`no crontab for kimiportaldev.at`**, i.e. the user has no scheduled jobs at all. Cross-checked the system cron locations readable to this account (`/etc/crontab`, `/etc/cron.d`, `/etc/cron.daily`): no entry mentions `kimi`. Coverage limit: `/var/spool/cron/crontabs` is not listable by this unprivileged account, so crontabs belonging to *other* users were not inspected
- [x] Check the web server logs for any request to the 11 URLs in the retained log window — searched the current `/home/kimiportaldev.at/web/logs/2281845-0402-nginx-access.log` plus all 31 rotated `.gz` files (roughly the last 32 days): **0 hits for every one of the 11 file names**

**Exit:** met — all 11 files present on the server, no crontab entry and no web request in ~32 days references any of them.

## Task 1 — Record the smoke-test baseline before any change

- [x] Run the safety net (`src-dev-scripts/run-safety-net.sh`) on the unmodified working copy — exit code 0
- [x] Write down the exact totals (tests / failures / skipped) as the "before" number to compare against — **BEFORE: `Tests: 214, Assertions: 292, Skipped: 72`, 0 failures** (26 Aug 2026)

**Exit:** met — the recorded "before" line matches the known green baseline of 214 tests / 0 failures / 72 skipped.

## Task 2 — Delete the 11 files

- [x] `git rm` the 7 Problem-2 batch scripts under `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/`
- [x] `git rm` the 4 Problem-3 files: `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/ticket_201502071142.php`, `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/ticket_sich20150208.php`, `src-dev/original-src/web/htdocs/kimidev_ET/modules/initial/ticketsuch_sich20150208.php`, `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/inkodeimp2x.php`
- [x] Confirm `git status` lists exactly 11 deletions and nothing else — `git status --porcelain | grep -c "^D "` returns **11**

**Exit:** met — exactly 11 files staged as deleted, `src/original-src/` untouched.

## Task 3 — Remove the 6 dead menu entries in `kimibatchtree.php`

- [x] Delete the six `<li><a href="./…">` lines in `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/kimibatchtree.php` that point at the deleted scripts (`:66`, `:67`, `:101`, `:135`, `:136`, `:137` in the pre-change file)
- [x] Re-count the `<li><a href=` entries in `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/kimibatchtree.php`: 69 before, **63 after** — as predicted
- [x] `php -l` on `src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/kimibatchtree.php` — "No syntax errors detected"
- [x] Load the batch menu in the local docker stack (`http://localhost:8082/kimidev_ET/kimibatch/kimibatchtree.php`) — **HTTP 200**, 13 409 bytes, 63 links rendered, 0 occurrences of "Fatal error"/"Parse error", 0 occurrences of any deleted script name

**Exit:** met — the batch menu renders and contains no link to a deleted file.

## Task 4 — Clean up the smoke-test quarantine and the two filter closures

> **Correction applied during execution.** The plan as written would have emptied `Quarantine::DEAD_BACKUP_MODULES` and removed both filter closures. That is wrong: **further copies of the same dated backups survive in the other module sets** — `src-dev/original-src/web/htdocs/kimidev_ET/modules/gui/ticketsuch_sich20150208.php`, `src-dev/original-src/web/htdocs/kimidev_ET/modules/initial/ticket_sich20150208.php` and `src-dev/original-src/web/htdocs/kimidev_ET/modules/menu/ticketsuch_sich20150208.php` were **not** in the client-approved list and still exist. Because the smoke runners match by basename, emptying the constant or dropping `MenuSmokeTest`'s filter would have un-quarantined those surviving copies and turned the suite red. Only the entries whose every copy is gone were removed.

- [x] Remove the whole `Quarantine::LEGACY_MYSQL_SCRIPTS` constant from `src-dev/tests/SmokeTest/Quarantine.php` (all 7 entries are gone) and its only use — the skip block plus the now-unneeded `require_once __DIR__ . '/Quarantine.php';` in `src-dev/tests/SmokeTest/BatchSmokeTest.php`
- [x] From `Quarantine::DEAD_BACKUP_MODULES` remove **only** `'ticket_201502071142.php'` (no copy of that basename survives); **keep** `'ticket_sich20150208.php'` and `'ticketsuch_sich20150208.php'` because surviving copies still need quarantining. The uses in `src-dev/tests/SmokeTest/GuiSmokeTest.php:26` and `src-dev/tests/SmokeTest/RouterSmokeTest.php:26` therefore stay
- [x] Remove the now-dead filter closure `fn(string $f): bool => basename($f) !== 'ticketsuch_sich20150208.php'` from `src-dev/tests/SmokeTest/InitialSmokeTest.php` — `modules/initial/ticketsuch_sich20150208.php` is deleted, so the filter matched nothing. **Kept** in `src-dev/tests/SmokeTest/MenuSmokeTest.php`, because `modules/menu/ticketsuch_sich20150208.php` still exists
- [x] Update the docblock in `src-dev/tests/SmokeTest/Quarantine.php` so it records which copies were deleted and why the two basenames remain quarantined
- [x] `php -l` clean on all six touched test files

**Exit:** met — no test file names a deleted file, and every remaining quarantine entry corresponds to a file that still exists.

## Task 5 — Re-run the safety net and record the new baseline

- [x] Run `src-dev-scripts/run-safety-net.sh` again — exit code 0
- [x] Confirm **0 failures** — no FAILURES/ERRORS block in the output
- [x] Confirm the drop in totals is exactly explained by the removed files — see the reconciliation below; every unit of every delta is attributed
- [x] Record the new baseline (tests / failures / skipped) in this plan

**BEFORE:** `Tests: 214, Assertions: 292, Skipped: 72` — **AFTER:** `Tests: 202, Assertions: 291, Skipped: 61`. Deltas: tests −12, assertions −1, skipped −11.

Reconciliation of the −12 tests:

| Suite | Entrypoints that disappeared | Tests |
|---|---|---|
| `BatchSmokeTest` | the 7 Problem-2 scripts + `kimibatch/inkodeimp2x.php` | −8 |
| `GuiSmokeTest` | `modules/gui/ticket_201502071142.php`, `modules/gui/ticket_sich20150208.php` | −2 |
| `RouterSmokeTest` | the same two basenames as routes | −2 |
| `InitialSmokeTest` | `modules/initial/ticketsuch_sich20150208.php` was already excluded from the provider by the filter closure, so deleting the file and the filter together nets out | 0 |
| | **total** | **−12** |

Reconciliation of the −11 skipped: 7 of the 8 removed batch tests were skipped (`LEGACY_MYSQL_SCRIPTS`), the 8th — `kimibatch/inkodeimp2x.php` — actually ran; plus 2 skipped in `GuiSmokeTest` and 2 in `RouterSmokeTest` for the two deleted gui backups. 7 + 2 + 2 = 11.

Reconciliation of the −1 assertion: `kimibatch/inkodeimp2x.php` was the only deleted entrypoint that executed rather than being skipped, and its test carried a single `assertSame(0, $code)` from the `php -l` check.

**Exit:** met — green suite, and every changed number accounted for.

## Task 6 — Commit, push and deploy to the dev server

- [x] Commit to the app repo with a message naming the client decision and the two Google-Doc problems it implements (no AI attribution) — commit **`6f7a8d0`** "Remove obsolete batch scripts and dated backup module copies", 12 files changed, 2 793 deletions, 0 insertions
- [x] Get explicit approval from the user before pushing — approval given 26 Aug 2026 ("please commit and deploy to dev")
- [x] Push to `origin/main` — `823fda7..6f7a8d0`
- [x] `git pull` in `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` on the dev server, with `GIT_SSH_COMMAND` set as documented in `.claude/skills/kimi-connect-dev-server/SKILL.md`
- [x] Confirm the server working copy moved to the new commit and that the 11 files are gone there — server `HEAD` is now `6f7a8d0`, working tree clean, **gone=11 present=0**
- [x] Commit the smoke-test cleanup in the wrapper repo — commit **`425dff7`** "Drop smoke-test quarantine entries for the removed batch and backup files" (5 files under `src-dev/tests/SmokeTest/`; also carries the previously uncommitted `CONTEXT_DEPENDENT_MODULES` skip blocks in `src-dev/tests/SmokeTest/GuiSmokeTest.php` and `src-dev/tests/SmokeTest/MenuSmokeTest.php`, which belong to the same safety net)

**Exit:** met — dev server on `6f7a8d0`, 0 of the 11 files present.

## Task 7 — Verify on the dev server and update the memory bank

- [x] Open `https://10.196.69.21/kimidev_ET/kimibatch/kimibatchtree.php` and confirm the batch menu renders without the six removed entries — **HTTP 200**, 13 409 bytes, 63 links, 0 fatal/parse errors, 0 mentions of any deleted script
- [x] Confirm the three retained scripts `oko01_daten_inA_fuer_elsbeth_import.php`, `oko01_daten_inA_fuer_elsbeth_import_telefon1.php` and `oko01_daten_inA_fuer_elsbeth_import_telefon2.php` still load (they only echo the deleted file's name as a label) — verified with `php -l` **on the server**, all three "No syntax errors detected". Deliberately not executed over HTTP: these are export jobs that write files and mutate the database
- [x] Update the memory bank with the new baseline and the fact that these 11 files no longer exist — created `memory-bank/smoke-tests-src-dev.md` (there was no memory-bank file covering the `src-dev/` safety net at all; the 202/0/61 baseline and the quarantine rationale live there now), added a "Client-approved removals (2026-08, `src-dev/` only)" section to `memory-bank/batch-processing-subsystem.md`, and listed the new file plus the amended description in `memory-bank/index.md`
- [ ] Tell Franz the removal is done, referencing his two approvals

**Exit:** dev server verified, memory bank reflects the new baseline, client informed.

---

## Rollback

`git revert <commit>` in the app repo, then `git pull` on the dev server. Nothing else is required — no database object, schema or data is touched anywhere in this plan.
