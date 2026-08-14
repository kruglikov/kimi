<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : LogUser_config.php

* Purpose :

* Creation Date : 23-07-2015

* Last Modified : Mit 12 Aug 2015 17:13:38 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/
  
  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  class LogUser {

    private $logUsers = array (
      1 => "Franz",
      2 => "Chrisi",
      3 => "Thomas",
    );

    public function getUserName ($userId) {
      return $this->logUsers[$userId];
    }

    public function getUserId ($name) {
      foreach ($this->logUsers as $id => $value) {
        if (strcmp($name, $value) === 0) {
          return $id;
        }
      }
      return false;
    }

    //Getter Methods
    public function getLogUserArray() {
      return $this->logUsers;
    }



  }

?>
