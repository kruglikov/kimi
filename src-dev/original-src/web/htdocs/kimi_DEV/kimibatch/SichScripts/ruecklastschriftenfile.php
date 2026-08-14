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
//
$filename = "files/ruecklastschriften".date("YmdHis").".csv";
$fp = fopen($filename, 'w');
$start = date("d.m.Y H:i:s");
$string ="Start:".$start.";"."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
//
$lines = file('files/mt94b.dat');


//
foreach ($lines as $line_num => $line) {
    // wenn Lastschriftenbeleg, dann alle Zeilen ausgaben bis zum nächsten Beleg
    if ((substr($line,0,1) == ':') AND ($ausgabe== TRUE)) {
      $ausgabe = FALSE;
      //echo "<br><b>+---Belegende----------------------------------------------------+</b><br><br>";      
	  $string ="+---Belegende----------------------------------------------------+;"."\n"; 
      fwrite($fp, $string); // will proccess /n as newline ... 
    }
    if ((substr_count($line, ':86E:01        SEPA-Lastschrift') > 0 ) or ( substr_count($line, ':86E:01        LASTSCHRIFT') > 0 )) {
      //Lastschriftbeleg
      $ausgabe = TRUE;  
      $belege++;      
      //echo "<br><b>+---Beleganfang---------------------------------------------------+</b>";
	  $string ="+---Beleganfang----------------------------------------------------+;"."\n"; 
      fwrite($fp, $string); // will proccess /n as newline ... 
    }
    if ($ausgabe==TRUE) {
      //echo "<br>".$line;
	  $string = "_".$line; 
      fwrite($fp, $string); // will proccess /n as newline ... 
    } 
}
if ($belege >0) {
  //echo "<br><br><h3>Anzahl Belege: ".$belege."</h3>";
  $string ="Anzahl Belege: ".$belege."\n"; 
  fwrite($fp, $string); // will proccess /n as newline ... 
} else {
  //echo "<br><h3><br>KEINE Belege! </h3>";
  $string ="KEINE Belege"."\n"; 
  fwrite($fp, $string); // will proccess /n as newline ... 
  }
$ende = date("d.m.Y H:i:s");
$string ="Ende:".$ende.";"."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 

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
$heute = date("d.m.Y H:i:s");    
//echo "<br><br>"."R&uuml;cklastschrifen - Ende: ".$heute;

?>
</body>    
</html>
