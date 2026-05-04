create table knp1_duplet
select id From ticket where mandant_id = 40 and kampagne_id <> 99
and telefon in (
select max(telefon) From ticket where mandant_id = 40 and kampagne_id <> 99 and beginn >= curdate() --  datediff(beginn, curdate()) < 1
-- and ticketnr in (400,401)
-- group by nachname,vorname,plz,ort,geburtsdatum
group by telefon -- 20.07.2023 - Tafr
having count(*) >1)
and anruf_status_id is null
