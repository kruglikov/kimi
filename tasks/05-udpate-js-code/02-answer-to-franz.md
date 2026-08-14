

Three changes are needed. We can make changes 1 and 3 ourselves — Franz only needs to provide the HTML for each new phone field (change 2).



## Change 1 — Remove `onClick` from the `<img>` tag

The `onClick="callTelco3()"` attribute does not work and must be removed. The click is handled automatically by the JavaScript — no `onClick` is needed.

**Before (Franz's example — broken):**
```html
<img style="vertical-align: middle;" src="../images/telephone.png"
     id="callTelco4" name="callTelco4"
     onClick="callTelco3()"
     width="16" height="16" alt="dummy_text6" />
```

**After (correct):**
```html
<img style="vertical-align: middle;" src="../images/telephone.png"
     id="callTelco4" name="callTelco4"
     width="16" height="16" alt="dummy_text6" />
```



## Change 2 — The `alt` attribute must match the `name` of the phone input field

The JavaScript reads the phone number by looking up `alt` as the input field name. So `alt` on the `<img>` and `name` on the `<input>` must be identical.

**Franz's example already has this correct** — `name="dummy_text6"` on the input and `alt="dummy_text6"` on the image both match. This is the pattern to follow for every new phone field:

**Example for Telefon 4 (correct):**
```html
<td bgcolor=#FFFF00><?php echo "Telefon 4" ?></td>
<td>
    <input style="width: 170px"
           placeholder="<?php echo "Telefon 4" ?>"
           name="dummy_text6"
           class="column" type="text"
           value="<?php echo $ticket->get_dummy_text6() ?>" />

    <img style="vertical-align: middle;" src="../images/telephone.png"
         id="callTelco4" name="callTelco4"
         width="16" height="16" alt="dummy_text6" />
<!--                                   ^^^^^^^^^^
                         must match the input name= above -->
</td>
```

**Example for Telefon 5 — same pattern, different field name:**
```html
<td bgcolor=#FFFF00><?php echo "Telefon 5" ?></td>
<td>
    <input style="width: 170px"
           placeholder="<?php echo "Telefon 5" ?>"
           name="dummy_text7"
           class="column" type="text"
           value="<?php echo $ticket->get_dummy_text7() ?>" />

    <img style="vertical-align: middle;" src="../images/telephone.png"
         id="callTelco5" name="callTelco5"
         width="16" height="16" alt="dummy_text7" />
<!--                                   ^^^^^^^^^^
                         matches the input name= above -->
</td>
```

Each icon gets a **unique `id`** (`callTelco4`, `callTelco5`, …) and the `alt` matches its own input `name`.



## Change 3 — Add a JavaScript handler for each new icon in `ticket.php`

**File:** `src/original-src/web/htdocs/kimi_ET/modules/gui/ticket.php`

Each new `id` needs its own click handler. The handlers go after the existing `callTelco3` block (after line 469) and before the `callTelcoAllg` block (line 472).

**Before** (lines 469–472 in ticket.php):
```javascript
            });
        });		


       $("#callTelcoAllg").click(function(e) {
```

**After** (insert one block per new phone icon — example for callTelco4 and callTelco5):
```javascript
            });
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
                    if (data.retcode != "0") {
                        alert(data.msg);
                        $('#telefon_status').val('Fehler');
                    } else {
                        $('#telefon_status').val('Fertig');
                    }
                },
                error: function(error) {
                    alert(error);
                    $('#telefon_status').val('Fehler');
                }
            });
        });

       $("#callTelco5").click(function(e) {
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
                    if (data.retcode != "0") {
                        alert(data.msg);
                        $('#telefon_status').val('Fehler');
                    } else {
                        $('#telefon_status').val('Fertig');
                    }
                },
                error: function(error) {
                    alert(error);
                    $('#telefon_status').val('Fehler');
                }
            });
        });

       // ... repeat for callTelco6 through callTelco10 in the same way ...

       $("#callTelcoAllg").click(function(e) {
```

Each block is identical — only the selector (`#callTelco4`, `#callTelco5`, …) changes. The phone field name is read from `alt` at runtime, so the same code works for all of them.

