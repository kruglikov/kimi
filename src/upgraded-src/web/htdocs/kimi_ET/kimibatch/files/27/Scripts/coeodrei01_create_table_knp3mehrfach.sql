create table knpdreimehrfach
as 
select id,indexa,name,telnr from knpdrei where import >= curdate() 
and telnr in (
select telnr from knpdrei where import >= curdate() 
group by telnr 
having count(*) > 1
)
