<html>
  <head>
     <title>KIMI-Plus - POWERDIALER-Export V 1 20200620</title>
  </head>
  <body>
  <h1>KIMI-Plus -  POWERDIALER-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Export - Start: ".$heute;


$query = "select
'listenname',';',
'kampagne_id',';',
'db_name',';',
'mandant_kuerzel',';',
'ticket_id',';',
'schuldnername',';',
'telefonnummer1',';',
'telefonnummer2',';',
'rufnummer_anzeige'
from dual
union
select 
 concat('',DATE_FORMAT(now(), '%Y%m%d%H%i'), '__kimi_ET__',t.mandant_id,'__',m.text,'_off'), ';', -- listenname
4, ';', -- kampagne_id
 'kimi_ET', ';', -- db_name
  concat('',m.text,''),';', -- mandant_kuerzel
  concat('',t.id,''),';', -- ticketid
  concat('',replace(t.nachname,' ',''),' ',replace(t.vorname,' ','')),';', -- schuldnername
  concat(CASE WHEN t.telefon ='' THEN '' ELSE '10950049' END ,replace(t.telefon,' ',''),''),';', -- telefonnummer 1
  concat(CASE WHEN t.telefon2 ='' THEN '' ELSE '10950049' END,replace(t.telefon2,' ',''),''),';', -- telefonnummer 2
  '00491703712712'-- '004985137956007'
 from ticket t
join mandant m on m.id = t.mandant_id
where 
-- (beginn != '2020-04-21')
not fahrgestellnummer like 'Novum Bank%'
and (( t.mandant_id = 24 and t.status_id in(103333333333333)
and anruf_status_id in (329,330,331,332,334,339) ) -- 1,2,3ter und 4ter Anruf und erreicht - später anrufen/Rückruf und Telefonnummer falsch 
or (
t.mandant_id = 24 and t.status_id in(104)
and anruf_status_id is null)
)
order by 9 desc
";

$filename = "files/".date("YmdHi")."__kimi_ET__24__INKODE_off".".csv";
$fp = fopen($filename, 'w');


$result = mysql_query($query);
// 
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['listenname'].";".$line['kampagne_id'].";".$line['db_name'].";".$line['mandant_kuerzel'].";".$line['ticket_id'].";".$line['schuldnername'].";".$line['telefonnummer1'].";".$line['telefonnummer2'].";".$line['rufnummer_anzeige']; 

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
echo "<br><br>"."POWERDIALER-Export- Ende: ".$heute;

?>
</body>    
</html>
