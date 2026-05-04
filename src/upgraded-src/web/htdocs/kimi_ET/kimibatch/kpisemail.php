<html>
  <head>
     <title>KIMI-Plus - KPIs EMAIL</title>
  </head>
  <body>
  <h1>KIMI-Plus -  KPIs EMAIL - Kennzahlen ab 1.7.204 , Tage des aktuelles Monats, aktueller Tag</h1>
<?PHP 
//include ("db.php");
include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    

echo "KPIs-EMIAL-Check - Start: ".$heute;

// Abfrage Status "erledigt" - Anrufstatus  "erreicht","unerreichbar" oder "telefonnummer falsch"
$query_status_upd_check_data = "select count(erl.ticketnr) erledigt,count(err.ticketnr) erreicht,count(unerr.ticketnr) unerreichbar,
count(telfa.ticketnr) telefonnummerfalsch,
count(err.ticketnr)+count(unerr.ticketnr)+count(telfa.ticketnr)+count(errap.ticketnr) summe ,
count(errap.ticketnr) erreichtap
from knp1erledigt erl
left outer join knp1erreicht err on erl.ticketnr = err.ticketnr
left outer join knp1unerreichbar unerr on erl.ticketnr = unerr.ticketnr
left outer join knp1telefonnummerfalsch telfa on erl.ticketnr = telfa.ticketnr
left outer join knp1erreichtap errap on erl.ticketnr = errap.ticketnr";
//
// Abfrage Status "Kennzahlen Letztes Jahr/letzte 12 Monate, aktuelle Tage, aktueller Tag"
$query_kpi = "

select  mandant_text mandant,anzahl, ZV,prozent_ZV, produkt_text emailtext, JahrMonat, Monat 
FROM (


-- INKODE letzte Monate ab 1.7.2024
select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, produkt_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_inkode.produkt_id) as anzahl,
produkt.text produkt_text,
sum(dummy_text3) Connect,
sum(dummy_text4) rpc,
sum(dummy_text5) ptp,
sum(0)
loesungsvorschlag_einmal,
sum(0)
loesungsvorschlag_raten,
sum(0)
loesungsvorschlag_nein,
sum(0)
loesungsvorschlag_ka,
DATE_FORMAT(ticket_inkode.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_inkode.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =24 and kampagne_id <>99  and status_id = 101 and produkt_id in (64,4,5,6) and erstellt >= '2024-07-01'),  -- erledigte
DATE_FORMAT(ticket_inkode.erstellt ,'%Y%m') JahrMonat


from ticket_inkode 
left Join mandant
ON mandant.id = ticket_inkode.mandant_id

left join produkt 
ON ticket_inkode.produkt_id = produkt.id


left outer join nummern nummern2 on nummern2.id = ticket_inkode.textant22_nummern_id

where ticket_inkode.mandant_id =24 and ticket_inkode.kampagne_id <>99  and ticket_inkode.status_id = 101 and ticket_inkode.produkt_id in (64,4,5,6) and erstellt >= '2024-07-01'
group by produkt_id,ticket_inkode.erstellt, mandant.text)ad

group by JahrMonat, produkt_text 

UNION
-- INKODE aktuelles Monat
select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, produkt_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_inkode.produkt_id) as anzahl,
produkt.text produkt_text,
sum(dummy_text3) Connect,
sum(dummy_text4) rpc,
sum(dummy_text5) ptp,
sum(0)
loesungsvorschlag_einmal,
sum(0)
loesungsvorschlag_raten,
sum(0)
loesungsvorschlag_nein,
sum(0)
loesungsvorschlag_ka,
DATE_FORMAT(ticket_inkode.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_inkode.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =24 and kampagne_id <>99  and status_id = 101 and produkt_id in (64,4,5,6) and erstellt >= '2024-07-01' ),  -- erledigte
DATE_FORMAT(ticket_inkode.erstellt ,'%Y%m%d') JahrMonat


from ticket_inkode 
left Join mandant
ON mandant.id = ticket_inkode.mandant_id

left join produkt 
ON ticket_inkode.produkt_id = produkt.id


left outer join nummern nummern2 on nummern2.id = ticket_inkode.textant22_nummern_id

where ticket_inkode.mandant_id =24 and ticket_inkode.kampagne_id <>99  and ticket_inkode.status_id = 101 and ticket_inkode.produkt_id in (64,4,5,6) and erstellt >= '2024-07-01' AND -- aktuelles Monat
MONTH(erstellt) = MONTH(CURDATE())
  AND YEAR(erstellt) = YEAR(CURDATE())
group by produkt_id,ticket_inkode.erstellt, mandant.text)ad

group by JahrMonat, produkt_text 



-- INKODE aktueller Tag aus Ticket

UNION
-- INKODE aktuelles Monat
select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, produkt_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(CURDATE() ,'%d.%m.%Y'), 
 count(ticket_inkode.produkt_id) as anzahl,
produkt.text produkt_text,
sum(dummy_text3) Connect,
sum(dummy_text4) rpc,
sum(dummy_text5) ptp,
sum(0)
loesungsvorschlag_einmal,
sum(0)
loesungsvorschlag_raten,
sum(0)
loesungsvorschlag_nein,
sum(0)
loesungsvorschlag_ka,
DATE_FORMAT(CURDATE(),'%Y')  Jahr,
DATE_FORMAT(CURDATE() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =24 and kampagne_id <>99  and status_id = 101 and produkt_id in (64,4,5,6)  ),  -- erledigte
DATE_FORMAT(CURDATE() ,'%Y%m%d') JahrMonat


from ticket ticket_inkode 
left Join mandant
ON mandant.id = ticket_inkode.mandant_id

left join produkt 
ON ticket_inkode.produkt_id = produkt.id


left outer join nummern nummern2 on nummern2.id = ticket_inkode.textant22_nummern_id

where ticket_inkode.mandant_id =24 and ticket_inkode.kampagne_id <>99  and ticket_inkode.status_id = 101 and ticket_inkode.produkt_id in (64,4,5,6) 
group by produkt_id,CURDATE(), mandant.text)ad

group by JahrMonat, produkt_text 



--
-- INKO2016 letzte Monate ab 1.7.2024

UNION 

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, produkt_text, JahrMonat, Monat
from

(select 
#ticket_inko2016.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(ticket_inko2016.erstellt ,'%d.%m.%Y'), 
 count(ticket_inko2016.produkt_id) as anzahl,
produkt.text produkt_text,
sum(dummy_text3) Connect,
sum(dummy_text4) rpc,
ifnull(sum(dummy_text5),0) ptp,
sum(0)
loesungsvorschlag_einmal,
sum(0)
loesungsvorschlag_raten,
sum(0)
loesungsvorschlag_nein,
sum(0)
loesungsvorschlag_ka,
DATE_FORMAT(ticket_inko2016.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_inko2016.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =18 and kampagne_id <>99  and status_id = 68 and produkt_id in (39,1,2,3)) and erstellt >= '2024-07-01',  -- erledigte
DATE_FORMAT(ticket_inko2016.erstellt ,'%Y%m') JahrMonat


from ticket_inko2016
left Join mandant
ON mandant.id = ticket_inko2016.mandant_id

left join produkt
ON ticket_inko2016.produkt_id = produkt.id

left outer join nummern nummern2 on nummern2.id = ticket_inko2016.textant22_nummern_id

WHERE ticket_inko2016.mandant_id =18 and ticket_inko2016.kampagne_id <>99  and ticket_inko2016.status_id = 68 and ticket_inko2016.produkt_id in (39,1,2,3) and erstellt >= '2024-07-01'

group by produkt_id,ticket_inko2016.erstellt, mandant.text
)ac
group by produkt_text, JahrMonat

UNION
-- INKO2016 aktueller Monat


select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, produkt_text, JahrMonat, Monat
from

(select 
#ticket_inko2016.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(ticket_inko2016.erstellt ,'%d.%m.%Y'), 
 count(ticket_inko2016.produkt_id) as anzahl,
produkt.text produkt_text,
sum(dummy_text3) Connect,
sum(dummy_text4) rpc,
ifnull(sum(dummy_text5),0) ptp,
sum(0)
loesungsvorschlag_einmal,
sum(0)
loesungsvorschlag_raten,
sum(0)
loesungsvorschlag_nein,
sum(0)
loesungsvorschlag_ka,
DATE_FORMAT(ticket_inko2016.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_inko2016.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =18 and kampagne_id <>99  and status_id = 68 and produkt_id in (39,1,2,3)) and erstellt >= '2024-07-01',  -- erledigte
DATE_FORMAT(ticket_inko2016.erstellt ,'%Y%m%d') JahrMonat


from ticket_inko2016
left Join mandant
ON mandant.id = ticket_inko2016.mandant_id

left join produkt
ON ticket_inko2016.produkt_id = produkt.id

left outer join nummern nummern2 on nummern2.id = ticket_inko2016.textant22_nummern_id

WHERE ticket_inko2016.mandant_id =18 and ticket_inko2016.kampagne_id <>99  and ticket_inko2016.status_id = 68 and ticket_inko2016.produkt_id in (39,1,2,3) and erstellt >= '2024-07-01' AND
MONTH(erstellt) = MONTH(CURDATE())
  AND YEAR(erstellt) = YEAR(CURDATE())
group by produkt_id,ticket_inko2016.erstellt, mandant.text
)ac
group by produkt_text, JahrMonat


UNION
-- INKO2016 aktueller Tag aus Ticket


select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, produkt_text, JahrMonat, Monat
from

(select 
#ticket_inko2016.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(CURDATE() ,'%d.%m.%Y'), 
 count(ticket_inko2016.produkt_id) as anzahl,
produkt.text produkt_text,
sum(dummy_text3) Connect,
sum(dummy_text4) rpc,
ifnull(sum(dummy_text5),0) ptp,
sum(0)
loesungsvorschlag_einmal,
sum(0)
loesungsvorschlag_raten,
sum(0)
loesungsvorschlag_nein,
sum(0)
loesungsvorschlag_ka,
DATE_FORMAT(CURDATE() ,'%Y')  Jahr,
DATE_FORMAT(CURDATE() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =18 and kampagne_id <>99  and status_id = 68 and produkt_id in (39,1,2,3)) ,  -- erledigte
DATE_FORMAT(CURDATE() ,'%Y%m%d') JahrMonat


from ticket ticket_inko2016
left Join mandant
ON mandant.id = ticket_inko2016.mandant_id

left join produkt
ON ticket_inko2016.produkt_id = produkt.id

left outer join nummern nummern2 on nummern2.id = ticket_inko2016.textant22_nummern_id

WHERE ticket_inko2016.mandant_id =18 and ticket_inko2016.kampagne_id <>99  and ticket_inko2016.status_id = 68 and ticket_inko2016.produkt_id in (39,1,2,3) 
group by produkt_id,CURDATE(), mandant.text
)ac
group by produkt_text, JahrMonat
) xx
order by mandant_text,JahrMonat,produkt_text
-- at
";
//

//

echo "Start: ".date("d.m.Y H:i:s");  

$result = mysqli_query($dbconn, $query_kpi);
echo '<table border="1">';
	     echo "<tr>";
		 echo "<td>Mandant</td>";
		echo "<td>EMAILText</td>";
		echo "<td>Anzahl</td>";
		echo "<td>JahrMonat</td>";
		echo "<td>Monat</td>";

		echo "</tr>";
while ($line = dbFetchArray($result)) { ?>
<?PHP
    if (1 <> 1)
      {
       echo "<b><font color='#FF0000'>FEHLER</font></b>&nbsp;Update Status - ungleich erledigt zu erreichbar/unerreichbar/telefonnummer falsch: Erledigt: ".$line['erledigt'].$line['summe']."<br>";
       $drucksatz= "KPIS: ".$line['kpizeile'];
       echo "<br>".$drucksatz;

    }
     else {
      /* echo "<b><font color='#00C000'>KEIN FEHLER</font></b><br>";
       $drucksatz= "KPIs: ".$line['kpizeile'];
       echo "<br>".$drucksatz; */
	     echo "<tr>";
		echo "<td>". $line['mandant'] . "</td>";
		echo "<td>". $line['emailtext'] . "</td>";
		echo "<td>". $line['anzahl'] . "</td>";
		echo "<td>". $line['JahrMonat'] . "</td>";
		echo "<td>". $line['Monat']. "</td>";
		echo "</tr>";
	   }
	   


 ?>
 
 <?PHP 
 
}
	   echo "</table>";
//


dbClose($dbconn);

$heute = date("d.m.Y H:i:s");    
echo "<br><br>KPIs-EMAIL-Check - Ende: ".$heute;

?>
</body>    
</html>
