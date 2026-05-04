--  aktuelle OKO-Logs auf verarbeitet setzen
update oko_out k
set verarbeitet = current_date()
where k.import >= curdate() and k.verarbeitet is null 
