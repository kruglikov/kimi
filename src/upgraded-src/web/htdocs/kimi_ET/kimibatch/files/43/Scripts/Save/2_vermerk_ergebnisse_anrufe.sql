-- #2 Ergebnisse der Anrufe im Feld Ergebnis im Ticket vermerken
update ticket t
inner join knp_out k on k.imp_str_ticketnr = t.ticketnr
set t.ergebnis = concat(ifnull(t.ergebnis,''), CHAR(13,10),'Elsbeth:',now(),' letzter Anruf: ', k.letzter_anruf_kontakt_datetimeoffset, ' Status: ',         k.status , ' ',grund_negativer_ausgang,'', beschreibung_positiver_ausgang,' Agent: ' , k.nachname_agenten, ' ',k.vorname_agenten )
where t.mandant_id = 40 and k.import >= curdate() and k.verarbeitet is null 

