<?php

// Buffer bootstrap output (entity files with trailing content after `?>`) so the
// real index.php can still call session_name() without a "headers already sent" warning.
ob_start();
require_once __DIR__ . '/bootstrap.php';

$route = $argv[1] ?? '';
if ($route === '') {
    fwrite(STDERR, "router_runner: route name required\n");
    exit(1);
}

kimi_bootstrap_portal(true, [
    'site' => $route,
]);

include './index.php';
ob_end_clean();
