<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : db_config.php

* Purpose :

* Creation Date : 23-07-2015

* Last Modified : Mit 12 Aug 2015 10:30:47 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

//connection infos
$dbUser = Settings::getProtected('db_user');
$password = Settings::getProtected('db_pwd');
$host = Settings::getProtected('db_host');
$dbname = Settings::getProtected('db_name');
$port = Settings::getProtected('db_port'); 
$socket = Settings::getProtected('db_socket');
$charset = Settings::getProtected('db_charset');


//get db connection

$mysqli = new mysqli($host, $dbUser, $password, $dbname, $port, $socket);
$mysqli->set_charset($charset);
if ($mysqli->connect_errno) {
  throw new Exception ("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
?>
