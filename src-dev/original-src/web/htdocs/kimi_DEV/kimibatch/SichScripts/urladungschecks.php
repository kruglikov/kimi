<html>
  <head>
     <title>KIMI-Plus - Urladungscheck</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Urladungscheck</h1>
<?PHP 
include_once ('db.php');
//

$heute = date("d.m.Y H:i:s");    
echo "Buchungsjournal - Start: ".$heute;
// 
$query1 = "select markt,
count(*) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
join kunde k on k.id = s.kunde_id
where s.gesamtsaldo >0
group by k.markt
";
// 
$query2 = "select markt,
count(*) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
join kunde k on k.id = s.kunde_id
where s.gesamtsaldo <0
group by k.markt
";
// 
$query3 = "select markt,
count(*) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) between 0 and 10
group by k.markt
";
// 
$query4 = "select 
markt,
case 
  when  s.inkassostatus_id between 03 and 89 then 'offen'
  when  s.inkassostatus_id between 90 and 91 then 'erledigt'
  else null
end inkassostatus,
count(*) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
join kunde k on k.id = s.kunde_id
where s.inkassostatus_id between 03 and 91
group by k.markt,
case
  when  s.inkassostatus_id between 03 and 89 then 'offen'
  when  s.inkassostatus_id between 90 and 91 then 'erledigt'
  else null
end
";
// 
$query5 = "select 
markt,
s.krsv,
count(*) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
join kunde k on k.id = s.kunde_id
group by k.markt,s.krsv";
// 
$query6 = "select 
markt,
REPLACE(CAST(sum(IFNULL(s.betrag_l_auslagerung,0)) AS CHAR), '.', ',') betrag_l_auslagerung , 
count(*) anzahl
from stammdaten s
join kunde k on k.id = s.kunde_id
group by k.markt";
// 
$query7 = "select 
markt,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo, 
count(*) anzahl
from stammdaten s
join kunde k on k.id = s.kunde_id
group by k.markt";
// 
$query8 = "select 
s.ktonr,
REPLACE(CAST(IFNULL(gesamtsaldo,0) AS CHAR), '.', ',') gesamtsaldo ,
REPLACE(CAST(IFNULL(sk2.sumsaldo,0) AS CHAR), '.', ',') sumsaldo ,
REPLACE(CAST(IFNULL(summ4,0) AS CHAR), '.', ',') summ4 ,
REPLACE(CAST(IFNULL(summ3,0) AS CHAR), '.', ',') summ3 ,
REPLACE(CAST(IFNULL(summ2,0) AS CHAR), '.', ',') summ2 ,
REPLACE(CAST(IFNULL(summ1,0) AS CHAR), '.', ',') summ1 ,
REPLACE(CAST(IFNULL(summ0,0) AS CHAR), '.', ',') summ0 ,
REPLACE(CAST(IFNULL(sumrest,0) AS CHAR), '.', ',') sumrest
from stammdaten s
join (select sk.stammdaten_id,sum(IFNULL(sk.m4,0)) summ4,sum(IFNULL(sk.m3,0)) summ3,sum(IFNULL(sk.m2,0)) summ2,sum(IFNULL(sk.m1,0)) summ1,sum(IFNULL(sk.m0,0)) summ0, sum(IFNULL(sk.rest,0)) sumrest,
sum(IFNULL(sk.m4,0))+sum(IFNULL(sk.m3,0))+sum(IFNULL(sk.m2,0))+sum(IFNULL(sk.m1,0))+sum(IFNULL(sk.m0,0))+ sum(IFNULL(sk.rest,0)) sumtoepfe,sum(IFNULL(sk.saldo,0)) sumsaldo
from subkonto_neu sk where sk.kz_aktuell = 'J'
group by sk.stammdaten_id) sk2 on sk2.stammdaten_id = s.id
where  s.gesamtsaldo<>sk2.sumsaldo";
// 
// 
$query9 = "select 'x','KDNR','MDA','MARKT','VORN','NACHN','GESCHL','SALDO','M0' ,'M1' ,'M2' ,'M3' ,'M4' ,'M14' ,'REST','KDART',
'STICHTAG','ZAHLTAG','RATE','RATE_A','RLZ','MSPERRE'
from dual
UNION
select 
'X' s1,
s.ktonr KDNR,
/* i.inkassostatus_id, */
case
when IFNULL(gesamtsaldo,0) > 0 and (IFNULL(i.inkassostatus_id,0) < 3  or IFNULL(i.inkassostatus_id,0) > 99) then 'Aktivkonto'
when IFNULL(gesamtsaldo,0) < 0 then 'Guthabenkonto'
when IFNULL(i.inkassostatus_id,0) between 3 and 89   then 'Inkassokonto - offen'
when IFNULL(i.inkassostatus_id,0) in (90, 91)  then 'Inkassokonto - geschlossen'
when IFNULL(gesamtsaldo,0) = 0 then 'SonderkontoSaldo0'
else 'Rest'
end mda,
k.markt markt,
k.vorname vorn,
k.nachname nachn,
IFNULL(k.geschlecht1,'') geschl,
REPLACE(CAST(IFNULL(s.gesamtsaldo,0) AS CHAR), '.', ',') saldo ,
REPLACE(CAST(IFNULL(summ0,0) AS CHAR), '.', ',') m0 ,
REPLACE(CAST(IFNULL(summ1,0) AS CHAR), '.', ',') m1 ,
REPLACE(CAST(IFNULL(summ2,0) AS CHAR), '.', ',') m2 ,
REPLACE(CAST(IFNULL(summ3,0) AS CHAR), '.', ',') m3 ,
REPLACE(CAST(IFNULL(summ4,0) AS CHAR), '.', ',') m4 ,
REPLACE(CAST((IFNULL(summ1,0)+IFNULL(summ2,0)+IFNULL(summ3,0)+IFNULL(summ4,0)) AS CHAR), '.', ',') m14 ,
REPLACE(CAST(IFNULL(sumrest,0) AS CHAR), '.', ',') rest,
k.kundenart kdart,
DATE_FORMAT(s.stichtag, '%d.%m.%Y') stichtag,
DATE_FORMAT(s.zahltag, '%d.%m.%Y') zahltag,
REPLACE(CAST(IFNULL(s.ratenhoehe,0) AS CHAR), '.', ',') rate,
REPLACE(CAST(IFNULL(s.offene_raten,0) AS CHAR), '.', ',') rate_a,
REPLACE(CAST(IFNULL(s.ratenanzahl,0) AS CHAR), '.', ',') rlz,
IFNULL(s.mahnsperre,'') msperre /*,
REPLACE(CAST(IFNULL(sk2.sumsaldo,0) AS CHAR), '.', ',') sumsaldo */
from stammdaten s
join kunde k on k.id = s.kunde_id
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join (select sk.stammdaten_id,sum(IFNULL(sk.m4,0)) summ4,sum(IFNULL(sk.m3,0)) summ3,sum(IFNULL(sk.m2,0)) summ2,sum(IFNULL(sk.m1,0)) summ1,sum(IFNULL(sk.m0,0)) summ0, sum(IFNULL(sk.rest,0)) sumrest,
sum(IFNULL(sk.m4,0))+sum(IFNULL(sk.m3,0))+sum(IFNULL(sk.m2,0))+sum(IFNULL(sk.m1,0))+sum(IFNULL(sk.m0,0))+ sum(IFNULL(sk.rest,0)) sumtoepfe,sum(IFNULL(sk.saldo,0)) sumsaldo
from subkonto_neu sk where sk.kz_aktuell = 'J'
group by sk.stammdaten_id) sk2 on sk2.stammdaten_id = s.id
";
// 
$query10 = "select 'MDA','ANZAHL','GESAMTSALDO' 
union
select 'Aktivkonto',
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) >0
and (IFNULL(i.inkassostatus_id,0) < 3  or IFNULL(i.inkassostatus_id,0) > 99) 
union
select 'Kleinstsaldo',
cast(count(*) as CHAR)anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where (IFNULL(s.gesamtsaldo,0) >0 and IFNULL(s.gesamtsaldo,0) < 10)
and (IFNULL(i.inkassostatus_id,0) < 3  or IFNULL(i.inkassostatus_id,0) > 99) 
union
select 'Guthaben',
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) <0 
UNION
select 'Inkassokonto - offen',
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(i.inkassostatus_id,0) between 3 and 89
UNION
select 'Inkassokonto - erledigt',
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(i.inkassostatus_id,0) in (90, 91)
UNION
select 'Kundenkonten migriert gesamt',
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
UNION
select 'Cardif-Konten',
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) <> 0
and NOT IFNULL(s.krsv,9) = 9 /* NULL ODER 9=Storno) ist keine aktive Versicherung */
union
select 'InkassoGuthaben',
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where (s.gesamtsaldo <0 )
and IFNULL(i.inkassostatus_id,0) = 91 
union
select 'AktivkontoSaldo=0',
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) =0
and (IFNULL(i.inkassostatus_id,0) < 3  or IFNULL(i.inkassostatus_id,0) > 89) 
";
// 
$query11 = "select 'MDA','MARKT','ANZAHL','GESAMTSALDO' 
union
select 'Aktivkonto',
k.markt markt,
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) >0
and (IFNULL(i.inkassostatus_id,0) < 3  or IFNULL(i.inkassostatus_id,0) > 89) 
group by markt
union
select 'Kleinstsaldo',
k.markt markt,
cast(count(*) as CHAR)anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where (IFNULL(s.gesamtsaldo,0) >0 and IFNULL(s.gesamtsaldo,0) <= 10)
and (IFNULL(i.inkassostatus_id,0) < 3  or IFNULL(i.inkassostatus_id,0) > 99) 
group by markt
union
select 'Guthaben',
k.markt markt,
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) <0 
group by markt
UNION
select 'Inkassokonto - offen',
k.markt markt,
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(i.inkassostatus_id,0) between 3 and 89
group by markt
UNION
select 'Inkassokonto - erledigt',
k.markt markt,
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(i.inkassostatus_id,0) in (90, 91)
group by markt
UNION
select 'Kundenkonten migriert gesamt',
k.markt markt,
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
group by markt
UNION
select 'Cardif-Konten',
k.markt markt,
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) <> 0
and NOT IFNULL(s.krsv,9) = 9 /* NULL ODER 9=Storno) ist keine aktive Versicherung */
group by markt
union
select 'InkassoGuthaben',
k.markt markt,
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where (s.gesamtsaldo <0 )
and IFNULL(i.inkassostatus_id,0) = 91 
group by markt
union
select 'AktivkontoSaldo=0',
k.markt markt,
cast(count(*) as CHAR) anzahl,
REPLACE(CAST(sum(IFNULL(gesamtsaldo,0)) AS CHAR), '.', ',') gesamtsaldo 
from stammdaten s
left outer join inkassoinformation i on 
i.kundennummer= s.ktonr and 
i.status_dat = s.status_dat and 
i.inkassostatus_id = s.inkassostatus_id 
and i.ra_ikbuero_id = s.ra_ikbuero_id
join kunde k on k.id = s.kunde_id
where IFNULL(s.gesamtsaldo,0) =0
and (IFNULL(i.inkassostatus_id,0) < 3  or IFNULL(i.inkassostatus_id,0) > 99) 
group by markt
";
//Auswertung 1 //
//
$titel='<br><br><b>1) Anzahl und offener Saldo aktiv konten (&Ouml;sterreich, S&uuml;dtirol):</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//
/*$result = mysql_query($query1);*/
$result = mysql_query($query1)
   or die ("MySQL-Error: " . mysql_error());  
echo "<br>".'markt;anzahl,gesamtsaldo';
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['markt'].";".$line['anzahl'].";".$line['gesamtsaldo'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//Auswertung 2 //
//
$titel='<br><br><b>2) Anzahl und offener Saldo Guthabenkonten (&Ouml;sterreich, S&uuml;dtirol):</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query2);
$result = mysql_query($query2)
   or die ("MySQL-Error: " . mysql_error());  

echo "<br>".'markt;anzahl,gesamtsaldo';
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['markt'].";".$line['anzahl'].";".$line['gesamtsaldo'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//Auswertung 3 //
//
$titel='<br><br><b>3) Anzahl und offener Saldo Kleinstsalden (&Ouml;sterreich, S&uuml;dtirol):</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query3);
$result = mysql_query($query3)
   or die ("MySQL-Error: " . mysql_error());  

echo "<br>".'markt;anzahl,gesamtsaldo';
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['markt'].";".$line['anzahl'].";".$line['gesamtsaldo'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//Auswertung 4 //
//
$titel='<br><br><b>4) Anzahl und offener Saldo Inkassokonten offen/erledigt (&Ouml;sterreich, S&uuml;dtirol):</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query4);
$result = mysql_query($query4)
   or die ("MySQL-Error: " . mysql_error());  

echo "<br>".'markt;inkassostatus;anzahl,gesamtsaldo';
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['markt'].";".$line['inkassostatus'].";".$line['anzahl'].";".$line['gesamtsaldo'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//Auswertung 5 //
//
$titel='<br><br><b>5) Anzahl und offener Saldo Cardif (&Ouml;sterreich)  ist in  S&uuml;dtirol NICHT :</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query5);
$result = mysql_query($query5)
   or die ("MySQL-Error: " . mysql_error());  

echo "<br>".'markt;krsv;anzahl,gesamtsaldo';
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['markt'].";".$line['krsv'].";".$line['anzahl'].";".$line['gesamtsaldo'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//Auswertung 6 //
//
$titel='<br><br><b>6) Ursprungssaldo (&Ouml;sterreich, S&uuml;dtirol):</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query6);
$result = mysql_query($query6)
   or die ("MySQL-Error: " . mysql_error());  

echo "<br>".'markt;betrag_l_auslagerung;anzahl';
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['markt'].";".$line['betrag_l_auslagerung'].";".$line['anzahl'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//Auswertung 7 //
//
$titel='<br><br><b>7) &uuml;bernommener offener Gesamtsaldo (&Ouml;sterreich, S&uuml;dtirol):</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query7);
$result = mysql_query($query7)
   or die ("MySQL-Error: " . mysql_error());  

echo "<br>".'markt;inkassostatus;anzahl,gesamtsaldo';
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['markt'].";".$line['inkassostatus'].";".$line['anzahl'].";".$line['gesamtsaldo'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//Auswertung 8 //
//
$titel='<br><br><b>8)offener Saldo Mahnt&ouml;pfe:</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query8);
$result = mysql_query($query8)
   or die ("MySQL-Error: " . mysql_error());  

echo "<br>".'ktonr;gesamtsaldo;sumsaldo;summ4;summ3;summ2;summ1;summ0;sumrest';
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['ktonr'].";".$line['gesamtsaldo'].";".$line['sumsaldo'].";".$line['summ4'].";".$line['summ3'].";".$line['summ2'].";".$line['summ1'].";".$line['summ0'].";".$line['sumrest'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//Auswertung 9 //
//
$titel='<br><br><b>9) Kennzahlen pro Konto</b>';
echo "<br>".$titel;
//echo "<br>".'RowNumber;ktonr;abrechnungstag;ratenhoehe;offene_raten;ratenanzahl';
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query9);
$result = mysql_query($query9)
   or die ("MySQL-Error: " . mysql_error());  

//
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['KDNR'].";".$line['MDA'].";".$line['MARKT'].";".$line['VORN'].";".$line['NACHN'].";".$line['GESCHL'].";".$line['SALDO'].";".$line['M0'].";".$line['M1'].";".$line['M2'].";".$line['M3'].";".$line['M4'].";".$line['M14'].";".$line['REST'].";".$line['KDART'].";".$line['STICHTAG'].";".$line['ZAHLTAG'].";".$line['RATE'].";".$line['RATE_A'].";".$line['RLZ'].";".$line['MSPERRE'].";";
//$ausgabe= ";".$line['MDA'].";".$line['MARKT'].";".$line['VORN'].";".$line['NACHN'].";".$line['GESCHL'].";".$line['SALDO'].";".$line['M0'].";".$line['M1'].";".$line['M2'].";".$line['M3'].";".$line['M4'].";".$line['M14'].";".$line['REST'].";".$line['KDART'].";".$line['STICHTAG'].";".$line['ZAHLTAG'].";".$line['RATE'].";".$line['RATE_A'].";".$line['RLZ'].";".$line['MSPERRE'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//

//
//
//Auswertung 10 //
//
$titel='<br><br><b>10) Kennzahlen_Gesamtsumme</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query10);
$result = mysql_query($query10)
   or die ("MySQL-Error: " . mysql_error());  

//
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['MDA'].";".$line['ANZAHL'].";".$line['GESAMTSALDO'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//
//Auswertung 11 //
//
$titel='<br><br><b>11) Kennzahlen_Gesamtsumme inkl. Markt</b>';
echo "<br>".$titel;
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Start: <br>".$heute;
//
//$result = mysql_query($query11);
$result = mysql_query($query11)
   or die ("MySQL-Error: " . mysql_error());  

//
while ($line = mysql_fetch_array($result)) { ?>
<?PHP
$ausgabe= $line['MDA'].";".$line['MARKT'].";".$line['ANZAHL'].";".$line['GESAMTSALDO'].";";
echo "<br>".$ausgabe;

 ?>
 <?PHP 
 
}
mysql_free_result($result);
//
$heute = date("d.m.Y H:i:s");    
echo "<br><br>Ende ___________________________________________________________________- ".$heute;
//
//
mysql_close();

$heute = date("d.m.Y H:i:s");    
echo "<br><br>Urladungscheck - Ende: ".$heute;

?>

</body>    
</html>
