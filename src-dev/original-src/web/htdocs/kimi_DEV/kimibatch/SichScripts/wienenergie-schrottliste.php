  <head>
     <title>KIMI-PLUS - WIEN_ENERGIE_AKTE_SCHROTTLISTE : EXPORT</title>
  </head>
  <body>
  <h1>KIMI-PLUS - WIEN_ENERGIE_AKTE_SCHROTTLISTE : EXPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "KIMI-PLUS - WIEN_ENERGIE_AKTE_SCHROTTLISTE : EXPORT - Start: ".$heute;


$query = "select  
'klient',
'aktenbezeichnung',
'VK Nummer',
'Anrede' ,
'Kunde Nachname',
'Kunde Vorname',
'Erledigungsdatum' ,
'Aktnr',
'Bewertung',
'Erledigungsgrund',
'Ausbuchungsgrund',
'kimi-infox',
'kimi-info'
from dual
UNION
select  
'98' klient,
'Wien-Energie-Akten SCHROTT'     aktenbezeichnung,
kundennummer kundennummer,
akt_su_anrede anrede ,
akt_su_nachname familienname,
akt_su_vorname vorname,
curdate() erledigungsdatum ,
concat(kundennummer,'-',dummy_text9,'-',ticketnr) aktnr,
nummern2.text bewertung,
produkt.text erledigungsgrund,
grund.text ausbuchungsgrund,
replace(REPLACE( dummy_text10, CHAR(13,10), ' ' ),';',' ') info,
replace(
REPLACE( 

CASE
  WHEN kunde_nachname != akt_su_nachname or
       kunde_vorname !=  akt_su_vorname or
       kunde_plz != akt_su_plz or
       kunde_ort != akt_su_ort or
       concat(kunde_strasse ,' ',kunde_hausnummer , ' ' , kunde_hausnummer_erw) != akt_su_strhnr or
       kunde_geburtsdatum != akt_su_gebdatum
  THEN CONCAT (akt_hinweise,' / QuelleDaten: ',
               kunde_vorname, 
               kunde_nachname, 
               kunde_strasse, ' ', 
               kunde_hausnummer, 
               kunde_hausnummer_erw, ' ',
               kunde_plz,' ',
               kunde_ort)
  ELSE akt_hinweise
END

, CHAR(13,10), ' ' ),
';',' ')
kimi_info
from ticket 
left outer join akt ON  akt.ticket_id = ticket.id 
left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
left outer join grund on grund.id = ticket.grund_id
left outer join produkt on produkt.id = ticket.produkt_id

where akt.mandant_id = 29 and status_id in ( 132,133) and janein1.text = 'Schrott' -- Betreibung = Nein

";

$filename = "files/wienergie-akte-schrottliste".date("Ymdm").".csv";
$fp = fopen($filename, 'w');

$result = mysql_query($query);
// 
while ($line = mysql_fetch_array($result)) { 
        $string = $line['klient'].";".$line['aktenbezeichnung'].";".$line['VK Nummer'].";".$line['Anrede'].";".$line['Kunde Nachname'].";".$line['Kunde Vorname'].";".$line['Erledigungsdatum'].";".$line['Aktnr'].";".$line['Bewertung'].";"; 
// 		$string = $string.$line['Erledigungsgrund'].";".$line['Ausbuchungsgrund'].";".$line['kimi-info'].";".$line['kimi-info2']; 				
		$string = $string.$line['kimi-info']; 				
		$string = $string.";"."\n"; 
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
echo "<br><br>"."KIMI-PLUS - WIEN_ENERGIE_AKTE_SCHROTTISTE : EXPORT - Ende: ".$heute;

?>
</body>    
</html>
