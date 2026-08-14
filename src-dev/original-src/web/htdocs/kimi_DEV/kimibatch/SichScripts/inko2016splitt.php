<html>
  <head>
     <title>KIMI-Plus - INKO2016 SPLITT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO2016 SPLITT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INKO2016 IMPORT - Start: ".$heute;
// SQL-Statements
// MAX ID selektieren
//


//


//
// INKO-Santander-Datei

$lines = file('files/INKO2016WORK.CSV');
$filename1 = "files/INKO2016".date("Ymdm").".CSV";
$fp1 = fopen($filename1, 'w');
$filename2 = "files/INKO2018".date("Ymdm").".CSV";
$fp2 = fopen($filename2, 'w');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
	//20170127 AR: wenn nicht UTF-8 dann konvertieren
	$line = convert2Utf8($line);

	if (substr($line, 0,6) == 'IndexA' ) {
      // Spaltenüberschrift
		$z = 0;
	  //20170127 AR: wenn nicht UTF-8 dann konvertieren
	  echo "<br>1ter Satz: ".convert2Utf8($spaltenueberschrift);
    } else {
		$z = $z +1;
    }		
    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
		
	
	
}
echo "<br>Anzahl Sätze ohne Überschrift in der Datei: ".$z;
//
$w1 = 0;
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num1 => $line) {
	


	if (substr($line, 0,6) == 'IndexA' ) {
      // Spaltenüberschrift
		fwrite($fp1, $line); // will proccess /n as newline ... 	
	  //20170127 AR: wenn nicht UTF-8 dann konvertieren
	  echo "<br>1ter Satz: ".convert2Utf8(substr($line, 0,6));
    } else {
		
		// $naechster_schritt= substr($line, 531,20);
		echo "<br>: naechster_schritt: ".convert2Utf8(substr($line, 583,20))."x";
		if (substr($line, 583,6) == 'Anwalt' ) {
      
	    	fwrite($fp1, $line); // will proccess /n as newline ... 	
			$w1 = $w1+1;
	    }

	}
//	
}
echo "<br>Anzahl Sätze Datei INKO2016: ".$w1;

//
fclose($fp1);
//
$w2 = 0;
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num2 => $line) {
	if (substr($line, 0,6) == 'IndexA' ) {
      // Spaltenüberschrift
		fwrite($fp2, $line); // will proccess /n as newline ... 	
	  //20170127 AR: wenn nicht UTF-8 dann konvertieren
	  echo "<br>1ter Satz: ".convert2Utf8(substr($line, 0,6));
    } else {
		// $naechster_schritt= substr($line, 531,20);
		if (substr($line, 583,3) == 'Vor' ) {
      
	    	fwrite($fp2, $line); // will proccess /n as newline ... 	
			$w2 = $w2+1;
	    }
		if (substr($line, 583,5) == 'Raten' ) {
      
	    	fwrite($fp2, $line); // will proccess /n as newline ... 	
			$w2 = $w2+1;
	    }


	}	
	
	
}
//
echo "<br><br>Anzahl Sätze Datei INKO2018: ".$w2;
//
echo "<br>Anzahl Sätze Eingabe Gesamt: ".$z;
$sum=$w1+$w2;
echo "<br>Anzahl Sätze Ausgabe Gesamt: ".$sum;
if ($z == $sum ) {
      
	  echo "<br>OK !!!!!!!!";
    } else {
	  echo "<br>NICHT OK !!!!!!!!";
}

//
fclose($fp2);

//
echo "<br><br>"."INKO2016 SPLITT - Ende: ".$heute;
//
mysql_free_result($result);
mysql_close();
?>
</body>    
</html>
