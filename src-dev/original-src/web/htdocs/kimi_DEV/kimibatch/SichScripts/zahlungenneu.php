<html>
  <head>
     <title>KIMI-Plus - ZahlungenNEU 201505 TEST</title>
  </head>
  <body>
  <h1>KIMI-Plus -  ZahlungenNEU 201505</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Zahlungen - Start: ".$heute;
// SQL-Statements
$zahlungenneu_trunc = "truncate table zahlungen";
// 
if (mysql_query($zahlungenneu_trunc ))
  {
  echo "TRUNCATE Zahlungen  durchgef&uuml;hrt";
  }
else
  {
  echo "<br>TRUNCATE Zahlungen: " . mysql_error();
  }

// RAIFFEISEN-Datei

$lines = file('files/zahlungenraiffe.txt');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
}
echo "<br>Anzeige Importfile f&uuml;r Tabelle Zahlungen: <br>";
//
echo '<br>vorlaufsatz;sa;kundennummer;ba;bg;belegdatum;betrag;herkunft';
foreach ($lines as $line_num => $line) {
    //echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
    //echo "<br>Satzart: ".substr($line, 119,2); 
    // Valutadatum aus Vorlaufsatz
    if (substr($line, 119,2) == 0 ) {
      $valutadatum = "20".substr($line, 42,6);
      $vorlaufsatz = $line;
      //echo "<br>Valutadatum: ".$valutadatum;
      if (substr_count($line, 'RAIFF') > 0) {
        //echo "<br>Geldinstitut: "."RAIFFE";
        $geldinstitut = 'RAIFFE';
      } else {
        //echo "<br>Geldinstitut: "."OBERBANK";
        $geldinstitut = 'OBERBA';        
      }  
    }
    
    if (substr($line, 119,2) == 1 ) {
      //echo "<br>Buchungsdatum: "."20".substr($line, 110,6);
      $buchungsdatum = "20".substr($line, 110,6);
      // Wenn Valutadatum leer, dann Buchungsdatum, sonst Valutadatum aus Vorlaufsatz      
      if (empty($valutadatum )) { 
           $belegdatum = $buchungsdatum;
      } else {
           $belegdatum = $valutadatum;
      };
      //echo "Belegdatum: ".$belegdatum;
      $belegdatum = substr($belegdatum,0,4).'-'.substr($belegdatum,4,2).'-'.substr($belegdatum,6,2);
      //echo "<br>Buchungsdatum: ".$belegdatum;
      $kundennummer = substr($line, 94,8);
      //echo "<br>Kundennummer: ".$kundennummer;     
      $betrag = substr($line, 5,11)/100;
      $betrag = number_format($betrag,2,".","");
      //echo "<br>Betrag: ".$betrag;         
      if ($geldinstitut =='RAIFFE'){
        $herkunft = $geldinstitut;
        //echo "<br>Herkunft: ".$geldinstitut;
        $ba = 21;        
        $bg = 54;        
        //echo "<br>BA/BG: ".$ba.'/'.$bg;        
      } else {
        $herkunft = $geldinstitut;
        //echo "<br>Herkunft: ".$geldinstitut;
        $ba = 21;        
        $bg = 50;        
        // echo "<br>BA/BG: ".$ba.'/'.$bg;        
      }  
      // Ausgabe Zahlungsastz
      $geaendert_von = 'zahlungenbatch';
      $geaendert_am = date('Y-m-d H:i:s');
      echo "<br>".$vorlaufsatz.';01;'.$kundennummer.';'.$ba.';'.$bg.';'.$belegdatum.';'.$betrag.';'.$herkunft.';'.$geaendert_am.';'.$geaendert_von;
	  // Insert in Zahlungen
	  $zahlungen_ins = "INSERT INTO zahlungen (vorlaufsatz,sa,kundennummer,ba,bg, belegdatum,betrag,herkunft,geaendert_am,geaendert_von) 
	  values ("."'".$vorlaufsatz."'".",'".'01'."','".$kundennummer."','".$ba."','".$bg."','".$belegdatum."','".$betrag."','".$herkunft."','".$geaendert_am."','".$geaendert_von."'".")";
      //echo "<br>".$zahlungenneu_ins;
	  if (mysql_query($zahlungen_ins))
	  {
      //echo "Insert in Zahlungen durchgef&uuml;hrt";
      }
      else
      {
      echo "Error insert in database: " . mysql_error();
      }
    }

}
// OBERBANK-Datei
$lines = file('files/zahlungenoberba.txt');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
}
echo "<br>Anzeige Importfile f&uuml;r Tabelle Zahlungen: <br>";
//
echo '<br>vorlaufsatz;sa;kundennummer;ba;bg;belegdatum;betrag;herkunft';
foreach ($lines as $line_num => $line) {
    //echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
    //echo "<br>Satzart: ".substr($line, 119,2); 
    // Valutadatum aus Vorlaufsatz
    if (substr($line, 119,2) == 0 ) {
      $valutadatum = "20".substr($line, 42,6);
      $vorlaufsatz = $line;
      //echo "<br>Valutadatum: ".$valutadatum;
      if (substr_count($line, 'RAIFF') > 0) {
        //echo "<br>Geldinstitut: "."RAIFFE";
        $geldinstitut = 'RAIFFE';
      } else {
        //echo "<br>Geldinstitut: "."OBERBANK";
        $geldinstitut = 'OBERBA';        
      }  
    }
    
    if (substr($line, 119,2) == 1 ) {
      //echo "<br>Buchungsdatum: "."20".substr($line, 110,6);
      $buchungsdatum = "20".substr($line, 110,6);
      // Wenn Valutadatum leer, dann Buchungsdatum, sonst Valutadatum aus Vorlaufsatz      
      if (empty($valutadatum )) { 
           $belegdatum = $buchungsdatum;
      } else {
           $belegdatum = $valutadatum;
      };
      //echo "Belegdatum: ".$belegdatum;
      $belegdatum = substr($belegdatum,0,4).'-'.substr($belegdatum,4,2).'-'.substr($belegdatum,6,2);
      //echo "<br>Buchungsdatum: ".$belegdatum;
      $kundennummer = substr($line, 94,8);
      //echo "<br>Kundennummer: ".$kundennummer;     
      $betrag = substr($line, 5,11)/100;
      $betrag = number_format($betrag,2,".","");
      //echo "<br>Betrag: ".$betrag;         
      if ($geldinstitut =='RAIFFE'){
        $herkunft = $geldinstitut;
        //echo "<br>Herkunft: ".$geldinstitut;
        $ba = 21;        
        $bg = 54;        
        //echo "<br>BA/BG: ".$ba.'/'.$bg;        
      } else {
        $herkunft = $geldinstitut;
        //echo "<br>Herkunft: ".$geldinstitut;
        $ba = 21;        
        $bg = 50;        
        // echo "<br>BA/BG: ".$ba.'/'.$bg;        
      }  
      // Ausgabe Zahlungsastz
      $geaendert_von = 'zahlungenbatch';
      $geaendert_am = date('Y-m-d H:i:s');
      echo "<br>".$vorlaufsatz.';01;'.$kundennummer.';'.$ba.';'.$bg.';'.$belegdatum.';'.$betrag.';'.$herkunft.';'.$geaendert_am.';'.$geaendert_von;
	  // Insert in Zahlungen
	  $zahlungen_ins = "INSERT INTO zahlungen (vorlaufsatz,sa,kundennummer,ba,bg, belegdatum,betrag,herkunft,geaendert_am,geaendert_von) 
	  values ("."'".$vorlaufsatz."'".",'".'01'."','".$kundennummer."','".$ba."','".$bg."','".$belegdatum."','".$betrag."','".$herkunft."','".$geaendert_am."','".$geaendert_von."'".")";
      //echo "<br>".$zahlungen_ins;
	  if (mysql_query($zahlungen_ins))
	  {
      //echo "Insert in Zahlungen durchgef&uuml;hrt";
      }
      else
      {
      echo "Error insert in database: " . mysql_error();
      }
    }

}
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Zahlungen - Ende: ".$heute;

?>
</body>    
</html>
