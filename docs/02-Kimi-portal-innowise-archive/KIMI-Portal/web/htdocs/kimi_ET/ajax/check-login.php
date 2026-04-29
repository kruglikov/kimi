<?php
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
} else {
    header("HTTP/1.0 403 No Username/Password given");
    exit;
}
$user = User::login($username, $password);

if (!isset($user) || !$user) {
    header("HTTP/1.0 403 No Permission");
    exit;
}

$_SESSION["user"] = $user;
$mandanten = Mandant::load_mandanten($user);

echo "OK";

echo json_encode($mandanten);
?>
