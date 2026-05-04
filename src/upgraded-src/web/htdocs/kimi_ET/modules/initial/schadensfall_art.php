<?php

$exists = FALSE;
$schadensfall_art_id = param("schadensfall_art", NULL);
$cur_schadensfall_art_id = param("cur_id", NULL);
$mode = param("mode", "SEL");
$site = param("s", 0);
$site_count = CONF_PORTAL_LINE_PER_SITE;
$show_new = param("showNew", FALSE);
$show_modify = param("showModify", FALSE);
$modify_id = param("modify_id", 0);
$can_create = App::$CURRENT->has_permission("schadensfall_art", "INS");
$show_delete = param("showDelete");

if ($show_delete == true) {
    $mode = "DEL";
}

if ($mode == "INS") {
    $show_new = false;
    $show_modify = false;

    $schadensfall = new SchadensfallArt((object) $_POST);

    $id = SchadensfallArt::insert($schadensfall);
}

if ($mode == "UPD") {
    $show_new = false;
    $show_modify = false;
    $edited_id = param("edited_id");

    $current = SchadensfallArt::get($modify_id);
    $current->text = "'".param('text')."'";
//    $current->add_informations($_POST);

    SchadensfallArt::update($current, $current->id);
   
}

if ($mode =="DEL") {
    $show_modify = false;
    $show_new = false;
    SchadensfallArt::delete($modify_id);
}

if ($show_modify) {
    $modify = SchadensfallArt::get($modify_id);
    $exists = true;
}

$count = SchadensfallArt::count();
$max_site = $count / $site_count;

$schadensfall_arten = SchadensfallArt::load_items( $site * $site_count, $site_count);

if (count($schadensfall_arten) > 0) {
    if (!isset($cur_schadensfall_art_id)) {
        $first = $schadensfall_arten[0];
    } else {
        $first = $schadensfall_arten::get($cur_schadensfall_art_id);
    }
}

?>

