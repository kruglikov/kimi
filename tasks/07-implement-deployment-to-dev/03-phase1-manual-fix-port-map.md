# Phase 1 — Manual-fix port map (dev tree vs `src/original-src`)

**Task:** `tasks/07-implement-deployment-to-dev/02-option1-execution-plan.md` — **Phase 1, substeps 1.1 and 1.2**. This file is the deliverable the plan's 1.1 refers to (it replaces the "append to `step1.2`" instruction by the user's choice of a dedicated file).

## Purpose

Our existing manual PHP 8.5 fixes were written against the original PROD baseline `src/original-src/web/htdocs/kimi_ET/` (upgraded into `src/upgraded-src/web/htdocs/kimi_ET/`). Option 1 deploys the **actual dev-server code** `src-dev/original-src/web/htdocs/kimidev_ET/`, which has diverged from that baseline. Before Phase 2 re-applies the upgrade to the dev tree, this map answers, per file: **where does the dev tree diverge from the baseline, and does any 8.5 fix land on a diverged line (so it must be adapted) or on untouched lines (so it ports cleanly)?**

## The three trees compared

- **A = baseline** `src/original-src/web/htdocs/kimi_ET/` — the code the manual 8.5 fixes were written against.
- **B = dev** `src-dev/original-src/web/htdocs/kimidev_ET/` — the deploy target (rsynced from the live dev server).
- **C = upgraded** `src/upgraded-src/web/htdocs/kimi_ET/` — baseline **plus** the 8.5 fixes (Rector + manual).

**Scope:** the 50 substantive differing files from Step 1.2 — 32 `kimibatch/*.php`, 15 `modules/gui/templates/tickets/*` (10 `.php` + 5 `.js`), and `getticketurl.php`, `testpost.php`, `libs/application.php`. Cosmetic-only (`?>`/whitespace) and environment-only (`session_name`, host, DB) files from Step 1.2 are intentionally excluded — they carry no logic to reconcile.

**Method:** a whitespace- and `?>`-ignoring (logic-only) three-way line diff via Python `difflib`. For each file we compute the set of **baseline (A) lines the dev tree changes** (`A→B`) and the set of **baseline lines the 8.5 upgrade changes** (`A→C`), then test whether those two sets **overlap**. Raw per-file `A→B` diffs are saved alongside this file in `tasks/07-implement-deployment-to-dev/03-phase1-field-diffs.txt`.

## Headline result

| Measure                                                                                 | Value |
|-----------------------------------------------------------------------------------------|---|
| Substantive differing files analysed                                                    | 50 (45 `.php` + 5 `.js`) |
| Files where the 8.5 upgrade changed nothing (`upg == orig`) → **no fix to port**        | **37 php + 5 js = 42** |
| Files with an 8.5 fix whose fix lands on **disjoint** lines → **fix ports cleanly**     | **8 php** |
| Files where a dev-divergent line **overlaps** an 8.5-fix line → **fix must be adapted** | **0** |
| Whole-tree 8.5 fix footprint (A→C, files changed)                                       | **75** — of which only **8** are also dev-divergent (all conflict-free); the other **67** are identical in dev and baseline, so those fixes port 1:1 trivially |

**Bottom line: no manual fix collides with a dev customization. The 8.5 fixes and the dev divergences occupy different regions of the code.**

## Why they do not collide

The 8.5 fixes are the expected PHP 8.5 **type-safety plumbing** — explicit casts and null-guards in utility/DB code. The dev divergences are **campaign business logic** — batch import/export SQL and the agent telephone UI. These never touch the same lines. Examples (baseline → upgraded fix):

- `kimibatch/telematica_import_callmanager_log.php`: `strtotime($this->end_time)` → `strtotime((string) $this->end_time)` (and the same on `connect_time`, `strpos((string) $value, (string) $search)`).
- `kimibatch/db.php`: `iconv("UTF-8", 'Windows-1252//TRANSLIT', $value)` → `iconv("UTF-8", 'Windows-1252//TRANSLIT', (string) $value)`.
- `getticketurl.php`: a new `fetchAssocOrFalse($result)` guard wrapping `mysqli_fetch_assoc` against a `false` result.

Whereas the dev divergences in the same files (where any) are elsewhere in the file — campaign SQL and layout — so the overlap set is empty.

## Result by file group

Columns: **devH** = number of divergent hunks dev-vs-baseline; **upgH** = number of 8.5-fix hunks baseline-vs-upgraded; **ovlp** = count of baseline lines changed by *both*.

### `kimibatch/*.php` (32) — 8 PORT-CLEAN, 24 NO-8.5-FIX

| File                                                              | devH   | upgH   | ovlp   | Verdict |
|-------------------------------------------------------------------|-------:|-------:|-------:|---|
| `kimibatch/coeo01_import_telefonie_taeglich.php`                  |     19 |      2 |      0 | PORT-CLEAN |
| `kimibatch/db.php`                                                |      2 |      1 |      0 | PORT-CLEAN |
| `kimibatch/inko2016imp3.php`                                      |      1 |      1 |      0 | PORT-CLEAN |
| `kimibatch/inkodeimp2.php`                                        |      1 |      1 |      0 | PORT-CLEAN |
| `kimibatch/okoexp.php`                                            |      1 |      5 |      0 | PORT-CLEAN |
| `kimibatch/telematica_import_callmanager_log.php`                 |     10 |      6 |      0 | PORT-CLEAN |
| `kimibatch/okoimp.php`                                            |     30 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/knp1check.php`                                         |      9 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/kimibatchtree.php`                                     |      7 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/inkodeexp.php`                                         |      7 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/knp1schnupd.php`                                       |      5 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/inko2016exp.php`                                       |      4 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/inboundoutboundrep.php`                                |      3 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/inko201605_daten_email_fuer_elsbeth_import.php`        |      3 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/coeo02_tagl_daten_fuer_elsbeth_*` (12 import variants) | 1 each |      0 |      0 | NO-8.5-FIX |
| `kimibatch/inko201603_verarbeitung_elsbeth_out.php`               |      1 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/inkode03_verarbeitung_elsbeth_out.php`                 |      1 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/oko03_verarbeitung_elsbeth_out.php`                    |      1 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/schlaustrom01_daten_inA_fuer_elsbeth_import.php`       |      1 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/schlaustrom01SONDER_daten_inA_fuer_elsbeth_import.php` |      1 |      0 |      0 | NO-8.5-FIX |
| `kimibatch/schlaustrom02_daten_off_fuer_elsbeth_import.php`       |      1 |      0 |      0 | NO-8.5-FIX |

### `modules/gui/templates/tickets/*.php` (10) — all NO-8.5-FIX

| File                                                    | devH | upgH | ovlp | Verdict |
|---------------------------------------------------------|---:|---:|---:|---|
| `modules/gui/templates/tickets/19/ticket.php`           | 40 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/19/ticketuebersicht.php` | 14 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/19/ticketsuch.php`       | 7 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/34/ticket.php`           | 7 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/10/ticketuebersicht.php` | 4 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/16/ticketuebersicht.php` | 4 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/8/ticket.php`            | 4 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/10/ticket.php`           | 3 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/16/ticket.php`           | 3 | 0 | 0 | NO-8.5-FIX |
| `modules/gui/templates/tickets/16/ticketsuch.php`       | 1 | 0 | 0 | NO-8.5-FIX |

### Entrypoints / libs (3) — 2 PORT-CLEAN, 1 NO-8.5-FIX

| File                   | devH | upgH | ovlp | Verdict |
|------------------------|---:|---:|---:|---|
| `getticketurl.php`     | 2 | 4 | 0 | PORT-CLEAN |
| `libs/application.php` | 1 | 1 | 0 | PORT-CLEAN |
| `testpost.php`         | 7 | 0 | 0 | NO-8.5-FIX |

### `modules/gui/templates/tickets/*.js` (5) — feature context only, not a PHP 8.5 fix target

`tickets/19/ticketoptimize.js` (12), `tickets/19/ticketvalidate.js` (7), `tickets/16/ticketvalidate.js` (6), `tickets/10/ticketvalidate.js` (4), `tickets/34/ticketvalidate.js` (1) — all NO-8.5-FIX. These are client-side click-to-call/validation scripts; they carry no PHP and are listed only because they are part of the diverged telephone feature to preserve.

## Dev functional divergences to PRESERVE (unrelated to the 8.5 upgrade)

These are the real dev customizations that Phase 2/3 must **not** clobber by re-applying the baseline. None are 8.5 concerns.

- **`kimibatch/okoimp.php` (30 hunks)** — the largest divergence. The dev tree keeps `telnr3`/`telnr4` **deactivated** (`null`) and uses a **shorter `INSERT INTO oko (...)` column list** (no `telnr3, telnr4, telefon3plus`), whereas the baseline **activated** them (comment `2023-07-19 tele3 und tele4 aktiviert`). This changes what the OKO import writes — a campaign decision that must be preserved as-is on the dev tree.
- **`modules/gui/templates/tickets/19/ticket.php` (40 hunks)** and the other `tickets/{8,10,16,34}` screens — the dev tree uses a **simpler telephone layout** (`Mobiltelefon` / `Telefon` / `telefon2`) and **omits** the baseline's richer `CONNECT`/`dummy_text3` click-to-call fields. This is the exact agent-facing telephone/ONCLICK-call area Franz is actively changing, so it must be reconciled against Franz's current requirement, never overwritten from the baseline.
- The `coeo02_*` import variants, `schlaustrom*`, `inko*`, `knp1*` scripts (1–9 hunks each) — per-campaign SQL/flag differences (which rows are read, `exportQueryToCSV(..., true/false)`, etc.). Preserve the dev variant.

## Porting guidance for Phase 2.4

1. **The 8.5 fix ports to the dev tree with no conflict.** Every differing file falls into "no fix here" (42) or "fix on disjoint lines" (8); nothing needs hand-merging into a diverged line.
2. **Re-run Rector fresh on the dev tree (Phase 2.3).** Rector regenerates the `(string)` casts directly on the dev files, so most of the 75-file upgrade footprint reproduces automatically. The **manual** (non-Rector) fixes are the small guard set (e.g. `getticketurl.php`'s `fetchAssocOrFalse`); apply those on top, and — because `ovlp = 0` everywhere — they will not overwrite any dev customization.
3. **For the 42 NO-8.5-FIX differing files, do nothing upgrade-related** — there is no fix to carry. Just ensure the deploy preserves the dev version (the divergences listed above), which the git-pull deploy already does since these files simply stay as they are on the dev tree.
4. **Re-verify after Rector.** After the Phase 2.3 Rector apply on the dev tree, re-diff the 8 PORT-CLEAN files against this map to confirm the regenerated casts still sit on the same disjoint lines (a cheap sanity check, expected to hold).

## Step 1.2 — No DB migration (confirmed)

The upgrade is **code-only**. Every 8.5 fix inspected is pure PHP type-safety — `(string)` casts, `mysqli_fetch_assoc` false-guards, `iconv` argument casts — with **no DDL and no data change**. The dev database `kimidev_et` (in the local `src-dev` stack and on the dev server) is the authoritative, current schema and **stays as-is**; the dev code already matches it. The 2.7 GB dump `src-dev-db-dumps/kimidev_et_20260812_1631.sql.gz` is retained only as a rollback backup. No schema migration is part of this deployment.

## Method notes & caveats

- **`upgH` counts the full A→C delta (Rector + manual together).** That makes the verdicts conservative: `NO-8.5-FIX` means *neither* Rector nor manual touched the file (nothing to port); `PORT-CLEAN` means the *entire* upgrade delta is disjoint from the dev divergence, so the manual-only subset is certainly disjoint too. A precise Rector-vs-manual split is not needed for the port decision and is deferred to the Phase 2.2 Rector dry-run.
- Comparison is **logic-only** (all whitespace and lone `?>` close-tags ignored), matching how Step 1.2 classified cosmetic vs substantive files.
- The `.js` files are included for feature completeness but are not PHP 8.5 fix targets.
- Raw per-file `dev-vs-baseline` diffs backing this table: `tasks/07-implement-deployment-to-dev/03-phase1-field-diffs.txt`.

## Exit criteria (Phase 1)

- **1.1** — per-file map of which manual fixes apply/adapt: **done** — 8 apply cleanly, 0 need adaptation, 42 have no fix to port.
- **1.2** — confirmed the upgrade is code-only (no schema change): **done**.
