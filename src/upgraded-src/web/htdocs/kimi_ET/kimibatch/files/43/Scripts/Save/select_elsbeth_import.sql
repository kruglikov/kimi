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
t.anrede,
t.titel,
t.nachname,
t.vorname,
t.plz, 
t.land_id,
'A' land,
t.ort,
t.strasse strasse_hnr,
--  replace(replace(t.telefon,' ',''),'0043','0043-') telefon , -- 21.21.2021
--  replace(replace(t.telefon2,' ',''),'0043','0043-') telefon2 , -- 21.21.2021
  case when t.telefon != '' then replace(replace(replace(t.telefon,'-',''),' ',''),'0043','0043-') else '' end telefon , -- 21.21.2021
  case when t.telefon2 != '' then replace(replace(replace(t.telefon2,'-',''),' ',''),'0043','0043-') else '' end telefon2, -- 21.21.2021    
 -- (case when ifnull(t.telefon,'') = '' then '' else concat('X11920043',replace(ifnull(TRIM(LEADING '0' FROM t.telefon) ,''),' ','')) end) telefon1  ,
-- (case when ifnull(t.telefon2,'') = '' then '' else concat('X11920043',replace(ifnull(TRIM(LEADING '0' FROM t.telefon2),''),' ','')) end) telefon2,
-- (case when ifnull(t.telefon,'') = '' then '' else concat('10910043',replace(ifnull(TRIM(LEADING '0' FROM '0676845222500') ,''),' ','')) end) telefon1  ,
-- (case when ifnull(t.telefon2,'') = '' then '' else concat('10910043',replace(ifnull(TRIM(LEADING '0' FROM '0676845222555'),''),' ','')) end) telefon2,
t.email,
beginn,
REPLACE( beschreibung_detail, CHAR(13,10), '|' ) kimi_task ,
REPLACE( ergebnis, CHAR(13,10), '|' ) kimi_memo,
concat('http://10.20.12.14/kimi/kimi_ET/index.php?autologin=true&loginuser=elsbeth&mandant=',
t.mandant_id,'&kId=',
t.kampagne_id,
'&ticket_id=',
t.id,'&site=ticket&selected_tickets=',
t.id,'&selected_ticket_index=0&noHeader=true&telefonStarten=N') link, 
concat('''', dummy_text9)   aktnr, 
dummy_text3 glaeubiger,
t.geburtsdatum,

CASE
    WHEN replace(replace(t.telefon,' ',''),'0043','0043-') = '' THEN concat(replace(replace(t.telefon2,' ',''),'0043','0043-'),curdate())
    ELSE concat(replace(replace(t.telefon,' ',''),'0043','0043-'),curdate())
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
  t.mandant_id in ( 40) and (t.status_id in (190) OR (t.status_id in (189) and t.anruf_status_id in (532,533,534,535,612) ) ) 
  and beginn >= '#datum#'
 --and beginn >= '2021-12-22'
