<html>
  <head>
     <title>KIMI-Plus - Endkapitalisierung Guthabenkonten</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Endkapitalisierung Guthabenkonten</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Endkapitalisierung Guthabenkonten - Start: ".$heute;
// Abfrage 
$query = "SELECT 'id' , 'stichtag', 'ratenhoehe', 'gesamtsaldo', 'dat_l_zahlung', 'betrag_l_zahlung','vermerk'
UNION
SELECT s.id, s.stichtag, 
REPLACE(CAST(IFNULL(s.ratenhoehe,0) AS CHAR), '.', ','),
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ','),
 s.dat_l_zahlung, 
REPLACE(CAST(IFNULL(s.betrag_l_zahlung,0) AS CHAR), '.', ','),
''
FROM stammdaten s
join kundenhistorie kh on kh.kdnr_id = s.id
where s.dat_l_zahlung between adddate(curdate(),interval -35 day) and curdate()
and s.gesamtsaldo < 0
and IFNULL(s.inkassostatus_id,0) not between 03 and 89
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
and s.id not in (SELECT s.id
FROM stammdaten s
join kundenhistorie kh on kh.kdnr_id = s.id
where kh.text like '%Endkapitalisierung%')
group by s.id
";
//
$filename = "files/Endkapitalisierung_GH_".date("YmdHis").".csv";
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
        $string = $line['id'].";".$line['stichtag'].";".$line['ratenhoehe'].";".$line['gesamtsaldo'].";".$line['dat_l_zahlung'].";".$line['betrag_l_zahlung'].";".$line['vermerk'].";"."\n"; 
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
echo "<br>Endkapitalisierung Guthabenkonten - Ende: ".$heute;

?>

</body>    
</html>
