<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : File.php

* Purpose :

* Creation Date : 06-08-2015

* Last Modified : Son 16 Aug 2015 22:23:45 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  class File {

    private $basename;
    private $filename;
    private $fileextension;
    private $dirpath;

    public function __construct ($filepath) {

      $path_parts = pathinfo($filepath);

      $this->filename = $path_parts['filename'];
      $this->basename = $path_parts['basename'];
      
      if (isset($path_parts['extension'])) {
        $this->fileextension = $path_parts['extension'];
      } else {
        $this->fileextension = null;
      }
      $this->dirpath = $path_parts['dirname'];

    }

    private function exists() {
      $filePath = $this->dirpath.DIRECTORY_SEPARATOR.$this->basename;
      return is_file($filePath);
    }

    public function putToFtp ($remoteDestination, $bookingDir=true) {
      
      include_once (Settings::getPublic('root_dir')."instances/Ftp_inst.php");
      include (Settings::getPublic('root_dir')."config/dateformat_config.php");

      if (!self::exists()) {
        return false;
      }

      if (!$ftp->connect()) {
        return false;
      }

      if ($bookingDir) {
        $date = DateTime::createFromFormat($dateformat['date']['php'], $_COOKIE['bookingDate']);
        $dirName = $date->format($dateformat['folder']['php']);
        $remoteDestination = $remoteDestination . DIRECTORY_SEPARATOR . $dirName;
      }

      $ftp->makeDirectory($remoteDestination);

      $fp = fopen(self::getFilepath(), 'r');
      //var_dump($fp);

      $success = $ftp->putFile($remoteDestination.DIRECTORY_SEPARATOR.$this->basename, $fp);

      $ftp->close();
      fclose($fp);

      return $success;

    }

    public function getFromFtp ($remoteFilepath) {

      include_once (Settings::getPublic('root_dir')."instances/Ftp_inst.php");

      $fp = fopen(self::getFilepath(), 'w');
      //var_dump($fp);
      $ftp->connect();
      $success = $ftp->getFile($remoteFilepath, $fp);
      $ftp->close();
      fclose($fp);
      $success = $success && self::exists();
      return $success;

    }

    public function deleteMe () {
      return unlink (self::getFilepath());
    }

    //getter Methods
    public function getFilename() {
      return $this->filename;
    }

    public function getBasename() {
      return $this->basename;
    }

    public function getDirectoryPath() {
      return $this->dirpath;
    }

    public function getFilepath() {
      return $this->dirpath.DIRECTORY_SEPARATOR.$this->basename;
    }

  }

?>
