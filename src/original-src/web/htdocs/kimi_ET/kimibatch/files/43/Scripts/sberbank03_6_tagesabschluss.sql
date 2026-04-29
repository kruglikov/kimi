-- #8 Wenn TAGESABSCHLUSS  (LAUFEND & TAGESABSCHLUSS )- restliche Tickets auf UNERREICHBAR setzen - aber erst bei der letzten Einarbeitung vom  Tag = Tages ende !!!
update ticket set 
status_id = 208,
anruf_status_id = 611
where mandant_id = 43 and kampagne_id <> 0 and status_id = 210 and anruf_status_id = 615
