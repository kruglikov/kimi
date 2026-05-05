<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

class InitialSmokeTest extends TestCase
{
    private string $runner;

    protected function setUp(): void
    {
        $this->runner = __DIR__ . '/../harness/module_runner.php';
    }

    /**
     * @dataProvider initialProvider
     */
    public function testInitialHookLoadsWithoutFatal(string $name, string $path): void
    {
        exec(
            'php ' . escapeshellarg($this->runner) . ' initial ' . escapeshellarg($path) . ' 2>&1',
            $lines,
            $code
        );
        $out = implode("\n", $lines);

        $this->assertSame(0, $code, "$name: non-zero exit\n$out");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function initialProvider(): array
    {
        $base = file_exists('/var/www/html/kimi_ET')
            ? '/var/www/html/kimi_ET'
            : realpath(__DIR__ . '/../../web/htdocs/kimi_ET');
        $files = glob($base . '/modules/initial/*.php') ?: [];

        return array_map(fn($f) => [basename($f), $f], $files);
    }
}
