--  aktuelle INKODE-Logs auf verarbeitet setzen
update inkode_out k
set verarbeitet = current_date()
where k.import >= curdate() and k.verarbeitet is null 
