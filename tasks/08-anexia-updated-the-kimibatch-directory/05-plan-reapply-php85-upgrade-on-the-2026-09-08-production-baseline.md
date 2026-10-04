# Plan — re-apply the PHP 8.5 upgrade on the 2026-09-08 production baseline

Created 2026-10-03. This is the execution plan for the second half of Path B, decided and recorded as $9 **Decide Path A, Path B or Path C** in `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/04-git-status-verification-and-way-forward-2026-10-03.md`. It supersedes the open items $12 to $18 of that document, which are marked `[SUPERSEDED]` there and carried forward here with their evidence intact.

**Goal:** working, tested, PHP 8.5-upgraded **current production** code running on the ANEXIA dev server `kimiportaldev.at@10.196.69.21`, ready for Franz Tausch's test round.

**Numbering:** item ids continue from the 2026-10-03 document rather than restarting at `$1`, so that no id means two different things inside the task folder `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/`.

**Verification principle, set by the user on 2026-10-03:** check everything one extra time rather than skip a test. Every actionable item below therefore carries a `Verify:` part stating what must be observed before the item may be marked `[DONE]`, and no item is marked `[DONE]` on the strength of a command having been run — only on the strength of its verification having been observed.

## Relationship to the August plan

The method comes from `/home/viktar/Projects/kimi-plus.at/tasks/07-implement-deployment-to-dev/02-option1-execution-plan.md`, which took the dev tree from PHP 8.0 to PHP 8.5 in August 2026. Its Phase 0 built permanent infrastructure that is still in place and is not rebuilt here: the application repository `git@github.com:viktarkruhlikau/kimi.git` with working copies on the dev server and locally (0.1, 0.2, 0.3), and the PHP 8.5 Docker stack plus Rector tooling under `/home/viktar/Projects/kimi-plus.at/src-dev/` (0.7). Its Phases 1 to 3 are repeated here against the new baseline. Its Phases 4 and 5 were never started and are carried forward.

**What is different about this round, and why a literal replay would miss it.** In August, Rector ran over a tree we already knew: 46 files changed out of 436. This time the tree contains **80 PHP files that have never been through the PHP 8.5 pass at all** — 65 of them in `kimibatch/`, 13 in `modules/`, 2 at the docroot root — and the smoke-test harness has never discovered them either. The measurement is recorded as $27 **The PHP 8.5 upgrade has to run again over the whole tree, because 80 delivered PHP files have never been through it** in the 2026-10-03 document.

---

## Phase 0 — Safety net and starting position

- [DONE] $30 **The code backup of the dev server is current and verified**
  - Evidence: `/home/kimiportaldev.at/web/kimidev_ET_backup_20261001/` was verified on 2026-10-03 as a complete copy of the live document root — 3 612 of 3 612 entries, 3 394 files byte-identical by `md5sum`, identical owner, group and permission bits throughout.
  - Reference: supersedes step 0.5 of `/home/viktar/Projects/kimi-plus.at/tasks/07-implement-deployment-to-dev/02-option1-execution-plan.md`. The older `/home/kimiportaldev.at/web/kimidev_ET_backup_20260813/` is kept as the pre-upgrade reference, and `/home/kimiportaldev.at/web/kimidev_ET_backup_20260909/` is incomplete and must never be used as a restore source.

- [IN_PROGRESS] $31 **Take a fresh database dump before any code is deployed**
  - Blocked by: the VPN tunnel to the ANEXIA network dropped during the 2026-10-03 run and cannot be restored unattended; see $D4 **The VPN dropped early in the run and cannot be restored without the user, so all dev-server work is deferred** in `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/06-autonomous-run-log-2026-10-03.md`. The dump command and its verification are ready to run the moment the tunnel is back.
  - Problem: the newest dump, `/home/viktar/Projects/kimi-plus.at/src-dev-db-dumps/kimidev_et_20260812_1631.sql.gz` (2.7 GB), predates Franz Tausch's test runs of 2026-08-23, which wrote ticket rows into `kimidev_et`, so a rollback to it would lose that data.
  - Plan: dump `kimidev_et` on the dev server with routines and triggers included, compress it, and store it outside the document root; the `*.sql.gz` ignore rule keeps it out of git.
  - Verify: the dump restores into a scratch database in the local Docker stack without error, and `SELECT COUNT(*)` on `ticket`, `oko` and `benutzer` in the restored copy matches the counts taken on the dev server at dump time.

- [DONE] $32 **The rollback targets are known and reachable**
  - Evidence: the branch `main` of `git@github.com:viktarkruhlikau/kimi.git` now holds `a9ac240` (pre-upgrade dev baseline), `e020fdd` (the August PHP 8.5 state), `6f7a8d0` (the August deployed state), `0a71298` (the production delivery recorded verbatim), `e3c4f94` (dev-era pollution removed) and `7fb5ae0` (configuration repaired and tracked). Rolling the dev server back to any of them is `git reset --hard <commit>` in `/home/kimiportaldev.at/web/htdocs/kimidev_ET/`.
  - Verify: before Phase 4 begins, confirm `git status` on the dev server is clean, so that a reset cannot destroy uncommitted work.

- [DONE] $33 **The dev database already contains every column the new production code needs — no migration is required**
  - Verdict: confirmed on 2026-10-03, which settles the one open doubt about the August assumption "this upgrade is code-only".
  - Evidence: `oko` has `telnr1` through `telnr10`, with `telnr5` to `telnr10` present as `varchar(45)` exactly as requested in `/home/viktar/Projects/kimi-plus.at/docs/10-franz-email-2026-06-16/franz-email-2026-06-16.md:38-45`; `ticket` has `dummy_text11` through `dummy_text19` as `varchar(250)`, which is what `kimibatch/okoimp.php` writes into. The tables were created on 2026-07-15 (`oko` ~69 875 rows, `ticket` ~618 868 rows, `benutzer` 14 rows), matching the production-to-test import performed in July 2026.
  - Reference: supersedes step 1.2 of `/home/viktar/Projects/kimi-plus.at/tasks/07-implement-deployment-to-dev/02-option1-execution-plan.md`.

- [DONE] $34 **A working portal login exists for testing**
  - Evidence: `system` / `admin123` was verified in a visible browser on 2026-10-03 at `https://10.196.69.21/kimidev_ET/login.php` — the login succeeded, the Mandant selection offered `KIMI-Vertrieb`, the portal opened on `index.php?site=ticketsuch&kId=8` and a Ticketsuche query ran without error.
  - Reference: the account is `benutzer.id=1`, `name='system'`, hash `sha256('kimiplus' + password)` per `src-dev/original-src/web/htdocs/kimidev_ET/libs/entities/user.php:205`; reset script `/home/viktar/Projects/kimi-plus.at/scripts/set-kimidev-server-admin-password.sh`.

- [DONE] $35 **Confirm the local Docker stack boots and serves the new baseline before any upgrade work starts**
  - Decision (2026-10-03): verified green before any upgrade change. The stack `kimi-plus-dev` builds and starts (`db` healthy, `web` running), the container runs **PHP 8.5.11**, `http://localhost:8082/kimidev_ET/login.php` returns HTTP 200 and renders `LOGIN (kimidev_et)`, and a login as `system` through `index.php?ajax=true&site=check-login` returns HTTP 200 with the follow-up page rendering `MANDANTENAUSWAHL`. The local database holds the August subset — `ticket` 5 506 rows, `oko` 5 000, `benutzer` 14 — and its `oko` table already carries `telnr5` through `telnr10`, matching the dev server.
  - Evidence — one pre-existing warning recorded as the "before" state: `Warning: Undefined array key "mandant" in /var/www/html/kimidev_ET/index.php on line 41` appears on the login round-trip. It comes from the delivered production code, not from the upgrade, and is a candidate for $44 **Fix the PHP 8.5 problems the smoke suite reveals, test-driven**.
  - Problem: the local mirror grew from 436 to 3 163 tracked files, and the stack has not been started against that content; starting the upgrade on a stack that cannot serve the code would make every later failure ambiguous.
  - Plan: bring up `/home/viktar/Projects/kimi-plus.at/src-dev/docker-compose.yml` and load the portal locally.
  - Verify: the local portal returns the login page, a login as `system` succeeds against the local Docker database, and the PHP error log shows no fatal errors on startup. Record the result, because this is the "before" state the upgrade will be measured against.

---

## Phase 1 — Measure the delta on the new baseline

- [DONE] $36 **The size and shape of the upgrade work is measured**
  - Evidence: of the 46 files that the August Rector commit `4ea05a3` touched, only **10** differ between the pre-upgrade baseline `a9ac240` and the delivery `0a71298`, by 143 insertions and 23 deletions in total; the other 36 are byte-identical, so Rector will reproduce the same output for them. The delivery added **80 PHP files** never processed by the upgrade.
  - Reference: $27 **The PHP 8.5 upgrade has to run again over the whole tree, because 80 delivered PHP files have never been through it** in `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/04-git-status-verification-and-way-forward-2026-10-03.md`.

- [DONE] $37 **Audit the Rector configuration against the new tree before running it**
  - Decision (2026-10-03): the audit found one real gap and it is fixed. `/home/viktar/Projects/kimi-plus.at/src-dev/tooling/php-upgrade/rector.php` targets the whole directory `original-src/web/htdocs/kimidev_ET`, so the 80 newly delivered files are in scope automatically — but its skip list named only `kimibatch/vendor`, while the delivery added a **second** vendored PHPMailer copy at `kimibatch/files/vendor` holding 68 third-party PHP files that nothing excluded. That path is now skipped as well, because third-party code must never be rewritten and, per $24 **`kimibatch/vendor/` is required by 133 batch scripts and must NOT be deleted, yet ANEXIA's copy did not deliver it**, the application does not even load from it.
  - Evidence — the inventory reconciles: the tree holds **475** `.php` files; the skips now cover **141** of them (`adminer-4.8.1.php` 1, `kimibatch/vendor` 68, `libs/addons/phpmail` 4, `kimibatch/files/vendor` 68), leaving **334** files in scope. The four campaign scripts under `kimibatch/files/16/Scripts/` and `kimibatch/files/27/Scripts/` stay in scope deliberately — they are application code the batch system runs, and `kimibatch/files/27/Scripts/okoexp.php` was already upgraded in the August run.
  - Problem: `/home/viktar/Projects/kimi-plus.at/src-dev/tooling/php-upgrade/rector.php` was written for the August tree; its include and skip paths may not cover the 80 newly delivered files, and a path that silently falls outside the configured scope would leave those files un-upgraded without any error.
  - Plan: read the Rector configuration, list the paths it includes and skips, and compare that against the current file inventory of `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/`.
  - Verify: every `.php` file in the tree is either inside a configured path or inside an explicitly justified skip path, and the count of files Rector will consider is stated explicitly and matches the tree inventory. Do not proceed to $38 **Run the Rector dry-run and review every proposed change** until the numbers agree.

---

## Phase 2 — Produce the upgraded artifact

- [DONE] $38 **Run the Rector dry-run and review every proposed change**
  - Decision (2026-10-04): dry-run clean and approved. Output saved to `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/07-rector-dry-run-20261004.txt` (2 593 lines). **52 files would change**, and only two rules fire — `NullToStrictStringFuncCallArgRector` (51 files) and `ReturnNeverTypeRector` (1) — exactly the two the August commit `4ea05a3` used, so no unreviewed new rule is being introduced across the tree.
  - Evidence — the file set reconciles exactly against August, 46 − 1 + 7 = 52: **minus** `kimibatch/inkodeimp2_test.php`, deleted as a dev-era leftover in commit `e3c4f94`; **plus** seven files never upgraded before — `kimibatch/coeoch01_import_telefonie_taeglich.php`, `kimibatch/coeodrei01_import_telefonie_taeglich.php`, `kimibatch/okoexp_ansi.php`, `kimibatch/okoexp_ansi2.php`, `kimibatch/okoexp_ansi-roni.php`, `kimibatch/okoexp_dev.php` and `kimibatch/files/27/Scripts/okoexp.php`, the last of which August did process but could not commit because `kimibatch/files/` was gitignored at the time.
  - Evidence — one blocker had to be cleared first: the run initially aborted because `kimibatch/coeochdeexptest.php` does not parse. That is a pre-existing production defect, repaired as recorded in $D5 **A delivered production file did not parse at all, and I repaired it rather than skipping it** in `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/06-autonomous-run-log-2026-10-03.md`.
  - Plan: run Rector in dry-run mode in the PHP 8.5 Docker container against `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/`, and save the output beside the August one at `/home/viktar/Projects/kimi-plus.at/tasks/07-implement-deployment-to-dev/04-rector-dry-run.txt` as a new file in the task-08 folder.
  - Verify: the output is read in full, not skimmed. For each rule that fires, confirm it is one of the rules the August run used (`NullToStrictStringFuncCallArgRector`, `ReturnNeverTypeRector`) or is explicitly accepted; any new rule firing on this tree must be understood and approved before $39 **Apply the Rector changes and commit them as their own commit**, because an unreviewed automated edit across 3 163 files is exactly the kind of change that is impossible to audit afterwards.

- [DONE] $39 **Apply the Rector changes and commit them as their own commit**
  - Decision (2026-10-04): applied and committed locally as two separate commits, so the automated change stays separable from the hand edit — `2a55616` "Repair the unparseable SQL alias quoting in coeochdeexptest.php" (4 insertions, 4 deletions) and `16e4279` "Apply the Rector PHP 8.1-8.5 upgrade to the 2026-09-08 production baseline" (**52 files, 0 additions**). Neither is pushed yet; pushing waits for the dev-server work.
  - Verify — all three conditions met: the applied file count matches the dry-run exactly (Rector reported "52 files have been changed", and `git diff --stat` showed 53 including the separate syntax fix, 291 insertions against 291 deletions, the line-for-line signature of pure in-place casts); a spot check of five files — `libs/init.php`, `kimibatch/okoexp_dev.php`, `modules/subkonto.php`, `setticketcallinfo.php` and `ajax/callInntelco.php` — showed only the expected `(string)` casts on string-function arguments; and `php -l` under PHP 8.5 passed on **all 53 changed files with 0 failures**.
  - Reference: the first attempt at this commit wrongly included 439 local test artifacts and was corrected before any push, as recorded in $D6 **I committed the 439 local test artifacts by mistake and corrected it before anything was pushed**.
  - Plan: apply Rector, then commit the result alone, with no hand edits mixed in, so the automated change stays separable in history exactly as `4ea05a3` was.
  - Verify: `git diff --stat` matches the dry-run's file and line counts exactly; a spot check of at least five changed files confirms the edits are the expected `(string)` casts; and `php -l` passes on every changed file.

- [DONE] $40 **Re-apply the session-reset fix that the delivery reverted**
  - Decision (2026-10-04): re-applied to `login.php` (the `session_unset()` block and the dead single-Mandant redirect removed) and to `index.php` (the campaign and remembered Ticketsuche filter cleared only when the Mandant actually changes) — 14 insertions, 11 deletions across `index.php`, `libs/init.php` and `login.php`.
  - Verify — both halves proven behaviourally against the local stack, not merely by reading the code: setting `kId=8` renders `Ticketsuche (OKO)`; reloading `login.php` returns HTTP 200; returning to Ticketsuche **without** `kId` still renders `Ticketsuche (OKO)`, which is the regression Franz Tausch reported — before the fix the reload wiped `kampId`; and switching to Mandant 2 returns HTTP 302 to `site=kampauswahl`, proving the campaign is cleared exactly when the Mandant changes. A separate check confirmed the Mandant itself survives a `login.php` reload: `index.php` answered 200 instead of bouncing to the login page with 302.
  - Evidence — a second, unplanned correction was needed: the delivery had also overwritten the session name with production values, leaving the tree inconsistent at `login.php:5` and `index.php:6` (`kimiET-P`) against `libs/init.php:106` (`kimi_ET-P`, with an underscore). Because `libs/init.php` is included first and calls `session_start()` itself, its value was the effective one, so the dev server was running under the production cookie name. All three now declare `session_name('kimiET-A')`, the documented dev value.
  - Problem: the delivery restored `session_unset()` in `login.php`, undoing commit `823fda7` "Preserve selected Mandant/campaign across login.php reloads", so Franz Tausch's Firefox campaign-selection problem must be expected to reappear.
  - Plan: re-apply the change to `src-dev/original-src/web/htdocs/kimidev_ET/login.php` and `src-dev/original-src/web/htdocs/kimidev_ET/index.php`, guided by the analysis in `/home/viktar/Projects/kimi-plus.at/tasks/07-implement-deployment-to-dev/12-session-reset-fix-analysis-and-plan.md`. The original commit touched 2 files with 11 insertions and 8 deletions.
  - Verify: in a browser, select a Mandant, reload the page, and confirm the selected Mandant and campaign survive the reload — the actual user-visible symptom, not merely the absence of the `session_unset()` call.
  - Reference: carried forward from $13 **Re-apply the session-reset fix of commit `823fda7`**.

- [DONE] $41 **Re-apply the client-approved deletions that the delivery undid**
  - Decision (2026-10-04): all 11 files deleted again and six menu entries removed from `kimibatch/kimibatchtree.php` — the same six that commit `6f7a8d0` removed in August — leaving 177 entries where there were 183.
  - Verify — the approval was re-confirmed against the delivered content, not assumed: every one of the 11 delivered files is **byte-identical** to the version `6f7a8d0` deleted, and the seven batch scripts still call the `mysql_*` API removed in PHP 7.0 (1 to 3 calls each), so they remain non-functional. Franz Tausch's recorded answers cover them verbatim — *"These batch jobs are no longer in use and can therefore be removed"* and *"These backup/variant files can be deleted"* in `/home/viktar/Projects/kimi-plus.at/docs/16-additional-feedback-from-franz/google-doc-preexisting-issues-with-franz-answers.md`.
  - Verify — the menu audit passed: resolving every `href` in `kimibatch/kimibatchtree.php` against the directory listing leaves no link to any file this work removed, and the file still parses under PHP 8.5.
  - Evidence — two dead links remain and were deliberately not touched: `coeoch02_tagl_daten_fuer_elsbeth_import_alle.php` and `inko2016exp_new.php` are linked by the delivered production menu but exist nowhere in the tree, so they are dead on production as well. See $D7 **Two dead links in the delivered batch menu were left in place, because removing them exceeds what the client approved**.
  - Problem: commit `6f7a8d0` removed 7 batch scripts using the `mysql_*` API removed in PHP 7.0, plus dated backup and variant files, all approved by Franz Tausch; the delivery brought them back.
  - Plan: re-delete them and remove the matching menu entries from `kimibatch/kimibatchtree.php`, as the original commit did (12 files, 2 793 deletions).
  - Verify: before deleting, re-confirm each file against Franz Tausch's recorded answers in `/home/viktar/Projects/kimi-plus.at/docs/16-additional-feedback-from-franz/google-doc-preexisting-issues-with-franz-answers.md`, because the delivered tree may contain newer variants with the same names; after deleting, confirm `kimibatch/kimibatchtree.php` contains no link to a file that no longer exists, by resolving every `href` in it against the directory listing.
  - Reference: carried forward from $14 **Re-apply the client-approved deletions of commit `6f7a8d0`**.

- [DONE] $42 **Remove the three HTTP-reachable administration and diagnostic files**
  - Decision (2026-10-04): `adminer-4.8.1.php`, `kimibatch/phpinfo.php` and `kimibatch/kimiphpinfo.php` removed from the tree.
  - Verify — measured before and after against the local stack rather than assumed: all three answered **HTTP 200** beforehand, confirming a full database administration tool and two PHP-configuration pages really were reachable over the web, and all three answer **HTTP 404** afterwards.
  - Plan: delete `adminer-4.8.1.php`, `kimibatch/phpinfo.php` and `kimibatch/kimiphpinfo.php` from the tree.
  - Verify: after deployment, request each of the three paths over HTTPS on the dev server and confirm each returns 404.
  - Reference: carried forward from $15 **Remove the three HTTP-reachable administration and diagnostic files from the dev docroot**, with evidence in $7 **Three security-relevant files now sit in the dev docroot and are reachable over HTTP**.

- [DONE] $43 **Extend the smoke-test harness to discover the 80 newly delivered files**
  - Problem found — the gap was real and larger than expected: the suite discovers subjects with directory globs (`kimibatch/*.php`, `modules/gui/*.php`, `ajax/*.php`, `modules/initial/*.php`, `modules/menu/*.php`, the docroot top level), which do pick up the 65 new `kimibatch/` files automatically, but reach **only 229 of the 321** application PHP files. The 92 invisible ones include all of `modules/gui/templates/tickets/`, and therefore the four template directories the delivery added, which no test would ever have touched.
  - Decision (2026-10-04): rather than add one glob per missing directory — which would leave the same trap for the next delivery — added `/home/viktar/Projects/kimi-plus.at/src-dev/tests/SmokeTest/ParseSmokeTest.php`, which walks the tree recursively and asserts `php -l` on every application file. Discovery is now complete by construction; only third-party paths are excluded (`kimibatch/vendor/`, `kimibatch/files/vendor/`, `libs/addons/phpmail/`).
  - Verify — the count reconciles exactly: the new test runs **321 tests, 321 assertions, 0 failures**, matching the 321 application PHP files counted in the tree, so no file is unexercised and none is quarantined without a reason.
  - Reference: a by-product of the full sweep was finding a fourth web-reachable PHP-info page, removed as recorded in $D8 **A fourth PHP-info page was found and removed, although it predates the delivery**.
  - Problem: the harness under `/home/viktar/Projects/kimi-plus.at/src-dev/tests/` discovers files by glob, and the quarantine lists in `src-dev/tests/SmokeTest/Quarantine.php` name files by path. Both were written for the August tree, so the new files may be silently invisible to the suite — which would produce a green run that proves nothing about them.
  - Plan: audit the discovery globs against the current inventory, then reconcile the five quarantine lists (`ABSENT_FEATURE_MODULES`, `LEGACY_MYSQL_SCRIPTS`, `DEAD_BACKUP_MODULES`, `NON_APP_TOPLEVEL`, `CONTEXT_DEPENDENT_MODULES`) with the files that now exist.
  - Verify: print the list of files the suite actually exercises and diff it against the tree inventory; every `.php` file must be either exercised or quarantined with a written reason. A file that is neither is a hole in the safety net and blocks $45 **Run the full smoke suite and record the new green baseline**.

- [DONE] $44 **Fix the PHP 8.5 problems the smoke suite reveals, test-driven**
  - Verdict: the suite revealed **no PHP 8.5 defect at all**. Its single failure was stale test data of our own making, and it was classified before anything was changed, exactly as this item requires.
  - Evidence: `Top level entry loads without fatal with data set #7` failed with `phpinfo.php: non-zero exit` and `top_level_runner: expected <path> <scenario>`. The cause is that `entryProvider()` in `/home/viktar/Projects/kimi-plus.at/src-dev/tests/SmokeTest/TopLevelEntrySmokeTest.php` is a **hardcoded** list, not a glob, and it still named `phpinfo.php` and `adminer-4.8.1.php` after $42 **Remove the three HTTP-reachable administration and diagnostic files** and $D8 **A fourth PHP-info page was found and removed, although it predates the delivery** deleted them. The application code was never at fault.
  - Decision (2026-10-04): removed both rows from the provider and dropped `adminer-4.8.1.php` from `Quarantine::NON_APP_TOPLEVEL`, since quarantining a file that no longer exists is misleading. No application code was touched — matching the August finding that apparent failures are usually harness gaps rather than 8.5 bugs.
  - Plan: let the suite drive the fixes on the dev tree, using `/home/viktar/Projects/kimi-plus.at/src/upgraded-src/` only as a reference, exactly as the August round did. In August the only genuine hand-written fix was one line, `modules/initial/subdetail.php:127`.
  - Verify: each fix is justified in writing as a real PHP 8.5 incompatibility rather than a harness gap — the August round found that four apparent failures were harness-context gaps and correctly added no null guards for them. Record the classification of every failure before changing any application code.

---

## Phase 3 — Verify locally, before touching the dev server

- [DONE] $45 **Run the full smoke suite and record the new green baseline**
  - Decision (2026-10-04): the new green baseline for `src-dev` is **580 tests, 667 assertions, 0 failures, 60 skipped**, against the August baseline of 202 tests / 0 failures / 61 skipped recorded in `/home/viktar/Projects/kimi-plus.at/memory-bank/smoke-tests-src-dev.md`. The growth comes from two sources: the 321 cases of the new `ParseSmokeTest`, and the 65 batch scripts the delivery added, which the existing `kimibatch/*.php` glob picks up automatically.
  - Verify: every skip is accounted for by the documented quarantine lists in `/home/viktar/Projects/kimi-plus.at/src-dev/tests/SmokeTest/Quarantine.php` — context-dependent modules that the direct-include runners cannot build an `$akt`/`$kunde` context for, absent-feature modules, dead backup modules, and the non-app top-level endpoints. No file is unexercised: $43 **Extend the smoke-test harness to discover the 80 newly delivered files** proves all 321 application files are reached.
  - Plan: run the suite via `/home/viktar/Projects/kimi-plus.at/src-dev-scripts/run-safety-net.sh` in the PHP 8.5 Docker stack.
  - Verify: 0 failures. The pass and skip counts will differ from the August baseline of 202 tests / 0 failures / 61 skipped recorded in `/home/viktar/Projects/kimi-plus.at/memory-bank/smoke-tests-src-dev.md`, because the tree has grown; the new figures are recorded as the new baseline, and every skip is accounted for by $43 **Extend the smoke-test harness to discover the 80 newly delivered files**.
  - Reference: carried forward from $16 **Run the smoke-test suite against the new baseline and record the new green figure**.

- [DONE] $46 **Run `php -l` across the entire tree as an independent second check**
  - Decision (2026-10-04): run with shell tooling inside the PHP 8.5 container rather than through PHPUnit, so the result does not depend on the same discovery code it is meant to double-check. Result: **320 files checked, 0 parse errors**.
  - Verify — the count is stated and reconciles: `ParseSmokeTest` reported 321 cases, and the difference of one is `phpinfo.php`, deleted after that run. The 140 third-party files excluded by design are `kimibatch/vendor/` (68), `kimibatch/files/vendor/` (68) and `libs/addons/phpmail/` (4).
  - Problem: the smoke suite proves that what it exercises loads; a parse check proves that every file in the tree is syntactically valid under PHP 8.5, including files the suite quarantines.
  - Plan: run `php -l` in the PHP 8.5 container over every `.php` file in `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/`, including `kimibatch/files/`.
  - Verify: zero parse errors, and the number of files checked equals the number of `.php` files in the tree — a count that must be stated, not assumed.

- [DONE] $47 **Exercise the upgraded code in a browser against the local Docker stack**
  - Decision (2026-10-04): exercised in a visible Chrome against `http://localhost:8082/kimidev_ET/` — login as `system`, client selection, the portal home, the Ticketsuche mask for the OKO campaign showing 20 tickets across 15 pages with real customer data, a ticket detail screen, and the batch menu `kimibatch/kimibatchtree.php`. Every screen rendered.
  - Verify — this found two defects the automated suite could not, because neither is fatal: the search mask printed a **PHP warning into the value attribute of the Gläubiger input**, and opening a ticket read one element past the end of the ticket list. Both are fixed in commit `e15b62b`, and a sweep of the five main screens now reports **zero** rendered warnings, notices, deprecations or fatal errors, where `index.php` previously also emitted `Undefined array key "mandant"`.
  - Evidence — defect 1: `modules/gui/templates/tickets/8/ticketsuch.php:57` echoes `$dummy_text3`, but `modules/initial/ticketsuch.php:48-70` defines every other search field with `param(...)` and simply omitted that one. Added `$dummy_text3 = param("dummy_text3", "");` in the same pattern; the field now renders `value=""`.
  - Evidence — defect 2: `modules/initial/ticket.php:140` guarded with `$selected_ticket_index != $max_ticket`, but `$max_ticket` is a **count**, so the last valid index is `$max_ticket - 1`. The guard read one past the end both on the last ticket of a result set and when `selected_tickets` is absent, where `explode(',', "")` returns a single empty element. Reproduced deterministically, fixed to `$selected_ticket_index + 1 < $max_ticket`, and re-verified in three scenarios — no `selected_tickets`, mid-result-set, and last ticket of a set — all clean.
  - Verify — no regression: the full smoke suite re-run after both fixes is unchanged at **580 tests, 667 assertions, 0 failures, 60 skipped**.
  - Plan: log in locally as `system`, open the ticket search, open a ticket detail screen, and open the batch menu `kimibatch/kimibatchtree.php`.
  - Verify: each screen renders without a PHP error or warning, the PHP error log is empty of fatals afterwards, and the Mandant and campaign survive a page reload — which also re-verifies $40 **Re-apply the session-reset fix that the delivery reverted**.

---

## Phase 4 — Deploy to the dev server

- [ ] $48 **Deploy by fast-forward and verify the server state afterwards**
  - Plan: confirm `git status` is clean on the dev server, then `git pull` in `/home/kimiportaldev.at/web/htdocs/kimidev_ET/`. The environment `config.php` files are now tracked, so the pull will also update them — intended, and the reason the policy changed, but it means the database settings must be re-checked immediately afterwards.
  - Verify — in this order: `git status` clean and `HEAD` at the expected commit; `config/config.php` still names `kimidev_et`; every file owned by `kimiportaldev.at:kimiportaldev.at` with none unreadable; the portal returns HTTP 200 on `login.php`; a login as `system` succeeds in a browser; and `adminer-4.8.1.php`, `kimibatch/phpinfo.php` and `kimibatch/kimiphpinfo.php` all return 404.
  - Reference: carried forward from $17 **Deploy the result to the dev server and hand it to Franz Tausch for the test round**; the ownership check exists because the hosting provider's copy left 2 309 root-owned files on 2026-09-08, recorded in $28 **The delivery overwrote the dev database settings with production ones, in `kimibatch/db.php` and in both `config.php` files**.

- [ ] $49 **Keep a tested rollback ready for the duration of the test round**
  - Plan: the rollback is `git reset --hard 7fb5ae0` in `/home/kimiportaldev.at/web/htdocs/kimidev_ET/`, or a restore from `/home/kimiportaldev.at/web/kimidev_ET_backup_20261001/` if git itself is damaged.
  - Verify: do not merely document the rollback — rehearse it once in the local Docker stack and confirm the portal still serves afterwards, so the procedure is known to work before it is needed under pressure.

---

## Phase 5 — Functional testing with the client

- [ ] $50 **Re-test the three batch imports that Franz Tausch reported as failing**
  - Problem: P1 (INKODE: 29 records versus 32 in the input file), P2 (INKO2016: 4 records instead of 46) and P3 (OKO/POS30: 28 records versus 16 expected) were never resolved, and the working hypothesis P4 was that the input files had been uploaded into the wrong directory.
  - Verify: for each import, count the lines of the input file on the server immediately before the run, run the import, and compare the imported record count against that line count — rather than against what the file is believed to contain. The 2026-08-23 failure was precisely a mismatch between the file on disk and the file assumed.
  - Blocked by: Franz Tausch must upload his test input files again — the production delivery overwrote `kimibatch/files/INKODE.CSV`, `kimibatch/files/INKO2016.CSV` and `kimibatch/files/pos30cc.txt` with production's own copies on 2026-09-08, recorded as $21 **Franz Tausch's own test import files were overwritten by production's copies**.
  - Reference: carried forward from $18 **Re-test Franz Tausch's import record-count problems P1, P2 and P3 on the redeployed code**; details in `/home/viktar/Projects/kimi-plus.at/docs/16-additional-feedback-from-franz/franz-reported-problems-2026-08-23.md`.

- [ ] $51 **Run the client's DEV test cases end to end**
  - Plan: work through `/home/viktar/Projects/kimi-plus.at/docs/08-franzs-letter-and-a-dump/KIMIPortal_Tests_DEV_20260607-English.pdf` against `https://10.196.69.21/kimidev_ET/login.php`.
  - Verify: record a pass or fail per test case in writing, with a screenshot for each failure. This is step 3.3 of the August plan, which was never executed.

- [ ] $52 **Monitor a full batch and cron cycle before asking for sign-off**
  - Plan: after the test round, review `log/`, the nginx error log `/home/kimiportaldev.at/web/logs/nginx-error.log`, the PHP error log `/home/kimiportaldev.at/web/logs/phperrors.log`, and the batch import and export output.
  - Verify: no fatal errors, and every warning that does appear is classified as pre-existing or new, by comparing against the same logs from before the deployment.

- [BLOCKED] $53 **Obtain Franz Tausch's confirmation that the dev system behaves as expected**
  - Verify: the confirmation must name what was tested, not merely say that the system works — at minimum the three batch imports of $50 **Re-test the three batch imports that Franz Tausch reported as failing**, the campaign selection in Firefox that failed on 2026-08-19, and the ticket screens of the DEV test cases.
  - Blocked by: Franz Tausch, who asked on 2026-08-23 for an alignment meeting before the test round proper begins, afternoons only.

---

## Phase 6 — Close out

- [ ] $54 **Tag the validated commit as the PHP 8.5 dev baseline**
  - Plan: create an annotated tag on the branch `main` of `git@github.com:viktarkruhlikau/kimi.git` whose message names the production delivery date 2026-09-08 and the sign-off date, so the tag records which production content was validated and not only when.
  - Verify: the tag points at the exact commit running on the dev server at the moment of sign-off, confirmed by comparing the tag's hash against `git rev-parse HEAD` on the server.

- [ ] $55 **Update the memory bank with the new baselines and the delivery history**
  - Plan: update `/home/viktar/Projects/kimi-plus.at/memory-bank/smoke-tests-src-dev.md` with the new green figures from $45 **Run the full smoke suite and record the new green baseline**, and `/home/viktar/Projects/kimi-plus.at/memory-bank/batch-processing-subsystem.md` with the batch scripts the delivery added, since 65 of the 80 new PHP files live in `kimibatch/`.
  - Verify: only stable project knowledge is recorded — no temporary implementation detail, per the project rule in `/home/viktar/Projects/kimi-plus.at/CLAUDE.md`.

- [ ] $56 **Write the deploy and rollback runbook**
  - Problem: there is still no written deployment process; every deployment so far has been reconstructed from task notes.
  - Reference: step 5.3 of `/home/viktar/Projects/kimi-plus.at/tasks/07-implement-deployment-to-dev/02-option1-execution-plan.md`, never started.

- [ ] $57 **Document the per-environment value swap needed for an eventual production cutover**
  - Plan: record the values that differ between the dev and production instances — host `10.196.69.21` versus `10.196.69.11`, `session_name` `kimiET-A` versus `kimiET-P`, database `kimidev_et` versus `kimi_et`, directory `kimidev_ET` versus `kimi_ET` — and note that since 2026-10-03 the environment `config.php` files are tracked in git, so a production deployment from this repository would carry the dev values unless they are swapped deliberately.
  - Reference: step 5.2 of `/home/viktar/Projects/kimi-plus.at/tasks/07-implement-deployment-to-dev/02-option1-execution-plan.md`, and the policy in `/home/viktar/Projects/kimi-plus.at/memory-bank/git-tracking-policy-kimidev-et.md`.

---

## Open questions for the hosting provider and the client

- [BLOCKED] $58 **Why did the production delivery not contain `kimibatch/vendor/`?**
  - Problem: `kimibatch/kimi_general.php:13` loads PHPMailer from `./vendor/phpmailer/phpmailer/src`, which resolves to `kimibatch/vendor/` because the batch scripts run with `kimibatch/` as their working directory, and 133 scripts include that file — yet the delivery brought only `kimibatch/files/vendor/`, which the code does not load from. Either production has its own `kimibatch/vendor/` that the copy excluded, or those 133 scripts fail on production too.
  - Blocked by: the hosting provider.
  - Reference: $24 **`kimibatch/vendor/` is required by 133 batch scripts and must NOT be deleted, yet ANEXIA's copy did not deliver it**.

- [BLOCKED] $59 **Should the OKO document links point at the dev host instead of production?**
  - Problem: `modules/gui/templates/tickets/8/ticket.php:33` and `modules/gui/templates/tickets/8/ticket.php:35` link to `https://10.196.69.11/kimi_ET/modules/gui/templates/tickets/8/OKO_Sachbearbeiter.pdf` and the matching `OKO_Leitfaden.pdf` — absolute URLs pointing at the production host, so on the dev server they lead to production.
  - Blocked by: Franz Tausch.
  - Reference: $26 **The two OKO PDFs are referenced by current production code through absolute production URLs**.
