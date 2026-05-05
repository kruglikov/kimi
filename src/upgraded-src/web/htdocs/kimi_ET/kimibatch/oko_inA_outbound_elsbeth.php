<html>
  <head>
     <title>KIMI-Plus - OKO inA Outbound ELSBETH-Export</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO inA Outbound ELSBETH-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "OKO inA Outbound ELSBETH-Export - Start: ".$heute;


$query = "select 'kampagne_id','kampagne','kontaktid','ticketnr','kontaktliste_id','kontaktliste','anrede','titel','nachname','vorname','plz','land_id','land','ort','strasse_hnr',
'telefon1','telefon2','email','beginn','kimi_task','kimi_memo','kimi_link','aktnr','glaeubiger','geburtsdatum','Kontaktgruppe Schluessel','exportdatum' from dual



union
select 
t.mandant_id kampagne_id,
m.text kampagne,
t.id kontaktid,
t.ticketnr ,
prioritaet_id kontaktliste_id ,
prioritaet.text kontaktliste,
t.anrede,
t.titel,
t.nachname,
t.vorname,
t.plz, 
t.land_id,
'A' land,
t.ort,
t.strasse strasse_hnr,
-- concat('0043-',replace(t.telefon,' ','')) telefon , -- 21.21.2021
  case when t.telefon != '' then concat('0043-',replace(t.telefon,' ','')) else '' end telefon , -- 21.21.2021
 --  concat('0043-',replace(t.telefon2,' ','')) telefon2, -- 21.21.2021
  case when t.telefon2 != '' then concat('0043-',replace(t.telefon2,' ','')) else '' end telefon2, -- 21.21.2021  
 -- (case when ifnull(t.telefon,'') = '' then '' else concat('X11920043',replace(ifnull(TRIM(LEADING '0' FROM t.telefon) ,''),' ','')) end) telefon1  ,
 -- (case when ifnull(t.telefon2,'') = '' then '' else concat('X11920043',replace(ifnull(TRIM(LEADING '0' FROM t.telefon2),''),' ','')) end) telefon2,
 -- (case when ifnull(t.telefon,'') = '' then '' else concat('10910043',replace(ifnull(TRIM(LEADING '0' FROM '0676845222500') ,''),' ','')) end) telefon1  ,
 -- (case when ifnull(t.telefon2,'') = '' then '' else concat('10910043',replace(ifnull(TRIM(LEADING '0' FROM '0676845222555'),''),' ','')) end) telefon2,
t.email,
beginn,
REPLACE( beschreibung_detail, CHAR(13,10), '|' ) kimi_task ,
REPLACE( ergebnis, CHAR(13,10), '|' ) kimi_memo ,
 
 concat('http://10.20.12.14/kimi/kimi_ET/index.php?autologin=true&loginuser=elsbeth&mandant=',
t.mandant_id,'&kId=',
t.kampagne_id,
'&ticket_id=',
t.id,'&site=ticket&selected_tickets=',
t.id,'&selected_ticket_index=0&noHeader=true&telefonStarten=A') link,
dummy_text9   aktnr, 
dummy_text3 glaeubiger,
t.geburtsdatum,
concat(ifnull(t.nachname,''),ifnull(t.vorname,''),ifnull(t.geburtsdatum,''),curdate()) kontaktgruppeschluessel ,
      now()  export

from ticket t
left outer join mandant m on m.id = t.mandant_id
left outer join kampagne k on k.id = t.kampagne_id
left outer join anruf_status asta on asta.id = t.anruf_status_id
left outer join status s on s.id = t.status_id
		left outer join prioritaet prioritaet on prioritaet.id = t.prioritaet_id
		left outer join benutzer on benutzer.id = t.benutzer_id
		left outer join grund on grund.id = t.grund_id
		left outer join firma on firma.id = t.firma_id
		left outer join produkt on produkt.id = t.produkt_id
		left outer join janein janein1 on janein1.id = t.textant11_janein_id
		left outer join janein janein2 on janein2.id = t.textant21_janein_id
		left outer join janein janein3 on janein3.id = t.textant31_janein_id
		left outer join janein janein4 on janein4.id = t.textant41_janein_id
		left outer join nummern nummern1 on nummern1.id = t.textant12_nummern_id
		left outer join nummern nummern2 on nummern2.id = t.textant22_nummern_id
        left outer join benutzer b on b.id = t.benutzer_id

	where 
--   (beginn >= '2020-04-01') and t.mandant_id in ( 32)  and prioritaet_id in (194) and asta.text !='in Recherche' -- and t.ticketnr in (247033,108118,38662)
  --   (beginn >= '2021-05-01') and t.mandant_id in ( 24) -- INKODE
  t.mandant_id in ( 16) and (t.status_id in (5800) OR (t.status_id in (57) and t.anruf_status_id in (193,194,195,196,203) ) ) -- and benutzer_id = 1
";

$filename = "files/OKO_inA_OUTBOUND_ELSBETHexp".date("Ymdm").".csv";
$fp = fopen($filename, 'w');

// Ueberschriftszeile _ KOMMT UEBER SELECT
/*
$string ='IndexA;IndexB;IndexC;Name;Vorname;Strasse;Plz;Ort;TelNr;TelNr2;E-Mail;GebDatum;Saldo;IBAN;BIC;Gl.Name;Gl.Ort;Bemerkung;VerzZinsen;Inko-Sb-Name;Inko-Sb-Mail;Inko-Sb-TelNr;CONNECT;RPC;PTP;'; 
$string = $string.'Inko-Aktion;AdressNr;Anmerkung;Gespraechsdatum;Gespraechszeit;Fehlerstatus;AgentenAnrede;AgentenVorname;AgentenNachname;';
$string = $string.'Kontakttel_vw;kontkattel_hw;Email_neu;name_neu;vorname_neu;plz_neu;ort_neu;strasse_neu;';
$string = $string.'neuetel_vw1;neuetel_hw1;neuetel_vw2;neuetel_hw2;telefon1falsch;telefon2falsch;gebdatum_neu'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
*/
$result = mysqli_query($dbconn, $query);
// 
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) { 
        //fputcsv($fp, array_keys($line));
		/*
        $string = $line['IndexA'].";".$line['IndexB'].";".$line['IndexC'].";".$line['Name'].";".$line['Vorname'].";".$line['Strasse'].";".$line['Plz'].";".$line['Ort'].";".$line['TelNr'].";"; 
		$string = $string.$line['TelNr2'].";".$line['TelNr-Apl'].";".$line['Arb.Platz'].";".$line['E-Mail'].";".$line['GebDatum'].";".$line['Saldo'].";".$line['IBAN'].";".$line['BIC'].";".$line['Gl.Name'].";".$line['Gl.Ort'].";"; 
		$string = $string.$line['Bemerkung'].";".$line['Verzzinsen'].";".$line['Inko-Sb-Name'].";".$line['Inko-Sb-Mail'].";".$line['Inko-Sb-TelNr'].";".$line['CONNECT'].";".$line['RPC'].";".$line['PTP'].";"; 		
		$string = $string.$line['Inko-Aktion'].";".$line['AdressNr'].";".$line['Anmerkung'].";".$line['Gespraechsdatum'].";".$line['Gespraechszeit'].";".$line['Fehlerstatus'].";".$line['AgentenAnrede'].";".$line['AgentenVorname'].";".$line['AgentenNachname'].";"; 				
		$string = $string.$line['kontakttel_vw'].";".$line['kontkattel_hw'].";".$line['Email_neu'].";".$line['name_neu'].";".$line['vorname_neu'].";".$line['plz_neu'].";".$line['ort_neu'].";".$line['strasse_neu'].";"; 				
		$string = $string.$line['neuetel_vw1'].";".$line['neuetel_hw1'].";".$line['neuetel_vw2'].";".$line['neuetel_hw2'].";".$line['telefon1falsch'].";".$line['telefon2falsch'].";".$line['gebdatum_neu'].";";  				
		$string = $string.$line['neuetel_vwa'].";".$line['neuetel_hwa'].";".$line['telefon_apl_falsch']; 						
		$string = $string.";"."\n"; 
        */
		//2020-06-02
			$string = $line['kampagne_id'].";".$line['kampagne'].";".$line['kontaktid'].";"; 
			$string = $string.$line['ticketnr'].";".$line['kontaktliste_id'].";".$line['kontaktliste'].";"; 		
			$string = $string.$line['anrede'].";".$line['titel'].";".$line['nachname'].";".$line['vorname'].";".$line['plz'].";".$line['land_id'].";".$line['land'].";".$line['ort'].";".$line['strasse_hnr'].";"; 				
			$string = $string.$line['telefon1'].";".$line['telefon2'].";".$line['email'].";".$line['beginn'].";".$line['kimi_task'].";".$line['kimi_memo'].";".$line['kimi_link'].";".$line['aktnr'].";"; 				
			$string = $string.$line['glaeubiger'].";".$line['geburtsdatum'].";".$line['Kontaktgruppe Schluessel'].";".$line['exportdatum'].";";  				
			$string = $string.$line['neuetel_vwa'].";".$line['neuetel_hwa'].";".$line['telefon_apl_falsch']; 						
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
echo "<br><br>"."OKO inA Outbound ELSBETH-Export - Ende: ".$heute;

?>
</body>    
</html>
