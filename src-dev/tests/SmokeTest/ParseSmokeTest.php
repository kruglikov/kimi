<?php

namespace KimiTest\SmokeTest;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Parses every application PHP file in the tree.
 *
 * The other smoke tests discover their subjects with directory globs
 * (kimibatch/*.php, modules/gui/*.php and so on), so a file in a directory no
 * glob names is invisible to them and a green run says nothing about it. That
 * gap is not hypothetical: the production delivery of 2026-09-08 added four
 * ticket-template directories, and none of them was reached by any glob.
 *
 * This test walks the whole tree instead, so the safety net covers every file
 * by construction. The assertion is a syntax check rather than execution,
 * because most of these files are fragments that only make sense inside their
 * including page.
 */
class ParseSmokeTest extends TestCase
{
    /**
     * Third-party or non-application code, never rewritten and never our
     * responsibility to keep parsing. Matched as a path prefix.
     */
    private const EXCLUDED_PREFIXES = [
        '.git/',
        'kimibatch/vendor/',
        'kimibatch/files/vendor/',
        'libs/addons/phpmail/',
    ];

    /**
     * @dataProvider phpFileProvider
     */
    public function testFileParsesOnPhp85(string $relativePath, string $absolutePath): void
    {
        exec('php -l ' . escapeshellarg($absolutePath) . ' 2>&1', $lines, $code);
        $output = implode("\n", $lines);

        $this->assertSame(0, $code, "$relativePath: php -l failed\n$output");
    }

    public static function phpFileProvider(): array
    {
        $appRoot = file_exists('/var/www/html/kimidev_ET')
            ? '/var/www/html/kimidev_ET'
            : realpath(__DIR__ . '/../../original-src/web/htdocs/kimidev_ET');

        $directoryIterator = new RecursiveDirectoryIterator($appRoot, RecursiveDirectoryIterator::SKIP_DOTS);
        $allFiles = new RecursiveIteratorIterator($directoryIterator);

        $cases = [];
        foreach ($allFiles as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $relativePath = substr($file->getPathname(), strlen($appRoot) + 1);
            if (self::isExcluded($relativePath)) {
                continue;
            }

            $cases[$relativePath] = [$relativePath, $file->getPathname()];
        }

        ksort($cases);

        return $cases;
    }

    private static function isExcluded(string $relativePath): bool
    {
        foreach (self::EXCLUDED_PREFIXES as $prefix) {
            if (str_starts_with($relativePath, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
