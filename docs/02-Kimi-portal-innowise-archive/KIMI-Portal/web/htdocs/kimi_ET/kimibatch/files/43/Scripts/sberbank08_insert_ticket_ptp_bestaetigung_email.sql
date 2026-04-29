INSERT INTO ticket
		(ticketnr, mandant_id,	hauptticketnr,	aktnummer, benutzer_id,
		status_id,		prioritaet_id, 	kampagne_id,
		 beschreibung_detail, kundennummer,	anrede,	nachname,vorname,plz,
		land_id, ort, strasse, 	hausnummer, 	telefon,	telefon2,
		email,  geburtsdatum,	beginn,	ende, dummy_text9,
		dummy_number5, -- aktueller Aussenstand
		dummy_number4,  -- überfälliger Aussenstand
		dummy_number6, -- überfälliger Aussenstand Zahlungsbetrag
		dummy_date1, -- maximaler PTP
		dummy_date2, -- Abbuchungsdatum Wunsch
		dummy_date4, -- vereinbarter PTP  
		textant22_nummern_id, -- loesungsvorschlag
		dummy_text12, -- co_borrower Telfon
		dummy_text7,		-- co_borrower Email
		dummy_id3) --  Leistungsanstoß durchgeführt
	SELECT
		 getNextUnterticketNr(mandant_id, ticketnr),
		 mandant_id,
		hauptticketnr,
		aktnummer,
		1, -- benutzer_id
		211, -- status_id,
		208, -- prioritaet_id, 
		kampagne_id,
		concat('PTP - Bestaetigung E-Mail - PTP am ', curdate()),-- beschreibung_detail,
		 kundennummer,
		anrede,
		nachname,
		vorname,
		plz,
		land_id,
		ort,
		strasse,
		hausnummer,
		telefon,
		telefon2,
		email,
        geburtsdatum,
		now(), -- beginn,
		now(), -- ende
        dummy_text9, -- Kreditkontonummer für Anzeige
		dummy_number5, -- aktueller Aussenstand
		dummy_number4,  -- überfälliger Aussenstand
		dummy_number6, -- überfälliger Aussenstand Zahlungsbetrag
		dummy_date1, -- maximaler PTP
		dummy_date2, -- Abbuchungsdatum Wunsch
		dummy_date4, -- vereinbarter PTP  
		textant22_nummern_id,
		dummy_text12,
		dummy_text7,
		dummy_id3

        from sberbank_ticket_ptp
		where (ifnull(email,'') != '' or ifnull(dummy_text7,'') != '') -- Email vorhanden
		