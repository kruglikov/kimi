<html>
  <head>
     <title>KIMI-Plus - Inkassovorschlagsliste Liste</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Inkassovorschlagsliste Liste</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Inkassovorschlagsliste Liste - Start: ".$heute;

$query = "select DISTINCT
DATE_FORMAT(s.stichtag, '%Y-%c-%d') stichtag,
s.ktonr kundennummer,
k.nachname,
k.vorname,
s.mahnstufe,
s.inkassostatus_id,
inks.text,
i.status_dat,
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ',') gesamtsaldo ,
(select REPLACE(CAST(sum(IFNULL(sk.m3,0)) AS CHAR), '.', ',') from subkonto_neu sk where kz_aktuell = 'J' and sk.stammdaten_id = s.id
group by sk.stammdaten_id ) sum_m3,
(select REPLACE(CAST(sum(IFNULL(sk.m2,0)) AS CHAR), '.', ',') from subkonto_neu sk where kz_aktuell = 'J' and sk.stammdaten_id = s.id
group by sk.stammdaten_id ) sum_m2,
(select REPLACE(CAST(sum(IFNULL(sk.m1,0)) AS CHAR), '.', ',') from subkonto_neu sk where kz_aktuell = 'J' and sk.stammdaten_id = s.id
group by sk.stammdaten_id ) sum_m1,
(select REPLACE(CAST(sum(IFNULL(sk.m0,0)) AS CHAR), '.', ',') from subkonto_neu sk where kz_aktuell = 'J' and sk.stammdaten_id = s.id
group by sk.stammdaten_id ) sum_m0,
REPLACE(CAST(IFNULL(s.ratenhoehe,0) AS CHAR), '.', ',') ratenhoehe ,
DATE_FORMAT(s.dat_l_zahlung, '%Y-%c-%d') dat_l_zahlung,
REPLACE(CAST(IFNULL(s.betrag_l_zahlung,0) AS CHAR), '.', ',') betrag_l_zahlung,
DATE_FORMAT(s.dat_l_kontoauszug, '%Y-%c-%d') dat_l_kontoauszug,
REPLACE(CAST(IFNULL(s.betrag_l_kontoauszug,0) AS CHAR), '.', ',') betrag_l_kontoauszug
from stammdaten s
join kunde k on k.id = s.kunde_id
left outer join inkassoinformation i on 
i.status_dat = s.status_dat and i.inkassostatus_id = s.inkassostatus_id and i.ra_ikbuero_id = s.ra_ikbuero_id
left outer join inkassostatus inks on inks.id = s.inkassostatus_id
where 
 IFNULL(i.inkassostatus_id,0) between 01 and 02 
order by s.ktonr
";

$filename = "files/inkassovorschlagsliste".date("YmdHi").".csv";
$fp = fopen($filename, 'w');
// �berschriftszeile
$string = 'stichtag;kundennummer;nachname;vorname;mahnstufe;inkassostatus_id;text;status_dat;gesamtsaldo;sum_m3;sum_m2;sum_m1;sum_m0;ratenhoehe;dat_l_zahlung;betrag_l_zahlung;dat_l_kontoauszug;betrag_l_kontoauszug'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['stichtag'].';'.$line['kundennummer'].';'.$line['nachname'].';'.$line['vorname'].';'.$line['mahnstufe'].';'.$line['inkassostatus_id'].';'.$line['text'].';'.$line['status_dat'].';'.$line['gesamtsaldo'].';'.$line['sum_m3'].';'.$line['sum_m2'].';'.$line['sum_m1'].';'.$line['sum_m0'].';'.$line['ratenhoehe'].';'.$line['dat_l_zahlung'].';'.$line['betrag_l_zahlung'].';'.$line['dat_l_kontoauszug'].';'.$line['betrag_l_kontoauszug']."\n"; 
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
echo "<br><br>"."Inkassovorschlagsliste Liste - Ende: ".$heute;

?>
</body>    
</html>
