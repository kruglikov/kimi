
-- # ###########################################################################
-- # LOAD DER ELSBETH-Ergebnisse COEO - Beschreibung der notwendigen Aktionen  für COEO - Import Telefonieergebnisse LAUFEND & TAGESABSCHLUSS
-- # ###########################################################################


-- #1  LADER DER DATEN vom EXPORT ELSBETH
LOAD DATA LOCAL INFILE '#input#/KNP.csv' INTO TABLE `knp_out` CHARACTER SET 'latin1' FIELDS TERMINATED BY ';' ENCLOSED BY '"' ESCAPED BY '\\' LINES TERMINATED BY '\r\n' IGNORE 1 LINES
(
`nachname`,`vorname`,`ort`,`plz`,`strasse`,`letzter_anruf_kontakt_datetimeoffset`,`grund_negativer_ausgang`, `beschreibung_positiver_ausgang`,`status`,`nachname_agenten`,`vorname_agenten`,`ask_str_kontakt_telefonnummer`,`imp_str_ticketnr`,`letzter_Anruf_kontakt`)
SET 
import = NOW() ;
