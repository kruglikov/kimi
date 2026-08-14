<html>
  <head>
     <title>KIMI-Plus - Stichtagsdaten speichern Tabelle Stichtag</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Stichtagsdaten speichern Tabelle Stichtag</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Stichtagsdaten speichern Tabelle Stichtag - Start: ".$heute;
	// Kein Kontoauszug bei Mahnsperre
	$stichtag_ms = "update stichtag st
	JOIN stammdaten s on s.id = st.stammdaten_id
	set kz_verarbeitet = 'M'
	where s.mahnsperre = 'MS'
	and kz_verarbeitet = 'I'";
// Kein Kontoauszug bei Saldo < 5
$stichtag_saldo = "
update stichtag st
JOIN stammdaten s on s.id = st.stammdaten_id
set kz_verarbeitet = 'S'
where IFNULL(st.gesamtsaldo,0) < 5
and kz_verarbeitet = 'I';";
// 
// Tabellen Stichtag updaten
$stichtag_upd = "update stichtag 
set 
kz_verarbeitet = 'I',
mahnstufe_neu = (select sk_mahnstufe_neu from tmp_stichtag tst where tst.stammdaten_id = stichtag.stammdaten_id),
dat_l_kontoauszug_neu = (select dat_l_kontoauszug_neu from tmp_stichtag tst where tst.stammdaten_id = stichtag.stammdaten_id),
betrag_l_kontoauszug_neu = (select betrag_l_kontoauszug_neu from tmp_stichtag tst where tst.stammdaten_id = stichtag.stammdaten_id),
gesamtsaldo_neu = (select gesamtsaldo_neu from tmp_stichtag tst where tst.stammdaten_id = stichtag.stammdaten_id),
mahnbetrag = (select mahnbetrag_neu from tmp_stichtag tst where tst.stammdaten_id = stichtag.stammdaten_id),
faelliger_betrag = (select faelliger_betrag_neu from tmp_stichtag tst where tst.stammdaten_id = stichtag.stammdaten_id),
kontoauszug_art = (select kontoauszugart from tmp_stichtag tst where tst.stammdaten_id = stichtag.stammdaten_id),
geaendert_von = 'stichdatenspeichern.php',
geaendert_am = NOW()
where kz_verarbeitet is null";
// Kein Kontoauszug bei GA gesperrte Adresse
$stichtag_ga = 
"update stichtag st
JOIN stammdaten s on s.id = st.stammdaten_id
join kunde k on k.id = s.id
set kz_verarbeitet = 'G'
where k.kenner like  '%GA%'
and kz_verarbeitet = 'I'";

// 
echo "<br><br><b>Update Tabelle STICHTAG mit Daten TMP_STICHTAG2 :<br></b>";
if (mysql_query($stichtag_upd))
  {
  echo "&Auml;nderung Tabelle STICHTAG durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//
echo "<br><br><b>Update KEIN KONTOAUSZUG bei Mahnsperre:<br></b>";
if (mysql_query($stichtag_ms))
  {
  echo "&Auml;nderung Tabelle STICHTAG KEIN KONTOAUSZUG bei Mahnsperre durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//
echo "<br><br><b>Update KEIN KONTOAUSZUG bei Saldo < 5:<br></b>";
if (mysql_query($stichtag_saldo))
  {
  echo "&Auml;nderung Tabelle STICHTAG KEIN KONTOAUSZUG bei Saldo < 5 durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//  
//
echo "<br><br><b>Update KEIN KONTOAUSZUG bei GA < 5:<br></b>";
if (mysql_query($stichtag_ga))
  {
  echo "&Auml;nderung Tabelle STICHTAG KEIN KONTOAUSZUG bei GA durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
  
  
//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Stichtagsdaten speichern Tabelle Stichtag - Ende: ".$heute;

?>
</body>    
</html>
