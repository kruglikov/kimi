<?php include_once "./modules/gui/templates/tickets/$kampId/ticketuebersicht.php" ?>
<?php include_once "./config/config.php" ?>

<script type="text/javascript">
    var closable = true;

    <?php include_once "./modules/gui/templates/tickets/$kampId/ticketvalidate.js" ?>
	<?php include_once "./modules/gui/templates/tickets/$kampId/ticketoptimize.js" ?>

    function setRadioValue(radioName, value) {
        var rObj = document.getElementsByName(radioName);
        for (var i=0; i<rObj.length; i++) 
        if (rObj[i].value == value) 
            rObj[i].checked = true;
    }

	// 20180529/ar ($kampId != CONF_KAMPAGNE_AKT)
    <?php if (strpos(CONF_KAMPAGNE_AKT, ".".$kampId.".") == false && strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") === false  ) { ?>
        window.onload = function() {

			if (document.getElementsByName("id")[0].value != '') {
				var r = confirm("<?php echo TXT_LBL_TICKET_HIST_START ?>");
				if (r == true) {
					document.getElementById("btnStart").click();
				} 
			} else {
				document.getElementsByName("wiedervorlage_automatik")[0].value = '1';
			}
        }

    <?php } ?>    
    
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
        

        $(window).on('beforeunload', function(){
           if (!closable) {
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
            closable = false;
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
					var data = $.parseJSON(data);
					document.getElementsByName('wiedervorlage')[0].value = data.wiedervorlage;
					document.getElementsByName('wiedervorlage_zeitpunkt')[0].value = data.wiedervorlage_zeitpunkt;
					document.getElementsByName('anruf_info')[0].value = data.anruf_info;
					document.getElementsByName('letzte_wiedervorlage_info')[0].value = data.letzte_wiedervorlage + ' ' + data.letzte_wiedervorlage_zeitpunkt;
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
            closable = true;
            
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
		
       $("#btnPrevious").click(function(e) {
			prev_ticket_id = document.getElementsByName("prev_ticket_id")[0].value;
			selected_tickets = document.getElementsByName("selected_tickets")[0].value;
			selected_ticket_index = parseInt(document.getElementsByName("selected_ticket_index")[0].value);
			selected_ticket_index = selected_ticket_index - 1;
			url = "./index.php?site=ticket2&ticket_id="+prev_ticket_id+"&selected_tickets="+selected_tickets+"&selected_ticket_index="+selected_ticket_index;
			window.open(url, "_self");
			return;
        });
       $("#btnNext").click(function(e) {
			next_ticket_id = document.getElementsByName("next_ticket_id")[0].value;
			selected_tickets = document.getElementsByName("selected_tickets")[0].value;
			selected_ticket_index = parseInt(document.getElementsByName("selected_ticket_index")[0].value);
			selected_ticket_index = selected_ticket_index + 1;
			url = "./index.php?site=ticket2&ticket_id="+next_ticket_id+"&selected_tickets="+selected_tickets+"&selected_ticket_index="+selected_ticket_index;
			window.open(url, "_self");
			return;
        });
		
       $("#btnTelWrongNo").click(function(e) {
		   return formDoAction("OnTelWrongNo", "<?php echo App::$CURRENT->MANDANT->get_id(); ?>", "<?php echo App::$CURRENT->USER->get_id(); ?>" );
        });
       $("#btnTelNotReachable").click(function(e) {
   		   return formDoAction("OnTelNotReachable", "<?php echo App::$CURRENT->MANDANT->get_id(); ?>", "<?php echo App::$CURRENT->USER->get_id(); ?>" );
        });
		
       $("#callTelco1").click(function(e) {
            $this = $(this);
            e.preventDefault();
			$('#telefon_status').val('senden...');

			kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;
			kampagne_iptel_auto_vorwahl  = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;
			benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
			telNr = document.getElementsByName("telefon")[0].value;
			clientIp = document.getElementsByName("client_ip")[0].value;

            $.ajax({
                url: "./index.php?site=callInntelco&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'callTelNo',
					'user': '<?php echo App::$CURRENT->USER->get_name() ?>',
					'iptel_durchwahl': benutzer_iptel_durchwahl,
					'kampagne_iptel_destclid': kampagne_iptel_destclid,
					'kampagne_iptel_auto_vorwahl': kampagne_iptel_auto_vorwahl,
					'dest': telNr,
					'client_ip': clientIp
                },
                success: function(data) {
					var data = $.parseJSON(data);
					if (data.retcode != "0") {
						alert(data.msg);
						$('#telefon_status').val('Fehler');
					}  else {
						$('#telefon_status').val('Fertig');
					}
                },
                error: function(error) {
					alert('E');
                    alert(error);
					$('#telefon_status').val('Fehler');
                }
            });
        });
		
       $("#callTelco2").click(function(e) {
            $this = $(this);
            e.preventDefault();
			$('#telefon_status').val('senden...');
			kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;
			kampagne_iptel_auto_vorwahl  = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;
			benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
			telNr = document.getElementsByName("telefon2")[0].value;
			clientIp = document.getElementsByName("client_ip")[0].value;

            $.ajax({
                url: "./index.php?site=callInntelco&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'callTelNo',
					'user': '<?php echo App::$CURRENT->USER->get_name() ?>',
					'iptel_durchwahl': benutzer_iptel_durchwahl,
					'kampagne_iptel_destclid': kampagne_iptel_destclid,
					'kampagne_iptel_auto_vorwahl': kampagne_iptel_auto_vorwahl,
					'dest': telNr,
					'client_ip': clientIp
                },
                success: function(data) {
					var data = $.parseJSON(data);
					if (data.retcode != "0") {
						alert(data.msg);
						$('#telefon_status').val('Fehler');
					} else {
						$('#telefon_status').val('Fertig');
					}
                },
                error: function(error) {
                    alert(error);
					$('#telefon_status').val('Fehler');
                }
            });
        });
		
       $("#callTelcoAllg").click(function(e) {
            $this = $(this);
            e.preventDefault();
			
			$('#telefon_status').val('senden...');

			kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;
			kampagne_iptel_auto_vorwahl  = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;
			benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
			//telNr = document.getElementsByName("telefon2")[0].value;
			telNr = $('#telefon_allg').val()
			clientIp = document.getElementsByName("client_ip")[0].value;

            $.ajax({
                url: "./index.php?site=callInntelco&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'callTelNo',
					'user': '<?php echo App::$CURRENT->USER->get_name() ?>',
					'iptel_durchwahl': benutzer_iptel_durchwahl,
					'kampagne_iptel_destclid': kampagne_iptel_destclid,
					'kampagne_iptel_auto_vorwahl': kampagne_iptel_auto_vorwahl,
					'dest': telNr,
					'client_ip': clientIp
                },
                success: function(data) {
					var data = $.parseJSON(data);
					if (data.retcode != "0") {
						alert(data.msg);
						$('#telefon_status').val('Fehler');
					} else {
						$('#telefon_status').val('Fertig');
					}
                },
                error: function(error) {
                    alert(error);
					$('#telefon_status').val('Fehler');
                }
            });
        });
    });

	
</script>

<h2><table width="100%" border="0"><tr>
<td>

<?php echo TXT_LBL_TICKDETAIL; ?> (<?php echo $kamp->get_bezeichnung(); ?>)
    <?php 
		//20180529/ar  if ($kampId!=CONF_KAMPAGNE_AKT) { 
		if ( strpos(CONF_KAMPAGNE_AKT, ".".$kampId.".") == false && strpos(CONF_KAMPAGNE_TICKET_NO_TELEFON, ".".$kampId.".") === false ) { 
		?>
			
        <button id="btnStart" class="button" href="#"><?php echo TXT_LBL_TICKET_HIST_START ?></button>
        <button id="btnEnd" class="button" style="display: none;" href="#"><?php echo TXT_LBL_TICKET_HIST_END ?></button>
		<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" ?>
        <button id="btnTelWrongNo" class="button" href="#"><?php echo "Telefonnummer falsch" ?></button>
        <button id="btnTelNotReachable" class="button" href="#"><?php echo "nicht erreichbar" ?></button>
    <?php } ?>
	<?php
	if (strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") === false) {?>
	<?php echo "&nbsp;&nbsp;" ?>
        <input style="width: 170px" placeholder="Telefonnummer Direktwahl" name="telefon_allg" id="telefon_allg" class="column" type="text" value="" /> 
		<img alt="wählen" style="vertical-align: middle;" src="../images/telephone.png" id="callTelcoAllg" name="callTelcoAllg" width="20" height="20" />
        <input style="width: 70px;border:0px;background-color: transparent;color: #252525;" readonly="readonly" name="telefon_status" id="telefon_status" class="column" type="text" value="" /> 		
	</td>
	<td align="right">
        <button id="btnPrevious" title="Voriges Ticket anzeigen" class="button" <?php if ($prev_ticket_id=="") echo " disabled " ?> href="#"><?php echo "<" ?></button>
        <button id="btnNext" title="Nächstes Ticket anzeigen" class="button"  <?php if ($next_ticket_id=="") echo " disabled " ?> href="#"><?php echo ">" ?></button>
	</td> <?php		
	} else {
		?>
		</td>
		<td></td><?php
	}?>

	</tr>
	</table>
</h2>

<form id="formTicket" onsubmit="return validateFormOnSave()" method="post" <?php if (!App::$CURRENT->has_permission("ticket2", "UPD") || !App::$CURRENT->has_permission("ticket2", "INS")) echo "disabled"; ?>>
    <input type="hidden" name="id" value="<?php echo $ticket->get_id() ?>" />
    <input type="hidden" name="ticket_id" value="<?php echo $ticket->get_id() ?>" />
	<input type="hidden" name="selected_tickets" value="<?php echo $selected_tickets ?>" />
	<input type="hidden" name="selected_ticket_index" value="<?php echo $selected_ticket_index ?>" />
	<input type="hidden" name="max_ticket" value="<?php echo $max_ticket ?>" />
	<input type="hidden" name="prev_ticket_id" value="<?php echo $prev_ticket_id ?>" />
	<input type="hidden" name="next_ticket_id" value="<?php echo $next_ticket_id ?>" />
	<input type="hidden" name="kampagne_iptel_destclid" value="<?php echo $kamp->get_iptel_destclid()  ?>" />
	<input type="hidden" name="kampagne_iptel_auto_vorwahl" value="<?php echo $kamp->get_iptel_auto_vorwahl()  ?>" />
	<input type="hidden" name="benutzer_iptel_durchwahl" value="<?php echo App::$CURRENT->USER->get_iptel_durchwahl()  ?>" />
	<input type="hidden" name="client_ip" value="<?php echo $_SERVER['REMOTE_ADDR']  ?>" />
    <?php include_once "./modules/gui/templates/tickets/$kampId/ticket2.php" ?>

    <input type="hidden" name="site" value="ticket2" />
    <input type="hidden" name="mandant_id" value="<?php echo $ticket->get_mandant_id(); ?>" />

    <input type="hidden" name="mode" value="<?php
    if ($mode == "SEL")
        echo "UPD"; else if ($mode == "NEW" || $mode == "INS")
        echo "INS";
    else
        echo "UPD";
    ?>" />

    <?php
    if (App::$CURRENT->has_permission("ticket2", "UPD") ||
            App::$CURRENT->has_permission("ticket2", "INS")) {
        ?>
        <input accesskey="S" type="submit" value="<?php echo TXT_LBL_SAVE ?>" />
    <?php } ?>
	<?php 
	//20180529/ar: $kampId != CONF_KAMPAGNE_AKT
	?>
    <?php if (strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") >= 0) { ?>
        <a class="button" href="./index.php?site=ticketsuch2&reset=TRUE"><?php echo TXT_LBL_CANCEL ?></a>
    <?php }?>

    <?php if ($ticket_id != -1 && strpos(CONF_KAMPAGNE_AKT, ".".$kampId.".") == false && strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") === false && App::$CURRENT->has_permission("ticket2", "DEL")) { ?>
        <a class="button confirm" href="./index.php?site=ticket2&mode=DEL&ticket_id=<?php echo $ticket_id; ?>"><?php echo TXT_LBL_DEL ?></a>
    <?php }
    if (App::$CURRENT->has_permission("ticket2", "INS") && strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") === false ) {
        ?>
        <a accesskey="N"  class="button" href="./index.php?site=ticket2"><?php echo TXT_LBL_NEW ?></a>
<?php } ?>

</form>
