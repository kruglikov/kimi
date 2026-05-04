<?php

$filter = array();
$search = array();

if (param("reset", false)) {
    if (isset($_SESSION["kd-filter"])) {
        unset($_SESSION["kd-filter"]);
    }
    if (isset($_SESSION["kd-order"])) {
        unset($_SESSION["kd-order"]);
    }
}

if (isset($_SESSION["kd-filter"])) {
    $search = $_SESSION["kd-filter"];
    if (isset($_GET["search"])) {
        $s_kunde = new Customer($_GET);
/*
        $search["kdnr"] = mysql_real_escape_string($_GET["kdnr"]);
        $search["nachname"] = mysql_real_escape_string($_GET["nachname"]);
        $search["vorname"] = mysql_real_escape_string($_GET["vorname"]);
        $search["plz"] = mysql_real_escape_string($_GET["plz"]);
        $search["ort"] = mysql_real_escape_string($_GET["ort"]);
        $search["strasse"] = mysql_real_escape_string($_GET["strasse"]);
        $search["hausnummer"] = mysql_real_escape_string($_GET["hausnummer"]);
        $search["telefon"] = mysql_real_escape_string($_GET["telefon"]);
        $search["email"] = mysql_real_escape_string($_GET["email"]);
  */
        $search["kdnr"] = $s_kunde->get_kdnr(FALSE);
        $search["nachname"] = $s_kunde->get_nachname(FALSE);
        $search["vorname"] = $s_kunde->get_vorname(FALSE);
        $search["plz"] = $s_kunde->get_plz(FALSE);
        $search["ort"] = $s_kunde->get_ort(FALSE);
        $search["strasse"] = $s_kunde->get_strasse(FALSE);
        $search["hausnummer"] = $s_kunde->get_hausnummer(FALSE);
        $search["telefon"] = $s_kunde->get_telefon(FALSE);
        $search["email"] = $s_kunde->get_email(FALSE);
 
        $search["geburtsdatum"] = $s_kunde->get_geburtsdatum(FALSE);
        $search["primaerkdnr"] = $s_kunde->get_primaerkdnr(FALSE);
    }
    else {
        $s_kunde = new Customer($search);
    }

} else {
    $search = $_GET;
    $s_kunde = new Customer($_GET);
}

if (isset($search["kdnr"])) {
    $kdnr = ltrim($search["kdnr"], "0");
} else {
    $kdnr = "";
}

if (isset($kdnr) && $kdnr != "") {
    array_push($filter, "KDNR LIKE '%$kdnr%'");
}

if (isset($search["nachname"])) {
    $nachname = $search["nachname"];
} else {
    $nachname = "";
}

if (isset($nachname) && $nachname != "") {
    array_push($filter, "NACHNAME LIKE '%$nachname%'");
}

if (isset($search["vorname"])) {
    $vorname = $search["vorname"];
} else {
    $vorname = "";
}

if (isset($vorname) && $vorname != "") {
    array_push($filter, "VORNAME LIKE '%$vorname%'");
}

if (isset($search["plz"])) {
    $plz = $search["plz"];
} else {
    $plz = "";
}

if (isset($plz) && $plz != "") {
    array_push($filter, "PLZ = $plz");
}

if (isset($search["ort"])) {
    $ort = $search["ort"];
} else {
    $ort = "";
}

if (isset($ort) && $ort != "") {
    array_push($filter, "ORT LIKE '%$ort%'");
}

if (isset($search["strasse"])) {
    $strasse = $search["strasse"];
} else {
    $strasse = "";
}

if (isset($strasse) && $strasse != "") {
    array_push($filter, "STRASSE LIKE '%$strasse%'");
}

if (isset($search["hausnummer"])) {
    $hausnummer = $search["hausnummer"];
} else {
    $hausnummer = "";
}

if (isset($hausnummer) && $hausnummer != "") {
    array_push($filter, "HAUSNUMMER LIKE '%$hausnummer%'");
}

if (isset($search["telefon"])) {
    $telefon = $search["telefon"];
} else {
    $telefon = "";
}

if (isset($telefon) && $telefon != "") {
    array_push($filter, "TELEFON LIKE '%$telefon%'");
}

if (isset($search["email"])) {
    $email = $search["email"];
} else {
    $email = "";
}

if (isset($email) && $email != "") {
    array_push($filter, "EMAIL LIKE '%$email%'");
}

if (isset($search["geburtsdatum"])) {
    $geburtsdatum = $search["geburtsdatum"];
} else {
    $geburtsdatum = "";
}

if (isset($geburtsdatum) && $geburtsdatum != "") {
    array_push($filter, "GEBURTSDATUM = " . $s_kunde->get_geburtsdatum(TRUE));
}

if (isset($search["primaerkdnr"])) {
    $primaerkdnr = $search["primaerkdnr"];
} else {
    $primaerkdnr = "";
}

if (isset($primaerkdnr) && $primaerkdnr != "") {
    array_push($filter, "primaerkdnr LIKE '%$primaerkdnr%'");
}

if (isset($_GET["search"])) {
    $_SESSION["kd-filter"] = $search;
}

if (isset($_GET["order"])) {
    $_SESSION["kd-order"] = $_GET["order"];
}

if (isset($_SESSION["kd-order"])) {
    $order = $_SESSION["kd-order"];
} else {
    $order = "1";
}

$entry_count = Customer::count(App::$CURRENT->MANDANT->get_id(), $filter);
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

if ($site > $max_site) {
    $site = $max_site;
}

$customers = Customer::load_items(App::$CURRENT->MANDANT->get_id(), $site * $site_count, $site_count, $filter, $order);

?>