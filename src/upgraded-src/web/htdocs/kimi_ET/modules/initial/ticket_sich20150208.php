<?php
$ticket_id = param("ticket_id", -1);
$mode = param("mode", "SEL");

if ($ticket_id == -1 && $mode != "INS") {
    $mode = "NEW";
}

if ($mode == "SEL") {
    $ticket = Ticket::get($ticket_id);
}
else if ($mode == "UPD") {
    $ticket = new Ticket($_POST);
    Ticket::update($ticket);
}
else if($mode == "INS") {
    $ticket = new Ticket($_POST);
    $ticket->set_mandant_id(App::$CURRENT->MANDANT->get_id());
    $id = Ticket::insert($ticket);
    if ($id != 0) {
        $mode = "UPD";
        $ticket->set_id($id);
        $ticket_id = $id;
    }
}
else if($mode == "NEW") {
    $ticket = new Ticket(NULL);
}
else if ($mode == "DEL") {
    Ticket::delete($ticket_id);
    header("Location: ./index.php?site=ticketsuch");
}


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

?>
