<html>
  <head>
     <title>KIMI-Plus - aktuellen Verwaltungssatz anzeigen</title>
  </head>
  <body>
  <h1>KIMI-Plus -  aktuellen Verwaltungssatz anzeigen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "aktuellen Verwaltungssatz anzeigen - Start: ".$heute;
// Verwaltungssatz
$query_vws = "select 1,'id','mandant_id','markt','kz_aktuell','buchungsdatum','saldo_gesamt','saldo_tag','geaendert_am','geaendert_von',
'stichtag1','stichtag2','stichtag3','stichtag4','stichtag5','kz_verarbeitet','infos_sa1','infos_sa2_3','ui_sa2_3','lenz_sa2_3','inko_sa2_3','maeser_sa2_3'
UNION
select 
2,id,mandant_id,markt,kz_aktuell,buchungsdatum,saldo_gesamt,saldo_tag,geaendert_am,geaendert_von,
stichtag1,stichtag2,stichtag3,stichtag4,stichtag5,kz_verarbeitet,infos_sa1,infos_sa2_3,ui_sa2_3,lenz_sa2_3,inko_sa2_3,maeser_sa2_3
 from verwaltungssatz 
where kz_aktuell is not null and kz_aktuell <> ''
order by 1,id";
//

echo "<br><br><b>1) Anzeige aktuellen Verwaltungssatz:<br></b>";
echo "Start: ".date("d.m.Y H:i:s");  

//
$result = mysql_query($query_vws);
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$drucksatz= $line['id'].";".$line['mandant_id'].";".$line['markt'].";".$line['kz_aktuell'].";".$line['buchungsdatum'].";".$line['saldo_gesamt'].";".$line['saldo_tag'].";".$line['geaendert_am'].";".$line['geaendert_von'].";".$line['stichtag1'].";".$line['stichtag2'].";".$line['stichtag3'].";".$line['stichtag4'].";".$line['stichtag5'].";".$line['kz_verarbeitet'].";".$line['infos_sa1'].";".$line['infos_sa2_3'].";".$line['ui_sa2_3'].";".$line['lenz_sa2_3'].";".$line['inko_sa2_3'].";".$line['maeser_sa2_3'].";";
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
echo "<br><br>aktuellen Verwaltungssatz anzeigen - Ende: ".$heute;

?>
</body>    
</html>
