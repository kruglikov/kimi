create table knpmehrfach2
as 
select telnr,min(id) ticketnr1,max(id) ticketnr2,
concat(
'ticketnr1: ',min(id) ,' AZ: ', min(indexa), ' Name: ', name,CHAR(13,10),
'ticketnr2: ',max(id) ,' AZ: ', max(indexa), ' Name: ', name,CHAR(13,10)
) text 
from knpmehrfach
group by telnr
