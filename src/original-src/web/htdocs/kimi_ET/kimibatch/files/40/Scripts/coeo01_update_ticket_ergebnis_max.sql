update ticket 
inner join knpmehrfach2 on knpmehrfach2.ticketnr2 = ticket.ticketnr
set ticket.ergebnis = concat('Schuldnertelefonnummer mind. 2 x mehrfach vorhanden: ',CHAR(13,10),'AZ: ',knpmehrfach2.text) 
where mandant_id = 40 and beginn >= curdate() and 
ticket.ticketnr in (select id from knpmehrfach )
