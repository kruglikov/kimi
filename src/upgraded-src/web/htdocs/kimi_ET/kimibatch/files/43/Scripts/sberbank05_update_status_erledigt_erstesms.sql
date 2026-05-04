update ticket 
set status_id = 208, anruf_status_id = 618,ergebnis = '#ergebnis#',dummy_id2 = 26, leistungsdatum = now(),benutzer_id =1,dummy_text13 = 'No_answer',
verkaeufercode=case when TRIM(ifnull(telefon,'')) != '' then concat('',TRIM(telefon)) else concat('',TRIM(telefon2)) end
where mandant_id = 43 and id = '#ticketid#'
