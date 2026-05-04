<html>
  <head>
     <title>KIMI-Plus - KPIs</title>
  </head>
  <body>
  <h1>KIMI-Plus -  KPIs - Kennzahlen Letztes Jahr/letzte 12 Monate, aktuelle Tage, aktueller Tag</h1>
<?PHP 
//include ("db.php");
include ("kimi_general.php");
$heute = date("d.m.Y H:i:s");    

echo "KPIs-Check - Start: ".$heute;

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
select 
kpi.* from (
-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx JAHR
select  mandant_text mandant , '1 - JAHR' grp ,
kpi_jahr.* from(
select
sum(anzahl) anzahl,
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) erreicht,
sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        ) unerreichbar,
  sum(CASE
		WHEN anruf_status_text = 'Telefonnummer falsch'
		THEN anzahl
        ELSE 0 END
        ) telefonnummer_falsch,      
sum(ZV) ZV,
/*
REPLACE(REPLACE(FORMAT(

CAST(((sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) / sum(anzahl))*100) AS DECIMAL(38,2))

, 2),',',''),'.',',') 
 prozent_erreicht,
--
sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        )+
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) erreichbar_unerreichbar,
--
*/
REPLACE(REPLACE(FORMAT(

CAST(((sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) / (sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        )+
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        )))*100) AS DECIMAL(38,2))

, 2),',',''),'.',',') 
 prozent_erreicht,
--

REPLACE(REPLACE(FORMAT(

CAST(((sum(ZV) / sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ))*100)AS DECIMAL(38,2)) 

, 2),',',''),'.',',') 
 prozent_ZV,

mandant_text, JahrMonat, Monat

From
(

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from

(select 
#ticket_inkoinbound.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%d.%m.%Y'), 
 count(ticket_inkoinbound.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =2 and kampagne_id <>99  and status_id = 7),  -- erledigte
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%Y%m') JahrMonat 


from ticket_inkoinbound
left Join mandant
ON mandant.id = ticket_inkoinbound.mandant_id

left join anruf_status
ON ticket_inkoinbound.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inkoinbound.textant22_nummern_id


group by anruf_status_id,ticket_inkoinbound.erstellt, mandant.text
)ac
group by anruf_status_text, JahrMonat


UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from

(select 
#ticket_inko2016.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(ticket_inko2016.erstellt ,'%d.%m.%Y'), 
 count(ticket_inko2016.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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

	where ticket.mandant_id =18 and kampagne_id <>99  and status_id = 68),  -- erledigte
DATE_FORMAT(ticket_inko2016.erstellt ,'%Y%m') JahrMonat


from ticket_inko2016
left Join mandant
ON mandant.id = ticket_inko2016.mandant_id

left join anruf_status
ON ticket_inko2016.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inko2016.textant22_nummern_id


group by anruf_status_id,ticket_inko2016.erstellt, mandant.text
)ac
group by anruf_status_text, JahrMonat

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_inkode.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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

	where ticket.mandant_id =24 and kampagne_id <>99  and status_id = 101),  -- erledigte
DATE_FORMAT(ticket_inkode.erstellt ,'%Y%m') JahrMonat


from ticket_inkode
left Join mandant
ON mandant.id = ticket_inkode.mandant_id

left join anruf_status
ON ticket_inkode.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inkode.textant22_nummern_id

group by anruf_status_id,ticket_inkode.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_schlaustrom.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =27 and kampagne_id <>99  and status_id = 117),  -- erledigte
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%Y%m') JahrMonat


from ticket_schlaustrom
left Join mandant
ON mandant.id = ticket_schlaustrom.mandant_id

left join anruf_status
ON ticket_schlaustrom.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_schlaustrom.textant22_nummern_id

group by anruf_status_id,ticket_schlaustrom.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_knp1.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_knp1.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_knp1.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =40 and kampagne_id <>99  and status_id = 187),  -- erledigte
DATE_FORMAT(ticket_knp1.erstellt ,'%Y%m') JahrMonat

from ticket_knp1
left Join mandant
ON mandant.id = ticket_knp1.mandant_id

left join anruf_status
ON ticket_knp1.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_knp1.textant22_nummern_id

group by anruf_status_id,ticket_knp1.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_knp3.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_knp3.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_knp3.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =41 and kampagne_id <>99  and status_id = 191),  -- erledigte
DATE_FORMAT(ticket_knp3.erstellt ,'%Y%m') JahrMonat

from ticket_knp3
left Join mandant
ON mandant.id = ticket_knp3.mandant_id

left join anruf_status
ON ticket_knp3.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_knp3.textant22_nummern_id

group by anruf_status_id,ticket_knp3.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(loesungsvorschlag_einmal + loesungsvorschlag_raten) ZV, ((sum(loesungsvorschlag_einmal + loesungsvorschlag_raten)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from
(
select 
#ticket_oko.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y') datum, 
 count(ticket_oko.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
sum(0) Connect,
sum(0) rpc,
sum(0) ptp,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'JA-Einmal' THEN 1
      ELSE 0
    END)
loesungsvorschlag_einmal,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'JA-Raten' THEN 1
      ELSE 0
    END)
 
loesungsvorschlag_raten,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'NEIN' THEN 1
      ELSE 0
    END)
loesungsvorschlag_nein,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'k.A.' THEN 1
      ELSE 0
    END)
loesungsvorschlag_ka,
DATE_FORMAT(ticket_oko.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_oko.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =16 and kampagne_id <>99  and status_id = 55) erledigte,  -- erledigte
DATE_FORMAT(ticket_oko.erstellt ,'%Y%m') JahrMonat-- JahrMonat


from ticket_oko
left Join mandant
ON mandant.id = ticket_oko.mandant_id

left join anruf_status
ON ticket_oko.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_oko.textant22_nummern_id

group by anruf_status_id,ticket_oko.erstellt, mandant.text
)aa
group by anruf_status_text, JahrMonat 



)xx
where JahrMonat >= CONCAT(SUBSTRING(DATE_ADD(CURRENT_DATE, INTERVAL -12 MONTH), 1, 4),SUBSTRING(DATE_ADD(CURRENT_DATE, INTERVAL -12 MONTH), 6, 2))
group by mandant_text -- , JahrMonat
order by mandant_text desc, JahrMonat asc 
) kpi_jahr

-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MONAT

UNION 

select mandant_text mandant , '2 - MONAT letzte 12' grp,
kpi_monat.* from(
select
sum(anzahl) anzahl,
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) erreicht,
sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        ) unerreichbar,
  sum(CASE
		WHEN anruf_status_text = 'Telefonnummer falsch'
		THEN anzahl
        ELSE 0 END
        ) telefonnummer_falsch,            
sum(ZV) ZV,
/*
REPLACE(REPLACE(FORMAT(

CAST(((sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) / sum(anzahl))*100) AS DECIMAL(38,2))

, 2),',',''),'.',',') 
 prozent_erreicht,
--
sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        )+
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) erreichbar_unerreichbar,
--
*/
REPLACE(REPLACE(FORMAT(

CAST(((sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) / (sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        )+
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        )))*100) AS DECIMAL(38,2))

, 2),',',''),'.',',') 
 prozent_erreicht,
--

REPLACE(REPLACE(FORMAT(

CAST(((sum(ZV) / sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ))*100)AS DECIMAL(38,2)) 

, 2),',',''),'.',',') 
 prozent_ZV,

mandant_text, JahrMonat, Monat

From
(

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from

(select 
#ticket_inkoinbound.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%d.%m.%Y'), 
 count(ticket_inkoinbound.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =18 and kampagne_id <>99  and status_id = 68),  -- erledigte
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%Y%m') JahrMonat 


from ticket_inkoinbound
left Join mandant
ON mandant.id = ticket_inkoinbound.mandant_id

left join anruf_status
ON ticket_inkoinbound.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inkoinbound.textant22_nummern_id


group by anruf_status_id,ticket_inkoinbound.erstellt, mandant.text
)ac
group by anruf_status_text, JahrMonat


UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from

(select 
#ticket_inko2016.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(ticket_inko2016.erstellt ,'%d.%m.%Y'), 
 count(ticket_inko2016.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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

	where ticket.mandant_id =18 and kampagne_id <>99  and status_id = 68),  -- erledigte
DATE_FORMAT(ticket_inko2016.erstellt ,'%Y%m') JahrMonat


from ticket_inko2016
left Join mandant
ON mandant.id = ticket_inko2016.mandant_id

left join anruf_status
ON ticket_inko2016.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inko2016.textant22_nummern_id


group by anruf_status_id,ticket_inko2016.erstellt, mandant.text
)ac
group by anruf_status_text, JahrMonat

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_inkode.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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

	where ticket.mandant_id =24 and kampagne_id <>99  and status_id = 101),  -- erledigte
DATE_FORMAT(ticket_inkode.erstellt ,'%Y%m') JahrMonat


from ticket_inkode
left Join mandant
ON mandant.id = ticket_inkode.mandant_id

left join anruf_status
ON ticket_inkode.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inkode.textant22_nummern_id

group by anruf_status_id,ticket_inkode.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_schlaustrom.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =27 and kampagne_id <>99  and status_id = 117),  -- erledigte
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%Y%m') JahrMonat


from ticket_schlaustrom
left Join mandant
ON mandant.id = ticket_schlaustrom.mandant_id

left join anruf_status
ON ticket_schlaustrom.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_schlaustrom.textant22_nummern_id

group by anruf_status_id,ticket_schlaustrom.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_knp1.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_knp1.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_knp1.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =40 and kampagne_id <>99  and status_id = 187),  -- erledigte
DATE_FORMAT(ticket_knp1.erstellt ,'%Y%m') JahrMonat

from ticket_knp1
left Join mandant
ON mandant.id = ticket_knp1.mandant_id

left join anruf_status
ON ticket_knp1.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_knp1.textant22_nummern_id

group by anruf_status_id,ticket_knp1.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 
UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_knp3.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_knp3.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_knp3.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =41 and kampagne_id <>99  and status_id = 191),  -- erledigte
DATE_FORMAT(ticket_knp3.erstellt ,'%Y%m') JahrMonat

from ticket_knp3
left Join mandant
ON mandant.id = ticket_knp3.mandant_id

left join anruf_status
ON ticket_knp3.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_knp3.textant22_nummern_id

group by anruf_status_id,ticket_knp3.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(loesungsvorschlag_einmal + loesungsvorschlag_raten) ZV, ((sum(loesungsvorschlag_einmal + loesungsvorschlag_raten)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from
(
select 
#ticket_oko.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y') datum, 
 count(ticket_oko.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
sum(0) Connect,
sum(0) rpc,
sum(0) ptp,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'JA-Einmal' THEN 1
      ELSE 0
    END)
loesungsvorschlag_einmal,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'JA-Raten' THEN 1
      ELSE 0
    END)
 
loesungsvorschlag_raten,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'NEIN' THEN 1
      ELSE 0
    END)
loesungsvorschlag_nein,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'k.A.' THEN 1
      ELSE 0
    END)
loesungsvorschlag_ka,
DATE_FORMAT(ticket_oko.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_oko.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =16 and kampagne_id <>99  and status_id = 55) erledigte,  -- erledigte
DATE_FORMAT(ticket_oko.erstellt ,'%Y%m') JahrMonat-- JahrMonat


from ticket_oko
left Join mandant
ON mandant.id = ticket_oko.mandant_id

left join anruf_status
ON ticket_oko.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_oko.textant22_nummern_id

group by anruf_status_id,ticket_oko.erstellt, mandant.text
)aa
group by anruf_status_text, JahrMonat 



)xx
where JahrMonat >= CONCAT(SUBSTRING(DATE_ADD(CURRENT_DATE, INTERVAL -12 MONTH), 1, 4),SUBSTRING(DATE_ADD(CURRENT_DATE, INTERVAL -12 MONTH), 6, 2))
group by mandant_text, JahrMonat
order by mandant_text desc, JahrMonat asc 
) kpi_monat


-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx TAG

UNION 

select mandant_text mandant , '3 - TAGE im aktuellen Monat' grp,
kpi_tag.* from(
select
sum(anzahl) anzahl,
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) erreicht,
sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        ) unerreichbar,
  sum(CASE
		WHEN anruf_status_text = 'Telefonnummer falsch'
		THEN anzahl
        ELSE 0 END
        ) telefonnummer_falsch,            
sum(ZV) ZV,
/*
REPLACE(REPLACE(FORMAT(

CAST(((sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) / sum(anzahl))*100) AS DECIMAL(38,2))

, 2),',',''),'.',',') 
 prozent_erreicht,
--
sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        )+
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) erreichbar_unerreichbar,
--
*/
REPLACE(REPLACE(FORMAT(

CAST(((sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) / (sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        )+
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        )))*100) AS DECIMAL(38,2))

, 2),',',''),'.',',') 
 prozent_erreicht,
--

REPLACE(REPLACE(FORMAT(

CAST(((sum(ZV) / sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ))*100)AS DECIMAL(38,2)) 

, 2),',',''),'.',',') 
 prozent_ZV,

mandant_text, JahrMonat, Monat

From
(

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from

(select 
#ticket_inkoinbound.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%d.%m.%Y'), 
 count(ticket_inkoinbound.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =2 and kampagne_id <>99  and status_id = 7),  -- erledigte
DATE_FORMAT(ticket_inkoinbound.erstellt ,'%Y%m%d') JahrMonat 


from ticket_inkoinbound
left Join mandant
ON mandant.id = ticket_inkoinbound.mandant_id

left join anruf_status
ON ticket_inkoinbound.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inkoinbound.textant22_nummern_id
where DATE_FORMAT(ticket_inkoinbound.erstellt ,'%Y%m') =  DATE_FORMAT(curdate() ,'%Y%m') 


group by anruf_status_id,ticket_inkoinbound.erstellt, mandant.text
)ac
group by anruf_status_text, JahrMonat


UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from

(select 
#ticket_inko2016.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(ticket_inko2016.erstellt ,'%d.%m.%Y'), 
 count(ticket_inko2016.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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

	where ticket.mandant_id =18 and kampagne_id <>99  and status_id = 68),  -- erledigte
DATE_FORMAT(ticket_inko2016.erstellt ,'%Y%m%d') JahrMonat


from ticket_inko2016
left Join mandant
ON mandant.id = ticket_inko2016.mandant_id

left join anruf_status
ON ticket_inko2016.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inko2016.textant22_nummern_id

where DATE_FORMAT(ticket_inko2016.erstellt ,'%Y%m') =  DATE_FORMAT(curdate() ,'%Y%m') 

group by anruf_status_id,ticket_inko2016.erstellt, mandant.text
)ac
group by anruf_status_text, JahrMonat

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_inkode.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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

	where ticket.mandant_id =24 and kampagne_id <>99  and status_id = 101),  -- erledigte
DATE_FORMAT(ticket_inkode.erstellt ,'%Y%m%d') JahrMonat


from ticket_inkode
left Join mandant
ON mandant.id = ticket_inkode.mandant_id

left join anruf_status
ON ticket_inkode.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inkode.textant22_nummern_id

where DATE_FORMAT(ticket_inkode.erstellt ,'%Y%m') =  DATE_FORMAT(curdate() ,'%Y%m') 

group by anruf_status_id,ticket_inkode.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_schlaustrom.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =27 and kampagne_id <>99  and status_id = 117),  -- erledigte
DATE_FORMAT(ticket_schlaustrom.erstellt ,'%Y%m%d') JahrMonat


from ticket_schlaustrom
left Join mandant
ON mandant.id = ticket_schlaustrom.mandant_id

left join anruf_status
ON ticket_schlaustrom.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_schlaustrom.textant22_nummern_id

where DATE_FORMAT(ticket_schlaustrom.erstellt ,'%Y%m') =  DATE_FORMAT(curdate() ,'%Y%m') 

group by anruf_status_id,ticket_schlaustrom.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_knp1.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_knp1.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_knp1.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =40 and kampagne_id <>99  and status_id = 187),  -- erledigte
DATE_FORMAT(ticket_knp1.erstellt ,'%Y%m%d') JahrMonat

from ticket_knp1
left Join mandant
ON mandant.id = ticket_knp1.mandant_id

left join anruf_status
ON ticket_knp1.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_knp1.textant22_nummern_id

where DATE_FORMAT(ticket_knp1.erstellt ,'%Y%m') =  DATE_FORMAT(curdate() ,'%Y%m') 

group by anruf_status_id,ticket_knp1.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y'), 
 count(ticket_knp3.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(ticket_knp3.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_knp3.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id = 41 and kampagne_id <>99  and status_id = 191),  -- erledigte
DATE_FORMAT(ticket_knp3.erstellt ,'%Y%m%d') JahrMonat

from ticket_knp3
left Join mandant
ON mandant.id = ticket_knp3.mandant_id

left join anruf_status
ON ticket_knp3.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_knp3.textant22_nummern_id

where DATE_FORMAT(ticket_knp3.erstellt ,'%Y%m') =  DATE_FORMAT(curdate() ,'%Y%m') 

group by anruf_status_id,ticket_knp3.erstellt, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(loesungsvorschlag_einmal + loesungsvorschlag_raten) ZV, ((sum(loesungsvorschlag_einmal + loesungsvorschlag_raten)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from
(
select 
#ticket_oko.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(erstellt ,'%d.%m.%Y') datum, 
 count(ticket_oko.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
sum(0) Connect,
sum(0) rpc,
sum(0) ptp,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'JA-Einmal' THEN 1
      ELSE 0
    END)
loesungsvorschlag_einmal,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'JA-Raten' THEN 1
      ELSE 0
    END)
 
loesungsvorschlag_raten,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'NEIN' THEN 1
      ELSE 0
    END)
loesungsvorschlag_nein,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'k.A.' THEN 1
      ELSE 0
    END)
loesungsvorschlag_ka,
DATE_FORMAT(ticket_oko.erstellt ,'%Y')  Jahr,
DATE_FORMAT(ticket_oko.erstellt ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =16 and kampagne_id <>99  and status_id = 55) erledigte,  -- erledigte
DATE_FORMAT(ticket_oko.erstellt ,'%Y%m%d') JahrMonat-- JahrMonat


from ticket_oko
left Join mandant
ON mandant.id = ticket_oko.mandant_id

left join anruf_status
ON ticket_oko.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_oko.textant22_nummern_id

group by anruf_status_id,ticket_oko.erstellt, mandant.text
)aa
group by anruf_status_text, JahrMonat 



)xx
where JahrMonat >= CONCAT(SUBSTRING(CURRENT_DATE, 1, 4),SUBSTRING(CURRENT_DATE, 6, 2))
group by mandant_text, JahrMonat
order by mandant_text desc, JahrMonat asc 
) kpi_tag
-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx AKTTAG

UNION 

select mandant_text mandant , '4 - TAG aktuell' grp,
kpi_akttag.* from(
select
sum(anzahl) anzahl,
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) erreicht,
sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        ) unerreichbar,
  sum(CASE
		WHEN anruf_status_text = 'Telefonnummer falsch'
		THEN anzahl
        ELSE 0 END
        ) telefonnummer_falsch,            
sum(ZV) ZV,
/*
REPLACE(REPLACE(FORMAT(

CAST(((sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) / sum(anzahl))*100) AS DECIMAL(38,2))

, 2),',',''),'.',',') 
 prozent_erreicht,
--
sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        )+
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) erreichbar_unerreichbar,
--
*/
REPLACE(REPLACE(FORMAT(

CAST(((sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ) / (sum(CASE
		WHEN anruf_status_text = 'Unerreichbar'
		THEN anzahl
        ELSE 0 END
        )+
sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        )))*100) AS DECIMAL(38,2))

, 2),',',''),'.',',') 
 prozent_erreicht,
--

REPLACE(REPLACE(FORMAT(

CAST(((sum(ZV) / sum(CASE
		WHEN anruf_status_text = 'erreicht'
		THEN anzahl
        ELSE 0 END
        ))*100)AS DECIMAL(38,2)) 

, 2),',',''),'.',',') 
 prozent_ZV,

mandant_text, JahrMonat, Monat

From
(

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from

(select 
#ticket_inkoinbound.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(curdate() ,'%d.%m.%Y'), 
 count(ticket_inkoinbound.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(curdate() ,'%Y')  Jahr,
DATE_FORMAT(curdate() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =2 and kampagne_id <>99  and status_id = 7),  -- erledigte
DATE_FORMAT(curdate() ,'%Y%m%d') JahrMonat 


from  ticket ticket_inkoinbound
left Join mandant
ON mandant.id = ticket_inkoinbound.mandant_id

left join anruf_status
ON ticket_inkoinbound.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inkoinbound.textant22_nummern_id
where ticket_inkoinbound.mandant_id =2 and ticket_inkoinbound.kampagne_id <>99  and ticket_inkoinbound.status_id = 7


group by anruf_status_id, mandant.text
)ac
group by anruf_status_text, JahrMonat

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from

(select 
#ticket_inko2016.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(curdate() ,'%d.%m.%Y'), 
 count(ticket_inko2016.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(curdate() ,'%Y')  Jahr,
DATE_FORMAT(curdate() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =18 and kampagne_id <>99  and status_id = 68),  -- erledigte
DATE_FORMAT(curdate() ,'%Y%m%d') JahrMonat


from ticket ticket_inko2016
left Join mandant
ON mandant.id = ticket_inko2016.mandant_id

left join anruf_status
ON ticket_inko2016.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inko2016.textant22_nummern_id

where ticket_inko2016.mandant_id =18 and ticket_inko2016.kampagne_id <>99  and ticket_inko2016.status_id = 68

group by anruf_status_id, mandant.text
)ac
group by anruf_status_text, JahrMonat

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(curdate() ,'%d.%m.%Y'), 
 count(ticket_inkode.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(curdate() ,'%Y')  Jahr,
DATE_FORMAT(curdate() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =24 and kampagne_id <>99  and status_id = 101),  -- erledigte
DATE_FORMAT(curdate() ,'%Y%m%d') JahrMonat


from ticket ticket_inkode
left Join mandant
ON mandant.id = ticket_inkode.mandant_id

left join anruf_status
ON ticket_inkode.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_inkode.textant22_nummern_id
where ticket_inkode.mandant_id =24 and ticket_inkode.kampagne_id <>99  and ticket_inkode.status_id = 101


group by anruf_status_id, mandant.text)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(curdate() ,'%d.%m.%Y'), 
 count(ticket_schlaustrom.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(curdate() ,'%Y')  Jahr,
DATE_FORMAT(curdate() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =27 and kampagne_id <>99  and status_id = 117),  -- erledigte
DATE_FORMAT(curdate(),'%Y%m%d') JahrMonat


from ticket ticket_schlaustrom
left Join mandant
ON mandant.id = ticket_schlaustrom.mandant_id

left join anruf_status
ON ticket_schlaustrom.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_schlaustrom.textant22_nummern_id
where ticket_schlaustrom.mandant_id =27 and ticket_schlaustrom.kampagne_id <>99  and ticket_schlaustrom.status_id = 117 

group by anruf_status_id,  mandant.text
)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(curdate() ,'%d.%m.%Y'), 
 count(ticket_knp1.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(curdate() ,'%Y')  Jahr,
DATE_FORMAT(curdate() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =40 and kampagne_id <>99  and status_id = 187),  -- erledigte
DATE_FORMAT(curdate() ,'%Y%m%d') JahrMonat

from ticket ticket_knp1
left Join mandant
ON mandant.id = ticket_knp1.mandant_id

left join anruf_status
ON ticket_knp1.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_knp1.textant22_nummern_id
where ticket_knp1.mandant_id =40 and ticket_knp1.kampagne_id <>99  and ticket_knp1.status_id = 187

group by anruf_status_id,  mandant.text
)ad

group by JahrMonat, anruf_status_text 

UNION ALL

select sum(anzahl) anzahl, sum(ptp) ZV, ((sum(ptp)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from


(select 

mandant.text mandant_text,
DATE_FORMAT(curdate() ,'%d.%m.%Y'), 
 count(ticket_knp3.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
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
DATE_FORMAT(curdate() ,'%Y')  Jahr,
DATE_FORMAT(curdate() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id = 41 and kampagne_id <>99  and status_id = 191),  -- erledigte
DATE_FORMAT(curdate() ,'%Y%m%d') JahrMonat

from ticket ticket_knp3
left Join mandant
ON mandant.id = ticket_knp3.mandant_id

left join anruf_status
ON ticket_knp3.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_knp3.textant22_nummern_id
where ticket_knp3.mandant_id =41 and ticket_knp3.kampagne_id <>99  and ticket_knp3.status_id = 191

group by anruf_status_id,  mandant.text
)ad

group by JahrMonat, anruf_status_text 
UNION ALL

select sum(anzahl) anzahl, sum(loesungsvorschlag_einmal + loesungsvorschlag_raten) ZV, ((sum(loesungsvorschlag_einmal + loesungsvorschlag_raten)/sum(anzahl))*100) prozent_ZV, mandant_text, anruf_status_text, JahrMonat, Monat
from
(
select 
#ticket_oko.anruf_status_id, 
mandant.text mandant_text,
DATE_FORMAT(curdate() ,'%d.%m.%Y') datum, 
 count(ticket_oko.anruf_status_id) as anzahl,
anruf_status.text anruf_status_text,
sum(0) Connect,
sum(0) rpc,
sum(0) ptp,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'JA-Einmal' THEN 1
      ELSE 0
    END)
loesungsvorschlag_einmal,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'JA-Raten' THEN 1
      ELSE 0
    END)
 
loesungsvorschlag_raten,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'NEIN' THEN 1
      ELSE 0
    END)
loesungsvorschlag_nein,
sum(CASE IFNULL(nummern2.text,'k.A.')  
      WHEN 'k.A.' THEN 1
      ELSE 0
    END)
loesungsvorschlag_ka,
DATE_FORMAT(curdate() ,'%Y')  Jahr,
DATE_FORMAT(curdate() ,'%M') Monat,
(		select 

       count(*)
		from ticket 

	where ticket.mandant_id =16 and kampagne_id <>99  and status_id = 55) erledigte,  -- erledigte
DATE_FORMAT(curdate() ,'%Y%m%d') JahrMonat-- JahrMonat


from ticket ticket_oko
left Join mandant
ON mandant.id = ticket_oko.mandant_id

left join anruf_status
ON ticket_oko.anruf_status_id = anruf_status.id

left outer join nummern nummern2 on nummern2.id = ticket_oko.textant22_nummern_id
where ticket_oko.mandant_id =16 and ticket_oko.kampagne_id <>99  and ticket_oko.status_id = 55 --  57
group by anruf_status_id,  mandant.text
)aa
group by anruf_status_text, JahrMonat 



)xx
where JahrMonat >= CONCAT(SUBSTRING(CURRENT_DATE, 1, 4),SUBSTRING(CURRENT_DATE, 6, 2))
group by mandant_text, JahrMonat
order by mandant_text desc, JahrMonat asc 
) kpi_akttag

) kpi

group by grp,mandant,JahrMonat
order by mandant_text desc, grp asc,JahrMonat asc 

-- at
";
//

//

echo "Start: ".date("d.m.Y H:i:s");  

$result = mysqli_query($dbconn, $query_kpi);
echo '<table border="1">';
	     echo "<tr>";
		 echo "<td>Mandant</td>";
		echo "<td>Gruppe</td>";
		echo "<td>Anzahl Erledigt</td>";
		echo "<td>Erreicht</td>";		
		echo "<td>Unerreichbar</td>";
		echo "<td>Telefonnummer falsch</td>";		
		echo "<td>ZV</td>";
		echo "<td>Prozent_erreicht</td>";
		echo "<td>Prozent_ZV</td>";
		echo "<td>Mandant_text</td>";
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
		echo "<td>". $line['grp'] . "</td>";
		echo "<td>". $line['anzahl'] . "</td>";
		echo "<td>". $line['erreicht'] . "</td>";
		echo "<td>". $line['unerreichbar'] . "</td>";
		echo "<td>". $line['telefonnummer_falsch'] . "</td>";		
		echo "<td>". $line['ZV'] . "</td>";
		echo "<td>". $line['prozent_erreicht'] . "</td>";
		echo "<td>". $line['prozent_ZV']. "</td>";
		echo "<td>". $line['mandant_text'] . "</td>";
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
echo "<br><br>KPIs-Check - Ende: ".$heute;

?>
</body>    
</html>
