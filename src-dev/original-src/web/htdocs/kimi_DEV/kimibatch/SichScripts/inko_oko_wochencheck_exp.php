<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>INKO-/OKO WOCHENCHECKS</title>
    </head>
    <body>
        <h1> INKO-/OKO WOCHENCHECKS EXPORT </h1>
        <?php
       include 'db.php';
       set_time_limit(500); 
        $heute = date("d.m.Y H:i:s");
        echo "INKO-/OKO WOCHENCHECKS- START:".$heute ;
        
        $query ="-- INKO-/OKO WOCHENCHECKS
            
        select 
		'mandant',	
		'Ticketnr',
    	'IndexA',
		'IndexB',
		'IndexC',
		'Name',
		'Vorname',
		'Strasse',
		'Plz',
		'Ort',
		'TelNr',
		'TelNr2',
        'E-Mail',
        'GebDatum',
		'saldo',
        'Gl.Name',
		'CONNECT',
		'RPC',
		'PTP',
        'Ergebnis',
		'Anmerkung',
        'Gespraechsdatum',
        'Gespraechszeit',
        'Fehlerstatus',
        'AgentenVorname',
        'AgentenNachname',
		'anruf_status',
		'kontakttel_vw',
        'kontkattel_hw',
		'name_neu',
		'vorname_neu',
		'plz_neu', 
        'ort_neu',
        'strasse_neu',
		'Email_neu',
        'neuetel_vw1',
        'neuetel_hw1',
        'telefon1falsch',
        'telefon2falsch',
        'gebdatum_neu'
		
		union all
		select
       'INKO2016',	
		ticketnr,	   
		REPLACE(FORMAT(dummy_number1, 0),',',''),
		REPLACE(FORMAT(dummy_number2, 0),',',''),
		REPLACE(FORMAT(dummy_number3, 0),',',''),
		inko2016.name,
		inko2016.vorname,
		inko2016.strasse,
		inko2016.plz,
		inko2016.ort,
		inko2016.telnr, -- telefon ORIG
		inko2016.telnr2, -- telefon2  ORIG
		inko2016.email,
		DATE_FORMAT(geburtsdatum, '%d.%m.%Y') , -- geburtsdatum
        REPLACE(REPLACE(FORMAT(dummy_number4, 2),',',''),'.',',') , -- Saldo
        inko2016.glname, -- aus INKO-Schnittstelle INKO2016
        dummy_text3, -- Connect
		dummy_text4, -- rpc
        dummy_text5, -- ptp
		REPLACE(REPLACE( ergebnis, CHAR(13,10), ' ' ),';',','), -- 'Inko-Aktion',
		null , -- 'Anmerkung',
        DATE_FORMAT(inko_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(inko_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
        inko_log.vorname , -- 'AgentenVorname',
        inko_log.nachname , -- 'AgentenNachname',
		anruf_status.text,
		ticket.verkaeufercode, -- kontakttelefonnr_vorwahl,
        ticket.standort, -- kontakttelefonnr_haupt,
        CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(inko2016.name,'') THEN ticket.nachname
            ELSE null
             END nameaenderung, --  nachname
        CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(inko2016.vorname,'') THEN  ticket.vorname
            ELSE null
             END vornamensaenderung, --  vorname
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(inko2016.plz,'') THEN ticket.plz
            ELSE null
             END ortaenderung, --  ortaenderung        
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(inko2016.ort,'') THEN  ticket.ort
            ELSE null
             END ortaenderung, --  ortaenderung
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(inko2016.strasse,'') THEN  ticket.strasse
            ELSE null
             END strassenaenderung , --  strassenaenderung
       CASE
            WHEN IFNULL(ticket.email,'') <> IFNULL(inko2016.email,'') THEN  ticket.email
            ELSE null
             END emailaenderung , --  emailaenderung
        ticket.verkaeufername, -- NEUEtelefonnr_vorwahl1,
        ticket.markencode, -- NEUEtelefonnr_haupt1,
        ticket.modell, -- Telefon1_falsch,
        ticket.amtliches_kennzeichen, -- Telefon2_falsch
		CASE
			WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(inko2016.gebdatum,null)
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END gebdataenderung  --  geburtsdatumaenderung,
		
        from ticket 
		left outer join status status on status.id = ticket.status_id
		left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
		left outer join benutzer on benutzer.id = ticket.benutzer_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
		left outer join produkt on produkt.id = ticket.produkt_id
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
left outer join inko2016 on inko2016.id = ticket.ticketnr  and inko2016.id >= 2000-- and inko2016.import >= '2016-01-01 00:00:00'
	where ticket.mandant_id =18 -- and kampagne_id =16 -- and ticketnr = 48
and ticket.status_id in (68, 69) /*--  =erledigt, gemeldet*/
and ticket.anruf_status_id in (234, 236)/* -- erreicht, gemeldet-erreicht*/
and ticket.letzter_anruf >= date_add(curdate(), interval -7 day)


union all


SELECT NULL as 'INKO2016',NULL as 'Ticketnr',NULL as 'IndexA',NULL as'IndexB',NULL  as'IndexC',NULL as'Name',NULL as'Vorname',NULL as'Strasse',NULL as'Plz',NULL as'Ort',NULL as'TelNr',NULL as'TelNr2',NULL as 'E-Mail',NULL as'GebDatum',NULL as'saldo',NULL as'Gl.Name',NULL as'CONNECT',NULL as'RPC',NULL as'PTP',NULL as'Ergebnis',NULL as'Anmerkung',NULL as'Gespraechsdatum',NULL as'Gespraechszeit',NULL as'Fehlerstatus',NULL as'AgentenVorname',NULL as'AgentenNachname',NULL as'anruf_status',NULL as'kontakttel_vw',NULL as'kontkattel_hw',NULL as'name_neu',NULL as'vorname_neu',NULL as'plz_neu', NULL as'ort_neu',NULL as'strasse_neu',NULL as'Email_neu',NULL as'neuetel_vw1',NULL as'neuetel_hw1',NULL as'telefon1falsch',NULL as'telefon2falsch',NULL as'gebdatum_neu'

UNION all

select 

		'INKODE',
		'Ticketnr',
    	'IndexA',
		'IndexB',
		'IndexC',
		'Name',
		'Vorname',
		'Strasse',
		'Plz',
		'Ort',
		'TelNr',
		'TelNr2',
        'E-Mail',
        'GebDatum',
		'saldo',
        'Gl.Name',
		'CONNECT',
		'RPC',
		'PTP',
        'Ergebnis',
		'Anmerkung',
        'Gespraechsdatum',
        'Gespraechszeit',
        'Fehlerstatus',
        'AgentenVorname',
        'AgentenNachname',
		'anruf_status',
		'kontakttel_vw',
        'kontkattel_hw',
		'name_neu',
		'vorname_neu',
		'plz_neu', 
        'ort_neu',
        'strasse_neu',
		'Email_neu',
        'neuetel_vw1',
        'neuetel_hw1',
        'telefon1falsch',
        'telefon2falsch',
        'gebdatum_neu'
		union
		select
       'INKODE',
		ticketnr,	   
		REPLACE(FORMAT(dummy_number1, 0),',',''),
		REPLACE(FORMAT(dummy_number2, 0),',',''),
		REPLACE(FORMAT(dummy_number3, 0),',',''),
		inkode.name,
		inkode.vorname,
		inkode.strasse,
		inkode.plz,
		inkode.ort,
		inkode.telnr, -- telefon ORIG
		inkode.telnr2, -- telefon2  ORIG
		inkode.email,
		DATE_FORMAT(geburtsdatum, '%d.%m.%Y') , -- geburtsdatum
        REPLACE(REPLACE(FORMAT(dummy_number4, 2),',',''),'.',',') , -- Saldo
        inkode.glname, -- aus INKO-Schnittstelle INKO2016
        dummy_text3, -- Connect
		dummy_text4, -- rpc
        dummy_text5, -- ptp
		REPLACE(REPLACE( ergebnis, CHAR(13,10), ' ' ),';',','), -- 'Inko-Aktion',
		null , -- 'Anmerkung',
        DATE_FORMAT(inko_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(inko_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
        inko_log.vorname , -- 'AgentenVorname',
        inko_log.nachname , -- 'AgentenNachname',
		anruf_status.text,
		ticket.verkaeufercode, -- kontakttelefonnr_vorwahl,
        ticket.standort, -- kontakttelefonnr_haupt,
        CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(inkode.name,'') THEN ticket.nachname
            ELSE null
             END nameaenderung, --  nachname
        CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(inkode.vorname,'') THEN  ticket.vorname
            ELSE null
             END vornamensaenderung, --  vorname
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(inkode.plz,'') THEN ticket.plz
            ELSE null
             END ortaenderung, --  ortaenderung        
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(inkode.ort,'') THEN  ticket.ort
            ELSE null
             END ortaenderung, --  ortaenderung
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(inkode.strasse,'') THEN  ticket.strasse
            ELSE null
             END strassenaenderung , --  strassenaenderung
       CASE
            WHEN IFNULL(ticket.email,'') <> IFNULL(inkode.email,'') THEN  ticket.email
            ELSE null
             END emailaenderung , --  emailaenderung
        ticket.verkaeufername, -- NEUEtelefonnr_vorwahl1,
        ticket.markencode, -- NEUEtelefonnr_haupt1,
        ticket.modell, -- Telefon1_falsch,
        ticket.amtliches_kennzeichen, -- Telefon2_falsch
		CASE
			WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(inkode.gebdatum,null)
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END gebdataenderung  --  geburtsdatumaenderung
        from ticket 
		left outer join status status on status.id = ticket.status_id
		left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
		left outer join benutzer on benutzer.id = ticket.benutzer_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
		left outer join produkt on produkt.id = ticket.produkt_id
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
left outer join inkode on inkode.id = ticket.ticketnr  and inkode.id >= 2000-- and inkode.import >= '2016-01-01 00:00:00'
	where ticket.mandant_id =24 -- and kampagne_id =16 -- and ticketnr = 48
and ticket.status_id in (101, 102) /*--  =erledigt, gemeldet*/
and ticket.anruf_status_id in (333, 335)/* -- erreicht, gemeldet-erreicht*/
and ticket.letzter_anruf >= date_add(curdate(), interval -7 day)

union all

SELECT NULL as 'INKO2016',NULL as 'Ticketnr',NULL as 'IndexA',NULL as'IndexB',NULL  as'IndexC',NULL as'Name',NULL as'Vorname',NULL as'Strasse',NULL as'Plz',NULL as'Ort',NULL as'TelNr',NULL as'TelNr2',NULL as 'E-Mail',NULL as'GebDatum',NULL as'saldo',NULL as'Gl.Name',NULL as'CONNECT',NULL as'RPC',NULL as'PTP',NULL as'Ergebnis',NULL as'Anmerkung',NULL as'Gespraechsdatum',NULL as'Gespraechszeit',NULL as'Fehlerstatus',NULL as'AgentenVorname',NULL as'AgentenNachname',NULL as'anruf_status',NULL as'kontakttel_vw',NULL as'kontkattel_hw',NULL as'name_neu',NULL as'vorname_neu',NULL as'plz_neu', NULL as'ort_neu',NULL as'strasse_neu',NULL as'Email_neu',NULL as'neuetel_vw1',NULL as'neuetel_hw1',NULL as'telefon1falsch',NULL as'telefon2falsch',NULL as'gebdatum_neu'

UNION all

select 
		'INKOSAN',
		'Ticketnr',
    	'IndexA',
		'IndexB',
		'IndexC',
		'Name',
		'Vorname',
		'Strasse',
		'Plz',
		'Ort',
		'TelNr',
		'TelNr2',
        'E-Mail',
        'GebDatum',
		'saldo',
        'Gl.Name',
		'CONNECT',
		'RPC',
		'PTP',
        'Ergebnis',
		'Anmerkung',
        'Gespraechsdatum',
        'Gespraechszeit',
        'Fehlerstatus',
        'AgentenVorname',
        'AgentenNachname',
		'anruf_status',
		'kontakttel_vw',
        'kontkattel_hw',
		'name_neu',
		'vorname_neu',
		'plz_neu', 
        'ort_neu',
        'strasse_neu',
		'Email_neu',
        'neuetel_vw1',
        'neuetel_hw1',
        'telefon1falsch',
        'telefon2falsch',
        'gebdatum_neu'
		union
		select 
        'INKOSAN',
		ticketnr,
		REPLACE(FORMAT(dummy_number1, 0),',',''),
		REPLACE(FORMAT(dummy_number2, 0),',',''),
		REPLACE(FORMAT(dummy_number3, 0),',',''),
		inkosantander.name,
		inkosantander.vorname,
		inkosantander.strasse,
		inkosantander.plz,
		inkosantander.ort,
		inkosantander.telnr, -- telefon ORIG
		inkosantander.telnr2, -- telefon2  ORIG
		inkosantander.email,
		DATE_FORMAT(geburtsdatum, '%d.%m.%Y') , -- geburtsdatum
        REPLACE(REPLACE(FORMAT(dummy_number4, 2),',',''),'.',',') , -- Saldo
        inkosantander.glname, -- aus INKO-Schnittstelle INKO2016
        dummy_text3, -- Connect
		dummy_text4, -- rpc
        dummy_text5, -- ptp
		REPLACE(REPLACE( ergebnis, CHAR(13,10), ' ' ),';',','), -- 'Inko-Aktion',
		null , -- 'Anmerkung',
        DATE_FORMAT(inko_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(inko_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
        inko_log.vorname , -- 'AgentenVorname',
        inko_log.nachname , -- 'AgentenNachname',
		anruf_status.text,
		ticket.verkaeufercode, -- kontakttelefonnr_vorwahl,
        ticket.standort, -- kontakttelefonnr_haupt,
        CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(inkosantander.name,'') THEN ticket.nachname
            ELSE null
             END nameaenderung, --  nachname
        CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(inkosantander.vorname,'') THEN  ticket.vorname
            ELSE null
             END vornamensaenderung, --  vorname
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(inkosantander.plz,'') THEN ticket.plz
            ELSE null
             END ortaenderung, --  ortaenderung        
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(inkosantander.ort,'') THEN  ticket.ort
            ELSE null
             END ortaenderung, --  ortaenderung
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(inkosantander.strasse,'') THEN  ticket.strasse
            ELSE null
             END strassenaenderung , --  strassenaenderung
       CASE
            WHEN IFNULL(ticket.email,'') <> IFNULL(inkosantander.email,'') THEN  ticket.email
            ELSE null
             END emailaenderung , --  emailaenderung
        ticket.verkaeufername, -- NEUEtelefonnr_vorwahl1,
        ticket.markencode, -- NEUEtelefonnr_haupt1,
        ticket.modell, -- Telefon1_falsch,
        ticket.amtliches_kennzeichen, -- Telefon2_falsch
		CASE
			WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(inkosantander.gebdatum,null)
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END gebdataenderung  --  geburtsdatumaenderung
        from ticket 
		left outer join status status on status.id = ticket.status_id
		left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
		left outer join benutzer on benutzer.id = ticket.benutzer_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
		left outer join produkt on produkt.id = ticket.produkt_id
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
left outer join inkosantander on inkosantander.id = ticket.ticketnr  and inkosantander.id >= 2000-- and inkosantander.import >= '2016-01-01 00:00:00'
	where ticket.mandant_id =12 -- and kampagne_id =16 -- and ticketnr = 48
and ticket.status_id in (42, 46) /*--  =erledigt, gemeldet*/
and ticket.anruf_status_id in (131, 144)/* -- erreicht, gemeldet-erreicht*/
and ticket.letzter_anruf >= date_add(curdate(), interval -7 day)

union all



SELECT NULL as 'INKO2016',NULL as 'Ticketnr',NULL as 'IndexA',NULL as'IndexB',NULL  as'IndexC',NULL as'Name',NULL as'Vorname',NULL as'Strasse',NULL as'Plz',NULL as'Ort',NULL as'TelNr',NULL as'TelNr2',NULL as 'E-Mail',NULL as'GebDatum',NULL as'saldo',NULL as'Gl.Name',NULL as'CONNECT',NULL as'RPC',NULL as'PTP',NULL as'Ergebnis',NULL as'Anmerkung',NULL as'Gespraechsdatum',NULL as'Gespraechszeit',NULL as'Fehlerstatus',NULL as'AgentenVorname',NULL as'AgentenNachname',NULL as'anruf_status',NULL as'kontakttel_vw',NULL as'kontkattel_hw',NULL as'name_neu',NULL as'vorname_neu',NULL as'plz_neu', NULL as'ort_neu',NULL as'strasse_neu',NULL as'Email_neu',NULL as'neuetel_vw1',NULL as'neuetel_hw1',NULL as'telefon1falsch',NULL as'telefon2falsch',NULL as'gebdatum_neu'

UNION all

select 
		'OKO',
		'Ticketnr',
    	'aktnr1',
		'aktnr2',
		'Name',
		'Strasse',
		'Ort',
		'TelNr',
		'TelNr2',
        'E-Mail',
        'GebDatum',
		'saldo',
        'Gl.Name',
        'Ergebnis',
        'Zahlungsvereinbarung',
        'Vorlage',
        'Gespraechsdatum',
        'Gespraechszeit',
        'Fehlerstatus',
        'AgentenVorname',
        'AgentenNachname',
		'anruf_status',
		'kontakttel',
		'name_neu',
        'ort_neu',
        'strasse_neu',
		'Email_neu',
        'neuetel_vw1',
        'neuetel_hw1',
        'telefon1falsch',
        'telefon2falsch',
        'gebdatum_neu',
        'Nachtelefonie',
		'leer',
		'leer',
		'leer',
		'leer',
		'leer',
		'leer',
		'leer'
		union
		select 
		'OKO',
		ticketnr,
		oko.aktnr1,
		oko.aktnr2,
		oko.schuldner,
		oko.schuldner_strasse,
		oko.schuldner_ort,
		oko.telnr1, -- telefon ORIG
		oko.telnr2, -- telefon2  ORIG
		oko.email01,
		DATE_FORMAT(ticket.geburtsdatum, '%d.%m.%Y') , -- geburtsdatum
        REPLACE(REPLACE(FORMAT(dummy_number4, 2),',',''),'.',',') , -- Saldo
        oko.glaeubiger, -- aus oko-Schnittstelle oko
		REPLACE(REPLACE( ergebnis, CHAR(13,10), ' ' ),';',','), -- 'Ergebnis',
		nummern2.text, -- 'Zahlungsvereinbarung'
        janein_vorlage.text, -- 'Vorlage'
        DATE_FORMAT(oko_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(oko_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
        oko_log.vorname , -- 'AgentenVorname',
        oko_log.nachname , -- 'AgentenNachname',
		anruf_status.text,
		ticket.dummy_text4, -- kontakttelefonnr
        CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(oko.schuldner,'') THEN ticket.nachname
            ELSE null
             END nameaenderung, --  nachname       
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(oko.schuldner_ort,'') THEN  ticket.ort
            ELSE null
             END ortaenderung, --  ortaenderung
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(oko.schuldner_strasse,'') THEN  ticket.strasse
            ELSE null
             END strassenaenderung , --  strassenaenderung
       CASE
            WHEN IFNULL(ticket.email,'') <> IFNULL(oko.email01,'') THEN  ticket.email
            ELSE null
             END emailaenderung , --  emailaenderung
        ticket.verkaeufername, -- NEUEtelefonnr_vorwahl1,
        ticket.markencode, -- NEUEtelefonnr_haupt1,
        ticket.modell, -- Telefon1_falsch,
        ticket.amtliches_kennzeichen, -- Telefon2_falsch
		CASE
			WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(oko.geburtsdatum,null)
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END gebdataenderung,  --  geburtsdatumaenderung
		REPLACE(REPLACE( dummy_text10, CHAR(13,10), ' ' ),';',',') -- 'Nachtelefonie',
		'leer',
		'leer',
		'leer',
		'leer',
		'leer',
		'leer',
		'leer',	
		'leer'
        from ticket 
		left outer join status status on status.id = ticket.status_id
		left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
		left outer join benutzer on benutzer.id = ticket.benutzer_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
		left outer join produkt on produkt.id = ticket.produkt_id
		left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
		left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join janein janein_vorlage on janein_vorlage.id = ticket.textant31_janein_id
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

 ) oko_log on oko_log.id  = ticket.id and ticket.mandant_id = oko_log.mandant_id
left outer join oko on oko.id = ticket.ticketnr  and oko.id >= 2000-- and oko.import >= '2016-01-01 00:00:00'
	where ticket.mandant_id =16 -- and kampagne_id =16 -- and ticketnr = 48
and ticket.status_id in (55, 56) /*--  =erledigt, gemeldet*/
and ticket.anruf_status_id in (197, 199)/* -- erreicht, gemeldet-erreicht*/
and ticket.letzter_anruf >= date_add(curdate(), interval -7 day)

UNION ALL
		select
       'INKO2018',	
		ticketnr,	   
		REPLACE(FORMAT(dummy_number1, 0),',',''),
		REPLACE(FORMAT(dummy_number2, 0),',',''),
		REPLACE(FORMAT(dummy_number3, 0),',',''),
		inko2018.name,
		inko2018.vorname,
		inko2018.strasse,
		inko2018.plz,
		inko2018.ort,
		inko2018.telnr, -- telefon ORIG
		inko2018.telnr2, -- telefon2  ORIG
		inko2018.email,
		DATE_FORMAT(geburtsdatum, '%d.%m.%Y') , -- geburtsdatum
        REPLACE(REPLACE(FORMAT(dummy_number4, 2),',',''),'.',',') , -- Saldo
        inko2018.glname, -- aus INKO-Schnittstelle INKO2018
        dummy_text3, -- Connect
		dummy_text4, -- rpc
        dummy_text5, -- ptp
		REPLACE(REPLACE( ergebnis, CHAR(13,10), ' ' ),';',','), -- 'Inko-Aktion',
		null , -- 'Anmerkung',
        DATE_FORMAT(inko_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(inko_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
        inko_log.vorname , -- 'AgentenVorname',
        inko_log.nachname , -- 'AgentenNachname',
		anruf_status.text,
		ticket.verkaeufercode, -- kontakttelefonnr_vorwahl,
        ticket.standort, -- kontakttelefonnr_haupt,
        CASE
            WHEN IFNULL(ticket.nachname,'') <> IFNULL(inko2018.name,'') THEN ticket.nachname
            ELSE null
             END nameaenderung, --  nachname
        CASE
            WHEN IFNULL(ticket.vorname,'') <> IFNULL(inko2018.vorname,'') THEN  ticket.vorname
            ELSE null
             END vornamensaenderung, --  vorname
       CASE
            WHEN IFNULL(ticket.plz,'') <>  IFNULL(inko2018.plz,'') THEN ticket.plz
            ELSE null
             END ortaenderung, --  ortaenderung        
       CASE
            WHEN IFNULL(ticket.ort,'') <>  IFNULL(inko2018.ort,'') THEN  ticket.ort
            ELSE null
             END ortaenderung, --  ortaenderung
       CASE
            WHEN IFNULL(ticket.strasse,'') <> IFNULL(inko2018.strasse,'') THEN  ticket.strasse
            ELSE null
             END strassenaenderung , --  strassenaenderung
       CASE
            WHEN IFNULL(ticket.email,'') <> IFNULL(inko2018.email,'') THEN  ticket.email
            ELSE null
             END emailaenderung , --  emailaenderung
        ticket.verkaeufername, -- NEUEtelefonnr_vorwahl1,
        ticket.markencode, -- NEUEtelefonnr_haupt1,
        ticket.modell, -- Telefon1_falsch,
        ticket.amtliches_kennzeichen, -- Telefon2_falsch
		CASE
			WHEN IFNULL(ticket.geburtsdatum,null) <> IFNULL(inko2018.gebdatum,null)
                 and IFNULL(ticket.geburtsdatum,null) <= '2010-01-01'
            THEN  DATE_FORMAT(ticket.geburtsdatum, '%Y.%m.%d') 
            ELSE null
             END gebdataenderung  --  geburtsdatumaenderung,
		
        from ticket 
		left outer join status status on status.id = ticket.status_id
		left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
		left outer join benutzer on benutzer.id = ticket.benutzer_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
		left outer join produkt on produkt.id = ticket.produkt_id
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
left outer join inko2018 on inko2018.id = ticket.ticketnr  and inko2018.id >= 0 and inko2018.import >= '2018-01-01 00:00:00'
	where ticket.mandant_id = 33 -- and kampagne_id =16 -- and ticketnr = 48
and ticket.status_id in (155, 156) /*--  =erledigt, gemeldet*/
and ticket.anruf_status_id in (453, 457)/* -- erreicht, gemeldet-erreicht*/
and ticket.letzter_anruf >= date_add(curdate(), interval -7 day)


";
 
    if (!$result = mysql_query($query)) {
        echo('Invalid query: ' . mysql_error());
    }        
        $filename ="files/inkookowochencheckexp".date("YmdHis").".csv";
        $fp = fopen($filename,"w");
        
    while ($line = mysql_fetch_array($result)){
        
		$string = $line['mandant'].";".$line['Ticketnr'].";".$line['IndexA'].";".$line['IndexB'].";".$line['IndexC'].";".$line['Name'].";".$line['Vorname'].";".$line['Strasse'].";".$line['Plz'].";".$line['Ort'].";".$line['TelNr'].";".$line['TelNr2'].";".$line['E-Mail'].";".$line['GebDatum'].";".$line['saldo'].";".$line['Gl.Name'].";".$line['Ort'].";".$line['CONNECT'].";".$line[ 'RPC'].";".$line['PTP'].";";
        $string = $string.$line['Ergebnis'].";".$line['Anmerkung'].";".$line['Gespraechsdatum'].";".$line['Gespraechszeit'].";".$line['Fehlerstatus'].";".$line['AgentenVorname'].";".$line['AgentenNachname'].";".$line['anruf_status'].";".$line['kontakttel_vw'].";".$line['kontkattel_hw'].";".$line['name_neu'].";".$line['vorname_neu'].";".$line['plz_neu'].";".$line['ort_neu'].";".$line['strasse_neu'].";".$line['Email_neu'].";".$line['neuetel_vw1'].";".$line['neuetel_hw1'].";".$line['telefon1falsch'].";".$line['telefon2falsch'].";".$line['gebdatum_neu'].";";
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
