-- ============================================================================
-- KIMI Portal — fix the 6 `ticket`/`log` trigger DEFINERs on `kimidev_et`
-- ============================================================================
--
-- PROBLEM
--   Saving a ticket fails with:
--     "The user specified as a definer ('sql_kimi_et'@'%') does not exist"
--   The PROD `kimi_et` -> dev `kimidev_et` import carried the 6 triggers with
--   the PRODUCTION definer `sql_kimi_et`@`%`, which does NOT exist on the dev
--   server (the dev DB user is `sql_kimidev_et`). Two of them fire on every
--   ticket save (bu_ticket, bu_ticket_telnr = BEFORE UPDATE ON ticket), so any
--   save errors out. Same class of issue as the missing stored routines
--   (see 06-found-problems-for-client.md, Problem 4).
--
-- WHAT THESE TRIGGERS DO (must be preserved, not dropped)
--   bi_log            BEFORE INSERT ON log    - links MAN_END/AUTO_CLOSE rows to
--                                               their MAN_START via start_id
--   bi_ticket         BEFORE INSERT ON ticket - INSERT log row; hauptticketnr;
--                                               Wiedervorlage date/firma_id
--   bi_ticket_telnr   BEFORE INSERT ON ticket - search_telnr1/2 =
--                                               getCleanPhoneNoN(kimi_decrypt(telefon))
--   bu_ticket         BEFORE UPDATE ON ticket - UPDATE log row; archive OLD row
--                                               into ticket_historie (audit trail)
--   bu_ticket_telnr   BEFORE UPDATE ON ticket - rebuild search_telnr1/2
--   bd_ticket         BEFORE DELETE ON ticket - DELETE log row; archive into
--                                               ticket_historie
--   (they depend on the stored routines restored via 09-stored-routines-install.sql)
--
-- FIX
--   DROP + recreate all 6 with DEFINER=`sql_kimidev_et`@`%` (the dev app user,
--   which exists). Trigger BODIES are unchanged - only the definer differs.
--
-- SAFETY / FEASIBILITY
--   * app user sql_kimidev_et@% has ALL PRIVILEGES on kimidev_et (incl. TRIGGER),
--     server log_bin=OFF, and DEFINER == CURRENT_USER, so NO SUPER/root needed.
--   * Reversible; re-runnable (DROP ... IF EXISTS).
--
-- TO INSTALL (as the app user, from the server)
--   MYSQL_PWD=<CONF_MYSQL_PASSWORD> mariadb -u sql_kimidev_et kimidev_et < 10-fix-trigger-definers.sql
-- ============================================================================

DROP TRIGGER IF EXISTS `bi_log`;
DROP TRIGGER IF EXISTS `bi_ticket`;
DROP TRIGGER IF EXISTS `bi_ticket_telnr`;
DROP TRIGGER IF EXISTS `bu_ticket`;
DROP TRIGGER IF EXISTS `bu_ticket_telnr`;
DROP TRIGGER IF EXISTS `bd_ticket`;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sql_kimidev_et`@`%`*/ /*!50003 TRIGGER `bi_log` BEFORE INSERT ON `log` FOR EACH ROW
BEGIN
	DECLARE cSearch	VARCHAR(10);
	DECLARE cSearch2	VARCHAR(10);
	DECLARE cStartID INT;
	SET cSearch = '';
	SET cSearch2 = '';
		IF NEW.logart = 'MAN_END' Or NEW.logart = 'MAN_END_A' Or NEW.logart = 'UPDATE' THEN
			SET cSearch = 'MAN_START';
			SET cSearch2 = 'AUTO_OPEN';
		ELSEIF NEW.logart = 'MAN_END' Or NEW.logart = 'MAN_END_A' THEN
			SET cSearch = 'MAN_START';
		ELSEIF NEW.logart = 'AUTO_CLOSE' THEN
			SET cSearch = 'AUTO_OPEN';
		END IF;

		IF cSearch != '' THEN
			SELECT MAX(id) INTO cStartID FROM log 
				WHERE objekt = NEW.objekt AND objekt_id = NEW.objekt_id AND benutzer = NEW.benutzer AND (logart = cSearch OR logart = cSearch2);
			SET NEW.start_id = cStartID;
		END IF;
END 
*/;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sql_kimidev_et`@`%`*/ /*!50003 TRIGGER `bi_ticket` BEFORE INSERT ON `ticket` FOR EACH ROW
BEGIN
	DECLARE cID INT;
    DECLARE sZeitpunkt varchar(20);
    DECLARE Zeit time;
    DECLARE dWiedervorlage date;
    DECLARE  nHauptticketnr int;
    
	SELECT auto_increment INTO cID FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='ticket';
	INSERT INTO log (objekt, objekt_id, logart, timestamp, benutzer) values ('TICKET', cID, 'INSERT', NOW(), NEW.geaendert_von);

    IF NEW.aktnummer <> "" AND NEW.aktnummer is not null 
		AND (NEW.hauptticketnr is NULL OR NEW.hauptticketnr = 0)
    THEN 
		SET nHauptticketnr = getHauptTicketNrFromAktnummer(NEW.mandant_id, NEW.aktnummer);
        IF nHauptticketnr = 0 THEN
			SET nHauptticketnr = NEW.ticketnr;
        END IF;
        SET NEW.hauptticketnr = nHauptticketnr;
	END IF;


	
    IF NEW.wiedervorlage_automatik = 1 THEN
		SET dWiedervorlage = now();
		Set Zeit = Time(now());
		IF hour(Zeit) >= 0 AND hour(zeit) < 13 THEN
			IF isFeiertag(dWiedervorlage) Or weekday(dWiedervorlage) = 6 THEN
				SET dWiedervorlage = date_add(dWiedervorlage, INTERVAL 1 DAY);
				set sZeitpunkt = 'Früh';
			ELSE
				SET sZeitpunkt = 'Abend';
			END IF;
		ELSE
			SET dWiedervorlage = date_add(dWiedervorlage, INTERVAL 1 DAY);
			SET sZeitpunkt = 'Früh';
		END IF;
		
		SET NEW.wiedervorlage = dWiedervorlage;
		SET NEW.wiedervorlage_zeitpunkt = sZeitpunkt;
        
        SET NEW.firma_id = getFirmenIdFromAnrufzeitpunkt(NEW.mandant_id, NEW.wiedervorlage_zeitpunkt);
	END IF;
END 
*/;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sql_kimidev_et`@`%`*/ /*!50003 TRIGGER `bi_ticket_telnr` BEFORE INSERT ON `ticket` FOR EACH ROW
BEGIN

declare vorwahl varchar(2);

select m.land_vorwahl into vorwahl from mandant m where m.id = NEW.mandant_id;

if vorwahl = "" or vorwahl = null then
	set vorwahl = "43";
end if;

	SET NEW.search_telnr1 = getCleanPhoneNoN(kimi_decrypt(NEW.telefon), vorwahl, true);
    SET NEW.search_telnr2 = getCleanPhoneNoN(kimi_decrypt(NEW.telefon2), vorwahl, true);

END 
*/;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sql_kimidev_et`@`%`*/ /*!50003 TRIGGER `bu_ticket` BEFORE UPDATE ON `ticket` FOR EACH ROW
BEGIN
INSERT INTO log (objekt, objekt_id, logart, timestamp, benutzer) values ('TICKET', NEW.ID, 'UPDATE', NOW(), NEW.geaendert_von);


IF NEW.wiedervorlage_automatik = 1 THEN
  IF NEW.wiedervorlage_zeitpunkt != OLD.wiedervorlage_zeitpunkt 
		Or NEW.firma_id is null Or OLD.firma_id is null THEN
    SET NEW.firma_id = getFirmenIdFromAnrufzeitpunkt(NEW.mandant_id, NEW.wiedervorlage_zeitpunkt);
  END IF;
END IF;


INSERT INTO `ticket_historie`
(`ticket_id`,
`ticketnr`,
`mandant_id`,
`kunde_id`,
`benutzer_id`,
`kundennummer`,
`anrede`,
`titel`,
`nachname`,
`vorname`,
`plz`,
`land_id`,
`ort`,
`strasse`,
`hausnummer`,
`hausnummer_erw`,
`telefon`,
`email`,
`geburtsdatum`,
`kenner`,
`anruf_status_id`,
`ergebnis`,
`wiedervorlage`,
`wiedervorlage_zeitpunkt`,
`letzte_wiedervorlage`,
`letzte_wiedervorlage_zeitpunkt`,
`wiedervorlage_automatik`,
`anzahl_anrufe`,
`letzter_anruf`,
`status_id`,
`prioritaet_id`,
`beginn`,
`ende`,
`aufwand`,
`beschreibung_detail`,
`geaendert_am`,
`geaendert_von`,
`grund_id`,
`firma_id`,
`produkt_id`,
`bewertung`,
`katalogversand`,
`emailversand`,
`textinfo1`,
`textant11_janein_id`,
`textant12_nummern_id`,
`textant21_janein_id`,
`textant22_nummern_id`,
`telefon2`,
`standort`,
`verkaeufercode`,
`verkaeufername`,
`erstzulassung`,
`kundenzulassung`,
`markencode`,
`modell`,
`amtliches_kennzeichen`,
`fahrgestellnummer`,
`kilometer_stand`,
`textinfo2`,
`ltzt_wkst_auftrag`,
`textant31_janein_id`,
`textant32_nummern_id`,
`textinfo4`,
`textant41_janein_id`,
`textant42_nummern_id`,
`textinfo3`,
`textinfo5`,
`textant51_janein_id`,
`textant52_nummern_id`,
`kampagne_id`,
`dummy_text1`,
`dummy_text2`,
`dummy_text3`,
`dummy_text4`,
`dummy_text5`,
`dummy_text6`,
`dummy_text7`,
`dummy_text8`,
`dummy_text9`,
`dummy_text10`,
`dummy_number1`,
`dummy_number2`,
`dummy_number3`,
`dummy_number4`,
`dummy_number5`,
`dummy_number6`,
`dummy_number7`,
`dummy_number8`,
`dummy_number9`,
`dummy_number10`,
`dummy_date1`,
`dummy_date2`,
`dummy_date3`,
`dummy_date4`,
`dummy_date5`,
`dummy_date6`,
`dummy_date7`,
`dummy_date8`,
`dummy_date9`,
`dummy_date10`,
`dummy_id1`,
`dummy_id2`,
`dummy_id3`,
`dummy_id4`,
`dummy_id5`)
VALUES
(OLD.id,
OLD.ticketnr,
OLD.mandant_id,
OLD.kunde_id,
OLD.benutzer_id,
OLD.kundennummer,
OLD.anrede,
OLD.titel,
OLD.nachname,
OLD.vorname,
OLD.plz,
OLD.land_id,
OLD.ort,
OLD.strasse,
OLD.hausnummer,
OLD.hausnummer_erw,
OLD.telefon,
OLD.email,
OLD.geburtsdatum,
OLD.kenner,
OLD.anruf_status_id,
OLD.ergebnis,
OLD.wiedervorlage,
OLD.wiedervorlage_zeitpunkt,
OLD.letzte_wiedervorlage,
OLD.letzte_wiedervorlage_zeitpunkt,
OLD.wiedervorlage_automatik,
OLD.anzahl_anrufe,
OLD.letzter_anruf,
OLD.status_id,
OLD.prioritaet_id,
OLD.beginn,
OLD.ende,
OLD.aufwand,
OLD.beschreibung_detail,
NOW(),
NEW.geaendert_von,
OLD.grund_id,
OLD.firma_id,
OLD.produkt_id,
OLD.bewertung,
OLD.katalogversand,
OLD.emailversand,
OLD.textinfo1,
OLD.textant11_janein_id,
OLD.textant12_nummern_id,
OLD.textant21_janein_id,
OLD.textant22_nummern_id,
OLD.telefon2,
OLD.standort,
OLD.verkaeufercode,
OLD.verkaeufername,
OLD.erstzulassung,
OLD.kundenzulassung,
OLD.markencode,
OLD.modell,
OLD.amtliches_kennzeichen,
OLD.fahrgestellnummer,
OLD.kilometer_stand,
OLD.textinfo2,
OLD.ltzt_wkst_auftrag,
OLD.textant31_janein_id,
OLD.textant32_nummern_id,
OLD.textinfo4,
OLD.textant41_janein_id,
OLD.textant42_nummern_id,
OLD.textinfo3,
OLD.textinfo5,
OLD.textant51_janein_id,
OLD.textant52_nummern_id,
OLD.kampagne_id,
OLD.dummy_text1,
OLD.dummy_text2,
OLD.dummy_text3,
OLD.dummy_text4,
OLD.dummy_text5,
OLD.dummy_text6,
OLD.dummy_text7,
OLD.dummy_text8,
OLD.dummy_text9,
OLD.dummy_text10,
OLD.dummy_number1,
OLD.dummy_number2,
OLD.dummy_number3,
OLD.dummy_number4,
OLD.dummy_number5,
OLD.dummy_number6,
OLD.dummy_number7,
OLD.dummy_number8,
OLD.dummy_number9,
OLD.dummy_number10,
OLD.dummy_date1,
OLD.dummy_date2,
OLD.dummy_date3,
OLD.dummy_date4,
OLD.dummy_date5,
OLD.dummy_date6,
OLD.dummy_date7,
OLD.dummy_date8,
OLD.dummy_date9,
OLD.dummy_date10,
OLD.dummy_id1,
OLD.dummy_id2,
OLD.dummy_id3,
OLD.dummy_id4,
OLD.dummy_id5);

END 
*/;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sql_kimidev_et`@`%`*/ /*!50003 TRIGGER `bu_ticket_telnr` BEFORE UPDATE ON `ticket` FOR EACH ROW
BEGIN

declare vorwahl varchar(2);

select m.land_vorwahl into vorwahl from mandant m where m.id = NEW.mandant_id;
if vorwahl = "" or vorwahl = null then
	set vorwahl = "43";
end if;

	SET NEW.search_telnr1 = getCleanPhoneNoN(kimi_decrypt(NEW.telefon), vorwahl, true);
    SET NEW.search_telnr2 = getCleanPhoneNoN(kimi_decrypt(NEW.telefon2), vorwahl, true);

END 
*/;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`sql_kimidev_et`@`%`*/ /*!50003 TRIGGER `bd_ticket` BEFORE DELETE ON `ticket` FOR EACH ROW
BEGIN
INSERT INTO log (objekt, objekt_id, logart, timestamp, benutzer) values ('TICKET', OLD.ID, 'DELETE', NOW(), OLD.geaendert_von);

INSERT INTO `ticket_historie`
(`ticket_id`,
`ticketnr`,
`mandant_id`,
`kunde_id`,
`benutzer_id`,
`kundennummer`,
`anrede`,
`titel`,
`nachname`,
`vorname`,
`plz`,
`land_id`,
`ort`,
`strasse`,
`hausnummer`,
`hausnummer_erw`,
`telefon`,
`email`,
`geburtsdatum`,
`kenner`,
`anruf_status_id`,
`ergebnis`,
`wiedervorlage`,
`wiedervorlage_zeitpunkt`,
`letzte_wiedervorlage`,
`letzte_wiedervorlage_zeitpunkt`,
`wiedervorlage_automatik`,
`anzahl_anrufe`,
`letzter_anruf`,
`status_id`,
`prioritaet_id`,
`beginn`,
`ende`,
`aufwand`,
`beschreibung_detail`,
`geaendert_am`,
`geaendert_von`,
`grund_id`,
`firma_id`,
`produkt_id`,
`bewertung`,
`katalogversand`,
`emailversand`,
`textinfo1`,
`textant11_janein_id`,
`textant12_nummern_id`,
`textant21_janein_id`,
`textant22_nummern_id`,
`telefon2`,
`standort`,
`verkaeufercode`,
`verkaeufername`,
`erstzulassung`,
`kundenzulassung`,
`markencode`,
`modell`,
`amtliches_kennzeichen`,
`fahrgestellnummer`,
`kilometer_stand`,
`textinfo2`,
`ltzt_wkst_auftrag`,
`textant31_janein_id`,
`textant32_nummern_id`,
`textinfo4`,
`textant41_janein_id`,
`textant42_nummern_id`,
`textinfo3`,
`textinfo5`,
`textant51_janein_id`,
`textant52_nummern_id`,
`kampagne_id`,
`dummy_text1`,
`dummy_text2`,
`dummy_text3`,
`dummy_text4`,
`dummy_text5`,
`dummy_text6`,
`dummy_text7`,
`dummy_text8`,
`dummy_text9`,
`dummy_text10`,
`dummy_number1`,
`dummy_number2`,
`dummy_number3`,
`dummy_number4`,
`dummy_number5`,
`dummy_number6`,
`dummy_number7`,
`dummy_number8`,
`dummy_number9`,
`dummy_number10`,
`dummy_date1`,
`dummy_date2`,
`dummy_date3`,
`dummy_date4`,
`dummy_date5`,
`dummy_date6`,
`dummy_date7`,
`dummy_date8`,
`dummy_date9`,
`dummy_date10`,
`dummy_id1`,
`dummy_id2`,
`dummy_id3`,
`dummy_id4`,
`dummy_id5`)
VALUES
(OLD.id,
OLD.ticketnr,
OLD.mandant_id,
OLD.kunde_id,
OLD.benutzer_id,
OLD.kundennummer,
OLD.anrede,
OLD.titel,
OLD.nachname,
OLD.vorname,
OLD.plz,
OLD.land_id,
OLD.ort,
OLD.strasse,
OLD.hausnummer,
OLD.hausnummer_erw,
OLD.telefon,
OLD.email,
OLD.geburtsdatum,
OLD.kenner,
OLD.anruf_status_id,
OLD.ergebnis,
OLD.wiedervorlage,
OLD.wiedervorlage_zeitpunkt,
OLD.letzte_wiedervorlage,
OLD.letzte_wiedervorlage_zeitpunkt,
OLD.wiedervorlage_automatik,
OLD.anzahl_anrufe,
OLD.letzter_anruf,
OLD.status_id,
OLD.prioritaet_id,
OLD.beginn,
OLD.ende,
OLD.aufwand,
OLD.beschreibung_detail,
NOW(),
OLD.geaendert_von,
OLD.grund_id,
OLD.firma_id,
OLD.produkt_id,
OLD.bewertung,
OLD.katalogversand,
OLD.emailversand,
OLD.textinfo1,
OLD.textant11_janein_id,
OLD.textant12_nummern_id,
OLD.textant21_janein_id,
OLD.textant22_nummern_id,
OLD.telefon2,
OLD.standort,
OLD.verkaeufercode,
OLD.verkaeufername,
OLD.erstzulassung,
OLD.kundenzulassung,
OLD.markencode,
OLD.modell,
OLD.amtliches_kennzeichen,
OLD.fahrgestellnummer,
OLD.kilometer_stand,
OLD.textinfo2,
OLD.ltzt_wkst_auftrag,
OLD.textant31_janein_id,
OLD.textant32_nummern_id,
OLD.textinfo4,
OLD.textant41_janein_id,
OLD.textant42_nummern_id,
OLD.textinfo3,
OLD.textinfo5,
OLD.textant51_janein_id,
OLD.textant52_nummern_id,
OLD.kampagne_id,
OLD.dummy_text1,
OLD.dummy_text2,
OLD.dummy_text3,
OLD.dummy_text4,
OLD.dummy_text5,
OLD.dummy_text6,
OLD.dummy_text7,
OLD.dummy_text8,
OLD.dummy_text9,
OLD.dummy_text10,
OLD.dummy_number1,
OLD.dummy_number2,
OLD.dummy_number3,
OLD.dummy_number4,
OLD.dummy_number5,
OLD.dummy_number6,
OLD.dummy_number7,
OLD.dummy_number8,
OLD.dummy_number9,
OLD.dummy_number10,
OLD.dummy_date1,
OLD.dummy_date2,
OLD.dummy_date3,
OLD.dummy_date4,
OLD.dummy_date5,
OLD.dummy_date6,
OLD.dummy_date7,
OLD.dummy_date8,
OLD.dummy_date9,
OLD.dummy_date10,
OLD.dummy_id1,
OLD.dummy_id2,
OLD.dummy_id3,
OLD.dummy_id4,
OLD.dummy_id5);
END 
*/;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

