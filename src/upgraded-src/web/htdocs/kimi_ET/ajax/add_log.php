<?php

$time = date("Y-m-d H:i:s");
$user = App::$CURRENT->USER->get_name();
$log = new Log($_POST);

$log->set_benutzer($user);
$log->set_timestamp($time);

$ticket_id = $log->get_objekt_id();
$logart = $log->get_logart();

// 20210702/ab
if (isset($_POST['logUserName']) && $_POST['logUserName'] != "" ) {
	$log->set_benutzer($_POST['logUserName']);
}

if (Log::insert($log)) {
	//set_wiedervorlage($ticket_id, $logart);
	$t=Ticket::get($ticket_id);
	if ($logart=='MAN_START') {
		Ticket::add_anruf($ticket_id, $t->get_mandant_id());	
	}
	$t=Ticket::get($ticket_id);
	$response = array();
	$response['status'] = 'success';
	$response['anzahl_anrufe'] = $t->get_anzahl_anrufe();
	$response['wiedervorlage'] = $t->get_wiedervorlage();
	$response['wiedervorlage_zeitpunkt'] = $t->get_wiedervorlage_zeitpunkt();
	$response['letzter_anruf'] = $t->get_letzter_anruf();
	$response['letzte_wiedervorlage'] = $t->get_letzte_wiedervorlage();
	$response['letzte_wiedervorlage_zeitpunkt'] = $t->get_letzte_wiedervorlage_zeitpunkt();

	$response['anruf_info'] = $t->get_letzter_anruf() . ' Gesamt ' .  $t->get_anzahl_anrufe();
	$response['letzte_wiedervorlage_info'] = $t->get_letzte_wiedervorlage() . ' ' .  $t->get_letzte_wiedervorlage_zeitpunkt();
	echo json_encode($response);
}
?>