# Session reset on `login.php` — analysis & implementation plan

## Context

Franz reported (see `tasks/07-implement-deployment-to-dev/11-ffeedback-from-Franz.md`) that in Firefox he
cannot reliably reach/keep the **Ticketsuche** (search) screen — the selected campaign "disappears" and he
is bounced back to Portal / Mandant selection. He labelled it a "session cookie" problem, but he is logged
in fine, so the cookie is stored; what is lost is the **selected Mandant + campaign**.

Goal: make the selected Mandant/campaign survive so an agent can work without being kicked back to selection.

## Root cause (confirmed in code)

`web/htdocs/kimidev_ET/login.php:10-15` runs `session_unset()` on **every** load when a user is present,
keeping only `user` + `lang` — deliberately discarding `$_SESSION["mandant"]` and `$_SESSION["kampId"]`.
`login.php` is also the "MANDANTENAUSWAHL" (switch-client) screen, so this reset is intentional *for
switching* — but it also fires on any **accidental** load of `login.php`:

- a stale second **"KiMi Login" tab** reloading (Firefox reloads background tabs on session-restore); all
  tabs share one cookie (`kimiET-A; path=/`), so it wipes the working tab too;
- the header **"Mandant wechseln"** link → `./login.php` (`web/htdocs/kimidev_ET/index.php:233`);
- **idle timeout** (`session.gc_maxlifetime = 1440` = 24 min) → session emptied → redirect to `login.php`;
- navigating to the site root / a bookmark / Back button into `login.php`.

Once Mandant is gone, `web/htdocs/kimidev_ET/index.php:83-86` redirects to `login.php` (no Mandant), and
`web/htdocs/kimidev_ET/modules/initial/ticketsuch.php:27-28` redirects to `kampauswahl` (no `kampId`) — i.e.
the "search bar disappeared".

Session keys and setters:
- `$_SESSION["user"]` — `ajax/check-login.php:16` (login) / `index.php:15` (autologin).
- `$_SESSION["mandant"]` — `index.php:82` (Mandant form submit) / `index.php:17` (autologin).
- `$_SESSION["kampId"]` — `modules/initial/ticketsuch.php:22` (campaign pick) / `index.php:18` (autologin).
- Logout: `modules/initial/logout.php:3` only sets `user = NULL`; the **full** clear then happens via
  `login.php`'s *no-user* branch (`login.php:21-23`). => the fix must leave that branch intact.

## The fix (Option B — preserve session unless explicitly switching)

Two coordinated edits; the no-user branch (logout / fresh visit) is left untouched.

### Edit 1 — `web/htdocs/kimidev_ET/login.php` (stop wiping on reload)

Before:
```php
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];

    session_unset();
    $_SESSION["user"] = $user;
    $_SESSION["lang"] = $user->get_sprache();
    $mandanten = Mandant::load_mandanten($user);
    ...
} else {
    session_unset();
}
```
After:
```php
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];

    // Preserve the selected Mandant/campaign across login.php (re)loads. The old
    // unconditional session_unset() discarded them on every load (stale tab reload,
    // Back button, idle redirect), which kicked the agent back to selection and made
    // the Ticketsuche menu vanish. Switching client is handled where the Mandant
    // actually changes (index.php clears kampId when the Mandant id differs).
    $_SESSION["lang"] = $user->get_sprache();
    $mandanten = Mandant::load_mandanten($user);
    ...
} else {
    session_unset();   // no user (fresh visit / after logout) -> full reset stays
}
```

### Edit 2 — `web/htdocs/kimidev_ET/index.php:81-86` (drop campaign only when Mandant changes)

Before:
```php
if (param("mandant", FALSE)) {
    $_SESSION["mandant"] = Mandant::get(param("mandant"));
} else if (!isset($_SESSION["mandant"]) || $_SESSION["mandant"] == NULL) {
    header("Location: ./login.php");
    exit;
}
```
After:
```php
if (param("mandant", FALSE)) {
    $newMandant = Mandant::get(param("mandant"));
    if (!isset($_SESSION["mandant"]) || $_SESSION["mandant"] == NULL
            || $_SESSION["mandant"]->get_id() != $newMandant->get_id()) {
        unset($_SESSION["kampId"]);
        unset($_SESSION["ts-search"]);   // remembered Ticketsuche filter carries the old kId
    }
    $_SESSION["mandant"] = $newMandant;
} else if (!isset($_SESSION["mandant"]) || $_SESSION["mandant"] == NULL) {
    header("Location: ./login.php");
    exit;
}
```

## Implementation checklist

- [x] Edit 1 applied to `src-dev/original-src/web/htdocs/kimidev_ET/login.php`
- [x] Edit 2 applied to `src-dev/original-src/web/htdocs/kimidev_ET/index.php`
- [x] Smoke safety net run (`src-dev-scripts/run-safety-net.sh`) — 214 tests / 0 failures / 72 skipped (RouterSmoke green)

## Browser test plan (local docker, http://localhost:8082/kimidev_ET/)

- [x] A. Fix: real login (`system`) → Mandant OKO → campaign kId=8 → load `login.php` → back to
      `index.php?site=ticketsuch` → **OKO list + full menu still shown** (campaign preserved) — PASS
- [x] B. Switch client: with OKO/kId=8 set, submit Mandant=18 (INKO2016) → `index.php?site=ticketsuch`
      **redirects to `kampauswahl`** (fresh pick, no OKO leak) — PASS
- [x] C. Same-Mandant navigation keeps the campaign (covered by A: reload path renders the OKO list) — PASS
- [x] D. Logout (`index.php?site=logout`) → `index.php` → **login form** (full reset) — PASS

### Verification findings
- Confirmed via the on-disk session file that Edit 2 clears `kampId`, but `ticketsuch.php:12-13` restores
  the whole previous search (`$_SESSION["ts-search"]`, which contained `kId=8`) into `$_GET`, so
  `ticketsuch.php:22` re-set the campaign. Fixed by also clearing `ts-search` on Mandant switch.
- Smoke safety net: 214 tests / 0 failures / 72 skipped (RouterSmoke green) — before and after.

### Post-review cleanup (applied + re-verified)
- `index.php`: extracted the switch condition into an explanatory predicate `$isMandantChanged` (behavior-identical).
- `login.php`: removed the pre-existing dead `if (count($mandanten) == 1 && 1==2)` block.
- Re-checked: `php -l` clean on both files; smoke 214/0; browser A (preserve across `login.php`) and
  B (switch → `kampauswahl`) both still PASS.

## Risks / things to keep in mind

- Mandant drives the **encryption context** (`index.php:37`); preserving it keeps the same Mandant, so context
  stays consistent. Optional hardening: validate the preserved Mandant is still in `Mandant::load_mandanten($user)`.
- Leave `login.php` **no-user** branch (`login.php:21-23`) intact so **logout** and **fresh login** still fully clear.
- Idle timeout (`gc_maxlifetime = 1440`) is **not** covered by this edit — if a session is GC'd there is nothing
  to preserve. Handle separately (raise `gc_maxlifetime` on the server, infra change) if it is contributing.
- Multi-tab: server session is shared across tabs by the one `kimiET-A; path=/` cookie — inherent.
- This is **app-repo** code → commit + redeploy to the dev server (separate approval); note the "Mandant
  wechseln" behavior change to the client.

## Deployment

- [x] Commit to app repo `main` — `823fda7` "Preserve selected Mandant/campaign across login.php reloads"
- [x] Pushed to origin (`e020fdd..823fda7`)
- [x] Dev server `/home/kimiportaldev.at/web/htdocs/kimidev_ET` fast-forwarded `e020fdd → 823fda7`
- [x] Verified live on the server (Chrome): A — campaign preserved across `login.php` load (OKO list renders);
      B — switch to Mandant 18 → Ticketsuche redirects to `kampauswahl`
- [ ] (Optional) reconfirm in Franz's Firefox once he's back on the test env
