# Batch Smoke Test Failure Investigation

Date: 2026-05-04  
Run command: `src/original-src/tests/run-batch.sh`  
Result: **Tests: 115, Assertions: 303, Failures: 43**

---

## Summary

43 of 115 batch smoke tests fail. All failures trace to **real script/runtime issues** — DB connectivity and vendor-path issues were resolved in a prior session (see `memory-bank/batch-docker-compatibility.md`).

The 43 failures split into **5 distinct root-cause categories** with one hybrid overlap.

---

## Category 1 — Missing campaign temp/check tables (~30 failures)

**Root cause:** Check and export scripts attempt to `TRUNCATE` per-campaign temp tables before use. These tables were never created in the Docker seed (`01-init.sql`), so `TRUNCATE` silently fails with an error string. Subsequent INSERT and SELECT against those tables also fail. The final SELECT returns `false` (failed query), and `dbFetchArray(false)` throws a `TypeError` at:

```
/var/www/html/kimi_ET/kimibatch/kimi_general.php:485
Fatal error: Uncaught TypeError: mysqli_fetch_array(): Argument #1 ($result)
  must be of type mysqli_result, bool given
```

**Missing tables by campaign prefix:**

| Campaign   | Missing tables                                                                                            |
|------------|-----------------------------------------------------------------------------------------------------------|
| `knp1`     | knp1erledigt, knp1erreicht, knp1erreichtap, knp1unerreichbar, knp1telefonnummerfalsch                     |
| `knp3`     | knp3erledigt, knp3erreicht, knp3erreichtap, knp3unerreichbar, knp3telefonnummerfalsch                     |
| `knpdrei`  | knpdreierledigt, knpdreierreicht, knpdreierreichtap, knpdreiunerreichbar, knpdreitelefonnummerfalsch      |
| `inkode`   | inkodeerledigt, inkodeerreicht, inkodeerreichtap, inkodeunerreichbar, inkodetelefonnummerfalsch           |
| `inko2016` | inko2016erledigt, inko2016erreicht, inko2016erreichtap, inko2016unerreichbar, inko2016telefonnummerfalsch |
| `ifs`      | ifserledigt, ifserreicht, ifserreichtap, ifsunerreichbar, ifstelefonnummerfalsch                          |
| `oko`      | okoerledigt, okoerreicht, okounerreichbar, okotelefonnummerfalsch                                         |

**Affected failing scripts:**
- coeochcheck.php, coeochchecktest.php
- coeodreicheck.php, coeodreichecktest.php
- coeochdeexp.php, coeochdeexpx.php
- knp1check.php, knp1checktest.php
- inko2016check.php
- okocheck.php, okoexp.php, okoexp_dev.php, okoexp_ansi.php, okoexp_ansi2.php, okoexp_ansi-roni.php
- inkodeexp.php
- inko2016exp.php
- inkodeemail1ktoexp.php, inkodeemail2zvexp.php, inkodeemail3zwexp.php
- inko2016email1ktoexp.php, inko2016email2zvexp.php, inko2016email3zwexp.php
- inkosepaexp.php, inkodesepaexp.php, inko2016sepaexp.php
- schlaustromexp20190924.php, schlaustromexp20220703.php
- questerexp20250208.php
- kpis.php, kpiscsv.php, kpisemail.php

**Possible fix:** Add `CREATE TABLE IF NOT EXISTS` DDL for all 37 temp tables to the DB seed, or ensure batch scripts CREATE them before use. The latter would require source changes; the former is seed-only.

---

## Category 2 — Legacy `mysql_*` API (6 scripts, some overlap with Cat. 1)

**Root cause:** PHP 8.0 removed the `mysql_*` extension entirely. These scripts still use the old API.

| Script                                          | Line | Error                                            |
|-------------------------------------------------|------|--------------------------------------------------|
| `oko04_status_offen_auf_inA_setzen.php`         | 23   | `Call to undefined function mysql_fetch_array()` |
| `oko04_status_offen_vortage_auf_inA_setzen.php` | 23   | `Call to undefined function mysql_fetch_array()` |
| `inkode04_status_offen_auf_inA_setzen.php`      | 23   | `Call to undefined function mysql_fetch_array()` |
| `inko201604_status_offen_auf_inA_setzen.php`    | 23   | `Call to undefined function mysql_fetch_array()` |
| `schlaustromcheck.php`                          | 493  | `Call to undefined function mysql_error()`       |
| `inkodecheck.php`                               | 475  | `Call to undefined function mysql_error()`       |

Note: `schlaustromcheck.php` and `inkodecheck.php` also hit Category 1 missing-table errors earlier in their execution, so they have two independent failure points.

**Possible fix:** Replace `mysql_fetch_array()`→`mysqli_fetch_array($conn, ...)` and `mysql_error()`→`mysqli_error($conn)` in each script. Requires knowing the connection variable name at each call site.

---

## Category 3 — Missing main import tables + input CSV files (2 scripts)

**Root cause:** Two import scripts depend on tables and source files that were never created/seeded.

| Script                | Missing table(s)                             | Missing file         |
|-----------------------|----------------------------------------------|----------------------|
| `inkodeimp2.php:88`   | `kimi_et.inkode`, `kimi_et.inkodeurgenz`     | `files/INKODE.CSV`   |
| `inko2016imp3.php:76` | `kimi_et.inko2016`, `kimi_et.inko2016urgenz` | `files/INKO2016.CSV` |

These scripts fail at the file-read step before even reaching the DB, so the missing tables are secondary.

**Possible fix:** Add DDL for `inkode`, `inkodeurgenz`, `inko2016`, `inko2016urgenz` tables to seed; provide sample CSV files under `kimibatch/files/` for smoke-test purposes.

---

## Category 4 — Wrong `mysqli_error()` call signature (1 script)

**Root cause:** PHP 8.0 requires `mysqli_error($connection)` to receive the connection object. A call with 0 arguments throws:

```
inkodeschnupd.php:90
Fatal error: Uncaught ArgumentCountError: mysqli_error() expects exactly 1 argument, 0 given
```

**Possible fix:** Pass the active `$conn` / `$db` variable to `mysqli_error()` at line 90.

---

## Category 5 — Typo: undefined function `bFetchArray` (1 script)

**Root cause:** `inkodeimp2x.php:66` calls `bFetchArray()` — missing the `d` prefix. The correct function is `dbFetchArray()` defined in `kimi_general.php`.

```
Fatal error: Uncaught Error: Call to undefined function bFetchArray()
  in /var/www/html/kimi_ET/kimibatch/inkodeimp2x.php:66
```

**Possible fix:** Rename `bFetchArray(` to `dbFetchArray(` at line 66.

---

## Category 6 — Parse error (1 script)

**Root cause:** `coeochdeexptest.php` has a PHP syntax error on line 24:

```
Parse error: syntax error, unexpected identifier "status" in
  /var/www/html/kimi_ET/kimibatch/coeochdeexptest.php on line 24
```

**Possible fix:** Inspect line 24; likely a reserved-word collision (`status` became reserved in PHP 7+) or a missing semicolon/operator before the identifier.

---

## Fix Priority Recommendation

| Priority | Category                             | Scripts affected | Effort                                                        |
|----------|--------------------------------------|------------------|---------------------------------------------------------------|
| High     | Cat. 1 – missing temp tables         | ~30              | Add 37 `CREATE TABLE IF NOT EXISTS` to seed (DB-only change)  |
| High     | Cat. 2 – legacy `mysql_*`            | 6                | PHP source edits (4 × `mysql_fetch_array`, 2 × `mysql_error`) |
| Medium   | Cat. 3 – missing import tables + CSV | 2                | DDL for 4 tables + stub CSV files                             |
| Low      | Cat. 4 – `mysqli_error()` args       | 1                | One-line PHP fix                                              |
| Low      | Cat. 5 – typo                        | 1                | One-character PHP fix                                         |
| Low      | Cat. 6 – parse error                 | 1                | PHP source fix at line 24                                     |

Fixing Category 1 alone (seed-only, no PHP changes) would resolve ~30 failures and bring the suite to roughly 13 failures or fewer.