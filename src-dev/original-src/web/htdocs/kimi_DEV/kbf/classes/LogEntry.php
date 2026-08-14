<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : LogEntry.php

* Purpose :

* Creation Date : 23-07-2015

* Last Modified : Mit 12 Aug 2015 19:58:28 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
	
	class LogEntry {
    
    private $id;
		private $logActivity;
		private $logDay;
		private $statusId;
		private $created;
		private $userId;
		private $scriptLog;

		//Constructor
		public function __construct ($logActivity, $logDay, $statusId, $userId, $scriptLog, $id=null) {
			
			if (!isset($logActivity) || !isset($logDay) || !isset($statusId) || !isset($userId) || !isset($scriptLog)) {
				throw new Exception ("Can't create an Log Object, logEntry, logDay, status, user and scriptLog can't be null!");
			}

			$this->logActivity = $logActivity;
			$this->logDay = $logDay;
			$this->statusId = $statusId;
			$this->userId = $userId;
			$this->scriptLog = $scriptLog;
      
      $actualDateTime = new DateTime();
      $actualDateTime->setTimestamp(time());

			$this->created = $actualDateTime;
      $this->id = $id;

		}

    //functional Methods

    public function insert() {
      include (Settings::getPublic('root_dir').'instances/DBHandler_inst.php');

      return $dbHandler->insertLogEntry ($this);
    }

		//Getter Methods
		public function getLogActivity() {
			return $this->logActivity;
		}

    public function getLogActivityId() {
      include (Settings::getPublic('root_dir').'instances/DBHandler_inst.php');

      return $dbHandler->getLogActivityId($this->logActivity);
    }

		public function getLogDay() {
      return $this->logDay;
    }

    public function getStatusId() {
      return $this->statusId;
    }

    public function getCreated() {
      return $this->created;
    }

    public function getUserId() {
      return $this->userId;
    }

    public function getScriptLog() {
      return $this->scriptLog;
    }

    public function getId() {
      return $this->id;
    }

    public function setCreated (DateTime $timestamp) {
      $this->created = $timestamp;
    }

	}

?>
