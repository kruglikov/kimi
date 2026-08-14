<html>
  <head>
     <title>KIMI-Plus - InkassoRechnungsnummer</title>
  </head>
  <body>
  <h1>KIMI-Plus -  InkassoRechnungsnummer</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "InkassoRechnungsnummer - Start: ".$heute;

$query = "SELECT 
s.ktonr kundennummer,
b.auftragsnummer rechnungsnummer,
DATE_FORMAT(b.valutadatum, '%Y-%c-%d') belegdatum,
bua.buart_key buchungsart,
/*substring(cast(bugr.bugru_key as CHAR) FROM -4 FOR 2) ba,*/
substring(cast(bugr.bugru_key as CHAR) FROM -2 FOR 2) buchungsgrund,
b.buchungskennzeichen
from buchungen b
join bua_bgr_man buabgr on  buabgr.id = b.bua_bgr_man_id
join buchungsgrund bugr on bugr.id = buabgr.bugru_id
join buchungsart bua on bua.id = bugr.buchungsart_id
join stammdaten s on s.id = b.stammdaten_id
left outer join inkassoinformation i on i.kunde_id = s.kunde_id 
and i.status_dat = s.status_dat and i.inkassostatus_id = s.inkassostatus_id and i.ra_ikbuero_id = s.ra_ikbuero_id
left outer join ra_ikbuero ra on ra.id = s.ra_ikbuero_id
/* where s.ktonr in (select * from inkasso_kdnr) */
where s.ktonr in (SELECT ktonr FROM saldoaufstellung)
and bua.buart_key = 01
";

$filename = "files/inkassorechnungsnummern.csv";
$fp = fopen($filename, 'w');
// �berschriftszeile

$string = 'kundennummer;rechnungsnummer;belegdatum;buchungsart;buchungsgrund;buchungskennzeichen;'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['kundennummer'].';'.$line['rechnungsnummer'].';'.$line['belegdatum'].';'.$line['buchungsart'].';'.$line['buchungsgrund'].';'.$line['buchungskennzeichen']."\n"; 
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
echo "<br><br>"."InkassoRechnungsnummer - Ende: ".$heute;

?>
</body>    
</html>
