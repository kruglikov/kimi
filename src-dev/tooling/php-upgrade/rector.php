<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Removing\Rector\FuncCall\RemoveFuncCallRector;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        dirname(__DIR__, 2) . '/original-src/web/htdocs/kimidev_ET',
    ])
    ->withSkip([
        dirname(__DIR__, 2) . '/original-src/web/htdocs/kimidev_ET/adminer-4.8.1.php',
        dirname(__DIR__, 2) . '/original-src/web/htdocs/kimidev_ET/kimibatch/vendor',
        // Second vendored PHPMailer copy, delivered with the production tree on
        // 2026-09-08. Third-party code is never rewritten.
        dirname(__DIR__, 2) . '/original-src/web/htdocs/kimidev_ET/kimibatch/files/vendor',
        dirname(__DIR__, 2) . '/original-src/web/htdocs/kimidev_ET/libs/addons/phpmail',
        RemoveFuncCallRector::class,
    ])
    // Explicitly target only post-PHP-8.0 upgrade rules.
    // This keeps Rector focused on 8.0 -> 8.5 compatibility work and avoids
    // pulling in pre-8.0 modernization sets such as php54/php71/php80.
    ->withSets([
        SetList::PHP_81,
        SetList::PHP_82,
        SetList::PHP_83,
        SetList::PHP_84,
        SetList::PHP_85,
    ]);
