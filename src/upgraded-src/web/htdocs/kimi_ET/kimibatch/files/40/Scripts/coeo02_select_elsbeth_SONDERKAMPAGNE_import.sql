select 'kampagne_id','kampagne','kontaktid','ticketnr','kontaktliste_id','kontaktliste','anrede','titel','nachname','vorname','plz','land_id','land','ort','strasse_hnr',
'telefon1','telefon2','email','beginn','kimi_task','kimi_memo','kimi_link','aktnr','glaeubiger','geburtsdatum','Kontaktgruppe Schluessel','exportdatum','urgenztext' from dual
union
select 
t.mandant_id kampagne_id,
m.text kampagne,
t.id kontaktid,
t.ticketnr ,
prioritaet_id kontaktliste_id ,
prioritaet.text kontaktliste, 
kimi_decrypt(t.anrede) anrede,
kimi_decrypt(t.titel) titel,
kimi_decrypt(t.nachname) nachname,
kimi_decrypt(t.vorname) vorname,
kimi_decrypt(t.plz) plz, 
t.land_id,
'A' land,
kimi_decrypt(t.ort) ort,
kimi_decrypt(t.strasse) strasse_hnr,
--  replace(replace(t.telefon,' ',''),'0043','0043-') telefon , -- 21.21.2021
--  replace(replace(t.telefon2,' ',''),'0043','0043-') telefon2 , -- 21.21.2021
  case when kimi_decrypt(t.telefon) != '' then replace(replace(replace(kimi_decrypt(t.telefon),'-',''),' ',''),'0043','0043-') else '' end telefon , -- 21.21.2021
  case when kimi_decrypt(t.telefon2) != '' then replace(replace(replace(kimi_decrypt(t.telefon2),'-',''),' ',''),'0043','0043-') else '' end telefon2, -- 21.21.2021    
 -- (case when ifnull(t.telefon,'') = '' then '' else concat('X11920043',replace(ifnull(TRIM(LEADING '0' FROM t.telefon) ,''),' ','')) end) telefon1  ,
-- (case when ifnull(t.telefon2,'') = '' then '' else concat('X11920043',replace(ifnull(TRIM(LEADING '0' FROM t.telefon2),''),' ','')) end) telefon2,
-- (case when ifnull(t.telefon,'') = '' then '' else concat('10910043',replace(ifnull(TRIM(LEADING '0' FROM '0676845222500') ,''),' ','')) end) telefon1  ,
-- (case when ifnull(t.telefon2,'') = '' then '' else concat('10910043',replace(ifnull(TRIM(LEADING '0' FROM '0676845222555'),''),' ','')) end) telefon2,
kimi_decrypt(t.email) email,
beginn,
REPLACE( beschreibung_detail, CHAR(13,10), '|' ) kimi_task ,
REPLACE( ergebnis, CHAR(13,10), '|' ) kimi_memo,
concat('https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=elsbeth&mandant=',
t.mandant_id,'&kId=',
t.kampagne_id,
'&ticket_id=',
t.id,'&site=ticket&selected_tickets=',
t.id,'&selected_ticket_index=0&noHeader=true&telefonStarten=N') link, 
concat('''', dummy_text9)   aktnr, 
dummy_text3 glaeubiger,
kimi_decrypt_date(t.geburtsdatum),

CASE
    WHEN replace(replace(kimi_decrypt(t.telefon),' ',''),'0043','0043-') = '' THEN concat(replace(replace(kimi_decrypt(t.telefon2),' ',''),'0043','0043-'),curdate())
    ELSE concat(replace(replace(kimi_decrypt(t.telefon),' ',''),'0043','0043-'),curdate())
END kontaktgruppeschluessel  ,
      now()  export,
REPLACE( dummy_text20, CHAR(13,10), '          |          ' ) urgenztext
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
  t.mandant_id in ( 40) and (t.status_id in (190) OR (t.status_id in (189) ))-- and t.anruf_status_id in (532,533,534,535,612) ) ) 
--  and t.ticketnr in (select * from coeoticketnr)
--   and not dummy_text9 in (select dummy_text9 from ticket where mandant_id = 40 and beginn = '2022-03-11' and status_id = 188 and anruf_status_id= 540)
 -- and not dummy_text9 in (select dummy_text9 from ticket where mandant_id = 40 and beginn = '2022-03-23' and status_id = 188 and anruf_status_id= 540)
 -- and not dummy_text9 in (select dummy_text9 from ticket where mandant_id = 40 and beginn = '2022-03-24' and status_id = 188 and anruf_status_id= 540)  
 --  and not dummy_text9 in (select dummy_text9 from ticket where mandant_id = 40 and beginn = '2022-03-25' and status_id = 188 and anruf_status_id= 540)  
 -- and not dummy_text9 in (select dummy_text9 from ticket where mandant_id = 40 and beginn = '2022-03-28' and status_id = 188 and anruf_status_id= 540)    

  and fahrgestellnummer like '%Sonderkampagne%'
  -- and ticketnr between 123543 and 124841  -- Klarn und BNP Standard

 --  
 
 
 -- and ticketnr between 124842 and 125032 -- BNP steger extra
 -- and fahrgestellnummer like '%02 - Klarna%'   -- 2022-03-02 - Test mit reinen Klarna's
  and beginn >= '#datum#'
 -- and beginn >= '2023-05-12' -- MTEL vom 12.5.2023
 -- Sonder OB Anwalt 26.6.2023
--  and ( beginn = '2023-06-28'
-- and ticketnr in (select ticketnr from ticket where mandant_id = 40 and beginn  = '2023-06-28' and status_id =  189 and anruf_status_id = 612 and beschreibung_detail   like '%Sonderkampagne%' and ifnull(ergebnis,'') not like '%Elsbeth:2023-06-28%'
-- ))
-- 2024-03-21
-- and beginn = '2024-03-20' 
-- and beginn = '2024-03-20' -- and not (ifnull(ergebnis,'')  like '%Elsbeth:2024-03-21%')
   -- and beginn = '2025-01-30'   and ticketnr between 267862	and 268081 -- and ticketnr between 268082	and 268433 /*and ticketnr between 162221+1999 and 162221+8999  and not (ifnull(ergebnis,'')  like '%Elsbeth:2024-%') */

  -- and beginn = '2025-05-20'   and ticketnr between 305741	and 305823 -- #1 SonderOutbound_20_05_2025_1_Mai_Klarna 305741	and 305823
  -- and beginn = '2025-05-20'   and ticketnr between 305824	and 305934 -- #2 SonderOutbound_20_05_2025_2_Mai_Klarnaa  305824	and 305934
  -- and beginn = '2025-10-15'   and ticketnr between 358964 and 359302 -- 58788 and 358963 -- #1 SonderOutbound_13_10_2025_1_Klarna_Oktober 176
  -- and beginn = '2025-10-21'   and ticketnr between 361573 and 362293 -- #3 #3 SonderOutbound_21_10_2025_1_Klarna_Oktober 721
   --  and beginn = '2025-11-19'   and ticketnr between  378925 and 379208 -- #1 SonderOutbound_18_11_2025_1_November 284 
--     and beginn = '2025-11-19'   and ticketnr between  379209 and 379355 -- #2 SonderOutbound_18_11_2025_1_November 147
  --   and beginn = '2025-12-22'   and ticketnr between  393666 and 393837 -- #1 SonderOutbound_22_12_2025_Dezember_1 172
     --  and beginn = '2026-01-22'   and ticketnr between  406461  and 407167 -- #2 SonderOutbound_22_01_2026_2_Januar.csv 707
      -- and beginn = '2026-01-22'   and ticketnr between  406281 and 406460-- #1 SonderOutbound_22_01_2026_1_Januar.csv 180
--       and beginn = '2026-01-28'   and ticketnr between  412015 and 412635-- #3 SonderOutbound_27_01_2026_1_Januar.csv 621
	        -- and beginn = '2026-03-09'   and ticketnr between 429620 and 429743 -- #1 SonderOutbound_06_03_2026_1_März_Klarna 124
  	        --  and beginn = '2026-03-09'   and ticketnr between  429744 and 429980 -- #1 SonderOutbound_06_03_2026_2_März_Klarna 237

	         and beginn = '2026-03-26'   and ticketnr between  439174 and 439844 -- #3 SonderOutbound_25_03_2026_1_März 671


  --   and beginn = '2025-12-19'   and ticketnr between  393838 and 379355 -- #2 SonderOutbound_22_12_2025_Dezember_2 171

   -- 17.6.2024
   -- and beginn = '2024-06-17' and ticketnr between 199399 and 200593 -- and not (ifnull(ergebnis,'')  like '%Elsbeth:2024-%')

-- 01.05.2024
-- and beginn = '2024-05-01' /* and not (ifnull(ergebnis,'')  like '%Elsbeth:2024-05-%') */

-- and (t.mandant_id = 40 and t.beginn  = '2023-09-13' and t.status_id =  189 and t.anruf_status_id = 612 and t.beschreibung_detail   like '%Sonderkampagne%' and ifnull(t.ergebnis,'') not like '%Elsbeth:2023-09-13%')
/*
   and ( beginn = '2023-07-20'

and ticketnr in (select ticketnr from ticket where mandant_id = 40 and beginn  = '2023-05-25' and status_id =  189 and anruf_status_id = 612 and beschreibung_detail   like '%Sonderkampagne%' and 
not (ifnull(ergebnis,'')  like '%Elsbeth:2023-07-20%'
)
)*/

