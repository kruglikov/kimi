<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : createTables.php

* Purpose :

* Creation Date : 17-08-2015

* Last Modified : Mon 17 Aug 2015 15:38:54 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  require (Settings::getPublic('root_dir') . "instances/DBHandler_inst.php");

  $sqlFile = Settings::getPublic('root_dir') . "setup/kimiBatch_tabellen.sql";

  if (!$dbHandler->executeSqlFile($sqlFile)) {
    echo "Erstellen der Tabellen war nicht erfolgreich!";
  } else {
    echo "Das Erstellen der Tabellen war erfolgreich!";
  }

?>
