<?php
$akt_id = param("akt_id", -1);
$ticket_id = param("ticket_id", -1);

$mode = param("mode", "SEL");

//$akt_id = 1;
/*if ($akt_id == -1 && $mode != "INS") {
    $mode = "NEW";
}*/
if ($mode == "SEL") {
    //$akt = Akt::get($akt_id);
    $akt = Akt::get_by_ticket_id($ticket_id);
}
else if ($mode == "UPD") {
    $akt  = new Akt($_POST);
    $ticket_id = $akt->get_ticket_id();
    Akt::update($akt);
    $akt = Akt::get_by_ticket_id($ticket_id);
}
/*else if($mode == "INS") {
    $ticket = new Ticket($_POST);
    $ticket->set_mandant_id(App::$CURRENT->MANDANT->get_id());
    $ticket->set_kampagne_id($kampId);
    //20160427
    if ($kampId!=CONF_KAMPAGNE_AKT ){
        $ticketnr = Ticket::get_next_ticket_nr($kampId);
        $ticket->set_ticketnr($ticketnr);
    }
    
    $id = Ticket::insert($ticket, ($kampId==CONF_KAMPAGNE_AKT));
    if ($id != 0) {
        $mode = "UPD";
        $ticket->set_id($id);
        $ticket_id = $id;
    }
}
else if($mode == "NEW") {
    $akt = new Akt(NULL);
}
else if ($mode == "DEL") {
    Ticket::delete($ticket_id);
    header("Location: ./index.php?site=ticketsuch");
} */

/*
$new_ticket_nr = Ticket::get_next_ticket_nr($kampId);
$prioritaet = Texte::get_prioritaet();
$status = Texte::get_status();
$benutzer = User::get_all_current();
$anruf_status = Texte::get_anruf_status();
$grund = Texte::get_grund();
$firma = Texte::get_firma();
$produkt = Texte::get_produkt();
$janein = Texte::get_janein();
$nummern = Texte::get_nummern();
$laender = Country::load_all();
*/

?>
