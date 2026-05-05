<?php

$subkonto_id = param("subkonto", NULL);
$cur_subkonto_id = param("cur_id", NULL);
$mode = param("mode", "SEL");
$site = param("s", 0);
$site_count = CONF_PORTAL_LINE_PER_SITE;
$show_new = param("showNew", FALSE);
$can_create = App::$CURRENT->has_permission("subdetail", "INS");
$user_default_bua_bgr_key = App::$CURRENT->USER->get_default_bua_bgr_key();
$user_default_belegdatum = App::$CURRENT->USER->get_default_belegdatum();
$default_belegdatum = param("default_belegdatum", NULL);
$default_bua_bgr_man_id = param("default_bua_bgr_man_id", NULL);
if ($default_bua_bgr_man_id == "-1") {
    $default_bua_bgr_man_id = "";
}
$default_enable_calc_button = FALSE;
$default_is_plus = FALSE;
$button_calc_label = TXT_LBL_SK_BTN_CALC;
$default_bugru_typ = 0;
if ($user_default_bua_bgr_key != "" && strpos(CONF_SKBUCH_ENABLE_BTN_NRATE,$user_default_bua_bgr_key)!==FALSE) {
    $default_enable_calc_button = TRUE;
    $default_bugru_typ = 1;
}
else if ($user_default_bua_bgr_key != "" && strpos(CONF_SKBUCH_ENABLE_BTN_MAHNGEB,$user_default_bua_bgr_key)!==FALSE) {
    $default_enable_calc_button = TRUE;
    $default_bugru_typ = 2;
}

$user_id = App::$CURRENT->USER->get_id();

if (!isset($subkonto_id)) {
    header("Location: index.php?site=subsuche");
}

if (!isset($kunde_id) && !isset($_SESSION["sd-kunde"]) && !isset($kunde_nr)) {
    //header("Location: index.php?site=stammsuche");
    // exit;
} else if (!isset($kunde_id) && !isset($kunde_nr)) {
    $kunde = $_SESSION["sd-kunde"];
    $kunde = Customer::get($kunde->get_id());
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

if ($mode == "INS") {

    $show_new = false;
    $bugru_id = param("bugru_id", -1);
    $current = Subkonto::get_current($subkonto_id);
    /*    if ($bugru_id >= 0) {
      $bua_bgr_man_id = Buchungsgrund::get_bua_bgr_man_id(App::$CURRENT->MANDANT->get_id(), $bugru_id);
      } else {
      $bua_bgr_man_id = "NULL";
      } */
    $kz_aktuell = param("kz_aktuell", FALSE);
    if ($kz_aktuell) {
        $kz_aktuell = "J";
    } else {
        $kz_aktuell = "NULL";
    }

    $current->add_informations($_POST, FALSE);
    $current->set_kz_aktuell($kz_aktuell);

    if (substr($current->get_bua_bgr_man_id(), strlen($current->get_bua_bgr_man_id()) - 4, 4) == CONF_SKBUCH_CLEAR_BETRAG) {
        $current->set_buchungsbetrag(0);
    }

    //$current->set_bua_bgr_man_id($bua_bgr_man_id);
    //$current->set_bugru_id($bugru_id);
    Subkonto::insert($current);

    if ($default_belegdatum != $user_default_belegdatum || $default_bua_bgr_man_id != $user_default_bua_bgr_key) {
        App::$CURRENT->USER->set_default_belegdatum($default_belegdatum);
        App::$CURRENT->USER->set_default_bua_bgr_key($default_bua_bgr_man_id);
        Benutzer::update_default_werte($user_id, $default_belegdatum, $default_bua_bgr_man_id);
    }
} else if ($mode == "UPD") {

    $show_new = false;
    $bugru_id = param("bugru_id", -1);
    $edited_id = param("edited_id");

    if ($bugru_id >= 0) {
        $bua_bgr_man_id = Buchungsgrund::get_bua_bgr_man_id(App::$CURRENT->MANDANT->get_id(), $bugru_id);
    } else {
        $bua_bgr_man_id = "NULL";
    }

    $current = Subkonto::get_current($edited_id);
    $current->add_informations($_POST);
    $current->set_bua_bgr_man_id($bua_bgr_man_id);
    $current->set_bugru_id($bugru_id);

    Subkonto::update($current);
}

$subkonten = Subkonto::get_all_for_subkonto($subkonto_id, $site * $site_count, $site_count);
$verwaltungssatz = Verwaltungssatz::get_aktuell2(App::$CURRENT->MANDANT->get_id(), $kunde->get_markt());
if (is_array($subkonten) && count($subkonten) > 0) {
    if (!isset($cur_subkonto_id)) {
        $first = $subkonten[0];
    } else {
        $first = Subkonto::get($cur_subkonto_id);
    }
    $kunde_nr = $first->get_kdnr();
    $rechnung_nr = $first->get_rechnungsnummer();
    $buchungsgruende = Buchungsgrund::load(App::$CURRENT->MANDANT->get_id(), $first->get_markt());
    $count = Subkonto::count_all_for_subkonto($subkonto_id);
    $max_site = $count / $site_count;
}
?>

