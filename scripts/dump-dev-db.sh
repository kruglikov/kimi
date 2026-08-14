
set -eu

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"

KEY="$REPO_ROOT/docs/12-ssh-keys/id_ed25519"
HOST="kimiportaldev.at@10.196.69.21"
SSH="ssh -i $KEY -o IdentitiesOnly=yes -o ServerAliveInterval=30"
REMOTE_DUMP="/tmp/kimidev_et_dump.sql.gz"
OUT="$REPO_ROOT/src-dev-db-dumps/kimidev_et_$(date +%Y%m%d_%H%M).sql.gz"

# Requires the FortiClient VPN to be connected first (see scripts/vpn-kimi.sh).
# Robust flow: dump to a file ON THE SERVER (disk-speed, survives no network),
# verify it there, then rsync it down (resumable), verify locally, remove the server copy.
# DB credentials are read from the app config on the server — never hard-coded here.
mkdir -p "$(dirname "$OUT")"

echo ">> 1/4 dumping on the server to $REMOTE_DUMP ..."
$SSH "$HOST" "bash -s" <<'REMOTE'
set -eu
cd /var/www/vhosts/kimiportaldev.at/htdocs/kimidev_ET
U=$(grep -oP 'CONF_MYSQL_USER"\s*,\s*"\K[^"]+' config/config.php)
P=$(grep -oP 'CONF_MYSQL_PASSWORD"\s*,\s*"\K[^"]+' config/config.php)
D=$(grep -oP 'CONF_MYSQL_DB"\s*,\s*"\K[^"]+' config/config.php)
MYSQL_PWD="$P" mariadb-dump -u"$U" --single-transaction --quick --routines --events \
  --default-character-set=utf8mb4 "$D" | gzip -1 > /tmp/kimidev_et_dump.sql.gz
REMOTE

echo ">> 2/4 verifying the dump on the server ..."
$SSH "$HOST" "gzip -t $REMOTE_DUMP && zcat $REMOTE_DUMP | tail -1 | grep -q 'Dump completed' && echo SERVER_DUMP_COMPLETE && ls -lh $REMOTE_DUMP"

echo ">> 3/4 downloading (resumable) to $OUT ..."
rsync -e "$SSH" --partial --inplace --progress "$HOST:$REMOTE_DUMP" "$OUT"

echo ">> 4/4 verifying locally and removing the server copy ..."
gzip -t "$OUT" && echo "local gzip OK"
$SSH "$HOST" "rm -f $REMOTE_DUMP"

echo "done: $OUT"
ls -lh "$OUT"
