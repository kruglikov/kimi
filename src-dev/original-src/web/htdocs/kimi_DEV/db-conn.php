<?php

$dbname="kimi_ET";

$dbhost="10.70.83.100";

$dbuser="kimi";

$dbpass="KimiPlus@13";

$myconn = mysql_connect($dbhost,$dbuser,$dbpass);

mysql_select_db($dbname);

if (!myconn) { die ("keine verbindung zur Datenbank");
}
	
$query = "SELECT * FROM kimi_KBF_Test.anrede";

$result = mysql_query($query);
 
if (!$result) {
    die('Invalid query: ' . mysql_error());
	
} 
//$output = mysql_fetch_array($result);


echo "<table>"; 
while ($line = mysql_fetch_array($result)) { 
       
		 //$string = $line['id'].";".$line['text'].";".$line['geaendert_am'].";".$line['geaendert_am'].";"; 

		
		echo "<tr><td>" . $line['id'] . "</td><td>" . $line['text'] . "</td></tr>";  
		}

	echo "</table>"; 

mysql_close(); 
//else
//die ("verbindung zur Datenbank");



?>