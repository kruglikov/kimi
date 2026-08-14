	<html>
  <head>
     <title>KIMI-Plus - Zahlungen einspielen</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Zahlungen einspielen</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Zahlungen einspielen - Start: ".$heute;
// KZ_AKTUELL f�r altuellen Verwaltungssatz setzen
$zahlungen_ins = "INSERT INTO buchungen 
(stammdaten_id,bua_bgr_man_id,betrag,buchungsdatum,valutadatum,
mwst_id,zahlart_id,geaendert_am,geaendert_von,buchungskennzeichen,mwst_20,mwst_0,mwst_10,
spesen,rabatt,verguetung,ratenhoehe,auftragsnummer,kz_manbuchung,herkunft,kz_gebucht)
SELECT
(select id from kunde where LPAD(kdnr,8,'0') = LPAD(z.kundennummer,8,'0')) stammdaten_id,
CONCAT('110', lpad(z.ba,2,0), substr(lpad(z.bg,2,0),-2)) bua_bug_man_id,
z.betrag betrag,
(select vw.buchungsdatum from verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt = 10) buchungsdatum,
z.belegdatum valutadatum,
2 mwst_id,
NULL zahlart_id,
now() geaendert_am,
'system' geaendert_von,
0 buchungskennzeichen,
z.betrag mwst_20,
NULL mwst_0,
NULL mwst_10,
NULL spesen,
NULL rabatt,
NULL verguetung,
NULL ratenhoehe,
NULL auftragsnummer,
'N' kz_manbuchung,
herkunft herkunft,
NULL kz_gebucht
From zahlungen z
where  LPAD(z.kundennummer,8,'0') in (select LPAD(kundennummer,8,'0') from kunde k 
                         join zahlungen z2 on LPAD(k.kdnr,8,'0') = LPAD(z2.kundennummer,8,'0'))";
// 


// 
echo "<br><br><b>Insert Zahlungen in Buchungen  :<br></b>";
if (mysql_query($zahlungen_ins))
  {
  echo "Insert Zahlungen in Buchungen durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//mysql_free_result($result);
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Zahlungen einspielen   - Ende: ".$heute;

?>
</body>    
</html>
