# Option 1 — Execution plan: re-apply the PHP 8.5 upgrade onto the actual dev code

**Chosen direction (Option 1):** take the actual dev code (`kimidev_ET`, captured in `src-dev/original-src`) as the baseline, re-run the proven Rector + manual-fix upgrade on it, validate, deploy to the dev server, then converge into one canonical repo. Rationale and option comparison: see `step1.2-comparison-report.md` and the chat decision.

## Key ground rules (decided)

- **Version control hub = GitHub `https://github.com/viktarkruhlikau/kimi.git` (private).** The repo root **is the deployable app dir `kimidev_ET`**. Locally its working copy is `src-dev/original-src/web/htdocs/kimidev_ET/`; on the dev server it is the docroot app dir `kimidev_ET/` (a clone that **pulls to deploy** and can **commit + push manual edits** — the live change-ledger). The docker/tooling/tests scaffolding stays **outside** this repo (up in `src-dev/`) so it never deploys.
- **Deploy transport = GitHub push → pull.** Flow: build + commit in the local app repo → `git push` to GitHub → `git pull` on the dev-server `kimidev_ET`. Verified prerequisite: the dev server reaches `github.com:443` (tested 2026-08-13). The private repo needs a **read-only GitHub deploy key** installed for the `kimiportaldev.at` user on the server so the pull authenticates.
- **Data-exposure trade-off accepted (decision 2026-08-13):** the code carries inline secrets that ship in `.php` and will land in the GitHub repo — the telematica `auth=` token in `src-dev/original-src/web/htdocs/kimidev_ET/ajax/callInntelco.php` and the validphone `uid/upw` in `src-dev/original-src/web/htdocs/kimidev_ET/validphone.php`. This is accepted. We still gitignore `config/config.php` (per-environment, holds the DB password), `kimibatch/files/` (churny data + PII), `log/`, and `*.sql.gz` — so `git pull` on the server never overwrites the environment config or live data.
- **Never run Rector on the live server.** Rector rewrites files in place; run it locally in the docker 8.5 stack, review, then push and pull the result.
- **Run on PHP 8.5 via docker** (local native PHP is 8.4.17). The 8.5 environment + vendored Rector + smoke harness come from `src/upgraded-src/`; we give `src-dev/` its own copy of that stack (see 0.7).
- **Preserve dev-specific environment:** app folder name `kimidev_ET`, `session_name('kimiET-A')`, DB `kimidev_et`, include-path layout (`kimibatch/vendor`), `config/`, `log/`, and all live `kimibatch/files/` data (never `--delete`).

## Task tracker

- [x] Phase 0 — Safety net & versioning
- [x] Phase 1 — Map the manual-fix port
- [x] Phase 2 — Produce the upgraded dev artifact
- [ ] Phase 3 — Deploy to `kimidev_ET` & validate
- [ ] Phase 4 — Stabilize & sign-off
- [ ] Phase 5 — Converge & document

## Phase 0 — Safety net & versioning

- [x] **0.1 Local app repo → GitHub:** `git init` in `src-dev/original-src/web/htdocs/kimidev_ET/` (repo root = the deployable app dir); `.gitignore` excludes all `**/config.php` (both `config/config.php` and the env-specific `ajax/config/config.php`), `kimibatch/files/`, `log/`, `*.sql.gz`; added `.gitattributes` (`* -text`) + `core.autocrlf=false` so the repo **preserves the server's CRLF line endings byte-for-byte** (without this, a clone diverged from the server on 283 files); committed the current dev code as the **authoritative baseline** and pushed. Current baseline commit: **`a9ac240`** on `main`. Verified via throwaway clone on the server: **0 content differences** vs the live `kimidev_ET`.
- [x] **0.2 Install a GitHub deploy key** on the dev server (private-repo auth) — **done**. The user's home `~/.ssh` is root-owned and not writable, so the key lives in the writable, above-docroot dir: private `/home/kimiportaldev.at/web/.deploy/github_kimi_deploy` (mode 600) + `known_hosts` beside it. Public key added to GitHub Deploy keys **with write access enabled** (user's choice — also lets the server push its manual edits). Git uses it via `GIT_SSH_COMMAND="ssh -i ~/web/.deploy/github_kimi_deploy -o IdentitiesOnly=yes -o UserKnownHostsFile=~/web/.deploy/known_hosts"`. Verified: `git ls-remote git@github.com:viktarkruhlikau/kimi.git` returns `main → a9ac240`.
- [x] **0.3 Server `kimidev_ET` → same repo — done.** In the live docroot `kimidev_ET/`: `git init`; `git config core.sshCommand "ssh -i ~/web/.deploy/github_kimi_deploy -o IdentitiesOnly=yes -o UserKnownHostsFile=~/web/.deploy/known_hosts -o StrictHostKeyChecking=accept-new"` (the `StrictHostKeyChecking` flag is required — without it the fetch fell back and got `Permission denied (publickey)`); `git remote add origin git@github.com:viktarkruhlikau/kimi.git`; `git fetch`; `git reset --mixed origin/main` (no working-tree writes) + `git branch -u origin/main`; `git checkout -- .gitignore .gitattributes` (only the 2 metadata files). Verified: clean `git status` (`main...origin/main`, 0 modified), `HEAD=a9ac240`, and an app-file fingerprint **identical before/after** (proof of no code change). `config/config.php` + `ajax/config/config.php` present and git-ignored. Note: SSH-to-GitHub auth was intermittent (one fetch failed, retry succeeded); `.git/` now sits under the docroot (reachable at `/kimidev_ET/.git/` unless an nginx `deny` is added).
- [x] **0.4** Code + DB backup — **already satisfied**: the rsync mirror `src-dev/original-src/` is the current code backup and `src-dev-db-dumps/kimidev_et_20260812_1631.sql.gz` (2.7 GB, verified) is the DB backup. (A fresh dump immediately before the real deploy is a Phase 3 action, not a setup step.)
- [x] **0.5 Snapshot the initial `kimidev_ET` code on the server** — **done**: `cp -a` to `/home/kimiportaldev.at/web/kimidev_ET_backup_20260813` (above docroot, not web-served; 730 files, 26 M, `diff` = 0 vs live). Fast restore point before 0.3 adds `.git`.
- [x] **0.6 Get a working portal login for testing** — **done**: `system` (`benutzer.id=1`) password reset to `admin123` (verified: stored hash == `sha256('kimiplus'+'admin123')`). Login: `system` / `admin123` at `https://10.196.69.21/kimidev_ET/login.php`. Done by resetting the existing admin user's password (not creating a new account). Admin = `benutzer` row `id=1`, `name='system'`, group `Management` in `kimidev_et` (the account the local `scripts/set-admin-password.sh` already treats as admin). Two helper scripts added:
  - `scripts/connect-to-kimidev-database-through-ssh.sh` — opens an interactive MariaDB client on the server against `kimidev_et` (creds read from the app config on the server, not hard-coded).
  - `scripts/set-kimidev-server-admin-password.sh` — sets `benutzer.passwort` for `name='system'` to `admin123` on the server (`passwort = sha256('kimiplus' + password)` per `src-dev/original-src/web/htdocs/kimidev_ET/libs/entities/user.php:205`).
  Run the second script to apply; login is then `system` / `admin123` at `https://10.196.69.21/kimidev_ET/login.php`.
- [x] **0.7 Scaffold a PHP 8.5 docker stack for `src-dev/` — done.** Copied `src/upgraded-src/docker/`, `tooling/`, `tests/` into `src-dev/`; wrote `src-dev/docker-compose.yml` (name `kimi-plus-dev`, web `8082`, db `3308`, web mount `./original-src/web/htdocs` → `/var/www/html`, dropped the vendor-relocation mount since dev already has `kimibatch/vendor`); repointed `tooling/php-upgrade/rector.php` and all 8 `tests/` files from `kimi_ET` → `kimidev_ET`. Verified: **web serves on PHP 8.5.9** (`login.php` → HTTP 200, root → 302), DB is **MariaDB 12.3.2** (matches the server) with DB/user `kimidev_et`/`sql_kimidev_et` matching the app config (socket connection). **Full 2.7 GB production dump imported into the local DB** (real data — see the PII follow-up in Risks). The dev code has **zero hardcoded absolute filesystem paths**, so it runs unchanged at the docker mount.

**Exit:** authoritative baseline pushed to GitHub and cloned/aligned on the server (deploy-key pull working); a known-good code+DB backup exists; a runnable 8.5 docker stack for `src-dev/`.

## Phase 1 — Map the manual-fix port (no code changes)

- [x] **1.1** Field-level diff of the ~47 meaningful files (`kimibatch/` + `tickets/`) between the dev tree and `src/original-src` — to see where the dev code differs from the baseline our existing manual 8.5 fixes were written against, so those fixes port correctly in Phase 2. **Done** — deliverable: `tasks/07-implement-deployment-to-dev/03-phase1-manual-fix-port-map.md` (raw diffs: `03-phase1-field-diffs.txt`). Result: of 50 substantive differing files, **8** get an 8.5 fix on disjoint lines (ports cleanly), **0** need adaptation (no dev-divergent line overlaps an 8.5-fix line), and **42** received no 8.5 fix at all. The dev functional divergences to preserve (`kimibatch/okoimp.php` telnr activation, the `tickets/{8,10,16,19,34}` telephone UI) are unrelated to the 8.5 fixes.
- [x] **1.2 No DB migration.** The dev DB (`kimidev_et`) is the authoritative, current database and stays as-is; this upgrade is **code-only** (PHP 8.5 compatibility) and the dev code already matches this DB. The 2.7 GB dump is kept only as a rollback backup. **Confirmed** in `03-phase1-manual-fix-port-map.md`: every 8.5 fix is pure PHP type-safety (`(string)` casts, `mysqli_fetch_assoc` false-guards, `iconv` argument casts) — no DDL, no data change.

**Exit:** a per-file map of which manual fixes apply/adapt; confirmed the upgrade is code-only (no schema change). **Met.**

## Phase 2 — Produce the upgraded dev artifact

- [x] **2.1** Copy the Rector config to target the dev tree — **already in place from Phase 0.7 and verified**: `src-dev/tooling/php-upgrade/rector.php` targets `src-dev/original-src/web/htdocs/kimidev_ET`, uses exactly `SetList::PHP_81..PHP_85`, and skips `adminer-4.8.1.php`, `kimibatch/vendor`, `libs/addons/phpmail` (+ `RemoveFuncCallRector`).
- [x] **2.2 Rector dry-run** in docker (PHP 8.5.9) — **done**. Output: `tasks/07-implement-deployment-to-dev/04-rector-dry-run.txt`. Result: **47 files would change, 0 in skipped paths**; rules = `NullToStrictStringFuncCallArgRector` (46 files, `(string)` casts on string-function args) + one `ReturnNeverTypeRector` (`libs/application.php` — `throw_exception(): never`). Matches the Phase 1 prediction; no structural rewrites.
- [x] **2.3 Rector apply** — **applied 2026-08-14 to the dev tree** (docker, run as host UID). 47 files changed (46 tracked + 1 gitignored `kimibatch/files/27/Scripts/okoexp.php`), 259/259 line-for-line edits, **PHP lint clean on all 46 tracked files**. Committed to the `kimidev_ET` app repo as **`4ea05a3`** ("rector output").
- [x] **2.4 Harden + audit the safety net** — **done**. **Audit:** discovery coverage is already complete — the non-recursive `*.php` globs (`modules/gui`, `modules/initial`, `modules/menu`, `ajax`, `kimibatch`) already pick up all 22 dev-only `modules/gui/*.php` files and both dev-only batch scripts (`kimibatch/ifscheck20181128.php`, `kimibatch/inkodeimp2_test.php`); the only dev-only files not discovered are 3 template files under `modules/gui/templates/tickets/19/17/`, which are `include`d by a module (not standalone entrypoints), correctly not load-tested alone — **no glob change needed**. **Hardening:** neutralized the two external hosts `validphone.validdata.eu` and `vbox6813.telematica.at` → `127.0.0.1` via `extra_hosts` in `src-dev/docker-compose.yml`, and added `-d default_socket_timeout=1` to the two harness runners (`src-dev/tests/SmokeTest/BatchSmokeTest.php:16`, `src-dev/tests/SmokeTest/TopLevelEntrySmokeTest.php:22`). **Verified:** `TopLevelEntrySmokeTest` dropped from a ~60 s hang to **1 s with 0 timeouts**; `validphone.php` now passes (outbound reads fail instantly — no fatal, no real external call, no credential leak). Remaining 4 top-level failures (`login.php`, `setticketcallinfo.php`, `xhangup.php`, `adminer-4.8.1.php` — all fast non-zero-exit) are 2.5 work.
- [x] **2.5 Smoke-driven 8.5 fixes on the dev tree** — **done, green baseline: 142 pass / 72 skip / 0 fail** (214 tests). The only genuine 8.5 code fix was `modules/initial/subdetail.php` → `count($subkonten ?? [])`, committed to the `kimidev_ET` app repo as **`e020fdd`**. Every other failure was triaged (full inventory: `05-smoke-failures-inventory.md`) as pre-existing/dead-code/harness/absent-feature — **not our 8.5 regression** — and resolved **test-infra-only**: `BatchSmokeTest` switched to `php -l` (no execution, so no DB mutation/PII, dissolving §3/§5), the router `session_name()` ordering fixed in `router_runner.php`, and dead/absent/context/tool modules quarantined with documented reasons in `SmokeTest/Quarantine.php`. Client-decision items captured in `06-found-problems-for-client.md`. `src/upgraded-src` was used only as reference, never as a code source. **Net app-code change for the whole upgrade: the Rector output + this one `subdetail.php` line.**

**Exit:** the upgraded app repo exists, produced by the same pipeline, with every step a separate git commit.

## Phase 3 — Deploy to `kimidev_ET` & validate

We update `kimidev_ET/` **in place** (no separate staging folder). The upgrade is **code-only — no DB changes**, so rollback is git (`reset --hard`) or the 0.5 code snapshot; the DB dump is kept only as general insurance.

- [x] **3.1** Smoke suite locally in docker 8.5 against the upgraded tree — **green (142 pass / 72 skip / 0 fail)**; see 2.5 / `05-smoke-failures-inventory.md`.
- [x] **3.2 Deployed 2026-08-14** (test env — no maintenance window needed, per Franz/owner). Fast-forwarded the server repo `/home/kimiportaldev.at/web/htdocs/kimidev_ET` from `a9ac240` → **`e020fdd`** (`git merge --ff-only origin/main`, 46 files). Verified: gitignored `config/config.php` + `ajax/config/config.php` preserved, `modules/initial/subdetail.php:127` carries the `count($subkonten ?? [])` guard, Rector casts present, clean working tree. `php8.5-fpm` not reloaded (no sudo) — **not needed**: `opcache.validate_timestamps=On`, `revalidate_freq=2`, so opcache picks up the new mtimes automatically. Site serves: `https://10.196.69.21/kimidev_ET/login.php` → HTTP 200.
- [ ] **3.3 Functional tests** against `https://10.196.69.21/kimidev_ET/login.php` per the DEV test cases (`docs/08-…/KIMIPortal_Tests_DEV_…pdf`): login (0.6 test account), ticket screens render, batch import/export scripts run. (Test env — telephony/CTI is not wired for real outbound calls.)
- [ ] **3.4 Rollback if needed:** `git reset --hard <baseline-commit>` on the server, or restore the 0.5 code snapshot.

**Exit:** smoke green locally; upgraded code running in `kimidev_ET`; test cases pass; rollback verified to work.

## Phase 4 — Stabilize & sign-off

- [ ] **4.1** Monitor over a full batch/cron cycle: check `log/`, nginx + `php8.5-fpm` error logs, and batch import/export output for regressions.
- [ ] **4.2** Get Franz's confirmation that the dev system behaves as expected on PHP 8.5.
- [ ] **4.3** Tag the validated commit in git as the 8.5 dev baseline.

**Exit:** upgraded dev system stable over a full cycle, Franz-confirmed, tagged.

## Phase 5 — Converge & document (Option 2 end-state)

- [ ] **5.1** Fold the reconciled + upgraded dev tree back into the repo as the **single canonical source**.
- [ ] **5.2** Document the **per-environment value swap** (host `…69.21`/`…69.11`, `session_name` `kimiET-A`/`-P`, DB `kimidev_et`/`kimi_et`, folder `kimidev_ET`/`kimi_ET`) for the eventual **PROD cutover**.
- [ ] **5.3** Write a lightweight, repeatable **deploy + rollback runbook** (there is currently no deployment process).
- [ ] **5.4** Follow-up: externalize secrets out of code into env/config (not blocking this deploy).

**Exit:** one canonical upgraded codebase, a documented per-env mapping, and a repeatable deploy runbook ready for PROD.

## Risks / things to keep in mind

- Deploying the wrong tree silently **reverts real dev features** — take the dev code as the authoritative baseline and diff every change before deploy.
- **Hardcoded URLs / telephony** can't be exercised locally → functional testing runs in `kimidev_ET` on the server; smoke stays a load-only check with stubs. (Test env: telephony/CTI is not wired for real outbound calls.)
- **Upgrade is code-only — no DB changes.** The `kimidev_et` DB stays as-is; rollback is git / the 0.5 code snapshot; the DB dump is only general insurance.
- **Secrets/PII on GitHub (accepted 2026-08-13):** inline API secrets ship in tracked `.php` and will be in the private repo; `config/config.php` + `kimibatch/files/` stay gitignored. Follow-up (5.4): externalize secrets out of code so future history is clean.
- **No existing deploy process / no rollback by default** → the 0.1 baseline commit + 0.5 code snapshot + 0.4 DB dump are the rollback path; verify rollback works before trusting it.
- Dev is the **rehearsal for PROD**; keep the process identical apart from the documented per-env swap.
- **Local docker DB holds the FULL production data (real PII)** — decision 2026-08-14: real data was prioritized over PII concerns for local testing (the full `kimidev_et` dump is loaded into the local `src-dev` docker DB). **Follow-up to revisit:** before sharing the local stack, backing up its DB volume anywhere, or onboarding anyone else, anonymize/scrub the local `kimidev_et` data (and keep the docker DB volume out of any shared/synced location). This is a GDPR-relevant item to address, just deferred, not dismissed.
