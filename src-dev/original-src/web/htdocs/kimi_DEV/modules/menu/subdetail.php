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
if (App::$CURRENT->has_permission("stammdaten", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_BASE_DATA, "stammdaten"));
}
if (App::$CURRENT->has_permission("buchungen", "*") ) {
    array_push($menu, new MenuItem(TXT_LBL_BUCHUNGEN, "buchungen"));
}
?>