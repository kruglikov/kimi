<?php
//include ("kimi_general.php");

// Lesen Ticketinformkation 
function getTicketInfo($dbconn, $mandantId, $ticket_id, $fromHauptTicket, &$paramTicket, &$paramrowHauptticket) {
    $ticketData = FALSE;
    $tiRes = FALSE;
    $paramTicket = FALSE;
    $paramrowHauptticket = FALSE;
	
	$columns = "id,
ticketnr,
mandant_id,
hauptticketnr,
aktnummer,
kunde_id,
benutzer_id,
kundennummer,
kimi_decrypt(anrede) anrede,
kimi_decrypt(titel) titel,
kimi_decrypt(nachname) nachname,
kimi_decrypt(vorname) vorname,
kimi_decrypt(plz) plz,
land_id,
kimi_decrypt(ort) ort,
kimi_decrypt(strasse) strasse,
kimi_decrypt(hausnummer) hausnummer,
kimi_decrypt(hausnummer_erw) hausnummer_erw,
kimi_decrypt(telefon) telefon,
kimi_decrypt(email) email,
kimi_decrypt_date(geburtsdatum) geburtsdatum,
kenner,
anruf_status_id,
ergebnis,
wiedervorlage,
wiedervorlage_zeitpunkt,
letzte_wiedervorlage,
letzte_wiedervorlage_zeitpunkt,
wiedervorlage_automatik,
anzahl_anrufe,
letzter_anruf,
status_id,
prioritaet_id,
beginn,
ende,
aufwand,
beschreibung_detail,
geaendert_am,
geaendert_von,
grund_id,
firma_id,
produkt_id,
bewertung,
katalogversand,
emailversand,
textinfo1,
textant11_janein_id,
textant12_nummern_id,
textant21_janein_id,
textant22_nummern_id,
telefon2,
standort,
verkaeufercode,
verkaeufername,
erstzulassung,
kundenzulassung,
markencode,
modell,
amtliches_kennzeichen,
fahrgestellnummer,
kilometer_stand,
textinfo2,
ltzt_wkst_auftrag,
textant31_janein_id,
textant32_nummern_id,
textinfo4,
textant41_janein_id,
textant42_nummern_id,
textinfo3,
textinfo5,
textant51_janein_id,
textant52_nummern_id,
kampagne_id,
dummy_text1,
dummy_text2,
dummy_text3,
dummy_text4,
dummy_text5,
dummy_text6,
dummy_text7,
dummy_text8,
dummy_text9,
dummy_text10,
dummy_number1,
dummy_number2,
dummy_number3,
dummy_number4,
dummy_number5,
dummy_number6,
dummy_number7,
dummy_number8,
dummy_number9,
dummy_number10,
dummy_date1,
dummy_date2,
dummy_date3,
dummy_date4,
dummy_date5,
dummy_date6,
dummy_date7,
dummy_date8,
dummy_date9,
dummy_date10,
dummy_id1,
dummy_id2,
dummy_id3,
dummy_id4,
dummy_id5,
dummy_text11,
dummy_text12,
dummy_text13,
dummy_text14,
dummy_text15,
dummy_text16,
dummy_text17,
dummy_text18,
dummy_text19,
dummy_text20,
leistungsdatum";
	
	
    $sql = "select ".$columns.", getHauptTicketID(t.id) HauptTicketId from ticket t
            where t.id = $ticket_id ";

    $row = executeSQLCmdQuerySingle($dbconn, $mandantId, $sql);
    if ($row !== false) {
       $rowHauptticket = $row;
       if ($row['id'] != $row['HauptTicketId'] ) {
            // Lese Hauptticket
            if ($fromHauptTicket === true) {
                $sql = "select ".$columns." from ticket t
                where t.id = ".$row['HauptTicketId'];

                $result = executeSQLCmdQuerySingle($dbconn, $mandantId, $sql);
                $rowHauptticket = $result;
            }
        }
        $paramTicket = $row;
        $paramrowHauptticket = $rowHauptticket;
    } else {
        return false;
    }
    return true;
}


?>