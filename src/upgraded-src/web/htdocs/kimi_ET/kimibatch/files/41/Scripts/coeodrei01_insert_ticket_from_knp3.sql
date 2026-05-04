INSERT INTO ticket
		(ticketnr,mandant_id,kunde_id,benutzer_id, beschreibung_detail,
		kundennummer,anrede,titel,nachname,vorname,plz,land_id,
		ort,strasse,hausnummer,telefon,telefon2,
        geburtsdatum,dummy_number5,
        dummy_number1,dummy_number2,dummy_number3,dummy_number4,dummy_text8,
	    dummy_text1, dummy_text2, dummy_text3, dummy_text4, dummy_text5, dummy_text6,dummy_text7,
		geaendert_am,geaendert_von,status_id,beginn,ende,prioritaet_id,kampagne_id,email,kenner,fahrgestellnummer,
		textinfo5,textinfo1,textinfo2,dummy_text10,dummy_text9,wiedervorlage_automatik, anzahl_anrufe,dummy_text11,dummy_text12,grund_id,dummy_text13)
		SELECT
		 id, -- ticketnr
		41, -- mandant_id
		0, -- kunde_id
		1, -- benutzer_id
		CONCAT( 'OUTBOUND CH', " / ", kampagne, " " , anwalt , CHAR(13,10), bemerkung ), -- beschreibung_detail
		0, --  kundennummer
		null, -- anrede
		null, -- titel
		name, -- nachname
		vorname, -- vorname
		plz, -- plz
		4, -- land_id
		ort, -- ort
		strasse, -- strasse
		null, -- hausnummer,
		kimi_encrypt(CONCAT('00',TRIM(kimi_decrypt(telnr)))), -- CONCAT('00',TRIM(telnr)), -- telefon / TF 25.4.2022
		TRIM(telnr2), -- telefon2
        null, -- gebdatum, -- geburtsdatum -- 2023-02-14 Fehler bei Datum
		null, -- year(NOW())- year(kimi_decrypt_date(gebdatum)) , -- dummy_number5 -- 2023-02-14 Fehler bei Datum
		-- 20220420
		null, -- indexa, -- dummy_number1
		null, -- indexb, -- dummy_number2
		null, -- indexc, -- dummy_number3
		saldo, -- dummy_number4
		verzzinsen, -- dummy_text8
        IFNULL(REPLACE(iban,' ',null),iban), -- dummy_text1
		IFNULL(REPLACE(bic,' ',null),bic), -- dummy_text2
		0, -- connect, -- dummy_text3
		0, -- rpc, -- dummy_text4
		0, -- ptp, -- dummy_text5
		concat('+43',telnr,'**27'), -- dummy_text6
		concat('+43',telnr2,'**27'), -- dummy_text7
		NOW(), -- geaendert_am
'FranZ', -- geaendert_von
194, -- status_id
CURDATE(), -- beginn
DATE_ADD(CURDATE(),INTERVAL 
		CASE 
        WHEN DATE_FORMAT(CURDATE(), '%w') = 1 THEN 5 -- Montag 5
        ELSE 6 -- restliche Tage 6
        END 
		DAY), -- ende
null, --  prioritaet_id -- > = Abschlussgrund
35, -- kampagne_id
TRIM(email), -- email
 CONCAT(RTRIM(sbname),' / E-Mail: ',RTRIM(sbemail),' / ',RTRIM(sbtelnr)), -- kenner
-- CONCAT(glname, ' / ' , glort), -- fahrgestellnummer
CONCAT(kampagne,' -' , anwalt), -- fahrgestellnummer
        CONCAT(statusforderung ,' - ', naechsterschritt), -- textinfo5,
         'Zeigen Sie Loesungsbereitschaft? Welche Möglichkeiten gibt es?',--  textinfo1
         'Wie sieht Ihr Loesungsvorschlag aus ? Hintergrund?', --  textinfo2
         CONCAT ( 
'- INTERNE Notizen', CHAR(13,10)
 ), -- dummy_text10
       
-- CONCAT(indexa,'-', indexb), -- dummy_text9,wiedervorlage_automatik, anzahl_anrufe
CONCAT(indexa), -- dummy_text9
1,-- wiedervorlage_automatik
0,-- anzahl_anrufe
-- Felder Dummy_text11, dummy_text12, dummy_text13 nur für Sonderaktion Kanzlei Rieger AkTIV am 17.2.2022
null, -- ROUND(((gesamtrueckstand-(offenes_kapitalhf+offenes_kapitalnf))*.75)+(offenes_kapitalhf+offenes_kapitalnf),2), -- dummy_text11, -- Angebot Zahlung
null , -- (ifnull(offenes_kapitalhf,0) +ifnull(offenes_kapitalnf,0)), -- dummy_text12  -- MINDEST Zahlung
 221 ,      -- grund_id 
null -- STR_TO_DATE('20220225', '%Y%m%d')-- DATE_ADD(anlagedatum,INTERVAL +100 DAY) -- dummy_text13  späteste Fälligkeit
        from knp3 where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY)
