
# Short document summary


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

- [S1] URL-based auto-login bypass.
  Business sense: this creates a direct authenticated access path without password verification. If such links leak through browser history, internal forwarding, logs, screenshots, copied URLs, or helper tools, unauthorized access to debtor/customer data becomes much easier.
  Evidence in code: `web/htdocs/kimi_ET/index.php:11`; the same pattern is also embedded into multiple batch and telephony-generated URLs under `web/htdocs/kimi_ET/kimibatch/`.
  What needs to be clarified before the fix: whether this mechanism is still genuinely required for telephony, batch, or agent workflows; whether the application is accessible only on a strictly private network; whether any safe replacement is operationally acceptable.
  How to fix: remove the mechanism if possible. If it must remain in some form, replace it with short-lived signed one-time tokens, strict server-side expiry, audit logging, and network/IP restrictions.
- [S2] SQL injection exposure in auth and DB access.
  Business sense: authentication and customer-data access are handled through raw SQL construction. This creates a risk of unauthorized data access, record manipulation, and compromise of personal data.
  Evidence in code: `web/htdocs/kimi_ET/libs/entities/user.php:115` and the broader raw-query pattern in `web/htdocs/kimi_ET/libs/database.php:1`.
  What needs to be clarified before the fix: which login, search, customer, ticket, and batch entry points still build SQL from untrusted values; whether there are helper wrappers already used anywhere for safer query construction.
  How to fix: migrate high-risk authentication and personal-data query paths to prepared statements.
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
- Must be fixed: [S2] SQL injection exposure in auth and DB access.
- Must be fixed: [S1] URL-based auto-login bypass, if there is any chance of lateral access, link sharing, or misuse by internal users or connected systems.
- Nice to have fixed: [S3] Weak password hashing.
- Nice to have fixed: [S5] Missing session rotation and CSRF protection, unless shared workstations, lateral access paths, externally reachable helper links, or browser-driven authenticated actions make session misuse realistic.
- Nice to have fixed: [S4] Weak session configuration.
- Nice to have fixed: [S6] Insecure auxiliary cookie handling.

## Public network access
If the site is accessible publicly:
- Must be fixed: [S1] URL-based auto-login bypass.
- Must be fixed: [S2] SQL injection exposure in auth and DB access.
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
  How to fix: remove this mechanism, or replace it with short-lived signed one-time tokens, strict IP/network restrictions, server-side expiry, and audit controls. Evidence in code includes [S1] URL-based auto-login bypass at `web/htdocs/kimi_ET/index.php:11` and multiple batch/telephony-generated links under `web/htdocs/kimi_ET/kimibatch/`.
  GDPR articles and justification: Article 25 data protection by design and by default and Article 32 security of processing require privacy-safe defaults and appropriate security. A passwordless URL-auth flow is difficult to justify as a secure default for debtor/customer data.
- [GDPR2] Weak protection of personal data in authentication and data access.
  Business sense: personal and debtor-related data is exposed to avoidable compromise risk because the authentication and data-access layers use weak security patterns.
  What needs to be clarified before the fix: whether the portal is public or strictly private, whether credentials may be reused elsewhere, whether shared workstations exist, and which query paths are highest-risk because they handle login or customer/debtor data directly.
  How to fix: the core required technical fix for this GDPR item is [S2] SQL injection exposure in auth and DB access, meaning critical authentication and personal-data query paths should be migrated to prepared statements. Conditional supporting fixes are [S3] weak password hashing, [S4] weak session configuration, and the session-rotation part of [S5] missing session rotation and CSRF protection; these improve the same GDPR concern but are currently lower-priority or deployment-dependent under the private-network assumption. Evidence in code includes [S2] SQL injection exposure in auth and DB access at `web/htdocs/kimi_ET/libs/entities/user.php:115`, [S3] weak password hashing at `web/htdocs/kimi_ET/libs/entities/user.php:178`, [S4] weak session configuration at `web/htdocs/kimi_ET/libs/init.php:93`, and [S5] missing session rotation and CSRF protection at `web/htdocs/kimi_ET/ajax/check-login.php:1`.
  GDPR articles and justification: Article 5(1)(f) integrity and confidentiality and Article 32 security of processing require security measures appropriate to the risk. Article 24 responsibility of the controller is also relevant because the controller must implement and be able to demonstrate appropriate measures.
- [GDPR3] Missing CSRF protection for authenticated state changes.
  Business sense: an authenticated user can potentially be tricked into submitting unwanted state-changing requests, which can affect customer records, logs, or case-processing actions.
  What needs to be clarified before the fix: which authenticated actions actually change data, whether they are triggered only by POST, and whether any integrations or frontend scripts would break once CSRF checks are enforced.
  How to fix: introduce CSRF tokens for authenticated POST actions and verify them server-side. Evidence in code overlaps with [S5] Missing session rotation and CSRF protection.
  GDPR articles and justification: Article 25 data protection by design and by default and Article 32 security of processing are relevant because integrity of personal-data processing depends on preventing unauthorized or manipulated actions under an authenticated user context.
- [GDPR4] Missing documented technical baseline for secure processing.
  Business sense: repeated insecure defaults across authentication, session handling, and DB access indicate the system lacks a clearly enforced minimum security standard.
  What needs to be clarified before the fix: whether any internal security standard, operational checklist, or deployment hardening guide already exists but is not reflected in the codebase or report inputs.
  How to fix: define and implement a minimum security baseline for authentication, session handling, error handling, and query execution, and keep it documented as part of the maintained application standard.
  GDPR articles and justification: Article 24 responsibility of the controller requires the controller to implement and be able to demonstrate appropriate technical and organisational measures. This is partly a governance/documentation issue, not only a coding issue.
- [GDPR5] Retention and storage-limitation controls are not evident from code.
  Business sense: the portal appears to maintain logs, archive data, telephony data, and batch-import artifacts, but the reviewed code does not show clear deletion, anonymisation, or retention enforcement.
  What needs to be clarified before the fix: actual production retention practice, whether `kimi_archiv` is used for regulated archiving, whether operational or contractual retention duties exist, and where file-based imports/exports are stored and cleaned up.
  How to fix: define retention periods for operational logs, archived records, telephony logs, and batch-import files, and implement deletion/anonymisation routines where required. Evidence includes `web/htdocs/kimi_ET/config/config.php:39` with `kimi_archiv`, `web/htdocs/kimi_ET/libs/application.php:47`, and file logging such as `web/htdocs/kimi_ET/setticketcallinfo.php:258`.
  GDPR articles and justification: Article 5(1)(e) storage limitation requires that personal data not be kept longer than necessary. This item cannot be fully confirmed from code alone, so it should be checked against real operations, DB content, and documented retention policy.
- [GDPR6] Transparency coverage cannot be confirmed from code alone.
  Business sense: the UI links to `../datenschutz.html`, but this review did not validate whether the privacy notice fully covers actual purposes, legal bases, retention, recipients, and rights.
  What needs to be clarified before the fix: the live privacy-notice text, real processing purposes, legal bases, recipients, retention statements, and whether employee/agent-facing and debtor/customer-facing notices differ.
  How to fix: review the live privacy notice against actual processing activities and ensure it matches the implemented data flows.
  GDPR articles and justification: Articles 13 and 14 information duties require clear information to data subjects. This is mainly a content/process review item rather than a pure code defect.
- [GDPR7] Data-subject-rights workflows are not evident in the reviewed implementation.
  Business sense: the review did not identify clear application support for access, rectification, erasure, restriction, objection, or portability handling. This does not prove non-compliance, because such requests may be handled operationally outside the portal.
  What needs to be clarified before the fix: whether such requests are currently handled manually, which teams handle them, whether turnaround times are documented, and whether the portal needs technical support for those workflows.
  How to fix: confirm whether these requests are handled outside the system; if not, implement and document a controlled process.
  GDPR articles and justification: Articles 15 to 22 data subject rights establish these rights. This item needs process review in addition to code review.
- [GDPR8] Breach-response readiness cannot be assessed from code alone.
  Business sense: application code does not show whether incident handling, assessment, evidence preservation, and notification responsibilities are operationally in place.
  What needs to be clarified before the fix: whether there is already an incident-response procedure, who owns breach assessment and notification, and whether evidence preservation/log access are operationally feasible.
  How to fix: ensure there is an organisational incident-response process covering detection, assessment, notification, and evidence preservation for personal-data breaches.
  GDPR articles and justification: Articles 33 and 34 personal data breach notification and communication govern breach notification and communication. This is primarily an organisational control item.

## GDPR Priorities
GDPR priorities if the current application remains in use:
### Must be fixed for GDPR:
- [GDPR1] URL-based auto-login is not privacy-safe by default.
- [GDPR2] Weak protection of personal data in authentication and data access.
### Nice to have fixed for GDPR, but should be checked carefully because they may move into must-fix depending on the real deployment, threat model, and organisational process maturity:
- [GDPR3] Missing CSRF protection for authenticated state changes.
- [GDPR4] Missing documented technical baseline for secure processing.
- [GDPR5] Retention and storage-limitation controls are not evident from code.
- [GDPR6] Transparency coverage cannot be confirmed from code alone.
- [GDPR7] Data-subject-rights workflows are not evident in the reviewed implementation.
- [GDPR8] Breach-response readiness cannot be assessed from code alone.

## GDPR-to-Security Dependency Map

Assumption [A1]: We assume that the site is accessible only private network by trusted users.
Assumption [A2]: Production setup: use HTTPS (Production is set up by Kimi's system administrators).
Assumption [A3]: Production setup: errors are hidden on production environment (Production is set up by Kimi's system administrators).

- [GDPR1] URL-based auto-login is not privacy-safe by default
  - depends on [S1] URL-based auto-login bypass
    - current priority: Must fix
    - what needs to be checked: whether any safe replacement is really needed, or whether the feature can be removed entirely
- [GDPR2] Weak protection of personal data in authentication and data access
  - depends on [S2] SQL injection exposure in auth and DB access
    - current priority: Must fix
    - what needs to be checked: identify all high-risk auth and personal-data query paths
  - depends on [S3] Weak password hashing
    - current priority: Must fix for public access; nice to have for strict private trusted network
    - what needs to be checked: public exposure, credential reuse risk, sensitivity of the data handled
    - interpretation under [A1]: likely nice to have unless passwords are reused elsewhere or data sensitivity/risk appetite requires stronger treatment
  - depends on [S4] Weak session configuration
    - current priority: Must fix for public access; nice to have for strict private trusted network
    - what needs to be checked: HTTPS enforcement, cookie exposure, shared workstation usage
    - interpretation under [A1]: likely nice to have unless internal network trust is weak or shared workstation/cookie exposure risk is real
  - depends on [S5] Missing session rotation and CSRF protection
    - current priority: session rotation must fix for public access; nice to have for strict private trusted network
    - what needs to be checked: shared workstations, lateral internal access, helper-link/browser misuse scenarios
    - interpretation under [A1]: session-rotation part is likely nice to have unless session misuse is realistic; CSRF part belongs more directly to [GDPR3]
- [GDPR3] Missing CSRF protection for authenticated state changes
  - depends on [S5] Missing session rotation and CSRF protection
    - current priority: Nice to have under [A1]; can become must fix if browser-driven authenticated actions create realistic misuse risk
    - what needs to be checked: which authenticated actions actually change data and whether those actions are exposed to browser-driven request forgery scenarios
    - interpretation under [A1]: still lower priority unless the workflow analysis shows a realistic misuse path
- [GDPR4] Missing documented technical baseline for secure processing
  - not tied to one single `S*` issue; this is a cross-cutting governance/control item informed by [S1] to [S5]
    - current priority: Nice to have
    - what needs to be checked: whether any internal security baseline or operational hardening standard already exists
- [GDPR5] Retention and storage-limitation controls are not evident from code
  - not tied to one single `S*` issue
    - current priority: Nice to have
    - what needs to be checked: actual production retention practice, contractual/legal retention obligations, archive usage, and cleanup of file-based data
    - interpretation under [A1]: needs process and data-lifecycle review, not primarily a code hotfix
- [GDPR6] Transparency coverage cannot be confirmed from code alone
  - not tied to one single `S*` issue
    - current priority: Nice to have
    - what needs to be checked: live privacy notice text, real processing purposes, legal bases, recipients, and retention wording
    - interpretation under [A1]: content/legal review item
- [GDPR7] Data-subject-rights workflows are not evident in the reviewed implementation
  - not tied to one single `S*` issue
    - current priority: Nice to have
    - what needs to be checked: existing manual handling process, team ownership, turnaround expectations, and whether technical support is needed
    - interpretation under [A1]: process review item
- [GDPR8] Breach-response readiness cannot be assessed from code alone
  - not tied to one single `S*` issue
    - current priority: Nice to have
    - what needs to be checked: existing incident-response procedure, breach ownership, and evidence/log access
    - interpretation under [A1]: organisational review item
  - related but secondary: [S6] Insecure auxiliary cookie handling
    - current priority: Nice to have
    - what needs to be checked: whether the auxiliary cookie is used in production and whether it contains or influences anything sensitive
    - interpretation under [A1]: stays secondary unless a separate exposure path is confirmed

## Issue Index

### Security Issues

| ID   | Title                                               | Current Priority |
|------|-----------------------------------------------------|---|
| S1   | URL-based auto-login bypass                         | Must fix for public access; must fix for private network if lateral access or link misuse is realistic |
| S2   | SQL injection exposure in auth and DB access        | Must fix |
| S3   | Weak password hashing                               | Must fix for public access; nice to have for private trusted network |
| S4   | Weak session configuration                          | Must fix for public access; nice to have for private trusted network |
| S5   | Missing session rotation and CSRF protection        | Must fix for public access; nice to have for private trusted network unless session misuse is realistic |
| S6   | Insecure auxiliary cookie handling                  | Nice to have |

### GDPR Issues

| ID    | Title                                                                        | Current Priority |
|-------|------------------------------------------------------------------------------|---|
| GDPR1 | URL-based auto-login is not privacy-safe by default                          | Must fix |
| GDPR2 | Inadequate protection of personal data in authentication and data access     | Must fix |
| GDPR3 | Missing CSRF protection for authenticated state changes                      | Nice to have; can become must fix depending on risk profile |
| GDPR4 | Missing documented technical baseline for secure processing                  | Nice to have; can become must fix depending on operational maturity |
| GDPR5 | Retention and storage-limitation controls are not evident from code          | Nice to have; requires operational verification |
| GDPR6 | Transparency coverage cannot be confirmed from code alone                    | Nice to have; requires legal/content review |
| GDPR7 | Data-subject-rights workflows are not evident in the reviewed implementation | Nice to have; requires process verification |
| GDPR8 | Breach-response readiness cannot be assessed from code alone                 | Nice to have; requires organisational verification |
