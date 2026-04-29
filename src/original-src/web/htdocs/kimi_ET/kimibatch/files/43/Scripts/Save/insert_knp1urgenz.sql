insert into knp1urgenz 
select 40 mandant_id, max(ticketnr) ticketnr,group_concat(urgenztxt order by urgenztxt desc)  urgenztext from (
select ticketnr,nachname,vorname,geburtsdatum,plz,strasse,dummy_text9,
CONCAT('Beginn: ', beginn , 'Index:',dummy_text9,' - ','Ticket:',ticketnr, ' - ', REPLACE( ergebnis, CHAR(13,10), ' ' ),CHAR(13,10)) urgenztxt,
REPLACE(REPLACE(dummy_text10, char(10), char(32)), char(13), char(32))
from ticket where mandant_id = 40 and concat(nachname,vorname) in (
select concat(nachname,vorname) from ticket where id in (select * from knp1_duplet )
and  mandant_id = 40 and kampagne_id <> 99 
) order by nachname, ticketnr desc
) x
group by concat(nachname,vorname,geburtsdatum)