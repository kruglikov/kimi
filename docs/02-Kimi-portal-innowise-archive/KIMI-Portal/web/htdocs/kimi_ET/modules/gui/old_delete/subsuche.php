<h1><?php echo TXT_LBL_SUBSEARCH ?></h1>

<form method="get">
    <table>
        <tr>
            <td><?php echo TXT_LBL_KDNR; ?></td>
            <td>
                <input type="text" placeholder="<?php echo TXT_LBL_KDNR ?>" name="kundennummer" class="column" value="<?php echo $kunde_nr; ?>" />
            </td>
            <td>
            <td><?php echo TXT_LBL_RNR ?></td>
            </td>
            <td>
                <input type="text" placeholder="<?php echo TXT_LBL_RNR ?>" name="rechnungsnummer" class="column" value="<?php echo $rechnungsnr; ?>" />
            </td>
            <td>
                <input type="hidden" name="site" value="subsuche" />
                <input type="submit" value="<?php echo TXT_LBL_SEARCH; ?>" />
            </td>
        </tr>
    </table>
</form>

<table class="designed">
    <tr>
        <th><?php echo TXT_LBL_LINK ?></th>
        <th><?php echo TXT_LBL_RECHNUNG ?></th>
        <th><?php echo TXT_LBL_ZA ?></th>
        <th><?php echo TXT_LBL_ZINS ?></th>
        <th><?php echo TXT_LBL_OPENED ?></th>
        <th><?php echo TXT_LBL_KW ?></th>
        <th><?php echo TXT_LBL_RH ?></th>
        <th><?php echo TXT_LBL_M4 ?></th>
        <th><?php echo TXT_LBL_M3 ?></th>
        <th><?php echo TXT_LBL_M2 ?></th>
        <th><?php echo TXT_LBL_M1 ?></th>
        <th><?php echo TXT_LBL_M0 ?></th>
        <th><?php echo TXT_LBL_REST ?></th>
        <th><?php echo TXT_LBL_SALDO ?></th>
    </tr>
    <?php

    foreach ($subkonten as $item) {
        ?>
        <tr>
            <td><a href="index.php?site=subdetail&subkonto=<?php echo $item->get_id(); ?>"><?php echo TXT_LBL_LINKSKD; ?></a></td>
            <td><?php echo $item->get_rechnungsnummer(); ?></td>
            <td><?php echo $item->get_zahlart(); ?></td>
            <td style="text-align: right"><?php echo $item->get_zinssatz(); ?></td>
            <td><?php echo $item->get_eroeffnet_am(); ?></td>
            <td style="text-align: right"><?php echo $item->get_kaufwert(); ?></td>
            <td style="text-align: right"><?php echo $item->get_ratenhoehe(); ?></td>
            <td style="text-align: right"><?php echo $item->get_m4(); ?></td>
            <td style="text-align: right"><?php echo $item->get_m3(); ?></td>
            <td  style="text-align: right"><?php echo $item->get_m2(); ?></td>
            <td style="text-align: right"><?php echo $item->get_m1(); ?></td>
            <td style="text-align: right"><?php echo $item->get_m0(); ?></td>
            <td style="text-align: right"><?php echo $item->get_rest(); ?></td>
            <td style="text-align: right"><?php echo $item->get_saldo(); ?></td>
        </tr>
        <?php
    }
    ?>
</table>

<div class="buttonset">
    <a href="index.php?site=subsuche&s=<?php echo ($site - 1) ?>" <?php if ($site <= 0) echo "disabled" ?> class="button-left <?php if ($site <= 0) echo "disabled" ?>"><?php echo TXT_LBL_NAV_BACK ?></a>
    <?php
    for ($i = 0; $i < $max_site; $i++) {
        if ($i == $site) {
            echo "<button class=\"button\" disabled>" . ($i + 1) . "</button>";
        } else {
            echo "<a class=\"button\" href=\"index.php?site=subsuche&s=$i\">" . ($i + 1) . "</a>";
        }
    }
    ?>
    <?php 
        if ($more_pages == TRUE){
         echo "<a class=\"button\" disabled>...</a>";
         }
         ?>

    <a href="index.php?site=subsuche&s=<?php echo ($site + 1) ?>" <?php if ($site >= $max_site - 1) echo "disabled" ?> class="button-right"><?php echo TXT_LBL_NAV_FORWARD ?></a>

</div>