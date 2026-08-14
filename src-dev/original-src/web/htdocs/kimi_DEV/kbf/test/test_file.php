<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : test_file.php

* Purpose :

* Creation Date : 06-08-2015

* Last Modified : Mon 10 Aug 2015 10:50:07 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/
include ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
include_once ($rootDir."classes/File.php");

/*$filepath = "/var/www/phpinfo.php";

$f = new File ($filepath);

var_dump($f->putToFtp('/ftp_exchange/to_ftp', true));
*/

$filepath = $rootDir."phpinfo.php";
$f = new File ($filepath);
var_dump($f->getFromFtp("/ftp_exchange/from_ftp/phpinfo.php"));


?>
