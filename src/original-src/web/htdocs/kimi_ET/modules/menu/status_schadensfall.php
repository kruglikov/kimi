<?php


if (App::$CURRENT->has_permission("menu_verw", "*") && isset($status_schadensfall)) {
    array_push($menu, new MenuItem(TXT_LBL_MENU_VERW, "menu_verw"));
}

?>