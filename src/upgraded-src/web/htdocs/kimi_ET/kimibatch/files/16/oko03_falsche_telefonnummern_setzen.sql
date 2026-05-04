--  Falsche Telefonnummern auf in Bearbeitung setzen und Falsche Telefonnummer setzen

update ticket t
inner join oko_out k on k.imp_str_ticketnr = t.ticketnr
set t.status_id = 57, t.anruf_status_id = 203 ,ergebnis = concat('Telefnr. falsch: ' , k.telefon,' / ', ifnull(ergebnis,'') )-- erledigt/Telefonnummer falsch
where t.mandant_id = 16 and t.status_id in (57,58) and k.import >= curdate() and kampagne_id <> 0  and k.verarbeitet is null and k.status = 'Negativ beendet' and k.grund_negativer_ausgang in ( 'Ungültige Nummer (System)','Telefonnummer falsch')
