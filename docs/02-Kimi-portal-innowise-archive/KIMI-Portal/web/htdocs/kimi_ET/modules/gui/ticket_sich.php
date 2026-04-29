<h2><?php echo TXT_LBL_TICKDETAIL; ?></h2>
<form method="post" <?php if (!App::$CURRENT->has_permission("ticket", "UPD") || !App::$CURRENT->has_permission("ticket", "INS")) echo "disabled"; ?>>
    <input type="hidden" name="id" value="<?php echo $ticket->get_id() ?>" />
    <input type="hidden" name="ticket_id" value="<?php echo $ticket->get_id() ?>" />
    <table>
        <tr>
            <td><?php echo TXT_LBL_TICKETNR ?></td>
            <td><input required class="column" name="ticketnr" placeholder="<?php echo TXT_LBL_TICKETNR ?>" type="text" value="<?php echo $ticket->get_ticketnr() ?>" /></td>
            <td><?php echo TXT_LBL_STATUS ?></td>
            <td>
                <select class="column" name="status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($status as $p) { ?>
                        <option <?php if ($ticket->get_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td></td>
            <td></td>            
        </tr>
        <tr>
            <td><?php echo TXT_LBL_TASK ?></td>
            <td colspan="3" style="padding-right: 14px"><input value="<?php echo $ticket->get_beschreibung_detail() ?>" placeholder="<?php echo TXT_LBL_TASK ?>" style="width: 100%" name="beschreibung_detail" type="text" /></td>
            <td></td>
        </tr>
        <tr><td><?php echo TXT_LBL_USER ?></td>
            <td>
                <select required class="column" name="benutzer_id">
                    <?php foreach ($benutzer as $p) { ?>
                        <option <?php if ($ticket->get_benutzer_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_name() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td><input value="<?php echo $ticket->get_kundennummer() ?>" placeholder="<?php echo TXT_LBL_KDNR ?>" class="column" name="kundennummer" type="text" /></td>
            <td></td>
            <td></td>            
        </tr>
        <tr>
            <td><?php echo TXT_LBL_LASTNAME ?></td>
            <td><input value="<?php echo $ticket->get_nachname() ?>" placeholder="<?php echo TXT_LBL_LASTNAME ?>" class="column" type="text" name="nachname" /></td>
            <td><?php echo TXT_LBL_FIRSTNAME ?></td>
            <td><input value="<?php echo $ticket->get_vorname() ?>" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" class="column" type="text" name="vorname" /></td>
            <td></td>
            <td></td>            
        </tr>
        <tr>
            <td><?php echo TXT_LBL_PLZ ?></td>
            <td>
                <select required name="land_id">
                    <option value="-1">-</option>
                    <?php
                    foreach ($laender as $land) {
                        ?>
                        <option <?php
                        if ($ticket->get_land_id() == $land->get_id())
                            echo "selected";
                        ?> value="<?php echo $land->get_id() ?>"><?php echo $land->get_kurzzeichen() ?></option>
                            <?php
                        }
                        ?>
                </select>
                <input value="<?php echo $ticket->get_plz() ?>" placeholder="<?php echo TXT_LBL_PLZ ?>" style="width: 150px" type="text" name="plz" /></td>
            <td><?php echo TXT_LBL_ORT ?></td>
            <td><input class="column" value="<?php echo $ticket->get_ort() ?>" placeholder="<?php echo TXT_LBL_ORT ?>" type="text" name="ort" /></td>
            <td></td>
            <td></td>            
        </tr>
        <tr>
            <td><?php echo TXT_LBL_STR ?></td>
            <td><input class="column" value="<?php echo $ticket->get_strasse() ?>" placeholder="<?php echo TXT_LBL_STR ?>" type="text" name="strasse" /></td>
            <td><?php echo TXT_LBL_HNR ?></td>
            <td style="width: 200px">
                <table style="width: 200px !important;">
                    <tr>
                        <td>
                            <input style="width: 90px" placeholder="<?php echo TXT_LBL_HNR ?>" name="hausnummer" type="text" value="<?php echo $ticket->get_hausnummer() ?>" /> 
                        </td>
                        <td>
                            <input style="width: 90px" placeholder="<?php echo TXT_LBL_HNR_EXTENDED ?>" name="hausnummer_erw" type="text" value="<?php echo $ticket->get_hausnummer_erw() ?>" />
                        </td>
                    </tr>
                </table>
            </td>
            <td></td>
            <td></td>            
        </tr>
        <tr>
            <td><?php echo TXT_LBL_TEL ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_TEL ?>" name="telefon" class="column" type="text" value="<?php echo $ticket->get_telefon() ?>" /> <br />
            </td>
            <td><?php echo TXT_LBL_EMAIL ?></td>
            <td>
                <input placeholder="<?php echo TXT_LBL_EMAIL ?>" name="email" class="column" type="email" value="<?php echo $ticket->get_email() ?>" /> <br />
            </td>
            <td></td>
            <td></td>            
        </tr>
        <tr>
            <td><?php echo TXT_LBL_CALL_STATE ?></td>
            <td>
                <select class="column" name="anruf_status_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($anruf_status as $p) { ?>
                        <option <?php if ($ticket->get_anruf_status_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><?php echo TXT_LBL_WIEDERVORLAGE ?></td>            
            <td><input class="column" value="<?php echo $ticket->get_wiedervorlage() ?>" placeholder="<?php echo TXT_LBL_WIEDERVORLAGE ?>" type="date" name="wiedervorlage" /></td>
            <td><?php echo TXT_LBL_GRUND ?></td>                        
            <td><select class="column" name="grund_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($grund as $p) { ?>
                        <option <?php if ($ticket->get_grund_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>                                    
        </tr>
        <tr>
            <td><?php echo TXT_LBL_RESULT ?></td>
            <td colspan="3" style="padding-right: 14px"><input style="width: 100%" placeholder="<?php echo TXT_LBL_RESULT ?>" value="<?php echo $ticket->get_ergebnis() ?>" type="text" name="ergebnis" /></td>
            <td><?php echo TXT_LBL_PRODUKT ?></td>
            <td><select class="column" name="produkt_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($produkt as $p) { ?>
                        <option <?php if ($ticket->get_produkt_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>            
        </tr>
        <tr>
            <td><?php echo TXT_LBL_PRIORITY ?></td>
            <td>
                <select class="column" name="prioritaet_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($prioritaet as $p) { ?>
                        <option <?php if ($ticket->get_prioritaet_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>
            <td></td>            
            <td></td>                        
            <td><?php echo TXT_LBL_FIRMA ?></td>                                    
            <td>
                <select class="column" name="firma_id">
                    <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                    <?php foreach ($firma as $p) { ?>
                        <option <?php if ($ticket->get_firma_id() == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                    <?php } ?>
                </select>
            </td>                                                
        </tr>
        <tr>
            <td><?php echo TXT_LBL_BEGIN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_beginn() ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
            <td><?php echo TXT_LBL_END ?></td>
            <td><input required value="<?php echo $ticket->get_ende() ?>" placeholder="<?php echo TXT_LBL_END ?>" class="column" type="date" name="ende" /></td>
            <td></td>            
            <td></td>                        
        </tr>
        <tr>
            <td><?php echo TXT_LBL_STUNDEN ?></td>
            <td><input class="column" value="<?php echo $ticket->get_aufwand() ?>" placeholder="<?php echo TXT_LBL_STUNDEN ?>" type="text" name="aufwand" /></td>
            <td></td>            
            <td></td>                        
        </tr>
    </table>

    <input type="hidden" name="site" value="ticket" />
    <input type="hidden" name="mandant_id" value="<?php echo $ticket->get_mandant_id(); ?>" />

    <input type="hidden" name="mode" value="<?php
    if ($mode == "SEL")
        echo "UPD"; else if ($mode == "NEW" || $mode == "INS")
        echo "INS";
    else
        echo "UPD";
    ?>" />

    <?php
    if (App::$CURRENT->has_permission("ticket", "UPD") ||
            App::$CURRENT->has_permission("ticket", "INS")) {
        ?>
        <input type="submit" value="<?php echo TXT_LBL_SAVE ?>" />
    <?php } ?>
    <?php if ($ticket_id != -1 && App::$CURRENT->has_permission("ticket", "DEL")) { ?>
        <a class="button confirm" href="./index.php?site=ticket&mode=DEL&ticket_id=<?php echo $ticket_id; ?>"><?php echo TXT_LBL_DEL ?></a>
    <?php }
    if (App::$CURRENT->has_permission("ticket", "INS")) {
        ?>
        <a class="button" href="./index.php?site=ticket"><?php echo TXT_LBL_NEW ?></a>
<?php } ?>
</form>