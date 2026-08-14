<html>
  <head>
	<meta charset="UTF-8"> 
     <title>KIMI-Plus - OKO-Santander-check</title>
  </head>
  <body>
  <h1>KIMI-Plus -  OKO-Santander-check</h1>
 
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    

echo "OKO-Santander-Check - Start: ".$heute;
echo "<br> <br>";
//begin select


$query = " select  

'ticketnr',
'zaehler',
'text',
'status',
'anruf_status',
'nachname',
'strasse',
'ort',
'aktnr',
'cur_date'

 from dual
UNION
select  
                               ticket.ticketnr ticketnr,

        count(distinct concat(okozwb.mandant,okozwb.ticketnr,okozwb.tagesdatum) )+1 zaehler, -- sum(count(*)+1), -- zaehler
    
                               prioritaet.text text,
							     status.text status,
                     
        anruf_status.text anruf_status,
      
        ticket.nachname nachname,                   -- schuldner
        ticket.strasse strasse,        
        ticket.ort ort, 
        REPLACE( dummy_text9, '/', '' ) aktnr, -- aktnr
      
                               now()cur_date
                               from ticket 
                               left outer join status status on status.id = ticket.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = ticket.prioritaet_id
                               left outer join benutzer on benutzer.id = ticket.benutzer_id
                               left outer join anruf_status on anruf_status.id = ticket.anruf_status_id
                               left outer join grund on grund.id = ticket.grund_id
                               left outer join firma on firma.id = ticket.firma_id
                               left outer join produkt on produkt.id = ticket.produkt_id
                               left outer join janein janein1 on janein1.id = ticket.textant11_janein_id
                               left outer join janein janein2 on janein2.id = ticket.textant21_janein_id
                               left outer join janein janein3 on janein3.id = ticket.textant31_janein_id
                                left outer join janein janein4 on janein4.id = ticket.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = ticket.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = ticket.textant22_nummern_id
        left outer join okozwb on okozwb.mandant = ticket.mandant_id and okozwb.ticketnr = ticket.ticketnr
        left outer join 
         (select letzt_log.*,ben.vorname,ben.nachname,ben.anrede from (
select 

log.start_objekt_id id,
avg(ticketnr),
max(start_timestamp) start_ges,
max(end_timestamp) end_ges,
count(*) anz_bearbeitungen,
TIMEDIFF(max(end_timestamp), max(start_timestamp)) zeit,
-- min(start_benutzer) benutzer,
min(lastuser) benutzer,
min(mandant_id) mandant_id,
SUBSTRING(max(lastuser_franz),20,99) lastuser_franz

from (
select start.id start_id,start.objekt start_objekt, start.objekt_id  start_objekt_id,start.logart start_logart,start.timestamp start_timestamp,start.benutzer start_benutzer,start.start_id start_start_id,
end.id end_id,end.objekt end_objekt, end.objekt_id  end_objekt_id,end.logart end_logart,end.timestamp end_timestamp,end.benutzer end_benutzer,end.start_id end_start_id,
end.timestamp - start.timestamp dauer2,
TIMEDIFF(end.timestamp, start.timestamp) dauer1,
t.ticketnr,t.mandant_id mandant_id ,
get_log_last_user(start.objekt, start.objekt_id, 'MAN_START') lastuser,
concat(start.timestamp,start.benutzer) lastuser_franz
from  log  start 
left outer JOIN (select * from  log  where logart in ('MAN_END','MAN_END_A')) end on  start.id = end.start_id
join ticket t on t.id = start.objekt_id 
where start.logart in ('MAN_START') )  log
group by log.start_objekt_id 
) letzt_log
left outer join benutzer ben on ben.name = letzt_log.benutzer
where mandant_id = 16 ) oko_log on oko_log.id  = ticket.id and ticket.mandant_id = oko_log.mandant_id
left outer join oko on oko.id = ticket.ticketnr -- INKOOEEB für Originaldaten 

                where ticket.mandant_id =16 
and ticket.status_id in (55,57) -- nicht offen und gemeldet
and dummy_text3 like '%Santander Consumer Bank GmbH%'

group by ticket.mandant_id,
                               ticket.ticketnr,
        curdate(),
      
                               prioritaet.text,
        REPLACE( dummy_text9, '/', '' ),

        ticket.nachname,
        ticket.strasse,
        ticket.ort, 
        status.text,
        anruf_status.text
";
//ende select


		
		
	if($result = mysql_query($query)){
		
		if($data = mysql_numrows($result) > 1){
		
			
			
			echo "<table border = \"1\">";

            echo "<tr>";

                echo "<th>TicketNr</th>";

                echo "<th>Zaehler</th>";

                echo "<th>Text</th>";

                echo "<th>Status</th>";
				echo "<th>Anruf_status</th>";
				echo "<th>Nachname</th>";
				echo "<th>Strasse</th>";
				echo "<th>Ort</th>";
				echo "<th>Aktnr</th>";
				echo "<th>Cur_date</th>";
				
            echo "</tr>"  ;  

			while($row = mysql_fetch_array($result)){

				echo "<tr>";

                echo "<td>" . $row['ticketnr'] . "</td>";

                echo "<td>" . $row['zaehler'] . "</td>";

                echo "<td>" . $row['text'] . "</td>";

                echo "<td>" . $row['status'] . "</td>";
				echo "<td>" . $row['anruf_status'] . "</td>";

                echo "<td>" . $row['nachname'] . "</td>";

                echo "<td>" . $row['strasse'] . "</td>";

                echo "<td>" . $row['ort'] . "</td>";
				echo "<td>" . $row['aktnr'] . "</td>";

                echo "<td>" . $row['cur_date'] . "</td>";

            
				echo "</tr>";
			}
		
			echo "</table>";
			
		
        // Close result set

        mysql_free_result($result);

		} 
			else { 
			echo "<b> <font color = '#FF0000' >Kein Datensatz</font> </b>"; //displays the font colour as red
			
			echo "<table border = \"1\">";

				echo "<tr>";

                echo "<th>TicketNr</th>";

                echo "<th>Zaehler</th>";

                echo "<th>Text</th>";

                echo "<th>Status</th>";
				echo "<th>Anruf_status</th>";
				echo "<th>Nachname</th>";
				echo "<th>Strasse</th>";
				echo "<th>Ort</th>";
				echo "<th>Aktnr</th>";
				echo "<th>Cur_date</th>";
				
            echo "</tr>" ;
			echo "</table>";}

      
	}

 else{

    echo "ERROR: Could not able to execute $sql. " . mysql_error($con);

}
		
		
		
		
echo "<br> <br>"."OKO -Santander-Check - Ende :".$heute;        
	
	

 ?>


</body>
</html>