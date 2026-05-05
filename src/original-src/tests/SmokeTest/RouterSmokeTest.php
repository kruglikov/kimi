<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

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
        exec('php ' . escapeshellarg($this->runner) . ' ' . escapeshellarg($name) . ' 2>&1', $lines, $code);
        $out = implode("\n", $lines);

        $this->assertSame(0, $code, "$name: non-zero exit\n$out");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function routeProvider(): array
    {
        $base = file_exists('/var/www/html/kimi_ET')
            ? '/var/www/html/kimi_ET'
            : realpath(__DIR__ . '/../../web/htdocs/kimi_ET');
        $files = glob($base . '/modules/gui/*.php') ?: [];

        return array_map(
            fn($f) => [basename($f, '.php')],
            $files
        );
    }
}
