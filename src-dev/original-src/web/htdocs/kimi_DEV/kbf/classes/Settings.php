<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : Settings.php

* Purpose :

* Creation Date : 12-08-2015

* Last Modified : Mit 12 Aug 2015 19:47:40 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  
  abstract class Settings {
    static private $protected = array();
    static private $public = array();

    public static function getProtected($key) {
      return isset(self::$protected[$key]) ? self::$protected[$key] : null;
    }

    public static function getPublic($key) {
      return isset(self::$public[$key]) ? self::$public[$key] : null;
    }

    public static function setProtected($key, $value) {
      self::$protected[$key] = $value;
    }

    public static function setPublic($key, $value) {
      self::$public[$key] = $value;
    }

    public function __get($key) {
      return isset(self::$public[$key]) ? self::$public[$key] : null;
    }

    public function __isset($key) {
      return isset(self::$public[$key]);
    }

  }

?>
