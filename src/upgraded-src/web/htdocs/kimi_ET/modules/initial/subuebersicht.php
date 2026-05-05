<?php

$kunde_id = param("kunde");
$kunde_nr = param("kundennummer");
$kunde_nr_backup = param("kundennummer_backup");
$show_tgz = (param("TGZ") == "1");
$buch_tgz = (param("BUCHTGZ") == "1");


if (!isset($kunde_id) && !isset($_SESSION["sd-kunde"]) && !isset($kunde_nr)) {
    //header("Location: index.php?site=kunde");
    //exit;
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

if ($kunde_id != "") {
    $stammdaten = Stammdaten::get_by_kunde($kunde_id);
}
if ($buch_tgz) {
    $tgz_summen = explode("@", (string) param("Summen"));
    $tgz_ids = explode("@", (string) param("SummenIDs"));
    $trans_ok = TRUE;

    // eigene Transaktion
    $db = App::$CURRENT->DB->manualOpen();

    // Buchung abstellen

    $verwaltungssatz = Verwaltungssatz::get_aktuell2(App::$CURRENT->MANDANT->get_id(), $kunde->get_markt());
    $buchung = new Buchung((object) $_POST);
    $buchung->set_stammdaten_id($stammdaten->get_id());
    $buchung->set_kz_gebucht("'J'");
    $buchung->set_mwst_id(2);
    $buchung->set_mwst_20(round(param("TotalTgz"), 2), TRUE);
    $buchung->set_betrag(round(param("TotalTgz"), 2), TRUE);
    $buchung->set_herkunft("'Kapitalisierung'");
    $buchung->set_zahlart_id(2);

    $buchung->set_buchungsdatum($verwaltungssatz[0]->get_buchungsdatum());
    $buchung->set_valutadatum($stammdaten->get_stichtag());
    $buchung->set_buchungskennzeichen(0);
    $buchung->set_kz_manbuchung("'N'");
    $buchung->set_bua_bgr_man_id(App::$CURRENT->MANDANT->get_id() . $kunde->get_markt() . CONF_TGZ_BUABUGRUMAN_ID_KAPITALISIERT);
    $trans_ok = Buchung::insert($buchung, FALSE, $db);
    // SK-Buchungen abstellen
    if ($trans_ok) {
        $n = 0;
        foreach ($tgz_ids as $item) {
            if ($item > 0 && $trans_ok) {
//            $sk = new Subkonto((object) $_POST);
                $sk = Subkonto::get_current_from_lfd_nr($item);
                if (isset($sk)) {
                    $sk->set_belegdatum($stammdaten->get_stichtag());
                    $sk->set_bua_bgr_man_id(App::$CURRENT->MANDANT->get_id() . $kunde->get_markt() . CONF_TGZ_BUABUGRUMAN_ID_KAPITALISIERT);
                    $sk->set_kz_aktuell("J");
                    $sk->set_buchungsdatum($verwaltungssatz[0]->get_buchungsdatum());
                    $sk->set_buchungskennzeichen(0);
                    $saldo = $sk->get_saldo(TRUE);
                    $rest = $sk->get_rest(TRUE);
                    $sk->set_buchungsbetrag($tgz_summen[$n], TRUE);
                    $sk->set_saldo($saldo + $tgz_summen[$n], TRUE); //$tgz_summen[$n]);
                    $sk->set_rest($rest + $tgz_summen[$n], TRUE); //$tgz_summen[$n]);
                    $trans_ok = Subkonto::insert($sk, FALSE, $db);
                }
            }
            $n++;
        }
    }

    if ($trans_ok) {
        App::$CURRENT->DB->commit($db);
    } else {
        App::$CURRENT->DB->rollback($db);
    }

    if ( $trans_ok && substr((string) $stammdaten->get_krsv(), 0, 1) == 1) {
        $sk_gessaldo = number_format((float) Subkonto::get_gessaldo_kunde_oid(App::$CURRENT->MANDANT->get_id(), $kunde_id), 2, ".", "");
    }

    // Prüfe KRSV
    if ( isset($sk_gessaldo) && $sk_gessaldo > 0 &&  $trans_ok && substr((string) $stammdaten->get_krsv(), 0, 1) == 1) {
        // Lese Geamtsaldo
        //$sk_gessaldo = number_format((float) Subkonto::get_gessaldo_kunde_oid(App::$CURRENT->MANDANT->get_id(), $kunde_id), 2, ".", "");
        $betrag_cardif = $sk_gessaldo / 100 * CONF_CARDIF_ZINSSATZ;
        $betrag_cardif = number_format((float) round($betrag_cardif, 2), 2);

        $buchung = new Buchung((object) $_POST);
        $buchung->set_stammdaten_id($stammdaten->get_id());
        $buchung->set_kz_gebucht("'J'");
        $buchung->set_mwst_id(2);
        $buchung->set_mwst_20(round($betrag_cardif, 2), TRUE);
        $buchung->set_betrag(round($betrag_cardif, 2), TRUE);
        $buchung->set_herkunft("'Kapitalisierung'");
        $buchung->set_zahlart_id(2);

        $buchung->set_buchungsdatum($verwaltungssatz[0]->get_buchungsdatum());
        $buchung->set_valutadatum($stammdaten->get_stichtag());
        $buchung->set_buchungskennzeichen(0);
        $buchung->set_kz_manbuchung("'N'");
        $buchung->set_bua_bgr_man_id(App::$CURRENT->MANDANT->get_id() . $kunde->get_markt() . CONF_CARDIF_BUABUGRUMAN_ID_KAPITALISIERT);
        $trans_ok = Buchung::insert($buchung, FALSE, $db);
        if ($trans_ok) {
            // Belaste ältestes Subkonto
            $skold = Subkonto::get_oldest_sk($stammdaten->get_id());
            if (isset($skold)) {
                $skold->set_belegdatum($stammdaten->get_stichtag());
                $skold->set_bua_bgr_man_id(App::$CURRENT->MANDANT->get_id() . $kunde->get_markt() . CONF_CARDIF_BUABUGRUMAN_ID_KAPITALISIERT);
                $skold->set_kz_aktuell("J");
                $skold->set_buchungsdatum($verwaltungssatz[0]->get_buchungsdatum());
                $saldo = $skold->get_saldo(TRUE);
                $rest = $skold->get_rest(TRUE);
                $skold->set_buchungsbetrag($betrag_cardif, TRUE);
                $skold->set_saldo($saldo + $betrag_cardif, TRUE);
                $skold->set_rest($rest + $betrag_cardif, TRUE);
                $trans_ok = Subkonto::insert($skold, FALSE, $db);
            }
        }
    }

    if ($trans_ok) {
        App::$CURRENT->DB->commit($db);
        App::$CURRENT->DB->manualClose($db);
    } else {
        App::$CURRENT->DB->rollback($db);
        App::$CURRENT->DB->manualClose($db);
    }
}

if (isset($kunde) && $kunde->get_kdnr() != "") {
    $subkonten = Subkonto::get_by_kdnr($kunde->get_kdnr());
//    $dat= date_create("19-NOV-2013");
//    echo date_format($dat, "d.m.Y");
//    exit;
    // date_format(date_create("19-NOV-2013"), "d.m.Y")
    $sk_tgz = Subkonto::select_for_tgz($kunde->get_kdnr(), App::$CURRENT->MANDANT->get_id(), $kunde->get_markt(), CONF_TGZ_BUABUGRUMAN_ID_KAPITALISIERT, date("d.m.Y"), $stammdaten->get_stichtag());
    
    $sum_tgz = array();
    $gessaldo = number_format((float) Subkonto::get_gessaldo_kunde_oid(App::$CURRENT->MANDANT->get_id(), $kunde_id), 2, ".", "");
}

if (isset($subkonten) && isset($kunde) && count($subkonten) < 1) {
    App::$CURRENT->add_information(MSG_NO_RESULTS);
}
?>

