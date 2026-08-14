# Pre-existing issues found during the PHP 8.5 upgrade — for client review

While upgrading the dev code to PHP 8.5 and running our runtime safety-net (smoke) tests against the real dev database, we found several issues that are **pre-existing** — they are present in the current code and database and are **not introduced by the upgrade**. We confirmed they fail identically on the current dev server (same PHP 8.5, same database), so they are independent of our migration work.

The items below need a **decision from you** (they concern whether certain features/scripts are still in use). The genuine PHP 8.5 code issues that are our responsibility are being fixed as part of the upgrade and are not listed here, because they need no action from you.

---

## Problem 1 — Modules that query database tables which do not exist

A set of modules fail because they query tables that are **absent from the `kimidev_et` database** — both in our local copy and on the dev server (we verified the server has exactly the same 141 tables, so nothing is missing from our side). These modules appear to belong to an **insurance / claims** feature set (Versicherung / Schadensfall) that is not provisioned in this database instance. Any screen or job that opens one of these modules currently errors with `Table 'kimidev_et.<name>' doesn't exist`.

**The 9 database tables that do not exist (and are referenced by the code):**

| # | Missing table         |
|---|-----------------------|
| 1 | `bankleitzahl`        |
| 2 | `inkassoinformation`  |
| 3 | `inkassostatus`       |
| 4 | `kundenhistorie`      |
| 5 | `lastschrift`         |
| 6 | `schadensfall_art`    |
| 7 | `stammdaten`          |
| 8 | `status_schadensfall` |
| 9 | `versicherung`        |

**The module files that reference those tables** — each of the following exists in **three** module sets (`modules/gui/`, `modules/initial/`, and `modules/menu/`), i.e. ~33 files in total:

| # | Module file (present in `modules/gui/`, `modules/initial/`, `modules/menu/`)   | Missing table(s) it queries   |
|---|--------------------------------------------------------------------------------|-------------------------------|
| 1 | `bankleitzahl.php`                                                             | `bankleitzahl`                |
| 2 | `buchungen.php`                                                                | `inkassostatus`               |
| 3 | `inkassoinformation.php`                                                       | `inkassoinformation`          |
| 4 | `kundenhistorie.php`                                                           | `kundenhistorie`              |
| 5 | `lastschrift.php`                                                              | `lastschrift`                 |
| 6 | `schadensfall.php`                                                             | `schadensfall_art`            |
| 7 | `schadensfall_art.php`                                                         | `schadensfall_art`            |
| 8 | `stammdaten.php`                                                               | `inkassostatus`               |
| 9 | `stammsuche.php`                                                               | `stammdaten`                  |
| 10 | `status_schadensfall.php`                                                      | `status_schadensfall`         |
| 11 | `versicherung.php`                                                             | `versicherung`                |

**Question for you:** Is this insurance/claims feature supposed to exist in this environment (i.e. are these tables missing and should be created/imported), or are these modules **obsolete/dead** and safe to ignore or remove?

---

## Problem 2 — Batch scripts using a database API removed in PHP 7.0

7 batch scripts use the old `mysql_*` functions (`mysql_query()` / `mysql_fetch_array()`), which were **removed from PHP in version 7.0**. This means these scripts have already been failing on the current PHP 8.5 dev server, independently of our upgrade. In practice this is a **strong signal that they are no longer in active use**: a scheduled job that fataled on every run would have surfaced as a visible failure long ago — so if any one of them is still expected to run, that itself is worth flagging.

| # | Batch script (`kimibatch/`)                     |
|---|-------------------------------------------------|
| 1 | `inko201604_status_offen_auf_inA_setzen.php`    |
| 2 | `inkode04_status_offen_auf_inA_setzen.php`      |
| 3 | `inkodeexp_new.php`                             |
| 4 | `oko04_status_offen_auf_inA_setzen.php`         |
| 5 | `oko04_status_offen_vortage_auf_inA_setzen.php` |
| 6 | `oko_inA_outbound_elsbeth.php`                  |
| 7 | `okoexpzwb.php`                                 |

**Question for you:** Are these batch jobs still in use? If **yes**, we can modernize them — but note this is a genuine **rewrite-and-test** effort, not a one-line swap: the newer `mysqli_*` API requires the database connection to be passed explicitly, and because these scripts have been broken for years there is no working baseline to compare the result against, so each one has to be re-read, corrected, and validated (especially the ones that *write* data). If **no**, they can simply be removed.

---

## Problem 3 — Old backup / variant copies of modules

A few dated backup or experimental copies of files error on load. They look like leftovers rather than active code.

| # | File                                          | Issue |
|---|-----------------------------------------------|-------|
| 1 | `modules/gui/ticket_201502071142.php`         | dated backup (2015-02-07), undefined variable |
| 2 | `modules/gui/ticket_sich20150208.php`         | dated backup ("Sicherung" 2015-02-08), undefined language constant |
| 3 | `modules/initial/ticketsuch_sich20150208.php` | dated backup (2015-02-08), calls `Ticket::count()` with the wrong number of arguments |
| 4 | `kimibatch/inkodeimp2x.php`                   | experimental variant (`…2x`), calls an undefined helper `bFetchArray()` |

**Question for you:** Can these backup/variant files be removed?

---

## Not requiring your action (for context only)

- **Local test-data artifacts** — a small number of failures (`Duplicate entry`, `Data too long`, `Can't find file …`) are caused by our **local subset of the database** and missing local batch input files, not by the code. They do not occur on the server with the full data.
- **Genuine PHP 8.5 code fixes** — issues that are truly part of the 8.5 migration (e.g. a `count(null)` case) are being handled by us and need no input from you.

*Full internal analysis with counts and evidence: `tasks/07-implement-deployment-to-dev/05-smoke-failures-inventory.md`.*
