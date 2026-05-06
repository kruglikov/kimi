# PHP 8.5 Smoke Follow-up Investigation - 2026-05-06

## Scope

This note answers three follow-up questions from the PHP 8.5 smoke comparison:

1. why the new batch-script failures did not appear in the earlier runs
2. whether the `getticketurl.php` error on `mandant.clid_name` can be solved by updating the DB schema or stubs
3. what the exact failure is in `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`

## 1. Why the new batch-script failures did not appear earlier

### Short answer

The main reason is not a generic PHP 8.5 warning level change.

The important change is MySQLi error handling:

- since PHP 8.1, the default MySQLi report mode is `MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT`
- before PHP 8.1, the default was `MYSQLI_REPORT_OFF`

That means many SQL problems that previously only returned `false` now throw `mysqli_sql_exception` and abort the script.

Official PHP reference:

- `https://www.php.net/manual/en/mysqli-driver.report-mode.php`

### What that means for this project

Many batch scripts in `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/` still use patterns like:

- `mysqli_query(...)`
- then later assume success
- no surrounding `try/catch`
- no explicit `mysqli_report(MYSQLI_REPORT_OFF)`

Under the earlier PHP 8.0 runtime used in the upgraded smoke work:

- failing SQL often returned `false`
- the script could continue or fail more softly
- the smoke harness sometimes saw a zero exit or at least a later failure path

Under PHP 8.5:

- the same failing SQL now throws immediately
- the script exits with a fatal uncaught `mysqli_sql_exception`
- the smoke test now records a hard failure

### Why the specific new batch failures appeared

The newly surfaced batch failures are mostly not new application bugs created by PHP 8.5. They are old environmental or SQL assumptions that PHP 8.5 now surfaces more aggressively.

Observed categories:

1. `LOAD DATA LOCAL INFILE` points to missing import files
   - examples:
     - `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeo03_verarbeitung_elsbeth_out.php`
     - `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeoch03_verarbeitung_elsbeth_out.php`
     - `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/coeodrei03_verarbeitung_elsbeth_out.php`
     - `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inko201603_verarbeitung_elsbeth_out.php`
     - `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/inkode03_verarbeitung_elsbeth_out.php`
     - `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/oko03_verarbeitung_elsbeth_out.php`

2. scratch/support tables assumed by the scripts are missing from the current smoke DB fixture
   - examples:
     - `inko2016_duplet`
     - `inkode_duplet`
     - `okomehrfach`

3. genuine SQL bugs still remain
   - example:
     - `src/upgraded-src/web/htdocs/kimi_ET/kimibatch/okoexpzwb.php`
     - insert column-count mismatch

### Conclusion for the batch group

So the answer is:

- not mainly "different PHP warning levels"
- mainly "mysqli errors are exceptions now"

That is why these failures were mostly hidden earlier and now appear as hard smoke failures on PHP 8.5.

## 2. `getticketurl.php` and `Unknown column 'clid_name'`

### What I checked

I inspected:

- `src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php`
- `src/original-src/web/htdocs/kimi_ET/getticketurl.php`
- `src/upgraded-src/docker/mariadb/init/02-schema.sql`
- `src/original-src/docker/mariadb/init/02-schema.sql`
- repo-wide references to `clid_name`

### What the code does

`src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php:53` runs:

```php
select id, text, getCleanPhoneNoN('$phoneNo', '', false) phoneNo
from mandant
where clid_name = '$queueName'
```

### What the schema contains

The local schema for `mandant` in:

- `src/upgraded-src/docker/mariadb/init/02-schema.sql:65`

does **not** define `clid_name`.

The same is true in the original init schema:

- `src/original-src/docker/mariadb/init/02-schema.sql:65`

### What that means

This is not a Rector issue and not really a PHP 8.5 logic change.

It is a schema/application mismatch that PHP 8.5 now exposes more aggressively because the bad query throws immediately.

### Can this be fixed by updating the schema/stub?

Yes, for the smoke environment, **probably yes**.

But there is an important distinction:

#### Option A: smoke-environment compatibility fix

Add a nullable `clid_name` column to the local `mandant` table stub and seed it with the smoke queue name.

Why this is plausible:

- the application code explicitly expects that column
- the smoke scenario uses `telefonGruppe = 'SMOKE-GROUP'`
- adding the column would unblock the query path in the local test environment

Risk:

- there is no evidence elsewhere in this repo that `clid_name` is part of the canonical schema
- so this would be a test-environment compatibility patch, not yet a confirmed production-schema truth

#### Option B: application-level correction

Change `src/upgraded-src/web/htdocs/kimi_ET/getticketurl.php` so it looks up the queue/group through the actually modeled telephony field or a different entity relation.

Why this may be more correct:

- the repo schema does include telephony-related data such as `kampagne.iptel_destclid`
- there are no repo references defining `mandant.clid_name`

Risk:

- without production schema or domain confirmation, we cannot safely infer the intended replacement field

### Best current assessment

For the smoke suite specifically:

- yes, this can likely be fixed in the DB schema/stub layer

For the actual application model:

- it is still uncertain whether `mandant.clid_name` is the real intended production column or whether the code is stale

## 3. Exact failure in `setticketcallinfo.php`

### How it was investigated

I inspected:

- `src/upgraded-src/tests/harness/top_level_runner.php`
- `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`
- `src/upgraded-src/docker/mariadb/init/06-batch-stubs.sql`

Then I reproduced the smoke scenario in the web container with the same effective conditions as the harness:

- working directory inside `kimi_ET`
- empty `$_POST`
- `REQUEST_METHOD=POST`
- `CONTENT_TYPE=application/json`

I wrapped the include in a catch block to capture the hidden exception text.

### Exact failure

The current PHP 8.5 failure is:

```text
mysqli_sql_exception: You have an error in your SQL syntax; check the manual
that corresponds to your MariaDB server version for the right syntax to use
near ' '', '',  '', , 0, 0, 0)' at line 1
in /var/www/html/kimi_ET/setticketcallinfo.php:222
```

Call path:

- `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php:222`
- then from:
  - `Request->insert_callmanager(...)`

### Why it happens

The smoke harness for `setticketcallinfo.php` does not provide a JSON body. That means all request fields stay empty.

In `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php`, the insert SQL is assembled with unquoted numeric-style fields:

- `$this->ticket_reference`
- `$this->id`
- `$this->mandantId`
- `$this->ticketId`
- `$this->dauer_sec`

Relevant SQL construction is at:

- `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php:211`

The problem is that `ticket_reference` and `id` are interpolated without quotes:

```php
"'$this->client_reference', '$this->project_reference', $this->ticket_reference, '$this->action_url', '$this->pickup_user_id',  ".
"'$this->outgoing_number', $this->id, $this->mandantId, $this->ticketId, $this->dauer_sec)"
```

When `ticket_reference` and `id` are empty strings, the generated SQL contains empty bare values like:

```sql
..., '', '',  '', , 0, 0, 0)
```

That is invalid SQL syntax.

### Why this passed before and now fails

Under the earlier runtime behavior:

- `mysqli_query()` on invalid SQL returned `false`
- the code then set an error message and returned JSON with `success=false`
- the smoke harness only cared about non-zero exit status, so this could still pass

Under PHP 8.5 / current MySQLi default mode:

- `mysqli_query()` throws `mysqli_sql_exception`
- there is no catch block
- the script exits `255`
- the smoke test now fails

### Practical fix direction

This looks fixable in code, not in schema.

Low-risk directions:

1. quote or normalize `ticket_reference` and `id` before building SQL
2. cast numeric fields explicitly with safe defaults
3. ideally move the insert to a prepared statement
4. for smoke robustness, reject empty/invalid request payload before attempting the insert

## Final Assessment

### Batch failures

Mostly newly visible because PHP 8.5 now throws MySQLi exceptions by default, exposing old file/schema/SQL problems.

### `getticketurl.php`

Likely fixable in the DB smoke schema/stubs, but that would be a compatibility patch unless the intended production column is confirmed.

### `setticketcallinfo.php`

Confirmed root cause:

- invalid SQL generated from empty unquoted fields in the insert statement
- exact failure captured at `src/upgraded-src/web/htdocs/kimi_ET/setticketcallinfo.php:222`
