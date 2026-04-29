create table knp3mehrfach
as 
select id,indexa,name,telnr from knp3 where import >= curdate() 
and telnr in (
select telnr from knp3 where import >= curdate() 
group by telnr 
having count(*) > 1
)
