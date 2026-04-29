<h2>Passwortgenerator</h2>
<form method="post">
    <table>
        <colgroup>
            <col span='1' style="width: auto" />
            <col span='1' style="width: auto" />
        </colgroup>
        <tr>
            <td><?php echo TXT_LBL_PASSWORD ?></td>
            <td>
                <input style="width: 100%" type="text" name="password" placeholder="<?php echo TXT_LBL_PASSWORD ?>" />
            </td>
        </tr>
        <tr>
            <td><?php echo TXT_LBL_PASSWORD_ENCR ?></td>
            <td>
                <?php echo $hash ?>
            </td>
        </tr>
    </table>
    <input type="hidden" name="site" value="pwgen" />
    <input type="submit" value="<?php echo TXT_LBL_NAV_FORWARD ?>" />
</form>