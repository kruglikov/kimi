<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : Ftp.php

* Purpose :

* Creation Date : 05-08-2015

* Last Modified : Son 16 Aug 2015 15:00:56 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/
  
require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  class Ftp { 

    private $connection;

    public function __construct () {

    }

    public function connect() {


      if (Settings::getProtected('ftp_ssl')) {
        $this->connection = ftp_ssl_connect (Settings::getProtected('ftp_host'), Settings::getProtected('ftp_port'), Settings::getProtected('ftp_timeout'));
      } else {
        $this->connection = ftp_connect (Settings::getProtected('ftp_host'), Settings::getProtected('ftp_port'), Settings::getProtected('ftp_timeout'));
      }

      $login_sucess = ftp_login($this->connection, Settings::getProtected('ftp_user'), Settings::getProtected('ftp_pwd'));

      if (Settings::getProtected('passiveMode')) {
        ftp_pasv ($this->connection, true);
      } else {
        ftp_pasv ($this->connection, false);
      }

      return $login_sucess;
    }

    public function getActualContent() {
      return ftp_nlist($this->connection, ".");
    }

    public function getCurrentDirectory() {
      return ftp_pwd($this->connection);
    }

    public function getFile($remoteFilepath, $handle) {
      
      return ftp_fget($this->connection, $handle, $remoteFilepath, Settings::getProtected('ftp_transferMode'), 0);
    }

    //method to create a directory on the given path; parent directories have to exist;
    //returns false, if an error occures; returns true, if directory already exists; returns the created directory-path, if the directory sucessfull created
    public function makeDirectory ($dirpath) {
      if (!self::exists($dirpath)) {
        return ftp_mkdir($this->connection, $dirpath);
      }
      return true;
    }

    public function putFile($remoteFilepath, $handle) {

      return ftp_fput($this->connection, $remoteFilepath, $handle, Settings::getProtected('ftp_transferMode'), 0);
    }

    public function changeDirectory ($dir) {
      return ftp_chdir($this->connection, $dir);
    }

    public function exists($path) {
      
      $currentDir = self::getCurrentDirectory();
      $pathParts = explode (DIRECTORY_SEPARATOR, $path);
      $parentPath = "";

      for ($i = 0; $i < count($pathParts)-1; $i++) {
        $parentPath = $parentPath. $pathParts[$i] . DIRECTORY_SEPARATOR;
      }

      if (!self::changeDirectory($parentPath)) {
        throw new Exception ("Error: Can't change FTP-Directory!");
      }
      $elemList = self::getActualContent();

      foreach ($elemList as $elem) {
        if (strcmp($elem, $pathParts[count($pathParts)-1]) === 0) {
          self::changeDirectory($currentDir);
          return true;
        }
      }
      self::changeDirectory($currentDir);
      return false;
    }


    public function close() {

      ftp_close($this->connection);
    }

  }

?>
