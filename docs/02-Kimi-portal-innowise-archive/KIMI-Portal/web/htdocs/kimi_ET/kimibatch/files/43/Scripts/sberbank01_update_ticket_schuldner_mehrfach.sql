update ticket set 
ergebnis = 'Schuldner mehrfach vorhanden' -- ergebnisfeld ist beim Einspielen leer !
where mandant_id = 43 and kampagne_id <> 99
and id in (
select id from  sberbank_duplet
)