<html>
  <head>
     <title>KIMI-Plus - SBERBANK REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SERBANKBANK REPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "SBERBANK REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_sberbank
select ticket.*,now() from ticket 
where ticket.mandant_id =43 and kampagne_id <>99 and status_id = 208
and anruf_status_id in (605,611,610,619,618,620);
";

// INSERT IN TICKET-Tabelle
if (mysqli_query($dbconn, $insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_sberbank durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_sberbank in database: " . mysql_error();
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."SBERBANK REPORT - Ende: ".$heute;
//
mysqli_close($dbconn);
?>
</body>    
</html>
