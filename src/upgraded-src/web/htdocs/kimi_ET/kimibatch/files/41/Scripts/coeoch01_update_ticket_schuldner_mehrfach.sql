update ticket set 
ergebnis = 'Schuldnertelefonnummer mind. 2 x mehrfach vorhanden' -- ergebnisfeld ist beim Einspielen leer !
where mandant_id = 41 and kampagne_id <> 99
and id in (
select id from  knp3_duplet
)