<?php

$ikstat = IKStatus::load_all();
$ikbueros = IKBuero::load_all();

$mode = param("mode", "SEL");
$kunde_id = param("kunde");
$kunde_nr = param("kundennummer");
$kunde_nr_backup = param("kundennummer_backup");

if (!isset($kunde_id) && !isset($_SESSION["sd-kunde"]) && !isset($kunde_nr)) {
    //header("Location: index.php?site=stammsuche");
    // exit;
} else if (!isset($kunde_id) && !isset($kunde_nr)) {
    $kunde = $_SESSION["sd-kunde"];

    $kunde_id = $kunde->get_id();
} else if (!isset($kunde_nr)) {

//exit;
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
    if (param("mahnsperre", FALSE)) {
        $mahnsperre = "MS";
    } else {
        $mahnsperre = "";
    }

    $data = array();
    $data["mandant_id"] = App::$CURRENT->MANDANT->get_id();
    $data["mahnsperre"] = $mahnsperre;
    $data["ktonr"] = $kunde->get_kdnr();

    $sd = new Stammdaten($kunde->get_raw_item());
    $sd->add_informations($_POST);
    $sd->add_informations($data);
    $sd->set_kunde_id($kunde->get_id());
    $sd->set_id(NULL);

    Stammdaten::insert($sd);
} else if ($mode == "UPD") {
    if (param("mahnsperre", FALSE)) {
        $mahnsperre = "MS";
    } else {
        $mahnsperre = "";
    }
    
    $sd = Stammdaten::get($kunde->get_id());    

    $data = array();
    $data["mandant_id"] = App::$CURRENT->MANDANT->get_id();
    $data["mahnsperre"] = $mahnsperre;
    $data["ktonr"] = $kunde->get_kdnr();

    //$sd = new Stammdaten($kunde->get_raw_item());
    $sd->add_informations($_POST);
    $sd->add_informations($data);
    $sd->set_kunde_id($kunde->get_id());
    Stammdaten::update($sd);
}
if (isset($kunde_id)) {
    $stammdaten = Stammdaten::get_by_kunde($kunde_id);
    $ikinfo = Inkassoinformation::get_last_status_dat($kunde_id);
}

if (isset($stammdaten)) {

    $exists = true;

    $subkonten = Subkonto::calculate_subkonten($stammdaten->get_id());

//    if (count($subkonten) < 1) {
//        App::$CURRENT->add_information(MSG_NO_RESULTS);
//    }
} else {

    $exists = false;
}
?>