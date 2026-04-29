-- #8 Wenn TAGESABSCHLUSS  (LAUFEND & TAGESABSCHLUSS )- restliche Tickets auf UNERREICHBAR setzen - aber erst bei der letzten Einarbeitung vom  Tag = Tages ende !!!
update ticket set 
status_id = 187,
anruf_status_id = 545
where mandant_id = 40 and kampagne_id <> 0 and status_id = 189 and anruf_status_id = 612
