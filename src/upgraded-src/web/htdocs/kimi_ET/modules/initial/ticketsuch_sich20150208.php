<?php

if (param("reset", FALSE)) {
    unset($_SESSION["ts-search"]);
}

if (isset($_SESSION["ts-search"]) && !param("search", FALSE)) {
    $_GET = $_SESSION["ts-search"];
}
else {
    $_SESSION["ts-search"] = $_GET;
}

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
$wiedervorlage = param("wiedervorlage", "");
$site = param("s", 0);


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
    array_push($filter, "t.nachname LIKE '%$nachname%'");
}
if (strlen((string) $vorname) > 0) {
    array_push($filter, "t.nachname LIKE '%$vorname%'");
}
if (strlen((string) $benutzer_id) > 0 && $benutzer_id != -1) {
    array_push($filter, "t.benutzer_id = $benutzer_id");
}
if (strlen($kdnr) > 0) {
    array_push($filter, "t.kundennummer = '$kdnr'");
}
if (strlen((string) $plz) > 0) {
    array_push($filter, "t.plz LIKE '%$plz%'");
}
if (strlen((string) $ort) > 0) {
    array_push($filter, "t.ort LIKE '%$ort%'");
}
if (strlen((string) $strasse) > 0) {
    array_push($filter, "t.strasse LIKE '%$strasse%'");
}
if (strlen((string) $hausnummer) > 0) {
    array_push($filter, "t.hausnummer = $hausnummer");
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

//$site = 0; //param("s", 0);
$entry_count = Ticket::count(App::$CURRENT->MANDANT->get_id(), $filter);
$site_count = CONF_PORTAL_LINE_PER_SITE;
//$entry_count = Ticket::count($site * $site_count, $site_count, $filter);

$tickets = Ticket::search($site * $site_count, $site_count, $filter);

$max_site = $entry_count / $site_count;

if (isset($_GET["s"])) {
    $site = $_GET["s"];
}

if ($site > $max_site) {
    $site = $max_site;
}


$prioritaet = Texte::get_prioritaet();
$status = Texte::get_status();
$benutzer = User::get_all_current();
?>