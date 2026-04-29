create table knp3mehrfach2
as 
select telnr,min(id) ticketnr1,max(id) ticketnr2,
concat(
'ticketnr1: ',min(id) ,' AZ: ', min(indexa), ' Name: ', kimi_decrypt(name),CHAR(13,10),
'ticketnr2: ',max(id) ,' AZ: ', max(indexa), ' Name: ', kimi_decrypt(name),CHAR(13,10)
) text 
from knp3mehrfach
group by telnr
