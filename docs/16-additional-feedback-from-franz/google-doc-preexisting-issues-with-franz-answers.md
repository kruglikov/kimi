# Pre-existing issues found during the PHP 8.5 upgrade — for client review (with Franz's answers)

> Downloaded 25 Aug 2026 from the Google Doc referenced in Franz's email of 23 Aug 2026:
> https://docs.google.com/document/d/1ZvnoYLuQxBI8MtmPjtA5KHgd7YK4sGJuU2OMGXZDZHg/edit
> Plain-text export, verbatim. The "Answer:" lines are Franz Tausch's replies (the ones he announced in his email).

---

Pre-existing issues found during the PHP 8.5 upgrade — for client review
While upgrading the dev code to PHP 8.5 and running our runtime safety-net (smoke) tests against the real dev database, we found several issues that are pre-existing — they are present in the current code and database and are not introduced by the upgrade. We confirmed they fail identically on the current dev server (same PHP 8.5, same database), so they are independent of our migration work.


The items below need a decision from you (they concern whether certain features/scripts are still in use). The genuine PHP 8.5 code issues that are our responsibility are being fixed as part of the upgrade and are not listed here, because they need no action from you.


________________


Problem 1 — Modules that query database tables which do not exist
A set of modules fail because they query tables that are absent from the kimidev_et database — both in our local copy and on the dev server (we verified the server has exactly the same 141 tables, so nothing is missing from our side). These modules appear to belong to an insurance / claims feature set (Versicherung / Schadensfall) that is not provisioned in this database instance. Any screen or job that opens one of these modules currently errors with Table 'kimidev_et.<name>' doesn't exist.


The 9 database tables that do not exist (and are referenced by the code):


#
	Missing table
	1
	bankleitzahl
	2
	inkassoinformation
	3
	inkassostatus
	4
	kundenhistorie
	5
	lastschrift
	6
	schadensfall_art
	7
	stammdaten
	8
	status_schadensfall
	9
	versicherung
	

The module files that reference those tables — each of the following exists in three module sets (modules/gui/, modules/initial/, and modules/menu/), i.e. ~33 files in total:


#
	Module file (present in modules/gui/, modules/initial/, modules/menu/)
	Missing table(s) it queries
	1
	bankleitzahl.php
	bankleitzahl
	2
	buchungen.php
	inkassostatus
	3
	inkassoinformation.php
	inkassoinformation
	4
	kundenhistorie.php
	kundenhistorie
	5
	lastschrift.php
	lastschrift
	6
	schadensfall.php
	schadensfall_art
	7
	schadensfall_art.php
	schadensfall_art
	8
	stammdaten.php
	inkassostatus
	9
	stammsuche.php
	stammdaten
	10
	status_schadensfall.php
	status_schadensfall
	11
	versicherung.php
	versicherung
	

Question for you: Is this insurance/claims feature supposed to exist in this environment (i.e. are these tables missing and should be created/imported), or are these modules obsolete/dead and safe to ignore or remove?


Answer: These insurance/claims functions are taken from modules that are no longer in use and are therefore obsolete or no longer required; they can be safely ignored or removed.
________________


Problem 2 — Batch scripts using a database API removed in PHP 7.0
7 batch scripts use the old mysql_* functions (mysql_query() / mysql_fetch_array()), which were removed from PHP in version 7.0. This means these scripts have already been failing on the current PHP 8.5 dev server, independently of our upgrade. In practice this is a strong signal that they are no longer in active use: a scheduled job that fataled on every run would have surfaced as a visible failure long ago — so if any one of them is still expected to run, that itself is worth flagging.


#
	Batch script (kimibatch/)
	1
	inko201604_status_offen_auf_inA_setzen.php
	2
	inkode04_status_offen_auf_inA_setzen.php
	3
	inkodeexp_new.php
	4
	oko04_status_offen_auf_inA_setzen.php
	5
	oko04_status_offen_vortage_auf_inA_setzen.php
	6
	oko_inA_outbound_elsbeth.php
	7
	okoexpzwb.php
	

Question for you: Are these batch jobs still in use? If yes, we can modernize them — but note this is a genuine rewrite-and-test effort, not a one-line swap: the newer mysqli_* API requires the database connection to be passed explicitly, and because these scripts have been broken for years there is no working baseline to compare the result against, so each one has to be re-read, corrected, and validated (especially the ones that write data). If no, they can simply be removed.


Answer: These batch jobs are no longer in use and can therefore be removed


________________


Problem 3 — Old backup / variant copies of modules
A few dated backup or experimental copies of files error on load. They look like leftovers rather than active code.


#
	File
	Issue
	1
	modules/gui/ticket_201502071142.php
	dated backup (2015-02-07), undefined variable
	2
	modules/gui/ticket_sich20150208.php
	dated backup ("Sicherung" 2015-02-08), undefined language constant
	3
	modules/initial/ticketsuch_sich20150208.php
	dated backup (2015-02-08), calls Ticket::count() with the wrong number of arguments
	4
	kimibatch/inkodeimp2x.php
	experimental variant (…2x), calls an undefined helper bFetchArray()
	

Question for you: Can these backup/variant files be removed?


Answer: These backup/variant files can be deleted


________________


Problem 4 — The database was migrated without its stored functions/procedures
When production kimi_et was imported into the dev database kimidev_et, the import ran without stored routines (mysqldump --routines was not used), so all 37 stored functions/procedures are missing on the dev server — including kimi_decrypt and kimi_encrypt, which the application uses to read its AES-encrypted columns.


Impact: any screen or query that decrypts customer data fails with FUNCTION kimidev_et.kimi_decrypt does not exist. For example, Ticketsuche shows the page count (e.g. "397 pages") but no ticket rows — the row query that calls kimi_decrypt(...) errors, while the separate COUNT query (which does not decrypt) still returns a count.


The 37 missing routines (verified: information_schema.ROUTINES for kimidev_et returns 0 on the dev server; the same schema from the client dump has 33 functions + 4 procedures):


Encryption / date routines — the immediate blockers:


#
	Type
	Name
	1
	FUNCTION
	kimi_decrypt
	2
	FUNCTION
	kimi_encrypt
	3
	FUNCTION
	kimi_decrypt_date
	4
	FUNCTION
	kimi_str_to_date
	

Other functions:


#
	Type
	Name
	#
	Type
	Name
	5
	FUNCTION
	getCleanPhoneNo
	20
	FUNCTION
	getNextUnterticketNr
	6
	FUNCTION
	getCleanPhoneNoN
	21
	FUNCTION
	getNextWorkDay
	7
	FUNCTION
	getFirmenIdFromAnrufzeitpunkt
	22
	FUNCTION
	getVorwahlFromTelNr
	8
	FUNCTION
	getHauptTicketID
	23
	FUNCTION
	getVwHw
	9
	FUNCTION
	getHauptTicketNrFromAktnummer
	24
	FUNCTION
	getZeitpunktText
	10
	FUNCTION
	getLetzterAnruf
	25
	FUNCTION
	get_log_last_user
	11
	FUNCTION
	getLogAgentAnrede
	26
	FUNCTION
	isFeiertag
	12
	FUNCTION
	getLogAgentNachname
	27
	FUNCTION
	isTimeDiffHours
	13
	FUNCTION
	getLogAgentVorname
	28
	FUNCTION
	setAnrufTicket
	14
	FUNCTION
	getLogAnrufVorhanden
	29
	FUNCTION
	testdate
	15
	FUNCTION
	getLogAnzBearbeitungen
	30
	FUNCTION
	getLogEndGes
	16
	FUNCTION
	getLogBenutzer
	31
	FUNCTION
	getLogStartGes
	17
	FUNCTION
	getLogDauer
	32
	FUNCTION
	getLogZeit
	18
	FUNCTION
	getLogDauerInSec
	33
	FUNCTION
	getLogObjektId
	19
	FUNCTION
	getLogLastUserFranz
	

	

	

	

Procedures:


#
	Type
	Name
	34
	PROCEDURE
	readLogInfo
	35
	PROCEDURE
	setNextWiedervorlage
	36
	PROCEDURE
	update_log
	37
	PROCEDURE
	update_ticket_anzahl_anrufe
	

Good news: the encryption key still matches the data — kimi_decrypt with the key from the dump correctly decrypts 99.4% of the server's ticket.telefon values — so the routines can be restored losslessly from the client-provided dump (docs/08-…/2281845-0402-MYSQL-kimidev_et-2026-06-01.sql; the extracted definitions are in tasks/07-implement-deployment-to-dev/08-kimi_decrypt-source.sql).


Action: we can restore the 37 routines onto kimidev_et (additive CREATE FUNCTION/PROCEDURE only — no data change, reversible) so the app works. Please also ensure any future or PROD database imports include the routines (mysqldump --routines) so this does not recur.


Answer: I have informed Anexia, and Mr Brunner has passed this on to his colleagues at DBA
________________


Problem 5 — The migration also left database triggers pointing at a non-existent (production) definer
Closely related to Problem 4 (same migration gap): when production kimi_et was imported into kimidev_et, the 6 database triggers on the ticket / log tables were carried over with the production definer `sql_kimi_et`@`%`, which does not exist on the dev server (the dev database user is sql_kimidev_et). Because two of these triggers fire on every ticket save (bu_ticket, bu_ticket_telnr = BEFORE UPDATE ON ticket), saving any ticket on the dev server currently fails with:


The user specified as a definer ('sql_kimi_et'@'%') does not exist


The 6 affected triggers (and what they do — they must be kept, not removed):


#
	Trigger
	Fires on
	Purpose
	1
	bu_ticket
	BEFORE UPDATE ticket
	writes an UPDATE log row and archives the prior row into ticket_historie (audit trail)
	2
	bu_ticket_telnr
	BEFORE UPDATE ticket
	rebuilds the search_telnr1/2 phone-search index (uses kimi_decrypt + getCleanPhoneNoN)
	3
	bi_ticket
	BEFORE INSERT ticket
	writes an INSERT log row; computes hauptticketnr and the Wiedervorlage date / firma_id
	4
	bi_ticket_telnr
	BEFORE INSERT ticket
	builds the search_telnr1/2 phone-search index
	5
	bd_ticket
	BEFORE DELETE ticket
	writes a DELETE log row and archives the row into ticket_historie
	6
	bi_log
	BEFORE INSERT log
	links a call's end/close log row to its start row (start_id)
	

Impact: agents cannot save ticket edits on the dev server; ticket insert/delete are affected too (the ticket_historie audit trail and the phone-search index depend on these triggers). Note these triggers also depend on the stored routines from Problem 4, so both must be present for saving to work.


Action: we recreate the 6 triggers with a valid definer (`sql_kimidev_et`@`%` — bodies unchanged; additive and reversible, no data change, no admin/root credential needed). Please also ensure any future or PROD database imports recreate triggers (and views) with a definer that exists on the target server — the same migration gap as Problem 4.


Answer: I have informed Anexia, and Mr Brunner has passed this on to his colleagues at DBA
________________


Not requiring your action (for context only)
* Local test-data artifacts — a small number of failures (Duplicate entry, Data too long, Can't find file …) are caused by our local subset of the database and missing local batch input files, not by the code. They do not occur on the server with the full data.
* Genuine PHP 8.5 code fixes — issues that are truly part of the 8.5 migration (e.g. a count(null) case) are being handled by us and need no input from you.


Full internal analysis with counts and evidence: tasks/07-implement-deployment-to-dev/05-smoke-failures-inventory.md.