
set -eu

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"

KEY="$REPO_ROOT/docs/12-ssh-keys/id_ed25519"
HOST="kimiportaldev.at@10.196.69.21"

# Opens an interactive MariaDB client on the test server against the kimidev_et DB.
# Credentials are read from the app config on the server — never hard-coded here.
# Requires the FortiClient VPN to be connected first (see scripts/vpn-kimi.sh).
exec ssh -t -i "$KEY" -o IdentitiesOnly=yes "$HOST" \
  'cd /var/www/vhosts/kimiportaldev.at/htdocs/kimidev_ET && U=$(grep -oP "CONF_MYSQL_USER\"\s*,\s*\"\K[^\"]+" config/config.php) && P=$(grep -oP "CONF_MYSQL_PASSWORD\"\s*,\s*\"\K[^\"]+" config/config.php) && D=$(grep -oP "CONF_MYSQL_DB\"\s*,\s*\"\K[^\"]+" config/config.php) && MYSQL_PWD="$P" mariadb -u"$U" "$D"'
