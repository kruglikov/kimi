-- #8 Wenn TAGESABSCHLUSS  (LAUFEND & TAGESABSCHLUSS )- restliche Tickets auf UNERREICHBAR setzen - aber erst bei der letzten Einarbeitung vom  Tag = Tages ende !!!
update ticket set 
status_id = 117,
anruf_status_id = 379
where mandant_id = 27 and kampagne_id <> 0 and status_id = 119 and anruf_status_id = 633
 