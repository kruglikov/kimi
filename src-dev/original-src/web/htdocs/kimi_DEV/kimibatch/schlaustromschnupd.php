<html>
  <head>
     <title>KIMI-Plus - SCHLAUSTROM SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SCHLAUSTROM SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "SCHLAUSTROM SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_ifs_erledigt = "
select * from ticket t where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from ifserledigt)
";
$select_ifs_erreicht = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from ifserreicht)
";
$select_ifs_erreichtap = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from ifserreichtap)
";
$select_ifs_unerreichbar = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in  (select ticketnr from ifsunerreichbar)
";
$select_ifs_telefonnummerfalsch = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from ifstelefonnummerfalsch)
";
// Updates für Stati
$update_ifs_erledigt = "
update ticket set status_id = 118 
where mandant_id = 27 and kampagne_id <>99 and ticketnr  in (select ticketnr from ifserledigt)
";
$update_ifs_erreicht = "
update ticket set anruf_status_id = 375 
where mandant_id = 27 and  kampagne_id <>99 and ticketnr in (select ticketnr from ifserreicht)
";
$update_inkosantander_erreichtap = "
update ticket set anruf_status_id = 515 
where mandant_id = 27 and  kampagne_id <>99 and ticketnr in (select ticketnr from ifserreichtap)
";
$update_ifs_telefonnummerfalsch = "
update ticket set anruf_status_id = 376
where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from ifstelefonnummerfalsch)
";
$update_ifs_unerreichbar = "
update ticket set anruf_status_id = 377
where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from ifsunerreichbar)
";

//


echo "<br><br><b>UPDATE Status der  INFOSCORE-Tabellen:<br></b>";
if (mysqli_query($dbconn, $update_ifs_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_ifs_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_ifs_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $update_ifs_unerreichbar))
  {
  echo "Update Status UNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }

//

//mysql_free_result($result);
mysqli_close($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>SCHLAUSTROM SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
