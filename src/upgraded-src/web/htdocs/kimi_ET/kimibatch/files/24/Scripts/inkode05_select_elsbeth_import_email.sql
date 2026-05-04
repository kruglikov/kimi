  select 'kampagne_id','kampagne','kontaktid','ticketnr','kontaktliste_id','kontaktliste','anrede','titel','nachname','vorname','plz','land_id','land','ort','strasse_hnr',
'telefon1','telefon2','email','beginn','kimi_task','kimi_memo','kimi_link','aktnr','glaeubiger','geburtsdatum','Kontaktgruppe Schluessel','exportdatum',
'saldo','sachbearbeiter','iban','bic'
 from dual
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
RTRIM(kimi_decrypt(t.nachname)),
RTRIM(kimi_decrypt(t.vorname)),
kimi_decrypt(t.plz), 
t.land_id,
'DE' land,
kimi_decrypt(t.ort),
kimi_decrypt(t.strasse) strasse_hnr,
-- concat('0049-',replace(t.telefon,' ','')) telefon , -- 21.21.2021
  concat('0049-','1703712712')  telefon , -- 08.07.2022
 --  concat('0049-',replace(t.telefon2,' ','')) telefon2, -- 21.21.2021
 null, -- case when kimi_decrypt(t.telefon2) != '' then concat('0049-',replace(kimi_decrypt(t.telefon2),' ','')) else '' end telefon2, -- 08.07.2022
 -- (case when ifnull(t.telefon,'') = '' then '' else concat('X11920043',replace(ifnull(TRIM(LEADING '0' FROM t.telefon) ,''),' ','')) end) telefon1  ,
 -- (case when ifnull(t.telefon2,'') = '' then '' else concat('X11920043',replace(ifnull(TRIM(LEADING '0' FROM t.telefon2),''),' ','')) end) telefon2,
 -- (case when ifnull(t.telefon,'') = '' then '' else concat('10910043',replace(ifnull(TRIM(LEADING '0' FROM '0676845222500') ,''),' ','')) end) telefon1  ,
 -- (case when ifnull(t.telefon2,'') = '' then '' else concat('10910043',replace(ifnull(TRIM(LEADING '0' FROM '0676845222555'),''),' ','')) end) telefon2,
kimi_decrypt(t.email),
beginn,
REPLACE( beschreibung_detail, CHAR(13,10), '|' ) kimi_task ,
REPLACE( ergebnis, CHAR(13,10), '|' ) kimi_memo ,
 
 concat('https://10.196.69.11/kimi_ET/index.php?autologin=true&loginuser=elsbeth&mandant=',
t.mandant_id,'&kId=',
t.kampagne_id,
'&ticket_id=',
t.id,'&site=ticket&selected_tickets=',
t.id,'&selected_ticket_index=0&noHeader=true&telefonStarten=A') link,
concat(': ',LPAD(truncate(indexa,0), 5, '0'),' ',LPAD(truncate(indexb,0), 10, '0'),' ',LPAD(truncate(indexc,0), 4, '0'))   aktnr, 
fahrgestellnummer glaeubiger,
-- t.geburtsdatum, -- 21.21.2021
case when kimi_decrypt(t.geburtsdatum) = '   0.00.00' then '' else kimi_decrypt(t.geburtsdatum) end geburtsdatum, -- 21.21.2021
concat(RTRIM(ifnull(kimi_decrypt(t.nachname),'')),RTRIM(ifnull(kimi_decrypt(t.vorname),'')),ifnull(kimi_decrypt(t.geburtsdatum),''),curdate()) kontaktgruppeschluessel ,
      now()  export,
      concat('€ ',FORMAT(dummy_number4, 2, 'de_DE') ) Saldo,
kenner sachbearbeiter,
dummy_text1 iban,
dummy_text2 bic

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
		left outer join inkode on inkode.id = t.ticketnr
		

	where 
--   (beginn >= '2020-04-01') and t.mandant_id in ( 32)  and prioritaet_id in (194) and asta.text !='in Recherche' -- and t.ticketnr in (247033,108118,38662)
  --   (beginn >= '2021-05-01') and t.mandant_id in ( 24) -- INKODE
 (beginn >= '2021-05-01') and
  -- t.mandant_id in ( 24) and (t.status_id in (104) OR (t.status_id in (10300000) and t.anruf_status_id in (329,330,331,332) ) )
   t.mandant_id in ( 24) and t.status_id in (101) and t.anruf_status_id in (333)   -- and beginn >= '2021-07-12'
  and (upper(dummy_text10) like '%$EMAIL%' or upper(dummy_text10) like '%$KONTAKTRATE%')
