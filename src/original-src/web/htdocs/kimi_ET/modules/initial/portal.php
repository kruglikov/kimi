<?php
$text = Portal_Text::load_text(App::$CURRENT->USER->get_sprache());

$portal_menu = array();
/*if (App::$CURRENT->has_permission("kunde", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_CUSTOMER_SEARCH, "kunde"));
}

if (App::$CURRENT->has_permission("subsuche", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_BASE_DATA_SEARCH, "stammsuche"));
}

if (App::$CURRENT->has_permission("kunde_details", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_CUSTOMER_DETAILS, "kunde_details"));
}

if (App::$CURRENT->has_permission("stammdaten", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_BASE_DATA, "stammdaten"));
}

if (App::$CURRENT->has_permission("subuebersicht", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_SUBOVERVIEW, "subuebersicht"));
}

if (App::$CURRENT->has_permission("subsuche", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_SUBSEARCH, "subsuche"));
}*/

if (App::$CURRENT->has_permission("ticketsuch", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_TICKSUCH, "ticketsuch"));
}

/*if (App::$CURRENT->has_permission("ticketsuch", "*")) {
    array_push($portal_menu, new MenuItem("Ticketsuche (NUR TEST!)", "ticketsuch2"));
}*/

/*
if (App::$CURRENT->has_permission("menu_verw", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_MENU_VERW, "menu_verw"));
}

if (App::$CURRENT->has_permission("ratenrechner", "*")) {
    array_push($portal_menu, new MenuItem(TXT_LBL_RATE_HEADER, "ratenrechner"));
}
*/
?>