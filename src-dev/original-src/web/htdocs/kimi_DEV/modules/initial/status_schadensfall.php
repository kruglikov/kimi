<?php

$exists = FALSE;
$status_schadensfall_id = param("schadensfall_art", NULL);
$cur_id = param("cur_id", NULL);
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

    $status_schadensfall = new StatusSchadensfall((object) $_POST);

    $id = StatusSchadensfall::insert($status_schadensfall);
}

if ($mode == "UPD") {
    $show_new = false;
    $show_modify = false;
    $edited_id = param("edited_id");

    $current = StatusSchadensfall::get($modify_id);
    $current->text = "'".param('text')."'";
    $current->kurz_text = "'".param('kurz_text')."'";
//    $current->add_informations($_POST);

    StatusSchadensfall::update($current, $current->id);
   
}

if ($mode =="DEL") {
    $show_modify = false;
    $show_new = false;
    StatusSchadensfall::delete($modify_id);
}

if ($show_modify) {
    $modify = StatusSchadensfall::get($modify_id);
    $exists = true;
}

$count = StatusSchadensfall::count();
$max_site = $count / $site_count;

$status_schadensfall = StatusSchadensfall::load_items( $site * $site_count, $site_count);

if (count($status_schadensfall_id) > 0) {
    if (!isset($cur_id)) {
        $first = $status_schadensfall[0];
    } else {
        $first = $status_schadensfall::get($cur_id);
    }
}

?>

