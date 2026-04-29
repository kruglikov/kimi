<html>
  <head>
     <title>KIMI-Plus - INKO SEPADATEN-REPORT V 1 20220528</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO SEPADATEN-Report</h1>
<?PHP 


// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INFOSCORE-Report - Start: ".$heute;


$query = "select
'projekt','id',	'email', 'anrede', 'name','index','indexauf','name2','adresse','rate','datum','benutzer','erstellt_am','sepa','anrede','loesungsvorschlag','ergebnis'
from dual
union 
select 'INKO2016',ticketnr,kimi_decrypt(ticket.email),'Anrede',CONCAT(TRIM(kimi_decrypt(ticket.vorname)),' ',TRIM(kimi_decrypt(ticket.nachname))) name,dummy_text9,
concat('x',LPAD(truncate(dummy_number1,0), 5, '0'),' ',LPAD(truncate(dummy_number2,0), 10, '0'),' ',LPAD(truncate(dummy_number3,0), 4, '0')) inkassonummer,
concat(TRIM(ticket.vorname),' ',TRIM(ticket.nachname)) NameZahlungspf,
concat(plz,' ',TRIM(Ort),', ',TRIM(strasse)) anschrift ,
REPLACE(FORMAT(dummy_number6, 0),',','') rate,

CASE
    WHEN grund.text = '1ter aktuelles Monat' THEN concat('01.',MONTH(ticket.geaendert_am),'.',YEAR(ticket.geaendert_am ) )
    WHEN grund.text = '15ter aktuelles Monat' THEN concat('15.',MONTH(ticket.geaendert_am),'.',YEAR(ticket.geaendert_am ) )
    WHEN grund.text = '8ter aktuelles Monat' THEN concat('8.',MONTH(ticket.geaendert_am),'.',YEAR(ticket.geaendert_am ) )	
    WHEN grund.text = '1ter Folgemonat' THEN concat('01.',MONTH(ticket.geaendert_am)+1,'.',YEAR(ticket.geaendert_am ) )
    WHEN grund.text = '15ter Folgemonat' THEN concat('15.',MONTH(ticket.geaendert_am)+1,'.',YEAR(ticket.geaendert_am ) )
    WHEN grund.text = '8ter Folgemonat' THEN concat('8.',MONTH(ticket.geaendert_am)+1,'.',YEAR(ticket.geaendert_am ) )	
    ELSE '00.00.0000'
END,
benutzer.nachname,
DATE_FORMAT(ticket.geaendert_am, '%Y.%m.%d'),
produkt.text,
dummy_id_referenz.text,
nummern2.text loesungsvorschlag,
REPLACE( ergebnis, CHAR(13,10), ' ' ) ergebnis


from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
		left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join produkt on produkt.id = ticket.produkt_id    
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id2    
		left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id  
where ticket.mandant_id = 18 
 and ticket.status_id = 69 -- GEMELDET
 and ticket.anruf_status_id = 236 -- GEMELDET ERREICHT
 and ticket.geaendert_am >= '2022-05-01'
 

 
 union
-- INDKO DE 

select 'INKODE',ticketnr,kimi_decrypt(ticket.email),'Anrede',CONCAT(TRIM(kimi_decrypt(ticket.vorname)),' ',TRIM(kimi_decrypt(ticket.nachname))) name,dummy_text9,
concat('x',LPAD(truncate(dummy_number1,0), 5, '0'),' ',LPAD(truncate(dummy_number2,0), 10, '0'),' ',LPAD(truncate(dummy_number3,0), 4, '0')) inkassonummer,
concat(TRIM(ticket.vorname),' ',TRIM(ticket.nachname)) NameZahlungspf,
concat(plz,' ',TRIM(Ort),', ',TRIM(strasse)) anschrift ,
REPLACE(FORMAT(dummy_number6, 0),',','') rate,

CASE
    WHEN grund.text = '1ter aktuelles Monat' THEN concat('01.',MONTH(ticket.geaendert_am),'.',YEAR(ticket.geaendert_am ) )
    WHEN grund.text = '15ter aktuelles Monat' THEN concat('15.',MONTH(ticket.geaendert_am),'.',YEAR(ticket.geaendert_am ) )
    WHEN grund.text = '8ter aktuelles Monat' THEN concat('8.',MONTH(ticket.geaendert_am),'.',YEAR(ticket.geaendert_am ) )	
    WHEN grund.text = '1ter Folgemonat' THEN concat('01.',MONTH(ticket.geaendert_am)+1,'.',YEAR(ticket.geaendert_am ) )
    WHEN grund.text = '15ter Folgemonat' THEN concat('15.',MONTH(ticket.geaendert_am)+1,'.',YEAR(ticket.geaendert_am ) )
    WHEN grund.text = '8ter Folgemonat' THEN concat('8.',MONTH(ticket.geaendert_am)+1,'.',YEAR(ticket.geaendert_am ) )	
    ELSE '00.00.0000'
END,
benutzer.nachname,
DATE_FORMAT(ticket.geaendert_am, '%Y.%m.%d'),
produkt.text,
dummy_id_referenz.text,
nummern2.text loesungsvorschlag,
REPLACE( ergebnis, CHAR(13,10), ' ' ) ergebnis


from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
        left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join produkt on produkt.id = ticket.produkt_id    
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id2    
		left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id  
where ticket.mandant_id = 24 
 and ticket.status_id = 102 -- GEMELDET 
 and ticket.anruf_status_id = 335 -- GEMELDET ERREICHT
 and ticket.geaendert_am >= '2022-05-01'



";

$filename = "files/".date("YmdHi")."_INKO_SEPA_ReportDaten".".csv";
$fp = fopen($filename, 'w');


$result = mysqli_query($dbconn, $query);
// 
while ($line =dbFetchArray($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['projekt'].";".$line['id'].";".$line['email'].";".$line['anrede'].";".$line['name'].";".$line['index'].";".$line['indexauf'].";".$line['name2'].";".$lin1e['adresse1'].";".$line['rate'].";".$line['datum'].";".$line['benutzer'].";".$line['erstellt_am'].";".$line['sepa'].";".$line['anrede'].";".$line['loesungsvorschlag'].";".$line['ergebnis'];  
		$string = $string."\n"; 
        //echo $string;
        // being transformed into a newline
		
		//20220528/TF Konvertierung auf ANSI
		$string = iconv("UTF-8", "WINDOWS-1252", $string);
	
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
echo "<br><br>"."INKO SEPADATEN-Report- Ende: ".$heute;

dbClose($dbconn);

?>
</body>    
</html>
