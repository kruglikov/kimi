create table sberbankmehrfach
as 
select id,kontonummer,kundenname,telefonnummer from sberbank where import >= curdate() 
and telefonnummer in (
select telefonnummer from sberbank where import >= curdate() 
group by telefonnummer 
having count(*) > 1
)