<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/Quarantine.php';

class GuiSmokeTest extends TestCase
{
    private string $runner;

    protected function setUp(): void
    {
        $this->runner = __DIR__ . '/../harness/gui_runner.php';
    }

    /**
     * @dataProvider moduleProvider
     */
    public function testModuleLoadWithoutFatal(string $name, string $path): void
    {
        if (in_array($name, Quarantine::ABSENT_FEATURE_MODULES, true)) {
            $this->markTestSkipped("$name references insurance/claims tables absent from this DB (inventory §1)");
        }
        if (in_array($name, Quarantine::DEAD_BACKUP_MODULES, true)) {
            $this->markTestSkipped("$name is a dated backup/dead module (inventory §4/§7)");
        }

        exec('php ' . escapeshellarg($this->runner) . ' ' . escapeshellarg($path) . ' 2>&1', $lines, $code);
        $out = implode("\n", $lines);

        $this->assertSame(0, $code,   "$name: non-zero exit\n$out");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function moduleProvider(): array
    {
        $base = file_exists('/var/www/html/kimidev_ET')
            ? '/var/www/html/kimidev_ET'
            : realpath(__DIR__ . '/../../original-src/web/htdocs/kimidev_ET');
        $files = array_merge(
            glob($base . '/modules/gui/*.php') ?: [],
            glob($base . '/ajax/*.php')        ?: []
        );
        return array_map(fn($f) => [basename($f), $f], $files);
    }
}