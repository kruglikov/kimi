update ticket 
inner join knp3mehrfach2 on knp3mehrfach2.ticketnr2 = ticket.ticketnr
set ticket.ergebnis = concat('Schuldnertelefonnummer mind. 2 x mehrfach vorhanden: ',CHAR(13,10),'AZ: ',knp3mehrfach2.text) 
where mandant_id = 41 and beginn >= curdate() and 
ticket.ticketnr in (select id from knp3mehrfach )
