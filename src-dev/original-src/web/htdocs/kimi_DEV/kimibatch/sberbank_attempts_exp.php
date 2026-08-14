<html>
  <head>
     <title>KIMI-Plus - SBERBANK ATTEMPTS-Export</title>
  </head>
  <body>
  <h1>KIMI-Plus -  SBERBANK ATTEMPTS-Export</h1>
<?PHP include ("db.php");
$heute = date("d.m.Y H:i:s");    
echo "SBERBANK ATTEMPTS-Export - Start: ".$heute;


$query = "select
'client_action', -- prioritaet 
'action_com_chan', -- prioritaet  - text
'direction_of_communications', --
'phone_number_of_the_client', --
'phonenr_of_partner_used', --
'wrong_contact_details' , -- 
'comment', 
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
'grundbeendigung_text', -- 17
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
'aktueller_aussenstand_gesamt_aend' -- Änderung aktueller Aussenstand Gesamt dummy_number 5
from dual
union
select 
-- Daten vom Unterticket
prioritaet.text, -- client action
case when upper(prioritaet.text) like '%OUTBOUND%' THEN 'Phone Call'
	when upper(prioritaet.text) like '%INBOUND%' THEN 'Phone Call'
    when upper(prioritaet.text) like '%SMS%' THEN 'SMS'
    when upper(prioritaet.text) like '%E-MAIL%' THEN 'EMail'
	when upper(prioritaet.text) like '%BRIEF%' THEN 'Brief'
	when upper(prioritaet.text) like '%EINGANG E-Mail%' THEN 'EMail'  
    else 'N.N.' end  , -- ActionComChan
case when upper(prioritaet.text) like '%OUTBOUND%' THEN 'Outbound'
	when upper(prioritaet.text) like '%INBOUND%' THEN 'Inbound'
    when upper(prioritaet.text) like '%SMS%' THEN 'Send SMS'
    when upper(prioritaet.text) like '%E-MAIL%' THEN 'Send EMail'
	when upper(prioritaet.text) like '%BRIEF%' THEN 'Send Brief'
	when upper(prioritaet.text) like '%EINGANG E-Mail%' THEN 'Eingang EMail'  
	when upper(prioritaet.text) like '%EINGANG SMS%' THEN 'Eingang SMS'
    else 'N.N.' end  , -- Direction of communications
case when upper(prioritaet.text) like '%OUTBOUND%' THEN concat('''',
    (select case when TRIM(ifnull(kimi_decrypt(t2.telefon),'')) != '' then concat('''+',TRIM(kimi_decrypt(t2.telefon))) else concat('+',TRIM(kimi_decrypt(t2.telefon2))) end  from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
    )
	when upper(prioritaet.text) like '%INBOUND%' THEN concat('''',
	(select case when TRIM(ifnull(kimi_decrypt(t2.telefon),'')) != '' then concat('''+',TRIM(kimi_decrypt(t2.telefon))) else concat('+',TRIM(kimi_decrypt(t2.telefon2))) end  from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
	)
    when upper(prioritaet.text) like '%SMS%' THEN concat('''',
	(select case when TRIM(ifnull(kimi_decrypt(t2.telefon),'')) != '' then concat('''+',TRIM(kimi_decrypt(t2.telefon))) else concat('+',TRIM(kimi_decrypt(t2.telefon2))) end  from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
	)
    when upper(prioritaet.text) like '%E-MAIL%' THEN (select kimi_decrypt(t2.email) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
	when upper(prioritaet.text) like '%BRIEF%' THEN 'Brief'
	when upper(prioritaet.text) like '%EINGANG E-Mail%' THEN 'EMail Eingang?'  
    else 'N.N.' end  , -- phone_number_of_the_client   
case when upper(prioritaet.text) like '%OUTBOUND%' THEN '+49 69 50958953'
	when upper(prioritaet.text) like '%INBOUND%' THEN 'Inbound'
    when upper(prioritaet.text) like '%SMS%' THEN '+49 151!?SMS?!'
    when upper(prioritaet.text) like '%E-MAIL%' THEN 'zahlungshilfe@sberbankdirect-collections.de'
	when upper(prioritaet.text) like '%BRIEF%' THEN 'Adresse'
	when upper(prioritaet.text) like '%EINGANG E-Mail%' THEN 'zahlungshilfe@sberbankdirect-collections.de'  
	when upper(prioritaet.text) like '%EINGANG SMS%' THEN '+49 151!?SMS?!'
    else 'N.N.' end  , -- phonenr_of_partner_used
case when ifnull(modell,'') != ''  THEN 'Telefon1 falsch'
	when ifnull(amtliches_kennzeichen,'') != ''  THEN 'Telefon2 falsch'
	when ifnull(verkaeufername,'') != '' THEN 'EMail falsch'  
    else 'N' end  , -- wrong_contact_details     
REPLACE(REPLACE(ergebnis, CHAR(13, 10), ' '),
        ';',
        ','), -- ergebnis - Comment    
ticket.id,  -- 1
ticket.ticketnr, -- 2
ticket.hauptticketnr, -- 3
aktnummer, -- 4
DATE_FORMAT(leistungsdatum, '%Y-%m-%d %T') leistungsdatum, -- 5
kimi_decrypt(ticket.anrede), -- 6
kimi_decrypt(ticket.nachname), -- 7
kimi_decrypt(ticket.plz), -- 8
kimi_decrypt(ticket.ort), -- 9
kimi_decrypt(ticket.strasse), --  10
kimi_decrypt(ticket.telefon), -- 11
kimi_decrypt(ticket.telefon2), -- 12
kimi_decrypt(ticket.email), -- 13
dummy_text7, -- 14 alternative email
status.text, -- 15
anruf_status.text, -- 16 
ifnull(reasonofdelay.text,'N/A'),  -- 17
grundbeendigung.text, -- 18
 DATE_FORMAT(dummy_date1, '%Y.%m.%d'), -- 19 maximaler PTP
 DATE_FORMAT(dummy_date2, '%Y.%m.%d'), -- 20 Abbuchungsdatum Wunsch
 DATE_FORMAT(dummy_date3, '%Y.%m.%d'), -- 21 Mahnsperre Datum
 DATE_FORMAT(dummy_date4, '%Y.%m.%d'), -- 22 vereinbarter PTP  
produkt.text, -- 23 SEPA - Text JA/NEIN
 REPLACE(REPLACE(FORMAT(dummy_number4, 2),
            ',',
            ''),
        '.',
        ',') , -- 23 überfälliger aussenstand
 dummy_text8, -- 24 monatliche Rate
 nummern1.text, -- 25 aktuell nicht belegt
case when nummern2.text = '01-Einmalzahlung' then 'PTP'
     when nummern2.text = '04-Restrukturierung' then 'Restrukturierung'
	 when ifnull(nummern2.text,'') = '' then ''
     else nummern2.text end	 , -- 26 Lösungsvorschlag
janein1.text , -- 27
janein2.text , -- 28
janein3.text , -- 29
janein4.text , -- 30
produkt.text , -- 31
grund.text , -- 32 SEPA
ticket.kundennummer, -- 33
dummy_number2, -- 34 Telefon falsch
dummy_number3, -- 35 
concat('''',verkaeufercode), -- 36 Kontakttelefonnummer
verkaeufername, -- 37 email falsch
modell, -- 38 telefon1 falsch
amtliches_kennzeichen,  -- 39 telefon2 falsch
dummy_text13,  -- 40 Status of the phone call
dummy_number5, -- aktueller Aussenstand 
dummy_number4,  -- überfälliger Aussenstand
dummy_number6, -- überfälliger Aussenstand Zahlungsbetrag
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

(select kimi_decrypt(t2.anrede) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'anrede_hauptticket', -- 6 --   ticket.anrede, -- 6
(select kimi_decrypt(t2.nachname) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'name_hauptticket', -- 7 ticket.nachname, -- 7
(select kimi_decrypt(t2.plz) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'plz_hauptticket', -- 8 ticket.plz, -- 8
(select kimi_decrypt(t2.ort) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'ort_hauptticket', -- 9 ticket.ort, -- 9
(select kimi_decrypt(t2.strasse) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'strasse_hauptticket', -- 10 ticket.strasse, --  10
(select kimi_decrypt(t2.telefon) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'telefon_hauptticket', -- 11 ticket.telefon, -- 11
(select kimi_decrypt(t2.telefon2) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'telefon2_hauptticket',  -- 12 ticket.telefon2, -- 12
(select kimi_decrypt(t2.email) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'email_hauptticket', -- 13 ticket.email, -- 13
(select t2.dummy_text7 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), --  'alternative_email_hauptticket', -- 14 dummy_text7, -- 14 alternative email
 (select t2.dummy_date1 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'maximaler_ptp_hauptticket', 
  (select t2.dummy_number4 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), -- 'ueberfaelliger_aussenstand_hauptticket', -- 23 dummy_number4
  (select t2.dummy_number5 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), --    'aktueller_aussenstand_gesamt_hauptticket' -- 23 dummy_number5

    case -- Schnittstellenänderungen Name, ort, plz nur wenn es Hauptticket its = ticketnr = hauptticketnr
        WHEN
            kimi_decrypt(ticket.anrede) <> (select kimi_decrypt(t2.anrede) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                or kimi_decrypt(ticket.nachname) <> (select kimi_decrypt(t2.nachname) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                or kimi_decrypt(ticket.plz) <> (select kimi_decrypt(t2.plz) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                or kimi_decrypt(ticket.ort) <> (select kimi_decrypt(t2.ort) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                or kimi_decrypt(ticket.strasse) <> (select kimi_decrypt(t2.strasse) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or kimi_decrypt(ticket.telefon) <>   (select kimi_decrypt(t2.telefon) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or kimi_decrypt(ticket.telefon2) <> (select kimi_decrypt(t2.telefon2) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or kimi_decrypt(ticket.email) <>  (select kimi_decrypt(t2.email) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                  or ticket.dummy_text7 <>  (select t2.dummy_text7 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or ticket.dummy_date1 <>  (select t2.dummy_date1 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                 or ticket.dummy_number4 <>   (select t2.dummy_number4 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') )
                  or ticket.dummy_number5 <>  (select t2.dummy_number5 from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ) 
       THEN
            'JA'
        ELSE null
    END aenderung_ja_nein,
        CASE
        WHEN IFNULL(kimi_decrypt(ticket.anrede), '') <> IFNULL((select kimi_decrypt(t2.anrede) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN kimi_decrypt(ticket.anrede) 
        ELSE null
    END anrede_aenderung,
        CASE
        WHEN IFNULL(kimi_decrypt(ticket.nachname), '') <> IFNULL((select kimi_decrypt(t2.nachname) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN kimi_decrypt(ticket.nachname) 
        ELSE null
    END nachname_aenderung,
        CASE
        WHEN IFNULL(kimi_decrypt(ticket.plz), '') <> IFNULL((select kimi_decrypt(t2.plz) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN kimi_decrypt(ticket.plz) 
        ELSE null
    END plz_aenderung,
        CASE
        WHEN IFNULL(kimi_decrypt(ticket.ort), '') <> IFNULL((select kimi_decrypt(t2.ort) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN kimi_decrypt(ticket.ort) 
        ELSE null
    END ort_aenderung,
        CASE
        WHEN IFNULL(kimi_decrypt(ticket.strasse), '') <> IFNULL((select kimi_decrypt(t2.strasse) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN kimi_decrypt(ticket.strasse) 
        ELSE null
    END strasse_aenderung,
        CASE
        WHEN IFNULL(kimi_decrypt(ticket.telefon), '') <> IFNULL((select kimi_decrypt(t2.telefon) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN kimi_decrypt(ticket.telefon) 
        ELSE null
    END telefon_aenderung,
        CASE
        WHEN IFNULL(kimi_decrypt(ticket.telefon2), '') <> IFNULL((select kimi_decrypt(t2.telefon2) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN kimi_decrypt(ticket.telefon2) 
        ELSE null
    END telefon2_aenderung,
        CASE
        WHEN IFNULL(kimi_decrypt(ticket.email), '') <> IFNULL((select kimi_decrypt(t2.email) from ticket t2 where t2.mandant_id = 43 and t2.ticketnr = concat(SUBSTR(ticket.ticketnr, 1, length(ticket.ticketnr)-3 ),'000') ), '') THEN kimi_decrypt(ticket.email) 
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
    END aktueller_aussenstand_gesamt_aenderung
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
    sberbank sberb ON sberb.id = ticket.ticketnr
where
    ticket.mandant_id = 43
        and ticket.status_id = 208
		and ticket.prioritaet_id not in (222,223,224)
 ";

$filename = "files/43/OUT/SBERBANK_AttemptsKIMIexp_".date("YmdHis").".csv";
$fp = fopen($filename, 'w');

// Ueberschriftszeile _ KOMMT UEBER SELECT

$string ='Client ID;ACCT_ID;Kontaktliste;Date & Time of Collections measure;ClientAction;ActionComChan;Direction of communications;Phone number of the client;Status of the phone call;Grund fuer Beendigung des Anrufs;Phone nr of Partner used;Date of PTP;PTP amount;Wrong contact details (flag) - for skip tracing;Comment;ReasonOfProblem;E-Mail Aof the client;Address of the client'."\n";; 
fwrite($fp, $string); // will proccess /n as newline ... 
//
$result = mysqli_query($dbconn, $query); 
$i = 1;

while ($line = mysqli_fetch_array($result)) { 
        //fputcsv($fp, array_keys($line));
		//
		
		//2022-02-20
		if ($i > 1 ) {
		$string = $line['kundennummer'].";".$line['aktnummer'].";;".$line['leistungsdatum'].";"; 
		$string = $string.$line['loesungsvorschlag'].";".$line['action_com_chan'].";"; 		
		$string = $string.$line['direction_of_communications'].";".$line['kontakttelefonnummer'].";".$line['anruf_status_text'].";".$line['grundbeendigung_text'].";".$line['phonenr_of_partner_used'].";"; 				
		$string = $string.$line['vereinbarter_ptp'].";".$line['ueberfaelliger_aussenstand_zahlbetrag'].";".$line['wrong_contact_details'].";".$line['client_action']." - ".$line['comment'].";".$line['reasonofdelay_text'].";".$line['email_hauptticket'].";".$line['strasse_hauptticket'].","; 				
		$string = $string.$line['plz_hauptticket']." ".$line['ort_hauptticket'];  				
		$string = $string.";"."\n"; 
        
		//echo $string;
        // being transformed into a newline
        fwrite($fp, $string); // will proccess /n as newline ... 	
		}

		$i = $i + 1;
}


fclose($fp);
$file = $filename;

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

echo "<br>File Download zum Dowload bereit <br>";


$heute = date("d.m.Y H:i:s");    
echo "<br><br>"."SBERBANK ATTEMPTS-Export - Ende: ".$heute;

?>
</body>    
</html>
