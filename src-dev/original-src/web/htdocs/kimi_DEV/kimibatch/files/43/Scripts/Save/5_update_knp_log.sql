-- #6  aktuelle KNP-Logs auf verarbeitet setzen
update knp_out k
set verarbeitet = now()
where k.import >= curdate() and k.verarbeitet is null 
