

# To Be Done

- Review all provided system documentation and source materials.
- Assess PHP 8.0 -> current supported PHP 8.5 migration feasibility.
- Highlight critical code sections, technical risks, and high-test-effort components.
- Review code-visible GDPR/DSGVO-relevant security aspects.
- Prepare a rough effort estimate for the migration work.

# Architectural overview
KIMI Portal is a legacy custom PHP/MariaDB business application with one main browser-based portal and a large set of supporting batch scripts. The main parts are authentication and session handling, mandant/role-based access control, customer and ticket management, campaign-specific UI modules, AJAX/telephony integration, and file/database-driven batch processing. The application is modular in structure but tightly coupled through shared bootstrap, database, and entity layers.

# Upgrade PHP Versions plan

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
- [S1] Weak password hashing. 
   `web/htdocs/kimi_ET/libs/entities/user.php:178` still uses `hash("sha256", "kimiplus" . $passwort)` with a global static salt. This is weaker than `password_hash()` with Argon2id or bcrypt because it has no per-user salt and no adaptive work factor.
- [S2] Weak session configuration. `web/htdocs/kimi_ET/libs/init.php:93` calls `session_start()` without secure cookie flags such as `cookie_secure`, `cookie_httponly`, or `cookie_samesite`. `web/htdocs/kimi_ET/libs/init.php:92`, `web/htdocs/kimi_ET/login.php:5`, and `web/htdocs/kimi_ET/index.php:6` also use inconsistent session names (`kimi_ET-P` vs `kimiET-P`).
- [S3] Missing session rotation and CSRF protection. `web/htdocs/kimi_ET/ajax/check-login.php:1` sets `$_SESSION["user"]` after login but does not rotate the session via `session_regenerate_id(true)`. No CSRF token handling was found in the main login or routed portal files reviewed.
- [S4] URL-based auto-login bypass. `web/htdocs/kimi_ET/index.php:11` accepts `?autologin=true&loginuser=...&mandant=...&kId=...` and establishes a logged-in session without password verification. The same pattern is embedded into multiple batch and telephony-generated URLs under `web/htdocs/kimi_ET/kimibatch/`.
- [S5] SQL injection exposure in auth and DB access. `web/htdocs/kimi_ET/libs/entities/user.php:115` builds the login query with raw string interpolation for `$name`, and `web/htdocs/kimi_ET/libs/database.php:1` provides a raw-query DB layer without prepared statements as the default pattern. This matters from both security and GDPR perspectives because the affected area is authentication and personal/customer data access.
- [S6] Raw error disclosure and insecure auxiliary cookies. Many scripts echo raw SQL/database errors via `mysqli_error(...)`, which can disclose internal query structure and schema details. There are also cookie writes such as the `KimiNebenstelle` path in `web/htdocs/kimi_ET/index.php:25` without visible security attributes in the code path shown.

## Private network with trusted users
If the site is only reachable inside a private network and only trusted users can access it:
- Must be fixed: [S5] SQL injection exposure in auth and DB access.
- Must be fixed: [S4] URL-based auto-login bypass, if there is any chance of lateral access, link sharing, or misuse by internal users or connected systems.
- Nice to have fixed: [S1] Weak password hashing.
- Nice to have fixed: [S3] Missing session rotation and CSRF protection, unless shared workstations, lateral access paths, or externally reachable helper links make session misuse realistic.
- Nice to have fixed: [S3] Missing session rotation and CSRF protection, for the CSRF-protection part.
- Nice to have fixed: [S2] Weak session configuration.
- Nice to have fixed: [S6] Raw error disclosure and insecure auxiliary cookies.

## Public network access
If the site is accessible publicly:
- Must be fixed: [S4] URL-based auto-login bypass.
- Must be fixed: [S5] SQL injection exposure in auth and DB access.
- Must be fixed: [S1] Weak password hashing.
- Must be fixed: [S2] Weak session configuration.
- Must be fixed: [S3] Missing session rotation and CSRF protection.
- Nice to have fixed: [S6] Raw error disclosure and insecure auxiliary cookies.

# GDPR Review

- This is a code-visible GDPR review. It covers issues that can be evidenced from the application code and local configuration. It is not a full legal audit of contracts, processor arrangements, records of processing, live retention practice, or operational procedures outside the application.
- The most directly implicated GDPR requirements are Article 5(1)(f) integrity and confidentiality, Article 24 controller responsibility, Article 25 data protection by design and by default, and Article 32 security of processing.
- GDPR does not create one set of duties for private networks and another for public deployments. The legal obligations remain the same. What changes is the Article 32 risk profile: public exposure usually makes weak controls less defensible and raises the likelihood that a finding should be treated as urgent.

Code-visible GDPR issues and what should be done:
- [GDPR1] Inadequate protection of personal data in authentication and data access.
  Business sense and how to fix: personal and debtor-related data is exposed to avoidable compromise risk because the authentication and data-access layers use weak security patterns. Evidence in code includes [S5] raw SQL authentication queries in `web/htdocs/kimi_ET/libs/entities/user.php:115`, [S1] weak static-salt SHA-256 password hashing in `web/htdocs/kimi_ET/libs/entities/user.php:178`, [S2] insecure session setup in `web/htdocs/kimi_ET/libs/init.php:93`, [S3] missing session rotation in `web/htdocs/kimi_ET/ajax/check-login.php:1`, and [S6] raw SQL error disclosure in `web/htdocs/kimi_ET/libs/database.php:1` and many endpoint scripts. Fix: move critical auth and data-access paths to prepared statements, replace password storage with `password_hash()` plus migration logic, harden session cookies and login session rotation, and stop exposing raw DB errors to end users.
  GDPR articles and justification: Article 5(1)(f) and Article 32 require integrity/confidentiality and security measures appropriate to the risk. Article 24 is also relevant because the controller must implement and be able to demonstrate appropriate measures.
- [GDPR2] URL-based auto-login is not privacy-safe by default.
  Business sense and how to fix: direct authenticated access by URL increases the chance of unauthorized access through leaked links, browser history, logs, internal forwarding, or misuse by connected systems. Evidence in code includes [S4] `web/htdocs/kimi_ET/index.php:11` and multiple batch/telephony-generated links under `web/htdocs/kimi_ET/kimibatch/`. Fix: remove this mechanism, or replace it with short-lived signed one-time tokens, strict IP/network restrictions, server-side expiry, and audit controls.
  GDPR articles and justification: Article 25 and Article 32 require privacy-safe defaults and appropriate security. A passwordless URL-auth flow is difficult to justify as a secure default for debtor/customer data.
- [GDPR3] Missing CSRF protection for authenticated state changes.
  Business sense and how to fix: an authenticated user can potentially be tricked into submitting unwanted state-changing requests, which can affect customer records, logs, or case-processing actions. Evidence in code overlaps with [S3]. Fix: introduce CSRF tokens for authenticated POST actions and verify them server-side.
  GDPR articles and justification: Article 25 and Article 32 are relevant because integrity of personal-data processing depends on preventing unauthorized or manipulated actions under an authenticated user context.
- [GDPR4] Missing documented technical baseline for secure processing.
  Business sense and how to fix: repeated insecure defaults across authentication, session handling, and DB access indicate the system lacks a clearly enforced minimum security standard. Fix: define and implement a minimum security baseline for authentication, session handling, error handling, and query execution, and keep it documented as part of the maintained application standard.
  GDPR articles and justification: Article 24 requires the controller to implement and be able to demonstrate appropriate technical and organisational measures. This is partly a governance/documentation issue, not only a coding issue.
- [GDPR5] Error handling discloses excessive technical detail.
  Business sense and how to fix: raw SQL errors can leak schema details, SQL text, and internal context that make personal-data systems easier to exploit or inspect. Evidence overlaps with [S6]. Fix: log technical errors to protected server logs, return generic user-safe error messages to the browser, and avoid including full SQL text in response content.
  GDPR articles and justification: Article 5(1)(f), Article 24, and Article 32 are relevant because unnecessary disclosure undermines confidentiality and indicates insufficient protective measures.
- [GDPR6] Retention and storage-limitation controls are not evident from code.
  Business sense and how to fix: the portal appears to maintain logs, archive data, telephony data, and batch-import artifacts, but the reviewed code does not show clear deletion, anonymisation, or retention enforcement. Evidence includes `web/htdocs/kimi_ET/config/config.php:39` with `kimi_archiv`, `web/htdocs/kimi_ET/libs/application.php:47`, and file logging such as `web/htdocs/kimi_ET/setticketcallinfo.php:258`. Fix: define retention periods for operational logs, archived records, telephony logs, and batch-import files, and implement deletion/anonymisation routines where required.
  GDPR articles and justification: Article 5(1)(e) requires storage limitation. This item cannot be fully confirmed from code alone, so it should be checked against real operations, DB content, and documented retention policy.
- [GDPR7] Transparency coverage cannot be confirmed from code alone.
  Business sense and how to fix: the UI links to `../datenschutz.html`, but this review did not validate whether the privacy notice fully covers actual purposes, legal bases, retention, recipients, and rights. Fix: review the live privacy notice against actual processing activities and ensure it matches the implemented data flows.
  GDPR articles and justification: Articles 13 and 14 require clear information to data subjects. This is mainly a content/process review item rather than a pure code defect.
- [GDPR8] Data-subject-rights workflows are not evident in the reviewed implementation.
  Business sense and how to fix: the review did not identify clear application support for access, rectification, erasure, restriction, objection, or portability handling. This does not prove non-compliance, because such requests may be handled operationally outside the portal. Fix: confirm whether these requests are handled outside the system; if not, implement and document a controlled process.
  GDPR articles and justification: Articles 15 to 22 establish these rights. This item needs process review in addition to code review.
- [GDPR9] Breach-response readiness cannot be assessed from code alone.
  Business sense and how to fix: application code does not show whether incident handling, assessment, evidence preservation, and notification responsibilities are operationally in place. Fix: ensure there is an organisational incident-response process covering detection, assessment, notification, and evidence preservation for personal-data breaches.
  GDPR articles and justification: Articles 33 and 34 govern breach notification and communication. This is primarily an organisational control item.

## GDPR Priorities
GDPR priorities if the current application remains in use:
### Must be fixed for GDPR:
- [GDPR1] Inadequate protection of personal data in authentication and data access.
- [GDPR2] URL-based auto-login is not privacy-safe by default.
- [GDPR5] Error handling discloses excessive technical detail.
### Nice to have fixed for GDPR, but should be checked carefully because they may move into must-fix depending on the real deployment, threat model, and organisational process maturity:
- [GDPR3] Missing CSRF protection for authenticated state changes.
- [GDPR4] Missing documented technical baseline for secure processing.
- [GDPR6] Retention and storage-limitation controls are not evident from code.
- [GDPR7] Transparency coverage cannot be confirmed from code alone.
- [GDPR8] Data-subject-rights workflows are not evident in the reviewed implementation.
- [GDPR9] Breach-response readiness cannot be assessed from code alone.
