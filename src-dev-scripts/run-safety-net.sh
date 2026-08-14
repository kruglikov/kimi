#!/usr/bin/env bash
# Run the KIMI dev-tree PHP 8.5 safety-net (smoke) suite and show the results.
# Assumes the local subset DB is already loaded (see the import done in task 07).
# Pass extra phpunit args through, e.g.:  src-dev-scripts/run-safety-net.sh --filter Batch
cd "$(dirname "$0")/.."

docker compose -f src-dev/docker-compose.yml up -d

tty_flag=""; [ -t 0 ] || tty_flag="-T"
docker compose -f src-dev/docker-compose.yml exec $tty_flag -w /opt/tests2 web \
  php vendor/bin/phpunit --testdox "$@"
