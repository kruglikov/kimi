-- #2 Ergebnisse der Anrufe im Feld Ergebnis im Ticket vermerken
update ticket t
inner join sberbank_ticket_ptp s on s.mandant_id = t.mandant_id and s.hauptticketnr = t.hauptticketnr and t.ticketnr = s.hauptticketnr
set
		t.dummy_number5 = s.dummy_number5, -- aktueller Aussenstand
		t.dummy_number4 = s.dummy_number4,  -- überfälliger Aussenstand
		t.dummy_number6 = s.dummy_number6, -- überfälliger Aussenstand Zahlungsbetrag
		t.dummy_date1 = s.dummy_date1, -- maximaler PTP
		t.dummy_date2 = s.dummy_date2, -- Abbuchungsdatum Wunsch
		t.dummy_date4 = s.dummy_date4, -- vereinbarter PTP  
		t.textant22_nummern_id = s.textant22_nummern_id, -- loesungsvorschlag
		t.ergebnis = concat(ifnull(t.ergebnis,''), CHAR(13,10),'Update PTP ',now(),' Auslöserticket: ', s.ticketnr ),
		t.dummy_text10 = concat('Update PTP ',now(),' Auslöserticket: ', s.ticketnr , CHAR(13,10),ifnull(t.dummy_text10,''))

where t.mandant_id = 43 

