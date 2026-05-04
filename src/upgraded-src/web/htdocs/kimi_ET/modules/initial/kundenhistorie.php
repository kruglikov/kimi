<?php

$anstoss = Anstoss::load_all();
$kategorie = Kategorie::load_all();
$ben = Benutzer::load_all(App::$CURRENT->MANDANT->get_id());
$exists = FALSE;
$kundenhistorie_id = param("kundenhistorie", NULL);
$kunde_id = param("kunde");
$kunde_nr = param("kundennummer");
$cur_kundenhistorie_id = param("cur_id", NULL);
$mode = param("mode", "SEL");
$site = param("s", 0);
$site_count = CONF_PORTAL_LINE_PER_SITE;
$show_new = param("showNew", FALSE);
$show_modify = param("showModify", FALSE);
$modify_id = param("modify_id", 0);
$can_create = App::$CURRENT->has_permission("kundenhistorie", "INS");

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

    $kh = new Kundenhistorie((object) $_POST);
    
    $kh->set_benutzer_id1(App::$CURRENT->USER->get_id());
    
    $kh->set_mandant_id(App::$CURRENT->MANDANT->get_id());
    $kh->set_kunde_id($kunde_id);
    if ($kh->get_anstoss_id() == -1) {
        $kh->set_anstoss_id(null);
    }
    if ($kh->get_kategorie_id() == -1) {
        $kh->set_kategorie_id(null);
    }

    $id = Kundenhistorie::insert($kh);
}

if ($mode == "UPD") {
    $show_new = false;
    $show_modify = false;

    $edited_id = param("edited_id");

    $current = Kundenhistorie::get($modify_id);
    $current->add_informations($_POST);

    //Kundenhistorie::update($current, $current->get_id());
   
}

if ($show_modify) {
    $kh_modify = Kundenhistorie::get($modify_id);
    $exists = true;
}

$count = Kundenhistorie::count(App::$CURRENT->MANDANT->get_id(), $kunde_nr);
$max_site = $count / $site_count;

$kundenhistorie = Kundenhistorie::load_items(App::$CURRENT->MANDANT->get_id(), $kunde_nr, $site * $site_count, $site_count);

if (count($kundenhistorie) > 0) {
    if (!isset($cur_kundenhistorie_id)) {
        $first = $kundenhistorie[0];
    } else {
        $first = Kundenhistorie::get($cur_kundenhistorie_id);
    }
}
?>

