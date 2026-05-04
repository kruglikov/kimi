<?php
if (App::$CURRENT->has_permission("ticketsuch", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_TICKSUCH, "ticketsuch"));
}
if (App::$CURRENT->has_permission("ticket", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_TICKDETAIL, "ticket"));
}
if (App::$CURRENT->has_permission("kampauswahl", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_KAMPAUSWAHL, "kampauswahl", "forced=true"));
}
?>
