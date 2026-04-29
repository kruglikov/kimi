-- #  Eintrag in LOG Tabelle für TELEFONIE ENDE

insert into log (objekt,objekt_id,logart,timestamp,benutzer,start_id)
select 'TICKET',imp_str_kontaktid,'MAN_END_A', STR_TO_DATE(letzter_anruf_kontakt_datetimeoffset,'%d.%m.%Y %H:%i:%s') ,ifnull(case when nachname_agenten = '' then null else nachname_agenten end,'SYSTEM'),null from inkode_out k 
where k.import >= curdate() and k.verarbeitet is null
 