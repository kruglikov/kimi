
# Short document summary
During the audit with AI tools we already updated the PHP version from 8.0 to 8.5. Archives with updated code (htdocs-folder-updated-to-php85.zip) and updated code
with test docker environment and AI-generated smoke tests (upgraded-code-with-safety-net-test-updated-to-php85(optional-archive).zip). See the full report what steps
was taken below.
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

For [S2] URL-based auto-login bypass, client input is required before the final remediation scope is fixed. In particular, KIMI should confirm whether this flow is
still used in production, which exact systems or workflows depend on it, whether it is restricted to a strictly private/internal network, and whether a safer
replacement such as short-lived signed one-time tokens would be operationally acceptable.

Testing problem: Currently we cannot test the application on our end, the final testing (including calls functionality, etc) is possible only on the Kimi's side. So
some minor issues may be catched only on Kimi's side. This adds risks that Kimi should have capability to test and fix minor issues after final testing on their side.
Or Innowise needs to have access to testing environmnet and include QA hours into the estimate.

Questions to KIMI regarding [S2]:
- Is the URL-based auto-login flow still actively used in production?
- If yes, which exact systems, scripts, integrations, or user workflows depend on it?
- Is the portal and every dependent auto-login workflow restricted to a strictly private internal network, or can any part of it be reached from public, VPN, partner,
  or mixed-trust access paths?
- Is one-click direct ticket opening operationally required, or can those workflows be changed to use normal authenticated login?
- If one-click access must remain, would a safer replacement such as short-lived signed one-time tokens be operationally acceptable?

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
  Questions to the client:
  - Is the URL-based auto-login flow still actively used in production?
  - If yes, which exact systems, scripts, integrations, or user workflows depend on it?
  - Is the portal and every dependent auto-login workflow restricted to a strictly private internal network, or can any part of it be reached from public, VPN, partner, or mixed-trust access paths?
  - Is one-click direct ticket opening operationally required, or can those workflows be changed to use normal authenticated login?
  - If one-click access must remain, would a safer replacement such as short-lived signed one-time tokens be operationally acceptable?
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

## Review scope and limitation

- This is a code-visible technical GDPR review. It is not a full legal or organisational compliance audit.
- We did not inspect or administer the live production environment. Therefore we cannot confirm the real network exposure, host hardening, filesystem permissions, transport protection, backup handling, retention enforcement, or contractual setup with external parties.
- However, the source code is sufficient to conclude that the portal processes personal data and that the batch subsystem performs file-based export and import of personal data. That means the client should treat the batch subsystem as a material GDPR-relevant processing path, not just as an internal technical utility.

## Technical conclusions supported directly by code

- The application processes personal data of users/agents and debtor/customers.
- Representative fields visible in the data model and batch SQL include names, addresses, postal codes, cities, phone numbers, email addresses, date of birth, and case-related collection information.
- Some batch flows also export additional financial/contact fields such as `iban` and `bic`.
- The batch subsystem stores exchange artifacts in per-campaign `IN/` and `OUT/` folders under `web/htdocs/kimi_ET/kimibatch/files/`, creating additional copies and transfer paths for personal data outside the main transactional DB.

## Code-visible GDPR issues

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

## Client-side operational checks required

- [GDPR4] Batch file access control and host exposure must be verified in production.
  Why this matters: the code proves that personal data is copied into batch exchange directories. If those directories, cron hosts, or shared locations are weakly protected, personal data exposure risk increases materially.
  What KIMI's system administrators should verify:
  - who can access `kimibatch/files/` in production
  - whether these directories are reachable from shared hosts, helper tools, or broad internal networks
  - whether file and directory permissions are restricted to the minimum necessary roles
  GDPR articles and justification: Article 5(1)(f), Article 24, and Article 32 are relevant, but this cannot be confirmed from code alone.
- [GDPR5] Batch file retention, cleanup, and backup scope must be defined.
  Why this matters: import/export files create extra copies of personal data and may remain on disk or in backups longer than intended.
  What KIMI's system administrators should verify:
  - how long `IN/` and `OUT/` files are retained
  - whether files are deleted after successful processing
  - whether backups preserve those files beyond the intended business lifetime
  - who owns the cleanup responsibility
  GDPR articles and justification: Article 5(1)(e) storage limitation and Article 32 security of processing are relevant.
- [GDPR6] Data minimisation of batch exchanges should be actively reviewed.
  Why this matters: some reviewed exchange definitions include email, date of birth, and in some cases IBAN/BIC in addition to basic contact data.
  What KIMI's process owners should verify:
  - whether every exported field is necessary for the receiving workflow
  - whether any columns can be removed or replaced with less sensitive alternatives
  GDPR articles and justification: Article 5(1)(c) data minimisation and Article 25 data protection by design and by default are relevant.
- [GDPR7] External recipient / processor governance must be checked.
  Why this matters: the code shows data exchange with adjacent systems and telephony-related flows, but the real party landscape was not reviewed here.
  What KIMI's responsible owners should verify:
  - which systems and vendors receive exported data
  - whether they act as processors or subprocessors
  - whether contractual and governance controls reflect that role
  GDPR articles and justification: Article 24 and Article 28 may be relevant, but this cannot be confirmed from code alone.
- [GDPR8] Privacy notices, rights handling, and breach procedures should explicitly include batch-processing flows.
  Why this matters: the batch subsystem creates additional storage and transfer paths that may otherwise be overlooked in documentation and incident handling.
  What KIMI's responsible owners should verify:
  - whether privacy notices and internal records reflect these data flows
  - whether access/erasure/rectification handling includes batch-file copies and connected systems
  - whether incident procedures cover leaks from batch directories, shared storage, backups, and connected systems
  GDPR articles and justification: Articles 13-14, 15-22, and 33-34 may be relevant, but this is an operational verification area outside the scope of the present technical review.

## GDPR Priorities

### Must be fixed for GDPR:
- [GDPR1] URL-based auto-login is not privacy-safe by default.
  - Related must-fix technical item: [S2] URL-based auto-login bypass.
- [GDPR2] Weak protection of personal data in authentication and data access.
  - Related must-fix technical item: [S1] SQL injection exposure in auth and DB access.

### Nice to have fixed for GDPR, but should be checked carefully because they may move into must-fix depending on the real deployment, threat model, and organisational process maturity:
- [GDPR3] Missing CSRF protection for authenticated state changes.
  - Related must-fix technical items under current assumptions: none.

### Additional client-side actions strongly recommended:
- [GDPR4] Verify batch file access control and host exposure.
- [GDPR5] Define retention, cleanup, and backup treatment for batch files.
- [GDPR6] Review data minimisation of batch exchanges.
- [GDPR7] Confirm external recipient / processor governance.
- [GDPR8] Ensure privacy notices, rights handling, and breach procedures include batch-processing flows.

# Further Steps

The main tasks to be fixed are either only 2 must have fixed:
- [S1] SQL injection exposure in auth and DB access.
- [S2] URL-based auto-login bypass
If the site accessible publicly, then we need to fix next "must fix" issues too:
- [S3] Weak password hashing.
- [S4] Weak session configuration.
- [S5] Missing session rotation and CSRF protection.

To continue with these fixes, we would very appreciate a real db dump with truncated data.

In parallel with the code fixes, KIMI's system administrators and process owners should run a focused production-side check of:
- permissions and network exposure for `kimibatch/files/`
- retention and cleanup of `IN/` and `OUT/` files
- backup scope for batch artifacts
- secure transfer/storage of exchanged files
- involved vendors and connected systems
- whether privacy/process documentation covers these batch flows

## Testing problem\risks

Currently, we cannot test the application on our end, the final testing (including calls functionality, etc) is possible only on the Kimi's side. So some minor issues may be catched only on Kimi's side. This adds risks that Kimi should have capability to test and fix minor issues after final testing on their side. Or Innowise needs to have access to testing environmnet and include QA hours into the estimate.
