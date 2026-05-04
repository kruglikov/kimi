<html>
  <head>
     <title>KIMI-Plus - COEO CH DE-Export</title>
  </head>
  <body>
  <h1>KIMI-Plus -  COEO CH DE-Export</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "COEO CH DE-Export - Start: ".$heute;

 
$query = "select 'Datum','ticketnr','az', 'statuas','status.text','anruf_status','anruf_status.text','benutzer','geaendert','k.status_Dialer','k.beschreibung_positiver_ausgang','k.grund_negativer_ausgang','k.nachname_agenten','t.art','art.text','kimi_ergebnis','maxkdate','maxkid','kid','Pivot','anzahl_anrufe','kampagne','Anrufbeantworter','KampagneId','VorgangId'
 from ticket t 

union
select  
--
curdate(),t.ticketnr,concat('AZ: ',t.dummy_text9), t.status_id,
 case when status.text = 'gemeldet' THEN 'erledigt' ELSE status.text END "status.text",
t.anruf_status_id,
-- anruf_status.text,
case when anruf_status.text like '%gemeldet-%' THEN REPLACE(anruf_status.text, 'gemeldet-', '') ELSE anruf_status.text END  "anruf_status.text",
benutzer.nachname,t.geaendert_am,k.status,
-- k.beschreibung_positiver_ausgang,
case when grund.text = 'RÜCKRUF OUTBOUND' then prioritaet.text else k.beschreibung_positiver_ausgang end ,
k.grund_negativer_ausgang,k.nachname_agenten,t.grund_id,grund.text,REPLACE( ergebnis, CHAR(13,10), ' ' ) ergebnis,k.import,k.id,k.id, case when k.id = k.id then 'max' else '' end , 1 anzahl_anrufe,fahrgestellnummer,
case when k.status = 'Anrufbeantworter' then 'JA' else 'NEIN' end
--
,knp3.kampagneid
,knp3.vorgangid
--

from ticket t 
left outer join ( Select knp3.* from knp3  ) knp3 on knp3.id = t.ticketnr

 -- left outer join ( Select ki.* from knp3_out as ki ) k3 on k.imp_str_ticketnr = t.ticketnr
/*
left outer join  ( SELECT ki.imp_str_ticketnr imp_str_ticketnr, MAX(ki.import) maxkDate, MAX(ki.id) maxkid,count(*) anzahl_anrufe
        FROM knp3_out ki 
        GROUP BY ki.imp_str_ticketnr
    ) ko ON t.ticketnr = ko.imp_str_ticketnr -- and ko.maxkid = k.id 
*/

LEFT OUTER JOIN (
    SELECT
        ki2.*
    FROM knp3_out ki2
    JOIN (
        SELECT
            imp_str_ticketnr,
            MAX(import) AS max_anrufzeit
        FROM knp3_out where verarbeitet = '2025-12-18'
        GROUP BY imp_str_ticketnr
    ) x
      ON  x.imp_str_ticketnr      = ki2.imp_str_ticketnr
      AND x.max_anrufzeit = ki2.import
) k
    ON k.imp_str_ticketnr = t.ticketnr
--  left outer join ( Select ki.* from knp3_out as ki order by ki.verarbeitet DESC LIMIT 1) k on k.imp_str_ticketnr = t.ticketnr

        left outer join
    status  ON status.id = t.status_id
        left outer join
    prioritaet prioritaet ON prioritaet.id = t.prioritaet_id
        left outer join
    anruf_status  ON anruf_status.id = t.anruf_status_id
        left outer join
    grund ON grund.id = t.grund_id
            left outer join
    benutzer ON benutzer.id = t.benutzer_id

 where t.mandant_id = 41 and ticketnr in(
select imp_str_ticketnr  FROM knp3_out ki where verarbeitet = '2025-12-18' -- diese Ticket selektion muss auf den Auswertungszeitpunkt hin ausgewertet werden
)
UNION
select  
--
curdate(),t.ticketnr,concat('AZ: ',t.dummy_text9), t.status_id,
 case when status.text = 'gemeldet' THEN 'erledigt' ELSE status.text END "status.text",
t.anruf_status_id,
-- anruf_status.text,
case when anruf_status.text like '%gemeldet-%' THEN REPLACE(anruf_status.text, 'gemeldet-', '') ELSE anruf_status.text END  "anruf_status.text",
benutzer.nachname,t.geaendert_am,k.status,
-- k.beschreibung_positiver_ausgang,
case when grund.text = 'RÜCKRUF OUTBOUND' then prioritaet.text else k.beschreibung_positiver_ausgang end ,
k.grund_negativer_ausgang,k.nachname_agenten,t.grund_id,grund.text,REPLACE( ergebnis, CHAR(13,10), ' ' ) ergebnis,k.import,k.id,k.id, case when k.id = k.id then 'max' else '' end , 1 anzahl_anrufe,fahrgestellnummer,
case when k.status = 'Anrufbeantworter' then 'JA' else 'NEIN' end
--
,knp3.kampagneid
,knp3.vorgangid
--
from ticket t 
left outer join ( Select knp3.* from knp3  ) knp3 on knp3.id = t.ticketnr
/*
left outer join  ( SELECT ki.imp_str_ticketnr imp_str_ticketnr, MAX(ki.import) maxkDate, MAX(ki.id) maxkid,count(*) anzahl_anrufe
        FROM knp3_out ki 
        GROUP BY ki.imp_str_ticketnr
    ) ko ON t.ticketnr = ko.imp_str_ticketnr -- and ko.maxkid = k.id 
*/

LEFT OUTER JOIN (
    SELECT
        ki2.*
    FROM knp3_out ki2
    JOIN (
        SELECT
            imp_str_ticketnr,
            MAX(import) AS max_anrufzeit
        FROM knp3_out where verarbeitet = '2025-12-18'
        GROUP BY imp_str_ticketnr
    ) x
      ON  x.imp_str_ticketnr      = ki2.imp_str_ticketnr
      AND x.max_anrufzeit = ki2.import
) k
    ON k.imp_str_ticketnr = t.ticketnr
--  left outer join ( Select ki.* from knp3_out as ki order by ki.verarbeitet DESC LIMIT 1) k on k.imp_str_ticketnr = t.ticketnr

        left outer join
    status  ON status.id = t.status_id
        left outer join
    prioritaet prioritaet ON prioritaet.id = t.prioritaet_id
        left outer join
    anruf_status  ON anruf_status.id = t.anruf_status_id
        left outer join
    grund ON grund.id = t.grund_id
            left outer join
    benutzer ON benutzer.id = t.benutzer_id

 where t.mandant_id = 41 and ticketnr in(
11419, 11423,11424 -- die restlichen erledigten die nicht über Elsbeth gelaufen sind - noch rausselektieren
)
";

$filename = "files/coeochdeexp".date("YmdHis").".csv";
$fp = fopen($filename, 'w');

// Ueberschriftszeile _ KOMMT UEBER SELECT

$result = mysqli_query($dbconn, $query);
// 
while ($line = dbFetchArray($result)) { 
        //fputcsv($fp, array_keys($line));

		//
		$string = $line['Datum'].";".$line['ticketnr'].";".$line['az'].";"; 
		$string = $string.$line['statuas'].";".$line['status.text'].";".$line['anruf_status'].";"; 		
		$string = $string.$line['anruf_status.text'].";".$line['benutzer'].";".$line['geaendert'].";".$line['k.status_Dialer'].";".$line['k.beschreibung_positiver_ausgang'].";".$line['k.grund_negativer_ausgang'].";".$line['k.nachname_agenten'].";".$line['t.art'].";"; 				
		$string = $string.$line['art.text'].";".$line['kimi_ergebnis'].";".$line['maxkdate'].";".$line['maxkid'].";".$line['kid'].";".$line['Pivot'].";".$line['anzahl_anrufe'].";".$line['kampagne'].";".$line['Anrufbeantworter'].";".$line['KampagneId'].";".$line['VorgangId']; 
		
		//$string = $string.";"."\n"; 
		//20220520/FT \r für CR hinzugefügt		
		$string = $string.";"."\r\n"; 
		
		//20220520/FT Konvertierung auf ANSI
		$string = iconv("UTF-8", "WINDOWS-1252", $string);		
        
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
echo "<br><br>"."INKO2016-Export - Ende: ".$heute;

dbClose($dbconn);

?>
</body>    
</html>
