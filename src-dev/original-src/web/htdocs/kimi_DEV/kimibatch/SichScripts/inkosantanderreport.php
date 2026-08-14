<html>
  <head>
     <title>KIMI-Plus - INKOSANTANDER REPORT</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKOSANTANDER REPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INKOSANTANDER REPORT - Start: ".$heute;
// SQL-Statements
//
$insert_report = "
insert into ticket_inkoscb
select ticket.*,now() from ticket  
where ticket.mandant_id =12 and kampagne_id <>99 and status_id = 42 
and anruf_status_id in (139,131,130,443);
";

// INSERT IN TICKET-Tabelle
if (mysql_query($insert_report))
{
echo "<br><br>Insert in Reporttabelle ticket_inkoscb durchgef&uuml;hrt";
}
else
{
echo "<br><br>Error insert Reporttabelle ticket_inkoscb in database: " . mysql_error();
}

//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKOSANTANDER REPORT - Ende: ".$heute;
//
mysql_free_result($result);
mysql_close();
mysql_free_result($result);
mysql_close();
?>
</body>    
</html>
