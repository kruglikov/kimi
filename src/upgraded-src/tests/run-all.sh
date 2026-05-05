#!/usr/bin/env bash

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/../../.." && pwd)"

cd "$REPO_ROOT"

docker compose -f src/original-src/docker-compose.yml run --rm \
  -v "$REPO_ROOT/src/original-src/tests:/var/www/tests" \
  -w /var/www/tests \
  web php vendor/bin/phpunit --testdox
