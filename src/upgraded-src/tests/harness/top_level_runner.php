<?php

require_once __DIR__ . '/bootstrap.php';

$target = $argv[1] ?? '';
$scenario = $argv[2] ?? '';
if (!$target || !$scenario || !file_exists($target)) {
    fwrite(STDERR, "top_level_runner: expected <path> <scenario>\n");
    exit(1);
}

switch ($scenario) {
    case 'login-anon':
        kimi_bootstrap_portal(false);
        break;

    case 'login-auth':
        kimi_bootstrap_portal(true);
        break;

    case 'getticketurl':
        chdir(kimi_app_dir());
        kimi_reset_superglobals([
            'mandantId' => 1,
            'mandantName' => 'Smoke',
            'benutzer' => 'admin',
            'telefonGruppe' => 'SMOKE-GROUP',
            'telefonNr' => '+43123456789',
        ]);
        break;

    case 'setticketcallinfo':
        chdir(kimi_app_dir());
        kimi_reset_superglobals();
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['CONTENT_TYPE'] = 'application/json';
        break;

    case 'xhangup':
        chdir(kimi_app_dir());
        kimi_reset_superglobals([], [
            'status' => 'HANGUP',
            'ticket_reference' => '1',
            'action_url' => 'https://localhost/kimi_ET/index.php?mandant=1&ticket_id=1',
            'id' => '1',
        ]);
        $_SERVER['REQUEST_METHOD'] = 'POST';
        break;

    case 'testpost':
        chdir(kimi_app_dir());
        kimi_reset_superglobals();
        break;

    case 'validphone':
        chdir(kimi_app_dir());
        kimi_reset_superglobals();
        break;

    case 'phpinfo':
        chdir(kimi_app_dir());
        kimi_reset_superglobals();
        break;

    case 'adminer':
        chdir(kimi_app_dir());
        kimi_reset_superglobals();
        break;

    case 'root-index':
        chdir(dirname($target));
        $_SERVER = array_merge($_SERVER, [
            'HTTP_USER_AGENT' => 'SmokeTest/1.0',
            'HTTP_HOST' => 'localhost',
            'REQUEST_URI' => '/',
            'REQUEST_METHOD' => 'GET',
        ]);
        $_GET = [];
        $_POST = [];
        $_REQUEST = [];
        break;

    default:
        fwrite(STDERR, "top_level_runner: unknown scenario '$scenario'\n");
        exit(1);
}

ob_start();
include $target;
ob_end_clean();
