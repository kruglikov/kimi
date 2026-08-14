# `.claude/` — project Claude Code assets

Project-scoped skills and subagents for the KIMI Portal migration. All **skills** use the
`kimi-` prefix to keep a clear project namespace. Restart Claude Code after adding or
renaming assets so they load.

## Skills (`.claude/skills/<name>/SKILL.md`)

| Skill                       | What it does | Use when |
|-----------------------------|--------------|----------|
| **kimi-connect-dev-server** | Connect to the ANEXIA dev/test server (`kimiportaldev.at@10.196.69.21`) over FortiClient VPN + SSH, or run a remote command. Enforces **VPN first, then SSH**. Wraps `scripts/vpn-kimi.sh` and `scripts/connect-to-kimidev-with-ssh.sh`. | "connect to dev", "ssh to kimidev", "bring up the VPN", "is the dev server reachable", run something on 10.196.69.21 |
| **kimi-run-smoke-tests**    | Run the PHPUnit runtime smoke-test safety net (entrypoints load without PHP fatal/parse errors). Upgraded-src baseline: 216 tests / 0 failures. | "run the tests", "run smoke tests", verify an upgrade change, before merging |

## Agents (`.claude/agents/<name>.md`)

| Agent                  | Role | Access |
|------------------------|------|--------|
| **kimi-code-reviewer** | Review a change against the modification policy, PHP 8.5 compatibility, the security/GDPR audit findings, and the smoke-test baseline; returns findings + PASS/CHANGES-REQUESTED. | read-only |
| **kimi-test-engineer** | Run the smoke suite, reproduce failures, extend coverage, keep upgraded-src green. | read + write (tests) |

## Grounding

Assets reference real repository sources rather than duplicating them:
`memory-bank/` (architecture, upgrade policy, smoke-test docs), `docs/04-results/Audit-report.md`
(security/GDPR findings), `scripts/`, and `src/upgraded-src/`.

## Conventions

- New skills: `kimi-<kebab-case>`; the `name:` in `SKILL.md` frontmatter **must** match its
  directory name.
- Give reviewers/read-only agents restricted tools; give write access only to intentional
  builders.
- Never put secrets (VPN password, SSH private key) in a skill, agent, or script — reference
  the source file by path (e.g. `docs/11-VPN-client/01-vpn-credentials.md`).
