create table knpmehrfach
as 
select id,indexa,name,telnr from knp1 where import >= curdate() 
and telnr in (
select telnr from knp1 where import >= curdate() 
group by telnr 
having count(*) > 1
)
