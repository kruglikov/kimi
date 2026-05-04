<?php
$pw = param("password");

if (isset($pw)) {
    $hash = User::encrypt($pw);
}
else {
    $hash = "";
}
?>
