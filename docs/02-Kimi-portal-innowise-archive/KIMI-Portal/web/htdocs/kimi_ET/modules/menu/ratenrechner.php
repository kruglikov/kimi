<?php

if (isset($kunde)) {

/*    if (App::$CURRENT->has_permission("subuebersicht", "*")) {
        array_push($menu, new MenuItem(TXT_LBL_SUBOVERVIEW, "subuebersicht"));
    } */
    if (App::$CURRENT->has_permission("stammdaten", "*")) {
        array_push($menu, new MenuItem(TXT_LBL_BASE_DATA, "stammdaten"));
    }
}
?>