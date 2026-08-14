<html>
  <head>
     <title>KIMI-Plus - Stichtags-Liste abarbeiten</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Stichtags-Liste abarbeiten</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Stichtags-Liste abarbeiten Start: ".$heute;

//
echo "<br><br><b>Setzen Stichtagsliste abgearbeitet<br></b><br>";
echo "Start: ".date("d.m.Y H:i:s");  

$heute = date("d.m.Y H:i:s");    
echo "<br><br>Stichtags-Liste abarbeiten- Ende: ".$heute;

?>
</body>    
</html>
