<html>
  <head>
     <title>KIMI-Plus - INKODE REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKODE REPORT</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INKODE REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_inkode
select ticket.*,now() from ticket 
where ticket.mandant_id =24 and kampagne_id <>99 and status_id = 101
and anruf_status_id in (333,339,340,447);
";

// INSERT IN TICKET-Tabelle
if (mysqli_query($dbconn, $insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_inkode durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_inkode in database: " . mysqli_error($dbconn);
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKODE REPORT - Ende: ".$heute;
//
// mysql_free_result($result);
// mysql_close();
// mysql_free_result($result);

// mysql_close();

dbClose($dbconn);

?>
</body>    
</html>
