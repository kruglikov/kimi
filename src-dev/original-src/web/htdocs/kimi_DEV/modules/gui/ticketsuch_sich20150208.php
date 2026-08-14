<h2><?php echo TXT_LBL_TICKSUCH; ?></h2>
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
        </tr>
        <tr>
            <td><?php echo TXT_LBL_LASTNAME ?></td>
            <td><input value="<?php echo $nachname ?>" placeholder="<?php echo TXT_LBL_LASTNAME ?>" class="column" type="text" name="nachname" /></td>
            <td><?php echo TXT_LBL_FIRSTNAME ?></td>
            <td><input value="<?php echo $vorname ?>" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" class="column" type="text" name="vorname" /></td>
            <td><?php echo TXT_LBL_PLZ ?></td>
            <td><input value="<?php echo $plz ?>" placeholder="<?php echo TXT_LBL_PLZ ?>" class="column" type="text" name="plz" /></td>
        </tr>
        <tr>
            <td><?php echo TXT_LBL_ORT ?></td>
            <td><input class="column" value="<?php echo $ort ?>" placeholder="<?php echo TXT_LBL_ORT ?>" type="text" name="ort" /></td>
            <td><?php echo TXT_LBL_STR ?></td>
            <td><input class="column" value="<?php echo $strasse ?>" placeholder="<?php echo TXT_LBL_STR ?>" type="text" name="strasse" /></td>
            <td><?php echo TXT_LBL_HNR ?></td>
            <td><input class="column" value="<?php echo $hausnummer ?>" placeholder="<?php echo TXT_LBL_HNR ?>" type="text" name="hausnummer" /></td>
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
        </tr>
        <tr>
            <td><?php echo TXT_LBL_BEGIN ?></td>
            <td><input class="column" value="<?php echo $beginn ?>" placeholder="<?php echo TXT_LBL_BEGIN ?>" type="date" name="beginn" /></td>
            <td><?php echo TXT_LBL_END ?></td>
            <td><input value="<?php echo $ende ?>" placeholder="<?php echo TXT_LBL_END ?>" class="column" type="date" name="ende" /></td>
            <td><?php echo TXT_LBL_STUNDEN ?></td>
            <td><input class="column" value="<?php echo $aufwand ?>" placeholder="<?php echo TXT_LBL_STUNDEN ?>" type="text" name="aufwand" /></td>
        </tr>
    </table>
    <input type="submit" value="<?php echo TXT_LBL_SEARCH ?>" />
    <?php if (App::$CURRENT->has_permission("ticket", "INS")) { ?>
        <a class="button" href="./index.php?site=ticket"><?php echo TXT_LBL_NEW ?></a>
    <?php } ?>
    <a class="button" href="./index.php?site=ticketsuch&reset=true"><?php echo TXT_LBL_RESET ?></a>
    
</form>
</div>
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
            <td><a href="./index.php?site=ticket&ticket_id=<?php echo $t->get_id() ?>"><?php echo $t->get_ticketnr() ?></a></td>
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
        </tr>
    <?php } ?>
</table>

<div class="buttonset">
    <a href="index.php?site=ticketsuch&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=ticketsuch&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>
    <a href="index.php?site=ticketsuch&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>