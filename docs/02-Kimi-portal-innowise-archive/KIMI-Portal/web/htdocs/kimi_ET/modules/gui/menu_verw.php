<h1><?php echo TXT_LBL_MENU_VERW_LONG ?></h1>

<div id="portal-menu">
    <table>
        <?php
        $count = 0;
        echo '<tr>';
        foreach ($verw_menu as $value) {
            if ($count > 0 && $count % CONF_PORTAL_MENU_COLUMNS == 0) {
                echo "</tr><tr>";
            }
            echo "<td><a class=\"button portal-link\" href=\"" . $value->get_link() . "\">" . $value->get_text() . "</a></td>";
            $count++;
        }
        echo '</tr>';
        ?>
    </table>
</div>
