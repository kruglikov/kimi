<html>
  <head>
     <title>KIMI-Plus - INKOSANTANDER IMPORT URGENZ</title>
  </head>
  <body>
  <h1>KIMI-Plus -  INKOSANTANDER IMPORT</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "INKOSANTANDER IMPORT - Start: ".$heute;
//
// ---
// truncate table inkourgenz
$trunc_urgenz = "
truncate table inkourgenz
";
// 
if (mysql_query($trunc_urgenz ))
  {
  echo "<br><br>TRUNCATE INKOURGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>TRUNCATE INKOURGENZ : " . mysql_error();
  }
//
// insert into inkourgenz 
$ins_urgenz = "
insert into inkourgenz 
select 12 mandant_id, max(ticketnr) ticketnr,group_concat(urgenztxt)  urgenztext from (
select ticketnr,nachname,vorname,geburtsdatum,plz,strasse,dummy_text9,
CONCAT('Index:',dummy_text9,' - ','Ticket:',ticketnr, ' - ', REPLACE( ergebnis, CHAR(13,10), ' ' ),CHAR(13,10)) urgenztxt,
REPLACE(REPLACE(dummy_text10, char(10), char(32)), char(13), char(32))
from ticket where mandant_id = 12 and concat(nachname,vorname) in (
select concat(nachname,vorname) from ticket where id in (select * from inkosantander_duplet )
and  mandant_id = 12 and kampagne_id <> 99 
) order by nachname, ticketnr
) x
group by concat(nachname,vorname,geburtsdatum)
";
// 
if (mysql_query($ins_urgenz ))
  {
  echo "<br><br>INSERT INKOURGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>INSERT INKOURGENZ : " . mysql_error();
  }
//
// update ticket  join inkourgenz 
$update_urgenz = "
update ticket  join inkourgenz
on ticket.ticketnr = inkourgenz.ticketnr and ticket.mandant_id = inkourgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 12 and ticket.ticketnr = inkourgenz.ticketnr
";
// 
if (mysql_query($update_urgenz ))
  {
  echo "<br><br>UPDATE TICKET URGENZ  durchgef&uuml;hrt";
  }
else
  {
  echo "<br><br>UPDATE TICKET URGENZ: " . mysql_error();
  }
//
$query_urgenz = "
select count(*) anzahl_n_urgenz From inkourgenz
"; 
//
echo "<br><br><b>Pr&uuml;fung URGENZ:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_urgenz);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl_n_urgenz'] > 0)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Status | URGENZ : ".$line['anzahl_n_urgenz']."<br>";
	  }
    }	  
//
//
$heute = date("d.m.Y H:i:s");    
//
echo "<br><br>"."INKOSANTANDER IMPORT - Ende: ".$heute;
//
mysql_free_result($result);
mysql_close();
?>
</body>    
</html>
