update ticket set 
ergebnis = 'Schuldner mehrfach vorhanden' -- ergebnisfeld ist beim Einspielen leer !
where mandant_id = 40 and kampagne_id <> 99
and id in (
select id from  knp1_duplet
)