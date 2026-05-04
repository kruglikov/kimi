-- #2 Ergebnisse der Anrufe im Feld Ergebnis im Ticket vermerken
update ticket t
inner join sberbank_out k on k.imp_str_ticketnr = t.ticketnr
set
t.dummy_text13 = TRIM(concat( ifnull(k.status,'')," ",ifnull(k.grund_negativer_ausgang,'')," ",ifnull(k.beschreibung_positiver_ausgang,''))),
-- bei Telefon ; aus Elsbeth, wenn leer, dann logik Telefon1 oder Telefon2 wenn Telefon1 leer
t.verkaeufercode = 
case when case when ask_str_kontakt_telefonnummer != '' then k.ask_str_kontakt_telefonnummer else k.telefon end is null 
then case when t.telefon != '' then t.telefon else t.telefon2 end
else 
case when ask_str_kontakt_telefonnummer != '' then k.ask_str_kontakt_telefonnummer else k.telefon end end,
 t.ergebnis = concat(ifnull(t.ergebnis,''), CHAR(13,10),'Elsbeth:',now(),' letzter Anruf: ', ifnull(k.letzter_anruf_kontakt_datetimeoffset,''), 'Telefon: ',case when ask_str_kontakt_telefonnummer != '' then k.ask_str_kontakt_telefonnummer else k.telefon end,' Status: ', k.status , ' ',ifnull(grund_negativer_ausgang,''),'', ifnull(beschreibung_positiver_ausgang,''),' Agent: ' , ifnull(k.nachname_agenten,''), ' ',ifnull(k.vorname_agenten,'') )
where t.mandant_id = 43 and k.import >= curdate() and k.verarbeitet is null 

