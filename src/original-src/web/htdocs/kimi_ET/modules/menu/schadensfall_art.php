<?php


if (App::$CURRENT->has_permission("menu_verw", "*") && isset($schadensfall_arten)) {
    array_push($menu, new MenuItem(TXT_LBL_MENU_VERW, "menu_verw"));
}

?>