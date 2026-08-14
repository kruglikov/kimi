---
name: kimi-connect-dev-server
description: Connect to the KIMI dev/test server (ANEXIA, kimiportaldev.at@10.196.69.21) over the FortiClient VPN and SSH, or run a command on it. Use when asked to "connect to dev", "ssh to kimidev", "log into the test server", "bring up the VPN", check if the dev server is reachable, or run/verify anything on 10.196.69.21.
---

# Connect to the KIMI dev server

The dev/test box is hosted by ANEXIA and reachable **only through the FortiClient VPN**.

| Fact | Value |
|------|-------|
| Host / user | `kimiportaldev.at@10.196.69.21` |
| VPN profile | `Kimi` (FortiClient CLI, user `kimiportal`) |
| SSH key | `docs/12-ssh-keys/id_ed25519` |
| Server | Debian 13, PHP 8.5.8, MariaDB 12.3.2 (hostname `2281845-0402`) |

Credentials live in `docs/11-VPN-client/01-vpn-credentials.md`. **Never copy the VPN
password or the private key into a script, skill, or chat message.**

## Workflow

> **VPN first, always.** The host is unroutable without the tunnel — SSH will hang
> or fail (`Permission denied` / timeout) until FortiClient is connected. Never
> attempt the SSH step before `forticlient vpn status` reports `Status: Connected`.

1. **Bring up the VPN (idempotent).** Run `scripts/vpn-kimi.sh`. It prints status if
   already connected, otherwise runs `forticlient vpn connect Kimi -u kimiportal`.
   - First time only, save the password so future connects are passwordless:
     `scripts/vpn-kimi.sh -p --save-password` (password from the credentials doc above).
   - Manual equivalents: `forticlient vpn status`, `forticlient vpn disconnect`.
2. **Confirm the route** goes through the tunnel: `ip route get 10.196.69.21`
   (expect `dev fctvpn...`). Optionally check port 22:
   `timeout 6 bash -c 'cat < /dev/null > /dev/tcp/10.196.69.21/22' && echo open`.
3. **Connect.** Run `scripts/connect-to-kimidev-with-ssh.sh` for an interactive shell,
   or pass a remote command through it, e.g.
   `scripts/connect-to-kimidev-with-ssh.sh 'php -v'`.

## Verification

Confirm you actually landed on the box:

```
scripts/connect-to-kimidev-with-ssh.sh -o BatchMode=yes 'echo OK $(whoami)@$(hostname)'
```

Expect `OK kimiportaldev.at@2281845-0402`. If SSH fails with `Permission denied
(publickey)`, the VPN is up but the key/user is wrong; if it hangs or the route is not
`dev fctvpn...`, the VPN is down — go back to step 1.

## Git on the dev server (deploy)

The live app `kimidev_ET` is a git clone of the private repo **`git@github.com:viktarkruhlikau/kimi.git`** — deploys are `git pull`, rollback is git. The repo root **is** the app dir, so it maps 1:1 onto the docroot.

| Fact | Value |
|------|-------|
| Repo (private) | `git@github.com:viktarkruhlikau/kimi.git` (branch `main`) |
| Server working copy | `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` (repo root = app dir) |
| Local working copy | `src-dev/original-src/web/htdocs/kimidev_ET/` (push here via `gh` auth) |
| Deploy key (server→GitHub) | `/home/kimiportaldev.at/web/.deploy/github_kimi_deploy` (600) + `known_hosts` beside it |
| Gitignored (never tracked, preserved on pull) | `**/config.php` (both `config/config.php` + `ajax/config/config.php`), `kimibatch/files/`, `log/`, `*.sql.gz` |

**Why the key lives in `web/.deploy/`:** the SSH user's `~/.ssh` is root-owned and not writable, so the deploy key + `known_hosts` sit in the writable, **above-docroot** `web/.deploy/` (not web-served). Git must be told to use them explicitly:

```
export GIT_SSH_COMMAND="ssh -i ~/web/.deploy/github_kimi_deploy -o IdentitiesOnly=yes -o UserKnownHostsFile=~/web/.deploy/known_hosts"
```

Run git from inside `kimidev_ET/` with that env set — e.g. verify auth: `git ls-remote git@github.com:viktarkruhlikau/kimi.git` (expect the `main` ref); deploy: `git pull`. This can also be pinned per-repo with `git config core.sshCommand '…'` so the env var isn't needed each time.

**Do not** copy the deploy private key off the server or into the project. Environment-specific `config.php` files stay untracked so a `git pull` never overwrites the server's DB config.
