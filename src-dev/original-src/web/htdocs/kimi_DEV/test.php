<?php

include_once './libs/init.php';

$_POST["username"] = "aberl";
$_POST["password"] ="";

require_once './ajax/check-login.php';

//$user = User::login("aberl", "");
//echo "test";

//$mandanten = Mandant::load_mandanten($user);
//echo "done\n\n";
//var_dump($mandanten);

?>