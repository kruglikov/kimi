select 'kontonummer','ticketnr','anrede','titel','nachname','vorname','plz','ort','strasse_hnr',
'telefon1','email','beginn','ende' from dual
union
select 
aktnummer,
t.ticketnr ,
kimi_decrypt(t.anrede),
kimi_decrypt(t.titel),
kimi_decrypt(t.nachname),
kimi_decrypt(t.vorname),
kimi_decrypt(t.plz), 
kimi_decrypt(t.ort),
kimi_decrypt(t.strasse) strasse_hnr,
  case when kimi_decrypt(t.telefon) != '' then replace(replace(replace(kimi_decrypt(t.telefon),'-',''),' ',''),'0049','0049-') else '' end telefon , -- 21.21.2021
kimi_decrypt( t.email),
beginn,
ende

from ticket t
left outer join mandant m on m.id = t.mandant_id
left outer join kampagne k on k.id = t.kampagne_id
left outer join anruf_status asta on asta.id = t.anruf_status_id
left outer join status s on s.id = t.status_id
                               left outer join prioritaet prioritaet on prioritaet.id = t.prioritaet_id
                               left outer join benutzer on benutzer.id = t.benutzer_id
                               left outer join grund on grund.id = t.grund_id
                               left outer join firma on firma.id = t.firma_id
                               left outer join produkt on produkt.id = t.produkt_id
                               left outer join janein janein1 on janein1.id = t.textant11_janein_id
                               left outer join janein janein2 on janein2.id = t.textant21_janein_id
                               left outer join janein janein3 on janein3.id = t.textant31_janein_id
                               left outer join janein janein4 on janein4.id = t.textant41_janein_id
                               left outer join nummern nummern1 on nummern1.id = t.textant12_nummern_id
                               left outer join nummern nummern2 on nummern2.id = t.textant22_nummern_id
        left outer join benutzer b on b.id = t.benutzer_id

                where 
--   (beginn >= '2020-04-01') and t.mandant_id in ( 32)  and prioritaet_id in (194) and asta.text !='in Recherche' -- and t.ticketnr in (247033,108118,38662)
  --   (beginn >= '2021-05-01') and t.mandant_id in ( 24) -- INKODE
  t.mandant_id in ( 43) and t.status_id in (210,211)  and 
       (curdate() between CAST( beginn AS DATE) and CAST( ende AS DATE) ) and -- Datum des Untertickets noch im Zeitrahmen BEGINN und ENDE
  -- MAHNSPERRE vom HAUPTTICKET
  ifnull( (select t2.grund_id from ticket t2 where t2.mandant_id = t2.mandant_id and t2.hauptticketnr = concat(SUBSTR(t.ticketnr,1,length(t.ticketnr)-3),'000') and t2.ticketnr = t2.hauptticketnr) ,216) = 215 -- 215 = JA,216 = NEIN, Default = null
  --
and
    -- Status vom Hauptticket offen oder in Arbeit
  ifnull( (select t2.status_id from ticket t2 where t2.mandant_id = t2.mandant_id and t2.hauptticketnr = concat(SUBSTR(t.ticketnr,1,length(t.ticketnr)-3),'000') and t2.ticketnr = t2.hauptticketnr) ,208) in( 210,211) -- Hauptticket offen oder in Bearbeitung)
  --
and 
(curdate() between
 ifnull( (select beginn from ticket t2 where t2.mandant_id = t2.mandant_id and t2.hauptticketnr = concat(SUBSTR(t.ticketnr,1,length(t.ticketnr)-3),'000') and t2.ticketnr = t2.hauptticketnr) ,curdate())
and
 ifnull( (select ende from ticket t2 where t2.mandant_id = t2.mandant_id and t2.hauptticketnr = concat(SUBSTR(t.ticketnr,1,length(t.ticketnr)-3),'000') and t2.ticketnr = t2.hauptticketnr) ,curdate())
)  
-- ende Hauptticket-Status
  and ticketnr = hauptticketnr -- geht nur um Hauptticket