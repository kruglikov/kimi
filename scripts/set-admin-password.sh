#!/usr/bin/env bash
# Sets the password for the 'system' admin user to 'admin123' in kimidev_et.
# Hash: sha256("kimiplus" + password), matching user.php:205

set -eux

HASH="bbbf241ee1ec01bdc83a5f5f646d26d2cfe88c81e3bd7d6310b6174e1603c927"

docker exec kimi-plus-original-db-1 \
  mysql -usql_kimidev_et -pNS889Hs4bhL1aub7HyEH6AjdYpYAlx kimidev_et \
  -e "UPDATE benutzer SET passwort = '${HASH}' WHERE name = 'system';"

echo "Password for user 'system' set to 'admin123'"
