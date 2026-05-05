#!/usr/bin/env bash
cd "$(dirname "$0")/.."
./vendor/bin/rector process --dry-run > ../../../../tasks/01-analyse-incoming-data/10-rector-dry-run.txt 2>&1
