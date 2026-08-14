<html>
  <head>
     <title>KIMI-Plus - INKO2018 REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKO2018 REPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INKO2018 REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_inko2018
select ticket.*,now() from ticket 
where ticket.mandant_id =33 and kampagne_id <>99 and status_id = 155
and anruf_status_id in (453,455,461,462);
";

// INSERT IN TICKET-Tabelle
if (mysql_query($insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_inko2018 durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_inko2018 in database: " . mysql_error();
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKO2018 REPORT - Ende: ".$heute;
//
mysql_free_result($result);
mysql_close();
mysql_free_result($result);
mysql_close();
?>
</body>    
</html>
