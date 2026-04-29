-- #8 Wenn TAGESABSCHLUSS  (LAUFEND & TAGESABSCHLUSS )- restliche Tickets auf UNERREICHBAR setzen - aber erst bei der letzten Einarbeitung vom  Tag = Tages ende !!!
update ticket set 
status_id = 191,
anruf_status_id = 630
where mandant_id = 41 and kampagne_id <> 0 and status_id = 193 and anruf_status_id = 626
 