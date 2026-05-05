<?php
// Launched as a subprocess by GuiSmokeTest.
// Usage: php gui_runner.php <absolute-path-to-module.php>

$modulePath = $argv[1] ?? '';
if (!$modulePath || !file_exists($modulePath)) {
    fwrite(STDERR, "gui_runner: file not found: $modulePath\n");
    exit(1);
}

// Inside Docker: tests → /var/www/tests, app → /var/www/html
// On host: tests → src/original-src/tests, app → src/original-src/web/htdocs
$appDir = file_exists('/var/www/html/kimi_ET')
    ? '/var/www/html/kimi_ET'
    : realpath(__DIR__ . '/../../web/htdocs/kimi_ET');
chdir($appDir);

$_SERVER['HTTP_USER_AGENT'] = 'SmokeTest/1.0';
$_SERVER['HTTP_HOST']       = 'localhost';
$_SERVER['REQUEST_URI']     = '/kimi_ET/';
$_SERVER['REQUEST_METHOD']  = 'GET';
$_GET  = [
    'ticket_id' => 1,   // seed ticket from 03-dev-seed.sql
    'mode'      => 'SEL',
    'kId'       => 1,   // seed campaign
];
$_POST = [];

include './libs/init.php';

// Seed session with the dev admin user (created by 03-dev-seed.sql).
$user = User::getFromName('admin');
if (!$user) {
    fwrite(STDERR, "gui_runner: 'admin' user not found. Is 03-dev-seed.sql applied and the DB running?\n");
    exit(2);
}

$_SESSION['user']          = $user;
$_SESSION['mandant']       = Mandant::get(1);
$_SESSION['portal-kampId'] = 1;
$_SESSION['kampId']        = 1;
App::$CURRENT->USER        = $_SESSION['user'];
App::$CURRENT->MANDANT     = $_SESSION['mandant'];

// Replicate index.php routing: include the initial/ pre-hook if it exists.
// These hooks set module-level variables ($ticket, $kamp, $kampId, $akt, etc.)
// that the GUI module expects to already be defined.
$moduleName  = basename($modulePath, '.php');
$initialHook = "./modules/initial/$moduleName.php";
if (file_exists($initialHook)) {
    include $initialHook;
}

// Generic fallbacks for context variables that initial hooks may not have set.
// Modules that already got these from their initial hook are unaffected.
if (!isset($ticket))  { $ticket  = Ticket::get(1); }
if (!isset($kampId))  { $kampId  = 1; }
if (!isset($kamp))    { $kamp    = Kampagne::load_for_id(1); }
if (!isset($kampPath)){ $kampPath = "./modules/gui/templates/tickets/$kampId"; }

// Run the module; discard HTML output (we only care about errors).
ob_start();
include $modulePath;
ob_end_clean();
