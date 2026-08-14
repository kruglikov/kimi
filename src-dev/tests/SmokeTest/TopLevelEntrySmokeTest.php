<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/Quarantine.php';

class TopLevelEntrySmokeTest extends TestCase
{
    private string $runner;

    protected function setUp(): void
    {
        $this->runner = __DIR__ . '/../harness/top_level_runner.php';
    }

    /**
     * @dataProvider entryProvider
     */
    public function testTopLevelEntryLoadsWithoutFatal(string $name, string $path, string $scenario): void
    {
        if (in_array($name, Quarantine::NON_APP_TOPLEVEL, true)) {
            $this->markTestSkipped("$name is a bundled tool / behavioral redirect endpoint, not load-testable offline (inventory §7)");
        }

        exec(
            'timeout 60 php -d default_socket_timeout=1 ' . escapeshellarg($this->runner) . ' ' . escapeshellarg($path) . ' ' . escapeshellarg($scenario) . ' 2>&1',
            $lines,
            $code
        );
        $out = implode("\n", $lines);

        $this->assertNotSame(124, $code, "$name: timed out after 60s");
        $this->assertSame(0, $code, "$name: non-zero exit\n$out");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function entryProvider(): array
    {
        $base = file_exists('/var/www/html/kimidev_ET')
            ? '/var/www/html/kimidev_ET'
            : realpath(__DIR__ . '/../../original-src/web/htdocs/kimidev_ET');

        return [
            ['login.php (anonymous)', $base . '/login.php', 'login-anon'],
            ['login.php (seeded session)', $base . '/login.php', 'login-auth'],
            ['getticketurl.php', $base . '/getticketurl.php', 'getticketurl'],
            ['setticketcallinfo.php', $base . '/setticketcallinfo.php', 'setticketcallinfo'],
            ['xhangup.php', $base . '/xhangup.php', 'xhangup'],
            ['testpost.php', $base . '/testpost.php', 'testpost'],
            ['validphone.php', $base . '/validphone.php', 'validphone'],
            ['phpinfo.php', $base . '/phpinfo.php', 'phpinfo'],
            ['adminer-4.8.1.php', $base . '/adminer-4.8.1.php', 'adminer'],
            ['web/htdocs/index.php', dirname($base) . '/index.php', 'root-index'],
        ];
    }
}
