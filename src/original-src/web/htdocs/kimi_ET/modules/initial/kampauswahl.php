<?php

$kampagnen = Kampagne::load_all();
$lastKamp = App::$CURRENT->USER->get_letzte_kampagne_id();

if (isset($_SESSION["kampId"]) && !param("forced", FALSE)) {
    header("Location: ./index.php?site=ticketsuch");
    exit;
}

?>