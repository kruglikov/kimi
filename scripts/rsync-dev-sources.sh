
set -eu

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"

KEY="$REPO_ROOT/docs/12-ssh-keys/id_ed25519"
REMOTE="kimiportaldev.at@10.196.69.21:/var/www/vhosts/kimiportaldev.at/htdocs/"
DEST="$REPO_ROOT/src-dev/original-src/web/htdocs/"

# Requires the FortiClient VPN to be connected first (see scripts/vpn-kimi.sh).
mkdir -p "$DEST"
exec rsync -az --delete -e "ssh -i $KEY -o IdentitiesOnly=yes" "$REMOTE" "$DEST" "$@"
