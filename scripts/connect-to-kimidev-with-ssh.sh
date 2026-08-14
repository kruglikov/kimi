
set -eux

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"

KEY="$REPO_ROOT/docs/12-ssh-keys/id_ed25519"
HOST="kimiportaldev.at@10.196.69.21"

exec ssh -i "$KEY" -o IdentitiesOnly=yes "$HOST" "$@"
