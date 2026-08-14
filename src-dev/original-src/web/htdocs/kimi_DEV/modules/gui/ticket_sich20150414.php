<?php include_once "./modules/gui/templates/tickets/$kampId/ticketuebersicht.php" ?>

<script type="text/javascript">
    var closable = true;
    
    $(document).ready(function() {
        $.ajax({
            url: "./index.php?site=add_log&ajax=true",
            type: "POST",
            data: {
                'objekt': 'TICKET',
                'objekt_id': '<?php echo $ticket->get_id() ?>',
                'logart': 'AUTO_OPEN'
            }
        });
        $(window).unload(function() {
            if (!$closable) {
                $.ajax({
                    url: "./index.php?site=add_log&ajax=true",
                    type: "POST",
                    data: {
                        'objekt': 'TICKET',
                        'objekt_id': '<?php echo $ticket->get_id() ?>',
                        'logart': 'MAN_END_A'
                    },
                    async: false
                });
            }
            $.ajax({
                url: "./index.php?site=add_log&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'TICKET',
                    'objekt_id': '<?php echo $ticket->get_id() ?>',
                    'logart': 'AUTO_CLOSE'
                },
                async: false
            });
        });
        
        $("#btnStart").click(function(e) {
            $this = $(this);
            e.preventDefault();
            $closable = false;
            
            $(this).attr("disabled", true);
            
            $.ajax({
                url: "./index.php?site=add_log&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'TICKET',
                    'objekt_id': '<?php echo $ticket->get_id() ?>',
                    'logart': 'MAN_START'
                },
                success: function(data) {
                    $this.hide();
                    $this.removeAttr("disabled");
                    $("#btnEnd").show();
                },
                error: function(error) {
                    $this.removeAttr("disabled");
                    alert(error);
                }
            });
        });
        
        $("#btnEnd").click(function(e) {
            $this = $(this);
            e.preventDefault();
            $closable = false;
            
            $(this).attr("disabled", true);
            
            $.ajax({
                url: "./index.php?site=add_log&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'TICKET',
                    'objekt_id': '<?php echo $ticket->get_id() ?>',
                    'logart': 'MAN_END'
                },
                success: function(data) {
                    $this.hide();
                    $this.removeAttr("disabled");
                    $("#btnStart").show();
                },
                error: function(error) {
                    $this.removeAttr("disabled");
                    alert(error);
                }
            });
        });
        
    });
</script>

<h2><?php echo TXT_LBL_TICKDETAIL; ?> (<?php echo $kamp->get_bezeichnung(); ?>)
    <button id="btnStart" class="button" href="#"><?php echo TXT_LBL_TICKET_HIST_START ?></button>
    <button id="btnEnd" class="button" style="display: none;" href="#"><?php echo TXT_LBL_TICKET_HIST_END ?></button>
</h2>
<form id="formTicket" method="post" <?php if (!App::$CURRENT->has_permission("ticket", "UPD") || !App::$CURRENT->has_permission("ticket", "INS")) echo "disabled"; ?>>
    <input type="hidden" name="id" value="<?php echo $ticket->get_id() ?>" />
    <input type="hidden" name="ticket_id" value="<?php echo $ticket->get_id() ?>" />

    <?php include_once "./modules/gui/templates/tickets/$kampId/ticket.php" ?>

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