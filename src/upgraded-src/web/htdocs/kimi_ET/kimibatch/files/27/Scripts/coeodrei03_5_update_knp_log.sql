-- #6  aktuelle KNP-Logs auf verarbeitet setzen
update knpdrei_out k
set verarbeitet = current_date()
where k.import >= curdate() and k.verarbeitet is null 
 