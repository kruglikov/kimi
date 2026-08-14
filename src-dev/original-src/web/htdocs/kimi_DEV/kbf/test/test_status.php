<?php

  include ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include ($rootDir.'classes/instances.php');

  echo "Test Status<br>";
  echo "Status mit der id 1: " . $logStatus->getLogStatus(1);
  echo "Status-id von FEHLER: " . $logStatus->getLogStatusId("FEHLER");

?>
