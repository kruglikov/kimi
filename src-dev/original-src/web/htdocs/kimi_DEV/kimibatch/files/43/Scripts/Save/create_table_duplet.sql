create table knp1_duplet
select id From ticket where mandant_id = 40 and kampagne_id <> 99
and ticketnr in (
select max(ticketnr) From ticket where mandant_id = 40 and kampagne_id <> 99 and datediff(beginn, curdate()) < 1
-- and ticketnr in (400,401)
group by nachname,vorname,plz,ort,geburtsdatum
having count(*) >1)
and anruf_status_id is null
