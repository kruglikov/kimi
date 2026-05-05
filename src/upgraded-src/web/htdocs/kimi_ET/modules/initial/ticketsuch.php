<?php

if (param("doQuery", false) == true)
    $doquery = true;
else
    $doquery = false;

if (param("reset", FALSE)) {
    unset($_SESSION["ts-search"]);
}

if (isset($_SESSION["ts-search"]) && !param("search", FALSE)) {
    $_GET = $_SESSION["ts-search"];
}
else {
    $_SESSION["ts-search"] = $_GET;
}

$kId = param("kId");

if ($kId != NULL) {
    $_SESSION["kampId"] = $kId;
    User::save_letzte_kampagne_id($kId);
    App::$CURRENT->USER->set_letzte_kampagne_id($kId);
    $kampId = $kId;
}
else if (!isset($_SESSION["kampId"])) {
    header("Location: ./index.php?site=kampauswahl");
}
else {
    $kampId = $_SESSION["kampId"];
}

if (param("debug", FALSE)) {
    var_dump($kampId);
}

if (!file_exists("./modules/gui/templates/tickets/$kampId/ticketsuch.php")) {
    $kampId = 1;
    App::$CURRENT->add_information(TXT_LBL_KAMP_NOT_FOUND);
}

$kampPath = "./modules/gui/templates/tickets/$kampId";
$kamp = Kampagne::load_for_id($kampId);

$filter = array();

$tnr = param("ticketnr", "");
$status_id = param("status_id", "");
$aufgabe = param("aufgabe", "");
$nachname = param("nachname", "");
$vorname = param("vorname", "");
$benutzer_id = param("benutzer_id", "");
$kdnr = ltrim((string) param("kundennummer", ""), "0");
$plz = param("plz", "");
$ort = param("ort", "");
$strasse = param("strasse", "");
$hausnummer = param("hausnummer", "");
$prioritaet_id = param("prioritaet_id", "");
$beginn = param("beginn", "");
$ende = param("ende", "");
$aufwand = param("aufwand", "");
$ergebnis = param("ergebnis", "");
$markencode = param("markencode", "");
$wiedervorlage = param("wiedervorlage", "");
$site = param("s", 0);
$anruf_status_id = param("anruf_status_id", "");
$firma_id = param("firma_id", "");
$telefon = param("telefon", "");
$telefon2 = param("telefon2","");
$dummy_text1 = param("dummy_text1","");
$dummy_text9 = param("dummy_text9","");
// TODO: hier evtl. neu benötigte Variablen hinzufügen!!


// 20211215 - Prüfe ob Encryption aktiv
$isEncryption = App::$CURRENT->isEncryptionEnabled();

if (strlen((string) $tnr) > 0) {
    array_push($filter, "t.ticketnr = $tnr");
}
if (strlen((string) $status_id) > 0 && $status_id != -1) {
    array_push($filter, "t.status_id = $status_id");
}
if (strlen((string) $aufgabe) > 0) {
    array_push($filter, "t.beschreibung_detail LIKE '%$aufgabe%'");
}
if (strlen((string) $nachname) > 0) {
	if ($isEncryption) {
		array_push($filter, "kimi_decrypt(t.nachname) LIKE '%$nachname%'");
	} else {
		array_push($filter, "t.nachname LIKE '%$nachname%'");
	}
}
if (strlen((string) $vorname) > 0) {
	if ($isEncryption) {
		array_push($filter, "kimi_decrypt(t.vorname) LIKE '%$vorname%'");
	} else {
		array_push($filter, "t.vorname LIKE '%$vorname%'");
	}
}
if (strlen((string) $benutzer_id) > 0 && $benutzer_id != -1) {
    array_push($filter, "t.benutzer_id = $benutzer_id");
}
if (strlen($kdnr) > 0) {
    array_push($filter, "t.kundennummer = '$kdnr'");
}
if (strlen((string) $plz) > 0) {
	if ($isEncryption) {
		array_push($filter, "kimi_decrypt(t.plz) LIKE '%$plz%'");
	} else {
		array_push($filter, "t.plz LIKE '%$plz%'");
	}	
}
if (strlen((string) $ort) > 0) {
	if ($isEncryption) {
		array_push($filter, "kimi_decrypt(t.ort) LIKE '%$ort%'");
	} else {
		array_push($filter, "t.ort LIKE '%$ort%'");
	}
}
if (strlen((string) $strasse) > 0) {
	if ($isEncryption) {
		array_push($filter, "kimi_decrypt(t.strasse) LIKE '%$strasse%'");
	} else {
		array_push($filter, "t.strasse LIKE '%$strasse%'");
	}
}
if (strlen((string) $hausnummer) > 0) {
	if ($isEncryption) {
		array_push($filter, "kimi_decrypt(t.hausnummer) LIKE '%$hausnummer%'");
	} else {
		array_push($filter, "t.hausnummer LIKE '%$hausnummer%'");
	}
}
if (strlen((string) $prioritaet_id) > 0 && $prioritaet_id != -1) {
    array_push($filter, "t.prioritaet_id = $prioritaet_id");
}
if (strlen((string) $beginn) > 0) {
    $date = date_create($beginn);
    array_push($filter, "t.beginn = '" . date_format($date, "Y-m-d H:i:s") . "'");
}
if (strlen((string) $ende) > 0) {
    $date = date_create($ende);
    array_push($filter, "t.ende = '" . date_format($date, "Y-m-d H:i:s") . "'");
}
if (strlen((string) $aufwand) > 0) {
    array_push($filter, "t.aufwand = $aufwand");
}
if (strlen((string) $wiedervorlage) > 0) {
    $date = date_create($wiedervorlage);
    array_push($filter, "t.wiedervorlage = '" . date_format($date, "Y-m-d H:i:s") . "'");
}
if (strlen($ergebnis) > 0) {
    array_push($filter, "t.ergebnis LIKE '%$ergebnis%'");
}
if (strlen((string) $markencode) > 0) {
    array_push($filter, "t.markencode LIKE '%$markencode%'");
}
if (strlen((string) $anruf_status_id) > 0 && $anruf_status_id != -1) {
    array_push($filter, "t.anruf_status_id = $anruf_status_id");
}
if (strlen((string) $firma_id) > 0 && $firma_id != -1) {
    array_push($filter, "t.firma_id = $firma_id");
}
if (strlen((string) $telefon) > 0) {
	if ($isEncryption) {
		array_push($filter, "kimi_decrypt(t.telefon) LIKE '%$telefon%'");
	} else {
		array_push($filter, "t.telefon LIKE '%$telefon%'");
	}
}
if (strlen((string) $telefon2) > 0) {
	if ($isEncryption) {
		array_push($filter, "kimi_decrypt(t.telefon2) LIKE '%$telefon2%'");
	} else {
		array_push($filter, "t.telefon2 LIKE '%$telefon2%'");
	}
}
if (strlen((string) $dummy_text1) > 0) {
    array_push($filter, "t.dummy_text1 LIKE '%$dummy_text1%'");
}
if (strlen((string) $dummy_text9) > 0) {
    array_push($filter, "t.dummy_text9 LIKE '%$dummy_text9%'");
}
// TODO: hier evtl. neu benötigte Suchfelder hinzufügen!!

$site_count = CONF_PORTAL_LINE_PER_SITE;
$tickets_selected = array();

if ($kampId!=30)
    $doquery = true;
//$doquery = true;

if ($doquery=="true") {
    $entry_count = Ticket::count(App::$CURRENT->MANDANT->get_id(), $filter, $kampId);
    $tickets = Ticket::search($site * $site_count, $site_count, $filter, $kampId);
    // 20161214/ab
    foreach ($tickets as $t) {
        array_push($tickets_selected, $t->get_id());
    }
}

$max_site = $entry_count / $site_count;
//20191202/ab

if ($kampId==30) {
	$max_site = 1;
}

if (isset($_GET["s"])) {
    $site = $_GET["s"];
}

if ($site > $max_site) {
    $site = $max_site;
}

$prioritaet = Texte::get_prioritaet();
$status = Texte::get_status();
$benutzer = User::get_all_current();
$anruf_status = Texte::get_anruf_status();
$firma = Texte::get_firma();

// TODO: hier evtl. neu benötigte Objekte hinzufügen!!
?>