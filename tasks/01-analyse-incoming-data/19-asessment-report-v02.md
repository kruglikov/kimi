

# To Be Done

- Review all provided system documentation and source materials.
- Assess PHP 8.0 -> current supported PHP 8.5 migration feasibility.
- Highlight critical code sections, technical risks, and high-test-effort components.
- Review code-visible GDPR/DSGVO-relevant security aspects.
- Prepare a rough effort estimate for the migration work.

# Architectural overview
KIMI Portal is a legacy custom PHP/MariaDB business application with one main browser-based portal and a large set of supporting batch scripts. The main parts are authentication and session handling, mandant/role-based access control, customer and ticket management, campaign-specific UI modules, AJAX/telephony integration, and file/database-driven batch processing. The application is modular in structure but tightly coupled through shared bootstrap, database, and entity layers.

# Upgrade PHP Versions plan

[done] Make the system work:`
  - Create docker file with app and db container (this change should only add or wrap the current coding base, and do not change its structure )
  - Recreate database dump file from the code and apply it 
  - Create accounts in database to see that it work
  - Create seed data
[] Cover with tests (How? Scenarios we cover? How to test email sending? In general we only need to check that the filed do not chra)
    [] (How to deal with the copy\paste functionality files?)
    [] Batch processing tests - The test iterates over every *.php file in kimibatch/ that includes kimi_general.php - is that right? 
[] PHP Upgrade to php 8.5
  - 
[] Run tests

# Security review
[] Are `hash("sha256", "kimiplus" . $password)` with static salt "kimiplus" good enough from security reasons?  
[] Are security issues mentioned in ### Session Security Issues in @ARCHITECTURE.md severe\require solving?
[] Other security checks\review.
[] Is it something relevant: "- SQL injection vulnerabilities in `libs/entities/user.php:137` (raw string concatenation in login query) — GDPR relevance since it involves personal data access - No prepared statements throughout the DB layer (`libs/database.php`)" ?

# GDPR Review
[] GDPR Review


# Questions
