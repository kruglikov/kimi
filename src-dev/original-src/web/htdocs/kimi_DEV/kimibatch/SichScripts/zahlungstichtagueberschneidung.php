<html>
  <head>
     <title>KIMI-Plus - Zahlung-Stichtag-Überschneidung</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Zahlung-Stichtag-Überschneidung</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Zahlung-Stichtag-Überschneidung - Start: ".$heute;


// 1) Check manuelle Zahlungen?
$query_zahl_stich = "select 'kdnr' kontonummer
UNION
select kdnr from (
select 'Z', kundennummer kdnr from zahlungen 
union
select 'Z',kundennummer kdnr from zahlungen2 
union
select 'S',stammdaten_id kdnr from stichtag 
) x
group by kdnr
having count(*) > 1";

//
echo "<br><br><b>1) Pr&uuml;fung Zahlungen/Stichtag-Überschneidungen<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  

//
$result = mysql_query($query_zahl_stich);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= $line['kontonummer'].";";
echo "<br>".$drucksatz;

 ?>
 <?PHP 
 
}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//

  //

mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>Zahlung-Stichtag-Überschneidung - Ende: ".$heute;

?>
</body>    
</html>
