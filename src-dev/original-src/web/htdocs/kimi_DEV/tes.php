
<?php
$con=mysqli_connect("192.168.100.14:3306","kimi","KimiPlus@13","kimi_ET");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
else {
	echo "connection successful";
}
// ...some PHP code for database "my_db"...

// Change database to "test"
mysqli_select_db($con,"kimi_KBF_Test");

// ...some PHP code for database "test"...



$query = "select * from titel";
$result = mysql_query($query);

if (!$result) {
    die('Invalid query: ' . mysql_error());
}
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['id'].";".$line['text'].";".$line['geaendert_am'].";".$line['geaendert_von']; 			
		$string = $string.";"."\n"; 
		echo '<br>lesen';
		echo '<br>Ausgabe'.$line['text'].";";
		
		mysqli_close($con);
	
		}
		
?> 
