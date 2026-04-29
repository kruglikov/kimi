INSERT INTO ticket
		(ticketnr, mandant_id,	hauptticketnr,	aktnummer, benutzer_id,
		status_id,		prioritaet_id, 	kampagne_id,
		 beschreibung_detail, kundennummer,	anrede,	nachname,vorname,plz,
		land_id, ort, strasse, 	hausnummer, 	telefon,	telefon2,
		email,  geburtsdatum,	beginn,	ende, dummy_text9)
	SELECT
		 getNextUnterticketNr(mandant_id, ticketnr),
		 mandant_id,
		hauptticketnr,
		aktnummer,
		1, -- benutzer_id
		211, -- status_id,
		204, -- prioritaet_id, 
		kampagne_id,
		'FOLGE_ANRUF',-- beschreibung_detail,
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
        dummy_text9 -- Kreditkontonummer für Anzeige


        from sberbank_ticket_folge_anruf
		