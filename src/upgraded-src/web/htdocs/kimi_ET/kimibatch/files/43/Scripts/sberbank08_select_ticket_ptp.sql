create table sberbank_ticket_ptp
 select * from ticket t where
  t.mandant_id in ( 43) and 
  ((t.status_id in (208, 211)) or  -- offen/erledigt
   (t.status_id in (210)and ifnull(anruf_status_id,'') in ('',600,601,602,603,615,605)) -- in  Bearbeitung
   )
  and 
  -- MAHNSPERRE vom HAUPTTICKET
  ifnull( (select t2.grund_id from ticket t2 where t2.mandant_id = t2.mandant_id and t2.hauptticketnr = concat(LEFT(t.ticketnr,3),'000') and t2.ticketnr = t2.hauptticketnr) ,216) = 216 -- 216 = NEIN, Default = null
  -- Hauptakt muss bearbeitetbar sein
  and t.hauptticketnr = (
	select t2.hauptticketnr from ticket t2 where t2.mandant_id = 43 and t.aktnummer = t2.aktnummer and t2.hauptticketnr = t2.ticketnr and curdate() between t2.beginn and t2.ende and t2.status_id in (210,211)
	)
-- 
	and textant22_nummern_id =  190 -- Einmalzahlung
    and ifnull(dummy_id3,28) = 28 -- PTP muss ncoh auf "setzen" stehen - d. h. es wurde noch kein Leistungsanstoß durchgeführt
	and prioritaet_id not in (208,212,213,226) -- Untertickets PTP Ablauf sicherheitshalber ausschließen