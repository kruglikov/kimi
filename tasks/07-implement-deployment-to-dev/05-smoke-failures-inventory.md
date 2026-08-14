# Phase 2.5 — Smoke-failure inventory (dev tree, post-Rector, hermetic, seed=`system`)

Full classification of the **82 smoke failures** observed after Rector apply (2.3), the hermetic-net changes (2.4), and the harness seed-user fix (Step A). Suite total (at the time of this analysis): **214 tests, 132 pass, 82 fail**.

**Current status (2026-08-14): 133 pass / 51 skip / 30 fail.** Resolved groups are marked `[x]` in their heading and carry a **Resolution** note at the end of the section. §1 and §2 were quarantined in the smoke harness (skipped-with-reason); the §6 `subdetail.php` code fix is committed. §3, §4, §5, and §7 (except where noted) are still open — most are pre-existing/harness items with no owner action required.

## Provenance (important)

These failures are **pre-existing conditions in the dev code and data that the safety net *revealed*, not *created*** — **Rector caused none of them**. Evidence: the failure count was ~147 *before* Rector and 148 *after* (Rector only added `(string)` casts + one `: never`, adding zero failures); the jump in *passes* came entirely from the Step A harness seed-user fix, which let the GUI modules run far enough to surface latent issues. The 9 "missing" tables were verified **absent on the live dev server too** (server has the same 141 tables), so the large majority of these would fail identically on the server. See `04-rector-dry-run.txt` for the Rector footprint.

The only actionable PHP 8.5 code items are in **§6**; everything else is out-of-scope for the code upgrade.

---

## [x] §1 — "Table doesn't exist" — dead modules for an absent feature (44)

Nine tables in an **insurance/claims domain** that **do not exist locally or on the server** (confirmed: server also has exactly 141 tables — our import is complete). The modules querying them reference a feature set not deployed in this DB instance; they fail on the server identically.

| Missing table (`kimidev_et.<table>`)   | # failures |
|----------------------------------------|---:|
| `inkassostatus`                        | 8 |
| `schadensfall_art`                     | 8 |
| `bankleitzahl`                         | 4 |
| `inkassoinformation`                   | 4 |
| `kundenhistorie`                       | 4 |
| `lastschrift`                          | 4 |
| `stammdaten`                           | 4 |
| `status_schadensfall`                  | 4 |
| `versicherung`                         | 4 |

**Verdict:** not an 8.5 issue, not an import gap — dead modules referencing absent features. No action.

**Resolution — quarantined (2026-08-14).** Skipped in the smoke harness across `GuiSmokeTest`, `InitialSmokeTest`, `MenuSmokeTest`, and `RouterSmokeTest` via `Quarantine::ABSENT_FEATURE_MODULES` (`markTestSkipped`, shown as skipped-with-reason — not hidden). 44 test cases now skip (11 module basenames × 4 suites). No application code changed. Flagged to the client for a keep/remove decision in `06-found-problems-for-client.md`, Problem 1.

## [x] §2 — Legacy `mysql_*` removed API (7)

`mysql_query()` / `mysql_fetch_array()` — the `mysql_*` extension was **removed in PHP 7.0**, so these have been broken since long before 8.5 and are outside our 8.1–8.5 Rector scope.

- `kimibatch/inko201604_status_offen_auf_inA_setzen.php`
- `kimibatch/inkode04_status_offen_auf_inA_setzen.php`
- `kimibatch/inkodeexp_new.php`
- `kimibatch/oko04_status_offen_auf_inA_setzen.php`
- `kimibatch/oko04_status_offen_vortage_auf_inA_setzen.php`
- `kimibatch/oko_inA_outbound_elsbeth.php`
- `kimibatch/okoexpzwb.php`

**Verdict:** pre-existing legacy breakage (fails on server too). Decision needed only if any is an active job: migrate to `mysqli` or confirm dead and exclude.

**Resolution — quarantined (2026-08-14), pending client decision.** Skipped in `BatchSmokeTest` via `Quarantine::LEGACY_MYSQL_SCRIPTS` (7 scripts, `markTestSkipped` with a §2 reason). The scripts themselves are unchanged — the client keep/migrate/remove question is in `06-found-problems-for-client.md`, Problem 2. Each script is removed from the quarantine list once the client decides (migrating `mysql_*` → `mysqli_*` is a per-script revive-and-validate effort, not a bulk swap — see that document).

## §3 — Undefined custom helper `bFetchArray()` (1)

- `kimibatch/inkodeimp2x.php:66` — calls `bFetchArray()`, which is not defined (an `x` variant/experimental script).

**Verdict:** dead/variant script; not 8.5. No action unless confirmed active.

## §4 — `ArgumentCountError` `Ticket::count()` (2)

- Caller `modules/initial/ticketsuch_sich20150208.php:92` passes 2 args to `Ticket::count()` (defined in `libs/entities/ticket.php:2591`, expects 3). PHP 8.0+ turns a missing required arg into a fatal `ArgumentCountError` (was a warning in 7.x).
- The caller filename `_sich20150208` (= "Sicherung", a **2015-02-08 backup**) indicates a dead backup module.

**Verdict:** dead backup module; not our concern unless it proves reachable/active.

## §5 — Data / environment artifacts (9)

Failures driven by the **subset/sample data** and **missing batch input files**, not by code:

| Signature | # |
|---|---:|
| `Duplicate entry '…' for key 'PRIMARY' / 'ticketnr'` | 5 |
| `Can't find file '…/kimibatch/files//IN/OKO_ExportResult…' / '…INKO_Export…'` | 2 |
| `Data too long for column 'ergebnis'` | 1 |
| `SQL syntax error near 'TRIM(LEADING '0' FROM …)'` | 1 |

**Verdict:** re-run/state and missing-input-file artifacts of the local subset DB; not 8.5 code.

---

## [~] §6 — Genuine PHP null-safety issues exposed by real data (actionable — Step B)

These are the only failures worth a code change; both are real null handling in **active** modules that the synthetic dev-seed masked and real data exposed.

| Location                            | Error | Nature | Proposed action |
|-------------------------------------|---|---|---|
| `modules/initial/subdetail.php:127` | `count(): Argument #1 must be Countable\|array, null given` (2 failures) | **True PHP 8.0+ regression** — `Subkonto::get_all_for_subkonto()` returns `null`; `count(null)` throws. Not covered by our 8.1–8.5 Rector set (`count()` is a PHP 8.0 rule). | Minimal call-site guard: `count($subkonten ?? [])`. |
| `modules/gui/akt.php`               | `Call to a member function get_herkunft() on null` (1 failure) | Pre-existing null-method call (fatal on 7.x and 8.x alike), triggered when a related lookup returns `null` for the seeded ticket. May be a **smoke-data artifact** (seed `ticket_id=1` lacks a related row) rather than a real production path. | Investigate: confirm whether an active flow reaches `akt.php` with a null object before deciding to guard. |

**Resolution — `subdetail.php` fixed (2026-08-14); `akt.php` still open.** `modules/initial/subdetail.php` now guards the call site as `count($subkonten ?? [])` — committed to the `kimidev_ET` app repo as `e020fdd`; the `count(null)` failures are gone from the suite. `modules/gui/akt.php` (`get_herkunft()` on null) is **not yet resolved** — it still needs a quick check of whether an active flow can legitimately reach it with a null object (vs. a smoke-data artifact) before deciding whether to guard it.

## §7 — Harness / behavioral artifacts (not app bugs) (17)

- **7 × `libs/entities/role.php`** (RouterSmokeTest) — `session_name(): Session name cannot be changed after headers have already been sent`. This is a **harness ordering artifact**: `RouterSmokeTest` routes through the real `index.php` after the runner has already emitted output, so `session_name()` fires too late. Not an app regression (could be fixed in the harness if we want these green).
- **2 dead backup modules** — `modules/gui/ticket_201502071142.php` (`Undefined variable $prioritaet`) and `modules/gui/ticket_sich20150208.php` (`Undefined constant "TXT_LBL_VERKAEUFERNAME"`) — dated 2015 snapshots.
- **3 behavioral exits** — `setticketcallinfo.php`, `xhangup.php` (telephony endpoints that redirect/exit without a valid call context → non-zero exit, no fatal) and `adminer-4.8.1.php` (the bundled Adminer tool, Rector-skipped; non-zero exit is expected/accepted).
- **Warnings-only, tied to the above** — `modules/initial/kunde_details.php` (`Undefined variable $error`), `modules/initial/subuebersicht.php` (`Undefined variable $stammdaten`, which also queries the absent `stammdaten` table from §1), and `subdetail.php` "headers already sent" (a follow-on of its §6 `count(null)` fatal).

**Verdict:** test-scaffold ordering, dead backups, and expected telephony/tool behavior — not PHP 8.5 code defects.

---

## Reconciliation (all 82 accounted for)

| Section   | Category                                    | Count   |
|-----------|---------------------------------------------|--------:|
| §1        | Missing-table dead modules (absent feature) |      44 |
| §2        | Legacy `mysql_*` removed API                |       7 |
| §3        | Undefined `bFetchArray()`                   |       1 |
| §4        | `ArgumentCountError` (dead backup)          |       2 |
| §5        | Data / environment artifacts                |       9 |
| §6        | **Genuine null-safety (actionable)**        |       3 |
| §7        | Harness / behavioral artifacts              |      16 |
|           | **Total**                                   |  **82** |

*(§6 = 2 `subdetail` + 1 `akt.php`; §7 = 17 minus the 1 `akt.php` counted in §6.)*

**Net actionable for the 8.5 upgrade:** the `count(null)` fix in `modules/initial/subdetail.php:127`, and an investigation of `modules/gui/akt.php`. Everything else fails on the live server identically or is a test-harness artifact.

---

# Proposed resolutions

## Do we need to fix all of these? — No.

**The bar for "done."** This task is a **PHP 8.5 code migration of the dev tree**, and the dev **server already runs PHP 8.5** (ANEXIA upgraded the runtime; the old code runs there today). So the real acceptance test is: *does the upgraded dev tree run at least as well as the code already runs on the server?* Because **80 of the 82 failures also occur on the server** (same PHP 8.5, same database with the same absent tables) or are **test-harness artifacts**, they are **not regressions our upgrade introduced** — fixing them is optional scope, not a migration requirement.

**The second goal: a trustworthy green baseline.** A safety net is only useful if a green run means "nothing new is broken." Right now the 82 pre-existing failures drown out any *new* regression we might introduce later. So the valuable engineering move for most groups is not to *fix the code* but to **quarantine the known-pre-existing/dead/harness cases in the test harness** (never in the app), so that the suite reaches a clean baseline and any future red is a real signal — the same reason `src/upgraded-src` maintains its 216/0 baseline.

With that framing, here is the per-group analysis. "Quarantine" throughout means *add the entrypoint to a harness skip-list with a documented reason* — a test-infrastructure change only, with no edit to application code and no effect on what gets deployed.

## §1 — 44 × missing-table dead modules

**Is it our regression?** No. The nine tables (`inkassostatus`, `schadensfall_art`, `versicherung`, …) do not exist locally *or* on the server, so these modules fail identically in production today.

**Options.**
- *Do nothing to the code and leave them failing in the suite.* Honest, but keeps 44 red lines that permanently obscure the real signal.
- *Quarantine them in the harness* (skip-list the absent-feature modules with a note that they require tables not present in this DB instance). Test-infra only; yields a clean baseline; the modules on disk and on the server are untouched.
- *Ask the client whether the insurance/claims feature is supposed to exist here.* Only worthwhile if someone actually expects it — otherwise it is a question about a feature nobody has asked us to deliver.

**Recommendation:** **quarantine them.** They can never pass without tables that exist nowhere, so keeping them red adds no information; skipping them with a documented reason keeps the suite meaningful. Raise the "should this feature exist?" question with the client only if they bring it up.

## §2 — 7 × legacy `mysql_*` batch scripts

**Is it our regression?** No. The `mysql_*` extension was removed in **PHP 7.0**, so these scripts have been fatal on the server since long before the 8.5 work — and outside our 8.1–8.5 Rector scope.

**Options.**
- *Do nothing.* Defensible (pre-existing), but leaves genuinely broken batch jobs broken.
- *Confirm they are dead and quarantine/remove them.* If these jobs are not scheduled or invoked anywhere, they are dead weight; skip them in the suite now, and delete the files later under a client-approved cleanup.
- *Migrate `mysql_*` → `mysqli_*`.* Real code work, only justified if a job is **active and needed**. Note the strong signal that they are *not* active: if they were, they would have been failing on the client's PHP 8.5 server every run, and someone would have reported it.

**Recommendation:** **flag to the client/ops, do not fix blindly.** Ask "are these batch jobs still used? they have been broken on your server since the PHP 7.0 upgrade." If a job is confirmed active → migrate it to `mysqli`; if not → quarantine now and remove in cleanup. This is a business/ops decision, not a migration blocker.

## §3 — 1 × undefined `bFetchArray()` (`kimibatch/inkodeimp2x.php`)

**Is it our regression?** No. It calls a helper that is not defined; the `x` suffix marks it as an experimental/variant copy.

**Options.** *Ignore it* (it is almost certainly a dead variant); or *confirm it is dead and quarantine it*.

**Recommendation:** **quarantine** unless it turns out to be an active job — in which case it is really the same conversation as §2 (a broken legacy batch script for the client to keep or drop).

## §4 — 2 × `ArgumentCountError` in a 2015 backup module

**Is it our regression?** No. The caller `modules/initial/ticketsuch_sich20150208.php` is a dated **backup** (`_sich` = "Sicherung", 2015-02-08) that passes 2 arguments to `Ticket::count()` which requires 3 — a fatal since PHP 8.0.

**Options.** *Quarantine the backup module* in the suite; or, as a separate cleanup, *delete the dead backup file* (a deployable change, so it needs client sign-off — removing files from the server).

**Recommendation:** **quarantine now.** Treat file deletion as a distinct, later "remove dead/backup files" cleanup task with client approval, not as part of the 8.5 migration.

## §5 — 9 × data / environment artifacts

**Is it our regression?** No. `Duplicate entry`, `Data too long for 'ergebnis'`, `Can't find file '…/OKO_ExportResult'`, and one malformed-`TRIM` SQL are consequences of the **local subset data** and **missing batch input files**, not of the code. On the server, with full data and the real input files present, these paths behave differently.

**Options.** *Accept them as local-test-data noise*; or *invest in richer local fixtures* (load fuller data, stage the expected input files) so the suite exercises these paths cleanly.

**Recommendation:** **accept for now** and note them as local-data artifacts. Improving the local fixtures is a nice-to-have for suite fidelity, not something the migration needs.

## §6 — 3 × genuine null-safety issues (the only real code work)

**Is it our regression?** Partially — these are real PHP-8-era null-handling issues in **active** modules that the synthetic dev-seed masked and real data exposed.

- **`modules/initial/subdetail.php:127` — `count(null)` (2 failures).** A true PHP 8.0+ behavioral change: `Subkonto::get_all_for_subkonto()` can return `null`, and `count(null)` throws a `TypeError` (it was a silent warning on 7.x). Rector did not catch it because `count()` handling lives in the PHP 8.0 rule set, which our 8.1–8.5 configuration deliberately excludes.
  - *Options:* the minimal call-site guard `count($subkonten ?? [])`; or add `CountOnNullRector` to `src-dev/tooling/php-upgrade/rector.php` and re-run to catch every `count(null)` site tree-wide (more systematic, but broadens the reviewed Rector footprint).
  - *Recommendation:* apply the **minimal call-site guard** — real data only exposed this one site, so a one-line fix is proportionate; keep the tree-wide Rector rule in reserve if more `count(null)` sites appear.
- **`modules/gui/akt.php` — `get_herkunft()` on `null` (1 failure).** A null-method call (fatal on 7.x and 8.x alike), triggered when a related lookup returns `null` for the seeded ticket. It may be a **smoke-data artifact** (the seed `ticket_id=1` happens to lack a related row that real tickets always have) rather than a reachable production path.
  - *Options:* investigate first, then guard only if it is a real path; or defensively guard it regardless.
  - *Recommendation:* **investigate first** (a few minutes). Guard it only if an active flow can legitimately reach `akt.php` with a null object; if it is purely a seed-data gap, leave the code and note it.

## §7 — 16 × harness / behavioral artifacts

**Is it our regression?** No — these are test-scaffold ordering and expected tool/telephony behavior, not application defects.

- **7 × `libs/entities/role.php` (`session_name()` after headers).** `RouterSmokeTest` routes through the real `index.php` *after* the runner has already emitted output, so `session_name()` fires too late and every router test fails on the warning. This means the router suite currently tests *nothing useful*.
  - *Options:* leave it (not an app bug); or **fix the harness ordering** so `session_name()` runs before any output.
  - *Recommendation:* **fix the harness.** Beyond turning 7 reds green, it makes `RouterSmokeTest` genuinely exercise routing — real added coverage, test-infra only.
- **2 dead backup modules** (`modules/gui/ticket_201502071142.php`, `modules/gui/ticket_sich20150208.php`) and **3 behavioral exits** (`setticketcallinfo.php`, `xhangup.php` telephony redirects; `adminer-4.8.1.php`, the bundled tool Rector already skips).
  - *Recommendation:* **quarantine** the backups and `adminer`; the telephony endpoints exit/redirect by design when called without a call context, so classify them as expected behavior rather than failures.

## Concrete plan I propose

1. **Fix the one genuine regression** — `modules/initial/subdetail.php:127` → `count($subkonten ?? [])`. Small, safe, real 8.5 improvement (Phase 2.5, Step B).
2. **Investigate `modules/gui/akt.php`** — confirm real path vs smoke-data artifact; guard only if real.
3. **Quarantine the pre-existing/dead cases** (§1, §3, §4, and the backups/`adminer` in §7) via a documented harness skip-list — test-infra only, no app-code edit, no deployment impact — so the suite reaches a clean, trustworthy baseline.
4. **Fix the `RouterSmokeTest` session ordering** (§7) so the 7 `role.php` tests actually exercise routing. Test-infra only.
5. **Flag to the client** (do not fix blindly): the §2 `mysql_*` batch jobs and the §4 backup — "these have been broken on your PHP 8.5 server since the 7.0 upgrade; are they still used? migrate or remove?" A business/ops decision.

## What I would explicitly not do

Rewrite or migrate the legacy `mysql_*` scripts on spec, delete dead modules as part of this task, or build the absent insurance/claims feature. All three are scope-creep beyond "make the code run on 8.5," and all three already fail on the client's server today.

## Net

Genuine application-code work is **one fix + one investigation** (§6). Everything else is **quarantine (test-infra), accept as local-data noise, or flag to the client** — none of it is a blocker for deploying the 8.5-upgraded dev tree.
