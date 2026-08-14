<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/Quarantine.php';

class RouterSmokeTest extends TestCase
{
    private string $runner;

    protected function setUp(): void
    {
        $this->runner = __DIR__ . '/../harness/router_runner.php';
    }

    /**
     * @dataProvider routeProvider
     */
    public function testRouteLoadsThroughRealIndexWithoutFatal(string $name): void
    {
        if (in_array($name . '.php', Quarantine::ABSENT_FEATURE_MODULES, true)) {
            $this->markTestSkipped("$name references insurance/claims tables absent from this DB (inventory §1)");
        }
        if (in_array($name . '.php', Quarantine::DEAD_BACKUP_MODULES, true)) {
            $this->markTestSkipped("$name is a dated backup/dead module (inventory §4/§7)");
        }

        exec('php ' . escapeshellarg($this->runner) . ' ' . escapeshellarg($name) . ' 2>&1', $lines, $code);
        $out = implode("\n", $lines);

        $this->assertSame(0, $code, "$name: non-zero exit\n$out");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function routeProvider(): array
    {
        $base = file_exists('/var/www/html/kimidev_ET')
            ? '/var/www/html/kimidev_ET'
            : realpath(__DIR__ . '/../../original-src/web/htdocs/kimidev_ET');
        $files = glob($base . '/modules/gui/*.php') ?: [];

        return array_map(
            fn($f) => [basename($f, '.php')],
            $files
        );
    }
}
