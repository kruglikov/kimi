<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : test.php

* Purpose :

* Creation Date : 14-08-2015

* Last Modified : Fre 14 Aug 2015 13:17:25 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  include_once (Settings::getPublic('root_dir')."classes/LogEntry.php");

  $log = new LogEntry ("CHECK Verarbeitung Buchungstag durchführen", "25.07.2015", 1, 1, "test.php");

  $log->insert();


?>
