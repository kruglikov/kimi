
-- # ###########################################################################
-- # LOAD DER ELSBETH-Ergebnisse COEO - Beschreibung der notwendigen Aktionen  für COEO - Import Telefonieergebnisse LAUFEND & TAGESABSCHLUSS
-- # ###########################################################################


-- #1  LADER DER DATEN vom EXPORT ELSBETH
LOAD DATA LOCAL INFILE '#input#/COEO_ExportResult.csv' INTO TABLE `knp_out` CHARACTER SET 'latin1' FIELDS TERMINATED BY ';' ENCLOSED BY '"' ESCAPED BY '\\' LINES TERMINATED BY '\r\n' IGNORE 1 LINES
(
`nachname`,`vorname`,`ort`,`plz`,`strasse`,`letzter_anruf_kontakt_datetimeoffset`,`grund_negativer_ausgang`, `beschreibung_positiver_ausgang`,`status`,`nachname_agenten`,`vorname_agenten`,`ask_str_kontakt_telefonnummer`,`imp_str_ticketnr`,`imp_str_kontaktid`,`telefon`)
SET 
import = NOW(),
nachname = kimi_encrypt(nachname),
vorname = kimi_encrypt(vorname),
ort = kimi_encrypt(ort),
plz = kimi_encrypt(plz),
strasse = kimi_encrypt(strasse),
telefon = kimi_encrypt(telefon) ,
-- letzter_anruf_kontakt_datetimeoffset = date_format(str_to_date(letzter_anruf_kontakt_datetimeoffset, '%m/%d/%Y %h:%i:%s %p'), '%d.%m.%Y %H:%i:%s');

-- 28.10.2022 Datumsformatänderung
-- "8/24/2022 11:50:25 AM"
-- 28.10.2022 08:46:00

 letzter_anruf_kontakt_datetimeoffset = date_format(str_to_date(letzter_anruf_kontakt_datetimeoffset, '%d.%m.%Y %H:%i:%s'), '%d.%m.%Y %H:%i:%s');

