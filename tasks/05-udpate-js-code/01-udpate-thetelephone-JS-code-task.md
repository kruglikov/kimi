See the description of the problem\task in this email: @docs/09-franz-email-2026-06-15/
The translated email text is stored here: @docs/09-franz-email-2026-06-15/email-en.md

Here is what Franz replied: @docs/10-franz-email-2026-06-16/franz-email-2026-06-16.md#L30-65

I want you to investigate where exactly this Onclick function is placed in 
Seems like here: src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php

Please append your answer into the current file  to the end: @tasks/05-udpate-js-code/01-udpate-thetelephone-JS-code-task.md 

---

## Investigation Result

### How the telephone click system works

The telephone-dialling feature is split across two layers:

#### Layer 1 — JavaScript handlers (in the shared `ticket.php`)

**File:** `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php`

All jQuery click handlers live inside the `$(document).ready(function() { … })` block that begins at **line 204**:

| Handler              | Line  | Reads phone number from field |
|----------------------|-------|-------------------------------|
| `#callTelco1`        | 345   | hardcoded: `telefon`          |
| `#callTelco2`        | 388   | hardcoded: `telefon2`         |
| `#callTelco3`        | 429   | dynamic: `e.target.alt`       |
| `#callTelcoAllg`     | 472   | `#telefon_allg` (free-dial)   |

Each handler does the same thing: reads VoIP credentials from hidden fields (`kampagne_iptel_destclid`, `kampagne_iptel_auto_vorwahl`, `benutzer_iptel_durchwahl`, `nebenstelle`, `client_ip`), reads the target phone number, then sends a POST request to `index.php?site=callInntelco&ajax=true`.

**Critical detail about `callTelco3`:** Unlike `callTelco1` / `callTelco2`, the `callTelco3` handler reads the phone field name *dynamically* from the `alt` attribute of the clicked image (`e.target.alt`). This makes it the reusable pattern for additional phone fields.

```javascript
// src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php : line 438
telNr = document.getElementsByName(e.target.alt)[0].value;
```

#### Layer 2 — HTML `<img>` icons (in per-kampagne template files)

The `<img>` telephone icons are placed inside campaign-specific ticket templates. The parent `ticket.php` includes the correct template at **line 641**:

```php
// src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php : line 641
<?php include_once "./modules/gui/templates/tickets/$kampId/ticket.php" ?>
```

The templates that already have phone icons:

| Template file                                                                         | Element rendered |
|---------------------------------------------------------------------------------------|---|
| `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/8/ticket.php:166`  | `callTelco1` (telefon) |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/8/ticket.php:171`  | `callTelco2` (telefon2) |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/8/ticket.php:224`  | `callTelco3` (dummy_text7 / "Telefon 3"), with `alt="dummy_text7"` |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/35/ticket.php:226` | `callTelco1` (telefon) |
| `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/35/ticket.php:231` | `callTelco2` (telefon2) |
| (other templates 1, 2, 3, 10, 16, 19, 34)                                             | callTelco1 and callTelco2 only |

Template **35** is the OKO template Franz refers to. It currently has `callTelco1` and `callTelco2` but **does not yet have a `callTelco3`** phone icon row.

---

### Root cause of Franz's problem

Franz's example HTML uses `id="callTelco4"` but `onClick="callTelco3()"`:

```html
<img ... id="callTelco4" name="callTelco4" onClick="callTelco3()" ... alt="dummy_text6" />
```

This **does not work** because:

1. `callTelco3()` is **not a global JavaScript function**. It is a jQuery handler bound to the element with `id="callTelco3"` — i.e. `$("#callTelco3").click(function(e) { … })`. jQuery registers this as a DOM event listener, not as a callable global function named `callTelco3`.
2. Calling `onClick="callTelco3()"` tries to invoke a global function named `callTelco3` — which does not exist — so the call silently fails.

---

### What needs to be done to add Telefon 4–10

#### Step 1: Add new jQuery handlers in `ticket.php`

In `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php`, after the `#callTelco3` block (after line 469), add one handler per new phone icon. Each handler is identical to the `callTelco3` handler and uses `e.target.alt` to pick the field name — only the selector ID differs:

**Before** (end of `callTelco3` block, line 469):
```javascript
        });		
			
	
       $("#callTelcoAllg").click(function(e) {
```

**After** (inserting handlers for callTelco4 through callTelco10):
```javascript
        });		

       $("#callTelco4").click(function(e) {
            $this = $(this);
            e.preventDefault();
            $("#btnStart").click();
            $('#telefon_status').val('senden...');
            kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;
            kampagne_iptel_auto_vorwahl = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;
            benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
            telNr = document.getElementsByName(e.target.alt)[0].value;
            clientIp = document.getElementsByName("client_ip")[0].value;
            nebenstelle = document.getElementsByName("nebenstelle")[0].value;
            $.ajax({
                url: "./index.php?site=callInntelco&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'callTelNo',
                    'user': '<?php echo App::$CURRENT->USER->get_name() ?>',
                    'iptel_durchwahl': benutzer_iptel_durchwahl,
                    'kampagne_iptel_destclid': kampagne_iptel_destclid,
                    'kampagne_iptel_auto_vorwahl': kampagne_iptel_auto_vorwahl,
                    'dest': telNr,
                    'client_ip': clientIp,
                    'nebenstelle': nebenstelle
                },
                success: function(data) {
                    var data = $.parseJSON(data);
                    if (data.retcode != "0") { alert(data.msg); $('#telefon_status').val('Fehler'); }
                    else { $('#telefon_status').val('Fertig'); }
                },
                error: function(error) { alert(error); $('#telefon_status').val('Fehler'); }
            });
        });
        // Repeat the same block for #callTelco5, #callTelco6, … #callTelco10

       $("#callTelcoAllg").click(function(e) {
```

Each of the 7 handlers (`callTelco4` … `callTelco10`) is identical except for the selector ID. The phone field name is read from `e.target.alt` at runtime, so the same JS pattern works for all of them.

#### Step 2: Add HTML rows in the OKO template

In `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/35/ticket.php`, add new `<tr>` rows for Telefon 4–10. The DB columns `telnr5`–`telnr10` will need to be added via:

```sql
ALTER TABLE oko
ADD COLUMN telnr5 VARCHAR(45),
ADD COLUMN telnr6 VARCHAR(45),
ADD COLUMN telnr7 VARCHAR(45),
ADD COLUMN telnr8 VARCHAR(45),
ADD COLUMN telnr9 VARCHAR(45),
ADD COLUMN telnr10 VARCHAR(45);
```

Each row in the template follows this pattern (example for Telefon 4):

```html
<td bgcolor=#FFFF00><?php echo "Telefon 4" ?></td>
<td>
    <input style="width: 170px" placeholder="<?php echo "Telefon 4" ?>"
           name="telnr5" class="column" type="text"
           value="<?php echo $ticket->get_telnr5() ?>" />
    <img style="vertical-align: middle;" src="../images/telephone.png"
         id="callTelco4" name="callTelco4"
         width="16" height="16" alt="telnr5" />
</td>
```

Note: the `alt` attribute **must match the `name` attribute of the corresponding `<input>`** — the JS reads the field via `document.getElementsByName(e.target.alt)[0].value`.

#### Step 3: Add `get_telnr5()` … `get_telnr10()` getters to the OKO entity

The getter methods (`get_telnr5()`, etc.) must be added to the entity class that backs the OKO ticket template. The entity file to update is in `src/original-src/web/htdocs/kimi_ET/libs/entities/` (the specific entity class for OKO needs to be identified — likely `customer.php` or a kampagne-specific entity).

---

### Summary of key file locations

| What                            | File | Lines |
|---------------------------------|---|---|
| All JS click handlers           | `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php` | 345–513 |
| `$(document).ready` block start | `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php` | 204 |
| Template include (parent)       | `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php` | 641 |
| OKO template (campaign 35)      | `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/35/ticket.php` | — |
| Existing callTelco3 example     | `src/original-src/web/htdocs/kimi_ET/modules/gui/templates/tickets/8/ticket.php` | 224 |
