<?php

$kdnr = param("kdnr");
$mode = param("mode", "SEL");
$current_id = param("subkonto", -1);
$new = $current_id == -1;

$zahlarten = Zahlart::get_all();
$buchungsarten = Buchungsart::get_list(App::$CURRENT->MANDANT->get_id());
$buchungsgruende = Buchungsgrund::load(App::$CURRENT->MANDANT->get_id());

if (!$new) {
    $current = Customer::get_by_kunde_nr($kdnr, App::$CURRENT->MANDANT->get_id());
}

if ($mode == "INS") {
    $ratenhoehe = param("ratenhoehe");
    if (strlen((string) $ratenhoehe) == 0) {
        $ratenhoehe = "NULL";
    }
    
    $cur = new Subkonto($_POST);
    $cur->set_sk_lfdnr(Subkonto::generate_sk_lfdnr());
    $cur->set_stammdaten_id(Stammdaten::get_by_kdnr($kdnr)->get_id());
    $cur->set_rechnungsnummer(param("rechungsnummer"));
    $cur->set_kz_aktuell("J");
    $cur->set_buchungsbetrag($cur->get_kaufwert());
    $cur->set_belegdatum($cur->get_buchungsdatum());
    $cur->set_buchungskennzeichen("0");

    Subkonto::insert($cur);
}

?>

