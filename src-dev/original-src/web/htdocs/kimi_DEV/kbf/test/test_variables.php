<?php
/* -.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.

* File Name : test_variables.php

* Purpose :

* Creation Date : 12-08-2015

* Last Modified : Son 16 Aug 2015 22:22:11 CEST

* Created By : Thomas Greb

* © Greb Consult

_._._._._._._._._._._._._._._._._._._._._.*/
require ($_SERVER['DOCUMENT_ROOT']."/kimi/kimi_ET/kbf/config/config.php");
var_dump($_SERVER['HTTP_HOST']);
var_dump($_SERVER['REQUEST_URI']);
var_dump($_SERVER['DOCUMENT_ROOT']);
var_dump(Settings::getPublic('html_home'));
?>
