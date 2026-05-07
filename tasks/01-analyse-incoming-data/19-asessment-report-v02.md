
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
  Business sense: missing secure cookie flags and inconsistent session naming weaken session integrity and make session behavior harder to reason about and harden.
  Evidence in code: `web/htdocs/kimi_ET/libs/init.php:92-93`, `web/htdocs/kimi_ET/login.php:5`, `web/htdocs/kimi_ET/index.php:6`.
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

- This is a code-visible GDPR review. It covers issues that can be evidenced from the application code and local configuration. It is not a full legal audit of contracts, processor arrangements, records of processing, live retention practice, or operational procedures outside the application.
- The most directly implicated GDPR requirements are Article 5(1)(f) integrity and confidentiality, Article 24 responsibility of the controller, Article 25 data protection by design and by default, and Article 32 security of processing.
- GDPR does not create one set of duties for private networks and another for public deployments. The legal obligations remain the same. What changes is the Article 32 security of processing risk profile: public exposure usually makes weak controls less defensible and raises the likelihood that a finding should be treated as urgent.

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
- [GDPR4] Missing documented technical baseline for secure processing.
  Business sense: repeated insecure defaults across authentication, session handling, and DB access indicate the system lacks a clearly enforced minimum security standard.
  What needs to be clarified before the fix: whether any internal security standard, operational checklist, or deployment hardening guide already exists but is not reflected in the codebase or report inputs.
  Required governance / process tasks (priority: Nice to have):
  - Define a minimum security baseline for authentication, session handling, transport security, and query execution.
  - Align the implemented application behavior and deployment checklist with that baseline.
  - Keep the baseline documented and maintained as part of the application standard.
  GDPR articles and justification: Article 24 responsibility of the controller requires the controller to implement and be able to demonstrate appropriate technical and organisational measures. This is partly a governance/documentation issue, not only a coding issue.
- [GDPR5] Retention and storage-limitation controls are not evident from code.
  Business sense: the portal appears to maintain logs, archive data, telephony data, and batch-import artifacts, but the reviewed code does not show clear deletion, anonymisation, or retention enforcement.
  What needs to be clarified before the fix: actual production retention practice, whether `kimi_archiv` is used for regulated archiving, whether operational or contractual retention duties exist, and where file-based imports/exports are stored and cleaned up.
  Required governance / process tasks (priority: Nice to have):
  - Define retention periods for operational logs, archived records, telephony logs, and batch-import files.
  - Check where these data sets are stored in production and who is responsible for deletion or anonymisation.
  - Implement deletion or anonymisation routines where retention is no longer justified.
  GDPR articles and justification: Article 5(1)(e) storage limitation requires that personal data not be kept longer than necessary. This item cannot be fully confirmed from code alone, so it should be checked against real operations, DB content, and documented retention policy.
- [GDPR6] Transparency coverage cannot be confirmed from code alone.
  Business sense: the UI links to `../datenschutz.html`, but this review did not validate whether the privacy notice fully covers actual purposes, legal bases, retention, recipients, and rights.
  What needs to be clarified before the fix: the live privacy-notice text, real processing purposes, legal bases, recipients, retention statements, and whether employee/agent-facing and debtor/customer-facing notices differ.
  Required governance / process tasks (priority: Nice to have):
  - Review the live privacy notice against actual processing activities and data flows.
  - Check whether the notice correctly covers purposes, legal bases, recipients, retention, and rights.
  - Update the content where the implemented processing and the notice do not match.
  GDPR articles and justification: Articles 13 and 14 information duties require clear information to data subjects. This is mainly a content/process review item rather than a pure code defect.
- [GDPR7] Data-subject-rights workflows are not evident in the reviewed implementation.
  Business sense: the review did not identify clear application support for access, rectification, erasure, restriction, objection, or portability handling. This does not prove non-compliance, because such requests may be handled operationally outside the portal.
  What needs to be clarified before the fix: whether such requests are currently handled manually, which teams handle them, whether turnaround times are documented, and whether the portal needs technical support for those workflows.
  Required governance / process tasks (priority: Nice to have):
  - Confirm whether these requests are already handled outside the system and document that process.
  - If not, define a controlled workflow with owners, deadlines, and evidence handling.
  - Add portal support only if the process cannot be handled reliably outside the application.
  GDPR articles and justification: Articles 15 to 22 data subject rights establish these rights. This item needs process review in addition to code review.
- [GDPR8] Breach-response readiness cannot be assessed from code alone.
  Business sense: application code does not show whether incident handling, assessment, evidence preservation, and notification responsibilities are operationally in place.
  What needs to be clarified before the fix: whether there is already an incident-response procedure, who owns breach assessment and notification, and whether evidence preservation/log access are operationally feasible.
  Required governance / process tasks (priority: Nice to have):
  - Confirm whether there is an incident-response procedure covering personal-data breaches.
  - Define owners for detection, assessment, notification, and evidence preservation where they are missing.
  - Ensure operational access to the logs and records needed for breach assessment.
  GDPR articles and justification: Articles 33 and 34 personal data breach notification and communication govern breach notification and communication. This is primarily an organisational control item.

## GDPR Priorities

### Must be fixed for GDPR:
- [GDPR1] URL-based auto-login is not privacy-safe by default.
  - Related must-fix technical item: [S2] URL-based auto-login bypass.
- [GDPR2] Weak protection of personal data in authentication and data access.
  - Related must-fix technical item: [S1] SQL injection exposure in auth and DB access.
### Nice to have fixed for GDPR, but should be checked carefully because they may move into must-fix depending on the real deployment, threat model, and organisational process maturity:
- [GDPR3] Missing CSRF protection for authenticated state changes.
  - Related must-fix technical items under current assumptions: none.
- [GDPR4] Missing documented technical baseline for secure processing.
  - Related must-fix technical items under current assumptions: none.
- [GDPR5] Retention and storage-limitation controls are not evident from code.
  - Related must-fix technical items under current assumptions: none.
- [GDPR6] Transparency coverage cannot be confirmed from code alone.
  - Related must-fix technical items under current assumptions: none.
- [GDPR7] Data-subject-rights workflows are not evident in the reviewed implementation.
  - Related must-fix technical items under current assumptions: none.
- [GDPR8] Breach-response readiness cannot be assessed from code alone.
  - Related must-fix technical items under current assumptions: none.

# Further Steps

The main tasks to be fixed are either only 2 must have fixed:
- [S1] SQL injection exposure in auth and DB access.
- [S2] URL-based auto-login bypass
If the site accessible publicly, then we need to fix next "must fix" issues too:
- [S3] Weak password hashing.
- [S4] Weak session configuration.
- [S5] Missing session rotation and CSRF protection.

To continue with these fixes, we would very appreciate a real db dump with truncated data.   

## Testing problem\risks

Currently, we cannot test the application on our end, the final testing (including calls functionality, etc) is possible only on the Kimi's side. So some minor issues may be catched only on Kimi's side. This adds risks that Kimi should have capability to test and fix minor issues after final testing on their side. Or Innowise needs to have access to testing environmnet and include QA hours into the estimate.
