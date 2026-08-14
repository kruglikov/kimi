I provided my pubic ssh keys to Franz @docs/12-ssh-keys/
and he reported that they were applied: @docs/13-franzs-answer/franz-answer-2026-07-16.md

Now I need to understand how to try SSh connection.

Previously I installed FortiClient VPN @docs/11-VPN-client/forticlient_vpn_7.4.3.5411_amd64.deb 
with credentials. And  it connect fine.

Now I need to connect to IP 10.196.69.21 with Username:  kimiportaldev.at and provided keys.
Please check

Also, whe vpn is connected, i can open https://83.164.170.30:10443/kimiportal (VPN-Verbindungsadresse) in browser and enter some hosting chamber with the same credentials:  @docs/11-VPN-client/01-vpn-credentials.md

---

## RESULT — verified working procedure (2026-07-21)

**Order matters: enable the VPN first, then SSH.** The host `10.196.69.21` is
unroutable without the FortiClient tunnel, so SSH hangs / returns
`Permission denied (publickey)` until the tunnel is up.

FortiClient is fully controllable from the CLI (`/bin/forticlient`). The VPN
profile is named `Kimi`, user `kimiportal`; the password is in
`docs/11-VPN-client/01-vpn-credentials.md`.

### Step 1 — enable the VPN

```bash
# Idempotent helper: prints status if already connected, else connects.
scripts/vpn-kimi.sh

# First time only — save the password so future connects need no prompt:
scripts/vpn-kimi.sh -p --save-password      # password from the credentials doc

# Manual equivalents:
forticlient vpn status                       # expect: Status: Connected  /  VPN name: Kimi
forticlient vpn connect Kimi -u kimiportal -p
forticlient vpn disconnect
```

Confirm the route goes through the tunnel: `ip route get 10.196.69.21`
(expect `dev fctvpn...`).

### Step 2 — SSH to the dev server

```bash
scripts/connect-to-kimidev-with-ssh.sh                 # interactive shell
scripts/connect-to-kimidev-with-ssh.sh 'php -v'        # run a remote command
```

Verified landing: `kimiportaldev.at@2281845-0402` — Debian 13, PHP 8.5.8,
MariaDB 12.3.2. This flow is also packaged as the `connect-dev-server` skill.

