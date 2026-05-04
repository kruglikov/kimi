

update ticket  join knp3urgenz
on ticket.ticketnr = knp3urgenz.ticketnr and ticket.mandant_id = knp3urgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 41 and ticket.ticketnr = knp3urgenz.ticketnr