<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : dateformat_config.php

* Purpose :

* Creation Date : 24-07-2015

* Last Modified : Mit 12 Aug 2015 17:13:16 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/

  require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");

  $dateformat = array (
    'date' => array (
        'php' => 'd.m.Y',
        'mysql' => '%d.%m.%Y',
      ),
    'timestamp' => array (
        'php' => 'd.m.Y H:i:s',
        'mysql' => '%d.%m.%Y %H:%i:%s',
      ),
    'folder' => array (
        'php' => 'Ymd',
        'mysql' => '%Y%m%d',
      ),
    );

?>
