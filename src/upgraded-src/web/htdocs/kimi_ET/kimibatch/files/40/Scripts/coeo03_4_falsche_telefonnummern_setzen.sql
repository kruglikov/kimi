-- #5  Falsche Telefonnummern auf Erledigt setzen und Falsche Telefonnummer setzen

update ticket t
inner join knp_out k on k.imp_str_ticketnr = t.ticketnr
set t.status_id = 187, t.anruf_status_id = 544 ,
ergebnis = concat('Telefnr. falsch: ' , kimi_decrypt(k.telefon), ' / ' , ifnull(ergebnis,'') )-- erledigt/Telefonnummer falsch
where t.mandant_id = 40 and k.import >= curdate() and kampagne_id <> 0  and k.verarbeitet is null and k.status = 'Negativ beendet' and k.grund_negativer_ausgang in ( 'Ungültige Nummer (System)','Telefonnummer falsch')
