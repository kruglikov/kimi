<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : editLogEntry.php

* Purpose :

* Creation Date : 03-08-2015

* Last Modified : Mit 12 Aug 2015 14:19:10 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require_once ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include ($rootDir."instances/DBHandler_inst.php");

  if (isset($_POST['logStatus']) && isset($_POST['scriptLog']) && isset($_POST['logEntryId'])) {
    
    $dbHandler->updateLogEntryStatus((int)$_POST['logStatus'], $_POST['scriptLog'], (int)$_POST['logEntryId']);
  }

  $url = "http://" . $_SERVER['HTTP_HOST'] . $_POST['sourceURI'];

  header("Location: " . $url);
  exit;


?>
