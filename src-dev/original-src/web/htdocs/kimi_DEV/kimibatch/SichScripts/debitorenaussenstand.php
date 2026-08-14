<html>
  <head>
     <title>KIMI-Plus - Debitorenaussenstand</title>
  </head>
  <body>
  <h1>KIMI-Plus -  Debitorenaussenstand</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "Debitorenaussenstand - Start: ".$heute;

/* ORIGINAL - View DEVIS
CREATE OR REPLACE VIEW V_STAT_GESAMTSALDEN AS
SELECT 'Gesamtsaldo' Beschreibung, k.markt Markt, COUNT (*) Anzahl_Datensaetze, SUM(bl_dk_salden.f_get_sum_gesamtsaldo(k.kunde_oid)) saldo, SYSDATE Laufdatum
FROM kundensuche k
  WHERE bl_dk_salden.f_get_sum_gesamtsaldo(k.kunde_oid) > 0
GROUP BY k.markt
UNION ALL
SELECT 'Saldo 1X-Kunden' AS Beschreibung, k.markt, COUNT (*) Anzahl_Datensaetze,  SUM(bl_dk_salden.f_get_sum_gesamtsaldo(k.kunde_oid)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) > 0
AND
(SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.ID = 14) = 0  -- RV
AND  (SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.ID = 12) > 0 -- 1x
GROUP BY k.markt
UNION ALL
SELECT 'Saldo RV-Kunden' AS Beschreibung, k.markt, COUNT (*) Anzahl_Datensaetze, SUM(bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) > 0
AND
(SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.id = 14) > 0  -- RV
AND  (SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.id = 12) = 0 -- 1x
GROUP BY k.markt
UNION ALL
SELECT 'Saldo Mischkonten' AS Beschreibung, k.markt, COUNT (*) Anzahl_Datensaetze, SUM(bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) > 0
AND
(SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.id = 14) > 0
AND  (SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.id = 12) > 0
GROUP BY k.markt
UNION ALL
SELECT '1X-Saldo Mischkonten' AS Beschreibung, k.markt, 0 Anzahl_Datensaetze, SUM((select sum(nvl(sk.gesamtsaldo,0)) from subkonten sk JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid where sk.adr_id=k.kunde_oid and tz.id=12)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) > 0
AND
(SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.id = 14) > 0
AND  (SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.id = 12) > 0
GROUP BY k.markt
union all
SELECT 'RV-Saldo Mischkonten' AS Beschreibung, k.markt, 0 Anzahl_Datensaetze, SUM((select sum(nvl(sk.gesamtsaldo,0)) from subkonten sk JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid where sk.adr_id=k.kunde_oid and tz.id=14)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) > 0
AND
(SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.id = 14) > 0
AND  (SELECT COUNT(*) anzahl
      FROM subkonten sk
      JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid
      JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid
     WHERE sk.adr_id = k.kunde_oid
       AND sk.datum_kto_geschl IS NULL
       and tz.id = 12) > 0
GROUP BY k.markt
UNION ALL
SELECT 'davon Saldo Inkassokunden' AS Beschreibung, k.markt, COUNT (*) Anzahl_Datensaetze, SUM(bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) > 0
AND k.kunde_oid IN
(SELECT i.kunde_oid FROM inkassoinformation i
JOIN t_inkassostatus ink ON ink.ID = i.t_inkasso_status_oid
WHERE  nvl(ink.inkassostatus, 0) BETWEEN 3 AND 89
GROUP BY i.kunde_oid, i.anz_uebergab
HAVING i.anz_uebergab = (SELECT MAX(i2.anz_uebergab) FROM inkassoinformation i2 WHERE i2.kunde_oid = i.kunde_oid))
GROUP BY k.markt
union all
SELECT 'davon 1X-Saldo Inkassokunden' AS Beschreibung, k.markt, 0 Anzahl_Datensaetze, 
SUM((select sum(nvl(sk.gesamtsaldo,0)) from subkonten sk JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid where sk.adr_id=k.kunde_oid and tz.id=12)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) > 0
AND k.kunde_oid IN
(SELECT i.kunde_oid FROM inkassoinformation i
JOIN t_inkassostatus ink ON ink.ID = i.t_inkasso_status_oid
WHERE  nvl(ink.inkassostatus, 0) BETWEEN 3 AND 89
GROUP BY i.kunde_oid, i.anz_uebergab
HAVING i.anz_uebergab = (SELECT MAX(i2.anz_uebergab) FROM inkassoinformation i2 WHERE i2.kunde_oid = i.kunde_oid))
GROUP BY k.markt
union all
SELECT 'davon RV-Saldo Inkassokunden' AS Beschreibung, k.markt, 0 Anzahl_Datensaetze, 
SUM((select sum(nvl(sk.gesamtsaldo,0)) from subkonten sk JOIN t_Zahlungsart_Markt tm ON tm.ID = sk.t_zahlungsart_markt_oid JOIN t_zahlungsart tz ON tz.ID = tm.t_zahlungsart_oid where sk.adr_id=k.kunde_oid and tz.id=14)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) > 0
AND k.kunde_oid IN
(SELECT i.kunde_oid FROM inkassoinformation i
JOIN t_inkassostatus ink ON ink.ID = i.t_inkasso_status_oid
WHERE  nvl(ink.inkassostatus, 0) BETWEEN 3 AND 89
GROUP BY i.kunde_oid, i.anz_uebergab
HAVING i.anz_uebergab = (SELECT MAX(i2.anz_uebergab) FROM inkassoinformation i2 WHERE i2.kunde_oid = i.kunde_oid))
GROUP BY k.markt
UNION ALL
SELECT 'Guthaben' AS Beschreibung, k.markt, COUNT (*) Anzahl_Datensaetze, SUM(bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid)) saldo, SYSDATE
FROM kundensuche k
WHERE bl_dk_salden.f_get_sum_Gesamtsaldo(k.kunde_oid) < 0
GROUP BY k.markt
*/

$query = "SELECT 
'Gesamtsaldo' beschreibung,
k.markt markt, 
count(distinct k.kdnr) anzahl_datensaetze,  
REPLACE(CAST(IFNULL(SUM(IFNULL(sk.saldo,0)),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join subkonto_neu sk on sk.stammdaten_id = k.id
WHERE IFNULL(sk.saldo,0) > 0 and sk.kz_aktuell = 'J'
GROUP BY k.markt
UNION
SELECT 
'Saldo 1X-Kunden' beschreibung, 
k.markt markt, 
COUNT(distinct k.kdnr) anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(
case 
when sk.kz_aktuell  = 'J' then IFNULL(sk.saldo,0)
else 0
end
),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join subkonto_neu sk on sk.stammdaten_id = k.id
WHERE IFNULL(sk.saldo,0) > 0  
AND
(SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
       and z.text= 'RV') = 0  
AND  (SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
       and z.text= '1X') > 0 
GROUP BY k.markt
UNION
SELECT 
'Saldo RV-Kunden' beschreibung, 
k.markt markt, 
COUNT(distinct k.kdnr) anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(
case 
when sk.kz_aktuell  = 'J' then IFNULL(sk.saldo,0)
else 0
end
),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join subkonto_neu sk on sk.stammdaten_id = k.id
WHERE IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
AND
(SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
       and z.text= 'RV') > 0 
AND  (SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
       and z.text= '1X') = 0 
GROUP BY k.markt
UNION
SELECT 
'Saldo Mischkonten' beschreibung, 
k.markt markt, 
COUNT(distinct k.kdnr) anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(
case 
when sk.kz_aktuell  = 'J' then IFNULL(sk.saldo,0)
else 0
end
),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join subkonto_neu sk on sk.stammdaten_id = k.id
WHERE IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
AND
(SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
       and z.text= 'RV') > 0 
AND  (SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) >0 and sk.kz_aktuell = 'J'
       and z.text= '1X') > 0 
GROUP BY k.markt
UNION
SELECT 
'1X-Saldo Mischkonten' beschreibung, 
k.markt markt, 
NULL anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(
(select sum(
case 
when sk2.kz_aktuell  = 'J' then IFNULL(sk2.saldo,0)
else 0
end
) from subkonto_neu sk2 
JOIN zahlart z2 on z2.id = sk2.zahlart_id where sk2.stammdaten_id=k.id and z2.text = '1X')
),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join stammdaten s on s.ktonr = k.id
WHERE IFNULL(s.gesamtsaldo,0) > 0
AND
(SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0   and sk.kz_aktuell = 'J'
       and z.text= 'RV') > 0 
AND  (SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
       and z.text= '1X') > 0 
GROUP BY k.markt
UNION
SELECT 
'RV-Saldo Mischkonten' beschreibung, 
k.markt markt, 
NULL anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(
(select sum(
case 
when sk2.kz_aktuell  = 'J' then IFNULL(sk2.saldo,0)
else 0
end
) from subkonto_neu sk2 
JOIN zahlart z2 on z2.id = sk2.zahlart_id where sk2.stammdaten_id=k.id and z2.text = 'RV')
),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join stammdaten s on s.kunde_id = k.id
WHERE IFNULL(s.gesamtsaldo,0) > 0
AND
(SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0   and sk.kz_aktuell = 'J'
       and z.text= 'RV') > 0 
AND  (SELECT COUNT(*) anzahl
      FROM subkonto_neu sk
      JOIN zahlart z on z.id = sk.zahlart_id
     WHERE sk.stammdaten_id = k.id
       AND IFNULL(sk.saldo,0) > 0  and sk.kz_aktuell = 'J'
       and z.text= '1X') > 0 
GROUP BY k.markt
UNION
SELECT 
'davon Saldo Inkassokunden' beschreibung,
k.markt markt, 
COUNT(distinct k.kdnr) anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(IFNULL(sk.saldo,0)),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join subkonto_neu sk on sk.stammdaten_id = k.id
join stammdaten s on s.id = k.id
WHERE IFNULL(sk.saldo,0) > 0 and sk.kz_aktuell = 'J'
and IFNULL(s.inkassostatus_id, 0) BETWEEN 3 AND 89
GROUP BY k.markt
UNION
SELECT 
'davon 1X-Saldo Inkassokunden' beschreibung,
k.markt markt, 
NULL anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(
/*IFNULL(sk2.saldo,0)*/
case 
when sk.kz_aktuell  = 'J' then IFNULL(sk.saldo,0)
else 0
end
),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join subkonto_neu sk on sk.stammdaten_id = k.id
join stammdaten s on s.id = k.id
JOIN zahlart z on z.id = sk.zahlart_id 
WHERE IFNULL(sk.saldo,0) > 0 and sk.kz_aktuell = 'J'
and IFNULL(s.inkassostatus_id, 0) BETWEEN 3 AND 89
and z.text = '1X'
group by markt
UNION
SELECT 
'davon RV-Saldo Inkassokunden' beschreibung,
k.markt markt, 
NULL anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(
/*IFNULL(sk2.saldo,0)*/
case 
when sk.kz_aktuell  = 'J' then IFNULL(sk.saldo,0)
else 0
end
),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join subkonto_neu sk on sk.stammdaten_id = k.id
join stammdaten s on s.id = k.id
JOIN zahlart z on z.id = sk.zahlart_id 
WHERE IFNULL(sk.saldo,0) > 0 and sk.kz_aktuell = 'J'
and IFNULL(s.inkassostatus_id, 0) BETWEEN 3 AND 89
and z.text = 'RV'
group by markt
UNION
SELECT 
'Guthaben' beschreibung,
k.markt markt, 
COUNT(*) anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(IFNULL(s.gesamtsaldo,0)),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
FROM kunde k
join stammdaten s on s.id = k.id
WHERE IFNULL(s.gesamtsaldo,0) < 0 
group by markt
UNION
SELECT 
'GuthabenArchiv' beschreibung,
10 markt, 
18197 anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(IFNULL(-470577.83,0)),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
UNION
SELECT 
'GuthabenArchiv' beschreibung,
21 markt, 
757 anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(IFNULL(-20121.53,0)),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
UNION
SELECT 
'Inkasso - erledigt' beschreibung,
10 markt, 
271947 anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(IFNULL(-23981.07,0)),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
UNION
SELECT 
'Inkasso - erledigt' beschreibung,
21 markt, 
3362 anzahl_datensaetze,
REPLACE(CAST(IFNULL(SUM(IFNULL(-1134.62,0)),0) AS CHAR), '.', ',') saldo, 
DATE_FORMAT(now(), '%d.%c.%Y %H:%i:%s') laufdatum
";

$filename = "files/debitorenaussenstand".date("YmdHi").".csv";
$fp = fopen($filename, 'w');
// �berschriftszeile
$string = 'BESCHREIBUNG;MARKT;ANZAHL_DATENSAETZE;SALDO;LAUFDATUM;'."\n"; 
fwrite($fp, $string); // will proccess /n as newline ... 
$result = mysql_query($query);
while ($line = mysql_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
        $string = $line['beschreibung'].';'.$line['markt'].';'.$line['anzahl_datensaetze'].';'.$line['saldo'].';'.$line['laufdatum']."\n"; 
        // $string = "XXX"."\n"; 
        // being transformed into a newline
        $write = fwrite($fp, $string); // will proccess /n as newline ... 

}
fclose($fp);
$file = $filename;

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

echo "<br>File Download zum Dowload bereit <br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."Debitorenaussenstand - Ende: ".$heute;

?>
</body>    
</html>
