<?php


if (App::$CURRENT->has_permission("menu_verw", "*") && isset($bankleitzahl)) {
    array_push($menu, new MenuItem(TXT_LBL_MENU_VERW, "menu_verw"));
}

?>