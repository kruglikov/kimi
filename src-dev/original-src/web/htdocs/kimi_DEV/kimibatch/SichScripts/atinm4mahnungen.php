<html>
  <head>
     <title>KIMI-Plus - ATIN M4 Mahnungen</title>
  </head>
  <body>
  <h1>KIMI-Plus -  ATIN M4 Mahnungen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "ATIN M4 Mahnungen - Start: ".$heute;
// Abfrage 
$query = "SELECT 'vermerk','ktonr', 'nachname', 'vorname', 'gesamtsaldo', 'inkassostatus_id', 'text', 'status_dat', 'stichtag'
UNION
SELECT '',s.ktonr, k.nachname, k.vorname, 
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ','),
s.inkassostatus_id, i.text, s.status_dat, s.stichtag
FROM stammdaten s
join kunde k on k.id = s.id
join inkassostatus i on i.id = s.inkassostatus_id
join subkonto_neu skn on skn.stammdaten_id = s.id
where skn.kz_aktuell = 'J'
and IFNULL(skn.m4,0) > 0
and ( 
s.stichtag in (
select stichtag1 from verwaltungssatz where kz_aktuell = 'J')
or
s.stichtag in (
select stichtag2 from verwaltungssatz where kz_aktuell = 'J')
or
s.stichtag in (
select stichtag3 from verwaltungssatz where kz_aktuell = 'J')
or
s.stichtag in (
select stichtag4 from verwaltungssatz where kz_aktuell = 'J')
or
s.stichtag in (
select stichtag5 from verwaltungssatz where kz_aktuell = 'J')
)
and IFNULL(s.inkassostatus_id,0) not between 01 and 91
and s.gesamtsaldo > 5
group by s.ktonr
";
//
$filename = "files/ATIN_Neuzugaenge_und_Nachbearbeitungen_".date("YmdHis").".csv";
$fp = fopen($filename, 'w');
$start = date("d.m.Y H:i:s");
// �berschriftszeile
$string ="Start;".$start.";;;;;;;;;;;;;;;;;;;"."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['vermerk'].";".$line['ktonr'].";".$line['nachname'].";".$line['vorname'].";".$line['gesamtsaldo'].";".$line['inkassostatus_id'].";".$line['text'].";".$line['status_dat'].";".$line['stichtag'].";"."\n"; 
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
echo "<br>ATIN M4 Mahnungen - Ende: ".$heute;

?>

</body>    
</html>
