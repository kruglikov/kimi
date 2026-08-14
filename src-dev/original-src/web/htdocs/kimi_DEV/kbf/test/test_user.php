<?php

  include ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  include ($rootDir.'classes/instances.php');

  echo "User Franz: " . $logUser->getUserName(1);
  echo "User Thomas: " . $logUser->getUserName(3);
  echo "User id von Thomas: " . $logUser->getUserId('Thomas');
  echo "User id von Chrisi: " . $logUser->getUserId("Chrisi");
  echo "User id von Test: " . $logUser->getUserId("test");

?>
