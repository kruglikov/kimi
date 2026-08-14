INSERT INTO ticket
		(ticketnr,mandant_id,hauptticketnr,aktnummer,kunde_id,benutzer_id, beschreibung_detail,
		kundennummer,anrede,titel,nachname,vorname,plz,land_id,
		ort,strasse,hausnummer,telefon,telefon2,
        geburtsdatum,
        dummy_number1,dummy_number2,dummy_number3,dummy_number4,dummy_number6,dummy_number5,dummy_date1,dummy_text8,
	    dummy_text1, dummy_text2, dummy_text3, dummy_text4, dummy_text5, dummy_text6,dummy_text7,
		geaendert_am,geaendert_von,status_id,beginn,ende,prioritaet_id,kampagne_id,email,kenner,fahrgestellnummer,
		textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,wiedervorlage_automatik, anzahl_anrufe,dummy_text11,dummy_text12,grund_id)
SELECT
		(select max(ticketnr)+1  from ticket where mandant_id = 43 and ticketnr between concat(SUBSTR(hauptticketnr, 1, length(hauptticketnr)-3 ),'000') and concat(SUBSTR(hauptticketnr, 1, length(hauptticketnr)-3 ),'999') and aktnummer = kontonummer ),-- ticketnr
		43, -- mandant_id
		(select hauptticketnr  from ticket where mandant_id = 43 and ticketnr between concat(SUBSTR(hauptticketnr, 1, length(hauptticketnr)-3 ),'000') and concat(SUBSTR(hauptticketnr, 1, length(hauptticketnr)-3 ),'999') and aktnummer = kontonummer and curdate() between beginn and ende and status_id in (210,211) and ticketnr = hauptticketnr ), -- hauptticketnr
		kontonummer, -- aktnummer
		0, -- kunde_id
		1, -- benutzer_id
		CONCAT( 'ÄNDERUNG'  , ' - aktueller Aussenstand: ', aktueller_aussenstand_gesamt, ' - genehmigter Betrag: ' , genehmigter_betrag ,' Restlaufzeit Monate ' , rest_laufzeit_monate, CHAR(13,10),' Ende der Laufzeit: ', ende_der_laufzeit,' Tag der Einziehung: ' ,tag_der_einziehung, ' offene _raten: ',offene_raten, ' Erste Fälligkeit: ', erste_faelligkeit, ' Auszahlungstag: ' , auszahlungstag, CHAR(13,10),'NOTLEIDEND: ' , notleidend), -- beschreibung_detail
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
		TRIM(telefonnummer), -- telefon
		TRIM(borrower_phone), -- telefon2
        borrower_date_of_birth, -- geburtsdatum -- ???
		null, -- kontonummer, -- dummy_number1
		null, -- dummy_number2
		null, -- dummy_number3
		ueberfaelliger_aussenstand, -- dummy_number4
		null, -- ueberfaelliger_aussenstand, -- dummy_number6 - für die Eingabe dopppelt  oder doch leer?!
		aktueller_aussenstand_gesamt, -- dummy_number5
		maximaler_ptp, -- dummy_date1
		monatliche_rate, -- dummy_text8
        IFNULL(REPLACE(iban,' ',null),iban), -- dummy_text1
		null, -- dummy_text2
		0, -- connect, -- dummy_text3
		0, -- rpc, -- dummy_text4
		0, -- ptp, -- dummy_text5
		concat('+49',borrower_phone,'**27'), -- dummy_text6
		concat(borrower_email), -- dummy_text7		
		NOW(), -- geaendert_am
'FranZ', -- geaendert_von
211, -- status_id
CURDATE(), -- beginn = Datum der Leistung
DATE_ADD(CURDATE(),INTERVAL 
		CASE 
        WHEN DATE_FORMAT(CURDATE(), '%w') = 1 THEN 40 -- Montag 5
        ELSE collection_counter -- Anzahl Tage bis Inkasso - max. 40 !!
        END 
		DAY), -- ende
223, --  prioritaet_id -- > = Abschlussgrund
43, -- kampagne_id
TRIM(email_address), -- email
 CONCAT(RTRIM('sbname'),' / E-Mail: ',RTRIM('sbemail'),' / ',RTRIM('sbtelnr')), -- kenner
-- CONCAT(glname, ' / ' , glort), -- fahrgestellnummer
CONCAT('SBERBANK'), -- fahrgestellnummer
        CONCAT('Änderung'), -- textinfo5,
         'Datenabgleich - spreche ich mir der richtigen Person? Ohne diese Angaben darf keine Auskunft erteilt werden!!!',--  textinfo1
         'Wie sieht Ihr Loesungsvorschlag aus ? Welches Zahlungsdatum? Sollen wir den Betrag von Ihrem Konto einziehen?', --  textinfo2
         CONCAT ( 
'- INTERNE Notizen', CHAR(13,10)
 ), -- dummy_text10
       
-- CONCAT(indexa,'-', indexb), -- dummy_text9,wiedervorlage_automatik, anzahl_anrufe
CONCAT(kontonummer), -- dummy_text9
1,-- wiedervorlage_automatik
0,-- anzahl_anrufe
case when ifnull(co_borrower_name,'') != '' THEN
concat(co_borrower_gender, ' ',co_borrower_name, ' Geb:', co_borrower_date_of_birth, ' Adresse:', co_borrower_zip, ' ',co_borrower_city, ', ', co_borrower_street)
ELSE null END,-- dummy_text11 Daten CO-Borrower,
TRIM(co_borrower_phone), -- dummy_text12 
null      -- grund_id
        from sberbank where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY)
		and ifnull(aenderungs_kz,'NEU') != 'NEU'
