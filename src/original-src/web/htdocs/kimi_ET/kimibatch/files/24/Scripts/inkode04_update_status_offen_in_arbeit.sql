update ticket 
set status_id = 103, anruf_status_id = 329
where mandant_id = 24 and status_id = 104 and beginn <= curdate()
