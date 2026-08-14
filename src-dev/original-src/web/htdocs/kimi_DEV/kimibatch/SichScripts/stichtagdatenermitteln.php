<html>
  <head>
     <title>KIMI-Plus - Stichtagsdaten ermitteln TMP_STICHTAG</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Stichtagsdaten ermitteln TMP_STICHTAG</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "Stichtagsdaten ermitteln TMP_STICHTAG- Start: ".$heute;
// KZ_AKTUELL f�r altuellen Verwaltungssatz setzen
$tmp_stichtag_create_drop = "drop table tmp_stichtag";
// 
// KZ_AKTUELL f�r altuellen Verwaltungssatz setzen
$tmp_stichtag_create = "
create table tmp_stichtag
Select
 1 mandant_id,
st.stammdaten_id ,
st.stichtag,
'Stichtag' geaendert_von,
now() geaendert_am,
s.dat_l_kontoauszug dat_l_kontoauszug_neu,
s.betrag_l_kontoauszug betrag_l_kontoauszug_neu,
s.gesamtsaldo gesamtsaldo_neu,
(select sum(IFNULL(m4,0)+IFNULL(m3,0)+IFNULL(m2,0)+IFNULL(m1,0) ) from subkonto_neu sk
where sk.kz_aktuell = 'J' 
and sk.stammdaten_id = st.stammdaten_id) mahnbetrag_neu,
(select sum(IFNULL(m4,0)+IFNULL(m3,0)+IFNULL(m2,0)+IFNULL(m1,0)+IFNULL(m0,0) ) from subkonto_neu sk
where sk.kz_aktuell = 'J' 
and sk.stammdaten_id = st.stammdaten_id) faelliger_betrag_neu,
(select 
case 
when sum(IFNULL(sk.m4,0)) > 0 then 4
when sum(IFNULL(sk.m3,0)) > 0 then 3
when sum(IFNULL(sk.m2,0)) > 0 then 2
when sum(IFNULL(sk.m1,0)) > 0 then 1
else 0
end 
from subkonto_neu sk
where sk.kz_aktuell = 'J' 
and sk.stammdaten_id = st.stammdaten_id) sk_mahnstufe_neu,
'XXXX' kontoauszugart,
s.ktonr
from stichtag st
join stammdaten s on s.id = st.stammdaten_id
join (
select distinct b.stammdaten_id
from buchungen b
join kunde k on k.id = b.stammdaten_id
where 
b.buchungsdatum >= (
/* anpassen !!!*/
select vw.buchungsdatum from verwaltungssatz vw
where vw.kz_aktuell = 'J' and vw.markt = k.markt )
and 
substr(b.bua_bgr_man_id,-4) = 4000) b on b.stammdaten_id = s.id
where  `kz_verarbeitet` is null
";
// 
// Datum Letzter Kontoauszug setzen - =Buchungstag
$tmp_stichtag_datlkto = "
update tmp_stichtag tst
set tst.dat_l_kontoauszug_neu = 
case 
when tst.sk_mahnstufe_neu = 4 then (SELECT vw.buchungsdatum FROM verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt  = 10)
when tst.sk_mahnstufe_neu = 3 then (SELECT vw.buchungsdatum FROM verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt  = 10)
when tst.sk_mahnstufe_neu = 2 then (SELECT vw.buchungsdatum FROM verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt  = 10)
when tst.sk_mahnstufe_neu = 1 then (SELECT vw.buchungsdatum FROM verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt  = 10)
when tst.sk_mahnstufe_neu = 0 and
date_add(dat_l_kontoauszug_neu, INTERVAL 3 MONTH) <= DATE_ADD(CURDATE() , INTERVAL 2 DAY) and 
(select s.lastschrift from stammdaten s where s.id = tst.stammdaten_id) ='J' then (SELECT vw.buchungsdatum FROM verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt  = 10)
when date_add(dat_l_kontoauszug_neu, INTERVAL 3 MONTH) <= DATE_ADD(CURDATE() , INTERVAL 2 DAY) then (SELECT vw.buchungsdatum FROM verwaltungssatz vw where vw.kz_aktuell = 'J' and vw.markt  = 10)
else dat_l_kontoauszug_neu
end
";
// 
// Betreg Letzter Kontoauszug setzen
$tmp_stichtag_betrlkto = "
update tmp_stichtag tst
set tst.betrag_l_kontoauszug_neu = 
case 
when tst.sk_mahnstufe_neu = 4 then tst.gesamtsaldo_neu
when tst.sk_mahnstufe_neu = 3 then tst.gesamtsaldo_neu 
when tst.sk_mahnstufe_neu = 2 then tst.gesamtsaldo_neu
when tst.sk_mahnstufe_neu = 1 then tst.gesamtsaldo_neu
when tst.sk_mahnstufe_neu = 0 and
date_add(dat_l_kontoauszug_neu, INTERVAL 3 MONTH) <= DATE_ADD(CURDATE() , INTERVAL 2 DAY) and 
(select s.lastschrift from stammdaten s where s.id = tst.stammdaten_id) = 'J' then tst.gesamtsaldo_neu
when date_add(dat_l_kontoauszug_neu, INTERVAL 3 MONTH) <= DATE_ADD(CURDATE() , INTERVAL 2 DAY) then tst.gesamtsaldo_neu
else betrag_l_kontoauszug_neu
end

";
// KZ Kontoauszug setzen
$tmp_stichtag_kzktoa = "
update tmp_stichtag tst
set tst.kontoauszugart = 
case 
when tst.sk_mahnstufe_neu = 4 then 'M4'
when tst.sk_mahnstufe_neu = 3 then 'M3'
when tst.sk_mahnstufe_neu = 2 then 'M2'
when tst.sk_mahnstufe_neu = 1 then 'M1'
when tst.sk_mahnstufe_neu = 0 and
date_add(dat_l_kontoauszug_neu, INTERVAL 3 MONTH) <= DATE_ADD(CURDATE() , INTERVAL 2 DAY) and
(select s.lastschrift from stammdaten s where s.id = tst.stammdaten_id) = 'J' then 'KAAB'
when date_add(dat_l_kontoauszug_neu, INTERVAL 3 MONTH) <= DATE_ADD(CURDATE() , INTERVAL 2 DAY) then 'KA'
else 'X'
end
";
// 
echo "<br><br><b>Drop Tabelle TMP_STICHTAG :<br></b>";
if (mysql_query($tmp_stichtag_create_drop))
  {
  echo "DROP TABLE TMP_STICHTAG durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//
// 
echo "<br><br><b>Create TABLE TMP_STICHTAG :<br></b>";
if (mysql_query($tmp_stichtag_create))
  {
  echo "CREATE TABLE TMP_STICHTAG durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//
// 
echo "<br><br><b>KZ Kontoauszug setzen :<br></b>";
if (mysql_query($tmp_stichtag_kzktoa))
  {
  echo "KZ Kontoauszug durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//
// 
echo "<br><br><b>Betrag letzter Kontoauszug setzen :<br></b>";
if (mysql_query($tmp_stichtag_betrlkto))
  {
  echo "Betrag letzter Kontoauszug durchgef&uuml;uhrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
//
// 
echo "<br><br><b>Datum letzter Kontoauszug setzen :<br></b>";
if (mysql_query($tmp_stichtag_datlkto))
  {
  echo "Datum letzter Kontoauszug durchgef&uuml;hrt";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }
// 


mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br>Stichtagsdaten ermitteln TMP_STICHTAG - Ende: ".$heute;

?>
</body>    
</html>
