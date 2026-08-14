# Step 1.2 — Comparison report: dev server code vs `src/original-src`

**Question (from the task):** Is the code deployed on the dev server the same as `@src/original-src/`, or has it diverged?

# What is on the dev server

**Live runtime on the dev server (verified 2026-08-13, over SSH):**

- **PHP `8.5.8`** — the `kimidev_ET` site is served by `php8.5-fpm` (pools `127.0.0.1:9001` app + `127.0.0.1:9002` batch, both under `/etc/php/8.5/fpm/`); CLI is also `PHP 8.5.8`. No other PHP version is installed.
- **MariaDB server `12.3.2-MariaDB-deb13-log`** (`SELECT VERSION()` against the live `kimidev_et` DB; client `mariadb 12.3.2`).

The dev docroot (`/var/www/vhosts/kimiportaldev.at/htdocs/`) holds **two separate instances** of the KIMI portal side by side:

- `~/web/htdocs/kimi_DEV`
- `~/web/htdocs/kimidev_ET`

They share code lineage but are different instances — different session names, different databases, different purpose and activity level (they diverge in ~230 files).

### `kimidev_ET/` — the live dev/test portal (this is "the" dev system)

| Property         | Value |
|------------------|-------|
| Purpose          | **Active KIMI test environment** — the site root `index.php` redirects here (`→ /kimidev_ET/login.php`) |
| Session instance | `session_name('kimiET-A')` — the **"ET-A"** (test) instance of the main product (PROD is "ET-P") |
| Database         | **`kimidev_et`** (user `sql_kimidev_et`), archive DB `kimi_archiv` — config in `kimidev_ET/config/config.php` |
| Activity         | Actively used — carries live batch **output files whose dates are in the filenames** (e.g. `…ELSBETH_neu20260706…csv`), so the system produced 2026-07 output (content evidence, not mtime) |
| Contents         | Clean app tree: `login.php`, `getticketurl.php`, `setticketcallinfo.php`, `testpost.php`, `modules/`, `libs/`, `ajax/`, `kimibatch/`, `log/` — no scratch/backup files |
| Corresponds to   | the repo's `src/original-src/web/htdocs/kimi_ET` (a diverged variant of it — see below) |

This is where ANEXIA imported the PROD DB (`kimi_et` → `kimidev_et`, per `docs/14-update-from-Franz-about-the-database/`). **This is the folder relevant to the migration/deployment.**

### `kimi_DEV/` — an old developer sandbox (stale)

| Property         | Value |
|------------------|-------|
| Purpose          | **Developer sandbox / batch-framework playground** — not the live portal |
| Session instance | `session_name('kimiSB')` — **"SB" = Sandbox** |
| Database         | root `config.php` → **`kimi_KBF_Test`** (KBF = KimiBatchFramework test DB, user `kimi`); a nested `config/config.php` points to the now-unused **`kimiportaldev`** DB (user `sql_kimiportaldev`) |
| Activity         | Files **2022-03 → 2022-05 only** — untouched for ~4 years (frozen) |
| Contents         | Scratch/experimental/backup files: `index.php.old`, `index.php.new`, `test.php`, `tes.php`, `f.php`, `newdb.php`, `KimiBatchFramework_20150817_*.tar.gz` (2015 archives), and one-off scripts (`zooblitz_outbound_calls.php`, `akte_datenkopieren_wien_energie.php`, `IPM-handakten.php`, `validphone_batch.php`) |

### Justification of these conclusions

- **Which one is live:** the docroot root `index.php` issues `header("Location: https://10.196.69.21/kimidev_ET/login.php")` — traffic goes to `kimidev_ET`, not `kimi_DEV`.
- **Instance identity:** each folder's `index.php` sets a distinct `session_name` — `kimiET-A` (kimidev_ET) vs `kimiSB` (kimi_DEV) — so they are independent sessions/instances, not one app.
- **Database wiring:** read directly from each `config.php` — `kimidev_ET` → `kimidev_et` (the DB that received the PROD import); `kimi_DEV` → `kimi_KBF_Test` / `kimiportaldev` (a test/unused DB). Different databases confirm different purposes.
- **Active vs stale:** file modification times — `kimidev_ET` has files through 2026-07 (live batch output), while every `kimi_DEV` file is 2022-03…2022-05 and it is littered with `.old`/`.new` backups, `test.php`/`tes.php`/`f.php` scratch scripts and 2015 batch-framework tarballs — the signature of an abandoned sandbox.
- **Note:** the `kimiportaldev` DB referenced by `kimi_DEV` is the same unused database ANEXIA (Bernhard Schreitl) proposed deleting in `docs/14-update-from-Franz-about-the-database/`.

---

## Comparison of `src/original-src/web/htdocs/kimi_ET` and `src-dev/original-src/web/htdocs/kimidev_ET`

### Folder trees comarison of `src/original-src/web/htdocs/kimi_ET` and `src-dev/original-src/web/htdocs/kimidev_ET`

**Top level is effectively identical.** Both trees have `ajax/ config/ css/ ical/ js/ kimibatch/ libs/ modules/`; the only top-level difference is `log/` (DEV only, a runtime log dir). All real structural divergence is in subfolders — listed below, each assessed as meaningful code vs auxiliary/data.

| `src/original-src/web/htdocs/kimi_ET` folder  | `src-dev/original-src/web/htdocs/kimidev_ET` folder | Assessment |
|-----------------------------------------------|-----------------------------------------------------|------------|
| `modules/gui/templates/tickets/{1,2,3,35}`    | `modules/gui/templates/tickets/19/17`               | **IMPORTANT — the only code-significant difference.** Per-campaign ticket/case UI templates (real code); each side has campaigns the other lacks. Needs a deploy decision. |
| `modules/gui/old_delete/`                     | —                                                   | **Redundant — dead code** (old GUI-module copies). Do not deploy. |
| `kimibatch/files/{41, 43, 20240606, save/}`   | `kimibatch/files/{184, 16/IN, 18/IN, 24/IN}`        | **Auxiliary — batch data**, environment-specific. Preserve DEV's; do not overwrite. |
| `kimibatch/files/vendor/`                     | `kimibatch/vendor/`                                 | **Auxiliary — vendored** phpmailer/composer lib, same contents, relocated (include path differs). |
| `kimibatch/files/css/`                        | `css/`                                              | **Auxiliary — styling** themes, same contents, relocated. |
| —                                             | `kimibatch/temp/`, `log/`                           | **Auxiliary — runtime scratch.** |

**Verdict:** The **only structurally-meaningful code difference is the per-campaign `modules/gui/templates/tickets/<id>` templates**, where the two environments carry different campaign sets — that is the one folder-level item to decide on before deploying.

---

### Single files comparison of `src/original-src/web/htdocs/kimi_ET` and `src-dev/original-src/web/htdocs/kimidev_ET` (excluding the folder differences detected above)

Of the **141 files that exist on both sides but differ in content**, 42 are batch **data/log** files under `kimibatch/files/` (already classified as auxiliary in the folder table). The remaining **99 are core code**, classified below by reading the actual diffs (whitespace-ignored):

| Category | Count | Where | Meaningful / redundant / auxiliary |
|----------|-------|-------|------------------------------------|
| **Cosmetic only** — differ solely by a trailing `?>` close-tag and/or blank lines | 48 | 44 `libs/`, 4 `modules/` | **Redundant** — no logic change, pure formatting. |
| **Environment/instance only** — differ solely by `session_name`, host URL, or DB name | 4 | `login.php`, `libs/init.php`, `config/config.php`, `getticketurl.php`* | **Auxiliary** — expected per environment (DEV `kimiET-A` / `kimidev_ET` / `10.196.69.21` vs REPO `-P` / `kimi_ET` / `…69.11`); must be preserved, not "fixed". |
| **Substantive** — real code/logic differences | 47 | 32 `kimibatch/*.php`, 12 `modules/gui/templates/tickets/{8,10,16,19,34}/*`, `testpost.php`, `getticketurl.php`, `libs/application.php` | **MEANINGFUL** — review before deploy. |

\* `getticketurl.php` mixes an env-URL change with a small logic change, so it is counted under environment but also carries a substantive edit.

**What the substantive changes are about** (from sampling the diffs):

- **Batch import/export scripts (`kimibatch/`, 32 files)** — differences in the Elsbeth import/export SQL and flags. E.g. `okoimp.php`: REPO activates `telnr3`/`telnr4` (comment "2023-07-19 tele3 und tele4 aktiviert") where DEV keeps them `null` (deactivated); `coeo02_…_import.php`: `exportQueryToCSV(…, false)` in REPO vs `(…, true)` in DEV. These change what the batch jobs read and write.
- **Ticket (case) UI templates (`tickets/{8,10,16,19,34}`, 12 files)** — per-campaign agent screens differ in **telephone-field layout and click-to-call wiring**. E.g. `tickets/19/ticket.php`: REPO shows extra `Telefon1Falsch`/`Telefon2Falsch`/`TelnrApl` fields and a `callTelco1` phone-call icon; DEV shows a simpler `Telefon`/`Mobiltelefon` layout. This is the same area as Franz's requested telephone / ONCLICK-call work.
- **Telephony endpoints** — `testpost.php` and `getticketurl.php` (call/redirect endpoints) carry small logic changes beyond the environment URLs.

**Verdict:** about **half** of the 99 core-code diffs (48) are **cosmetic** (`?>` / whitespace) and **4** are **environment config** — none are real changes. The genuinely meaningful single-file divergence is **~47 files**, concentrated in the **same two areas the folder analysis flagged**: `kimibatch/` batch scripts and `modules/gui/templates/tickets/`. Those are the files to review before deploying — they touch batch import/export behaviour and the agent-facing telephone/call UI.

---

- **DEV** = `src-dev/original-src/web/htdocs/kimidev_ET/` — the live dev app, rsynced from `kimiportaldev.at:/var/www/vhosts/kimiportaldev.at/htdocs/` (Step 1.1, via `scripts/rsync-dev-sources.sh`). `kimidev_ET/` is the redirect target of the site root.
- **REPO** = `src/original-src/web/htdocs/kimi_ET/` — our original-source baseline.

Method: `diff -rq` between the two trees (content comparison) plus content sampling — no reliance on file timestamps (see the note under "which side is newer"). Full machine-readable lists: `tasks/07-implement-deployment-to-dev/step1.2-diff-lists.txt`.

## Headline numbers

| Metric                                  | Value                                                                                 |
|-----------------------------------------|---------------------------------------------------------------------------------------|
| Total files — REPO `kimi_ET`            | 2,138                                                                                 |
| Total files — DEV `kimidev_ET`          | 730                                                                                   |
| Files present in both but **differing** | 141 (of which **99 are core code**; the rest are `kimibatch/files/` data + logs)      |
| Only in REPO                            | 1,375 (**1,310 are `kimibatch/files/` campaign data**, 56 batch scripts, 9 app files) |
| Only in DEV                             | 272 (**227 are `kimibatch/files/` data**, 25 modules, 10 css, misc)                   |

## On "which side is newer" — not determinable from timestamps

**File modification times are unreliable on both sides and are NOT used to draw any conclusion.** On the server they most likely reflect when files were *deployed/copied* to the dev box; locally they reflect when the `rsync` wrote them. Neither reflects when the code was *authored*. (An earlier draft ranked "REPO newer in 140/141" from mtimes — that was an artifact and is withdrawn.)

The only content-based hint available is **dated edit-markers written inside the source** (e.g. `//20230412` comments — these are literal code, not filesystem metadata): the latest such marker is `2023-05-08` in REPO and `2023-04-12` in DEV. That is a weak signal (present in only some files) suggesting both trees are 2022–2023-era code, but it is **not** a basis for deciding which is authoritative.

**We do not need a "newer" verdict for the deployment decision.** What matters is the *content* difference — which files differ and what changed — established by `diff -rq` above and to be detailed by a semantic review of the 99 differing core files (comparing actual code, not any dates).

## Where the code differences are (the 99 core-code differing files)

| Area                                  | # differing   | Notes                                                        |
|---------------------------------------|---------------|--------------------------------------------------------------|
| `kimibatch/*.php` (scripts, not data) | 32            | batch import/export scripts                                  |
| `libs/`                               | 46            | shared entities / business logic                             |
| `modules/`                            | 16            | GUI modules (+25 modules exist only on DEV, +6 only in REPO) |
| `ajax/`                               | 3             | AJAX endpoints                                               |
| entrypoints                           | 4             | `login.php`, `index.php`, `getticketurl.php`, `testpost.php` |
| `config/`                             | 1             | `config.php` — environment config (expected to differ)       |

### Concrete examples

- **Instance/environment marker (not a version marker):** `login.php` — REPO `session_name('kimiET-P')` vs DEV `session_name('kimiET-A')` (production "P" vs the dev/test "A" instance). This distinguishes the two instances, not their age.
- **Content-level divergence:** `libs/application.php` — DEV carries a `//20220503/ab` edit marker that is absent from the REPO copy; the two files genuinely differ in content (independent of any timestamp).

## The large file-count gap is mostly DATA, not code

The 1,310 "only in REPO" and 227 "only in DEV" files under `kimibatch/files/` are per-campaign exchange/data files (CSV in/out, Elsbeth exchange), i.e. **runtime data that naturally differs per environment** — not application code. The dev server also holds **live 2026-07 batch output** that must not be destroyed.

## Implications for the deployment task

1. Deploying our `src/upgraded-src` (built on `src/original-src`) to the dev server will **replace a diverged codebase** — the deployed `kimidev_ET` differs from `src/original-src` in 99 core-code files (both are 2022–2023-era; see Direction). Expect broad changes in `libs/`, `modules/`, entrypoints, and batch scripts, not a like-for-like swap.
2. **Environment/instance specifics must be preserved**: `config/config.php` (DB `kimidev_et`, user `sql_kimidev_et`), the `kimiET-A` session name, and the app folder name `kimidev_ET` (repo uses `kimi_ET`).
3. **Live batch data must be preserved**: everything under `kimidev_ET/kimibatch/files/` (incl. the 2026-07 output) — do not `--delete` it on deploy.
4. The 25 DEV-only `modules/` files should be reviewed before deploy — confirm whether any are intentional dev customizations that must survive (none are recently dated, but they exist only on the server).

## Caveats

- DEV `kimidev_ET` is not a 1:1 copy of repo `kimi_ET` — same application, but a diverged variant: both are 2022–2023-era code, different instance ("A"), each with files the other lacks.
- **Method note:** divergence and file inventory come from `diff -rq` (content). "Which side is newer" is judged from in-code dated markers, NOT file mtimes — the rsync'd tree preserves the server's real mtimes while the repo tree carries git-checkout mtimes, so an mtime comparison is invalid for versioning.
- Comparison excludes the server's `kimi_DEV/` and `kimi/` sibling folders (the site root redirects to `kimidev_ET`, so that is the live app).
