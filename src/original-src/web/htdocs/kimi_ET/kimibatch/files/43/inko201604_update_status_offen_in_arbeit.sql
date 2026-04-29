update ticket 
set status_id = 67, anruf_status_id = 230
where mandant_id = 18 and status_id = 66 and beginn <= curdate()
