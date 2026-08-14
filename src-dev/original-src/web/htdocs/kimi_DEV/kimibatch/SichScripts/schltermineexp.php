<html>
  <head>
     <title>KIMI-Plus - Schlaustrom Termindaten-Export V 1 20200620</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Schlaustrom Termindaten-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Export - Start: ".$heute;


$query = "select 
 'Projekt',
 'firma',
  'titel',
 'anrede',
 'nachname',
		'vorname',
		'strasse',
        'hausnummer',
		'Plz',
		'Ort',
		'Telefon1',
		'Telefon2',
        'terminbearbeitet',
		'Bemerkung',
        'Webseite',
		'Zusatz',
		'FAX',
		'dzt. Versorger',
        'Inko-Aktion',
        'Gespraechsdatum',
        'Gespraechszeit',
        'Fehlerstatus',
		'AgentenAnrede',
        'AgentenVorname',
        'AgentenNachname',
		'X',
	    'ticketnr',
		'kundennummer',
		'anruf_status',
		'Jahresabrechnung', -- 'antwort_frage1_loesung',
		'Kundenberater', -- 'antwort_frage1_telefonnummer',
        'TerminTag', -- ende 
        'TerminDatum', -- ende 
        'Uhrzeit', -- afufwand
		'Strom_Gas' , -- 'antwort_frage2_loesungsvorschlag',
		'kwh' , -- 'antwort_frage2_hintergrund',
		'wiedervorlage',
		'ergebnis',
        'status',
		'zeit',
		'beginn',
		'monat',
        'tageszeit',
        'dauergesamt',
		'Y', -- neu ab 18.1.2016
        'E-Mail',
		'kontakttel_vw',
        'kontkattel_hw'
		union
		select
        'schlaustrom',
        ticket.fahrgestellnummer,
        ticket.titel,
        ticket.anrede,
		ticket.nachname,
		ticket.vorname,
		ticket.strasse,
		ticket.hausnummer_erw,
		ticket.plz,
		ticket.ort,
		ticket.telefon, -- telefon ORIG
		ticket.telefon2, -- telefon2  ORIG
		DATE_FORMAT(ticket.geburtsdatum, '%d.%m.%Y') , -- geburtsdatum
		REPLACE( beschreibung_detail, CHAR(13,10), ' ' ),         -- Bemerkung
	    dummy_text2, -- WEBSeite
        dummy_text3, -- Zusatz
		dummy_text4, -- fax
        REPLACE( dummy_text5, CHAR(13,10), ' ' ), -- dzt. Versorger
		null, -- REPLACE(REPLACE( ergebnis, CHAR(13,10), ' ' ),';',','), -- 'Inko-Aktion',
        DATE_FORMAT(inko_log.start_ges, '%d.%m.%Y') , -- 'Gespraechsdatum',
        TIME_FORMAT(inko_log.start_ges, '%H:%i:%s') , -- 'Gespraechszeit',
        anruf_status.text, -- 'Fehlerstatus',
		inko_log.anrede , -- 'AgentenAnrede',
        inko_log.vorname , -- 'AgentenVorname',
        inko_log.nachname , -- 'AgentenNachname',
        'x',
	    ticketnr,
		kundennummer,
		anruf_status.text,
		janein1.text antwort_frage1_loesung,
		produkt.text antwort_frage1_telefonnummer,
         DATE_FORMAT(ticket.ende, '%W'), -- termin
         DATE_FORMAT(ticket.ende, '%d %M %Y'), -- termin
        ticket.aufwand, -- uhrzeit
		nummern2.text antwort_frage2_loesungsvorschlag,
		grund.text antwort_frage2_hintergrund,
        DATE_FORMAT(wiedervorlage, '%Y-%c-%d') , 
		concat( anruf_status.text, ' - ', status.text, ': ',REPLACE( ergebnis, CHAR(13,10), ' ' ) ), -- ergebnis
        status.text,
        sec_to_time(inko_log.dauerinsec) zeit,
        DATE_FORMAT(beginn, '%d.%m.%Y') , -- = Datum der Einspielung/Tag der Schnittstelle,
		DATE_FORMAT(beginn, '%M') , -- = Datum der Einspielung/Tag der Schnittstelle,
		case when DATE_FORMAT(inko_log.start_ges, '%H') between 00 and 11 then 'VM'
              when DATE_FORMAT(inko_log.start_ges, '%H') between 12 and 16 then 'NM'
              when DATE_FORMAT(inko_log.start_ges, '%H') between 17 and 23 then 'AB'
               else  'UD' end ,
        -- TIME_FORMAT(inko_log.dauer, '%H:%i:%s')
		sec_to_time(inko_log.dauerinsec),
        'y',
        ticket.email,
		ticket.verkaeufercode, -- kontakttelefonnr_vorwahl,
        ticket.standort -- kontakttelefonnr_haupt,

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
where mandant_id = 32

 ) inko_log on inko_log.id  = ticket.id and ticket.mandant_id = inko_log.mandant_id

-- join inkode inkode on inkode.id = ticket.ticketnr

	where ticket.mandant_id =32
 --   and not ticket.status_id in(151)
-- and upper(ergebnis) like '%VERBUND%'
and ticket.ticketnr in (
-- 2316,2318,6254,10742,11814,12244,12696) -- 19.5.2020 
-- 3621,5120,7177,7547,16458, 6450,6450) -- 20.5.2020 
-- 6963) -- 20.5.2020 - 2 
-- 9093, 8122, 16647, 16636) -- 22.5.2020
-- 16634, 16641) -- 22.5.2020
-- 16649, 16637,15773,16414,13146,16626,3525) -- 25.5.2020
-- 3543,13116,16462,13098,11128,11167) -- 26.5.2020
-- 13199,9979,9608,6036,5171) -- 27.5.2020
-- 7069) -- 28.5.2020
-- 3624, 4243) -- 29.5.2020
-- 5172, 16658, 16675, 5455,11128, 13230,16626) -- 2.6.2020
-- 16680, 10358, 12874) -- 3.6.2020
-- 16674,16708,16717,4243,16715,10443,6859,10443) 4.6.2020
-- 13136,8284,11982) -- 5-6-2020
-- 10646,12580,9823,6607,8620,9155,10695,11533) -- 8.6.2020
-- 7478,12205,13400,14372,12581 ) -- 9.6.2020
-- 16693,11744) -- 10.6.2020
-- 3610,3586,13398) -- 12.6.2020
-- 5040, 16741,11766,16655, 16702, 16732) -- 15.6.2020
-- 12496,9998,5909,13211,13250,12887) -- 16.6.2020
-- 13204,3606,16731) -- 17.6.2020
-- 3500,16743,10840,3495) -- 18.6.2020
-- 12901, 13007,15955,15559) -- 19.6.2020
-- 16756,16753, 15955 , 12923 , 10859, 10859 , 16758) -- verbund 20.6.2020
-- 2335,2338,2344,2345,2359,2366,4566,10603,15628,13292) -- 22.6.2020
-- 13301,12759,11263,12960) -- 23.6.
-- 9417,11110,16784,15341,12553,2327) -- 24.6
-- 13280,4963) -- 25.6.
-- 3534, 4114) -- 10399, 12875,7212,15709 )  -- 26.6.
-- 2605,8159,16795,2152,2155,2156,2180,2594,2599 ) -- 29.6.
-- 4587,5772,8452,9383,16802,2145,15032,13473,14757,13545) -- 30.6
-- 595,596,8056,4271,8776,10353,10081) -- 2.7
-- 606,600) -- 3.7
-- 13681,13756,13831,13884,15627,15724) -- 6.7.
-- 613,3910,7096,8756,10819,10910,12658) -- 7.7^
-- 12658,13943,13955,13960,13962,15504) -- 8.7
-- 13526,3845,16821,16816,6847,10653) -- 9.7
-- 16834,612) -- 10.7
-- 3313,3314) -- 13.7
-- 6975) -- 14.7
-- 3643,3417,3423) -- 15.7.
-- 7339) -- 16.7
-- 546,9396,16048) -- 17.7
-- 14502,15464,15121) -- 20.7
-- 8426, 5761) -- 21.7
-- 14955,9035,14874) -- 22.7
-- 2160,2187,16727,13500,9378,10650,12034,2329,10152,2171,3496) -- 23.7
-- 4959,13021,15325) -- 24.7
-- 16882,16873,13022,4187,7680,9075,12369,3389) -- 27.7
-- 15566,12225,5150,14566,65,12578,14387) -- 28.7
-- 2138,13680,4303,13822) -- 29.7
-- 4018, 3846,15677) -- 30.7
-- 10470,4118,5272,543) -- 31.7
-- 724, 7982 ,11257, 13348, 13500, 13756, 14316,16390, 16847 ) -- 3.8.2020 16390) -- 3.8.2020 
-- 16520,730,731,4239,5830,8101,10884,12633,14643,14705) -- 4.8-2020
-- 14351,3470, 3839, 4273, 6180, 6391,6292, 7149, 7432, 3464, 3466) -- 5.8.2020
-- 12985,11056,10839,13565,13424,13442,13419) -- 6.8.2020
-- 13998, 5930,13376,16887) -- 7.8.2020
-- 13568,16058,2990,16886,16859,7382,724) -- 10.8.2020
-- 4242,14740,12508,16541,1122,14739) -- 11.8.2020
-- 16594, 9906) -- 12.8.2020
-- 13973,14644,10109) -- 13.8.2020
-- 13974) -- 14.8
-- 6391, 11638,11884,3994,13249,14859,14977,15060, 16027) -- 17.8.2020
-- 10757,7333,3797, 3833,13547) -- 18.8
-- 3797,9215,15300) -- 19.8
-- 14309,10891,10411,10329,8381,6536,5936,6379,8450) -- 20.8
-- 5937,12557,7070,14466,13693,10779) -- 21.8 
-- 3577, 4277,5967,6502,7563,13144,13094,8906,11455,13620) -- 24.8.2020
-- 2306, 7846, 9839) -- 25.8.2020
 -- 11315,15387,10029,8305,7204,5255,7308,10037,11759,13738,16348 ) -- 26.8.2020
-- 16899,10889,31837,34379,18831) -- 27.8.2020
-- 37848,15217,33311,35033,29232) -- 28.8.2020
-- 10071,16764,15788,16488,3934,2712,4135,3796,7976,16812) -- 31.8.2020
-- 1735,2989,33475,16488,43266,39646,12961,13260,19739,19773,19776,28772,32260,34626) -- 1.9.2020
-- 12199,37934,33475,11545,737,14466,42820,53180) -- 2.9.2020
-- 16922,65010,64869,61885,42771,16949,16914,18853,39755,16915) -- 3.9.2020
-- 16946,16937,16948,16935,72492, 16929,16927,16926,72562) -- 4.9.2020
-- 67437 ) -- 5.9
-- 18865,16945,16972 ) -- 7.9
-- 16971,49502,43412,16999,75069,42021,71367,70040) -- 8.9
-- 4368,51254,75071,53137,62719,580,75074,62709,45958 ) -- 9.9 und 10.9
-- 67161,16932,6502,75077,75078,75079) -- 11.9
-- 75069) -- 12.9
-- 11455, 1460,6871,8213,10003,75080,8992,11716,12187,75081) -- 14.9
-- 75009,75010,75008,75100,31775,75091,871,875,901,903,75099,75013,75097) -- 15.9
 -- 16904,75097,4225,16488,7923,868,15251,11957,11162,38038,6203,69829) -- 16.9
-- 75054,75126,75074 ) -- 17.9
75051,75127,48123 ) -- 18.9
";

$filename = "files/".date("YmdHi")."__SchlaustromTermine".".csv";
$fp = fopen($filename, 'w');


$result = mysql_query($query);
// 
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['Projekt'].";".$line['firma'].";".$line['titel'].";".$line['anrede'].";".$line['nachname'].";".$line['vorname'].";".$line['strasse'].";".$line['hausnummer'].";".$line['Plz'].";"; 
        $string = $string.$line['Ort'].";".$line['Telefon1'].";".$line['Telefon2'].";".$line['terminbearbeitet'].";".$line['Bemerkung'].";".$line['Webseite'].";".$line['Zusatz'].";".$line['FAX'].";".$line['dzt. Versorger'].";"; 
        $string = $string.$line['Inko-Aktion'].";".$line['Gespraechsdatum'].";".$line['Gespraechszeit'].";".$line['Fehlerstatus'].";".$line['AgentenAnrede'].";".$line['AgentenVorname'].";".$line['AgentenNachname'].";".$line['X'].";".$line['ticketnr'].";"; 
        $string = $string.$line['kundennummer'].";".$line['anruf_status'].";".$line['Jahresabrechnung'].";".$line['Kundenberater'].";".$line['TerminTag'].";".$line['TerminDatum'].";".$line['Uhrzeit'].";".$line['Strom_Gas'].";".$line['kwh'].";"; 
        $string = $string.$line['wiedervorlage'].";".$line['ergebnis'].";".$line['status'].";".$line['zeit'].";".$line['beginn'].";".$line['monat'].";".$line['tageszeit'].";".$line['dauergesamt'].";".$line['Y'].";"; 
        $string = $string.$line['E-Mail'].";".$line['kontakttel_vw'].";".$line['kontkattel_hw']; 
		$string = $string."\n"; 
        //echo $string;
        // being transformed into a newline
        fwrite($fp, $string); // will proccess /n as newline ... 	
	
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


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Schlaustrom Termindaten-Export- Ende: ".$heute;

?>
</body>    
</html>
