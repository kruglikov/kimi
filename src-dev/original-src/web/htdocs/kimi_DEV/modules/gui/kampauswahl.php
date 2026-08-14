<div class="shadow" style="padding:1px 10px; border-radius: 5px; margin: 0 auto; width: 350px;">
    <div id="login-div">
        <span class="headlines-subtext"><?php echo TXT_LBL_KAMPAGNE ?></span>
        <hr style="padding:0; margin:0;" />
        <div class="space"></div>
        <form id="kampform" method="get" action="./index.php">
            <input type="hidden" name="site" value="ticketsuch" />
            <table>
                <tr>
                    <td><?php echo TXT_LBL_KAMPAGNE ?></td>
                    <td>
                        <select name="kId" id="kId" style="min-width: 250px;">
                            <?php
                            $foundKamp = 0;
                            foreach ($kampagnen as $val) {
                                $validKamp = true;
                                
                                if (!strpos(CONF_KAMPAGNE_USER, ".".App::$CURRENT->USER->get_id()."=") == false ) {
                                    if (strpos(CONF_KAMPAGNE_USER, ".".App::$CURRENT->USER->get_id()."=".$val->get_id()."." ) ==false ) {
                                        $validKamp = false;
                                    }
                                } 

                                if ($validKamp==true) {
                                    echo "<option value=\"" . $val->get_id() . "\"";
                                    if ($lastKamp == $val->get_id()) echo "selected";
                                    echo ">" . $val->get_bezeichnung() . "</option>";
                                    $foundKamp = $foundKamp + 1;
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="space"></div>
            <input type="submit" style="width: 100%;" value="<?php echo TXT_LBL_SELECT ?>" />
            <div style="height:10px"></div>
        </form>
        <?php
        if ($foundKamp == 1) { 
            echo '<script language="javascript">';
            echo 'document.getElementById("kampform").submit();';
            echo '</script>';
        } ?>
    </div>
</div>