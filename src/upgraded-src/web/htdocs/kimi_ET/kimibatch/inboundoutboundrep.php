<html>
  <head>
     <title>KIMI-Plus - INBOUND OUTBOUND REPORT V 1 20220528</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INBOUND OUTBOUND REPORT</h1>
<?PHP 


// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INBOUND OUTBOUND REPORT - Start: ".$heute;


$query = "select
'projekt','id',	'benutzer','datum','inbound_outbound'
from dual
union 
select 'INKO2016',ticketnr,
benutzer.nachname,
DATE_FORMAT(ticket.geaendert_am, '%Y.%m.%d'),
dummy_id_referenz.text


from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
		left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join produkt on produkt.id = ticket.produkt_id    
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id1    
where ticket.mandant_id = 18 
 and ticket.status_id = 69 -- GEMELDET
 and ticket.anruf_status_id = 236 -- GEMELDET ERREICHT
 and ticket.geaendert_am >= '2022-05-01'
 
 
 union
-- INDKO DE 

select 'INKODE',ticketnr,
benutzer.nachname,
DATE_FORMAT(ticket.geaendert_am, '%Y.%m.%d'),
dummy_id_referenz.text

from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
        left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join produkt on produkt.id = ticket.produkt_id    
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id1                
where ticket.mandant_id = 24 
 and ticket.status_id = 102 -- GEMELDET 
 and ticket.anruf_status_id = 335 -- GEMELDET ERREICHT
 and ticket.geaendert_am >= '2022-05-01'

 union
-- OKO 

select 'OKO',ticketnr,
benutzer.nachname,
DATE_FORMAT(ticket.geaendert_am, '%Y.%m.%d'),
dummy_id_referenz.text


from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
        left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join produkt on produkt.id = ticket.produkt_id    
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id1                
where ticket.mandant_id = 16 
 and ticket.status_id = 56  -- GEMELDET 
 and ticket.anruf_status_id = 199 -- GEMELDET ERREICHT
 and ticket.geaendert_am >= '2022-05-01'

 union
-- SCHLAUSTROM 

select 'SCHLAUSTROM',ticketnr,
benutzer.nachname,
DATE_FORMAT(ticket.geaendert_am, '%Y.%m.%d'),
dummy_id_referenz.text


from ticket 
		left outer join grund on grund.id = ticket.grund_id
		left outer join firma on firma.id = ticket.firma_id
        left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join produkt on produkt.id = ticket.produkt_id    
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id1                
where ticket.mandant_id = 16 
 and ticket.status_id = 118  -- GEMELDET 
 and ticket.anruf_status_id = 375 -- GEMELDET ERREICHT
 and ticket.geaendert_am >= '2022-05-01'
 

 union
-- COEO

select 'COEO',ticketnr,
benutzer.nachname,
DATE_FORMAT(ticket.geaendert_am, '%Y.%m.%d'),
dummy_id_referenz.text


from ticket 
        left outer join benutzer on benutzer.id = ticket.benutzer_id
        left outer join dummy_id_referenz on dummy_id_referenz.id = ticket.dummy_id1                
where ticket.mandant_id = 40 
 and ticket.status_id = 188  -- GEMELDET 
 and ticket.anruf_status_id = 540 -- GEMELDET ERREICHT
 and ticket.geaendert_am >= '2022-05-01' 
";

$filename = "files/".date("YmdHi")."_INBOUND_OUTBOUND_ReportDaten".".csv";
$fp = fopen($filename, 'w');


$result = mysqli_query($dbconn, $query);
// 
echo "<br>INBOUND OUTBOUND REPORT - Start2: ".$heute;
while ($line = dbFetchArray($result)) { 
        //echo "<br>INBOUND OUTBOUND REPORT - Start3 - WHILE: ".$heute;
        //fputcsv($fp, array_keys($line));
        $string = $line['projekt'].";".$line['id'].";".$line['benutzer'].";".$line['datum'].";".$line['inbound_outbound']; 
		$string = $string."\n"; 
        //echo $string;
        // being transformed into a newline

		//20220528/TF Konvertierung auf ANSI
		$string = iconv("UTF-8", "WINDOWS-1252", $string);
		
        fwrite($fp, $string); // will proccess /n as newline ... 	
	
}
echo "<br>INBOUND OUTBOUND REPORT - Start4 - ENDE WHILE: ".$heute;

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
echo "<br><br>"."INBOUND OUTBOUND REPORT- Ende: ".$heute;

dbClose($dbconn);

?>
</body>    
</html>
