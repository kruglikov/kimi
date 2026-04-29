create table sberbank_duplet
select id From ticket where mandant_id = 43 and kampagne_id <> 99
and ticketnr in (
select max(ticketnr) From ticket where mandant_id = 43 and kampagne_id <> 99 and datediff(beginn, curdate()) < 1
and prioritaet_id = 222  -- Prüfung nur bei Hauptticket
group by nachname,vorname,plz,ort,geburtsdatum
having count(*) >1)
and anruf_status_id is null
