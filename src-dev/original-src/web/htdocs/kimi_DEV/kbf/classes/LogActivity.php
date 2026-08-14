<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : LogActivity.php

* Purpose :

* Creation Date : 23-07-2015

* Last Modified : Mon 17 Aug 2015 17:09:41 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  class LogActivity {
    
    private $id;
    private $topic;
    private $activity;
    private $note;
    private $position;

    //Contructor
    public function __construct ($topic, $activity, $position, $note=null, $id=null) {
      if (!isset($topic) || !isset($activity) || !isset($position)) {
	throw new Exception ("Can't create an LogActivity, topic and activity can't be null");
      }
      
      $this->topic = $topic;
      $this->activity = $activity;
      
      if ($note === "") {
        $this->note = null;
      } else {
        $this->note = $note;
      }

      $this->position = $position;
      $this->id = $id;
    
    }

    //DB Methods

    public function insert() {
      include (Settings::getPublic('root_dir').'instances/DBHandler_inst.php');
      if (!$dbHandler->existsLogActivity($this->activity)) {
        return $dbHandler->insertLogActivity($this);
      }

      return false;
    }

    public function insertLogActivityBefore ($activity) {
      include (Settings::getPublic('root_dir').'instances/DBHandler_inst.php');

      if ($dbHandler->existsLogActivity($this->activity) || !$dbHandler->existsLogActivity($activity)) {
        return false;
      }

      $posBefore = $dbHandler->getLogActivityPos($activity);

      if (!$dbHandler->increaseLogActivityPos($posBefore)) {
        return false;
      }

      $this->position = $posBefore;

      return self::insert();
    }

    public function insertLogActivityAfter ($activity) {
      include (Settings::getPublic('root_dir').'instances/DBHandler_inst.php');

      if ($dbHandler->existsLogActivity($this->activity) || !$dbHandler->existsLogActivity($activity)) {
        return false;
      }

      $posActual = $dbHandler->getLogActivityPos ($activity);

      if (!$dbHandler->increaseLogActivityPos($posActual + 1)) {
        return false;
      }

      $this->position = $posActual + 1;

      return self::insert();

    }

    public static function exists($activity) {
      include (Settings::getPublic('root_dir').'instances/DBHandler_inst.php');

      return $dbHandler->existsLogActivity($activity);
    }

    public function getLogEntries ($logDay) {
      include (Settings::getPublic('root_dir').'instances/DBHandler_inst.php');

      return $dbHandler->getLogEntries($this->activity, $logDay);
    }

    //Getter Methods
    public function getTopic() {
      return $this->topic;
    }

    public function getActivity() {
      return $this->activity;
    }

    public function getNote() {
      return $this->note;
    }

    public function getPosition() {
      return $this->position;
    }

    public function getId() {
      return $this->id;
    }

    //Setter Methods

    public function setPosition($pos) {
      $this->position = $pos;
    }

  }

?>
