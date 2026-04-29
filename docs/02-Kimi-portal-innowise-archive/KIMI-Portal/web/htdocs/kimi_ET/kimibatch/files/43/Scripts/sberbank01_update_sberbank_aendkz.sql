update sberbank  set aenderungs_kz = (
select t.id from ticket t where t.mandant_id = 43 and sberbank.kontonummer = t.aktnummer and t.hauptticketnr = t.ticketnr and curdate() between beginn and ende and t.status_id in (210,211)
)
where import >= DATE_ADD(CURDATE(),INTERVAL -0.1 DAY) -- heute eingespielt  - es geht immer um die Tagesdatei