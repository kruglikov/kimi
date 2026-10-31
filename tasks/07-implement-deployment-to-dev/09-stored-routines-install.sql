-- ============================================================================
-- KIMI Portal — ALL 37 stored routines for database `kimidev_et`
--   33 FUNCTIONs + 4 PROCEDUREs
-- ============================================================================
--
-- WHY THIS FILE EXISTS
--   ANEXIA's production `kimi_et` -> dev `kimidev_et` import was run WITHOUT
--   `mysqldump --routines`, so the dev server DB `kimidev_et` has ZERO stored
--   routines (verified: information_schema.ROUTINES returns 0). The application
--   depends on them — e.g. `kimi_decrypt`/`kimi_encrypt` read the AES-encrypted
--   columns, so Ticketsuche shows a page count but NO rows without them.
--   See tasks/07-implement-deployment-to-dev/06-found-problems-for-client.md
--   (Problem 4) for the full missing-routine list and impact.
--
-- SOURCE
--   Generated from the local docker `kimidev_et`, whose routines were loaded
--   verbatim from the client dump:
--   docs/08-franzs-letter-and-a-dump/KIMIPortal_Innowise#2/2281845-0402-MYSQL-kimidev_et-2026-06-01.sql
--
-- SAFETY (audited before install)
--   * Additive DDL only — no table/row/index/schema is changed; reversible.
--   * No destructive statements in any body (no DROP TABLE/TRUNCATE/DELETE/ALTER TABLE).
--   * 33 of 37 are read-only when called; the 4 writers (setAnrufTicket,
--     setNextWiedervorlage, update_log, update_ticket_anzahl_anrufe) only touch
--     the app's own call/log/ticket-count tables, and only when the app calls them.
--   * None reference the 9 missing insurance tables (Problem 1).
--   * DEFINER=`sql_kimidev_et`@`%` == the server's app account (CURRENT_USER),
--     and server log_bin=OFF, so install needs no SUPER / root credential.
--   * `CREATE OR REPLACE` makes this file safely re-runnable (idempotent).
--
-- NOTE (sensitive): the AES key 'Kimi#2021!Plus' is hardcoded inside the
--   kimi_encrypt / kimi_decrypt / kimi_decrypt_date bodies (as in the source dump).
--   Keep this file out of shared channels.
--
-- TO INSTALL (as the app user, from the server)
--   MYSQL_PWD=<CONF_MYSQL_PASSWORD> mariadb -u sql_kimidev_et kimidev_et < 09-stored-routines-install.sql
--
-- ROLLBACK
--   The server had 0 routines before this; to revert, DROP the 37 routines
--   (DROP FUNCTION IF EXISTS <name>; / DROP PROCEDURE IF EXISTS <name>;).
-- ============================================================================

-- MariaDB dump 10.19-12.3.2-MariaDB, for debian-linux-gnu (x86_64)
--
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Dumping routines for database 'kimidev_et'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getCleanPhoneNo`(phoneNo VARCHAR(500)) RETURNS varchar(500) CHARSET utf8mb3 COLLATE utf8mb3_uca1400_ai_ci
    DETERMINISTIC
BEGIN 
 DECLARE temp VARCHAR(1000); 
 DECLARE ch VARCHAR(1); 
 DECLARE i INT;
 DECLARE pattern VARCHAR(1000);
 SET i = 1;
 SET temp = '';
 SET pattern = '[a-z;/+\-\.:() ,A-Z]';
 IF phoneNo REGEXP pattern THEN 
  loop_label: LOOP 
   IF i>CHAR_LENGTH(phoneNo) THEN
    LEAVE loop_label;  
   END IF;
   SET ch = SUBSTRING(phoneNo,i,1);
   IF NOT ch REGEXP pattern THEN
    SET temp = CONCAT(temp,ch);
   ELSE
    SET temp = CONCAT(temp,'');
   END IF;
   SET i=i+1;
  END LOOP;
 ELSE
  SET temp = phoneNo;
 END IF;

 if (SUBSTRING(temp, 1,4) = '0043') THEN
   SET temp = SUBSTRING(temp, 5, LENGTH(temp)-4);
 END IF;
 if (SUBSTRING(temp, 1,4) = '+43') THEN
   SET temp = SUBSTRING(temp, 4, LENGTH(temp)-3);
 END IF;
 if (SUBSTRING(temp, 1,4) = '0049') THEN
   SET temp = SUBSTRING(temp, 5, LENGTH(temp)-4);
 END IF;
 if (SUBSTRING(temp, 1,4) = '+49') THEN
   SET temp = SUBSTRING(temp, 4, LENGTH(temp)-3);
 END IF;
 
 if (SUBSTRING(temp, 1,2) = '00') THEN
   SET temp = SUBSTRING(temp, 3, LENGTH(temp)-2);
 END IF;
 if (SUBSTRING(temp, 1,1) = '0') THEN
   SET temp = SUBSTRING(temp, 2, LENGTH(temp)-1);
 END IF;
  
 RETURN temp;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getCleanPhoneNoN`(phoneNo VARCHAR(500), defaultCountry VARCHAR(2), setVorwahl bool) RETURNS varchar(500) CHARSET utf8mb3 COLLATE utf8mb3_uca1400_ai_ci
    DETERMINISTIC
BEGIN 
 DECLARE temp VARCHAR(1000); 
 DECLARE ch VARCHAR(1); 
 DECLARE i INT;
 DECLARE hasLVorwahl BOOLEAN;
 DECLARE pattern VARCHAR(1000);
 SET i = 1;
 set hasLVorwahl = false;
 SET temp = '';
 SET pattern = '[a-z;/+\-\.:() ,A-Z]';
 SET phoneNo = trim(phoneNo);
 
 if substring(phoneNo, 1, 2) = '00' or substring(phoneNo, 1, 1) = '+' then
	set hasLVorwahl = true;
end if;
 
 IF phoneNo REGEXP pattern THEN 
	  loop_label: LOOP 
		   IF i>CHAR_LENGTH(phoneNo) THEN
			LEAVE loop_label;  
		   END IF;
		   SET ch = SUBSTRING(phoneNo,i,1);
		   IF NOT ch REGEXP pattern THEN
			SET temp = CONCAT(temp,ch);
		   ELSE
			SET temp = CONCAT(temp,'');
		   END IF;
		   SET i=i+1;
	  END LOOP;
 ELSE
	SET temp = phoneNo;
 END IF;

	 if (SUBSTRING(temp, 1,2) = '00') THEN
	   SET temp = SUBSTRING(temp, 3, LENGTH(temp)-2);
	 END IF;
	 if (SUBSTRING(temp, 1,1) = '0') THEN
	   SET temp = SUBSTRING(temp, 2, LENGTH(temp)-1);
	 END IF;

	

	IF defaultCountry <> "" and hasLVorwahl = false and setVorwahl and temp <> "" THEN

			Set temp = concat(defaultCountry, temp);

	END IF;





  
RETURN temp;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getFirmenIdFromAnrufzeitpunkt`(pnMandantId INT, psAnrufzeitpunkt VARCHAR(20) ) RETURNS int(11)
BEGIN
	DECLARE vId INT;
	DECLARE no_more_rows BOOLEAN;
	DECLARE curFirma CURSOR FOR 
		SELECT id FROM firma where mandant_id = pnMandantId and text = psAnrufzeitpunkt;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;
        
	OPEN curFirma;
	FETCH curFirma INTO vId;
	IF no_more_rows THEN
		Set vId = null;
	END IF;

	CLOSE curFirma;
RETURN vId;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getHauptTicketID`(pnTicketId int) RETURNS int(11)
BEGIN

	DECLARE nMandantId INT;
    DECLARE nHauptticketnr INT;
    DECLARE nHauptticket_id INT;
    DECLARE no_more_rows BOOLEAN;

	DECLARE curTicket CURSOR FOR 
		SELECT mandant_id, hauptticketnr from ticket where id = pnTicketId;

	DECLARE curHauptTicket CURSOR FOR 
		SELECT id from ticket 
			where mandant_id = nMandantId and ticketnr = nHauptticketnr
            and ticketnr = hauptticketnr
            order by 1 desc;
    
	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;
	SET no_more_rows = FALSE;
	SET nMandantId = 0;
    SET nHauptticketnr = 0;
    SET nHauptticket_id = 0;
	OPEN curTicket;
	FETCH curTicket INTO nMandantId, nHauptticketnr;
	IF no_more_rows THEN
		Set nMandantId = 0;
	END IF;
	CLOSE curTicket;
    
    SET nHauptticket_id =0;
    
    IF nMandantId > 0 THEN
		OPEN curHauptTicket;
		FETCH curHauptTicket INTO nHauptticket_id;
		IF no_more_rows THEN
			SET nHauptticket_id = pnTicketId;
		END IF;
		CLOSE curHauptTicket;
    END IF;
RETURN nHauptticket_id;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getHauptTicketNrFromAktnummer`(pnMandantId int, psAktnummer varchar(50)) RETURNS int(11)
BEGIN

    DECLARE nHauptticketnr INT;
    DECLARE no_more_rows BOOLEAN;

	DECLARE curTicket CURSOR FOR 
		SELECT ticketnr from ticket where mandant_id = pnMandantId and aktnummer = psAktnummer
           and ticketnr = hauptticketnr
          order by 1 desc;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;

    SET nHauptticketnr = 0;
	OPEN curTicket;
	FETCH curTicket INTO nHauptticketnr;
	IF no_more_rows THEN
		Set nHauptticketnr = 0;
	END IF;
	CLOSE curTicket;
    
RETURN nHauptticketnr;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLetzterAnruf`(pnTicketId INT) RETURNS datetime
BEGIN
	DECLARE vRetval DATETIME;
	DECLARE no_more_rows BOOLEAN;
	DECLARE curLog CURSOR FOR 
		SELECT timestamp FROM log where objekt = 'TICKET' and objekt_id = pnTicketId and logart = 'MAN_START' order by timestamp desc;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;
        
	SET vRetval = TRUE;
	OPEN curLog;
	FETCH curLog INTO vRetval;
	IF no_more_rows THEN
		Set vRetval = null;
	END IF;

	CLOSE curLog;
	

RETURN vRetval;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogAgentAnrede`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS varchar(50) CHARSET latin1 COLLATE latin1_swedish_ci
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN agentAnrede;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogAgentNachname`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS varchar(50) CHARSET latin1 COLLATE latin1_swedish_ci
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN agentNachname;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogAgentVorname`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS varchar(50) CHARSET latin1 COLLATE latin1_swedish_ci
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN agentVorname;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogAnrufVorhanden`(pnTicketId INT) RETURNS int(11)
BEGIN

	DECLARE retVal INTEGER;
    DECLARE retID INTEGER;
    DECLARE no_more_rows BOOLEAN;
	DECLARE curLog CURSOR FOR 
		SELECT id FROM log 
			where objekt = 'TICKET' 
            and objekt_id = pnTicketId 
            and logart like '%MAN_START%';
	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;
	SET retVal = 1;
	OPEN curLog;
	FETCH curLog INTO retID;
    IF no_more_rows THEN
		Set retVal = 0;
	END IF;
    CLOSE curLog;
RETURN retVal;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogAnzBearbeitungen`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS int(11)
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN anz_bearbeitungen;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogBenutzer`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS varchar(50) CHARSET latin1 COLLATE latin1_swedish_ci
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN benutzer;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogDauer`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS time
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN dauer;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogDauerInSec`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS int(11)
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN dauerinsec;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogEndGes`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS timestamp
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN end_ges;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogLastUserFranz`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS varchar(50) CHARSET latin1 COLLATE latin1_swedish_ci
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN lastuser_franz;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogObjektId`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS int(11)
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN id;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogStartGes`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS timestamp
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN start_ges;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getLogZeit`(pnTicketId int,  psZusatzLogTable varchar(50)) RETURNS time
BEGIN
	declare id 	int;
	declare start_ges timestamp;
	declare end_ges timestamp;
	declare anz_bearbeitungen int;
	declare zeit time;
	declare benutzer varchar(50);
	declare lastuser_franz varchar(50);
	declare dauer time;
	declare dauerinsec  int;
    declare agentAnrede varchar(50);
    declare agentVorname varchar(50);
    declare agentNachname varchar(50);

	declare result int;

	call readLogInfo(pnTicketId, psZusatzLogTable,
		id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec,
			agentAnrede, agentVorname, agentNachname);

	RETURN zeit;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getNextUnterticketNr`(pnMandantId INT, pnHauptticketNr INT ) RETURNS int(11)
BEGIN

	DECLARE nUnterticketNr INT;
    DECLARE nBase, nStart, nEnd int;
    DECLARE no_more_rows bool;
        
	DECLARE curTicket CURSOR FOR
		select max(ticketnr)+1 
        from ticket where mandant_id = pnMandantId and ticketnr between nStart AND nEnd;
        
	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;
   
    Set nBase = substr(pnHauptticketNr, 1, length(pnHauptticketNr)-3);
    Set nStart = concat(nBase, '000');
    Set nEnd = concat(nBase, '999');

	OPEN curTicket;
	FETCH curTicket INTO nUnterticketNr;
	IF no_more_rows THEN
		Set nUnterticketNr = 0;
	END IF;
	CLOSE curTicket;
    
    IF nUnterticketNr IS NULL THEN
		Set nUnterticketNr = 0;
    END IF;
    
RETURN nUnterticketNr;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getNextWorkDay`(pdDatum date, psNextZeitpunkt varchar(20)) RETURNS date
BEGIN
	DECLARE dDatum date;
    DECLARE bValid boolean;
    DECLARE nDummy integer;
    
    SET dDatum = pdDatum;
	SET bValid = FALSE;

	nextDay:loop
        IF isFeiertag(dDatum) = 0 THEN
          SET bValid = TRUE;
		END IF;
        
        IF bValid = TRUE THEN
            IF weekday(dDatum) = 6 THEN
				SET bValid = FALSE;
			END IF;
        END IF;
		




		IF bValid = TRUE THEN
			LEAVE nextDay;
        END IF;
        SET dDatum = date_add(dDatum, INTERVAL 1 DAY);
	END LOOP;


    RETURN dDatum;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getVorwahlFromTelNr`(pnLandVorwahl tinyint, psTelNr varchar(30)) RETURNS varchar(15) CHARSET utf8mb3 COLLATE utf8mb3_uca1400_ai_ci
BEGIN

	DECLARE sVorwahl VARCHAR(15);
	DECLARE no_more_rows BOOLEAN;
    DECLARE curVorwahl CURSOR FOR 
		SELECT vorwahl FROM vorwahlen 
        WHERE land = pnLandVorwahl AND LEFT(psTelNr, LENGTH(vorwahl)) = vorwahl 
        ORDER BY LENGTH(vorwahl) DESC, vorwahl DESC;

   	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;

	OPEN curVorwahl;
	FETCH curVorwahl INTO sVorwahl;
	IF no_more_rows THEN
		Set sVorwahl = '';
	END IF;

	CLOSE curVorwahl;

RETURN sVorwahl;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getVwHw`(pnLandVorwahl tinyint, psTelNr varchar(30)) RETURNS varchar(15) CHARSET utf8mb3 COLLATE utf8mb3_uca1400_ai_ci
BEGIN

	DECLARE sVorwahl VARCHAR(15);
    DECLARE sTelNr   VARCHAR(50);
	DECLARE no_more_rows BOOLEAN;
    DECLARE curVorwahl CURSOR FOR 
		SELECT vorwahl FROM vorwahlen 
        WHERE land = pnLandVorwahl AND LEFT(psTelNr, LENGTH(vorwahl)) = vorwahl 
        ORDER BY LENGTH(vorwahl) DESC, vorwahl DESC;

   	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;

	OPEN curVorwahl;
	FETCH curVorwahl INTO sVorwahl;
	IF no_more_rows THEN
        IF LEFT(psTelNr, 2) = '16' Or LEFT(psTelNr, 2) = '17' Or LEFT(psTelNr, 2) = '30' THEN
			SET sVorwahl = LEFT(psTelNr, 3);
		ELSE
			SET sVorwahl = LEFT(psTelNr, 4);
        END IF;
	END IF;
	CLOSE curVorwahl;
    
    SET sTelNr = TRIM( CONCAT(sVorwahl, ' ', RIGHT(psTelNr, LENGTH(psTelNr)-LENGTH(sVorwahl) )));
    
RETURN sTelNr;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `getZeitpunktText`(pdDatumZeit DATETIME) RETURNS text CHARSET utf8mb3 COLLATE utf8mb3_uca1400_ai_ci
BEGIN
	DECLARE vRetval varchar(20);
	DECLARE no_more_rows BOOLEAN;
    DECLARE zeit TIME;
	DECLARE curZeit CURSOR FOR 
		SELECT text FROM anrufzeiten where von <= zeit AND bis >= zeit;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;
        
	Set Zeit = Time(pdDatumZeit);

	OPEN curZeit;
	FETCH curZeit INTO vRetval;
	IF no_more_rows THEN
		Set vRetval = '--';
	END IF;

	CLOSE curZeit;
	

RETURN vRetval;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `get_log_last_user`(psObject Text, pnObjectId INT, psLogart Text) RETURNS text CHARSET utf8mb3 COLLATE utf8mb3_bin
BEGIN
	DECLARE vRetval text;
	DECLARE no_more_rows BOOLEAN;
	DECLARE curUser CURSOR FOR 
		SELECT benutzer FROM log where objekt = psObject and  objekt_id = pnObjectId and logart = psLogart ORDER BY ID DESC;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;

	OPEN curUser;
	FETCH curUser INTO vRetval;
	IF no_more_rows THEN
		Set vRetval = '--';
	END IF;

	CLOSE curUser;
	

RETURN vRetval;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `isFeiertag`(pdDatum DATE) RETURNS tinyint(1)
BEGIN
	DECLARE vRetval tinyint;
    DECLARE vId INT;
	DECLARE no_more_rows BOOLEAN;
	DECLARE curFeiertage CURSOR FOR 
		SELECT id FROM feiertage where feiertag = pdDatum;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;
        
	SET vRetval = 1;
	OPEN curFeiertage;
	FETCH curFeiertage INTO vId;
	IF no_more_rows THEN
		Set vRetval = 0;
	END IF;

	CLOSE curFeiertage;
RETURN vRetval;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `isTimeDiffHours`(pdTimestamp DATETIME, pdLastTimestamp DATETIME, pnHours INT) RETURNS tinyint(1)
BEGIN
   
    IF pdLastTimestamp = null THEN
      RETURN TRUE;
    END IF;

    IF time_to_sec( timediff( pdTimestamp, pdLastTimestamp ))/3600 < pnHours THEN
		RETURN FALSE;
    END IF;
    RETURN TRUE;

END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `kimi_decrypt`(psValue VARCHAR(4000)) RETURNS varchar(4000) CHARSET utf8mb3 COLLATE utf8mb3_uca1400_ai_ci
BEGIN
	DECLARE retVal varchar(4000);  
    SET retVal = aes_decrypt(from_base64(psValue), 'Kimi#2021!Plus');
RETURN retVal;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `kimi_decrypt_date`(psValue VARCHAR(4000)) RETURNS date
BEGIN
	DECLARE retVal varchar(4000);
    DECLARE retValDate date;
    SET retVal = aes_decrypt(from_base64(psValue), 'Kimi#2021!Plus');
    IF retVal != '' THEN
		IF locate('.', retVal) > 0 THEN
			Set retValDate = str_to_date(retVal, "%Y.%m.%d %H:%i:%s");
		ELSE
			Set retValDate = str_to_date(retVal, "%Y-%m-%d %H:%i:%s");
		END IF;    
    END IF;
RETURN retValDate;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `kimi_encrypt`(psValue VARCHAR(4000)) RETURNS varchar(4000) CHARSET utf8mb3 COLLATE utf8mb3_uca1400_ai_ci
BEGIN
	DECLARE retVal varchar(4000);
    SET retVal = to_base64(aes_encrypt(psValue, 'Kimi#2021!Plus'));

RETURN retVal;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `kimi_str_to_date`(psValue VARCHAR(50)) RETURNS date
BEGIN
    DECLARE retValDate date;
    IF psvalue != '' AND psValue != 'NULL' THEN
       Set retValDate = str_to_date(psValue, "%Y-%m-%d %H:%i:%s");
    END IF;
RETURN retValDate;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `setAnrufTicket`(pnTicketId INT, pbDoUpdate BOOLEAN) RETURNS tinyint(1)
BEGIN
    DECLARE bAddAnruf boolean;
    DECLARE nAnzAnrufe integer;
    DECLARE dLetzterAnruf datetime;
    DECLARE bUpdate boolean;
    DECLARE nMandantId integer;
    DECLARE nAutomatik tinyint;
    DECLARE bDoAnzAnrufe boolean;
    
    SELECT mandant_id, ifnull(anzahl_anrufe, 0), letzter_anruf, wiedervorlage_automatik 
		INTO nMandantId, nAnzAnrufe, dLetzterAnruf, nAutomatik
		from ticket WHERE id = pnTicketId;
    
    SET bUpdate = FALSE;
    IF dLetzterAnruf = NULL THEN
      SET dLetzterAnruf = NOW();
      SET bDoAnzAnrufe = TRUE;
    END IF;
    
    
    SET bAddAnruf = isTimeDiffHours(NOW(), dLetzterAnruf, 1);
    IF bAddAnruf Or bDoAnzAnrufe THEN
		SET nAnzAnrufe = nAnzAnrufe + 1;
        SET bUpdate = TRUE;
    END IF;
 
    SET dLetzterAnruf = NOW();
        
    IF pbDoUpdate THEN
		update ticket set letzter_anruf = dLetzterAnruf, 
        anzahl_anrufe = nAnzAnrufe where id = pnTicketId;
		IF nAutomatik=1 THEN
			call setNextWiedervorlage(pnTicketId, nMandantId, dLetzterAnruf, nAnzAnrufe);
		END IF;
	END IF;
    
    RETURN TRUE;
	
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` FUNCTION `testdate`(psText varchar(10)) RETURNS datetime
BEGIN

	declare retValDate datetime;
    
    if locate('.', psText) > 0 THEN
		Set retValDate = str_to_date(psText, "%Y.%m.%d %H:%i:%s");
	ELSE
		Set retValDate = str_to_date(psText, "%Y-%m-%d %H:%i:%s");
    END IF;
    
RETURN retValDate;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` PROCEDURE `readLogInfo`(pnTicketId int,  psZusatzLogTable varchar(50),
						out id 	int,
                        out start_ges timestamp,
                        out end_ges timestamp,
                        out anz_bearbeitungen int,
                        out zeit timestamp,
                        out benutzer varchar(50),
                        out lastuser_franz varchar(50),
                        out dauer time,
                        out dauerinsec1  int,
                        out agentAnrede varchar(50),
                        out agentVorname varchar(50),
                        out agentNachname varchar(50))
BEGIN
   	DECLARE no_more_rows BOOLEAN;
	DECLARE bFound BOOLEAN;
    
	DECLARE curBenAgent CURSOR FOR
		select vorname, nachname, anrede 
		from benutzer where concat(',', agent_name, ',') like concat('%,', benutzer, ',%');

    DECLARE curLog CURSOR FOR 
			select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
		select 
		log.start_objekt_id id,
		max(start_timestamp) start_ges,
		max(end_timestamp) end_ges,
		count(*) anz_bearbeitungen,
		TIMEDIFF(max(end_timestamp), 
			max(start_timestamp)) zeit,
		min(lastuser) benutzer,
		SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
		sum(dauer1) dauer,
		sum(dauerinsec) dauerinsec
		from (
		select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
		end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
		end.timestamp - start.timestamp dauer2,
		TIME_FORMAT(TIMEDIFF(end.timestamp, start.timestamp), 'H:i:s') dauer1,
		time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
		get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
		concat(start.timestamp,start.benutzer) lastuser_franz
		from  log  start 
			left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
		where start.objekt = 'TICKET' 
			and start.objekt_id = pnTicketId
			and start.logart in ('MAN_START') )  log
		group by log.start_objekt_id 
		) letzt_log
		left outer join benutzer ben on ben.name = letzt_log.benutzer;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;

    set id = null;
    set start_ges = null;
    set end_ges = null;
    set anz_bearbeitungen = null;
    set zeit = null;
    set benutzer = null;
    set lastuser_franz = null;
    set dauer = null;
    set dauerinsec1 = null;
	set agentAnrede = null;
    set agentVorname = null;
    set agentNachname = null;

	OPEN curLog;
	FETCH curLog INTO id, start_ges, end_ges, anz_bearbeitungen, zeit, benutzer, lastuser_franz, dauer, dauerinsec1,
			agentVorname, agentNachname, agentAnrede;
    CLOSE curLog;
    
    IF (ISNULL(agentNachname) OR agentNachname = '') AND benutzer != '' THEN
		OPEN curBenAgent;
      	FETCH curBenAgent INTO agentVorname, agentNachname, agentAnrede;
		CLOSE curBenAgent;
    END IF;    
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` PROCEDURE `setNextWiedervorlage`(pnTicketId integer, pnMandantId integer, pdLetzterAnruf datetime, pnAnzahlAnrufe tinyint)
BEGIN

	DECLARE nAddTage tinyint;
    DECLARE sZeitpunktNeu varchar(20);
	DECLARE sZeitpunktLetzterAnruf varchar(20);
    DECLARE bFound boolean;
    DECLARE dWiedervorlage date;
   	DECLARE no_more_rows BOOLEAN;

	
	DECLARE curKonfig CURSOR  FOR SELECT folgeanruf_tage, folgeanruf_zeitpunkt  FROM wiedervorlage_konfig 
		where mandant_id = pnMandantId
		and anruf_anzahl >= pnAnzahlAnrufe
		and anruf_zeitpunkt = sZeitpunktLetzterAnruf
	order by anruf_anzahl;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;

	SET sZeitpunktLetzterAnruf = getZeitpunktText(pdLetzterAnruf);
	SET bFound = TRUE;
	OPEN curKonfig;
	FETCH curKonfig INTO nAddTage, sZeitpunktNeu;
    IF no_more_rows THEN
       SET bFound = FALSE;
     END IF;
 
    CLOSE curKonfig;
    
	IF bFound THEN
   
        SET dWiedervorlage = getNextWorkDay(date_add(pdLetzterAnruf, INTERVAL nAddTage DAY), sZeitpunktNeu );
	 
		update ticket set 
			letzte_wiedervorlage = wiedervorlage,
            letzte_wiedervorlage_zeitpunkt = wiedervorlage_zeitpunkt,
			wiedervorlage = dWiedervorlage, 
            wiedervorlage_zeitpunkt = sZeitpunktNeu
			where id = pnTicketId;
    END IF;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` PROCEDURE `update_log`()
BEGIN
	DECLARE no_more_rows BOOLEAN;
	DECLARE cId INT;
	DECLARE cObjekt VARCHAR(15);
	DECLARE cObjekt_id INT;
	DECLARE cLogart VARCHAR(10);
	DECLARE cBenutzer VARCHAR(50);
	
	DECLARE cSearch	VARCHAR(10);
	DECLARE cSearch2 VARCHAR(10);

	DECLARE cKey 	VARCHAR(100);
	DECLARE cBreak	VARCHAR(100);

	DECLARE cStartID INT;
	
	DECLARE cur CURSOR  FOR SELECT id, objekt, objekt_id, logart, benutzer, start_id FROM log 
		WHERE cStartId is null AND logart IN ('MAN_END', 'MAN_END_A', 'AUTO_CLOSE', 'UPDATE') ORDER BY objekt_id, id desc;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;

	OPEN cur;
	myLoop: loop
		FETCH cur into cId, cObjekt, cObjekt_id, cLogart, cBenutzer, cStartId;
		
		IF no_more_rows THEN
			LEAVE myLoop;
		END IF;
		SET cSearch = '';
		SET cSearch2 = '';
		IF cLogart = 'UPDATE' THEN
			SET cSearch = 'MAN_START';
			SET cSearch2 = 'AUTO_OPEN';
		ELSEIF cLogart = 'MAN_END' Or cLogart = 'MAN_END_A' Or cLogart = 'UPDATE' THEN
			SET cSearch = 'MAN_START';
		ELSEIF cLogart = 'AUTO_CLOSE' THEN
			SET cSearch = 'AUTO_OPEN';
		END IF;

		IF cSearch != '' THEN
			SELECT MAX(id) INTO cStartID FROM log 
				WHERE objekt = cObjekt AND objekt_id = cObjekt_id AND benutzer = cBenutzer AND id < cID AND (logart = cSearch OR logart = cSearch2);
			UPDATE log SET start_id = cStartID WHERE ID = cID;
		END IF;
	END LOOP;
    CLOSE cur;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
DELIMITER ;;
CREATE OR REPLACE DEFINER=`sql_kimidev_et`@`%` PROCEDURE `update_ticket_anzahl_anrufe`()
BEGIN
	DECLARE no_more_rows BOOLEAN;
	DECLARE nTicketId INT;
    DECLARE dTimestamp DATETIME;
    DECLARE dLastTimestamp DATETIME;
    DECLARE nAnzahl INT;
	
	DECLARE curTicket CURSOR  FOR SELECT id FROM ticket 
		ORDER BY id;

	DECLARE curLog CURSOR  FOR SELECT timestamp FROM log 
		WHERE objekt = 'TICKET' and objekt_id = nTicketId AND logart = 'MAN_START' ORDER BY timestamp ;

	DECLARE CONTINUE HANDLER FOR NOT FOUND
		SET no_more_rows = TRUE;

	OPEN curTicket;
	LoopTicket: loop
		FETCH curTicket into nTicketId;
		
		IF no_more_rows THEN
			LEAVE LoopTicket;
		END IF;
        
        SET dLastTimestamp = NULL;
        SET nAnzahl = 0;
        OPEN curLog;
        LoopLog: loop
			FETCH curLog INTO dTimestamp;
            IF no_more_rows THEN
              SET no_more_rows = FALSE;
              LEAVE LoopLog;
            END IF;
            
            IF dLastTimestamp = NULL THEN
              SET nAnzahl = nAnzahl + 1;
			ELSEIF isTimeDiffHours(dTimestamp, dLastTimestamp, 1) THEN
              SET nAnzahl = nAnzahl + 1;
            END IF;
            SET dLastTimestamp = dTimestamp;
		END LOOP;
        CLOSE curLog;
        update ticket SET anzahl_anrufe = nAnzahl, letzter_anruf = dLastTimestamp where id = nTicketId;

	END LOOP;
    CLOSE curTicket;
END
;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

