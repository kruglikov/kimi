<html>
  <head>
     <title>KIMI-Plus - Kundenhistorie Vorlagen</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Kundenhistorie Vorlagen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Kundenhistorie Vorlagen - Start: ".$heute;
// Abfrage Kontoauszugsdaten
$query = "select k.mandant_id mandant, k.kdnr,k.nachname,k.vorname,k.ort,k.plz,h.text,h.geaendert_am,b.name benutzer from kundenhistorie h
join stammdaten s on s.id = h.kdnr_id
join kunde k on k.id = s.id
join benutzer b on b.id = h.benutzer_id2
where UPPER(h.text) like '%VORLAGE%'
and h.geaendert_am >= str_to_date('31.12.2013','%d.%m.%Y')
order by h.geaendert_am desc
";

$filename = "files/kundenhistorievorlage".date("YmdHi").".csv";
$fp = fopen($filename, 'w');
// �berschriftszeile
$string ='Mandant;kdnr;nachname;vorname;ort;plz;text;geaendert_am;benutzer;'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['mandant'].";".$line['kdnr'].";".$line['nachname'].";".$line['vorname'].";".$line['ort'].";".$line['plz'].";".$line['text'].";".$line['geaendert_am'].";".$line['benutzer'].";"."\n"; 
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
mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Kundenhistorie Vorlagen	- Ende: ".$heute;

?>

</body>    
</html>
