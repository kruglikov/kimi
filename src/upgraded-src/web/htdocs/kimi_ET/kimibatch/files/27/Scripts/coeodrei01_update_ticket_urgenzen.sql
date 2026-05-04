

update ticket  join knpdreiurgenz
on ticket.ticketnr = knpdreiurgenz.ticketnr and ticket.mandant_id = knpdreiurgenz.mandant_id
set dummy_text10 = urgenztext
Where ticket.mandant_id = 27 and ticket.ticketnr = knpdreiurgenz.ticketnr