
# I have:
- FortiClient set up that connects me to the dev server.
  -  Credentails for FortiClient are:
        login: kimiportal
        pass: F?F9ExVRwE%8zQ
  - Once vpn is connected, i can open https://83.164.170.30:10443/kimiportal (VPN-Verbindungsadresse) in browser and enter some hosting chamber with the same credentials above
  - Once vpn is connected, I can go to https://10.196.69.21/kimidev_ET/login.php and see a login form of the dev environment.
  - And here is the information about how to connect to the dev server by SSH: @memory-bank/ssh-connection-to-dev-server.md

 Here's what they wrote about the database version:
 - "The database kimi_et was imported from the production system into the database kimidev_et on the test system".

# What I need to do:
- update and test the content of the dev server according to the recent estimate: @docs/15-the-most-recent-estimate-excel-file/Kimi-plus Estimate Deplymnet + Fixes.xlsx

## Task tracker
- [x] Step 1 — understand what version is on the dev server vs `@src/original-src/`

## Step 1 — dev-server version vs `@src/original-src/`
- [x] Step 1.1 — rsync the data from dev server to `@src-dev/original-src`
- [x] Step 1.2 — compare `@src-dev/original-src` to `@src/original-src`; save report into `@tasks/07-implement-deployment-to-dev/`
**Exit:** report written describing whether the deployed code diverges from `src/original-src` and how. — **met.**

**Result:** DIVERGED. The dev server runs an **older (2022-era) snapshot** of the same app
(`kimidev_ET`), not our `src/original-src` (newer, 2026). 141 files differ (99 core code);
REPO newer in 140/141. Report: `step1.2-comparison-report.md`; raw lists: `step1.2-diff-lists.txt`.

### Notes
- Step 1.1 done via `scripts/rsync-dev-sources.sh` (VPN must be connected first). Synced the whole dev docroot `/var/www/vhosts/kimiportaldev.at/htdocs/` (2,080 files, 43 MB) into `src-dev/original-src/web/htdocs/`. Live app dir on the server is `kimidev_ET/` (repo uses `kimi_ET/`).
