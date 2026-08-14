

Hi Franz,

Thank you for the productive call yesterday. I wanted to write a follow-up to make sure we are aligned on the next steps and to clarify a few open points.

It seems like our deployment and test work is divided into a few parts/steps:

1. Setup new test environment
2. Deploy the updated PHP 8.5 code base and test database
3. Test & bugfix
4. Final deploy to production
5. Auto-login issue

Here are the ideas we discussed regarding each point and questions from my side:


## 1. Setup New Test Environment

Innowise will need to contact Anexia for the deployment setup process.

**Please confirm the understanding:**
- Anexia is your hosting provider and is responsible for provisioning the test server with the new OS (Debian 12 or 13), PHP 8.5, and an upgraded MariaDB version.
- Innowise and Anexia should collaborate: Anexia set's up the infrastructure layer (OS, PHP, DB versions), and Innowise needs either guide Anexia how to pre-setup project files or setup projetc files. 
- Innowise will receive VPN access to the test server to be able to deploy and test directly.

**Questions & discussion points:**
- Can Anexia deploy latest Debian, PHP 8.5, latest Maria DB, and copy the current codebase to new server with proper PHP setups from the old serer. Or they provide only the empty Debian server with PHP 8.5, latest Maria DB, and all the reest deployment is on Innowise? 
- Regarding the internal network, setup VPN and intergations with ELSBET and Call manager -  are there anything that Innowise should do, or these intergations are on Anexia?


## 2. Deploy the Updated PHP 8.5 Code Base and Test Database

**Please confirm the understanding:**
- Innowise will deploy the updated PHP 8.5 codebase to the test server once the environment is ready.
- For the database, we agreed on a two-option approach:
  - **Option A (try first):** Use the existing 2022 test database dump as-is. This is simpler and avoids any sensitive data concerns. The database structure should be the same as production, though some clients added after 2022 are not present.
  - **Option B (fallback):** If the 2022 data causes too many problems during testing, you will provide a stripped production dump — keeping the data of one less-sensitive client and removing all PII from the others. We can confirm whether Option A works once we start testing.
- Franz will provide the database dump (either option). 
- And for the dumps Franz will name what clients, tickets and other entities can be sued for testing.


## 3. Test & Bugfix

**Please confirm the understanding:**
- Testing will happen in two phases:
  - **Phase A (technical/functional testing by Innowise):** We will test the main system flows using the test database and report any issues found.
  - **Phase B (acceptance testing by KIMI team):** Once Innowise confirms the system is working, you and your colleagues (agents) will log into the test system and run through the actual call workflows to verify the system end-to-end.
- Franz writes test cases describing the flows to be tested (format: action → expected result).
- Viktor will provide examples of test scenarios - how to describe them.
- The Elsbeth and Call Manager integrations **cannot** be tested in the test environment because there are no test versions of those systems. These will only be validated when going live on production.

**Questions & discussion points:**
- Test scenarios are can we created in free form, and later we can adjust the form. In general we just need to make sure that all main success scenarious are covered. For example:
  - "Create new ticket: Enter Mandants list, click the Mandant, go to Tickets list and click 'Create ticket'. Then fill in the data and click Save. Expected result: New ticket is created."
  - "Manager the system from the Call application by the link: https://{sererIP}/kimi_ET/index.php?autologin=true&loginuser=tauschfranz&mandant=40&kId=34&ticket_id=28891&site=ticket&selected_tickets=28891&selected_ticket_index=0 Expected result: clent's ticket is opened and seen."
  - this is just examples, the main idea is to start express main success scenarios starting from the most important/critical (failed scenarious usually supplementary and it's redundant to describe). From what I understood from the meeting, the most critical end-to-end test is: open a ticket → process the call → record the result → verify the end-of-day export file contains the correct data.
  - How many clients/campaigns should the test cases cover? This is discussable - at least one.
  - Also what bulk scenarious (and exmaple csv files for them to be used) are discussable - at lease 1 should be tested, but I think you know better that scenrious are important.


## 4. Final Deploy to Production

**Questions:**
- Who is responsible for the final production deployment?
- What is the plan of the deployment  
- What is the rollback plan if a critical issue is discovered after going live? For example, is there a way to quickly restore the previous version, or would that require Anexia's involvement?


## 5. Auto-Login Issue

**Please confirm the understanding:**
- This issue is **deferred to Phase 2**, after the PHP 8.5 upgrade is deployed and stable on production. We agree this is the right order.
- Franz confirmed that the auto-login mechanism is actively used in production for two specific flows:
  1. **Elsbeth PowerDialing (outbound calls):** When a call connects, the Elsbeth client opens the KIMI ticket dialog in an embedded browser control using an autologin URL. The timing is critical — the agent has only ~5–10 seconds when the call connects to see the ticket.
  2. **Call Manager (inbound calls):** When an incoming call arrives, the system searches for the matching ticket by phone number and presents an autologin link to the agent.
- Franz proposed a **token-based approach**: instead of passing the username directly in the URL, Elsbeth and Telematica would be given a short-lived token (valid for 1 working day or similar). This would keep the one-click-open behavior for agents while eliminating the permanent credential exposure in the URL.

**Questions:**
- Am I understand right that all your managers who doing the calls, they should have access to _any_ ticket? 
