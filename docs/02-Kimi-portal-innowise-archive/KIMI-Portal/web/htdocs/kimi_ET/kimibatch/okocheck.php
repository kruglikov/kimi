<html>
  <head>
     <title>KIMI-Plus - OKO-Check</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO-Check</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    

echo "OKO-Check - Start: ".$heute;
// Abfrage Status "erledigt" - Anrufstatus nicht "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_anruf_status = "select count(*) anzahl_n_verarbeitet from ticket
left outer join status status on status.id = ticket.status_id
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =16 and status_id = 55 and
IFNULL(anruf_status_id,0) not in (197,203,204)";

// Abfrage Status "erledigt" - Anrufstatus  "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_anruf_status_pos_data = "select 'id', 'ticketnr', 'status_text','anruf_status_text'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text
from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =16 and status_id = 55 and
 anruf_status_id  in (197,203,204) ";

 // Abfrage Status "erledigt" - Anrufstatus NICHT  "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_anruf_status_err_data = "select 'id', 'ticketnr', 'status_text','anruf_status_text'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text
from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =16 and status_id = 55 and
 IFNULL(anruf_status_id,0) NOT in (197,203,204) ";
// Abfrage Status "Adress- und eMail-Check und Arbeitgeberdaten-Check"
$query_adr_email_check = "
select count(*) anzahl_n_verarbeitet from ticket
left outer join status status on status.id = ticket.status_id
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =16 and status_id = 55 and
 anruf_status_id in (197,203,204) and (textant21_janein_id is null or textant41_janein_id is null or textant11_janein_id is null )
 ";

// Abfrage Status "Adress- und eMail-Check und Arbeitgeberdaten-Check"
$query_adr_email_check_data = "
select 'id', 'ticketnr', 'status_text','anruf_status_text','adrcheck','emailcheck','arbeitgeberdatencheck'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text,
IFNULL(textant21_janein_id,' ') adrcheck, IFNULL(textant41_janein_id,' ') emailcheck, IFNULL(textant11_janein_id,' ') arbeitgeberdatencheck
 from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =16 and status_id = 55 and
 anruf_status_id in (197,203,204) and  (textant21_janein_id is null or textant41_janein_id is null or textant11_janein_id is null)
 "; 

$query_check_kontakttelnr = "
select count(*) anzahl_n_verarbeitet from ticket
left outer join status status on status.id = ticket.status_id
left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =16 and status_id = 55 and
 anruf_status_id in (197) and (dummy_text4 is null )"; 
$query_check_kontakttelnr_data = "
select 'id', 'ticketnr', 'status_text','anruf_status_text','kontakttelnr'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text,
IFNULL(dummy_text4,' ') kontakttelnr
 from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
where ticket.mandant_id =16 and status_id = 55 and
 anruf_status_id in (197) and  (dummy_text4 is null)"; 
//
$query_check_rate = "

select count(*) anzahl_n_verarbeitet from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
        left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
where ticket.mandant_id =16 and status_id = 55 and
 anruf_status_id in (197) and 
(
(IFNULL(nummern2.text,'k.A.')= 'JA-Einmal' and ( dummy_date1 is null))
OR
(IFNULL(nummern2.text,'k.A.')= 'JA-Raten' and (dummy_number6 is null or dummy_date1 is null))
OR
(IFNULL(nummern2.text,'k.A.')= 'JA-Einmal' and (dummy_number6 is not null))
)";  
$query_check_rate_data = "
select 'id', 'ticketnr', 'status_text','anruf_status_text','loesungsvorschlag','ratenhoehe_verein','ratenzahlung_am'
UNION
select ticket.id id ,ticketnr ticketnr ,status.text status_text,anruf_status.text anruf_status_text,
IFNULL(nummern2.text,'k.A.') loesungsvorschlag,
REPLACE(CAST(IFNULL(dummy_number6,0) AS CHAR), '.', ',') ratenhoehe_verein,
DATE_FORMAT(dummy_date1, '%d-%m-%Y') ratenzahlung_am
 from ticket
		left outer join status status on status.id = ticket.status_id
		left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
        left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
where ticket.mandant_id =16 and status_id = 55 and
 anruf_status_id in (197) and 
(
(IFNULL(nummern2.text,'k.A.')= 'JA-Einmal' and ( dummy_date1 is null))
OR
(IFNULL(nummern2.text,'k.A.')= 'JA-Raten' and (dummy_number6 is null or dummy_date1 is null))
OR
(IFNULL(nummern2.text,'k.A.')= 'JA-Einmal' and (dummy_number6 is not null))
)
";  
 

 
// Tables für Stati-Check truncaten
$trunc_okoerledigt = "truncate table okoerledigt";
$trunc_okoerreicht = "truncate table okoerreicht";
$trunc_okounerreichbar = "truncate table okounerreichbar";
$trunc_okotelefonnummerfalsch = "truncate table okotelefonnummerfalsch";
// Tables für Stati-Check INSERT
$ins_okoerledigt = "insert into okoerledigt
select ticket.ticketnr from ticket
where ticket.mandant_id =16 and status_id = 55";
$ins_okoerreicht = "insert into okoerreicht
select ticket.ticketnr from ticket
where ticket.mandant_id =16 and status_id = 55 and anruf_status_id = 197";
$ins_okounerreichbar = "insert into okounerreichbar
select ticket.ticketnr from ticket
where ticket.mandant_id =16 and status_id = 55 and anruf_status_id = 204";
$ins_okotelefonnummerfalsch = "insert into okotelefonnummerfalsch
select ticket.ticketnr from ticket
where ticket.mandant_id =16 and status_id = 55 and anruf_status_id = 203";
// 
// Abfrage Status "erledigt" - Anrufstatus  "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_upd_check_data = "select count(erl.ticketnr) erledigt,count(err.ticketnr) erreicht,count(unerr.ticketnr) unerreichbar,
count(telfa.ticketnr) telefonnummerfalsch,
count(err.ticketnr)+count(unerr.ticketnr)+count(telfa.ticketnr) summe 
from okoerledigt erl
left outer join okoerreicht err on erl.ticketnr = err.ticketnr
left outer join okounerreichbar unerr on erl.ticketnr = unerr.ticketnr
left outer join okotelefonnummerfalsch telfa on erl.ticketnr = telfa.ticketnr";
//
// Abfrage ob ""Gesprächszeit/Anrufer" gesetzt
$query_status_telefonat = "select count(*) anzahl_n_verarbeitet 
		from ticket 
/*
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
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz
 from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
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
 */
	where ticket.mandant_id =16 and status_id <> 58 -- wenn status nicht offen
-- and  oko_log.start_ges is null
and getLogAnrufVorhanden(ticket.id) = 0 and beginn >= DATE_SUB(curdate(), INTERVAL 7 DAY);
";
$query_status_telefonat_data = "select 
	    'ticketnr','beginn'
		union
		select 
		ticketnr,beginn
		from ticket 
/*
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
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz
 from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
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
*/
	where ticket.mandant_id =16 and status_id <> 58
-- and  oko_log.start_ges is null
and getLogAnrufVorhanden(ticket.id) = 0 and beginn >= DATE_SUB(curdate(), INTERVAL 7 DAY);
";
// Select für Schnittstellen_Daten und Reporting Daten
// Stand 2015-07-12
$query_schnitt_data = "
select 
		ticketnr,
        REPLACE( dummy_text9, '/', '' ) aktnr, -- aktnr
        dummy_text5 sachbearbeiter, -- sachbearabeiter
        dummy_text3 glaeubiger, -- glaeubiger
        ticket.nachname,		 -- schuldner
        strasse,        
        ort, 
        dummy_text8, -- mitschuldner
        REPLACE( beschreibung_detail, CHAR(13,10), ' ' ) beschreibung_detail, 
        ticket.dummy_number4 saldo,
        ticket.telefon  telnr1,
		ticket.telefon2 telnr2,
        ticket.dummy_text4 kontakttelefonnr,
	  	ticket.dummy_text1 iban,
        ticket.dummy_text2 bic,
	    ticket.dummy_text10 bemerkung,
	    ticket.geburtsdatum geburtsdatum,
	    ticket.dummy_number1 ratenanzahl,
	    ticket.dummy_number2 ratenhoehe,
	    ticket.dummy_number3 gesamtzahlung,
        CASE 
            WHEN ticket.nachname <> oko.schuldner or 
                 ticket.ort <> oko.schuldner_ort or 
                 ticket.strasse <> oko.schuldner_strasse 
                  THEN 'JA' 
            ELSE null
             END adraend, -- Adressaenderung
        CASE
            WHEN ticket.nachname <> oko.schuldner THEN CONCAT('NAME: ', ticket.nachname)
            ELSE null
             END namensaenderung, --  ortaenderung
        CASE
            WHEN ticket.ort <>  oko.schuldner_ort THEN CONCAT('ORT: ', ticket.ort)
            ELSE null
             END ortaenderung, --  ortaenderung
        CASE
            WHEN ticket.strasse <> oko.schuldner_strasse THEN CONCAT('STR: ', ticket.strasse)
            ELSE null
             END strassenaenderung , --  strassenaenderung
        status.text status,
        anruf_status.text anruf_status, 
		janein2.text zahlschein,
		janein3.text vorlage,
		janein4.text mahnsperre,
		IFNULL(nummern2.text,'k.A.') loesungsvorschlag,
		grund.text ratenbriefhinweis,
        REPLACE(CAST(IFNULL(dummy_number6,0) AS CHAR), '.', ',') ratenhoeh_verein,
        DATE_FORMAT(dummy_date1, '%d-%m-%Y') ratenzahlung_am, 
        DATE_FORMAT(wiedervorlage, '%Y-%c-%d') wiedervorlage, 
		REPLACE( ergebnis, CHAR(13,10), ' ' ) ergebnis,
        status.text status_text,
        anruf_status.text anruf_status_text,
        zeit,
        DATE_FORMAT(oko_log.start_ges, '%d.%m.%Y') gespraechsdatum, -- 'Gespraechsdatum',
        TIME_FORMAT(oko_log.start_ges, '%H:%i:%s') gespraechszeit , -- 'Gespraechszeit',
        oko_log.anrede ag_anrede , -- 'AgentenAnrede',
        oko_log.vorname ag_vorname, -- 'AgentenVorname',
        oko_log.nachname ag_nachname -- 'AgentenNachname',
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
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz

 from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
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
where mandant_id = 16 ) oko_log on oko_log.id  = ticket.id and ticket.mandant_id = oko_log.mandant_id
left outer join oko on oko.id = ticket.ticketnr 

	where ticket.mandant_id =16 
and ticket.status_id = 55
";
// Stand 2015-07-12
$query_schnitt_report = "
select 
    	'ticketnr',
		'sachbearbeiter',
		'glaeubiger',
		'nachname',
		'strasse',
		'ort',
		'mitschuldner',
		-- 'beschreibung_detail',
		'saldo',
		'telnr1',
        'telnr2',
		'kontakttelefonnr',
		'iban',
        'bic',
       -- 'bemerkung',
        'geburtsdatum',
		'ratenanzahl',
		'ratenhoehe',
		'gesamtzahlung',
        'adraend',
		'namensaenderung',
		'ortaenderung',
        'sttrassenaenderung',
        'status',
        'anruf_status',
		'zahlschein',
        'vorlage',
        'mahnsperre',
        'zahlungsvereinbarung',
		'ratenbriefhinweis',
        'raetnhoehe_verein',
        'ratenzahlung_am',
        'wiedervorlage',
        'ergebnis',
		'status_text',
	    'anruf_status_text',
		'zeit',
		'gespraechsdatum',
		'gespraechszeit',
		'ag_anrede',
		'ag_vorname',
		'ag_nachname',
		'zeit',
		'beginn',
		'monat',
		'tageszeit'
		union
select 
        -- REPLACE( dummy_text9, '/', '' ) aktnr, -- aktnr
        dummy_text9 aktnr, -- aktnr
        dummy_text5 sachbearbeiter, -- sachbearabeiter
        dummy_text3 glaeubiger, -- glaeubiger
        ticket.nachname,		 -- schuldner
        strasse,        
        ort, 
        dummy_text8 mitschulder, -- mitschuldner
       -- REPLACE( beschreibung_detail, CHAR(13,10), ' ' ) beschreibung_detail, 
         REPLACE(CAST(IFNULL(ticket.dummy_number4,0) AS CHAR), '.', ',')   saldo,
        ticket.telefon  telnr1,
		ticket.telefon2 telnr2,
        ticket.dummy_text4 kontakttelefonnr,
	  	ticket.dummy_text1 iban,
        ticket.dummy_text2 bic,
	    -- ticket.dummy_text10 bemerkung,
        DATE_FORMAT(ticket.geburtsdatum,'%Y-%c-%d') geburtsdatum, 
	    ticket.dummy_number1 ratenanzahl,
	    REPLACE(CAST(IFNULL(ticket.dummy_number2,0) AS CHAR), '.', ',')   ratenhoehe,
	     REPLACE(CAST(IFNULL(ticket.dummy_number3,0) AS CHAR), '.', ',')  gesamtzahlung,
        CASE 
            WHEN ticket.nachname <> oko.schuldner or 
                 ticket.ort <> oko.schuldner_ort or 
                 ticket.strasse <> oko.schuldner_strasse 
                  THEN 'JA' 
            ELSE null
             END adraend, -- Adressaenderung
        CASE
            WHEN ticket.nachname <> oko.schuldner THEN CONCAT('NAME: ', ticket.nachname)
            ELSE null
             END namensaenderung, --  ortaenderung
        CASE
            WHEN ticket.ort <>  oko.schuldner_ort THEN CONCAT('ORT: ', ticket.ort)
            ELSE null
             END ortaenderung, --  ortaenderung
        CASE
            WHEN ticket.strasse <> oko.schuldner_strasse THEN CONCAT('STR: ', ticket.strasse)
            ELSE null
             END strassenaenderung , --  strassenaenderung
        status.text status,
        anruf_status.text anruf_status, 
		janein2.text adresscheck,
		janein3.text vorlage,
		janein4.text emailcheck,
		IFNULL(nummern2.text,'k.A.') loesungsvorschlag,
		grund.text ratenbriefhinweis,
        REPLACE(CAST(IFNULL(dummy_number6,0) AS CHAR), '.', ',') ratenhoeh_verein,
        DATE_FORMAT(dummy_date1, '%d-%m-%Y') ratenzahlung_am, 
        DATE_FORMAT(wiedervorlage, '%Y-%c-%d') wiedervorlage, 
		REPLACE( ergebnis, CHAR(13,10), ' ' ) ergebnis,
        status.text status_text,
        anruf_status.text anruf_status_text,
        zeit,
        DATE_FORMAT(oko_log.start_ges, '%d.%m.%Y') gespraechsdatum, -- 'Gespraechsdatum',
        TIME_FORMAT(oko_log.start_ges, '%H:%i:%s') gespraechszeit , -- 'Gespraechszeit',
        oko_log.anrede ag_anrede , -- 'AgentenAnrede',
        oko_log.vorname ag_vorname, -- 'AgentenVorname',
        oko_log.nachname ag_nachname, -- 'AgentenNachname',
        zeit,
        DATE_FORMAT(beginn, '%d.%m.%Y') beginn, -- = Datum der Einspielung/Tag der Schnittstelle,
		DATE_FORMAT(beginn, '%M') monat , -- = Datum der Einspielung/Tag der Schnittstelle,
		case when DATE_FORMAT(oko_log.start_ges, '%H') between 00 and 11 then 'VM'
              when DATE_FORMAT(oko_log.start_ges, '%H') between 12 and 16 then 'NM'
              when DATE_FORMAT(oko_log.start_ges, '%H') between 17 and 23 then 'AB'
               else  'UD' end tageszeit
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
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz

 from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
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
where mandant_id = 16 ) oko_log on oko_log.id  = ticket.id and ticket.mandant_id = oko_log.mandant_id
left outer join oko on oko.id = ticket.ticketnr -- OKO 

	where ticket.mandant_id =16 

";

//TESTNeu
//
$query_check_SCBKorr = "

select count(*) anzahl_n_verarbeitet from ticket
                               left outer join status status on status.id = ticket.status_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
        left outer join prioritaet prio on prio.id = ticket.prioritaet_id
where ticket.mandant_id =16 and status_id = 55 and
anruf_status_id in (197) 
and dummy_text3 like '%Santander Consumer Bank GmbH%'
and not prioritaet_id in (61,62)
";  
$query_check_SCBKorr_data = "
select 'id', 'ticketnr', 'scbkorr'
UNION
select ticket.id id ,ticketnr ticketnr, prio.text scbkorr
 from ticket
                               left outer join status status on status.id = ticket.status_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
         left outer join prioritaet prio on prio.id = ticket.prioritaet_id
where ticket.mandant_id =16 and status_id = 55 and
anruf_status_id in (197) 
and dummy_text3 like '%Santander Consumer Bank GmbH%'
and not prioritaet_id in (61,62)
";  

//
echo "<br><br><b>Pr&uuml;fung Abfrage Status 'erledigt' - Anrufstatus nicht 'erreicht','unerreichbar' oder 'telefonnummer falsch':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_status_anruf_status);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | Anruf_Status: ".$line['anzahl_n_verarbeitet']."<br>";
//
echo "<br><br><b>Status ERLEDIGT und NICHT ERREICHT oder UNERREICHBAR oder TELEFONNUMMER FALSCH:<br></b>";
$result = mysqli_query($dbconn, $query_status_anruf_status_err_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['status_text'].";".$line['anruf_status_text'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
	   //	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}


//
echo "<br><br><b>Pr&uuml;fung Check SCBKorrKZ:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_check_SCBKorr);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;SCBKorrKZ falsch gesetzt: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysqli_query($dbconn, $query_check_SCBKorr_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['scbkorr'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	   	   
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
//


//
// keine Ausgabe mehr weil Felder ausgebaut - Tafr/2022-07-03
// echo "<br><br><b>Pr&uuml;fung Adress-Check und eMail-Check und Arbeitgebercheck gesetzt:<br></b>";
// echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_adr_email_check);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
		// keine Ausgabe mehr weil Felder ausgebaut - Tafr/2022-07-03
     //  echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Adress-Check und/oder eMail-Check und/oder Arbeitgeber-Check NICHT gesetzt: ".$line['anzahl_n_verarbeitet']."<br>";
//


$result = mysqli_query($dbconn, $query_adr_email_check_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['status_text'].";".$line['anruf_status_text'].";".$line['adrcheck'].";".$line['emailcheck'].";".$line['arbeitgeberdatencheck'].";";
// keine Ausgabe mehr weil Felder ausgebaut - Tafr/2022-07-03
//echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	   	   
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
// Kontakt_Telefonnummer
echo "<br><br><b>Pr&uuml;fung Check KONTAKT_TELEFONNR:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_check_kontakttelnr);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;KONTAKT_TELEFONNR NICHT gesetzt: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysqli_query($dbconn, $query_check_kontakttelnr_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['kontakttelnr'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	   	   
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
//
//
echo "<br><br><b>Pr&uuml;fung Check Zahlungsvereinbarungen:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_check_rate);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Zahlungsverereinbarungen gesetzt: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysqli_query($dbconn, $query_check_rate_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['loesungsvorschlag'].";".$line['ratenhoehe_verein'].";".$line['ratenzahlung_am'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	   	   
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
//

echo "<br><br><br><b>Status ERLEDIGT und ERREICHT oder UNERREICHBAR oder TELEFONNUMMER FALSCH:<br></b>";
$result = mysqli_query($dbconn, $query_status_anruf_status_pos_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['ticketnr'].";".$line['status_text'].";".$line['anruf_status_text'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}

echo "<br><br><b>Truncate Tabellen für Status-Check :<br></b>";
if (mysqli_query($dbconn, $trunc_okoerledigt))
  {
  echo "TRUNCATE TABLE OKOERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $trunc_okoerreicht))
  {
  echo "TRUNCATE TABLE OKOERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $trunc_okounerreichbar))
  {
  echo "TRUNCATE TABLE OKOUNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn, );
  }
  if (mysqli_query($dbconn, $trunc_okotelefonnummerfalsch))
  {
  echo "TRUNCATE TABLE OKOTELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn, );
  }

  echo "<br><b>INSERT Tabellen für Status-Check :<br></b>";
if (mysqli_query($dbconn, $ins_okoerledigt))
  {
  echo "INSERT TABLE OKOERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn, );
  }
if (mysqli_query($dbconn, $ins_okoerreicht))
  {
  echo "INSERT TABLE OKOERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $ins_okounerreichbar))
  {
  echo "INSERT TABLE OKOUNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $ins_okotelefonnummerfalsch))
  {
  echo "INSERT TABLE OKOTELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }

echo "<br><b>Pr&uuml;fung VOR UPATE - Status  'erledigt' - Anrufstatus nicht 'erreicht','unerreichbar' oder 'telefonnummer falsch':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  

$result = mysqli_query($dbconn, $query_status_upd_check_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['erledigt'] <> $line['summe'])
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Update Status - ungleich erledigt zu erreichbar/unerreichbar/telefonnummer falsch: Erledigt: ".$line['erledigt'].' zu '.$line['summe']."<br>";
       $drucksatz= "Erledigt: ".$line['erledigt']." Erreicht: ".$line['erreicht']." Unerreichbar: ".$line['unerreichbar']." Telefonnummerfalsch: ".$line['telefonnummerfalsch']." Summe: ".$line['summe'];
       echo "<br>".$drucksatz;

    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
       $drucksatz= "Erledigt: ".$line['erledigt']." Erreicht: ".$line['erreicht']." Unerreichbar: ".$line['unerreichbar']." Telefonnummerfalsch: ".$line['telefonnummerfalsch']." Summe: ".$line['summe'];
       echo "<br>".$drucksatz;
	   }

 ?>
 
 <?PHP 
 
}

//

echo "<br><b>Pr&uuml;fung ob Telefonat im Logfile vorhanden':<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysqli_query($dbconn, $query_status_telefonat);
while ($line = dbFetchArray($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Check Telefonat im Logfile vorhanden: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysqli_query($dbconn, $query_status_telefonat_data);
while ($line = dbFetchArray($result)) { ?>
<?PHP
$drucksatz= $line['ticketnr'].";".$line['ticketnr'];
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	   	   
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}
  //

/*  
echo "<br><br><b>Pr&uuml;fung ANRUF_STATUS ERREICHT und CONNECT NICHT = 1:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_check_connect1);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | ANRUF_STATUS ERREICHT und CONNECT NICHT = 1: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysql_query($query_check_connect1_data);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= $line['ticketnr'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
}  
  //
  
echo "<br><br><b>Pr&uuml;fung ANRUF_STATUS UNERREICHT und TELEFONNUMMERFALSCH und CONNECT = 1:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_check_connect2);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_verarbeitet'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | ANRUF_STATUS UNERREICHT und TELEFONNUMMERFALSCH und CONNECT = 1: ".$line['anzahl_n_verarbeitet']."<br>";
//
$result = mysql_query($query_check_connect2_data);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= $line['ticketnr'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
//	
	   
    }
     else {
       echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
    }

 ?>
 
 <?PHP 
 
} 



*/
// mysql_free_result($result);
// mysql_close();

dbClose($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>OKO-Check - Ende: ".$heute;

?>
</body>    
</html>
