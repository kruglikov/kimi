<?php

  include ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include_once (Settings::getPublic('root_dir').'classes/LogActivity.php');
  include (Settings::getPublic('root_dir').'instances/DBHandler_inst.php');

  //$entry1 = new LogActivity ('Stichtag Teil 3', 'Stichtagende setzten', 2);
  //$entry1->insert();


  /*$logEntries = array (
    new LogActivity("Verwaltungssatz", "CHECK Verarbeitung Buchungstag durchführen", 1, "CHECK ob Buchungstag ordnungsgemäß verarbeitet"),
    new LogActivity("Verwaltungssatz", "Verwaltungssatz Salden berechnen", 2, "Berechnungen Tages- und Gesamtsalden"),
  );

  foreach ($logEntries as $logEntry) {
    $logEntry->insert();
  }

  $entry1 = new LogActivity("Verwaltungssatz", "Verwaltungssatz Planung durchführen", 1, "Planung Buchungs- und Stichtage und Eintragung in die Verwaltungssatzsteuerungen, wöchentlich");
  var_dump($entry1->insertLogActivityBefore("Verwaltungssatz Salden berechnen"));*/


  //include ($rootDir.'classes/instances.php');
  /*var_dump($dbHandler->getLogActivityPos ('CHECK Verarbeitung Buchungstag durchführen'));
  //var_dump($dbHandler->increaseLogActivityPos(3));

  var_dump($dbHandler->existsLogActivity('CHECK Verarbeitung Buchungstag durchführen'));

  //var_dump($dbHandler->getLogActivities());

  var_dump($dbHandler->getLogActivityId("Verwaltungssatz Planung durchführen"));

  echo mb_internal_encoding();*/

  $entry1 = new LogActivity ('Stichtag Teil 3', 'Stichtagende setzten', 0);
  var_dump($entry1->insertLogActivityAfter("Verwaltungssatz Salden berechnen"));



?>
