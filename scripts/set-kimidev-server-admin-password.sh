
# Sets the password for the 'system' admin user (benutzer.id=1, group Management) to
# 'admin123' in the kimidev_et database ON THE TEST SERVER, over SSH.
# Hash: sha256("kimiplus" + password), matching
# src-dev/original-src/web/htdocs/kimidev_ET/libs/entities/user.php:205.
# DB credentials are read from the app config on the server — never hard-coded here.
# Requires the FortiClient VPN to be connected first (see scripts/vpn-kimi.sh).

set -eux

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"

KEY="$REPO_ROOT/docs/12-ssh-keys/id_ed25519"
HOST="kimiportaldev.at@10.196.69.21"

ssh -i "$KEY" -o IdentitiesOnly=yes "$HOST" 'bash -s' <<'REMOTE'
cd /var/www/vhosts/kimiportaldev.at/htdocs/kimidev_ET
U=$(grep -oP 'CONF_MYSQL_USER"\s*,\s*"\K[^"]+' config/config.php)
P=$(grep -oP 'CONF_MYSQL_PASSWORD"\s*,\s*"\K[^"]+' config/config.php)
D=$(grep -oP 'CONF_MYSQL_DB"\s*,\s*"\K[^"]+' config/config.php)
HASH="bbbf241ee1ec01bdc83a5f5f646d26d2cfe88c81e3bd7d6310b6174e1603c927"
MYSQL_PWD="$P" mariadb -u"$U" "$D" -e "UPDATE benutzer SET passwort='$HASH' WHERE name='system';"
REMOTE

echo "Password for portal user 'system' set to 'admin123' on the test server (kimidev_et)."
