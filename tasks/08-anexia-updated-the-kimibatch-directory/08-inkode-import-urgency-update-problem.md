# INKODE import — the "Urgenz" update fails and no INFO field is written

Status on 2026-10-05: the import **no longer crashes** — that part is fixed and deployed as commit `c88d4b8`. What is described below is the remaining problem: one statement inside the import still fails, so a group of tickets never receives its INFO text. The import now says so on screen instead of stopping silently.

## Which file has the problem

The batch import script **`kimibatch/inkodeimp2.php`** — in the repository at `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/inkodeimp2.php`, on the dev server at `/home/kimiportaldev.at/web/htdocs/kimidev_ET/kimibatch/inkodeimp2.php`, reachable in a browser as `https://10.196.69.21/kimidev_ET/kimibatch/inkodeimp2.php` and listed in the batch overview `https://10.196.69.21/kimidev_ET/kimibatch/kimibatchtree.php` under the INKODE branch as **"IMPORT INKODE-Daten"**.

The failing statement is at `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/inkodeimp2.php:340-345`.

## What the failing statement is for

INKODE (client `mandant_id = 24`) has debtors who hold **more than one case** at the same time. For each such debtor the import builds a summary of **all** of that person's cases — one line per case, newest first, in the form `Beginn: <start date> Index:<INKODE file reference> - Ticket:<case number> - <result of the last call>`. The summary is written into the column `kimidev_et.ticket.dummy_text10` of that debtor's **newest** case, which the portal shows to the agent as the green **INFO** textarea on the ticket screen. The purpose is that an agent opening one case immediately sees every other case the same person has, and what was last agreed on each of them.

The summary is assembled in the working table `kimidev_et.inkodeurgenz`, which the import empties and rebuilds on every run. One row of `kimidev_et.inkodeurgenz` equals one debtor with several cases.

## When exactly the problem happens

The problem occurs at the **second-to-last step** of the import, the step the page announces as `INKODE IMPORT - update ticket join inkourgenz`. By that point the tickets themselves have already been imported successfully, at `/home/viktar/Projects/kimi-plus.at/src-dev/original-src/web/htdocs/kimidev_ET/kimibatch/inkodeimp2.php:220`.

It happens **whenever at least one debtor's generated summary is longer than 4000 characters**, because the target column `kimidev_et.ticket.dummy_text10` is of type `varchar(4000)` while the source column `kimidev_et.inkodeurgenz.urgenztext` is of type `text` and has no such limit. MariaDB then rejects the statement with `Data too long for column 'dummy_text10' at row 1`.

The length of a summary grows with the number of cases the debtor has. Measured on the dev database on 2026-10-05: **30 debtors** have more than one case, **29 of them have between 2 and 4 cases** and summaries of 137 to 501 characters, and **one debtor has 64 cases** and a summary of **6030 characters**. That single debtor is what makes the statement fail.

Because the import performs this as **one single UPDATE covering all 30 debtors at once**, the database rejects the whole statement rather than the one offending row. The consequence is therefore not limited to the one debtor: **none of the 30 debtors receives an updated INFO field**, on every run, for as long as the condition lasts.

## How to reproduce it in the browser

**Before you start, two warnings.** First, running the import **writes to the database** — it imports the tickets from the current INKODE input file. Do not run it unless an import is intended. Second, the read-only check in step 1 tells you in advance whether the problem will occur, so the import itself does not have to be run merely to observe it.

**Step 1 — check, without changing anything, whether the condition is present.** Run this query against the database `kimidev_et`:

```sql
SELECT COUNT(*) AS debtors,
       MAX(LENGTH(urgenztext)) AS longest_summary
FROM inkodeurgenz;
```

If `longest_summary` is greater than 4000, the next import **will** hit the problem. On 2026-10-05 the result was 30 debtors and a longest summary of 6030 characters.

**Step 2 — connect.** Bring up the FortiClient VPN and open `https://10.196.69.21/kimidev_ET/login.php` in the browser. The dev server presents a self-signed certificate, so the browser will ask for a security exception the first time; accept it. Log in and select any client.

**Step 3 — open the batch overview.** Go to `https://10.196.69.21/kimidev_ET/kimibatch/kimibatchtree.php` and open the **INKODE** branch by clicking its arrow.

**Step 4 — start the import.** Click **"IMPORT INKODE-Daten"**, which opens `https://10.196.69.21/kimidev_ET/kimibatch/inkodeimp2.php`. The page prints its progress step by step.

**Step 5 — read the result.** Scroll to the step headed `INKODE IMPORT - update ticket join inkourgenz`. Instead of the success line `UPDATE TICKET URGENZ durchgeführt` the page prints:

```
UPDATE TICKET URGENZ: Data too long for column 'dummy_text10' at row 1
```

The page then continues normally through `Prüfung URGENZ`, `Prüfung OFFENE EINGESPIELT` and the closing line `INKODE IMPORT - Ende`, with its timestamp.

**Step 6 — confirm what was skipped.** The error message names the database fault but neither the debtor nor the number of records affected. To see what was actually skipped, compare the summaries against what reached the tickets:

```sql
SELECT u.ticketnr,
       LENGTH(u.urgenztext)                      AS summary_length,
       LENGTH(COALESCE(t.dummy_text10, ''))      AS info_field_length
FROM inkodeurgenz u
JOIN ticket t
  ON t.ticketnr = u.ticketnr AND t.mandant_id = u.mandant_id
ORDER BY summary_length DESC;
```

Every row will show an `info_field_length` that does not match its `summary_length`, which is the evidence that no debtor's INFO field was updated.

**What it looked like before the fix of 2026-10-05.** Up to commit `c88d4b8` the page did **not** print the error and did **not** continue: it simply stopped in the middle of step 5, with no `INKODE IMPORT - Ende` and no closing record counts, which is what made the import look as though it had silently lost records.

## Why the text cannot simply be cut at 4000 characters

The obvious repair — writing only the first 4000 characters — was examined against the real data and rejected. The summary lines are ordered **newest case first**. In the 64-case summary the newest entries are mostly cases on which nobody has been reached yet, so their result field is empty; of the 64 lines, **39 have an empty result and only 25 carry content**. Cutting at 4000 characters keeps the first 46 lines and discards the last 18 — and those 18 are the oldest, which are the ones holding the agreements. The discarded block includes, on case `5508`, the entry *"Frau Toene möchte 6 Raten mit 63€ ab 01.01.2023 mit SEPA einzahlen"* — a payment arrangement. Cutting at 4000 would therefore keep the empty lines and throw away the payment agreements.

## The options, and the question that decides between them

1. **Widen the column** `kimidev_et.ticket.dummy_text10` from `varchar(4000)` to `text`. Nothing is lost, it matches the type of the source column, and `text` is stored outside the row so the `ticket` row actually becomes smaller. This is the correct long-term fix, because the summaries grow as cases accumulate and any fixed limit will be reached again. It requires a schema change by the hosting provider.

2. **List only the cases that carry a call result.** For the 64-case debtor that is 25 lines and **3321 characters**, which fits the existing `varchar(4000)`, and all 30 debtors would fit. No schema change is needed. The cost is that a case on which nobody has been reached yet would no longer appear in the summary at all, so the agent would not learn from the INFO field that such a case exists.

**The question for the client:** *should a case that has no call result yet appear in the INFO summary at all?* If it must appear, only option 1 will do and the column has to be widened. If it need not appear, option 2 solves the problem today without touching the schema.

## Related

- `/home/viktar/Projects/kimi-plus.at/tasks/08-anexia-updated-the-kimibatch-directory/05-plan-reapply-php85-upgrade-on-the-2026-09-08-production-baseline.md` — items $61 and $62.
- Commit `c88d4b8` — `mysqli_report(MYSQLI_REPORT_OFF);` at `kimibatch/db.php:8`, which is why the import now prints the error and runs to its end instead of stopping.
