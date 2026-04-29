update ticket 
set status_id = 57, anruf_status_id = 193
where mandant_id = 16 and status_id = 58 and beginn <= curdate()
