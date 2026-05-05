<?php

require_once __DIR__ . '/bootstrap.php';

$type = $argv[1] ?? '';
$modulePath = $argv[2] ?? '';
if (!in_array($type, ['initial', 'menu'], true) || !$modulePath || !file_exists($modulePath)) {
    fwrite(STDERR, "module_runner: expected <initial|menu> <path>\n");
    exit(1);
}

$moduleName = basename($modulePath, '.php');
kimi_bootstrap_portal(true, [
    'site' => $moduleName,
]);

if ($type === 'initial') {
    ob_start();
    include $modulePath;
    ob_end_clean();
    return;
}

$menu = [];
$initialPath = "./modules/initial/$moduleName.php";
if (file_exists($initialPath)) {
    include $initialPath;
}

ob_start();
include $modulePath;
ob_end_clean();
