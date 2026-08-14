<html>
  <head>
     <title>KIMI-Plus - Lastschrift EXCEL-File</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Lastschrift EXCEL-File</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Lastschrift EXCEL-File - Start: ".$heute;
// Abfrage 
$query = "
select '1' z,'ktonr','einziehbetrag','lastschrift','kz_lastschrift','sepa_einzug_sequenz','iban','bic' ,
'dat_unterschrift','name','ktonr12stellen','budat_frst_rcur','KIMI-Check+','BA/BG','Belegdatum'
UNION
select '2',s.ktonr,
case 
when IFNULL(s.gesamtsaldo,0) > IFNULL(s.ratenhoehe,0) then REPLACE(CAST(IFNULL(s.ratenhoehe,0) AS CHAR), '.', ',')
else REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ',')
end einziehbetrag,
s.lastschrift,l.kz_lastschrift,l.sepa_einzug_sequenz, l.iban,b.bic ,
DATE_FORMAT(l.dat_unterschrift, '%Y-%m-%d') dat_unterschrift,
CONCAT(k.vorname, ' ', k.nachname) name,
lpad(s.ktonr,12,'0') ktonr12stellen,
case 
when l.sepa_einzug_sequenz = 'FRST' then 
(select ADDDATE(vw.buchungsdatum, INTERVAL +5 DAY) from verwaltungssatz vw
where kz_aktuell = 'J' and markt = 10)
else
(select ADDDATE(vw.buchungsdatum, INTERVAL +2 DAY) from verwaltungssatz vw
where kz_aktuell = 'J' and markt = 10)
end budat_frst_rcur,
case 
when IFNULL(s.gesamtsaldo,0) > IFNULL(s.ratenhoehe,0) then REPLACE(CAST(IFNULL(s.ratenhoehe,0) AS CHAR), '.', ',')
else REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ',')
end kimi_check,
'21/56',''
from stichtag st
join stammdaten s on s.id = st.stammdaten_id
join lastschrift l on l.stammdaten_id = s.id
join kunde k on k.id = s.kunde_id
join bankleitzahl b on b.id = l.bankleitzahl_id
where st.kz_verarbeitet in ( 'I' , 'G')
and (
case when IFNULL(l.kz_lastschrift,'N') = 'J' and IFNULL(l.kz_kzinaktiv,'N') = 'J' then 'I' 
when IFNULL(l.kz_lastschrift,'N') = 'N'then 'N'
when IFNULL(l.kz_lastschrift,'J') = 'J' then 'J'
else null
end ) ='J'
and (case when IFNULL(l.kz_lastschrift,'N') = 'J' and IFNULL(l.kz_kzinaktiv,'N') = 'J' then 'I' 
when IFNULL(l.kz_lastschrift,'N') = 'N'then 'N'
when IFNULL(l.kz_lastschrift,'J') = 'J' then 'J'
else null
end ) = s.lastschrift
UNION
-- Summenzeile
select '3',null,null,null,null,null, null,null ,null,null,null, null,
REPLACE(CAST(
sum(case 
when IFNULL(s.gesamtsaldo,0) > IFNULL(s.ratenhoehe,0) then IFNULL(s.ratenhoehe,0) 
else IFNULL(s.gesamtsaldo,0) 
end)
 AS CHAR), '.', ',')
,
null,null
from stichtag st
join stammdaten s on s.id = st.stammdaten_id
join lastschrift l on l.stammdaten_id = s.id
join kunde k on k.id = s.kunde_id
join bankleitzahl b on b.id = l.bankleitzahl_id
where st.kz_verarbeitet in ( 'I' , 'G')
and (
case when IFNULL(l.kz_lastschrift,'N') = 'J' and IFNULL(l.kz_kzinaktiv,'N') = 'J' then 'I' 
when IFNULL(l.kz_lastschrift,'N') = 'N'then 'N'
when IFNULL(l.kz_lastschrift,'J') = 'J' then 'J'
else null
end ) ='J'
and (case when IFNULL(l.kz_lastschrift,'N') = 'J' and IFNULL(l.kz_kzinaktiv,'N') = 'J' then 'I' 
when IFNULL(l.kz_lastschrift,'N') = 'N'then 'N'
when IFNULL(l.kz_lastschrift,'J') = 'J' then 'J'
else null
end ) = s.lastschrift
order by z,sepa_einzug_sequenz,ktonr
";
//
$filename = "files/lastschrift_".date("YmdHis").".csv";
$fp = fopen($filename, 'w');
$start = date("d.m.Y H:i:s");
// �berschriftszeile
$string ="Start;".$start.";;;;;;;;;;;;;;;;;;;"."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['z'].";".$line['ktonr'].";".$line['einziehbetrag'].";".$line['lastschrift'].";".$line['kz_lastschrift'].";".$line['sepa_einzug_sequenz'].";".$line['iban'].";".$line['bic'].";".$line['dat_unterschrift'].";".$line['name'].";".$line['ktonr12stellen'].";".$line['budat_frst_rcur'].";".$line['KIMI-Check+'].";".$line['BA/BG'].";".$line['Belegdatum'].";"."\n"; 
        //echo $string;
        // being transformed into a newline
        fwrite($fp, $string); // will proccess /n as newline ... 

}
$ende = date("d.m.Y H:i:s");
$string ="Ende;".$ende.";;;;;;;;;;;;;;;;;;;"."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 

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
mysql_free_result($result);
mysql_close();

mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Lastschrift EXCEL-File - Ende: ".$heute;

?>

</body>    
</html>
