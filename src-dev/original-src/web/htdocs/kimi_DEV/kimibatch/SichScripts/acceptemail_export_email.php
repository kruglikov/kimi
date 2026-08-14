<html>
  <head>
     <title>KIMI-Plus - ACCEPTEMAIL-Export EMAIL</title>
  </head>
  <body>
  <h1>KIMI-Plus -  ACCEPTEMAIL-Export EMAIL</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "ACCEPTEMAIL-Export - EMAIL Start: ".$heute;

/* xxx
x
*/



$filenameemail = "files/kimiplus_ae_email".date("Ymdm").".csv";
$outfileemail = fopen($filenameemail, 'w');
$source_file = fopen("files/uebergabedateikimiplus.csv","r");


//datum
$date = date("YmdHis");
$tagesdatum= date("d.m.Y");
$akutelles_Datum_Uhrzeit=date("d.m.Y H:i");
$Tagesdatum_7Tage=date('d.m.Y', strtotime(' + 7 days'));
$z = 0;
 
// changes the date ,datetime,expiredate of the original file($source_file)
while ($line_of_text = fgetcsv($source_file, 10000,";")) {
	  $z = $z +1 ;
      $line_of_text[1] = str_replace(['2017.05.05'],[$tagesdatum], $line_of_text[1]);
      $line_of_text[7] = str_replace(['2017.05.05 09:52'],[$akutelles_Datum_Uhrzeit], $line_of_text[7]);
      $line_of_text[9] = str_replace(['2017.05.15'],[$Tagesdatum_7Tage], $line_of_text[9]);
     
       
      $inhalt=$line_of_text[0].";".$line_of_text[1].";".$line_of_text[2].";".$line_of_text[3].";".$line_of_text[4].";".$line_of_text[5].";".$line_of_text[6].";".$line_of_text[7].";".$line_of_text[8].";".$line_of_text[9].";".$line_of_text[10].";".$line_of_text[11].";".$line_of_text[12].";".$line_of_text[13].";".$line_of_text[14].";".$line_of_text[15].";".$line_of_text[16].";".$line_of_text[17].";".$line_of_text[18].";";

      $inhalt.="\n";
      echo ' inhalt: '.$inhalt;
      // EMAIL-Datei
	  if ($z < 10) {
 		   fwrite($outfileemail, $inhalt);
           echo'Dateien write email';
      }

   }

fclose($outfileemail);
fclose($outfilesms);

$file = $filenameemail;

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
echo "<br><br>"."ACCEPTEMAIL-Export - EMAIL Ende: ".$heute;

?>
</body>    
</html>
