<html>
  <head>
     <title>KIMI-Plus - Stichtagsende - KZ-Verarbeitet setzen</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Stichtagsende - KZ-Verarbeitet setzen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Stichtagsende - KZ-Verarbeitet setzen - Start: ".$heute;
// Tabellen Stichtag updaten
$stichtag_upd = "update stichtag 
set kz_verarbeitet = 'J',
geaendert_am = now(),
geaendert_von = 'stichtagende.php'
where kz_verarbeitet = 'I'";
// 
$stichtag_save = "INSERT INTO stichtag_save (
id,mandant_id,stammdaten_id,stichtag,gesamtsaldo,mahnstufe,inkassostatus_id,text,kz_verarbeitet,
geaendert_am,geaendert_von,mahnstufe_neu,gesamtsaldo_neu,Dat_l_kontoauszug_neu,betrag_l_kontoauszug_neu,
mahnbetrag,faelliger_betrag,kontoauszug_art,dat_l_kontoauszug,betrag_l_kontoauszug,dat_l_zahlung
)  SELECT id,mandant_id,stammdaten_id,stichtag,gesamtsaldo,mahnstufe,inkassostatus_id,text,kz_verarbeitet,
geaendert_am,geaendert_von,mahnstufe_neu,gesamtsaldo_neu,Dat_l_kontoauszug_neu,betrag_l_kontoauszug_neu,
mahnbetrag,faelliger_betrag,kontoauszug_art,dat_l_kontoauszug,betrag_l_kontoauszug,dat_l_zahlung
  FROM stichtag";
// 
// Fran - 2016-12-12 $stichtag_trunc = "TRUNCATE table stichtag";
$stichtag_trunc = "delete from stichtag";
// 
echo "<br><br><b>Update Tabelle STICHTAG KZ_VERARBEITET :<br></b>";
if (mysql_query($stichtag_upd))
  {
  echo "&Auml;nderung Tabelle STICHTAG durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
// 
echo "<br><br><b>Sicherung Tabelle STICHTAG in STICHTAG_SAVE :<br></b>";
if (mysql_query($stichtag_save))
  {
  echo "Sicherung Tabelle STICHTAG in STICHTAG_SAVE durchgef&uuml;hrt";
  //
  echo "<br><br><b>TRUNCATE Tabelle STICHTAG:<br></b>";
  if (mysql_query($stichtag_trunc))
    {
    echo "TRUNCATE Tabelle STICHTAG durchgef&uuml;hrt";
    }
  else
    {
    echo "Error creating database: " . mysql_error();
    }  
  }
else
  {
  echo "Error creating database: " . mysql_error();
}
// 

//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Stichtagsende - KZ-Verarbeitet setzen - Ende: ".$heute;

?>
</body>    
</html>
