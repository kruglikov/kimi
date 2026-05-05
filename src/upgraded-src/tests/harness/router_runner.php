<?php

require_once __DIR__ . '/bootstrap.php';

$route = $argv[1] ?? '';
if ($route === '') {
    fwrite(STDERR, "router_runner: route name required\n");
    exit(1);
}

kimi_bootstrap_portal(true, [
    'site' => $route,
]);

ob_start();
include './index.php';
ob_end_clean();
