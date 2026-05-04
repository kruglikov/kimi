update ticket 
inner join sberbankmehrfach2 on sberbankmehrfach2.ticketnr2 = ticket.ticketnr
set ticket.ergebnis = concat('mehrfach: ',CHAR(13,10),'AZ: ',sberbankmehrfach2.text) 
where mandant_id = 43 and beginn >= curdate() and 
ticket.ticketnr in (select concat(id,'000') from sberbankmehrfach )
