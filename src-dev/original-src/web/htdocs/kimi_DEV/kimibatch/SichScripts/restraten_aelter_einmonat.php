<html>
  <head>
     <title>KIMI-Plus - Restrate älter 1 Monat</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Restrate älter 1 Monat</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Restrate mit Abbucher - Start: ".$heute;
// Abfrage 
$query = "SELECT 'id', 'nachname', 'vorname', 'gesamtsaldo', 'ratenhoehe', 'dat_l_zahlung', 'stichtag'
UNION
SELECT s.id, k.nachname, k.vorname, s.gesamtsaldo, s.ratenhoehe, s.dat_l_zahlung, s.stichtag FROM stammdaten s join kunde k on k.id = s.id where s.gesamtsaldo < s.ratenhoehe and s.dat_l_zahlung < adddate(curdate(),interval -30 day) and ( 
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
and IFNULL(s.inkassostatus_id,0) not between 03 and 89 and s.gesamtsaldo > 5 and
 s.id not in (SELECT s.id FROM stammdaten s join kundenhistorie kh on kh.kdnr_id = s.id where kh.text like '%Sammelfall_Restrate%')


";
//
$filename = "files/Restraten_aelter_einmonat_".date("YmdHis").".csv";
$fp = fopen($filename, 'w');
$start = date("d.m.Y H:i:s");
// �berschriftszeile
$string ="Start;".$start.";;;;;;;;;;;;;;;;;;;"."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['id'].";".$line['nachname'].";".$line['vorname'].";".$line['gesamtsaldo'].";".$line['ratenhoehe'].";".$line['dat_l_zahlung'].";".$line['stichtag'].";"."\n"; 
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
echo "<br>Restrate älter 1 Monat - Ende: ".$heute;

?>

</body>    
</html>
