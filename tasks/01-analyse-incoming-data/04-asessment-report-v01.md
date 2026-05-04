

# To Be Done

PHP current version: from 8.0. To be updated to 8.5 version 
Update project code  to 8.5 
Database version update:


# Architectural overview
TBD: Overview of all affected system areas


# Highlighted critical points and technical risks
## PHPMailer Update
- 


# Upgrade plan

[] Make the system work:`
  - Create docker file with app and db container (this change should only add or wrap the current coding base, and do not change its structure )
  - Recreate database dump file from the code and apply it 
  - Create accounts in database to see that it work
  - Create seed data
[] Cover with tests (How? Scenarios we cover? How to test email sending? In general we only need to check that the filed do not chra)
    (How to deal with the copy\paste functionality files?)
[] PHP Upgrade to php 8.5
  - 
[] Run tests

# Security review
[] Are `hash("sha256", "kimiplus" . $password)` with static salt "kimiplus" good enough from security reasons?  
[] Are security issues mentioned in ### Session Security Issues in @ARCHITECTURE.md severe\require solving?
[] Other security checks\review.

# GDPR Review
[] GDPR Review


# Questions
