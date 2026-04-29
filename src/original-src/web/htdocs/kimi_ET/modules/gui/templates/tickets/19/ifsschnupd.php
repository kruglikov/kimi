<html>
  <head>
     <title>KIMI-Plus - INFOSCORE SchnittstellenUpdate</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INFOSCORE SchnittstellenUpdate</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "INFOSCORE SchnittstellenUpdate - Start: ".$heute;


// selects für Stati
$select_ifs_erledigt = "
select * from ticket t where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from ifserledigt)
";
$select_ifs_erreicht = "
select * from ticket where mandant_id = 27 and kampagne_id <>99 and ticketnr in (select ticketnr from ifserreicht)
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
if (mysql_query($update_ifs_erledigt))
  {
  echo "Update Status ERLEDIGT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_ifs_erreicht))
  {
  echo "Update Status ERREICHT durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
if (mysql_query($update_ifs_telefonnummerfalsch))
  {
  echo "Update Status TELEFONNUMMERFALSCH durchgef&uuml;hrt<br>";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
  if (mysql_query($update_ifs_unerreichbar))
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
echo "<br><br>INFOSCORE SchnittstellenUpdate - Ende: ".$heute;

?>
</body>    
</html>
