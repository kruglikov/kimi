<html>
  <head>
     <title>KIMI-Plus - INKOINBOUND REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKOINBOUND REPORT</h1>
<?PHP 

// include ("db.php");

include ("kimi_general.php");

$heute = date("d.m.Y H:i:s");    
echo "INKOINBOUND REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_inkoinbound
	select ticket.*,curdate() from ticket 
	where ticket.mandant_id =2 and kampagne_id = 2 and status_id = 7
	and anruf_status_id in (20);
";
$upate_ticket_leer = "
update ticket set status_id = 7,anruf_status_id=24,ergebnis = CONCAT(ifnull(ergebnis,''),'leer') , beginn =curdate()
where ticket.mandant_id =2 and kampagne_id = 2 and status_id = 6  and ifnull(anruf_status_id,0) in (0,20,24)
;
";
$update_ticket_gemeldet = "
update ticket set status_id = 8 where ticket.mandant_id =2 and kampagne_id = 2 and status_id = 7  and anruf_status_id in (20,24);
";

// INSERT IN TICKET-INBOUND-Tabelle
if (mysqli_query($dbconn, $insert_report))
{
echo "<br><br>Update in Reporttabelle ticket_inkoinbound durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_inkobound in database: " . mysqli_error($dbconn);
}
// UPDATE IN TICKET-Tabelle#1
if (mysqli_query($dbconn, $upate_ticket_leer))
{
echo "<br><br>upate_ticket_leer durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error upate_ticket_leer in database: " . mysqli_error($dbconn);
}
// UPDATE IN TICKET-Tabelle#2
if (mysqli_query($dbconn, $update_ticket_gemeldet))
{
echo "<br><br>update_ticket_gemeldet durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error update_ticket_gemeldet in database: " . mysqli_error($dbconn);
}
//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKOINBOUND REPORT - Ende: ".$heute;
//
// mysql_free_result($result);
// mysql_close();
// mysql_free_result($result);

// mysql_close();

dbClose($dbconn);

?>
</body>    
</html>
