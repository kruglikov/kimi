<html>
<head>
<title> KIMI-PLUS - IPM-Handakten - EXPORT  </title>
</head>
<body>
<h1> KIMI-PLUS - IPM-Handakten - EXPORT </h1>

<?php

$dbname="kimi_ET";

$dbhost="10.70.83.100";

$dbuser="kimi";

$dbpass="KimiPlus@13";

mysql_connect($dbhost,$dbuser,$dbpass);

mysql_select_db($dbname);
?>
<?php
if (!myconn) { die ("keine verbindung zur Datenbank");}
else
{ die ("hello ");}
	
 $query =  "select  
'klient',
'aktenbezeichnung',
'kundennummer',
'anrede' ,
'familienname',
'vorname',
'Geburtsdatum' ,
'firmenbuchnummer',
'strasse_und_hausnummer',
'laenderkennzeichen',
'plz',
'ort',
'kommunikation',
'forderungsgrund01',
'forderungsgrund12',
'restl_hauptforderung',
'zinssatz_kapital',
'restl_nebenforderung',
'abrechnungsstichtag',
'kap_zinsen_bis_stichtag',
'rest_ra_honorar',
'restl_barauslagen',
'titel_gericht',
'titel_vom',
'titel_geschaeftszahl',
'letztes_exekutionsgericht',
'exekution_geschaeftszahl',
'kimi_info'
from dual
UNION 
select  
'IPM' klient,
'Quelle-Handakten'     aktenbezeichnung,
kunde_kdnr kundennummer,
kunde_anrede_text anrede ,
kunde_nachname familienname,
kunde_vorname vorname,
kunde_geburtsdatum Geburtsdatum ,
akt_su_firmenbuchnummer firmenbuchnummer,
akt_su_strhnr strasse_und_hausnummer,
'A' laenderkennzeichen,
akt_su_plz plz,
akt_su_ort ort,
null kommunikation,
akt_forderungsgrund01 forderungsgrund01,
akt_forderungsgrund01 forderungsgrund12,
REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_restl_hauptforderung,0) / 13.7603 ELSE IFNULL(akt_restl_hauptforderung,0) END
, 2),',',''),'.',',') restl_hauptforderung,
akt_zinssatz_kapital zinssatz_kapital,
REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_restl_nebenforderung,0) / 13.7603 ELSE IFNULL(akt_restl_nebenforderung,0) END
, 2),',',''),'.',',')  restl_nebenforderung,
curdate()  abrechnungsstichtag,
REPLACE(REPLACE(FORMAT(
case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_kap_zinsen_bis_stichtag,0) / 13.7603 ELSE IFNULL(akt_kap_zinsen_bis_stichtag,0) END
, 2),',',''),'.',',')  kap_zinsen_bis_stichtag,

REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_rest_ra_honorar,0) / 13.7603 ELSE IFNULL(akt_rest_ra_honorar,0) END
, 2),',',''),'.',',') rest_ra_honorar,

REPLACE(REPLACE(FORMAT(

case akt_waehrung WHEN 'ATS' THEN IFNULL(akt_restl_barauslagen ,0) / 13.7603 ELSE IFNULL(akt_restl_barauslagen ,0) END
, 2),',',''),'.',',') restl_barauslagen,
akt_titel_gericht titel_gericht,
akt_titel_datum titel_vom,
akt_titel_geschaeftszahl titel_geschaeftszahl,
akt_letztes_exekutionsgericht letztes_exekutionsgericht,
akt_exekution_geschaeftszahl exekution_geschaeftszahl,
REPLACE( 

CASE
  WHEN kunde_nachname != akt_su_nachname or
       kunde_vorname !=  akt_su_vorname or
       kunde_plz != akt_su_plz or
       kunde_ort != akt_su_ort or
       concat(kunde_strasse ,' ',kunde_hausnummer , ' ' , kunde_hausnummer_erw) != akt_su_strhnr or
       kunde_geburtsdatum != akt_su_gebdatum
  THEN CONCAT (' / QuelleDaten: ',
               kunde_vorname, 
               kunde_nachname, 
               kunde_strasse, ' ', 
               kunde_hausnummer, 
               kunde_hausnummer_erw, ' ',
               kunde_plz,' ',
               kunde_ort)
  ELSE akt_hinweise
END

, CHAR(13,10), ' ' ) kimi_info


from ticket
left outer join akt
ON  akt.ticket_id = ticket.id 
 
where ticket.mandant_id = 1

";
$filename = "nfile.txt"
$fp = $fopen($filename, 'w');


	
} 
//$output = mysql_fetch_array($result);



while ($line = mysql_fetch_array($result)) { 
       
 $string = $line['klient'].";".$line['aktenbezeichnung'].";".$line['kundennummer'].";".$line['anrede'].";".$line['familienname'].";".$line['vorname'].";".$line['Geburtsdatum'].";".$line['firmenbuchnummer'].";".$line['strasse_und_hausnummer'].";"; 
		$string = $string.$line['laenderkennzeichen'].";".$line['plz'].";".$line['ort'].";".$line['kommunikation'].";".$line['forderungsgrund01'].";".$line['forderungsgrund12'].";".$line['restl_hauptforderung'].";".$line['abrechnungsstichtag'].";"; 
		$string = $string.$line['kap_zinsen_bis_stichtag'].";".$line['rest_ra_honorar'].";".$line['restl_barauslagen'].";".$line['titel_gericht'].";".$line['titel_vom'].";".$line['titel_geschaeftszahl'].";".$line['letztes_exekutionsgericht'].";".$line['exekution_geschaeftszahl'].";"; 		
		$string = $string.$line['kimi_info']; 				
		$string = $string.";"."\n"; 
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

echo "<br>File Download zum Dowload bereit <br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."INKO2016-Export - Ende: ".$heute;

	 


?> 
</body>    
</html>
