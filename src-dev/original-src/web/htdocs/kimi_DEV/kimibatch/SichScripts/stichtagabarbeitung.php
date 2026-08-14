<html>
  <head>
     <title>KIMI-Plus - Stichtagsliste abarbeiten</title>
  </head>
  <body>
  <h1>KIMI-Plus - Stichtagsliste abarbeiten</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Stichtagsliste abarbeiten - Start: ".$heute;

$query = "
";


echo "<table border='1' cellspacing='1' cellpadding='5'";
echo "<tr><td><b>Report:<b> </td><td>Stichtagsliste abarbeiten</td></tr>";
echo "<tr><td><b>Datei:<b> </td><td>Datei siehe Stichtagsliste</td></tr>";
echo "<tr><td><b>Rhythmus:<b> </td><td>t&auml;glich</td></tr>";
echo "<tr><td><b>Verteiler:<b> </td><td>KIMI-Plus/td></tr>";
echo "<tr><td><b>Vorgehensweise:<b> </td><td>
<br>
DIALOG KIMI-Plus Poratal:<br>
 - Zinsen<br>
 - Beachten Kenner Stundung, Mahnsperre<br> 
 - Raten verschieben<br> 
 - Topfverschiebung<br> 
 - Cardifversicherung - Zinsenbuchen<br> 
</td></tr>";
echo "</table><br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Inkassorechnungen drucken - Ende: ".$heute;

?>
</body>    
</html>
