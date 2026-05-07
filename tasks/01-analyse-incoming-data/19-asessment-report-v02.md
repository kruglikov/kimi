

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
- Issue: Weak password hashing. 
   `web/htdocs/kimi_ET/libs/entities/user.php:178` still uses `hash("sha256", "kimiplus" . $passwort)` with a global static salt. This is weaker than `password_hash()` with Argon2id or bcrypt because it has no per-user salt and no adaptive work factor.
- Issue: Weak session configuration. `web/htdocs/kimi_ET/libs/init.php:93` calls `session_start()` without secure cookie flags such as `cookie_secure`, `cookie_httponly`, or `cookie_samesite`. `web/htdocs/kimi_ET/libs/init.php:92`, `web/htdocs/kimi_ET/login.php:5`, and `web/htdocs/kimi_ET/index.php:6` also use inconsistent session names (`kimi_ET-P` vs `kimiET-P`).
- Issue: Missing session rotation and CSRF protection. `web/htdocs/kimi_ET/ajax/check-login.php:1` sets `$_SESSION["user"]` after login but does not rotate the session via `session_regenerate_id(true)`. No CSRF token handling was found in the main login or routed portal files reviewed.
- Issue: URL-based auto-login bypass. `web/htdocs/kimi_ET/index.php:11` accepts `?autologin=true&loginuser=...&mandant=...&kId=...` and establishes a logged-in session without password verification. The same pattern is embedded into multiple batch and telephony-generated URLs under `web/htdocs/kimi_ET/kimibatch/`.
- Issue: SQL injection exposure in auth and DB access. `web/htdocs/kimi_ET/libs/entities/user.php:115` builds the login query with raw string interpolation for `$name`, and `web/htdocs/kimi_ET/libs/database.php:1` provides a raw-query DB layer without prepared statements as the default pattern. This matters from both security and GDPR perspectives because the affected area is authentication and personal/customer data access.
- Issue: Raw error disclosure and insecure auxiliary cookies. Many scripts echo raw SQL/database errors via `mysqli_error(...)`, which can disclose internal query structure and schema details. There are also cookie writes such as the `KimiNebenstelle` path in `web/htdocs/kimi_ET/index.php:25` without visible security attributes in the code path shown.

If the site is only reachable inside a private network and only trusted users can access it:
- Must be fixed: Issue: SQL injection exposure in auth and DB access.
- Must be fixed: Issue: URL-based auto-login bypass, if there is any chance of lateral access, link sharing, or misuse by internal users or connected systems.
- Must be fixed: Issue: Missing session rotation and CSRF protection, at least for the session-rotation part.
- Nice to have fixed: Issue: Weak password hashing.
- Nice to have fixed: Issue: Missing session rotation and CSRF protection, for the CSRF-protection part.
- Nice to have fixed: Issue: Weak session configuration.
- Nice to have fixed: Issue: Raw error disclosure and insecure auxiliary cookies.

If the site is accessible publicly:
- Must be fixed: Issue: URL-based auto-login bypass.
- Must be fixed: Issue: SQL injection exposure in auth and DB access.
- Must be fixed: Issue: Weak password hashing.
- Must be fixed: Issue: Weak session configuration.
- Must be fixed: Issue: Missing session rotation and CSRF protection.
- Nice to have fixed: Issue: Raw error disclosure and insecure auxiliary cookies.

# GDPR Review

- This review is code-visible only. It identifies GDPR-relevant issues that can be evidenced from the application code and local configuration. It is not a full legal audit of contracts, records of processing, retention policies, processor agreements, or live operational practice.
- The most directly implicated GDPR requirements are: Article 5(1)(f) integrity and confidentiality, Article 24 controller responsibility, Article 25 data protection by design and by default, and Article 32 security of processing.
- The review was done on the codebase updated to PHP 8.5 so refers to particular  

Code-visible GDPR issues and what should be done:
- Article 5(1)(f) and Article 32: personal data is not protected with security measures appropriate to the risk. Evidence in code includes raw SQL authentication queries in `web/htdocs/kimi_ET/libs/entities/user.php:115`, weak static-salt SHA-256 password hashing in `web/htdocs/kimi_ET/libs/entities/user.php:178`, insecure session setup in `web/htdocs/kimi_ET/libs/init.php:93`, missing session rotation in `web/htdocs/kimi_ET/ajax/check-login.php:1`, and raw SQL error disclosure in `web/htdocs/kimi_ET/libs/database.php:1` and many endpoint scripts. Fix: move critical auth and data-access paths to prepared statements, replace password storage with `password_hash()` plus migration logic, harden session cookies and login session rotation, and stop exposing raw DB errors to end users.
- Article 25 and Article 32: the URL-based auto-login flow is not privacy-safe by default. `web/htdocs/kimi_ET/index.php:11` allows direct authenticated access by URL parameters, and the same pattern is embedded into batch and telephony-generated links under `web/htdocs/kimi_ET/kimibatch/`. Fix: remove this mechanism, or replace it with short-lived signed one-time tokens, strict IP/network restrictions, and server-side expiry and audit controls.
- Article 25 and Article 32: the reviewed login and portal flow does not show CSRF protection for authenticated state-changing requests. Fix: introduce CSRF tokens for authenticated POST actions and verify them server-side.
- Article 24: the controller must be able to demonstrate appropriate technical and organisational measures. The repeated use of insecure defaults in the authentication, session, and DB layers indicates that current technical measures are not strong enough for a portal processing debtor/customer personal data. Fix: define and implement a minimum security baseline for authentication, session handling, error handling, and query execution, and keep it documented as part of the maintained application standard.
- Article 5(1)(f), Article 24, and Article 32: error handling currently risks unnecessary exposure of personal-data context and internal schema details through raw SQL errors. Fix: log technical errors to protected server logs, return generic user-safe error messages to the browser, and avoid including full SQL text in response content.
- Article 5(1)(e) storage limitation may be at risk, but this cannot be confirmed fully from the code reviewed. The application includes multiple log, archive, and batch-processing paths such as `web/htdocs/kimi_ET/config/config.php:39` with `kimi_archiv`, `web/htdocs/kimi_ET/libs/application.php:47`, and file logging such as `web/htdocs/kimi_ET/setticketcallinfo.php:258`. Fix: define retention periods for operational logs, archived records, telephony logs, and batch-import files, and implement deletion/anonymisation routines where required.
- Articles 13 and 14 transparency duties cannot be confirmed as satisfied from the reviewed application code alone. The UI links to `../datenschutz.html`, but this review did not validate whether the privacy notice fully covers purposes, legal bases, retention, recipients, and data subject rights. Fix: review the live privacy notice against actual processing activities and ensure it matches the implemented data flows.
- Articles 15 to 22 data subject rights workflows are not evident from the reviewed code. This does not prove non-compliance, but no clear application support for access, rectification, erasure, restriction, objection, or portability handling was identified in this review. Fix: confirm whether these requests are handled operationally outside the portal; if not, implement and document a controlled process.
- Articles 33 and 34 breach response obligations cannot be assessed from application code alone. Fix: ensure there is an organisational incident-response process covering detection, assessment, notification, and evidence preservation for personal-data breaches.

GDPR priorities if the current application remains in use:
- Must be fixed for GDPR:
- Remove or replace the URL-based auto-login mechanism.
- Eliminate SQL injection exposure in authentication and other personal-data access paths by using prepared statements.
- Replace static-salt SHA-256 password hashing with a modern password hashing scheme and migration path.
- Harden session security: secure cookie flags, consistent session handling, and session ID rotation on login.
- Stop returning raw SQL and internal error details to users.
- Nice to have fixed for GDPR:
- Add CSRF protection across authenticated state-changing actions.
- Formalise and implement retention/deletion rules for logs, archives, and batch-import data.
- Verify that the privacy notice fully reflects actual processing, recipients, retention, and rights handling.
- Document and, if needed, implement operational handling for data subject requests and breach response.
