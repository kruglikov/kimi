

update ticket  join knp1urgenz
on ticket.ticketnr = knp1urgenz.ticketnr and ticket.mandant_id = knp1urgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 40 and ticket.ticketnr = knp1urgenz.ticketnr