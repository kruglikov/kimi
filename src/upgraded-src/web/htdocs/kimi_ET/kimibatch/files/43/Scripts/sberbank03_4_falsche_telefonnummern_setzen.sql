-- #5  Falsche Telefonnummern auf Erledigt setzen und Falsche Telefonnummer setzen

update ticket t
inner join sberbank_out k on k.imp_str_ticketnr = t.ticketnr
set t.status_id = 208, t.anruf_status_id = 610 ,ergebnis = concat('Telefnr. falsch: ' , ifnull(k.telefon,''), ' / ' , ifnull(ergebnis,'') ) ,-- erledigt/Telefonnummer falsch
modell = ifnull(k.telefon,'') -- falsche telefonnummer eintragen  - immer in die erste !!!
where t.mandant_id = 43 and k.import >= curdate() and kampagne_id <> 0  and k.verarbeitet is null and k.status = 'Negativ beendet' and k.grund_negativer_ausgang in ( 'Ungültige Nummer (System)','Telefonnummer falsch')
