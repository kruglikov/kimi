<?php
$text = Portal_Text::load_text(App::$CURRENT->USER->get_sprache());

$verw_menu = array();
if (App::$CURRENT->has_permission("schadensfall_art", "*")) {
    array_push($verw_menu, new MenuItem(TXT_LBL_VW_SCHADENSFALLART, "schadensfall_art"));
}

if (App::$CURRENT->has_permission("status_schadensfall", "*")) {
    array_push($verw_menu, new MenuItem(TXT_LBL_VW_STATUSSCHADENSFALL, "status_schadensfall"));
}

if (App::$CURRENT->has_permission("bankleitzahl", "*")) {
    array_push($verw_menu, new MenuItem(TXT_LBL_BANKEN, "bankleitzahl"));
}


?>