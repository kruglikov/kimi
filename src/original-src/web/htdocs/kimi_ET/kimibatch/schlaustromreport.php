<html>
  <head>
     <title>KIMI-Plus - SCHLAUSTROM REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SCHLAUSTROM REPORT</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "SCHLAUSTROM REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_schlaustrom
select ticket.*,now() from ticket 
where ticket.mandant_id =27 and kampagne_id <>99 and status_id = 117
and anruf_status_id in (373,379,378,372);
";

// INSERT IN TICKET-Tabelle
if (mysqli_query($dbconn, $insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_schlaustrom durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_inko2018 in database: " . mysqli_error($dbconn);
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."SCHLAUSTROM REPORT - Ende: ".$heute;
//
// mysql_free_result($result);
// mysql_close();
// mysql_free_result($result);
// mysql_close();

dbClose($dbconn);


?>
</body>    
</html>
