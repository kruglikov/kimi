<?php

$filter = sess("filter", array(), "ss-");

if (param("reset", FALSE)) {
    $filter = array();
    $_SESSION["ss-filter"] = NULL;
    $_SESSION["ss-kdnr"] = NULL;
    $_SESSION["ss-zahltag"] = NULL;
    $_SESSION["ss-abrechnungstag"] = NULL;
    $_SESSION["ss-mahnsperre"] = NULL;
    $_SESSION["ss-mahnsperre_datum"] = NULL;
}

$site = param("s", 0);
$site_count = CONF_PORTAL_LINE_PER_SITE;
$kdnr = ltrim(param("kdnr", sess("kdnr", "", "ss-")), "0");
$zahltag = param("zahltag", sess("zahltag", "", "ss-"));
$abrechnungstag = param("abrechnungstag", sess("abrechnungstag", "", "ss-"));
$mahnsperre = param("mahnsperre", sess("mahnsperre", "", "ss-"));
$mahnsperre_datum = param("mahnsperre_datum", sess("mahnsperre_datum", "", "ss-"));

if (strlen($kdnr) != 0) {
    $filter["kdnr"] = "k.kdnr LIKE '%$kdnr%'";
    $_SESSION["ss-kdnr"] = $kdnr;
}
else {
    unset($filter["kdnr"]);
    unset($_SESSION["ss-kdnr"]);
}

if (strlen($zahltag != 0)) {
    $new_date = date_create($zahltag);
    $new_date = date_format($new_date, "Y-m-d");
    $filter["zahltag"] = "s.zahltag = '$new_date'";
    $_SESSION["ss-zahltag"] = $zahltag;
}
else {
    unset($filter["zahltag"]);
    unset($_SESSION["ss-zahltag"]);
}

if (strlen($abrechnungstag) != 0) {
    $new_date = date_create($abrechnungstag);
    $new_date = date_format($new_date, "Y-m-d");
    $filter["stichtag"] = "s.stichtag = '$new_date'";
    $_SESSION["ss-abrechnungstag"] = $abrechnungstag;
}
else {
    unset($filter["stichtag"]);
    unset($_SESSION["ss-abrechnungstag"]);
}
if (strlen($mahnsperre) != 0) {
    $filter["mahnsperre"] = "s.mahnsperre LIKE '$mahnsperre'";
    $_SESSION["ss-mahnsperre"] = $mahnsperre;
}
else {
    unset($filter["mahnsperre"]);
    unset($_SESSION["ss-mahnsperre"]);
}

if (strlen($mahnsperre_datum) != 0) {
    $new_date = date_create($mahnsperre_datum);
    $new_date = date_format($new_date, "Y-m-d");
    $filter["mahnsperre_datum"] = "s.mahnsperre_datum = '$new_date'";
    $_SESSION["ss-mahnsperre_datum"] = $mahnsperre_datum;
}
else {
    unset($filter["mahnsperre_datum"]);
    unset($_SESSION["ss-mahnsperre_datum"]);
}

$_SESSION["ss-filter"] = $filter;

//$count = Stammdaten::count_results(App::$CURRENT->MANDANT->get_id(), $site * $site_count, $site_count, $filter);
$count = Stammdaten::count(App::$CURRENT->MANDANT->get_id(), $filter);
$stammdaten = Stammdaten::search(App::$CURRENT->MANDANT->get_id(), $site * $site_count, $site_count, $filter);

$max_site = $count / $site_count;

$more_pages = FALSE;
if ($max_site > CONF_PORTAL_MAX_PAGES) {
    $max_site = CONF_PORTAL_MAX_PAGES;
    $more_pages = TRUE;
}

?>

