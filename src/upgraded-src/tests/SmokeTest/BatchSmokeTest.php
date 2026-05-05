<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

class BatchSmokeTest extends TestCase
{
    /**
     * @dataProvider batchProvider
     */
    public function testBatchScriptRunsWithoutFatal(string $name, string $path): void
    {
        $lines = [];
        $command = sprintf(
            'cd %s && timeout 60 php %s 2>&1',
            escapeshellarg(dirname($path)),
            escapeshellarg(basename($path))
        );
        exec($command, $lines, $code);
        $out = implode("\n", $lines);

        $this->assertNotSame(124, $code, "$name: timed out after 60s");
        $this->assertStringNotContainsString('Fatal error', $out, "$name: Fatal error");
        $this->assertStringNotContainsString('Parse error', $out, "$name: Parse error");
    }

    public static function batchProvider(): array
    {
        $dir = file_exists('/var/www/html/kimi_ET/kimibatch')
            ? '/var/www/html/kimi_ET/kimibatch'
            : realpath(__DIR__ . '/../../web/htdocs/kimi_ET/kimibatch');

        $files = glob($dir . '/*.php') ?: [];
        $files = array_values(array_filter(
            $files,
            fn($f) => basename($f) !== 'pwgen.php'
        ));

        return array_map(
            fn($f) => [basename($f), $f],
            $files
        );
    }
}
