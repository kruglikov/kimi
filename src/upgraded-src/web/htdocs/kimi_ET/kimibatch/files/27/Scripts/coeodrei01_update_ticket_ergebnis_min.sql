update ticket 
inner join knpdreimehrfach2 on knp3mehrfach2.ticketnr1 = ticket.ticketnr
set ticket.ergebnis = concat('Schuldnertelefonnummer mind. 2 x mehrfach vorhanden: ',CHAR(13,10),'AZ: ',knpdreimehrfach2.text) 
where mandant_id = 27 and beginn >= curdate() and 
ticket.ticketnr in (select id from knpdreimehrfach )
