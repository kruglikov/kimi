<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : test_KimiBatch.php

* Purpose :

* Creation Date : 14-08-2015

* Last Modified : Son 16 Aug 2015 17:20:20 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include_once (Settings::getPublic('root_dir')."classes/KimiBatch.php");

  $url1 = 'http://gcvirsv03/kbf/test_scripts/checkverwaltungssatzsalden_test.php';
  $url2 = "http://gcvirsv03/kbf/test_scripts/buchungsjournalfile_test.php";

  $url3 = 'http://gcvirsv03/kbf/test_scripts/chedckverwaltungssatzsalden_test.php';
  
  $kb = new KimiBatch ("Verwaltungssatz Salden berechnen");
  
  $kb->copyScriptInputFileFromFtp (Settings::getPublic('ftpFrom_test')."/phpinfo.php", Settings::getPublic('root_dir')."tmp/phpinfo.php");
  $kb->executeHttpScript($url1, false);
  //$kb->copyScriptFileToFtp(Settings::getPublic('toFtp_test'));



?>
