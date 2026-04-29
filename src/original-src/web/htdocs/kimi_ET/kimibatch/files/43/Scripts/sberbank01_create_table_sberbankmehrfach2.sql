create table sberbankmehrfach2
as 
select telefonnummer,concat(min(id),'000') ticketnr1,concat(max(id),'000') ticketnr2,
concat(
'ticketnr1: ',concat(min(id),'000') ,' AZ: ', min(kontonummer), ' Name: ', kundenname,CHAR(13,10),
'ticketnr2: ',concat(max(id),'000') ,' AZ: ', max(kontonummer), ' Name: ', kundenname,CHAR(13,10)
) text 
from sberbankmehrfach
group by telefonnummer
