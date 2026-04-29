<?php
if (App::$CURRENT->has_permission("kunde", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_CUSTOMER_SEARCH, "kunde"));
}
if (App::$CURRENT->has_permission("stammsuche", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_BASE_DATA_SEARCH, "stammsuche"));
}
if (App::$CURRENT->has_permission("subsuche", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_SUBSEARCH, "subsuche"));
}
if (App::$CURRENT->has_permission("subuebersicht", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_SUBOVERVIEW, "subuebersicht"));
}
if (App::$CURRENT->has_permission("kunde_details", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_CUSTOMER_DETAILS, "kunde_details"));
}
if (App::$CURRENT->has_permission("kundenhistorie", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_KUNDENHISTORIE, "kundenhistorie"));
}

if (App::$CURRENT->has_permission("stammdaten", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_BASE_DATA, "stammdaten"));
}
if (App::$CURRENT->has_permission("buchungen", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_BUCHUNGEN, "buchungen"));
}
if (App::$CURRENT->has_permission("inkassoinformation", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_INKASSO, "inkassoinformation"));
}

if (App::$CURRENT->has_permission("versicherung", "*") && isset($stammdaten)) {
    array_push($menu, new MenuItem(TXT_LBL_VERSICHERUNGEN, "versicherung"));
}

if (App::$CURRENT->has_permission("schadensfall", "*") && isset($stammdaten)) {
    array_push($menu, new MenuItem(TXT_LBL_SCHADENSFAELLE, "schadensfall"));
}

if (App::$CURRENT->has_permission("lastschrift", "*") && isset($stammdaten)) {
    array_push($menu, new MenuItem(TXT_LBL_LASTSCHRIFTEN, "lastschrift"));
}

?>