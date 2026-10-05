# Deploy and Rollback Runbook — `kimidev_ET` on the ANEXIA dev server

## What this document is for

This runbook describes the **order of operations** for putting a change on the ANEXIA dev/test server and for taking it off again. The connection mechanics — the FortiClient VPN, the SSH key, the deploy key on the server and the `GIT_SSH_COMMAND` the server needs — are not repeated here; they live in `.claude/skills/kimi-connect-dev-server/SKILL.md`, and what the git working copy on the server tracks is in `git-tracking-policy-kimidev-et.md`.

The deployment model is deliberately small: the live application directory `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` on `kimiportaldev.at@10.196.69.21` **is** the working copy of the app repository `git@github.com:viktarkruhlikau/kimi.git`, branch `main`. A deploy is therefore a `git pull` inside that directory, and a rollback is a git operation on the same directory. There is no build step, no artefact and no restart — PHP files are read from disk on every request.

## Deploy

1. **Make the change in the local working copy** `src-dev/original-src/web/htdocs/kimidev_ET/`, which is the same repository and the same branch as the server's working copy.
2. **Run the smoke-test safety net** from the repository root with `src-dev-scripts/run-safety-net.sh`. The suite must come back green against the baseline recorded in `smoke-tests-src-dev.md`. A red suite is a stop: the safety net exists precisely so that a PHP fatal or parse error is found on the local Docker stack and not by a call-centre agent on the dev server.
3. **Commit and push to `main`.** The branch `main` is what the server pulls, so an unpushed commit is not deployed, and a commit pushed to any other branch is not deployed either.
4. **Pull on the server.** Open an SSH session as described in `.claude/skills/kimi-connect-dev-server/SKILL.md`, change into `/home/kimiportaldev.at/web/htdocs/kimidev_ET/`, set the `GIT_SSH_COMMAND` the skill gives, and run `git pull`.
5. **Confirm that the server is on the commit you expect**, by comparing the output of `git rev-parse HEAD` in `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` against the commit hash you pushed. `git status` must also report a clean working tree: anything modified there was changed on the server outside git and will be overwritten by the next pull.
6. **Exercise the change in a browser** against `https://10.196.69.21/kimidev_ET/login.php`. The server presents a self-signed certificate without a `subjectAltName` extension, so a browser will refuse the host until a security exception is added for it; Chrome can be started with `--ignore-certificate-errors` for automated checks.
7. **Read the PHP error log** `/home/kimiportaldev.at/web/logs/phperrors.log` and the nginx error log `/home/kimiportaldev.at/web/logs/nginx-error.log` for the minutes covering the check. A new `PHP Fatal error` line is a failed deploy even when the page appeared to work, because a fatal error in a batch script aborts the rest of that script silently from the operator's point of view.

## Rollback

Which of the two paths to take depends on whether the bad commit has already been pulled by anyone else. For this project only the dev server pulls, so the second path is almost always available.

**Path A — revert through the repository (preferred).** In the local working copy `src-dev/original-src/web/htdocs/kimidev_ET/`, run `git revert <bad commit>`, push the revert commit to `main`, and then `git pull` on the server exactly as in the deploy steps above. This keeps the server's working copy on `main`, keeps the history honest about what was deployed and when, and needs no special handling the next time somebody pulls.

**Path B — reset the server working copy (emergency only).** In `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` run `git reset --hard <last good commit>`. This puts the files back immediately without waiting for a push, and is the right choice when the dev server is unusable and somebody is waiting. It leaves the server's working copy **behind** `main`, so the next `git pull` would bring the bad commit straight back; the repository must therefore be repaired with Path A before anybody pulls again.

**What a rollback does not undo.** Git restores files only. A batch script that has already written to the database `kimidev_et`, and a migration or a manual `UPDATE`, are untouched by either path and have to be reversed separately. The same applies to files the repository does not track: `log/`, which includes `ajax/log/`, and `*.sql.gz`.

## The two hazards that have actually occurred

**The environment `config.php` files are tracked.** `config/config.php` and `ajax/config/config.php` are in the repository, so a `git pull` overwrites the database settings on the server. That is deliberate and is explained in `git-tracking-policy-kimidev-et.md`: while those files were untracked, the hosting provider's copy of 2026-09-08 repointed the portal at a database that does not exist on the dev host and `git status` showed nothing at all. The consequence for deployment is that the dev values must be the ones committed on `main` — see `environment-value-differences.md` for the values that differ between the environments and must never be carried across.

**A copy made outside git is invisible to git.** When the hosting provider copies a document root onto the server, the files change but the repository does not know why. After any such copy, `git status` in `/home/kimiportaldev.at/web/htdocs/kimidev_ET/` must be read before anything else is done, and the copy must be committed as its own commit so that later changes can be told apart from it.

## Related documents

- `.claude/skills/kimi-connect-dev-server/SKILL.md` — VPN, SSH, the deploy key and the `GIT_SSH_COMMAND` the server needs
- `git-tracking-policy-kimidev-et.md` — what the deployed tree tracks and why the environment `config.php` files are tracked
- `environment-value-differences.md` — the values that differ between the dev and production instances
- `smoke-tests-src-dev.md` — the safety net that gates step 2, and its current baseline
