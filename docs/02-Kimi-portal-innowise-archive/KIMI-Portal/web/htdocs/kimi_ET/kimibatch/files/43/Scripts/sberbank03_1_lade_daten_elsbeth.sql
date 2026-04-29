
-- # ###########################################################################
-- # LOAD DER ELSBETH-Ergebnisse SBERBANK - Beschreibung der notwendigen Aktionen  für SBERBANK - Import Telefonieergebnisse LAUFEND & TAGESABSCHLUSS
-- # ###########################################################################


-- #1  LADER DER DATEN vom EXPORT ELSBETH
LOAD DATA LOCAL INFILE '#input#/SBERBANK_ExportResult.csv' INTO TABLE `sberbank_out` CHARACTER SET 'latin1' FIELDS TERMINATED BY ';' ENCLOSED BY '"' ESCAPED BY '\\' LINES TERMINATED BY '\r\n' IGNORE 1 LINES
(
`nachname`,`vorname`,`ort`,`plz`,`strasse`,`letzter_anruf_kontakt_datetimeoffset`,`grund_negativer_ausgang`, `beschreibung_positiver_ausgang`,`status`,`nachname_agenten`,`vorname_agenten`,`ask_str_kontakt_telefonnummer`,`imp_str_ticketnr`,`imp_str_kontaktid`,`telefon`)
SET 
import = NOW() ;
