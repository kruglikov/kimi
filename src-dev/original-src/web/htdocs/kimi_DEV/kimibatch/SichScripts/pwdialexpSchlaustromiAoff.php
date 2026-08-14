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
'rufnummer_anzeige',
'0zufallszahl-sort',
'art'
from dual
union
select 
 concat('',DATE_FORMAT(now(), '%Y%m%d%H%i'), '__kimi_ET__',t.mandant_id,'__',m.text,'_inAoff'), ';', -- listenname
1 ,';', -- kampagne_id
 'kimi_ET', ';', -- db_name
  concat('',m.text,''),';', -- mandant_kuerzel
  concat('',t.id,''),';', -- ticketid
  concat('',replace(t.nachname,' ',''),' ',replace('',' ','')),';', -- schuldnername
  concat(replace(t.telefon,' ',''),''),';', -- telefonnummer 1
  concat(replace(t.telefon2,' ',''),''),';', -- telefonnummer 2
--   concat('0043',case when cast(IFNULL(t.telefon,0) as INTEGER)= 0 then cast(t.telefon2 as INTEGER) else cast(t.telefon as INTEGER) end,''),';', -- telefonnummer 1
--  concat( ''/*'0043',t.telefon2*/,''),';', -- telefonnummer 2
  '0732209961',
  FLOOR(1+ RAND() * 999) ,-- zufallszahl zum Sortieren
t.status_id -- art NEU oder in Arbeit
 from ticket t
join mandant m on m.id = t.mandant_id
where t.mandant_id = 27 and t.status_id in(119,120)  -- and t.status_id in(119,120)
and not t.telefon ='-' 
union
select 
 concat('',DATE_FORMAT(now(), '%Y%m%d%H%i'), '__kimi_ET__',t.mandant_id,'__',m.text,'_inAoff'), ';', -- listenname
1 ,';', -- kampagne_id
 'kimi_ET', ';', -- db_name
  concat('',m.text,''),';', -- mandant_kuerzel
  concat('',t.id,''),';', -- ticketid
  concat('',replace(t.nachname,' ',''),' ',replace('',' ','')),';', -- schuldnername
  concat(replace(t.telefon,' ',''),''),';', -- telefonnummer 1
  concat(replace(t.telefon2,' ',''),''),';', -- telefonnummer 2
--   concat('0043',case when cast(IFNULL(t.telefon,0) as INTEGER)= 0 then cast(t.telefon2 as INTEGER) else cast(t.telefon as INTEGER) end,''),';', -- telefonnummer 1
--  concat( ''/*'0043',t.telefon2*/,''),';', -- telefonnummer 2
  '0732209961',
  FLOOR(1+ RAND() * 999) ,-- zufallszahl zum Sortieren
t.status_id -- art NEU oder in Arbeit
 from ticket t
join mandant m on m.id = t.mandant_id
where t.mandant_id = 27   and t.status_id in(119,120)  -- and t.status_id in(119,120)
and not t.telefon2 ='-' and t.telefon = '-' 
group by concat(t.telefon) 
order by 18,9 desc
";

$filename = "files/".date("YmdHi")."__kimi_ET__27__Schlaustrom_inAoff".".csv";
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
