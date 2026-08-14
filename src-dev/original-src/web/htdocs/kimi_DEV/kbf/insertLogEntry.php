<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : insertLogEntry.php

* Purpose :

* Creation Date : 31-07-2015

* Last Modified : Mit 12 Aug 2015 14:34:17 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require_once ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include ($rootDir."classes/LogEntry.php");

  $logEntry = new LogEntry ($_POST['logActivity'], $_POST['bookingDate'], (int)$_POST['logStatus'], (int)$_POST['logUser'], $_POST['scriptLog']);
  $logEntry->insert();

  $url = "http://" . $_SERVER['HTTP_HOST'] . $_POST['sourceURI'];

  header("Location: " . $url);
  exit;


  //var_dump($_POST);

?>
