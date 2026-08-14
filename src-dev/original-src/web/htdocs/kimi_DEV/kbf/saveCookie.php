<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : saveCookie.php

* Purpose :

* Creation Date : 30-07-2015

* Last Modified : Mit 12 Aug 2015 14:34:28 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require_once ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
  
  $lifeTime = 60*60*24*7; //7 Tage
  $cookieLifetime = time()+$lifeTime;

  if (!isset($_POST['value']) || !isset($_POST['sourceURI']) || !isset($_POST['cookieName'])) {
    echo "Error: required variables for saving cookie are not set!";
  }

  setcookie($_POST['cookieName'], $_POST['value'], $cookieLifetime, KBF_HOME);

  $url = "http://" . $_SERVER['HTTP_HOST'] . $_POST['sourceURI'];

  header("Location: " . $url);
  exit;

  /*foreach ($_POST as $key => $value) {
    echo $key . ": " . $value;
  }*/

?>
