#!/usr/bin/env bash
cd "$(dirname "$0")/.."
./vendor/bin/phpcs --standard=PHPCompatibility --runtime-set testVersion 8.1-8.5 --report=full ../../web/htdocs/kimi_ET > ../../../../tasks/01-analyse-incoming-data/09-phpcompatibility-report.txt 2>&1
