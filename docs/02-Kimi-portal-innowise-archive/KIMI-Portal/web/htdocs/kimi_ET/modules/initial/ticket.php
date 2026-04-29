<?php
$ticket_id = param("ticket_id", -1);
$mode = param("mode", "SEL");

// 20220502/ab
$pageStatusInfo = "";

if (isset($_SESSION["kampId"])) {
    $kampId = $_SESSION["kampId"];
}
else {
    App::$CURRENT->add_information(TXT_LBL_KAMP_NOT_SET);
    $kampId = 1;
}

if (!file_exists("./modules/gui/templates/tickets/$kampId/ticket.php")) {
    $kampId = 1;
    App::$CURRENT->add_information(TXT_LBL_KAMP_NOT_FOUND);
}

$kamp = Kampagne::load_for_id($kampId);

if ($ticket_id == -1 && $mode != "INS") {
    $mode = "NEW";
}

if ($mode == "SEL") {
    $ticket = Ticket::get($ticket_id);
	// 20161215/ab
	if ($ticket->get_benutzer_id()=="" | $ticket->get_benutzer_id()=="0" ) {
		$ticket->set_benutzer_id(App::$CURRENT->USER->get_id());
	}
}
else if ($mode == "UPD") {
	// 20160710/Roni
	$check_value = isset($_POST['wiedervorlage_automatik']) ? "1" : "0";
	$_POST['wiedervorlage_automatik'] = $check_value;

    $ticket = new Ticket($_POST);

    // Check 
    if ($kampId == 30) {
        if ($ticket->get_textant12_nummern_id() == 160) {
            $ticket->set_plz('rot');
        }
        if ($ticket->get_textant12_nummern_id() == 161) {
            $ticket->set_plz('gelb');
        }
    }


    Ticket::update($ticket);

    // 20220502/ab
    $pageStatusInfo = "Erfolgreich gespeichert (". date('H:i:s', time()).")";

    if($kampId == 30) {
        header("Location: ./index.php?site=ticketsuch");
    }

}
else if($mode == "INS") {
	// 20160710/Roni
	$check_value = isset($_POST['wiedervorlage_automatik']) ? "1" : "0";
	$_POST['wiedervorlage_automatik'] = $check_value;

    $ticket = new Ticket($_POST);
    $ticket->set_mandant_id(App::$CURRENT->MANDANT->get_id());
    $ticket->set_kampagne_id($kampId);

    // Check 
    if ($kampId == 30) {
        if ($ticket->get_textant12_nummern_id() == 160) {
            $ticket->set_plz('rot');
        }
        if ($ticket->get_textant12_nummern_id() == 161) {
            $ticket->set_plz('gelb');
        }
    }

    // $kampId==CONF_KAMPAGNE_AKT
    $id = Ticket::insert($ticket, ( strpos(CONF_KAMPAGNE_AKT, ".".$kampId.".") != false  ), $kampId);
    if ($id != 0) {
        $mode = "UPD";
        $ticket->set_id($id);
        $ticket_id = $id;
        // 20220502/ab
        $pageStatusInfo = "Erfolgreich gespeichert (". date('H:i:s', time()).")";

    }
    if($kampId == 30) {
        header("Location: ./index.php?site=ticketsuch");
    }

}
else if($mode == "NEW") {
    $ticket = new Ticket(NULL);
	$ticket->set_wiedervorlage_automatik(1);
	$ticket->set_benutzer_id(App::$CURRENT->USER->get_id());
	
}
else if ($mode == "DEL") {
    Ticket::delete($ticket_id);
    header("Location: ./index.php?site=ticketsuch");
}

//20160427
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

// 20220211/ar
$dummy_id1 = Texte::get_dummy_id(1);
$dummy_id2 = Texte::get_dummy_id(2);
$dummy_id3 = Texte::get_dummy_id(3);
$dummy_id4 = Texte::get_dummy_id(4);
$dummy_id5 = Texte::get_dummy_id(5);


// 20160710/Roni
$anrufzeiten = Anrufzeiten::load_all();

// 20161214/ar
$selected_tickets  = param("selected_tickets", "");
$ticket_ids=explode(',', $selected_tickets);
$selected_ticket_index = intval( param("selected_ticket_index", "0"));
$next_ticket_id = "";
$prev_ticket_id = "";
$max_ticket = count($ticket_ids);
if ($selected_ticket_index != 0) {
	$prev_ticket_id = $ticket_ids[$selected_ticket_index-1];	
};
if ($selected_ticket_index != $max_ticket) {
	$next_ticket_id= $ticket_ids[$selected_ticket_index+1];
};

$laender = Country::load_all();
//20170327/ar
$aktBenutzer = Benutzer::get(App::$CURRENT->USER->get_id())


?>
