

# To Be Done

PHP current version: from 8.0. To be updated to 8.5 version 
Update project code  to 8.5 
Database version update:


# Architectural overview
TBD: Overview of all affected system areas


# Highlighted critical points and technical risks
## PHPMailer Update
- A legacy PHPMailer 2.0.4 copy is still present in the repository, but the visible active mail-sending code paths already use vendor PHPMailer 6.5.1. This should be treated as a dependency review and cleanup topic, not as a confirmed PHP 8.5 blocker, unless an additional runtime path still loads the old bundled copy.


# Upgrade plan

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
