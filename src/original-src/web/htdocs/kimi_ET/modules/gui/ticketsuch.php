<h2><?php echo TXT_LBL_TICKSUCH; ?> (<?php echo $kamp->get_bezeichnung() ?>)</h2>
<?php include_once "$kampPath/ticketsuch.php" ?>

<?php 
	if ($kamp->get_id() == 30) {
		echo "<br>";
	} else {?>
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
<?php	} ?>


