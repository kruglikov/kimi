--  #4 erreichte auf Erledigt und erreicht setzen - ist zwar schon durch User gemacht, wird aber auch vergessen, daher auf jeden Fall "gleichziehen"

update ticket t
inner join sberbank_out k on k.imp_str_ticketnr = t.ticketnr
set t.status_id = 208, t.anruf_status_id = 605 -- erledigt/erreicht
where t.mandant_id = 43 and k.import >= curdate() and kampagne_id <> 0  and k.verarbeitet is null and k.status = 'Positiv beendet'
