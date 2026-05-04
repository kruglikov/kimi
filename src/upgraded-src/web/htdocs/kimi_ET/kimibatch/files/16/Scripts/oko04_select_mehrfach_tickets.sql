select  'NR' , 'nachname','ticketnr','aktnr' from dual
UNION ALL
select 1,kimi_decrypt(nachname),ticketnr,dummy_text9 aktnr from ticket
where mandant_id = 16 and status_id in (57,58) and nachname in ( 

select nachname from ticket where mandant_id = 16 -- and upper (ergebnis) like '%MEHRFACH%' -- mehrfach wird nicht mehr reingeschrieben
and status_id in (57,58)
group by nachname
having count(*)>1
)
order by 1 desc,2
