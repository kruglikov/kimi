-- ============================================================================
-- KIMI Portal — application-level column-encryption stored functions
-- ============================================================================
-- Primary function requested: kimi_decrypt  (kimi_encrypt + kimi_decrypt_date
-- included because they are the paired routines the app uses alongside it).
--
-- WHAT IT IS
--   The app stores certain columns AES-encrypted + base64 (e.g. ticket.telefon,
--   nachname, vorname, plz, ort, anrede, titel, …) and calls kimi_decrypt() at
--   read time — e.g. libs/entities/ticket.php:63-69 builds the Ticketsuche list
--   with kimi_decrypt(t.nachname), kimi_decrypt(t.vorname), … .
--
-- WHY THIS FILE EXISTS
--   The dev server DB `kimidev_et` is MISSING these routines (ANEXIA's
--   kimi_et -> kimidev_et import was done without --routines). Result:
--   "FUNCTION kimidev_et.kimi_decrypt does not exist", and ticket lists render
--   empty (the COUNT/pagination query works, the decrypting row query fails).
--   Verified: locally (routines present) the decrypt query returns 5,206 rows;
--   on the server it errors. See 05-smoke-failures-inventory.md.
--
-- SOURCE
--   Extracted verbatim from the client-provided dump:
--   docs/08-franzs-letter-and-a-dump/KIMIPortal_Innowise#2/2281845-0402-MYSQL-kimidev_et-2026-06-01.sql
--   (routine section, lines ~5446-5495). Original DEFINER = `sql_kimidev_et`@`%`
--   (dropped here so the file loads as the current user; add it back if needed).
--
-- NOTE (sensitive): the AES key 'Kimi#2021!Plus' is hardcoded in the routine
--   bodies exactly as in the source dump. Keep this file out of shared channels.
--
-- TO INSTALL
--   mariadb -u <user> -p kimidev_et < 08-kimi_decrypt-source.sql
--   (binary logging is off on the dev server, so no SUPER / log_bin_trust_function_creators needed)
-- ============================================================================

DELIMITER ;;

DROP FUNCTION IF EXISTS `kimi_decrypt` ;;
CREATE FUNCTION `kimi_decrypt`(psValue VARCHAR(4000)) RETURNS varchar(4000) CHARSET utf8
BEGIN
    DECLARE retVal varchar(4000);
    SET retVal = aes_decrypt(from_base64(psValue), 'Kimi#2021!Plus');
    RETURN retVal;
END ;;

DROP FUNCTION IF EXISTS `kimi_encrypt` ;;
CREATE FUNCTION `kimi_encrypt`(psValue VARCHAR(4000)) RETURNS varchar(4000) CHARSET utf8
BEGIN
    DECLARE retVal varchar(4000);
    SET retVal = to_base64(aes_encrypt(psValue, 'Kimi#2021!Plus'));
    RETURN retVal;
END ;;

DROP FUNCTION IF EXISTS `kimi_decrypt_date` ;;
CREATE FUNCTION `kimi_decrypt_date`(psValue VARCHAR(4000)) RETURNS date
BEGIN
    DECLARE retVal varchar(4000);
    DECLARE retValDate date;
    SET retVal = aes_decrypt(from_base64(psValue), 'Kimi#2021!Plus');
    IF retVal != '' THEN
        IF locate('.', retVal) > 0 THEN
            SET retValDate = str_to_date(retVal, "%Y.%m.%d %H:%i:%s");
        ELSE
            SET retValDate = str_to_date(retVal, "%Y-%m-%d %H:%i:%s");
        END IF;
    END IF;
    RETURN retValDate;
END ;;

DELIMITER ;
