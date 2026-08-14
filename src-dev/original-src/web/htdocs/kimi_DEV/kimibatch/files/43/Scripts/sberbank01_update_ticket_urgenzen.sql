

update ticket  join sberbankurgenz
on ticket.ticketnr = sberbankurgenz.ticketnr and ticket.mandant_id = sberbankurgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 43 and ticket.ticketnr = sberbankurgenz.ticketnr