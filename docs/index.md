# KIMI Portal Docs — Index

Project communication history and context for the **KIMI Portal migration** (PHP 8.0 →
8.5 / MariaDB modernisation for KIMI Plus GmbH): client brief and responses, the original
Innowise archive, translated documentation, the audit deliverables, email threads with
Franz Tausch, meeting notes, VPN/SSH access material, and dev-server findings.

> This folder is **read-only reference material** (see project `CLAUDE.md`). Do not modify
> client-provided documents; add new incoming material as a new numbered subfolder.

---

## Loose files

- `03 Kimi-plus Fixes Estimate.xlsx` — spreadsheet estimating effort for the requested KIMI fixes.

## Subfolders

### `01-initial-request/` — Client brief & our response
The original engagement request and Innowise's confirmation.
- `initial-request.md` — client brief: company/project metadata plus the Initial Analysis scope (#1–#6: PHP 8.0.30 → 8.4+ migration feasibility, effort estimate, security/GDPR focus).
- `initial-responce.md` — Innowise's reply confirming a static-code-analysis audit (no code changes/runtime testing) and what it covers.

### `02-Kimi-portal-innowise-archive/` — Original client-supplied archive
The initial code + documentation package handed over by the client.
- `KIMI-Portal_Innowise.zip` — the original delivered archive.
- `KIMI-Portal/` — unpacked archive: `web/` source, `KIMIPortal_202604.pptx`, `KIMIPortal_DBModell.pdf`, `KIMIPortal_DokumentationÜbersicht.pdf`, and a `phpinfo()` capture of the PROD PHP 8.0.30 environment.

### `03-translated docs/` — Translated documentation
German→English / working copies of the client documentation.
- `KIMIPortal_202604.pptx` — portal overview slide deck.
- `KIMIPortal_DBModell.pdf` — database model / schema documentation.
- `KIMIPortal_DokumentationÜbersicht.pdf` — documentation overview.

### `04-results/` — Audit & upgrade deliverables
The task-1 deliverables (PHP 8.0→8.5 upgrade + security/GDPR audit).
- `Audit-report.md` — the audit report (security S1–S6, GDPR1–8, migration findings).
- `Audit-report.docx` — Word version of the audit report.
- `htdocs-folder-updated-to-php85.zip` — the upgraded PHP 8.5 `htdocs` folder.
- `upgraded-code-with-safety-net-test-updated-to-php85(optional-archive).zip` — upgraded code plus the smoke-test safety net (optional archive).

### `05-further-communications/` — Interim client updates
Status updates shared with the client (Confluence export).
- `01-client-update.md` — "Further Communication" page (Confluence) with a project status update.
- `78eea526-70d1-4915-824e-9af31e5670cc.png`, `image-20260520-144038.png.webp` — images embedded in the update.

### `06-meeting with Franz/` — Meeting notes & follow-up
Record of the client call with Franz Tausch and the follow-up Q&A.
- `01-meeting-transcript.md` — transcript of the meeting (Darya Nestserava ↔ Franz).
- `02-fullow-up-message-with-Franzs-answers.md` — follow-up doc with Franz's answers (new test environment setup, etc.).

### `07-followup-message-to-Franz/` — (placeholder)
Empty — reserved for a follow-up message to Franz.

### `08-franzs-letter-and-a-dump/` — Franz's letter + DB dump & test docs
Client-supplied package with a database dump and dev test cases.
- `KIMIPortal_Innowise#2.zip` — second delivery archive.
- `KIMIPortal_Innowise#2/` — unpacked: a `2026-06-01` MySQL dump of `kimidev_et` (`.sql` + `.sql.gz`).
- `KIMIPortal_Tests_DEV_20260607.pdf` / `…-English.pdf` — the DEV test cases (German + English) for the batch processes.

### `09-franz-email-2026-06-15/` — Email thread (Jun 15, 2026)
A multi-message email thread between Franz and Darya, with attachments.
- `email.md` — the thread in German.
- `email-en.md` — English translation of the thread.
- `attachments/` — `ticket.php`, `INKO2016.CSV`, and screenshots `image001–003.png`.

### `10-franz-email-2026-06-16/` — Email from Franz (Jun 16, 2026)
Franz's answers on test cases, DB changes (telnr5–telnr10 / ONCLICK call feature), PHP 8.5 / MariaDB 12.3 LTS versions.
- `franz-email-2026-06-16.md` — the email.

### `11-VPN-client/` — VPN access
FortiClient VPN client and credentials for reaching the ANEXIA dev/test network.
- `forticlient_vpn_7.4.3.5411_amd64.deb` — FortiClient VPN installer (Debian/amd64).
- `01-vpn-credentials.md` — VPN profile credentials (**sensitive** — user `kimiportal`).

### `12-ssh-keys/` — SSH keys for the dev server
Key pair provided to Franz/ANEXIA for `kimiportaldev.at@10.196.69.21` access.
- `id_ed25519` — private key (**sensitive**; keep out of shared channels).
- `id_ed25519.pub` — public key that was applied on the server.

### `13-franzs-answer/` — ANEXIA status + our dev-server findings
Franz's forwarded ANEXIA maintenance status and our verification of the test system.
- `franz-answer-2026-07-16.md` — Daniel Brunner's status (PROD DB imported to test; OS→Debian 13, PHP→8.5, MariaDB→12.3 LTS; new public key) and the ask to confirm readiness for PROD migration.
- `dev-server-findings-2026-07-21.md` — our SSH investigation: runtime is upgraded but the **old/original code** is deployed (not `src/upgraded-src/`); server facts and the old-vs-upgraded evidence.

### `14-update-from-Franz-about-the-database/` — DB import clarification
Franz relaying Anexia (Bernhard Schreitl) on the database import.
- `01-update-from-Franz-about-the-database.md` — `kimi_et` (PROD) imported into `kimidev_et` (test); `kimiportal` was empty on PROD; question about deleting the unused `kimiportal` / `kimiportaldev` databases.

### `15-the-most-recent-estimate-excel-file/` — Current effort estimate
The latest estimate spreadsheet for the deployment plus the requested fixes.
- `Kimi-plus Estimate Deplymnet + Fixes.xlsx` — deployment + fixes estimate; the Google Sheets copy shared with the client is linked from `docs/16-additional-feedback-from-franz/franz-email-2026-08-23-en.md`.

### `16-additional-feedback-from-franz/` — Franz's batch-test feedback (23 Aug 2026)
Franz's first batch tests on the upgraded test server plus his Firefox session-cookie finding, forwarded by Darya Nestserava on 24 Aug 2026.
- `franz-email-2026-08-23.md` — German original: answers entered in the Google Doc, batch-test log with OK/NOK verdicts (record counts not matching the input files: 29 vs 32, 4 vs 46, 28 vs 16), suspicion about the wrong `kimibatch/files` import directory, and the request for an alignment meeting.
- `franz-email-2026-08-23-en.md` — English translation of the same message, including the quoted 19 Aug 2026 message (`#1 Session-Cookie` — cannot reach the campaign selection in Firefox) and the quoted 18/14/13 Aug 2026 context.
- `franz-reported-problems-2026-08-23.md` — the problems extracted as an action list: P1–P3 the three import count mismatches, P4 the wrong upload directory as root-cause candidate, P5 the session-cookie item (already fixed, not repeated on 23 Aug), P6 his request for an afternoon alignment meeting.
- `google-doc-preexisting-issues-with-franz-answers.md` — downloaded copy of the shared Google Doc "Pre-existing issues found during the PHP 8.5 upgrade" including Franz's five answers (insurance/claims modules obsolete; the 7 `mysql_*` batch scripts removable; backup/variant files deletable; Anexia/DBA informed about the missing stored routines and the trigger definers).
- `attachments/` — 28 screenshots (`image001.png` … `image028.png`) referenced inline from the two email transcripts and from `franz-reported-problems-2026-08-23.md`.
