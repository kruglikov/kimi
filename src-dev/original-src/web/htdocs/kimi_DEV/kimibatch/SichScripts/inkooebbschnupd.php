<html>
  <head>
     <title>KIMI-Plus - INKO-ÖBB SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO-ÖBB SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "INKO-ÖBB SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_inkooebb_erledigt = "
select * from ticket where mandant_id = 13 and ticketnr in (select ticketnr from inkooebberledigt)
";
$select_inkooebb_erreicht = "
select * from ticket where mandant_id = 13 and ticketnr in (select ticketnr from inkooebberreicht)
";
$select_inkooebb_unerreichbar = "
select * from ticket where mandant_id = 13 and ticketnr in (select ticketnr from inkooebbunerreichbar)
";
$select_inkooebb_telefonnummerfalsch = "
select * from ticket where mandant_id = 13 and ticketnr in (select ticketnr from inkooebbtelefonnummerfalsch)
";
// Updates für Stati
$update_inkooebb_erledigt = "
update ticket set status_id = 47 
where mandant_id = 13 and ticketnr in  (select ticketnr from inkooebberledigt)
";
$update_inkooebb_erreicht = "
update ticket set anruf_status_id = 153 
where mandant_id = 13 and ticketnr in (select ticketnr from inkooebberreicht)
";
$update_inkooebb_telefonnummerfalsch = "
update ticket set anruf_status_id = 154 
where mandant_id = 13 and ticketnr in (select ticketnr from inkooebbtelefonnummerfalsch)
";
$update_inkooebb_unerreichbar = "
update ticket set anruf_status_id = 155 
where mandant_id = 13 and ticketnr in (select ticketnr from inkooebbunerreichbar)
";

//


echo "<br><br><b>UPDATE Stati der INKO-ÖBB Tabellen:<br></b>";
if (mysql_query($update_inkooebb_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_inkooebb_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_inkooebb_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
  if (mysql_query($update_inkooebb_unerreichbar))
  {
  echo "Update Status UNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }

//

//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>INKO-ÖBB SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
