select
 'ticketid', -- 1
'ticketnr', -- 2
'hauptticketnr', -- 3
'aktnummer', -- 4
'leistungsdatum', -- 5
'anrede', -- 6
'name', -- 7
'plz', -- 8
'ort', -- 9
'strasse', -- 10
'telefon', -- 11
'telefon2',  -- 12
'email', -- 13
 'alternative_email', -- 14
'status_text', -- 14
'anruf_status_text', -- 15
'reasonofdelay_text' , -- 16
'grundbeendigung.text', -- 17
 'maximaler_ptp', -- 18
 'Abbuchungsdatum_wunsch', -- 19
 'mahnsperre_datum', -- 20 
 'vereinbarter_ptp', -- 21
'sepa_janein', -- 22
 'ueberfaelliger_aussenstand', -- 23
 'monatliche_rate', -- 24
 'nummern1.text', -- 25 aktuell nicht belegt
 'loesungsvorschlag', -- 26 
'janein1.text' , -- 27
'janein2.text' , --  28
'janein3.text' , -- 29
'janein4.text' , -- 30
'produkt.text' , -- 31
'mahnsperre_ja_nein' , -- 32 SEPA
'kundennummer', -- 33 
'telefonfalsch_kz', --  34 Telefon falsch
'emailfalsch_kz', -- 35 email falsch
'kontakttelefonnummer', -- 36 Kontakttelefonnummer
'neuetelefonnummer', -- 37 neue Telefonnummer
'telefon1_falsch', -- 38 telefon1 falsch
'telefon2_falsch', -- 39 telefon2 falsch
'statusofthephonecall', -- 40 Status of the phone call
'aktueller_aussenstand', -- aktueller Aussenstand
'ueberfaelliger_aussenstand', -- überfälliger Aussenstand
'ueberfaelliger_aussenstand_zahlbetrag', -- überfälliger Aussenstand Zahlungsbetrag
'co_borrower' , -- co_borrower
-- daten vom Hauptticket
'hauptticketid', -- 41
 'maximaler_ptp_hauptticket', -- 42 
 'abbuchungsdatum_wunsch_hauptticket', -- 43 
  'datum_mahnsperre_hauptticket', -- 44 
 'vereinbarter_ptp_hauptticket', -- 45
 'sepa_hauptticket', -- 46 
'referenz_unterticket_ptp', -- 47
'grund_beendigung_hauptticket' , -- 48 Grund für Beendigung des Anrufs Hauptticket
'reasonofdelay_hauptticket' , -- 49 Reason of delay
'leistungsanstoss_hauptticket' , -- 50 Leistungsanstoss
'anrede_hauptticket', -- 6
'name_hauptticket', -- 7
'plz_hauptticket', -- 8
'ort_hauptticket', -- 9
'strasse_hauptticket', -- 10
'telefon_hauptticket', -- 11
'telefon2_hauptticket',  -- 12
'email_hauptticket', -- 13
 'alternative_email_hauptticket', -- 14
  'maximaler_ptp_hauptticket', -- 18
   'ueberfaelliger_aussenstand_hauptticket', -- 23
      'aktueller_aussenstand_hauptticket' ,
	'aenderung_ja_nein', -- Änderungskenner
'anrede_aend', -- Änderung Anrede
'nachname_aend', -- Änderung Anrede
'plz_aend' , -- Änderung plz
'ort_aend', -- Änderung ort
'strasse_aend', -- Änderung Strasse
'telefon_aend' , -- Änderung telefon
'telefon2_aend', -- Änderung telefon
'email_aend', -- Änderung email
'alternative_email_aend', -- Änderung dummy_text7 = alternative Email
'maximaler_ptp_aend' , -- Änderung maximaler ptp dummy_date1
'ueberfaelliger_aussenstand_aend', -- Änderung überfalliger aussenstand dummy_number4
'aktueller_aussenstand_gesamt_aend', -- Änderung aktueller Aussenstand Gesamt dummy_number 5
'co_borrower_aend' -- Änderung CO_borrower - dummy_text11

from dual
union
select 
-- Daten vom Unterticket
ticket.id,  -- 1
ticket.ticketnr, -- 2
ticket.hauptticketnr, -- 3
aktnummer, -- 4
leistungsdatum, -- 5
ticket.anrede, -- 6
ticket.nachname, -- 7
ticket.plz, -- 8
ticket.ort, -- 9
ticket.strasse, --  10
ticket.telefon, -- 11
ticket.telefon2, -- 12
ticket.email, -- 13
dummy_text7, -- 14 alternative email
status.text, -- 15
anruf_status.text, -- 16 
reasonofdelay.text,  -- 17
grundbeendigung.text, -- 18
 DATE_FORMAT(dummy_date1, '%Y-%m-%d'), -- 19 maximaler PTP
 DATE_FORMAT(dummy_date2, '%Y-%m-%d'), -- 20 Abbuchungsdatum Wunsch
 DATE_FORMAT(dummy_date3, '%Y-%m-%d'), -- 21 Mahnsperre Datum
 DATE_FORMAT(dummy_date4, '%Y-%m-%d'), -- 22 vereinbarter PTP  
produkt.text, -- 23 SEPA - Text JA/NEIN
 REPLACE(REPLACE(FORMAT(dummy_number4, 2),
            ',',
            ''),
        '.',
        ',') , -- 23 überfälliger aussenstand
 dummy_text8, -- 24 monatliche Rate
 nummern1.text, -- 25 aktuell nicht belegt
 nummern2.text, -- 26 Lösungsvorschlag
janein1.text , -- 27
janein2.text , -- 28
janein3.text , -- 29
janein4.text , -- 30
produkt.text , -- 31
grund.text , -- 32 SEPA
ticket.kundennummer, -- 33
dummy_number2, -- 34 Telefon falsch
dummy_number3, -- 35 
verkaeufercode, -- 36 Kontakttelefonnummer
verkaeufername, -- 37 email falsch
modell, -- 38 telefon1 falsch
amtliches_kennzeichen,  -- 39 telefon2 falsch
dummy_text13,  -- 40 Status of the phone call
dummy_number5, -- aktueller Aussenstand
dummy_number4,  -- überfälliger Aussenstand
dummy_number6, -- überfälliger Aussenstand Zahlungsbetrag
dummy_text11, -- co_borrower
   -- daten vom Hauptticket
 (select t2.id from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(LEFT(ticket.ticketnr,3),'000') ), -- 40 hauptticketid
  (select DATE_FORMAT(t2.dummy_date1, '%Y-%c-%d') from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 42 maximaler PTP vom HAUPTTICKET
 (select DATE_FORMAT(t2.dummy_date2, '%Y-%c-%d') from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000')) , -- 43 Abbuchungsdatum Wunsch vom HAUPTTICKET
  (select DATE_FORMAT(t2.dummy_date3, '%Y-%c-%d') from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 44 grund der Mahnsperre vom HAUPTTICKET
 (select DATE_FORMAT(t2.dummy_date4, '%Y-%c-%d') from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 45 vereinbarter PTP vom HAUPTTICKET
 (select p.text from ticket t2
  join produkt p on p.id = t2.produkt_id where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 46 produkt_id für SEPA JA/NEIN
(select t2.markencode from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 47 referenz_unterticket_ptp
 (select d.text from ticket t2
  join dummy_id_referenz d on d.id = t2.dummy_id2 and d.dummy_id = 2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 48 Grund für Beendigung des Anrufs Hauptticket
 (select d.text from ticket t2
  join dummy_id_referenz d on d.id = t2.dummy_id1 and d.dummy_id = 1 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 49 Reason of delay
   (select d.text from ticket t2
  join dummy_id_referenz d on d.id = t2.dummy_id1 and d.dummy_id = 3 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 50 leistungsanstoss

(select t2.anrede from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'anrede_hauptticket', -- 6 --   ticket.anrede, -- 6
(select t2.nachname from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'name_hauptticket', -- 7 ticket.nachname, -- 7
(select t2.plz from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'plz_hauptticket', -- 8 ticket.plz, -- 8
(select t2.ort from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'ort_hauptticket', -- 9 ticket.ort, -- 9
(select t2.strasse from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'strasse_hauptticket', -- 10 ticket.strasse, --  10
(select t2.telefon from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'telefon_hauptticket', -- 11 ticket.telefon, -- 11
(select t2.telefon2 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'telefon2_hauptticket',  -- 12 ticket.telefon2, -- 12
(select t2.email from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'email_hauptticket', -- 13 ticket.email, -- 13
(select t2.dummy_text7 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), --  'alternative_email_hauptticket', -- 14 dummy_text7, -- 14 alternative email
 (select t2.dummy_date1 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'maximaler_ptp_hauptticket', 
  (select t2.dummy_number4 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'ueberfaelliger_aussenstand_hauptticket', -- 23 dummy_number4
  (select t2.dummy_number5 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), --    'aktueller_aussenstand_gesamt_hauptticket' -- 23 dummy_number5

    case -- Schnittstellenänderungen Name, ort, plz nur wenn es Hauptticket its = ticketnr = hauptticketnr
        WHEN
            ticket.anrede <> (select t2.anrede from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                or ticket.nachname <> (select t2.nachname from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                or ticket.plz <> (select t2.plz from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                or ticket.ort <> (select t2.ort from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                or ticket.strasse <> (select t2.strasse from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or ticket.telefon <>   (select t2.telefon from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or ticket.telefon2 <> (select t2.telefon2 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or ticket.email <>  (select t2.email from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                  or ticket.dummy_text7 <>  (select t2.dummy_text7 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or ticket.dummy_date1 <>  (select t2.dummy_date1 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or ticket.dummy_number4 <>   (select t2.dummy_number4 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                  or ticket.dummy_number5 <>  (select t2.dummy_number5 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ) 
				  or ticket.dummy_text11 <>  (select t2.dummy_text11 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ) 
       THEN
            'JA'
        ELSE null
    END aenderung_ja_nein,
        CASE
        WHEN IFNULL(ticket.anrede, '') <> IFNULL((select t2.anrede from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.anrede
        ELSE null
    END anrede_aenderung,
        CASE
        WHEN IFNULL(ticket.nachname, '') <> IFNULL((select t2.nachname from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.nachname
        ELSE null
    END nachname_aenderung,
        CASE
        WHEN IFNULL(ticket.plz, '') <> IFNULL((select t2.plz from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.plz
        ELSE null
    END plz_aenderung,
        CASE
        WHEN IFNULL(ticket.ort, '') <> IFNULL((select t2.ort from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.ort
        ELSE null
    END ort_aenderung,
        CASE
        WHEN IFNULL(ticket.strasse, '') <> IFNULL((select t2.strasse from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.strasse
        ELSE null
    END strasse_aenderung,
        CASE
        WHEN IFNULL(ticket.telefon, '') <> IFNULL((select t2.telefon from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.telefon
        ELSE null
    END telefon_aenderung,
        CASE
        WHEN IFNULL(ticket.telefon2, '') <> IFNULL((select t2.telefon2 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.telefon2
        ELSE null
    END telefon2_aenderung,
        CASE
        WHEN IFNULL(ticket.email, '') <> IFNULL((select t2.email from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.email
        ELSE null
    END emailaenderung,
        CASE
        WHEN IFNULL(ticket.dummy_text7, '') <> IFNULL((select t2.dummy_text7 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.dummy_text7
        ELSE null
    END alternative_email_aenderung,
        CASE
        WHEN IFNULL(ticket.dummy_date1, '') <> IFNULL((select t2.dummy_date1 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.dummy_date1
        ELSE null
    END maximaler_ptp_aenderung,
        CASE
        WHEN IFNULL(ticket.dummy_number4, '') <> IFNULL((select t2.dummy_number4 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.dummy_number4
        ELSE null
    END ueberfaelliger_aussenstand_aenderung,
        CASE
        WHEN IFNULL(ticket.dummy_number5, '') <> IFNULL((select t2.dummy_number5 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.dummy_number5
        ELSE null
    END aktueller_aussenstand_gesamt_aenderung,
	    CASE
        WHEN IFNULL(ticket.dummy_text11, '') <> IFNULL((select t2.dummy_text11 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN ticket.dummy_number5
        ELSE null
    END co_borrower_aenderung
from
    ticket 
        left outer join
    status status ON status.id = ticket.status_id
        left outer join
    prioritaet prioritaet ON prioritaet.id = ticket.prioritaet_id
        left outer join
    benutzer ON benutzer.id = ticket.benutzer_id
        left outer join
    anruf_status ON anruf_status.id = ticket.anruf_status_id
        left outer join
    grund ON grund.id = ticket.grund_id
        left outer join
    firma ON firma.id = ticket.firma_id
        left outer join
    produkt ON produkt.id = ticket.produkt_id
        left outer join
    janein janein1 ON janein1.id = ticket.textant11_janein_id
        left outer join
    janein janein2 ON janein2.id = ticket.textant21_janein_id
        left outer join
    janein janein3 ON janein3.id = ticket.textant31_janein_id
        left outer join
    janein janein4 ON janein4.id = ticket.textant41_janein_id
        left outer join
    nummern nummern1 ON nummern1.id = ticket.textant12_nummern_id
        left outer join
    nummern nummern2 ON nummern2.id = ticket.textant22_nummern_id
            left outer join
    dummy_id_referenz reasonofdelay ON reasonofdelay.id = ticket.dummy_id1
            left outer join
    dummy_id_referenz grundbeendigung ON grundbeendigung.id = ticket.dummy_id2    
	           left outer join
    dummy_id_referenz leistunganstoss ON leistunganstoss.id = ticket.dummy_id3   
        left outer join
    sberbank sberb ON sberb.id = ticket.ticketnr
where
    ticket.mandant_id = 43
        and ticket.prioritaet_id = 223
		and ticket.status_id in (210,211)