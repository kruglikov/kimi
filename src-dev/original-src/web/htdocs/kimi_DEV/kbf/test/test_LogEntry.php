<?php

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include (Settings::getPublic('root_dir').'classes/LogEntry.php');

  /*$log = new LogEntry ("CHECK Verarbeitung Buchungstag durchführen", "23.07.2015", 1, 1, "CHECK Verarbeitung Buchungstag- Start: 10.07.2015 12:57:11\nPrüfung Ordnungsgemäße Verarbeitung Buchungstag:\nStart: 10.07.2015 12:57:11\nBUCHUNGSTAG ordnungsgemß verarbeitet\nEnde: 10.07.2015 12:57:11\nCHECK Verarbeitung Buchungstag - Ende: 10.07.2015 12:57:11");
  
  var_dump($log);
  echo "Teste Log schreiben<br> Log: ";

  var_dump($log->insert());*/

  include (Settings::getPublic('root_dir')."instances/DBHandler_inst.php");

  echo test;
  var_dump($dbHandler->getLogEntries ("CHECK Verarbeitung Buchungstag durchführen", "23.07.2015"));

?>
