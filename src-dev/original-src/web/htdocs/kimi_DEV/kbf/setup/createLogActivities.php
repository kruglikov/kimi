<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : createLogActivities.php

* Purpose :

* Creation Date : 17-08-2015

* Last Modified : Mon 17 Aug 2015 17:03:11 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  require (Settings::getPublic('root_dir') . "classes/LogActivity.php");

  function initialSetup () {

    $filepath = Settings::getPublic('root_dir') . "setup/initialLogActvities.csv";

    $csvContent = file_get_contents($filepath);

    $csvLines = explode ("\n", $csvContent);
    var_dump($csvLines); 
    $lines = array();
    foreach ($csvLines as $line) {
      if ($line !== "") {
        $l = explode(";", $line);
        array_push($lines, $l);
      }
    }

    $index = 1;
    foreach ($lines as $act) {
      $la = new LogActivity($act[0], $act[1], $index, $act[2]);
      $la->insert();
      $index++;
    }

    var_dump($lines);
    
    /*$index = 1;
    foreach ($logEntries as $logEntry) {
      $logEntry->setPosition($index);
      $logEntry->insert();
      $index++;

    }*/

  }
  
  initialSetup();


?>
