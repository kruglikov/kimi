INSERT INTO ticket
		(ticketnr,mandant_id,hauptticketnr,aktnummer,kunde_id,benutzer_id, beschreibung_detail,
		kundennummer,anrede,titel,nachname,vorname,plz,land_id,
		ort,strasse,hausnummer,telefon,telefon2,
        geburtsdatum,dummy_number5,
        dummy_number1,dummy_number2,dummy_number3,dummy_number4,dummy_number6,dummy_date1,dummy_text8,
	    dummy_text1, dummy_text2, dummy_text3, dummy_text4, dummy_text5, dummy_text6,dummy_text7,
		geaendert_am,geaendert_von,status_id,beginn,ende,prioritaet_id,kampagne_id,email,kenner,fahrgestellnummer,
		textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,wiedervorlage_automatik, anzahl_anrufe,dummy_text11,dummy_text12,grund_id)
	SELECT
		 concat(id,'001'), -- ticketnr
		43, -- mandant_id
		concat(id,'000'), -- hauptticketnr
		kontonummer, -- aktnummer
		0, -- kunde_id
		1, -- benutzer_id
		CONCAT( 'UNTERTICKET' , ' - ERSTE SMS' ,' - ', 'Bitte kontaktieren Sie uns zu Ihrer Verbindlichkeit zum KK: ',kontonummer, ' zahlungshilfe@sberbank-collections.de'), -- beschreibung_detail
		kundennummer, --  kundennummer
		gender, -- anrede
		null, -- titel
		kundenname, -- nachname
		null, -- vorname
		plz, -- plz
		2, -- land_id
		stadt, -- ort
		strasse, -- strasse
		null, -- hausnummer,
		CONCAT('00',TRIM(telefonnummer)), -- telefon
		TRIM(BORROWER_MOBIL), -- telefon2
        null, -- geburtsdatum -- ???
		year(NOW())- year(null) , -- dummy_number5
		kontonummer, -- dummy_number1
		null, -- dummy_number2
		null, -- dummy_number3
		ueberfaelliger_aussenstand, -- dummy_number4
		ueberfaelliger_aussenstand, -- dummy_number6
		maximaler_ptp, -- dummy_date1
		monatliche_rate, -- dummy_text8
        IFNULL(REPLACE(iban,' ',null),iban), -- dummy_text1
		IFNULL(REPLACE('bic',' ',null),'bic'), -- dummy_text2
		0, -- connect, -- dummy_text3
		0, -- rpc, -- dummy_text4
		0, -- ptp, -- dummy_text5
		concat('+43',BORROWER_DAILY_PHONE,'**27'), -- dummy_text6
		concat('+43',BORROWER_MOBIL,'**27'), -- dummy_text7
		NOW(), -- geaendert_am
'FranZ', -- geaendert_von
211, -- status_id
CURDATE(), -- beginn = Datum der Leistung
curdate(), -- ende
201, --  prioritaet_id -- > = Abschlussgrund
43, -- kampagne_id
TRIM(email_address), -- email
 CONCAT(RTRIM('sbname'),' / E-Mail: ',RTRIM('sbemail'),' / ',RTRIM('sbtelnr')), -- kenner
-- CONCAT(glname, ' / ' , glort), -- fahrgestellnummer
CONCAT('SBERBANK'), -- fahrgestellnummer
        CONCAT('ERSTE SMS' ,' - ', 'Bitte kontaktieren Sie uns zu Ihrer Verbindlichkeit zum KK: ',kontonummer, ' zahlungshilfe@sberbank-collections.de'), -- textinfo5,
         'Zeigen Sie Loesungsbereitschaft? Welche Möglichkeiten gibt es?',--  textinfo1
         'Wie sieht Ihr Loesungsvorschlag aus ? Hintergrund?', --  textinfo2
         CONCAT ( 
'- INTERNE Notizen', CHAR(13,10)
 ), -- dummy_text10
       
-- CONCAT(indexa,'-', indexb), -- dummy_text9,wiedervorlage_automatik, anzahl_anrufe
CONCAT(kontonummer), -- dummy_text9
1,-- wiedervorlage_automatik
0,-- anzahl_anrufe
null, -- dummy_text11,
null, -- dummy_text12 
null      -- grund_id
        from sberbank where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY)
