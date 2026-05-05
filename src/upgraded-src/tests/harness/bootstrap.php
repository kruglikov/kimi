<?php

function kimi_app_dir(): string
{
    return file_exists('/var/www/html/kimi_ET')
        ? '/var/www/html/kimi_ET'
        : realpath(__DIR__ . '/../../web/htdocs/kimi_ET');
}

function kimi_reset_superglobals(array $get = [], array $post = []): void
{
    $_SERVER = array_merge($_SERVER, [
        'HTTP_USER_AGENT' => 'SmokeTest/1.0',
        'HTTP_HOST' => 'localhost',
        'REQUEST_URI' => '/kimi_ET/',
        'REQUEST_METHOD' => $post ? 'POST' : 'GET',
        'CONTENT_TYPE' => 'text/html; charset=UTF-8',
    ]);

    $_GET = array_merge([
        'ticket_id' => 1,
        'mode' => 'SEL',
        'kId' => 1,
        's' => 0,
        'cur_id' => 1,
    ], $get);
    $_POST = $post;
    $_REQUEST = array_merge($_GET, $_POST);
}

function kimi_bootstrap_portal(bool $withSession = true, array $get = [], array $post = []): void
{
    $appDir = kimi_app_dir();
    chdir($appDir);

    kimi_reset_superglobals($get, $post);

    include './libs/init.php';

    if (!$withSession) {
        session_unset();
        return;
    }

    // Seed session with the dev admin user (created by 03-dev-seed.sql).
    $user = User::getFromName('admin');
    if (!$user) {
        fwrite(STDERR, "bootstrap: 'admin' user not found. Is 03-dev-seed.sql applied and the DB running?\n");
        exit(2);
    }

    $_SESSION['user'] = $user;
    $_SESSION['mandant'] = Mandant::get(1);
    $_SESSION['portal-kampId'] = 1;
    $_SESSION['kampId'] = 1;
    $_SESSION['autoLogin'] = false;
    App::$CURRENT->USER = $_SESSION['user'];
    App::$CURRENT->MANDANT = $_SESSION['mandant'];
}
