<html>
  <head>
     <title>KIMI-Plus - Abrechnung Inkasso</title>
  </head>
  <body>
  <h1>KIMI-Plus - Abrechnung Inkasso</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Abrechnung Inkasso - Start: ".$heute;

$query = "
";


echo "<table border='1' cellspacing='1' cellpadding='5'";
echo "<tr><td><b>Report:<b> </td><td>Abrechnungen Inkasso</td></tr>";
echo "<tr><td><b>Datei:<b> </td><td>Div. Abrechnungsbelege</td></tr>";
echo "<tr><td><b>Rhythmus:<b> </td><td>monatlich</td></tr>";
echo "<tr><td><b>Verteiler:<b> </td><td>Paula K&uuml;hn, Katrin Rudolph, Livia Lorkowski</td></tr>";
echo "<tr><td><b>Vorgehensweise:<b> </td><td>comming soon - im Zuge der Inkassoabrechnungen</td></tr>";
echo "</table><br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Abrechnung Inkasso - Ende: ".$heute;

?>
</body>    
</html>
