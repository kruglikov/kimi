<html>
  <head>
     <title>KIMI-Plus - IPM-BatchCheck1</title>
  </head>
  <body>
  <h1>KIMI-Plus -  IPM-BatchCheck1</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "IPM-BatchCheck1 - Start: ".$heute;
// 1) Anzahl durchgeführter Stichtagsbuchungen
$query_tmp_stichtage = "select count(*) anzahl from tmp_stichtag";


//
echo "<br><br><b>1) Pr&uuml;fung durchgeführte Stichtage nach TMP_STICHTAG:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  
$result = mysql_query($query_tmp_stichtage);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
    echo "<br>";
    if ($line['anzahl'] > 0)
      {
       echo "<br><b><font color='#00C000'>ANZAHL STICHTAGE</font></b>&nbsp;durchgeführte Stichtage nach TMP_STICHTAG: ".$line['anzahl']."<br>";
    }
     else {
       echo "<b><font color='#FF0000'>KEINE STICHTAGE FEHLER???</font></b><br>";
    }

 ?>
 
 <?PHP 

}
 echo "<br>Ende: ".date("d.m.Y H:i:s");  
//



  //

mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>IPM-BatchCheck1- Ende: ".$heute;

?>
</body>    
</html>
