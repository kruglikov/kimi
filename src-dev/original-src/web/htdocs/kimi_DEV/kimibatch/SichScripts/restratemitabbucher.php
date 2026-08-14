<html>
  <head>
     <title>KIMI-Plus - Restrate mit Abbucher</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Restrate mit Abbucher</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Restrate mit Abbucher - Start: ".$heute;
// Abfrage 
$query = "SELECT 'id','stichtag','gesamtsaldo','lastschrift'
UNION
SELECT s.id, s.stichtag, 
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ','),
 s.lastschrift
FROM stammdaten s
where s.gesamtsaldo between 1.00 and 10.00
and s.lastschrift = 'J'
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
and IFNULL(s.inkassostatus_id,0) not between 03 and 89
";
//
$filename = "files/Restrate_mit_Abbucher_".date("YmdHis").".csv";
$fp = fopen($filename, 'w');
$start = date("d.m.Y H:i:s");
// �berschriftszeile
$string ="Start;".$start.";;;;;;;;;;;;;;;;;;;"."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['id'].";".$line['stichtag'].";".$line['gesamtsaldo'].";".$line['lastschrift'].";"."\n"; 
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
echo "<br>Restrate mit Abbucher - Ende: ".$heute;

?>

</body>    
</html>
