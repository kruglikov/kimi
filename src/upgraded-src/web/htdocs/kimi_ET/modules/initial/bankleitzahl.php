<?php

$exists = FALSE;
$bankleitzahl = param("bankleitzahl", NULL);
$cur_id = param("cur_id", NULL);
$mode = param("mode", "SEL");
$site = param("s", 0);
$site_count = CONF_PORTAL_LINE_PER_SITE;
$show_new = param("showNew", FALSE);
$show_modify = param("showModify", FALSE);
$modify_id = param("modify_id", 0);
$can_create = App::$CURRENT->has_permission("bankleitzahl", "INS");
$show_delete = param("showDelete");

$sblz = ltrim(param("sblz"), NULL);
$sbank = param("sbank", NULL);


if ($show_delete == true) {
    $mode = "DEL";
}

if ($mode == "INS") {
    $show_new = false;
    $show_modify = false;

    $bankleitzahl = new Bankleitzahl((object) $_POST);

    $id = Bankleitzahl::insert($bankleitzahl);
}

if ($mode == "UPD") {
    $show_new = false;
    $show_modify = false;
    $edited_id = param("edited_id");

    $current = Bankleitzahl::get($modify_id);
    $current->blz = param('blz');
    $current->bank = param('bank');
    $current->bic = param('bic');
    $current->kz_sepa_faehig = param('kz_sepa_faehig');

    Bankleitzahl::update($current, $current->id);
}

if ($mode == "DEL") {
    $show_modify = false;
    $show_new = false;
    Bankleitzahl::delete($modify_id);
}

if ($show_modify) {
    $modify = Bankleitzahl::get($modify_id);
    $exists = true;
}

$count = 0;
$max_site = 0;

if ( 1==1 || $sblz != NULL || $sbank != NULL) {

    $count = Bankleitzahl::count($sblz, $sbank);
    $max_site = $count / $site_count;

    $bankleitzahl = Bankleitzahl::load_items($sblz, $sbank, $site * $site_count, $site_count);

    if (count($bankleitzahl) > 0) {
        if (!isset($cur_id)) {
            $first = $bankleitzahl[0];
        } else {
            $first = $bankleitzahl::get($cur_id);
        }
    }
}
?>

