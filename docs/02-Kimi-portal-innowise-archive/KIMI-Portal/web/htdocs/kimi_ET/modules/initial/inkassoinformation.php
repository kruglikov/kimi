<?php

$exists = FALSE;
$inkassoinformation_id = param("inkassoinformation", NULL);
$kunde_id = param("kunde");
$kunde_nr = param("kundennummer");
$kunde_nr_backup = param("kundennummer_backup");
$cur_inkassoinformation_id = param("cur_id", NULL);
$mode = param("mode", "SEL");
$site = param("s", 0);
$site_count = CONF_PORTAL_LINE_PER_SITE;
$show_new = param("showNew", FALSE);
$show_modify = param("showModify", FALSE);
$modify_id = param("modify_id", 0);
$update_ikinfo_id = param("update_ikinfo_oid", 0);
$can_create = App::$CURRENT->has_permission("inkassoinformation", "INS");

if (!isset($kunde_id) && !isset($_SESSION["sd-kunde"]) && !isset($kunde_nr)) {

    //header("Location: index.php?site=stammsuche");
    // exit;
} else if (!isset($kunde_id) && !isset($kunde_nr)) {

    $kunde = $_SESSION["sd-kunde"];

    $kunde_id = $kunde->get_id();
} else if (!isset($kunde_nr)) {

    $kunde = Customer::get($kunde_id);

    $_SESSION["sd-kunde"] = $kunde;
} else {
    $kunde = Customer::get_by_kunde_nr($kunde_nr, App::$CURRENT->MANDANT->get_id());
    $kunde_id = $kunde->get_id();

    if (!isset($kunde_id)) {
        $kunde = Customer::get_by_kunde_nr($kunde_nr_backup, App::$CURRENT->MANDANT->get_id());
        $kunde_id = $kunde->get_id();
        App::$CURRENT->add_error(MSG_NO_RESULTS);

        if (!isset($kunde_id)) {
            unset($kunde);
        }
    }

    if (isset($kunde)) {
        $_SESSION["sd-kunde"] = $kunde;
    } else {
        unset($_SESSION["sd-kunde"]);
    }
}

if (!isset($kunde_nr) && isset($kunde)) {
    $kunde_nr = $kunde->get_kdnr();
}

if (isset($kunde_id)) {
    $stammdaten = Stammdaten::get_by_kunde($kunde_id);
}



if ($mode == "INS") {
    $show_new = false;
    $show_modify = false;

    $inkasso = new Inkassoinformation((object) $_POST);
    if ($inkasso->get_ausbuchungsgrund_id(TRUE) == -1) {
        $inkasso->set_ausbuchungsgrund_id(null);
    }
    if ($inkasso->get_erled_qual_id(TRUE) == -1) {
        $inkasso->set_erled_qual_id(null);
    }
    if ($inkasso->get_ra_ikbuero_id(TRUE) == -1) {
        $inkasso->set_ra_ikbuero_id(null);
    }

    $inkasso->set_kundennummer($kunde_nr);
    $inkasso->set_kunde_id($kunde_id);

    $id = Inkassoinformation::insert($inkasso);
    $stammdaten = Stammdaten::get_by_kunde($kunde_id);
    if ($inkasso->get_ra_ikbuero_id(TRUE) > 0) {
        $stammdaten->set_ra_ikbuero_id($inkasso->get_ra_ikbuero_id(TRUE));
    } else {
        $stammdaten->set_ra_ikbuero_id(NULL);
    }
    $stammdaten->set_status_dat($inkasso->get_status_dat());

    $stammdaten->set_inkassostatus_id($inkasso->get_inkassostatus_id(TRUE));
    Stammdaten::update($stammdaten);
}

if ($mode == "UPD") {
    $show_new = false;
    $show_modify = false;

    $edited_id = param("edited_id");

    $current = Inkassoinformation::get($modify_id);
    $current->add_informations($_POST);

    if ($current->get_ausbuchungsgrund_id(TRUE) == -1) {
        $current->set_ausbuchungsgrund_id(null);
    }
    if ($current->get_erled_qual_id(TRUE) == -1) {
        $current->set_erled_qual_id(null);
    }
    if ($current->get_ra_ikbuero_id(TRUE) == -1) {
        $current->set_ra_ikbuero_id(null);
    }

    Inkassoinformation::update($current, $current->get_id());

    if ($current->get_id() == $current->get_max_id() || 1==1) {
        $stammdaten = Stammdaten::get_by_kunde($kunde_id);
        if ($current->get_ra_ikbuero_id(TRUE) > 0) {
            $stammdaten->set_ra_ikbuero_id($current->get_ra_ikbuero_id(TRUE));
        } else {
            $stammdaten->set_ra_ikbuero_id(NULL);
        }
        $stammdaten->set_status_dat($current->get_status_dat());
        $stammdaten->set_inkassostatus_id($current->get_inkassostatus_id(TRUE));
        Stammdaten::update($stammdaten);
    }
}

if ($show_modify) {
    $inkasso_modify = Inkassoinformation::get($modify_id);
    $exists = true;
}

$count = Inkassoinformation::count(App::$CURRENT->MANDANT->get_id(), $kunde_nr);
$max_site = $count / $site_count;

$inkassoinfo = Inkassoinformation::load_items(App::$CURRENT->MANDANT->get_id(), $kunde_nr, $site * $site_count, $site_count);

if (count($inkassoinfo) > 0) {
    if (!isset($cur_inkassoinformation_id)) {
        $first = $inkassoinfo[0];
    } else {
        $first = Inkassoinformation::get($cur_inkassoinformation_id);
    }
}
$ikstat = IKStatus::load_all();
$ikbueros = IKBuero::load_all($kunde->get_markt());
$verwaltungssatz = Verwaltungssatz::get_aktuell2(App::$CURRENT->MANDANT->get_id(), $kunde->get_markt());
//$sk_gessaldo = Subkonto::get_gessaldo(App::$CURRENT->MANDANT->get_id(), $kunde_nr);
$sk_gessaldo = number_format((float) Subkonto::get_gessaldo(App::$CURRENT->MANDANT->get_id(), $kunde_nr), 2, ",", ".");
$ausbuchungsgrund = Ausbuchungsgrund::load_all();
$erled_qual = Erled_Qual::load_all();

//    echo "Markt=".$kunde->get_anrede_id();
//    exit;
?>

