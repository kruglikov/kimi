#!/usr/bin/env bash
cd "$(dirname "$0")"
bash ./run-phpcompatibility.sh
bash ./run-rector-dry-run.sh
