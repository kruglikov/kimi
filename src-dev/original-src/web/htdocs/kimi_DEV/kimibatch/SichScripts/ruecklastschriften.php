<html>
  <head>
     <title>KIMI-Plus - R&uuml;cklastschrifen</title>
  </head>
  <body>
  <h1>KIMI-Plus -  R&uuml;cklastschrifen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "R&uuml;cklastschrifen - Start: ".$heute;

$ausgabe = False;
$belege = 0 ;

$lines = file('files/mt94b.dat');

echo "<br>Anzeige: Eingabefile: <br>";
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
}
echo "<br>Anzeige Lastschriftbelege";
//
foreach ($lines as $line_num => $line) {
    // wenn Lastschriftenbeleg, dann alle Zeilen ausgaben bis zum nächsten Beleg
    if ((substr($line,0,1) == ':') AND ($ausgabe== TRUE)) {
      $ausgabe = FALSE;
      echo "<br><b>+---Belegende----------------------------------------------------+</b><br><br>";      
    }
    if ((substr_count($line, ':86E:01        SEPA-Lastschrift') > 0 ) or ( substr_count($line, ':86E:01        LASTSCHRIFT') > 0 )) {
      //Lastschriftbeleg
      $ausgabe = TRUE;  
      $belege++;      
      echo "<br><b>+---Beleganfang---------------------------------------------------+</b>";
    }
    if ($ausgabe==TRUE) {
      echo "<br>".$line;
    } 
}
if ($belege >0) {
  echo "<br><br><h3>Anzahl Belege: ".$belege."</h3>";
} else {
  echo "<br><h3><br>KEINE Belege! </h3>";
}
$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."R&uuml;	cklastschrifen - Ende: ".$heute;

?>
</body>    
</html>
