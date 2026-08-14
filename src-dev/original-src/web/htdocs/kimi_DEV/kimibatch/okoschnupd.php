<html>
  <head>
     <title>KIMI-Plus - OKO SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "OKO SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_oko_erledigt = "
select * from ticket where mandant_id = 16 and ticketnr in (select ticketnr from okoerledigt)
";
$select_oko_erreicht = "
select * from ticket where mandant_id = 16 and ticketnr in (select ticketnr from okoerreicht)
";
$select_oko_unerreichbar = "
select * from ticket where mandant_id = 16 and ticketnr in (select ticketnr from okounerreichbar)
";
$select_oko_telefonnummerfalsch = "
select * from ticket where mandant_id = 16 and ticketnr in (select ticketnr from okotelefonnummerfalsch)
";
// Updates für Stati
$update_oko_erledigt = "
update ticket set status_id = 56 
where mandant_id = 16 and ticketnr in  (select ticketnr from okoerledigt)
";
$update_oko_erreicht = "
update ticket set anruf_status_id = 199 
where mandant_id = 16 and ticketnr in (select ticketnr from okoerreicht)
";
$update_oko_telefonnummerfalsch = "
update ticket set anruf_status_id = 200
where mandant_id = 16 and ticketnr in (select ticketnr from okotelefonnummerfalsch)
";
$update_oko_unerreichbar = "
update ticket set anruf_status_id = 201
where mandant_id = 16 and ticketnr in (select ticketnr from okounerreichbar)
";

//


echo "<br><br><b>UPDATE Stati der OKO Tabellen:<br></b>";
if (mysqli_query($dbconn, $update_oko_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_oko_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_oko_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $update_oko_unerreichbar))
  {
  echo "Update Status UNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }

//

mysqli_close($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>OKO SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
