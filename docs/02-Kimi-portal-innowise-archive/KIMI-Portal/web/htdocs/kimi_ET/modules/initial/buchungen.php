<?php

$ikstat = IKStatus::load_all();
$ikbueros = IKBuero::load_all();

$buchung_id = param("buchungen", NULL);
$kunde_id = param("kunde");
$kunde_nr = param("kundennummer");
$kunde_nr_backup = param("kundennummer_backup");
$cur_buchung_id = param("cur_id", NULL);
$mode = param("mode", "SEL");
$site = param("s", 0);
$site_count = CONF_PORTAL_LINE_PER_SITE;
$show_new = param("showNew", FALSE);
$update_buchung_id = param("update_buchung_oid", 0);
$buch_sk = false;
if (isset($_POST["buch_auf_sk"]) && $_POST["buch_auf_sk"] == 1) {
    $buch_sk = true;
}
$buch_sk_negativ = false;
if  (isset($_POST["bua_bgr_man_id"]) && $_POST["bua_bgr_man_id"] == "1104770" && $buch_sk == true) {
	$buch_sk = false;
	$buch_sk_negativ = true;
}

$can_create = App::$CURRENT->has_permission("buchungen", "INS");

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
if (!isset($kunde__id) && isset($kunde)) {
    $kunde_id = $kunde->get_id();
}

if (isset($kunde_id)) {
    $stammdaten = Stammdaten::get_by_kunde($kunde_id);
}


if ($mode == "INS") {
    $show_new = false;
    $buchung = new Buchung((object) $_POST);
    $buchung->set_stammdaten_id($stammdaten->get_id());
    $buchung->set_kz_gebucht("'J'");
    $buchung->set_mwst_id(2);
    $buchung->set_mwst_20($buchung->get_betrag());
    $buchung->set_herkunft("'Dialog'");
    //$buchung->set_mwst_20($val)

    $db = App::$CURRENT->DB->manualOpen();

    $trans_ok = Buchung::insert($buchung, FALSE, $db);

    if ($trans_ok && $buch_sk && $buchung->get_betrag(TRUE) > 0 && $buchung->get_buchungskennzeichen() != "1") {
        // Lese Subkonten und teile den Betrag auf
        $subkonten = Subkonto::get_for_auto_update($stammdaten->get_id());
        $sk_betrag = 0;
        $bu_betrag = $buchung->get_betrag(TRUE);
        $offen = $bu_betrag;
        $exists = FALSE;
        $betrag_done = "" . $bu_betrag . "<br>";
        $anz = count($subkonten);
        $n = 1;
        if (isset($sk_aufteilung)) {
            unset($sk_aufteilung);
        }
        $sum = 0.00;
        $sk_id = 0;
        foreach ($subkonten as $sk) {
            $sk_saldo = $sk->get_saldo(TRUE);
            $sk_id = $sk->get_id();
            $done = 0;
            $sk_m4 = $sk->get_m4(TRUE);
            $sk_m3 = $sk->get_m3(TRUE);
            $sk_m2 = $sk->get_m2(TRUE);
            $sk_m1 = $sk->get_m1(TRUE);
            $sk_m0 = $sk->get_m0(TRUE);
            $sk_rest = $sk->get_rest(TRUE);

            $sk_aufteilung[] = array('sk_id' => "0",
                'sklfdnr' => $sk->get_rechnungsnummer(),
                'M4' => $sk->format_number($sk_m4),
                'M3' => $sk->format_number($sk_m3),
                'M2' => $sk->format_number($sk_m2),
                'M1' => $sk->format_number($sk_m1),
                'M0' => $sk->format_number($sk_m0),
                'Rest' => $sk->format_number($sk_rest),
                'Saldo' => $sk->format_number($sk_saldo),
                'Buch' => ""
            );

            $start = $offen;
            $sk->neg_betrag($offen, $sk_m4);
            $sk->neg_betrag($offen, $sk_m3);
            $sk->neg_betrag($offen, $sk_m2);
            $sk->neg_betrag($offen, $sk_m1);
            $sk->neg_betrag($offen, $sk_m0);
            $sk->neg_betrag($offen, $sk_rest);

            $gebucht = $start - $offen;
            $sk_betrag = $sk_betrag + $gebucht;
            if ($n == $anz && $offen > 0) {
                // bei letztem SK und noch offenen Betrag buchen
                $sk_betrag = $sk_betrag + $offen;
                $gebucht = $gebucht + $offen;
                $offen = 0;
            }
            $sk_saldo_neu = $sk_saldo - $gebucht;
            $sum = $sum + $gebucht;

            $sk_aufteilung[] = array('sk_id' => $sk->get_id(),
                'sklfdnr' => "",
                'M4' => $sk->format_number($sk_m4),
                'M3' => $sk->format_number($sk_m3),
                'M2' => $sk->format_number($sk_m2),
                'M1' => $sk->format_number($sk_m1),
                'M0' => $sk->format_number($sk_m0),
                'Rest' => $sk->format_number($sk_rest),
                'Saldo' => $sk->format_number($sk_saldo_neu),
                'Buch' => $sk->format_number($gebucht)
            );


            $n++;
            if ($offen == 0) {
                break;
            }
        }
        $sk_aufteilung[] = array('sk_id' => "0",
            'sklfdnr' => "",
            'M4' => "",
            'M3' => "",
            'M2' => "",
            'M1' => "",
            'M0' => "",
            'Rest' => "",
            'Saldo' => TXT_SUM,
            'Buch' => number_format((float) $sum, 2, ",", ".")
        );
        // und los mit Buchung
        $anz = count($sk_aufteilung);
        $n = 1;
        foreach ($sk_aufteilung as $aufteil) {
            if ($aufteil['Buch'] != "" && $aufteil['sk_id'] != "0" && $aufteil['sk_id'] != "'0'" && $aufteil['sk_id'] != "") {
                // lese aktuelles SK
                $curr_sk = Subkonto::get_current($aufteil['sk_id']);
                $curr_sk->set_belegdatum($buchung->get_valutadatum());
                $curr_sk->set_buchungsdatum($buchung->get_buchungsdatum());
                $curr_sk->set_bua_bgr_man_id($buchung->get_bua_bgr_man_id());
                $curr_sk->set_buchungskennzeichen($buchung->get_buchungskennzeichen());
                $curr_sk->set_buchungsbetrag($aufteil['Buch']);
                $curr_sk->set_verwendungszweck($buchung->get_verwendungszweck());
                $curr_sk->set_kz_gebucht("J");
                $curr_sk->set_kz_aktuell("J");
                $curr_sk->set_m0($aufteil['M0']);
                $curr_sk->set_m1($aufteil['M1']);
                $curr_sk->set_m2($aufteil['M2']);
                $curr_sk->set_m3($aufteil['M3']);
                $curr_sk->set_m4($aufteil['M4']);
                $curr_sk->set_rest($aufteil['Rest']);
                $curr_sk->set_buchungsbetrag($aufteil['Buch']);


                if ($anz - 1 == $n || $curr_sk->get_saldo() != "0,00") {
                    //echo "<br> BUCH".$n;
                    $curr_sk->set_saldo($aufteil['Saldo']);
                    if (strrpos($aufteil['Saldo'], "-") !== false) {
                        $curr_sk->set_m0($aufteil['Saldo']);
                        $aufteil['M0'] = $aufteil['Saldo'];
                    }

                    $trans_ok = Subkonto::insert($curr_sk, FALSE, $db);
                }
            }
            $n++;
        }
    }
	// 20160306/ab 
	if ($trans_ok && $buch_sk_negativ && $buchung->get_betrag(TRUE) > 0 && $buchung->get_buchungskennzeichen() != "1") {
        // Lese Subkonten und teile den Betrag auf
        $subkonten = Subkonto::get_for_auto_update($stammdaten->get_id());
        $sk_betrag = 0;
        $bu_betrag = $buchung->get_betrag(TRUE);
        $offen = $bu_betrag;
        $exists = FALSE;
        $betrag_done = "" . $bu_betrag . "<br>";
        $anz = count($subkonten);
        $n = 1;
        if (isset($sk_aufteilung)) {
            unset($sk_aufteilung);
        }
        $sum = 0.00;
        $sk_id = 0;
        foreach ($subkonten as $sk) {
            $sk_saldo = $sk->get_saldo(TRUE);
			
			$sk_id = $sk->get_id();
			$done = 0;
			$sk_m4 = $sk->get_m4(TRUE);
			$sk_m3 = $sk->get_m3(TRUE);
			$sk_m2 = $sk->get_m2(TRUE);
			$sk_m1 = $sk->get_m1(TRUE);
			$sk_m0 = $sk->get_m0(TRUE);
			$sk_rest = $sk->get_rest(TRUE);
			$gebucht = 0;

			if ($sk_saldo < 0 && $sk_m0 < 0 && $sk_saldo == $sk_m0) {
				$sk_aufteilung[] = array('sk_id' => "0",
					'sklfdnr' => $sk->get_rechnungsnummer(),
					'M4' => $sk->format_number($sk_m4),
					'M3' => $sk->format_number($sk_m3),
					'M2' => $sk->format_number($sk_m2),
					'M1' => $sk->format_number($sk_m1),
					'M0' => $sk->format_number($sk_m0),
					'Rest' => $sk->format_number($sk_rest),
					'Saldo' => $sk->format_number($sk_saldo),
					'Buch' => ""
				);

				$start = $offen;
				$sk->neg_betrag($offen, $sk_m4);
				$sk->neg_betrag($offen, $sk_m3);
				$sk->neg_betrag($offen, $sk_m2);
				$sk->neg_betrag($offen, $sk_m1);
				$sk->neg_betrag($offen, $sk_m0);
				$sk->neg_betrag($offen, $sk_rest);

				$gebucht = $start - $offen;
				$sk_betrag = $sk_betrag + $gebucht;
			}
            if ($n == $anz && $offen > 0) {
                // bei letztem SK und noch offenen Betrag buchen
                $sk_betrag = $sk_betrag + $offen;
                $gebucht = $gebucht + $offen;
                $offen = 0;
            }
            $sk_saldo_neu = $sk_saldo + $gebucht;
			$sk_m0 = $sk_m0 + $gebucht;
            $sum = $sum + $gebucht;

            $sk_aufteilung[] = array('sk_id' => $sk->get_id(),
                'sklfdnr' => "",
                'M4' => $sk->format_number($sk_m4),
                'M3' => $sk->format_number($sk_m3),
                'M2' => $sk->format_number($sk_m2),
                'M1' => $sk->format_number($sk_m1),
                'M0' => $sk->format_number($sk_m0),
                'Rest' => $sk->format_number($sk_rest),
                'Saldo' => $sk->format_number($sk_saldo_neu),
                'Buch' => $sk->format_number($gebucht)
            );


            $n++;
            if ($offen == 0) {
                break;
            }
        }
        $sk_aufteilung[] = array('sk_id' => "0",
            'sklfdnr' => "",
            'M4' => "",
            'M3' => "",
            'M2' => "",
            'M1' => "",
            'M0' => "",
            'Rest' => "",
            'Saldo' => TXT_SUM,
            'Buch' => number_format((float) $sum, 2, ",", ".")
        );
        // und los mit Buchung
        $anz = count($sk_aufteilung);
        $n = 1;
        foreach ($sk_aufteilung as $aufteil) {
            if ($aufteil['Buch'] != "" && $aufteil['sk_id'] != "0" && $aufteil['sk_id'] != "'0'" && $aufteil['sk_id'] != "") {
                // lese aktuelles SK
                $curr_sk = Subkonto::get_current($aufteil['sk_id']);
                $curr_sk->set_belegdatum($buchung->get_valutadatum());
                $curr_sk->set_buchungsdatum($buchung->get_buchungsdatum());
                $curr_sk->set_bua_bgr_man_id($buchung->get_bua_bgr_man_id());
                $curr_sk->set_buchungskennzeichen($buchung->get_buchungskennzeichen());
                $curr_sk->set_buchungsbetrag($aufteil['Buch']);
                $curr_sk->set_verwendungszweck($buchung->get_verwendungszweck());
                $curr_sk->set_kz_gebucht("J");
                $curr_sk->set_kz_aktuell("J");
                $curr_sk->set_m0($aufteil['M0']);
                $curr_sk->set_m1($aufteil['M1']);
                $curr_sk->set_m2($aufteil['M2']);
                $curr_sk->set_m3($aufteil['M3']);
                $curr_sk->set_m4($aufteil['M4']);
                $curr_sk->set_rest($aufteil['Rest']);
                $curr_sk->set_buchungsbetrag($aufteil['Buch']);


                if ($anz - 1 == $n || $curr_sk->get_saldo() != "0,00") {
                    //echo "<br> BUCH".$n;
                    $curr_sk->set_saldo($aufteil['Saldo']);
                    if (strrpos($aufteil['Saldo'], "-") !== false) {
                        $curr_sk->set_m0($aufteil['Saldo']);
                        $aufteil['M0'] = $aufteil['Saldo'];
                    }

                    $trans_ok = Subkonto::insert($curr_sk, FALSE, $db);
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
    App::$CURRENT->DB->manualClose($db);
    $stammdaten = Stammdaten::get_by_kunde($kunde_id);
}


if ($mode == "KZBUCH_BU" || $mode == "KZBUCH_BUSK" || $mode == "KZBUCH_ST") {
    $buchung = Buchung::get($update_buchung_id);
    $db = App::$CURRENT->DB->manualOpen();

    if ($mode == "KZBUCH_BU" || $mode == "KZBUCH_BUSK") {
        $buchung->kz_gebucht = "'J'";
    } else {
        $buchung->kz_gebucht = "'N'";
    }

    $trans_ok = Buchung::update_kz_gebucht($buchung, $update_buchung_id, FALSE, $db);

    if ($trans_ok && $mode == "KZBUCH_BUSK") {
        // TODO Buchung Subkonten bei Zahlungsbuchungen
        $buchung = Buchung::getarr($update_buchung_id);
        if (!isset($stammdaten) && isset($kunde_id)) {
            $stammdaten = Stammdaten::get_by_kunde($kunde_id);
        }

        if ($buchung->get_betrag(TRUE) > 0 && $buchung->get_buchungskennzeichen() != "1") {
            // Lese Subkonten und teile den Betrag auf
            //$subkonten = Subkonto::get_for_auto_update($stammdaten->get_id());
            $subkonten = Subkonto::get_for_auto_update($buchung->get_stammdaten_id());
            $sk_betrag = 0;
            $bu_betrag = $buchung->get_betrag(TRUE);
            $offen = $bu_betrag;
            $exists = FALSE;
            $betrag_done = "" . $bu_betrag . "<br>";
            $anz = count($subkonten);
            $n = 1;
            if (isset($sk_aufteilung)) {
                unset($sk_aufteilung);
            }
            $sum = 0.00;
            $sk_id = 0;
            foreach ($subkonten as $sk) {
                $sk_saldo = $sk->get_saldo(TRUE);
                $sk_id = $sk->get_id();
                $done = 0;
                $sk_m4 = $sk->get_m4(TRUE);
                $sk_m3 = $sk->get_m3(TRUE);
                $sk_m2 = $sk->get_m2(TRUE);
                $sk_m1 = $sk->get_m1(TRUE);
                $sk_m0 = $sk->get_m0(TRUE);
                $sk_rest = $sk->get_rest(TRUE);

                $sk_aufteilung[] = array('sk_id' => "0",
                    'sklfdnr' => $sk->get_rechnungsnummer(),
                    'M4' => $sk->format_number($sk_m4),
                    'M3' => $sk->format_number($sk_m3),
                    'M2' => $sk->format_number($sk_m2),
                    'M1' => $sk->format_number($sk_m1),
                    'M0' => $sk->format_number($sk_m0),
                    'Rest' => $sk->format_number($sk_rest),
                    'Saldo' => $sk->format_number($sk_saldo),
                    'Buch' => ""
                );

                $start = $offen;
                $sk->neg_betrag($offen, $sk_m4);
                $sk->neg_betrag($offen, $sk_m3);
                $sk->neg_betrag($offen, $sk_m2);
                $sk->neg_betrag($offen, $sk_m1);
                $sk->neg_betrag($offen, $sk_m0);
                $sk->neg_betrag($offen, $sk_rest);

                $gebucht = $start - $offen;
                $sk_betrag = $sk_betrag + $gebucht;
                if ($n == $anz && $offen > 0) {
                    // bei letztem SK und noch offenen Betrag buchen
                    $sk_betrag = $sk_betrag + $offen;
                    $gebucht = $gebucht + $offen;
                    $offen = 0;
                }
                $sk_saldo_neu = $sk_saldo - $gebucht;
                $sum = $sum + $gebucht;

                $sk_aufteilung[] = array('sk_id' => $sk->get_id(),
                    'sklfdnr' => "",
                    'M4' => $sk->format_number($sk_m4),
                    'M3' => $sk->format_number($sk_m3),
                    'M2' => $sk->format_number($sk_m2),
                    'M1' => $sk->format_number($sk_m1),
                    'M0' => $sk->format_number($sk_m0),
                    'Rest' => $sk->format_number($sk_rest),
                    'Saldo' => $sk->format_number($sk_saldo_neu),
                    'Buch' => $sk->format_number($gebucht)
                );


                $n++;
                if ($offen == 0) {
                    break;
                }
            }
            $sk_aufteilung[] = array('sk_id' => "0",
                'sklfdnr' => "",
                'M4' => "",
                'M3' => "",
                'M2' => "",
                'M1' => "",
                'M0' => "",
                'Rest' => "",
                'Saldo' => TXT_SUM,
                'Buch' => number_format((float) $sum, 2, ",", ".")
            );
            // und los mit Buchung
            $anz = count($sk_aufteilung);
            $n = 1;
            foreach ($sk_aufteilung as $aufteil) {
                if ($aufteil['Buch'] != "" && $aufteil['sk_id'] != "0" && $aufteil['sk_id'] != "'0'" && $aufteil['sk_id'] != "") {
                    // lese aktuelles SK
                    $curr_sk = Subkonto::get_current($aufteil['sk_id']);
                    $curr_sk->set_belegdatum($buchung->get_valutadatum());
                    $curr_sk->set_buchungsdatum($buchung->get_buchungsdatum());
                    $curr_sk->set_bua_bgr_man_id($buchung->get_bua_bgr_man_id());
                    $curr_sk->set_buchungskennzeichen($buchung->get_buchungskennzeichen());
                    $curr_sk->set_buchungsbetrag($aufteil['Buch']);
                    $curr_sk->set_verwendungszweck($buchung->get_verwendungszweck());
                    $curr_sk->set_kz_gebucht("J");
                    $curr_sk->set_kz_aktuell("J");
                    $curr_sk->set_m0($aufteil['M0']);
                    $curr_sk->set_m1($aufteil['M1']);
                    $curr_sk->set_m2($aufteil['M2']);
                    $curr_sk->set_m3($aufteil['M3']);
                    $curr_sk->set_m4($aufteil['M4']);
                    $curr_sk->set_rest($aufteil['Rest']);
                    $curr_sk->set_buchungsbetrag($aufteil['Buch']);

                    if ($anz - 1 == $n || $curr_sk->get_saldo() != "0,00") {
                        $curr_sk->set_saldo($aufteil['Saldo']);
                        if (strrpos($aufteil['Saldo'], "-") !== false) {
                            $curr_sk->set_m0($aufteil['Saldo']);
                            $aufteil['M0'] = $aufteil['Saldo'];
                        }

                        $trans_ok = Subkonto::insert($curr_sk, FALSE, $db);
                    }
                }
                $n++;
            }
        }
    }
    if ($trans_ok) {
        App::$CURRENT->DB->commit($db);
    } else {
        App::$CURRENT->DB->rollback($db);
    }
    App::$CURRENT->DB->manualClose($db);
    $stammdaten = Stammdaten::get_by_kunde($kunde_id);
}


if (isset($stammdaten)) {

    $exists = true;
}

$count = Buchung::count(App::$CURRENT->MANDANT->get_id(), $kunde_nr);
$max_site = $count / $site_count;

//$buchungen = new Buchung();
$buchungen = Buchung::load_items(App::$CURRENT->MANDANT->get_id(), $kunde_nr, $site * $site_count, $site_count);

if (count($buchungen) > 0) {
    if (!isset($cur_buchung_id)) {
        $first = $buchungen[0];
    } else {
        $first = Buchung::get($cur_buchung_id);
    }
}
$buchungsarten = Buchungsart::get_list_bugr(App::$CURRENT->MANDANT->get_id());
$buchungsgruende = Buchungsgrund::load(App::$CURRENT->MANDANT->get_id(), $kunde->get_markt());
$verwaltungssatz = Verwaltungssatz::get_aktuell2(App::$CURRENT->MANDANT->get_id(), $kunde->get_markt());
$zahlarten = Zahlart::get_all();
//$sk_gessaldo =  Subkonto::get_gessaldo(App::$CURRENT->MANDANT->get_id(), $kunde_nr);

$sk_gessaldo = number_format((float) Subkonto::get_gessaldo(App::$CURRENT->MANDANT->get_id(), $kunde_nr), 2, ",", ".");

//    echo "Markt=".$kunde->get_anrede_id();
//    exit;

/*
  if (count($buchungen) > 0) {
  if (!isset($cur_buchung_id)) {
  $first = $buchungen[0];
  } else {
  $first = Buchung::get($cur_buchung_id);
  }
  $kunde_nr = $first->get_kdnr();
  $buchungsgruende = Buchungsgrund::load(App::$CURRENT->MANDANT->get_id());
  $count = Buchung::count($kunde_nr);
  $max_site = $count / $site_count;
  } */
?>

