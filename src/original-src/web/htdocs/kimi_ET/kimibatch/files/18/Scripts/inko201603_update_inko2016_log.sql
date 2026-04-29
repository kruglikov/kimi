--  aktuelle INKODE-Logs auf verarbeitet setzen
update inko2016_out k
set verarbeitet = current_date()
where k.import >= curdate() and k.verarbeitet is null 
