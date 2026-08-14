<html>
  <head>
     <title>KIMI-Plus - Kontobewegungen</title>
  </head>
  <body>
  <h1>KIMI-Plus - Kontobewegungen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Kontobewegungen - Start: ".$heute;

$query = "
";


echo "<table border='1' cellspacing='1' cellpadding='5'";
echo "<tr><td><b>Report:<b> </td><td>Kontobewegungen</td></tr>";
echo "<tr><td><b>Datei:<b> </td><td>Kontobewegungen.xls</td></tr>";
echo "<tr><td><b>Rhythmus:<b> </td><td>w&ouml;chentlich</td></tr>";
echo "<tr><td><b>Verteiler:<b> </td><td>Paula K&uuml;hn, Katrin Rudolph, Livia Lorkowski</td></tr>";
echo "<tr><td><b>Vorgehensweise:<b> </td><td>comming soon</td></tr>";
echo "</table><br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Kontobewegungen - Ende: ".$heute;

?>
</body>    
</html>
