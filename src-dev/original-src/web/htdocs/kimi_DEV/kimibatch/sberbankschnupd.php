<html>
  <head>
     <title>KIMI-Plus - SBERBANK SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SBERBANK SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "SBERBANK SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_sberbank_erledigt = "
select * from ticket t where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKerledigt)
";
$select_sberbank_erreicht = "
select * from ticket where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKerreicht)
";
$select_sberbank_erreichtap = "
select * from ticket where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKerreichtap)
";
$select_sberbank_unerreichbar = "
select * from ticket where mandant_id = 43 and kampagne_id <>99 and ticketnr in  (select ticketnr from SBERBANKunerreichbar)
";
$select_sberbank_telefonnummerfalsch = "
select * from ticket where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKtelefonnummerfalsch)
";
$select_sberbank_gesendet = "
select * from ticket where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKgesendet)
";
$select_sberbank_manbearbeitet = "
select * from ticket where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKmanbearbeitet)
";
// Updates für Stati
$update_sberbank_erledigt = "
update ticket set status_id = 209
where mandant_id = 43 and kampagne_id <>99 and ticketnr  in (select ticketnr from SBERBANKerledigt)
";
$update_sberbank_erreicht = "
update ticket set anruf_status_id = 607 
where mandant_id = 43 and  kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKerreicht)
";
// nicht aktiv bei sberbank
$update_sberbank_erreichtap = "
update ticket set anruf_status_id = 539
where mandant_id = 43 and  kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKerreichtap)
";
$update_sberbank_telefonnummerfalsch = "
update ticket set anruf_status_id = 608 
where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKtelefonnummerfalsch)
";
$update_sberbank_unerreichbar = "
update ticket set anruf_status_id = 609
where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKunerreichbar)
";
$update_sberbank_gesendet = "
update ticket set anruf_status_id = 619
where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKgesendet)
";
$update_sberbank_manbearbeitet = "
update ticket set anruf_status_id = 621
where mandant_id = 43 and kampagne_id <>99 and ticketnr in (select ticketnr from SBERBANKmanbearbeitet)
";

//


echo "<br><br><b>UPDATE Status der  SBERBANK-Tabellen:<br></b>";
if (mysqli_query($dbconn, $update_sberbank_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
if (mysqli_query($dbconn, $update_sberbank_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  /*
if (mysqli_query($dbconn, $update_sberbank_erreichtap))
  {
  echo "Update Status ERREICHTAP durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  */
if (mysqli_query($dbconn, $update_sberbank_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $update_sberbank_unerreichbar))
  {
  echo "Update Status UNERREICHBAR durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $update_sberbank_gesendet))
  {
  echo "Update Status GESENDET durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
  if (mysqli_query($dbconn, $update_sberbank_manbearbeitet))
  {
  echo "Update Status MANBEARBEITET durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($dbconn);
  }
//

mysqli_close($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>SBERBANK SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
