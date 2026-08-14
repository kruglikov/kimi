update ticket 
set status_id = 208, anruf_status_id = 618,ergebnis = '#ergebnis#',dummy_id2 = 26, leistungsdatum = now(),benutzer_id =1,dummy_text13 = 'No_answer',
verkaeufercode=case when TRIM(ifnull(kimi_decrypt(email),'')) != '' then concat('+',TRIM(kimi_decrypt(email))) else concat('+',TRIM(dummy_text7)) end -- dummy_text7 = co_borrower_email
where mandant_id = 43 and id = '#ticketid#'
