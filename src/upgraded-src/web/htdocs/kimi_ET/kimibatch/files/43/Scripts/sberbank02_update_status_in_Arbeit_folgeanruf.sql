-- Statement in Verbindung mit sberbank02_select_elsbeth_import_ersteranruf.sql 
-- die gleichen Selektionskriterien !
-- 
update ticket 
set status_id = 210, anruf_status_id = 615
where mandant_id = 43 and status_id = 211 and kampagne_id > 0
and ifnull(grund_id,'216') = 216 -- 216 = NEIN, Default = null
and prioritaet_id = 204 -- Erster Anruf (Outbound)
