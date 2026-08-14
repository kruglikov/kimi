<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Mahnung Täglich Report</title>
    </head>
    <body>
        <h1> Mahnung Täglich Report EXPORT </h1>
        <?php
       include 'db.php';
       set_time_limit(500); 
        $heute = date("d.m.Y H:i:s");
        echo "Mahnung Täglich Report - START:".$heute ;
        
        $query ="-- MAHNUNG - Report zu bearbeiten MEINS 
            
        select 
        'mandant',
        'status',
        'anruf_status',
        'wiedervorlage',
        'anrufzeitpunkt',
		'anzahl',
        'heute fällig',
        'schon überfällig',
        'aeltestes Beginndatum'
        
            union all 
        select
        'INKO_SAN',
        status.text status,
        anruf_status.text anruf_status,
        wiedervorlage,
        firma.text anrufzeitpunkt,
        count(*) anzahl,
		
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,

min(beginn)
  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                                left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 12

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id =12 and kampagne_id <>99 and status.text != 'gemeldet'  and status.text != 'erledigt'

group by 1,2,3,4,5 WITH ROLLUP

union
                               select 
        'INKO_2016',
        status.text status,
        anruf_status.text anruf_status,
        wiedervorlage,
        firma.text anrufzeitpunkt,
        count(*) anzahl,
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,
min(beginn)


  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                               left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                              left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 18

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id =18 and status.text != 'gemeldet'  and status.text != 'erledigt'

group by 1,2,3,4,5 WITH ROLLUP

union
                               select 
        'OKO',
        status.text status,
        anruf_status.text anruf_status,
                               wiedervorlage,
        firma.text anrufzeitpunkt,
        count(*) anzahl,
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,
min(beginn)


  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                               left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 16

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id =16 and status.text != 'gemeldet'  and status.text != 'erledigt'

group by 1,2,3,4,5 WITH ROLLUP

union
                               select 
        'OKO-SAN' mand,
        status.text status,
        anruf_status.text anruf_status,
        wiedervorlage,
        firma.text anrufzeitpunkt,
        count(*) anzahl,
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,
min(beginn)


  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                               left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 19

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id =19 and status.text != 'gemeldet' and status.text != 'erledigt'
group by 1,2,3,4,5 WITH ROLLUP


union
                               select 
        'OKO-SAN' mand,
        status.text status,
        anruf_status.text anruf_status,
                               wiedervorlage,
        firma.text anrufzeitpunkt,
        count(*) anzahl,
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,
min(beginn)


  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                               left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 19

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id =19 and status.text != 'gemeldet' and status.text != 'erledigt'
group by 1,2,3,4,5 WITH ROLLUP
union
                               select 
        'BERNDORFER' mand,
        status.text status,
        anruf_status.text anruf_status,
                               wiedervorlage,
        firma.text anrufzeitpunkt,
        count(*) anzahl,
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,
min(beginn)


  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                               left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 20

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id =20 and status.text != 'gemeldet' and status.text != 'erledigt'
group by 1,2,3,4,5 WITH ROLLUP

UNION
  select 
        'INKO_DE',
        status.text status,
        anruf_status.text anruf_status,
        wiedervorlage,
        firma.text anrufzeitpunkt,
        count(*) anzahl,
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,
min(beginn)


  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                                left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 24

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id =24 and kampagne_id <>99 and status.text != 'gemeldet'  and status.text != 'erledigt'

group by 1,2,3,4,5 WITH ROLLUP

union
                               select 
        'INKO_2018',
        status.text status,
        anruf_status.text anruf_status,
        wiedervorlage,
        firma.text anrufzeitpunkt,
        count(*) anzahl,
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,
min(beginn)


  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                               left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                              left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 33

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id =33 and status.text != 'gemeldet'  and status.text != 'erledigt'

group by 1,2,3,4,5 WITH ROLLUP


union
select 
        'GESAMT',
        null,
        null,
        null,
                               null,
        count(*) anzahl,
sum(
CASE
WHEN ende =  curdate() THEN 1
ELSE 0 END) heute_faellig,
sum(
CASE
WHEN ende <  curdate() THEN 1
ELSE 0 END) ueberfaellig,
min(beginn)


  
                                                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                                left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                               left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz,
sum(dauer1) dauer,
sum(dauerinsec) dauerinsec

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
time_to_sec(TIMEDIFF(end.timestamp, start.timestamp) ) dauerinsec,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id in ( 12,16,18,19,20,24,33)

) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

                where ticket.mandant_id in ( 12,16,18,19,20,24,33) and kampagne_id <>99 and status.text != 'gemeldet'  and status.text != 'erledigt'
";
 
    if (!$result = mysql_query($query)) {
        echo('Invalid query: ' . mysql_error());
    }        
        $filename ="files/mahnungexp".date("YmdHis").".csv";
        $fp = fopen($filename,"w");
        
    while ($line = mysql_fetch_array($result)){
        
        $string = $line['mandant'].";".$line['status'].";".$line['anruf_status'].";".$line['wiedervorlage'].";".$line[ 'anrufzeitpunkt'].";".$line['anzahl'].";";
        $string = $string.$line['heute fällig'].";".$line['schon überfällig'].";".$line['aeltestes Beginndatum'].";";
        $string = $string.";"."\n";
        // being transformed into a newline
       fwrite($fp, $string);
    }
        
        
      
        
        fclose($fp);
        
        
        
        
$file = $filename;

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

echo "<br>File Download zum Dowload bereit <br>";
 ?>       
        
 <?php
        $heute1 = date("d.m.Y H:i:s");    
        echo "<br><br>"."Mahnung Täglich Report- Ende: ".$heute1;
?>
</body>
</html>
