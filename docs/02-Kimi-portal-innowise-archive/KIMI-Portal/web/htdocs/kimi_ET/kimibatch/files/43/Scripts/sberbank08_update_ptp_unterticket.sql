-- #2 Ergebnisse der Anrufe im Feld Ergebnis im Ticket vermerken
update ticket t
inner join sberbank_ticket_ptp s on s.mandant_id = t.mandant_id and s.id = t.id and s.ticketnr = t.ticketnr
set
		t.dummy_id3 = 29,
		t.ergebnis = concat(ifnull(t.ergebnis,''), CHAR(13,10),'Update PTP Leistungs Anstoss gesetzt',now(),' Auslöserticket: ', s.ticketnr ),
		t.dummy_text10 = concat('Update PTP Leistungs Anstoss gesetzt ',now(),' Auslöserticket: ', s.ticketnr , CHAR(13,10),ifnull(t.dummy_text10,''))
where t.mandant_id = 43 

