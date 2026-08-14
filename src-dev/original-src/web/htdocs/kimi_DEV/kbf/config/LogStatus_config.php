<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : LogStatus_config.php

* Purpose :

* Creation Date : 23-07-2015

* Last Modified : Mit 12 Aug 2015 17:13:03 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/
  
  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  class LogStatus {

    private $logStatus = array (
      1 => "OK",
      2 => "FEHLER",
      3 => "KONTROLLE",
    );

    public function getLogStatus ($statusId) {
      return $this->logStatus[$statusId];
    }

    public function getLogStatusId ($status) {
      foreach ($this->logStatus as $id => $value) {
        if (strcmp($status, $value) === 0) {
          return $id;
        }
      }
      return false;
    }

    public function getLogStatusArray() {
      return $this->logStatus;
    }

  }

?>
