<?php

$filter = array();
$kunde_nr = ltrim(param("kundennummer"), "0");
$rechnungsnr = param("rechnungsnummer", NULL);

if (isset($_SESSION["sd-kunde"]) && !isset($kunde_nr)) {
    $kunde_nr = $_SESSION["sd-kunde"]->get_kdnr();
}

if (isset($kunde_nr)) {
    array_push($filter, "k.KDNR LIKE '%$kunde_nr%'");
}

if (isset($rechnungsnr)) {
    array_push($filter, "s.rechnungsnummer LIKE '%$rechnungsnr%'");
}

if (!($filter[0] == "k.KDNR LIKE '%%'" && count($filter)==1)) {
    $entry_count = Subkonto::count($filter);
    $site_count = CONF_PORTAL_LINE_PER_SITE;
    $site = 0;
    $max_site = $entry_count / $site_count;

    $more_pages = FALSE;
    if ($max_site > CONF_PORTAL_MAX_PAGES) {
        $max_site = CONF_PORTAL_MAX_PAGES;
        $more_pages = TRUE;
    }

    if (isset($_GET["s"])) {
        $site = $_GET["s"];
    }

    $subkonten = Subkonto::load_items($site * $site_count, $site_count, $filter, FALSE);
} else {
    $entry_count = 0;
    $site_count = 0;
    $site = 0;
    $max_site = 0;
    $more_pages = 0;
    $myfilter = array();
    $myfilter[0] = "k.id=-1";
    $subkonten = Subkonto::load_items($site * $site_count, $site_count, $myfilter, TRUE) ;
}
?>

