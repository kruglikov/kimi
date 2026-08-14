
set -eux

VPN_PROFILE="Kimi"
VPN_USER="kimiportal"

if forticlient vpn status 2>/dev/null | grep -q "Status: Connected"; then
    exec forticlient vpn status
fi

# First run: add  -p --save-password  to enter the password once and remember it.
# Password lives in docs/11-VPN-client/01-vpn-credentials.md — never hard-code it here.
exec forticlient vpn connect "$VPN_PROFILE" -u "$VPN_USER" "$@"
1282560
