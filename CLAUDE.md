

This file provides guidance for AI Agent when working with code in this repository.

# Project Overview

Migration and modernisation of the **KIMI Portal** — a legacy PHP 8.0 / MariaDB 10.5 B2B SaaS portal for debt-collection call-centre agents.

## Business Context

**KIMI Plus GmbH** (kimi-plus.at) is an Austrian consulting company that acts as a professional intermediary in payment management — helping businesses communicate with customers about late payments and debt collection, while preserving customer relationships.

**The KIMI Portal** (`kimiportal.at`) is a multi-tenant, browser-based B2B SaaS portal used by call-center agents to manage debt collection campaigns. Call-center agents log in, select a client (Mandant), and work through tickets (Akt/Ticket) — each representing a customer case within a campaign. Agents can view case data, record interactions, make outbound phone calls, and process payments/bookings.


# AI Agent instruction
- **PII on local / test / dev environments — do NOT worry about it.** On the local docker stack and the `kimidev_ET` dev/test server, freely print, query, and decrypt customer data (names, phones, emails, `kimi_decrypt(...)` output, etc.) in diagnostics. Do not redact, hedge, or repeatedly raise PII concerns for these environments — the user has explicitly said so. (PII caution still applies only to PROD and to sending data to external/third-party services.)
- Change nothing in the codebase without an approve\confirmation!
- **Browser testing is ALWAYS done in a visible browser window — never headless.** Every browser action (opening a page, filling a form, clicking, reading a rendered value, taking a screenshot) must run in a browser window the user can watch, so the user sees what is being done at the moment it is done. Do not pass `--headless`, do not use a headless driver, and do not fall back to `curl` or an HTTP client and present the result as a browser test — a request made with `curl` is not an end-to-end test and must be described as what it is. If the only browser available cannot be driven in visible mode, say so and stop rather than switching to a headless run.
- We implement Memory Bank pattern to handle the project information management:
  - See @memory-bank/ folder which consists of @memory-bank/index.md file - please read it to be able to navigate memory bank.
- Two navigation index files exist — read them first to orient:
  - @memory-bank/index.md — index of project knowledge (architecture, upgrade status, stakeholders, smoke tests).
  - @docs/index.md — index of the client communication history and reference documentation.
- when you finish some task or investigation and present the results be descriptive. I.e.: 
  - Please in your final answer provide steps that you have taken to find out the final answer\solution and justify all changes in code
  - clear explanation of underlying entities that are included into the final explanation
- When you mention any file or method, please provide **full path** to the file or method!!!
- Markdown formatting: do **not** hard-wrap / insert line breaks within a paragraph. Each paragraph (and each list item) is a single continuous line; separate paragraphs with a blank line, and never use more than one consecutive blank line.


- Never do changes without approve!
- In plan mode please once you create a plan, always save prepared plan into the current task folder in @tasks/ with 'plan' prefix:
  '{max_number+1}-plan-{meaningful-plan-name}.md'.
  - or if you don't find current task folder - ask what where to save or propose suitable place.
- IMPORTANT: when you finish some task or investigation and present the results be descriptive. I.e.:
  - Please in your final answer provide steps that you have taken to find out the final answer\solution and justify all changes in code
  - clear explanation of underlying entities that are included into the final explanation
- Be specific when you mention or refer to something!
  - When you mention the file, or lines of file, or method of class\object, or project entity - please make sure it's clear what exact file path they refer to
  - For PROPOSED (not-yet-written) code, say explicitly that the class is proposed and name it anyway (e.g. "the proposed `DevStaticTokenAuthenticator::supports()`"); if the method implements a framework interface, name that interface too.
  - NEVER cite a file without its full path from project root and line number.
  - **NEVER cite a bare line number — every line or line-range reference must carry the full path of the file it belongs to, inside the same reference.** Write `blentech/src/src/MessageHandler/SendBatchReadyWebhookMessageHandler.php:44-45`; never `:44-45`, never `at :127-128`, never "lines 44-45" on the assumption that the file is obvious from an earlier sentence, a heading, or the previous bullet. This applies to the SECOND and every later reference to the same file too, including inside one paragraph, bullet, or table cell — repeat the full path every single time, even when the repetition feels clumsy. A bare `:NN` forces the reader to scroll back and guess which of the several files under discussion it belongs to, and the guess is often wrong.
    - NOT "the code comment at `:44-45` already admits this" -> "the code comment at `blentech/src/src/MessageHandler/SendBatchReadyWebhookMessageHandler.php:44-45` already admits this".
    - NOT "applied at `:127-128`" -> "applied at `blentech/src/src/MessageHandler/SendBatchReadyWebhookMessageHandler.php:127-128`".
  - **NEVER use jargon, shorthand, or a metaphor as the load-bearing word of an explanation — name the concrete mechanism instead.** A term like "pin it", "wire it up", "fan out", "short-circuit", "blast radius", "source of truth", "bind", "hydrate", "under the hood" describes the writer's mental model, not the actual operation, and forces the reader to guess which operation is meant. Say exactly WHAT is done, to WHICH parameter/field/resource, with WHICH value. If a jargon term genuinely is the industry name for the thing (an AWS "encryption context", a "read replica"), define the term in the same sentence the first time it appears, and only then use the term as a label.
    - NOT "pin the `KeyId`" -> "pass the `KeyId` parameter explicitly on the `kms:Decrypt` API call, sourced from the env var `WEBHOOK_SECRET_KMS_KEY_ARN` — the parameter is optional, and omitting it lets the ciphertext blob choose which key is used".
    - NOT "the dev override short-circuits the pipeline" -> "`DevWebhookFanoutSubscriber` in `blentech/src/src/EventSubscriber/Dev/DevWebhookFanoutSubscriber.php:60-67` dispatches its own `SendBatchReadyWebhookMessage` with `overrideSecret` set, so `CustomerWebhookConfigReadRepository::findWebhookConfigForCompany()` is never called".
    - NOT "we need to widen the blast radius of the check" -> "the check must also run for rows of `IgnitionCC.customer_webhook_urls` whose `retired` column is NOT NULL".
  - **Name the TARGET of every action in full — never a bare verb phrase.** Each action you describe (in plans, step lists, summaries, prose) must say WHAT is acted on and WHERE it lives, in the same sentence, so the reader never has to ask "write where?" / "update what?". A bare verb plus an identifier is not enough: an identifier alone does not say whether it is a file, a database row, an env var, a cloud resource, or a git branch. Name the kind of thing, its system/location (service, region, account, repo, database), and its identifier together — even in a terse bullet list, and even when the previous sentence made it "obvious".
    - NOT "Write `/artis-api/dev/database_read_url` version 4" -> "Write a new version of the **AWS SSM Parameter Store** SecureString `/artis-api/dev/database_read_url` in **us-east-1**".
    - NOT "update the skill" -> "update the capability-skill file `.claude/skills/blentech-read-replica-queries/SKILL.md`".
    - NOT "truncate the catalog" -> "truncate the table `batch_json_status` in the dev **write** database (`DATABASE_URL`), not on the read replica".
    - NOT "bump the constant" -> "change `private const string WEBHOOK_TYPE` in `blentech/src/src/Service/Webhook/CustomerWebhookConfigReadRepository.php:24`".
  - if you mention a column (for example BatchID), always be specific and mention table (tableName.BatchID) or even database (dtabaseName.tableName.BatchID)
  - If you refer some point in docs always mention the point title (with exact wording) alongside with it's number
    - for example rule in PRD: "— PRD 4.3" -> "— ### 4.3. Endpoint 1: Get Batch List (GET v1/batches) ".
    - if you mention "$13", mention it with the title "$13. Batch LIST endpoint returns HARDCODED mock data"
  - ALWAYS use the FULL title of any labeled/numbered item — never the bare id or a truncated label. This covers metric ids, requirement ids, section ids, task ids, and any similar handle. Pair the id with its exact, complete title every time you mention it.
    - for example a metric: NOT "M5 throughput" -> "M5. JSON-pipeline throughput (batches processed)".
    - for example a metric: NOT "M4 queue depth" -> "M4. Queue depth, per transport".
  - **Do NOT use pronouns to stand in for a subject — name the subject.** Words such as "it", "this", "that", "they", "them", "these", "those", "the former/latter" force the reader to reconstruct the referent, and the reconstruction is often wrong — especially in a paragraph that already mentions several entities (a class, a table, a finding, an environment). Repeating the full noun is never confusing; a pronoun frequently is. Repeat the entity name even when repetition feels clumsy — clarity beats elegance.
    - NOT "the people who could fix it aren't told for ~13 hours" -> "the customer's integration owner and Blentech ops are not told that the registered webhook endpoint is returning a permanent error for ~13 hours".
    - NOT "it throws when the claim is missing" -> "`Auth0TokenValidator::extractOrganizations()` throws when the `site_identifier` claim is missing".
    - NOT "this breaks the tests" -> "switching the company key to the Auth0 organization `name` breaks `SubscriptionGuardTest`".
    - Applies to every user-facing sentence, and equally to commit messages, PR descriptions, code comments, docblocks, and docs.
- when you show code changes, show before and after changes in some way
- Never commit without approval!!!!!
- **A pull-request description is ONE SENTENCE. Not one paragraph, not "a few sentences" — one.** Say what the change does, and stop. Everything else is already carried by the PR title, the diff, the commit messages and the task notes; repeating any of it in the body only buries the single line the reviewer needs. Concretely forbidden in a PR body: a second paragraph, section headings (`Why` / `What changed` / `Tests` / `Verification` / `Follow-up`), bullet lists, tables of touched files, per-test narration, `make ci` / test-count output, quoted client messages, root-cause history, and any retelling of the investigation. If something genuinely does not fit, put it in `tasks/` or `docs/` and link it. The same one-sentence limit applies to PR comments and review replies.
  - GOOD: "Declare all three documentation tags explicitly so the docs sections render Auth, Batches, Webhooks."
  - BAD: the same thing followed by paragraphs on why the old order happened, what the new test asserts, and the `make ci` totals.
- NEVER mention that code or content was created by Claude / an AI — anywhere. No `Co-Authored-By: Claude ...` or "Generated with Claude Code" trailers in commit messages, no AI attribution in code, comments, docblocks, PR titles/descriptions, changelogs, or docs. The output must be indistinguishable from work authored by the developer.
- NEVER mention real people by name in code or other committed app-repo files — source code, comments, docblocks, config/env files, migrations, commit messages. Refer to the role instead (e.g. "infrastructure", "DevOps", "the client"). Project docs and task notes (wrapper repo `docs/`, `tasks/`) may name people where needed for context.
- When I provide you (numbered) list of questions\requests - please format answer in the same\similar numbered way. Number of answers should relate to number of questions. When you write answer, please cite the question to avoid that I need to scroll between questions above and answers below. It should be obvious the question and the answer one near another.
- Before running any diagnostic or investigative commands,
  - state what you suspect the root cause is and why, and what you will check to confirm it.
  - For any task that requires more than 2 tool calls, write a short plan first: what you believe the problem or goal is, what steps you will take in order, and what outcome you expect. Then proceed.
- Prefer an explanatory return variable over returning a long/chained expression directly. Assign the result to a clear, readable, self-describing variable and return that variable, so the returned value's meaning is obvious at the `return` statement.

  ```php
  // Avoid: returning an opaque chained expression directly
  return $this->readConnection->createQueryBuilder()
      ->select('Unit', 'Therm', 'SN', 'hasRecipeOperation')
      ->from(\sprintf('%s.Units', $tenantSchema))
      ->orderBy('SN', 'ASC')
      ->executeQuery()
      ->fetchAllAssociative();

  // Prefer: name the result, then return it
  $units = $this->readConnection->createQueryBuilder()
      ->select('Unit', 'Therm', 'SN', 'hasRecipeOperation')
      ->from(\sprintf('%s.Units', $tenantSchema))
      ->orderBy('SN', 'ASC')
      ->executeQuery()
      ->fetchAllAssociative();

  return $units;
  ```
- Never iterate over an inline method call / expression directly in `foreach`. First assign the iterable to a clear, self-describing variable, then loop over that variable, so the loop reads cleanly and the iterated collection is obvious.

  ```php
  // Avoid: looping over an inline method call
  foreach ($this->getCookersForCompany($artisCompanyId) as $cooker) {
      // ...
  }

  // Prefer: name the collection, then iterate it
  $companyCookers = $this->getCookersForCompany($artisCompanyId);
  foreach ($companyCookers as $cooker) {
      // ...
  }
  ```
- Name variables for what they actually hold (Clean Code). A variable holding the *name/identifier* of a thing must be named `...Name`/`...Id`, not after the thing itself. A variable named after the thing should hold the thing (the object/row/collection), not a string describing it. Avoid vague names; the name must reveal intent without a comment.

  ```php
  // Avoid: $table holds a string (the table NAME), not a table
  $table = \sprintf('%s.%s_Batch_Data', $artisCompanyTenantSchemaName, $cookerSerialNumber);

  // Prefer: the name says it is a name
  $batchDataTableName = \sprintf('%s.%s_Batch_Data', $artisCompanyTenantSchemaName, $cookerSerialNumber);
  ```

  Examples: a string → `$tableName`, `$schemaName`, `$cookerSerialNumber`; an object/row → `$cooker`, `$artisCompany`; a collection → plural `$cookers`, `$companyCookers`; a boolean → predicate `$isCookerBelongToCompany`, `$hasRecipeOperation`.
- Do not over-engineer. Never add a helper method, wrapper, or abstraction whose only purpose is to satisfy the static analyzer (e.g. to make a `mixed` cast legal) or to wrap a single language construct. Solve the issue at the call site with the minimal narrowing, or — when the surrounding type already allows it — pass the value through unchanged. A helper must earn its place with real, reused domain logic (a genuine transformation or computation), not exist only to appease PHPStan. When a rule and simplicity conflict, prefer the simplest code that works and raise the question rather than inventing scaffolding.

  ```php
  // Avoid: helpers that exist only to make a mixed-cast pass PHPStan
  'recipe_name' => $this->asString($row['RecipeName'] ?? null),
  'step_id'     => $this->asInt($row['StepNum'] ?? null),

  // Prefer: pass the value through — the array is already array<string, mixed>
  'recipe_name' => $row['RecipeName'] ?? null,
  'step_id'     => $row['StepNum'] ?? null,
  ```

  Helpers that do real work are fine (e.g. `toIso8601()` reformats a value and maps a sentinel to null; `durationInSeconds()` computes a difference) — the line is "does it carry domain logic" vs "does it only launder a type".
- Do not update the Memory Bank with temporary implementation details. Only document stable architectural decisions, established project behavior, or long-term project knowledge.



## Repository Layout

```
AGENTS.md                    ← symlink to `CLAUDE.md`
CLAUDE.md                    ← this file

docs/                        ← Incoming client'd docunmentation saved here  
  index.md                   ← entry point / index of all docs subfolders (read first)
  01-initial-request/        ← original client brief and our response
  02-Kimi-portal-innowise-archive/  ← client-supplied archive (PPTX, PDF originals)
  03-translated docs/        ← German→English translated documentation

memory-bank/
  index.md                   ← entry point for project knowledge and navigation

tasks/
  01-analyse-incoming-data/  ← [DONE] PHP 8.0→8.5 upgrade analysis and execution;
                               security (S1–S6) and GDPR review (GDPR1–8).
                               Task results\deliverables: @docs/04-results/Audit-report.md,
                               @docs/htdocs-folder-updated-to-php85.zip,
                               @docs/upgraded-code-with-safety-net-test-updated-to-php85(optional-archive).zip

src/
  original-src/
    web/                     ← original PHP source (Apache document root: web/htdocs/)
    docker/                  ← Docker support files (Dockerfile, vhost, DB init SQL)
  upgraded-src/              ← target location for upgraded / modernised code

scripts/up-original.sh       ← helper script for starting the original stack
src/original-src/docker-compose.yml  ← local dev entry point for the original stack
```

