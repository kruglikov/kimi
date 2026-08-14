--  #4 erreichte auf Erledigt und erreicht setzen - ist zwar schon durch User gemacht, wird aber auch vergessen, daher auf jeden Fall "gleichziehen"

update ticket t
inner join knp_out k on k.imp_str_ticketnr = t.ticketnr
set t.status_id = 187, t.anruf_status_id = 536 -- erledigt/erreicht
where t.mandant_id = 40 and k.import >= curdate() and kampagne_id <> 0  and k.verarbeitet is null and k.status = 'Positiv beendet'
