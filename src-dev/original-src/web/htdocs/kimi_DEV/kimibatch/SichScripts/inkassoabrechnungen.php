<html>
  <head>
     <title>KIMI-Plus - Inkassoabrechnungen</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Inkassoabrechnungen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Inkassoabrechnungen - Start: ".$heute;

$lines = file('files/inkassoabrechnung.txt');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
}

echo "<br>Anzeige Importfile f&uuml;r Tabelle Inkassoabrechnungen: <br>";
//
$ueberschrift_buch = '<br>band;sa;kundennummer;ba;bg;belegdatum;betrag;ue_betrag;mahnspesen;barauslagen;leer;stornokennzeichen;kz_verarbeitet;geaendert_am;geaendert_von';
$ueberschrift_stati = '<br>band;sa;datum;kundennummer;ikstatus;erledigtstatus;forderungsverlust;kz_verarbeitet;geaendert_am;geaendert_von';
$sa = 0;
$geaendert_von = 'inkassobatch';
$geaendert_am = date('Y-m-d H:i:s');
$sum_betrag5130 = 0;
$sum_betrag5140 = 0;
$sum_betrag5150 = 0;
$sum_betrag11 = 0;
$sum_betrag12 = 0;
$count_sa5130 = 0;
$count_sa5140 = 0;
$count_sa11 = 0;
$count_sa12 = 0;

foreach ($lines as $line_num => $line) {
    if (substr($line, 0,2) == '10' ) { // Vorlaufsatz UI etc.
      $vorlaufsatz = $line;
    }    
    if (substr($line, 0,4) == '0000' ) { // Vorlaufsatz infoscore 
      $vorlaufsatz = $line;
    }    
    if (substr($line, 0,2) == '11' ) { // Buchungen UI etc.
      $buchung = substr($line, 0,2).';'.substr($line, 8,8).';'.substr($line, 16,2).';'.substr($line, 18,2).';20'.substr($line, 20,6).';'.substr($line, 26,7).'.'.substr($line, 33,2).';;;;;'.substr($line, 44,1).';;'.$geaendert_am.';'.$geaendert_von;
      $sum_betrag11= $sum_betrag11 + (substr($line,26,9)/100);      
      $count_sa11++;
    }    
    if (substr($line, 0,4) == '5130' ) { // Buchungen infoscore 
      $buchung = substr($line, 0,4).';'.substr($line, 9,14).';'.substr($line, 25,18).'.'.substr($line, 44,12).'.'.substr($line, 57,12).'.'.substr($line, 70,12).'.'.substr($line, 83,12).'.'.substr($line,96,4).';;'.$geaendert_am.';'.$geaendert_von;
      $sum_betrag5130= $sum_betrag5130 + ((substr($line,34,9).substr($line,44,2)) /100);
      $count_sa5130++;      
    }    
    if (substr($line, 0,2) == '12' ) { // Stati UI etc.
      $status = substr($line, 0,2).';;'.substr($line, 8,8).';'.substr($line, 16,2).';;;;;'.$geaendert_am.';'.$geaendert_von;;
      $count_sa12++;            
    }    
    if (substr($line, 0,4) == '5140' ) { // Stati infoscore 
      $status = substr($line, 0,4).';'.substr($line, 5,8).';'.substr($line, 18,16).';'.substr($line, 41,9).'.'.substr($line, 51,2).';;'.$geaendert_am.';'.$geaendert_von;
      $count_sa5140++;                  
    }    
    if (substr($line, 0,2) == '13' ) { // Schlusssatz UI etc.
      $art = "UI";
      $sum_betrag13 = substr($line, 8,9)/100;      
      $anzahl_sa11 = substr($line, 17,4)+0;
      $anzahl_sa12 = substr($line, 21,4)+0;
    }    
    if (substr($line, 0,4) == '5150' ) { // Schlusssatz infoscore 
      $art = "INFOS";
      $sum_betrag5150 = (substr($line, 14,9).substr($line, 24,2))/100;      
      $anzahl_sa5130 = substr($line, 27,4)+0;
      $anzahl_sa5140 = substr($line, 32,4)+0;
    }    
    // Ausgabe Saetze
    // Spaltenüberschriften
    // Satzartvergleichsfeld für Gruppenwechsel aufbauen
    if ((substr($line, 0,2) == '10') OR (substr($line, 0,2) == '11') OR (substr($line, 0,2) == '12')) {
      $sa_neu = substr($line, 0,2);        
    } else {
      $sa_neu = substr($line, 0,4);            
    }
    // Gruppenwechsel ? Wenn ja, dann Ausgabe Überschriftszeile    
    if ($sa <> $sa_neu) {
      if ( substr($line, 0,2) == '11') {
        echo "<br>".$ueberschrift_buch;
        $sa = substr($line, 0,2);        
      }
      if ( substr($line, 0,4) == '5130') {
        echo "<br>".$ueberschrift_buch;
        $sa = substr($line, 0,4);        
      }
      if ( substr($line, 0,2) == '12') {
        echo "<br>".$ueberschrift_stati;
        $sa = substr($line, 0,2);        
      }
      if ( substr($line, 0,4) == '5140') {
        echo "<br>".$ueberschrift_stati;
        $sa = substr($line, 0,4);        
      }
    }
    // Ausgabe Satz Buchungen oder Status
    if ((substr($line, 0,2) == '11') OR (substr($line, 0,4) == '5130')) {
         echo "<br>".$vorlaufsatz.';'.$buchung;           
    }
    if ((substr($line, 0,2) == '12') OR (substr($line, 0,4) == '5140')) {   
         echo "<br>".$vorlaufsatz.';'.$status;           
    }
    $buchung ='';
    $status ='';    
    
}
// Prüfung Schlussätze

echo "<br><br><br>Prüfung Schlusssatz:";
echo "ART: ".$art;
if ($art == 'UI' ) { // Schlusssatz UI etc.
    if (($sum_betrag13 == $sum_betrag11) AND ($anzahl_sa11 == $count_sa11) AND ($anzahl_sa12 == $count_sa12) )
    {
       echo "<br><b><font color='#00C000'>KEIN FEHLER</font></b><br>";       
    } else {
       echo "<br><b><font color='#FF0000'>FEHLER</font></b>";
    }
    echo "<br>Summe Betrag:".$sum_betrag13;
    echo "<br>Anzahl SA11:".$anzahl_sa11;
    echo "<br>Anzahl SA12:".$anzahl_sa12;
    echo "<br>Summe Betrag IST:".$sum_betrag11;
    echo "<br>Anzahl SA11 IST:".$count_sa11;
    echo "<br>Anzahl SA12 IST:".$count_sa12;

} else {
    if (($sum_betrag5150 == $sum_betrag5130) AND ($anzahl_sa5130 == $count_sa5130) AND ($anzahl_sa5140 == $count_sa5140))
    {
       echo "<br><b><font color='#00C000'>KEIN FEHLER</font></b><br>";       
    } else {
       echo "<br><b><font color='#FF0000'>FEHLER</font></b>";
    }
    echo "<br>Summe Betrag:".$sum_betrag5150;      
    echo "<br>Anzahl SA5130:".$anzahl_sa5130;
    echo "<br>Anzahl SA5140:".$anzahl_sa5140;
    echo "<br>Summe Betrag IST:".$sum_betrag5130;      
    echo "<br>Anzahl SA5130 IST:".$count_sa5130;
    echo "<br>Anzahl SA5140 IST:".$count_sa5140;
    
}    

$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Inkassoabrechnungen - Ende: ".$heute;

?>
</body>    
</html>
