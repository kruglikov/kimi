
<div>
    <form action="index.php" method="GET">
        <input type="hidden" name="site" value="ticketsuch" />
        <input type="hidden" name="search" value="true" />
        <table>
            <tr>
                <td><?php echo TXT_LBL_TICKETNR ?></td>
                <td><input class="column" name="ticketnr" placeholder="<?php echo TXT_LBL_TICKETNR ?>" type="text" value="<?php echo $tnr ?>" /></td>
                <td><?php echo TXT_LBL_STATUS ?></td>
                <td>
                    <select class="column" name="status_id">
                        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                        <?php foreach ($status as $p) { ?>
                            <option <?php if ($status_id == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td>
				<td><?php echo TXT_LBL_CALL_STATE ?></td>
                <td>
                    <select class="column" name="anruf_status_id">
                        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                        <?php foreach ($anruf_status as $p) { ?>
                            <option <?php if ($anruf_status_id == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </select>
                </td>
				<td></td>
				<td></td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_TASK ?></td>
                <td><input value="<?php echo $aufgabe ?>" placeholder="<?php echo TXT_LBL_TASK ?>" class="column" name="aufgabe" type="text" /></td>
                <td><?php echo TXT_LBL_USER ?></td>
                <td>
                    <select class="column" name="benutzer_id">
                        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                        <?php foreach ($benutzer as $p) { ?>
                            <option <?php if ($benutzer_id == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_name() ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><?php echo TXT_LBL_KDNR ?></td>
                <td><input value="<?php echo $kdnr ?>" placeholder="<?php echo TXT_LBL_KDNR ?>" class="column" name="kundennummer" type="text" /></td>
				<td></td>
				<td></td>
			</tr>
            <tr>
                <td><?php echo TXT_LBL_LASTNAME ?></td>
                <td><input value="<?php echo $nachname ?>" placeholder="<?php echo TXT_LBL_LASTNAME ?>" class="column" type="text" name="nachname" /></td>
                <td><?php echo TXT_LBL_FIRSTNAME ?></td>
                <td><input value="<?php echo $vorname ?>" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" class="column" type="text" name="vorname" /></td>
                <td><?php echo TXT_LBL_PLZ ?></td>
                <td><input value="<?php echo $plz ?>" placeholder="<?php echo TXT_LBL_PLZ ?>" class="column" type="text" name="plz" /></td>
				<td></td>
				<td></td>
			</tr>
            <tr>
                <td><?php echo TXT_LBL_ORT ?></td>
                <td><input class="column" value="<?php echo $ort ?>" placeholder="<?php echo TXT_LBL_ORT ?>" type="text" name="ort" /></td>
                <td><?php echo TXT_LBL_STR ?></td>
                <td><input class="column" value="<?php echo $strasse ?>" placeholder="<?php echo TXT_LBL_STR ?>" type="text" name="strasse" /></td>
                <td><?php echo TXT_LBL_HNR ?></td>
                <td><input class="column" value="<?php echo $hausnummer ?>" placeholder="<?php echo TXT_LBL_HNR ?>" type="text" name="hausnummer" /></td>
				<td><?php echo 'Aktnr' ?></td>
				<td><input class="column" name="dummy_text9" placeholder="<?php echo 'Aktnr' ?>" type="text" value="<?php echo $dummy_text9 ?>" /></td>
				</tr>
			</tr>
            <tr>
                <td><?php echo TXT_LBL_PRIORITY ?></td>
                <td>
                    <select class="column" name="prioritaet_id">
                        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                        <?php foreach ($prioritaet as $p) { ?>
                            <option <?php if ($prioritaet_id == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>Wiedervorlage</td>
                <td><input class="column" value="<?php echo $wiedervorlage ?>" placeholder="Wiedervorlage" type="date" name="wiedervorlage" /></td>
                <td>Ergebnis</td>
                <td><input class="column" value="<?php echo $ergebnis ?>" placeholder="Ergebnis" type="text" name="ergebnis" /></td>
				<td><?php echo TXT_LBL_TEL ?></td>
				<td><input class="column" name="telefon" placeholder="<?php echo TXT_LBL_TEL ?>" type="text" value="<?php echo $telefon ?>" /></td>
			</tr>
            <tr>
                <td><?php echo TXT_LBL_BEGIN ?></td>
                <td><input class="column" value="<?php echo $beginn ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
                <td><?php echo TXT_LBL_END ?></td>
                <td><input value="<?php echo $ende ?>" placeholder="<?php echo TXT_LBL_END ?>" class="column" type="date" name="ende" /></td>
               <td><?php echo 'Anrufzeitpunkt' ?></td>
                <td>
                    <select class="column" name="firma_id">
                        <option value="-1"><?php echo TXT_LBL_NOONE ?></option>
                        <?php foreach ($firma as $p) { ?>
                            <option <?php if ($firma_id == $p->get_id()) echo "selected"; ?> value="<?php echo $p->get_id() ?>"><?php echo $p->get_text() ?></option>
                        <?php } ?>
                    </select>
                </td>
				<td><?php echo TXT_LBL_TELEFON2 ?></td>
				<td><input class="column" name="telefon2" placeholder="<?php echo TXT_LBL_TELEFON2 ?>" type="text" value="<?php echo $telefon2 ?>" /></td>
			</tr>
        </table>
        <input type="submit" value="<?php echo TXT_LBL_SEARCH ?>" />
        <?php if (App::$CURRENT->has_permission("ticket", "INS")) { ?>
            <a class="button" href="./index.php?site=ticket"><?php echo TXT_LBL_NEW ?></a>
        <?php } ?>
        <a class="button" href="./index.php?site=ticketsuch&reset=true"><?php echo TXT_LBL_RESET ?></a>

    </form>
</div>
<?php
// 20161412/ab
$selected_tickets = implode(',', $tickets_selected);
$selected = 0;
?>
<table class="designed">
    <tr>
        <th><?php echo TXT_LBL_TICKETNR ?></th>
        <th><?php echo TXT_LBL_TASK ?></th>
        <th><?php echo TXT_LBL_STATUS ?></th>
        <th><?php echo TXT_LBL_PRIORITY ?></th>
        <th><?php echo TXT_LBL_BEGIN ?></th>
        <th><?php echo TXT_LBL_END ?></th>
        <th><?php echo TXT_LBL_USER ?></th>
        <th><?php echo TXT_LBL_KUNDE ?></th>
        <th><?php echo TXT_LBL_LASTNAME ?></th>
        <th><?php echo TXT_LBL_FIRSTNAME ?></th>
        <th><?php echo TXT_LBL_PLZ ?></th>
        <th><?php echo TXT_LBL_ORT ?></th>
        <th><?php echo TXT_LBL_STR ?></th>
        <th><?php echo TXT_LBL_HNR ?></th>
    </tr>
    <?php foreach ($tickets as $t) { ?>
        <tr>
            <td><a href="./index.php?site=ticket&ticket_id=<?php echo $t->get_id() ?>&selected_tickets=<?php echo $selected_tickets ?>&selected_ticket_index=<?php echo $selected ?>"><?php echo $t->get_ticketnr() ?></a></td>
            <td><?php echo $t->get_beschreibung_detail() ?></td>
            <td><?php echo $t->get_status() ?></td>
            <td><?php echo $t->get_prioritaet() ?></td>
            <td><?php echo $t->get_beginn() ?></td>
            <td><?php echo $t->get_ende() ?></td>
            <td><?php echo $t->get_benutzer() ?></td>
            <td><?php echo $t->get_kundennummer() ?></td>
            <td><?php echo $t->get_nachname() ?></td>
            <td><?php echo $t->get_vorname() ?></td>
            <td><?php echo $t->get_plz() ?></td>
            <td><?php echo $t->get_ort() ?></td>
            <td><?php echo $t->get_strasse() ?></td>
            <td><?php echo $t->get_hausnummer() ?></td>
			<?php $selected=$selected+1; ?>
        </tr>
    <?php } ?>
</table>