<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;

class BatchSmokeTest extends TestCase
{
    /**
     * @dataProvider batchProvider
     */
    public function testBatchScriptParsesOnPhp85(string $name, string $path): void
    {
        // Batch scripts are data-import/mutating jobs: executing them would run
        // INSERT/UPDATE against the DB and echo record data. We verify PHP 8.5
        // compatibility with a syntax check (`php -l`) instead — no side effects.
        exec('php -l ' . escapeshellarg($path) . ' 2>&1', $lines, $code);
        $out = implode("\n", $lines);

        $this->assertSame(0, $code, "$name: php -l failed\n$out");
    }

    public static function batchProvider(): array
    {
        $dir = file_exists('/var/www/html/kimidev_ET/kimibatch')
            ? '/var/www/html/kimidev_ET/kimibatch'
            : realpath(__DIR__ . '/../../original-src/web/htdocs/kimidev_ET/kimibatch');

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
