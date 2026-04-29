<?php

$anreden = Anrede::load_all();
$titel = Titel::load_all();
$laender = Country::load_all();

if (param("new", FALSE)) {
    unset($_SESSION["sd-kunde"]);
}

if (!param("mode", FALSE)) {
    $mode = "UPD";
    if (!param("kunde", FALSE)) {
        if (isset($_SESSION["sd-kunde"]) && !param("new", FALSE)) {
            $kunde = $_SESSION["sd-kunde"];
            $kunde_id = $kunde->get_id();
        } else {
            $mode = "INS";
            $kunde = new Customer(NULL);
        }
    } else {
        $kunde_id = param("kunde");
        $kunde = Customer::get($kunde_id);
        $_SESSION["sd-kunde"] = $kunde;
    }
} else {
    $mode = param("mode");

    if ($mode == "INS") {
        $kunde = new Customer((object) $_POST);
        $id = Customer::insert($kunde);
        
        $error = !$id;
        $kunde->set_id($id);
        $kunde_id = $id;

        if (!$error) {
            $mode = "UPD";
        }
    } else if ($mode == "UPD") {
        $kunde_id = param("id");
        $kunde = new Customer((object) $_POST);
        $kunde->set_id($kunde_id);
        $error = !Customer::update($kunde);
        $kunde_id = $kunde->get_id();
    } else if ($mode == "DEL") {
        $kunde_id = $_POST["id"];
        $ok = Customer::delete($kunde_id);

        if ($ok) {
            unset($_SESSION["sd-kunde"]);
            // header("Location: index.php?site=kunde");
            // exit;
        } else {
            $error = TRUE;
            $kunde_id = param("id");
            $kunde = Customer::get($kunde_id);
        }
    }

    if (!$error) {
        App::$CURRENT->add_information(MSG_SAVED);
        $_SESSION["sd-kunde"] = $kunde;
    }
}
?>