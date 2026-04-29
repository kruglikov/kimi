<?php

if (App::$CURRENT->has_permission("ticketsuch", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_TICKSUCH, "ticketsuch2"));
}
if (App::$CURRENT->has_permission("ticket", "*")) {
    array_push($menu, new MenuItem(TXT_LBL_TICKDETAIL, "ticket2"));
}

?>
