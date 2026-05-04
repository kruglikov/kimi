<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        dirname(__DIR__, 2) . '/web/htdocs/kimi_ET',
    ])
    ->withSkip([
        dirname(__DIR__, 2) . '/web/htdocs/kimi_ET/adminer-4.8.1.php',
        dirname(__DIR__, 2) . '/web/htdocs/kimi_ET/kimibatch/files/vendor',
        dirname(__DIR__, 2) . '/web/htdocs/kimi_ET/libs/addons/phpmail',
    ])
    ->withPhpSets();
