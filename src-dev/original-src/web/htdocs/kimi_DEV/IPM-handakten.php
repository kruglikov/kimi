<html>
<head>
<title> KIMI-PLUS - IPM-Handakten - EXPORT  </title>
</head>
<body>
<h1> KIMI-PLUS - IPM-Handakten - EXPORT </h1>


<?php 
include 'db.php';
$heute = date("d-m-Y H:i:s");

echo "KIMI-PLUS - IPM-Handakten - EXPORT - START:". $heute;

$query = "select  
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
$result = mysql_query($query);

if (!$result) {
    die('Invalid query: ' . mysql_error());
}
//$output = mysql_fetch_array($result);

echo '<br>anfang';

while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['IndexA'].";".$line['IndexB'].";".$line['IndexC'].";".$line['Name'].";".$line['Vorname'].";".$line['Strasse'].";".$line['Plz'].";".$line['Ort'].";".$line['TelNr'].";"; 
		$string = $string.$line['TelNr2'].";".$line['E-Mail'].";".$line['GebDatum'].";".$line['Saldo'].";".$line['IBAN'].";".$line['BIC'].";".$line['Gl.Name'].";".$line['Gl.Ort'].";"; 
		$string = $string.$line['Bemerkung'].";".$line['Verzzinsen'].";".$line['Inko-Sb-Name'].";".$line['Inko-Sb-Mail'].";".$line['Inko-Sb-TelNr'].";".$line['CONNECT'].";".$line['RPC'].";".$line['PTP'].";"; 		
		$string = $string.$line['Inko-Aktion'].";".$line['AdressNr'].";".$line['Anmerkung'].";".$line['Gespraechsdatum'].";".$line['Gespraechszeit'].";".$line['Fehlerstatus'].";".$line['AgentenAnrede'].";".$line['AgentenVorname'].";".$line['AgentenNachname'].";"; 				
		$string = $string.$line['kontakttel_vw'].";".$line['kontkattel_hw'].";".$line['Email_neu'].";".$line['name_neu'].";".$line['vorname_neu'].";".$line['plz_neu'].";".$line['ort_neu'].";".$line['strasse_neu'].";"; 				
		$string = $string.$line['neuetel_vw1'].";".$line['neuetel_hw1'].";".$line['neuetel_vw2'].";".$line['neuetel_hw2'].";".$line['telefon1falsch'].";".$line['telefon2falsch'].";".$line['gebdatum_neu']; 				
		$string = $string.";"."\n"; 
		//
		echo '<br>lesen';
		echo '<br>Ausgabe'.$line['kundennummer'].";";
        //echo $string;
        // being transformed into a newline
       // fwrite($fp, $string); // will proccess /n as newline ... 	
	
}
echo '<br>ende';
?>
</body>
</html>