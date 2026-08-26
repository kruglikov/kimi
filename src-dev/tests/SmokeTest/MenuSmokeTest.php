<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/Quarantine.php';

class MenuSmokeTest extends TestCase
{
    private string $runner;

    protected function setUp(): void
    {
        $this->runner = __DIR__ . '/../harness/module_runner.php';
    }

    /**
     * @dataProvider menuProvider
     */
    public function testMenuIncludeLoadsWithoutFatal(string $name, string $path): void
    {
        if (in_array($name, Quarantine::ABSENT_FEATURE_MODULES, true)) {
            $this->markTestSkipped("$name references insurance/claims tables absent from this DB (inventory §1)");
        }
        if (in_array($name, Quarantine::CONTEXT_DEPENDENT_MODULES, true)) {
            $this->markTestSkipped("$name needs a full case/customer context the direct-include runner doesn't build (covered via RouterSmokeTest / Phase 3.3)");
        }

        exec(
            'php ' . escapeshellarg($this->runner) . ' menu ' . escapeshellarg($path) . ' 2>&1',
            $lines,
            $code
        );
        $out = implode("\n", $lines);

        $this->assertSame(0, $code, "$name: non-zero exit\n$out");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function menuProvider(): array
    {
        $base = file_exists('/var/www/html/kimidev_ET')
            ? '/var/www/html/kimidev_ET'
            : realpath(__DIR__ . '/../../original-src/web/htdocs/kimidev_ET');
        $files = glob($base . '/modules/menu/*.php') ?: [];
        $files = array_values(array_filter(
            $files,
            fn(string $f): bool => basename($f) !== 'ticketsuch_sich20150208.php'
        ));

        return array_map(fn($f) => [basename($f), $f], $files);
    }
}
