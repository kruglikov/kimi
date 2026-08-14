<html>
  <head>
     <title>KIMI-Plus - ABS OPLISTE AUFBEREITUNG</title>
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

$lines = file('files/oplistework.csv');
$filename1 = "files/oplisteworkout".date("Ymdm").".csv";
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

// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num1 => $line) {
	


	if (substr($line, 0,5) == 'feld1' ) {
      // Spaltenüberschrift
		$spalteA = 'kdnr';
		$spalteB = 'lfdnr';
        $z = 0;		
	  echo "<br>1ter Satz: ".convert2Utf8(substr($line, 0,6));
    } else {
		$z = $z+1;
		if (substr($line, 0,6) == 'Kunde:' ) {
            $kdnr = substr($line, 7,6);
    		
        }
		$spalteA = $kdnr;
		$spalteB = $z;
	}

	fwrite($fp1, $spalteA.' '.$spalteB.' '.$line); // will proccess /n as newline ... 		
//	
}
echo "<br>Anzahl Sätze Datei ABS OPLISTE: ".$w1;

//
fclose($fp1);
//

//
echo "<br><br>"."ABS OPLISTE Ende: ".$heute;
//
mysql_free_result($result);
mysql_close();
?>
</body>    
</html>
