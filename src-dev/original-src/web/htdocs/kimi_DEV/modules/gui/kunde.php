<h1><?php echo TXT_LBL_CUSTOMER_SEARCH ?></h1>

<div>
    <form action="index.php" method="GET">
        <input type="hidden" name="site" id="site" value="kunde" />
        <input type="hidden" name="search" id="search" value="true" />
        <table>
            <tr>
                <td><?php echo TXT_LBL_KDNR ?></td>
                <td>
                    <input value="<?php echo $kdnr; ?>" name="kdnr" id="kdnr" class="search" type="text" placeholder="<?php echo TXT_LBL_KDNR ?>" />
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
		<td></td>
		<td></td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_PLZ ?></td>
                <td>
                    <input value="<?php echo $plz; ?>" name ="plz" id="plz" class="search" type="text" placeholder="<?php echo TXT_LBL_PLZ ?>" />
                </td>
                <td><?php echo TXT_LBL_LASTNAME ?></td>
                <td>
                    <input value="<?php echo $nachname; ?>" name="nachname" id="nachname" class="search" type="text" placeholder="<?php echo TXT_LBL_LASTNAME ?>" />
                </td>
                <td><?php echo TXT_LBL_EMAIL ?></td>
                <td>
                    <input value="<?php echo $email; ?>" name="email" id="email" class="search" type="email" placeholder="<?php echo TXT_LBL_EMAIL ?>" />
                </td>
		<td><?php echo TXT_LBL_PRIMAERKDNR ?></td>
		<td>
                    <input value="<?php echo $primaerkdnr; ?>" name="primaerkdnr" id="primaerkdnr" class="search" type="text" placeholder="<?php echo TXT_LBL_PRIMAERKDNR ?>" />
		</td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_ORT ?></td>
                <td>
                    <input value="<?php echo $ort; ?>" name="ort" id="ort" class="search" type="text" placeholder="<?php echo TXT_LBL_ORT ?>" />
                </td>
                <td><?php echo TXT_LBL_FIRSTNAME ?></td>
                <td>
                    <input value="<?php echo $vorname; ?>" name="vorname" id="vorname" class="search" type="text" placeholder="<?php echo TXT_LBL_FIRSTNAME ?>" />
                </td>
                <td><?php echo TXT_LBL_TEL ?></td>
                <td>
                    <input value="<?php echo $telefon; ?>" name="telefon" id="telefon" class="search" type="text" placeholder="<?php echo TXT_LBL_TEL ?>" />
                </td>
            </tr>
            <tr>
                <td><?php echo TXT_LBL_STR ?></td>
                <td>
                    <input value="<?php echo $strasse; ?>" name="strasse" id="strasse" class="search" type="text" placeholder="<?php echo TXT_LBL_STR ?>" />
                </td>
                <td><?php echo TXT_LBL_HNR ?></td>
                <td>
                    <input value="<?php echo $hausnummer; ?>" name="hausnummer" id="hausnummer" class="search" type="text" placeholder="<?php echo TXT_LBL_HNR ?>" />
                </td>
                <td><?php echo TXT_LBL_BIRTH ?></td>
                <td>
                    <input value="<?php echo $geburtsdatum; ?>" name="geburtsdatum" id="geburtsdatum" class="search" type="date" placeholder="<?php echo TXT_LBL_BIRTH ?>" />
                </td>
            </tr>
        </table>
        <input class="search" type="submit" value="<?php echo TXT_LBL_SEARCH ?>" />
        <a href="index.php?site=kunde&reset=true" class="button search"><?php echo TXT_LBL_RESET ?></a>
        <?php if (App::$CURRENT->has_permission("kunde_details", "INS")) { ?>
            <a href="index.php?site=kunde_details&new=true" class="button search"><?php echo TXT_LBL_NEW_CUSTOMER ?></a>
        <?php } ?>
    </form>
</div>

<table class="designed">
    <tr>
        <th></th>
        <th><a href="index.php?site=kunde&order=KDNR"><?php echo TXT_LBL_KDNR ?></a></th>
        <th><a href="index.php?site=kunde&order=ANREDE"><?php echo TXT_LBL_ANREDE ?></a></th>
        <th><a href="index.php?site=kunde&order=TITEL"><?php echo TXT_LBL_TITEL ?></a></th>
        <th><a href="index.php?site=kunde&order=VORNAME"><?php echo TXT_LBL_FIRSTNAME ?></a></th>
        <th><a href="index.php?site=kunde&order=NACHNAME"><?php echo TXT_LBL_LASTNAME ?></a></th>
        <th><a href="index.php?site=kunde&order=PLZ"><?php echo TXT_LBL_PLZ ?></a></th>
        <th><a href="index.php?site=kunde&order=ORT"><?php echo TXT_LBL_ORT ?></a></th>
        <th><a href="index.php?site=kunde&order=STRASSE"><?php echo TXT_LBL_STR ?></a></th>
        <th><a href="index.php?site=kunde&order=TELEFON"><?php echo TXT_LBL_TEL ?></a></th>
        <th><a href="index.php?site=kunde&order=EMAIL"><?php echo TXT_LBL_EMAIL ?></a></th>
        <th><a href="index.php?site=kunde&order=PRIMAERKDNR"><?php echo TXT_LBL_PRIMAERKDNR ?></a></th>
    </tr>
    <?php

    foreach ($customers as $item) {
        ?>
        <tr>
            <td><a href="index.php?site=stammdaten&kunde=<?php echo $item->get_id(); ?>"><?php echo TXT_LBL_LINKKONTO; ?></a></td>
            <td>
                <a href="index.php?site=kunde_details&kunde=<?php echo $item->get_id(); ?>"><?php echo $item->get_kdnr(); ?></a>
            </td>
            <td>
                <?php echo $item->get_anrede(); ?>
            </td>
            <td>
                <?php echo $item->get_titel(); ?>
            </td>
            <td>
                <?php echo $item->get_vorname(); ?>
            </td>
            <td>
                <?php echo $item->get_nachname(); ?>
            </td>
            <td>
                <?php echo $item->get_plz(); ?>
            </td>
            <td>
                <?php echo $item->get_ort(); ?>
            </td>
            <td>
                <?php echo $item->get_strasse() . " " . $item->get_hausnummer(); ?>
            </td>
            <td>
                <?php echo $item->get_telefon(); ?>
            </td>
            <td>
                <?php echo $item->get_email(); ?>
            </td>
            <td>
                <?php echo $item->get_primaerkdnr(); ?>
            </td>

        </tr>
        <?php
    }
    ?>
</table>

<div class="buttonset">
    <a href="index.php?site=kunde&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=kunde&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>
    <?php 
        if ($more_pages == TRUE){
         echo "<a class=\"button\" disabled>...</a>";
         }
         ?>
    <a href="index.php?site=kunde&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>

</div>