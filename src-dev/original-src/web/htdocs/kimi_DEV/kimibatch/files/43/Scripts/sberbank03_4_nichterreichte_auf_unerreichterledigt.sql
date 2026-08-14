--  #4 unerreichte auf Erledigt und unerreicht setzen - 

update ticket t
inner join sberbank_out k on k.imp_str_ticketnr = t.ticketnr
set t.status_id = 208, t.anruf_status_id = 611 -- erledigt/erreicht
where t.mandant_id = 43 and k.import >= curdate() and kampagne_id <> 0  and k.verarbeitet is null and k.status not in ('Positiv beendet', 'Negativ beendet')
