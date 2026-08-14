<html>
  <head>
     <title>KIMI-Plus - XX und SZ Kenner</title>
  </head>
  <body>
  <h1>KIMI-Plus -  XX und SZ Kenner</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "XX und SZ Kenner - Start: ".$heute;
// Abfrage 
$query = "SELECT 'kdnr', 'nachname','kto_kenner', 'kenner', 'gesamtsaldo','inkassostatus_id','stichtag','vermerk'
UNION
SELECT k.kdnr, k.nachname, s.kto_kenner, k.kenner,
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ','),
s.inkassostatus_id, s.stichtag,''
FROM kunde k
join stammdaten s on s.id = k.id
where s.kto_kenner like '%SZ%'
and IFNULL(s.gesamtsaldo,0) > 10
and IFNULL(s.inkassostatus_id,0) not between 03 and 89
and s.stichtag between adddate(curdate(),interval 22 day) and adddate(curdate(),interval 30 day)
union
SELECT k.kdnr, k.nachname, s.kto_kenner, k.kenner,
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ','),
s.inkassostatus_id, s.stichtag,''
FROM kunde k
join stammdaten s on s.id = k.id
where k.kenner like '%XX%'
and IFNULL(s.gesamtsaldo,0) > 10
and IFNULL(s.inkassostatus_id,0) not between 03 and 89
and s.stichtag between adddate(curdate(),interval 22 day) and adddate(curdate(),interval 30 day)
";
//
$filename = "files/Konten_XX_SZ_".date("YmdHis").".csv";
$fp = fopen($filename, 'w');
$start = date("d.m.Y H:i:s");
// �berschriftszeile
$string ="Start;".$start.";;;;;;;;;;;;;;;;;;;"."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
//$string ='Mandant;markt;kdnr;buchungsdatum;valutadatum;ba;bg;betrag;mwst_key;mwst_proz;mwst20;mwst_0;mwst_10;buchungskennzeichen;kz_berechnung;lastschrift;gutschrift;text;herkunft;geaendert_von;'."\n"; 
//fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['kdnr'].";".$line['nachname'].";".$line['kto_kenner'].";".$line['kenner'].";".$line['gesamtsaldo'].";".$line['inkassostatus_id'].";".$line['stichtag'].";".$line['vermerk'].";"."\n"; 
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
echo "<br>XX und SZ Kenner - Ende: ".$heute;

?>

</body>    
</html>
