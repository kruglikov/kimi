<?php

//if (param("search", "false") == "false") {
$ratenbetrag = param("Kreditbetrag", "0,00");
$ratenanzahl = param("Ratenanzahl", "0");
$ratenhoehe = param("Ratenhoehe", "0,00");
$ratenzinssatz = param("Zinssatz", CONF_TGZ_ZINSSATZ);
$kunde_id = param("kunde_id", "0");
$mischzinssatz = "0,00";


if (isset($kunde)) {
    unset($kunde);
}
if (isset($stammdaten)) {
    unset($stammdaten);
}
if (isset($kunde_id) && $kunde_id != "0" && $kunde_id != "") {
    $kunde = Customer::get($kunde_id);
    $stammdaten = Stammdaten::get_by_kunde($kunde_id);
    $mischzinssatz = Subkonto::calc_mischzinssatz($stammdaten->get_id());
    $akt_ratenhoehe = Subkonto::get_akt_ratenhoehe($stammdaten->get_id());

    $gessaldo = number_format((float) Subkonto::get_gessaldo_kunde_oid(App::$CURRENT->MANDANT->get_id(), $kunde_id), 2, ".", "");
    if (param("search", "false") == "false") {
        $ratenzinssatz = $mischzinssatz;
        $ratenbetrag = $stammdaten->get_gesamtsaldo(true);
        if ((float) $ratenbetrag < 0) {
            $ratenbetrag = "";
            ;
        }
    }
}

if ($ratenbetrag == "") {
    $ratenbetrag = "0,00";
}
if ($ratenanzahl == "") {
    $ratenanzahl = "0";
}
if ($ratenhoehe == "") {
    $ratenhoehe = "0,00";
}
if ($ratenzinssatz == "") {
    $ratenzinssatz = CONF_TGZ_ZINSSATZ;
}


$ratenbetrag = str_replace(',', '.', $ratenbetrag);
$ratenanzahl = str_replace(',', '.', $ratenanzahl);
$ratenhoehe = str_replace(',', '.', $ratenhoehe);
$ratenzinssatz = str_replace(',', '.', $ratenzinssatz);


if (param("search", "false") == "true") {
    if ((float) $ratenbetrag <= 0) {
        App::$CURRENT->add_error(TXT_ERR_RATE_KREDITBETRAG);
        return FALSE;
    }

    if ((float) $ratenanzahl == 0 && (float) $ratenhoehe == 0) {
        App::$CURRENT->add_error(TXT_ERR_RATE_ANZAHLHOEHE);
        return FALSE;
    }

    if ((float) $ratenhoehe == 0) {
        $ratenhoehe = Ratenrechner::calc_ratenhoehe($ratenbetrag, $ratenzinssatz, $ratenanzahl);
    } else {
        $ratenanzahl = Ratenrechner::calc_ratenanzahl($ratenbetrag, $ratenzinssatz, $ratenhoehe);
    }

    $sum_zinsen = 0;
    $sum_tilgung = 0;
    $tilgung = Ratenrechner::get_tilgungsplan($ratenbetrag, $ratenhoehe, $ratenzinssatz, $ratenanzahl, $sum_zinsen, $sum_tilgung);
} else {
    if (isset($akt_ratenhoehe) && $ratenhoehe == "0,00" && $ratenanzahl != "0") {
        $ratenhoehe = $akt_ratenhoehe;
    }
}

$ratenbetrag = str_replace('.', ',', $ratenbetrag);
$ratenanzahl = str_replace('.', ',', $ratenanzahl);
$ratenhoehe = str_replace('.', ',', $ratenhoehe);
$ratenzinssatz = str_replace('.', ',', $ratenzinssatz);
if (isset($gessaldo)) {
    $gessaldo = str_replace('.', ',', $gessaldo);
}
?>
