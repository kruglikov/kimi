<h1><?php echo TXT_LBL_BASE_DATA_SEARCH ?></h1>

<form>
    <table>
        <tr>
            <td><?php echo TXT_LBL_KDNR ?></td>
            <td><input value="<?php echo $kdnr; ?>" name="kdnr" type="text" placeholder="<?php echo TXT_LBL_KDNR ?>" /></td>
            <td />
            <td />
        </tr>
        <tr>
            <td><?php echo TXT_LBL_ZAHLTAG ?></td>
            <td><input value="<?php echo $zahltag; ?>" name="zahltag" type="date" placeholder="<?php echo TXT_LBL_ZAHLTAG ?>" /></td>
            <td><?php echo TXT_LBL_STICHTAG ?></td>
            <td><input value="<?php echo $abrechnungstag; ?>" name="abrechnungstag" type="date" placeholder="<?php echo TXT_LBL_STICHTAG ?>" /></td>
        </tr>
        <tr>
            <td><label for="mahnsperre"><?php echo TXT_LBL_MAHNSPERRE ?></label></td>
            <td><input value="<?php echo $mahnsperre; ?>" name="mahnsperre" id="mahnsperre" name="mahnsperre" type="text" placeholder="<?php echo TXT_LBL_MAHNSPERRE ?>" /></td>
            <td><?php echo TXT_LBL_MAHNSPERR_DATUM ?></td>
            <td><input value="<?php echo $mahnsperre_datum; ?>" name="mahnsperre_datum" type="date" placeholder="<?php echo TXT_LBL_MAHNSPERR_DATUM ?>" /></td>
        </tr>
    </table>
    <input type="submit" value="<?php echo TXT_LBL_SEARCH ?>" class="column" />
    <input type="hidden" value="stammsuche" name="site" />
    <a href="./index.php?site=stammsuche&reset=true" class="button column"><?php echo TXT_LBL_RESET ?></a>
</form>

<table class="designed">
    <tr>
        <th><?php echo TXT_LBL_KDNR ?></th>
        <th><?php echo TXT_LBL_LASTNAME ?></th>
        <th><?php echo TXT_LBL_FIRSTNAME ?></th>
        <th><?php echo TXT_LBL_PLZ ?></th>
        <th><?php echo TXT_LBL_ORT ?></th>
        <th><?php echo TXT_LBL_STR ?></th>
        <th><?php echo TXT_LBL_ZAHLTAG ?></th>
        <th><?php echo TXT_LBL_STICHTAG ?></th>
        <th><?php echo TXT_LBL_MAHNSPERRE ?></th>
        <th><?php echo TXT_LBL_MAHNSPERR_DATUM ?></th>
    </tr>
    <?php foreach($stammdaten as $item) { ?>
    <tr>
        <td><a href="./index.php?site=stammdaten&kundennummer=<?php echo $item->get_kunde_kdnr(); ?>"><?php echo $item->get_kunde_kdnr(); ?></a></td>
        <td><?php echo $item->get_kunde_nachname(); ?></td>
        <td><?php echo $item->get_kunde_vorname(); ?></td>
        <td><?php echo $item->get_kunde_plz(); ?></td>
        <td><?php echo $item->get_kunde_ort(); ?></td>
        <td><?php echo $item->get_kunde_strasse(); ?></td>
        <td><?php echo $item->get_zahltag(); ?></td>
        <td><?php echo $item->get_stichtag(); ?></td>
        <td><input type="checkbox" disabled <?php if ($item->get_mahnsperre() == "MS") echo "checked"; ?> /></td>
        <td><?php echo $item->get_mahnsperre_datum(); ?></td>
    </tr>
    <?php } ?>
</table>

<div class="buttonset">
    <a href="index.php?site=stammsuche&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=stammsuche&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>
    <?php
        if ($more_pages == TRUE){

         echo "<button class=\"button\" disabled>...</button>";
         }
         ?>
    <a href="index.php?site=stammsuche&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>
</div>