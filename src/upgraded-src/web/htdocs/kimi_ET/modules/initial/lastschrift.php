<?php

$exists = FALSE;
$lastschrift_id = param("lastschrift", NULL);
$kunde_id = param("kunde");
$kunde_nr = param("kundennummer");
$cur_id = param("cur_id", NULL);
$mode = param("mode", "SEL");
$site = param("s", 0);
$site_count = CONF_PORTAL_LINE_PER_SITE;
$show_new = param("showNew", FALSE);
$show_modify = param("showModify", FALSE);
$show_delete = param("showDelete", FALSE);
$modify_id = param("modify_id", 0);
$can_create = App::$CURRENT->has_permission("lastschrift", "INS");


if (!isset($kunde_id) && !isset($_SESSION["sd-kunde"]) && !isset($kunde_nr)) {
    
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

    $bankleitzahl = Bankleitzahl::get_from_blz(param("blz"));
    if (isset($bankleitzahl)) {
        $show_new = false;
        $show_modify = false;
        $show_delete = false;

        $record = new Lastschrift((object) $_POST);

        $record->set_bankleitzahl_id($bankleitzahl->id);

        $record->set_stammdaten_id($stammdaten->get_id());
        $record->set_mandant_id(App::$CURRENT->MANDANT->get_id());

        $id = Lastschrift::insert($record);
        $stammdaten = Stammdaten::get_by_kunde($kunde_id);
    } else {
        App::$CURRENT->add_error(TXT_ERR_INVALID_BLZ);
    }
}

if ($mode == "UPD") {
    $bankleitzahl = Bankleitzahl::get_from_blz(param("blz"));
    if (isset($bankleitzahl)) {
        $show_new = false;
        $show_modify = false;
        $show_delete = false;

        $edited_id = param("edited_id");

        $current = Lastschrift::get($modify_id);
        $current->add_informations($_POST);

        Lastschrift::update($current, $current->get_id());
    } else {
        App::$CURRENT->add_error(TXT_ERR_INVALID_BLZ);
    }
}
if ($show_modify) {
    $modify = Lastschrift::get($modify_id);
    $exists = true;
}

if ($show_delete) {
    Lastschrift::delete($modify_id);
}

$count = Lastschrift::count(App::$CURRENT->MANDANT->get_id(), $kunde_nr);
$max_site = $count / $site_count;

$lastschriften = Lastschrift::load_items(App::$CURRENT->MANDANT->get_id(), $kunde_nr, $site * $site_count, $site_count);

if (is_array($lastschriften) && count($lastschriften) > 0) {
    if (!isset($cur_id)) {
        $first = $lastschriften[0];
    } else {
        $first = $lastschriften::get($cur_id);
    }
}
?>

