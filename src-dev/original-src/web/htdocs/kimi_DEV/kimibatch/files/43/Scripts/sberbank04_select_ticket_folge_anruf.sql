create table sberbank_ticket_folge_anruf
 select * from ticket t where
  t.mandant_id in ( 43) and 
  ((t.status_id in (210)) or 
   (t.status_id in (211)and ifnull(anruf_status_id,'') in ('',600,601,602,603,615))
   )
  and 
  -- MAHNSPERRE vom HAUPTTICKET
  ifnull( (select t2.grund_id from ticket t2 where t2.mandant_id = t2.mandant_id and t2.hauptticketnr = concat(LEFT(t.ticketnr,3),'000') and t2.ticketnr = t2.hauptticketnr) ,216) = 216 -- 216 = NEIN, Default = null
  -- Hauptakt muss bearbeitetbar sein
  and t.id = (
	select t2.id from ticket t2 where t2.mandant_id = 43 and t.aktnummer = t2.aktnummer and t2.hauptticketnr = t2.ticketnr and curdate() between t2.beginn and t2.ende and t2.status_id in (210,211)
	)