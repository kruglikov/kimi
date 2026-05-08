
# Short document summary
During the audit with AI tools we already updated the PHP version from 8.0 to 8.5. Archives with updated code (htdocs-folder-updated-to-php85.zip) and updated code with test docker environment and AI-generated smoke tests (upgraded-code-with-safety-net-test-updated-to-php85(optional-archive).zip). See the full report what steps was taken below.
Clent's system administrators can prepare new PHP 8.5 environment and deploy the system and test.

Also Security and GDPR review was conducted (see the full report below). In a nutshell, "must fix" results of both Security review and GDPR review are the next:
If the site is only reachable inside a private network and only trusted users can access it:
- [S1] SQL injection exposure in auth and DB access.
- [S2] URL-based auto-login bypass
If the site is accessible publicly, then additional "must fix" tasks should be included:
- [S3] Weak password hashing.
- [S4] Weak session configuration.
- [S5] Missing session rotation and CSRF protection.

After GDPR review, "must fix" issues are the same. But there are a bunch "Nice to be fixed" additional GDPR tasks (see details below).

Testing problem: Currently we cannot test the application on our end, the final testing (including calls functionality, etc) is possible only on the Kimi's side. So some minor issues may be catched only on Kimi's side. This adds risks that Kimi should have capability to test and fix minor issues after final testing on their side. Or Innowise needs to have access to testing environmnet and include QA hours into the estimate.

# To Be Done

- Review all provided system documentation and source materials.
- Assess PHP 8.0 -> current supported PHP 8.5 migration feasibility.
- Highlight critical code sections, technical risks, and high-test-effort components.
- Review code-visible GDPR/DSGVO-relevant security aspects.
- Prepare a rough effort estimate for the migration work.

# Architectural overview & critical code sections
KIMI Portal is a legacy custom PHP/MariaDB business application with one main browser-based portal and a large set of supporting batch scripts. The main parts are authentication and session handling, mandant/role-based access control, customer and ticket management, campaign-specific UI modules, AJAX/telephony integration, and file/database-driven batch processing. The application is modular in structure but tightly coupled through shared bootstrap, database, and entity layers.

# Upgrade PHP Versions plan [DONE]

- Prepare environment and smoke tests safety net on PHP 8.0 version [DONE]
  - Create docker file with app and db container on PHP 8.0 (this change should only add or wrap the current coding base, and do not change its structure ) [DONE]
  - Recreate database dump file from the code and apply it [DONE]
  - Create accounts in database to see that it work [DONE]
  - Create reverce-engeneer datbase seed data to make the system work locally in a base state [DONE]
  - Create safety-net smoke tests as the baseline before broader code or dependency changes [DONE]
  - Make sure that test safety net covers project files enough (with PHP 8.0) [DONE]
  - Prepare Rector code updates script to run updates PHP 8.0 - 8.5 leap [DONE]
- Upgrade environment to php 8.5 and check [DONE]
  - Update docker environment php version 8.0 -> 8.5 [DONE]
  - Run Rector code updates PHP 8.0 - 8.5 tool [DONE]
- Check after udpate problems and fix them [DONE]
  - Run safety net tests and fix issues related to the update that Rector did not handle [DONE]
  - Review dependencies that were intentionally skipped by Rector, especially `vendor/`, `kimibatch/files/vendor/`, and bundled legacy libraries such as `libs/addons/phpmail/` [DONE]
  - Run the project live and check if it works with own eyes [DONE]

Caution: this upgrade validation was done with the smoke-test safety net only, not with full functional/regression testing. The system may still contain issues in business flows, edge cases, integrations, or less-used modules that were not covered by the current safety net.

# Security review

- [S1] SQL injection exposure in auth and DB access.
  Business sense: authentication and customer-data access are handled through raw SQL construction. This creates a risk of unauthorized data access, record manipulation, and compromise of personal data.
  Evidence in code: `web/htdocs/kimi_ET/libs/entities/user.php:115` and the broader raw-query pattern in `web/htdocs/kimi_ET/libs/database.php:1`.
  What needs to be clarified before the fix: which login, search, customer, ticket, and batch entry points still build SQL from untrusted values; whether there are helper wrappers already used anywhere for safer query construction.
  How to fix: migrate high-risk authentication and personal-data query paths to prepared statements.
- [S2] URL-based auto-login bypass.
  Business sense: this creates a direct authenticated access path without password verification. If such links leak through browser history, internal forwarding, logs, screenshots, copied URLs, or helper tools, unauthorized access to debtor/customer data becomes much easier.
  Evidence in code: `web/htdocs/kimi_ET/index.php:11`; the same pattern is also embedded into multiple batch and telephony-generated URLs under `web/htdocs/kimi_ET/kimibatch/`.
  What needs to be clarified before the fix: whether this mechanism is still genuinely required for telephony, batch, or agent workflows; whether the application is accessible only on a strictly private network; whether any safe replacement is operationally acceptable.
  How to fix: remove the mechanism if possible. If it must remain in some form, replace it with short-lived signed one-time tokens, strict server-side expiry, audit logging, and network/IP restrictions.
- [S3] Weak password hashing.
  Business sense: static-salt SHA-256 is weak compared with modern password hashing. If password data is exposed, offline cracking risk is materially higher than with Argon2id or bcrypt.
  Evidence in code: `web/htdocs/kimi_ET/libs/entities/user.php:178`.
  How to fix: switch to `password_hash()` and `password_verify()` with a migration strategy that rehashes legacy passwords on successful login or through a controlled reset flow.
- [S4] Weak session configuration.
  Business sense: session setup is not cleanly centralized, and explicit secure cookie settings are not evident in the reviewed portal code. This weakens session integrity and makes session behavior harder to reason about and harden.
  Evidence in code: `web/htdocs/kimi_ET/login.php:5`, `web/htdocs/kimi_ET/index.php:6`, `web/htdocs/kimi_ET/libs/init.php:106`.
  How to fix: normalize session naming, enforce secure cookie settings such as `cookie_secure`, `cookie_httponly`, and `cookie_samesite`, and keep session initialization centralized.
- [S5] Missing session rotation and CSRF protection.
  Business sense: without session ID rotation on login, session fixation risk remains. Without CSRF protection, authenticated users may be tricked into unintended state-changing actions.
  Evidence in code: `web/htdocs/kimi_ET/ajax/check-login.php:1`.
  How to fix: call `session_regenerate_id(true)` immediately after successful login and add CSRF tokens plus server-side validation for authenticated state-changing actions.
- [S6] Insecure auxiliary cookie handling.
  Business sense: auxiliary cookies without clear security attributes can increase exposure of client-side state, even if this is less critical than core session issues.
  Evidence in code: auxiliary cookie handling includes `web/htdocs/kimi_ET/index.php:25`.
  What needs to be clarified before the fix: whether the auxiliary cookie is actually used in production, whether it contains sensitive or workflow-relevant data, and whether it can be removed entirely.
  How to fix: remove the cookie if unnecessary, or harden it with appropriate security attributes and constrained lifetime/scope.

## Private network with trusted users
If the site is only reachable inside a private network and only trusted users can access it:
- Must be fixed: [S1] SQL injection exposure in auth and DB access.
- Must be fixed: [S2] URL-based auto-login bypass, if there is any chance of lateral access, link sharing, or misuse by internal users or connected systems.
- Nice to have fixed: [S3] Weak password hashing.
- Nice to have fixed: [S5] Missing session rotation and CSRF protection, unless shared workstations, lateral access paths, externally reachable helper links, or browser-driven authenticated actions make session misuse realistic.
- Nice to have fixed: [S4] Weak session configuration.
- Nice to have fixed: [S6] Insecure auxiliary cookie handling.

## Public network access
If the site is accessible publicly:
- Must be fixed: [S1] SQL injection exposure in auth and DB access.
- Must be fixed: [S2] URL-based auto-login bypass.
- Must be fixed: [S3] Weak password hashing.
- Must be fixed: [S4] Weak session configuration.
- Must be fixed: [S5] Missing session rotation and CSRF protection.
- Nice to have fixed: [S6] Insecure auxiliary cookie handling.

Question [Q1]: Am I right that the site is accessible only in private network by trusted users?

# GDPR Review

- This is a code-visible technical GDPR review. It covers only what can be evidenced from the application source code, local configuration, and repository materials available in this task.
- It is not a full legal or organisational GDPR audit. We did not inspect or manage the live production environment, contracts, processor arrangements, records of processing, real retention practice, or operational procedures outside the codebase.
- Because of that limitation, this review cannot confirm how the production environment is network-exposed or segmented, who has filesystem, database, backup, or cron access, whether batch exchange files are encrypted or access-restricted in production, or whether external service providers are covered by the necessary contractual arrangements.
- The most directly implicated GDPR requirements visible from code are Article 5(1)(f) integrity and confidentiality, Article 24 responsibility of the controller, Article 25 data protection by design and by default, and Article 32 security of processing.

What can be concluded from code with high confidence:
- The application clearly processes personal data. This includes both user/agent data and debtor/customer data stored in business tables and used throughout the portal.
- Representative tables and seed data include personal fields such as names, addresses, telephone numbers, email addresses, and case-related customer data.
- The batch-processing subsystem also clearly performs file-based export and import of personal data through per-campaign `IN/` and `OUT/` directories under `web/htdocs/kimi_ET/kimibatch/files/`.
- Representative batch SQL definitions show export and import of fields such as `nachname`, `vorname`, `plz`, `ort`, `strasse`, `telefon`, `email`, `geburtsdatum`, and in some cases `iban` and `bic`.

Code-visible GDPR issues:
- [GDPR1] URL-based auto-login is not privacy-safe by default.
  Business sense: direct authenticated access by URL increases the chance of unauthorized access through leaked links, browser history, logs, internal forwarding, or misuse by connected systems.
  What needs to be clarified before the fix: whether this mechanism is still operationally required, whether a non-URL-based replacement is acceptable, and whether any current integrations depend on this exact flow.
  Required technical tasks:
  - [S2] URL-based auto-login bypass — Must fix
  GDPR articles and justification: Article 25 data protection by design and by default and Article 32 security of processing require privacy-safe defaults and appropriate security. A passwordless URL-auth flow is difficult to justify as a secure default for debtor/customer data.
- [GDPR2] Weak protection of personal data in authentication and data access.
  Business sense: personal and debtor-related data is exposed to avoidable compromise risk because the authentication and data-access layers use weak security patterns.
  What needs to be clarified before the fix: whether the portal is public or strictly private, whether credentials may be reused elsewhere, whether shared workstations exist, and which query paths are highest-risk because they handle login or customer/debtor data directly.
  Required technical tasks:
  - [S1] SQL injection exposure in auth and DB access — Must fix
  - [S3] Weak password hashing — Nice to have
  - [S4] Weak session configuration — Nice to have
  - [S5] Missing session rotation and CSRF protection — Nice to have
  GDPR articles and justification: Article 5(1)(f) integrity and confidentiality and Article 32 security of processing require security measures appropriate to the risk. Article 24 responsibility of the controller is also relevant because the controller must implement and be able to demonstrate appropriate measures.
- [GDPR3] Missing CSRF protection for authenticated state changes.
  Business sense: an authenticated user can potentially be tricked into submitting unwanted state-changing requests, which can affect customer records, logs, or case-processing actions.
  What needs to be clarified before the fix: which authenticated actions actually change data, whether they are triggered only by POST, and whether any integrations or frontend scripts would break once CSRF checks are enforced.
  Required technical tasks:
  - [S5] Missing session rotation and CSRF protection — Nice to have
  GDPR articles and justification: Article 25 data protection by design and by default and Article 32 security of processing are relevant because integrity of personal-data processing depends on preventing unauthorized or manipulated actions under an authenticated user context.

Operational / organisational items not confirmable from code alone:
- [GDPR4] Retention and storage-limitation controls for batch files, logs, archive data, and telephony data are not evident from code.
  Why it matters: the reviewed code shows file-based import/export and historical data handling, but not the real production retention or cleanup practice.
  What the client should verify: where import/export files are stored in production, who can access them, how long they are retained, how they are deleted, and whether backups extend their lifetime.
  GDPR articles and justification: Article 5(1)(e) storage limitation and Article 32 security of processing are relevant, but this point cannot be confirmed from code alone.
- [GDPR5] Data minimisation of exported/imported batch fields should be checked.
  Why it matters: some reviewed export definitions include not only names and phone numbers but also email, date of birth, and in some cases IBAN/BIC.
  What the client should verify: whether each exported field is strictly necessary for the real business purpose and receiving system workflow.
  GDPR articles and justification: Article 5(1)(c) data minimisation and Article 25 data protection by design and by default are relevant.
- [GDPR6] External recipients / processor involvement should be checked.
  Why it matters: the code shows that personal data is exchanged with external or adjacent systems through batch files and telephony-related workflows, but the contractual and operational setup was not reviewed here.
  What the client should verify: whether the receiving systems or service providers act as processors or subprocessors, and whether this is covered by the required contractual and governance measures.
  GDPR articles and justification: Article 24 responsibility of the controller and Article 28 processor obligations may be relevant, but this cannot be confirmed from code alone.
- [GDPR7] Transparency, data-subject-rights handling, and breach-response readiness cannot be confirmed from code alone.
  Why it matters: the codebase does not prove whether privacy notices, rights-handling workflows, and incident procedures are complete in real operations.
  What the client should verify: whether these processes exist outside the portal and whether they correctly include the batch subsystem and any personal-data exchange files.
  GDPR articles and justification: Articles 13-14, 15-22, and 33-34 may be relevant, but these are mainly operational controls outside the scope of this technical review.

## GDPR Priorities

### Must be fixed for GDPR:
- [GDPR1] URL-based auto-login is not privacy-safe by default.
  - Related must-fix technical item: [S2] URL-based auto-login bypass.
- [GDPR2] Weak protection of personal data in authentication and data access.
  - Related must-fix technical item: [S1] SQL injection exposure in auth and DB access.

### Nice to have fixed for GDPR under the current technical-review scope:
- [GDPR3] Missing CSRF protection for authenticated state changes.
  - Related technical item: [S5] Missing session rotation and CSRF protection.

### Client-side verification items required because they cannot be confirmed from code alone:
- [GDPR4] Retention and storage-limitation controls for batch files, logs, archive data, and telephony data.
- [GDPR5] Data minimisation of exported/imported batch fields.
- [GDPR6] External recipients / processor involvement.
- [GDPR7] Transparency, data-subject-rights handling, and breach-response readiness.

# Further Steps

The main tasks to be fixed are either only 2 must have fixed:
- [S1] SQL injection exposure in auth and DB access.
- [S2] URL-based auto-login bypass
If the site accessible publicly, then we need to fix next "must fix" issues too:
- [S3] Weak password hashing.
- [S4] Weak session configuration.
- [S5] Missing session rotation and CSRF protection.

To continue with these fixes, we would very appreciate a real db dump with truncated data.

For the GDPR-related items that cannot be confirmed from code alone, KIMI's system administrators and responsible process owners should additionally verify:
- access restrictions to batch directories and supporting hosts
- retention and cleanup of `kimibatch/files/.../IN` and `.../OUT` artifacts
- whether exported fields are limited to what is necessary
- whether external receiving systems are covered by the required organisational and contractual arrangements

## Testing problem\risks

Currently, we cannot test the application on our end, the final testing (including calls functionality, etc) is possible only on the Kimi's side. So some minor issues may be catched only on Kimi's side. This adds risks that Kimi should have capability to test and fix minor issues after final testing on their side. Or Innowise needs to have access to testing environmnet and include QA hours into the estimate.
