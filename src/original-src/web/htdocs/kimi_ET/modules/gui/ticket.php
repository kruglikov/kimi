<script type="text/javascript">
	// Funktionen für iCalendar

    //zero padding for data fixes
    function zeroPad(s){ 
		return ("0"+s).slice(-2); 
	}
	
	function getFilenameForICal() {
		
		var ticketnr = document.getElementsByName("ticketnr")[0].value;
		var kamp_id = "<?php echo $kampId?>";
		var dat = new Date();
		var month = dat.getMonth()+1;
		
		var ts = "";
		var ts = ts.concat(dat.getFullYear(), zeroPad(month), zeroPad(dat.getDay()), zeroPad(dat.getHours()), zeroPad(dat.getMinutes()), zeroPad(dat.getSeconds()));
		
		var filename = "./ical/kimi_event_" + kamp_id + "_" + ticketnr + "_" + ts +  ".ics";
		
		return filename;
	};
	
	function fixUmlaute(value) {
		value = value.replace(/ä/g, '&auml;');
		value = value.replace(/ö/g, '&ouml;');
		value = value.replace(/ü/g, '&uuml;');
		value = value.replace(/ß/g, '&szlig;');
		value = value.replace(/Ä/g, '&Auml;');
		value = value.replace(/Ö/g, '&Ouml;');
		value = value.replace(/Ü/g, '&Uuml;');
		value = value.replace(/(?:\r\n|\r|\n)/g, '<br>');
		return value;
	}
	
	function generate_icalendar(filename, dateStart, timeStart, dateEnd, timeEnd, subject, eventLocation, textDescription, htmlDescription) {
			
			if (filename == "") {
				filename = getFilenameForICal();
			}
	
			htmlDescription = fixUmlaute(htmlDescription);
			textDescription = fixUmlaute(textDescription);

			var content = getICalContent(dateStart, timeStart, dateEnd, timeEnd, subject, eventLocation, textDescription, htmlDescription);
			
			$.ajax({
                url: "./index.php?site=write_file&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'save_icl',
					'filename': filename,
					'content': content					
                },
                success: function(data) {
					var data = $.parseJSON(data);
					return filenme;
					
                },
                error: function(error) {
                    alert('FEHLER '+error);
					return "";
                }
            });
		};

	function addMinutes(time, minutes) {

		var hour =  parseInt(time.substr(0, 2));
		var min =   parseInt(time.substr(2, 2));
		if (min == 60 ) {
			hour = hour + 1;
		}
		else {
			min = min + parseInt(minutes);
			if (min > 60) {
				min = min - 60;
				hour = hour + 1;
			}
		}
		return hour.toString() + min.toString();
		
	}
		
	function getICalContent(dateStart, timeStart, dateEnd, timeEnd, subject, eventLocation, desc, xDescription){
		//helper functions
	
		//iso date for ical formats
		this._isofix = function(d, t){
			if(typeof d=='string'){
				
				d = d.substr(6,4) + d.substr(3,2)+d.substr(0,2);
				if (t=="") {
					t = "0000";
				}
				return d +'T'+t+'00A';
			}else{
				return d.getFullYear()+this._zp(d.getMonth()+1)+this._zp(d.getDate())+'T'+this._zp(d.getHours())+"0000A";
			  }
			}
			
		//zero padding for data fixes
		this._zp = function(s){ return ("0"+s).slice(-2); }
		
	
		// Check End Time
		
		if (timeEnd == "") {
			timeEnd = addMinutes(timeStart, 30);
		}
			
		var now = new Date();
		var ics_lines = [
		 "BEGIN:VCALENDAR",
		 "VERSION:2.0",
		 "PRODID:-//kimi-plus//iCalAdUnit//DE",

		 "BEGIN:VEVENT",
		 "UID:event-"+now.getTime()+"@kimi-plus.at",
		 "DTSTAMP:"+this._isofix(now, ""),
		 "DTSTART:"+this._isofix(dateStart, timeStart),
		 "DTEND:"+this._isofix(dateEnd, timeEnd),
		 "DESCRIPTION:"+desc,
		 "X-ALT-DESC;FMTTYPE=text/html:"+fixUmlaute(xDescription),
		 "SUMMARY:"+subject,
		 "LAST-MODIFIED:"+this._isofix(now, ""),
		 "LOCATION:"+eventLocation,
		 "SEQUENCE:0",
		 "END:VEVENT",
		 "END:VCALENDAR"
		];
		return ics_lines.join('\r\n');
   }		
	
</script>


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
    <?php 

	if (strpos(CONF_KAMPAGNE_AKT, ".".$kampId.".") == false && strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") === false  ) { ?>
        window.onload = function() {
			
		
            <?php
			//20210531/ar
			if ($telefonStarten == "A") { ?>
				document.getElementById("btnStart").click();
				<?php 
			}
			elseif ($telefonStarten != "N") { ?>
				<?php
				
				// 20200720/ab Prüfe ob Standardabfrage kommen soll
				if ( strpos(CONF_TICKETTELABFRAGE_KAMPID, ",".$kampId.",") !== false ) {
					?>
					 if (document.getElementsByName("id")[0].value != '') {
						 var r = confirm("<?php echo TXT_LBL_TICKET_HIST_START  ?>");
						 if (r == true) {
							 document.getElementById("btnStart").click();
						 } 
					 } 
					 <?php
				 }  
			}
            ?>
            <?php // 20200707 
            /*
			if (document.getElementsByName("id")[0].value != '') {
				var r = confirm("<?php echo TXT_LBL_TICKET_HIST_START ?>");
				if (r == true) {
					document.getElementById("btnStart").click();
				} 
			} else {
				document.getElementsByName("wiedervorlage_automatik")[0].value = '1';
			}*/ ?>
            //20200707/ab
			//20210318 - Prüfe ob überhaupt vorhanden
			/*
			if (document.getElementsByName("wiedervorlage_automatik")[0]) {
				document.getElementsByName("wiedervorlage_automatik")[0].value = '1';
			}
			*/
            //document.getElementsByName("wiedervorlage_automatik")[0].value = '1';
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
					
					var temp = document.getElementsByName('wiedervorlage')[0];
					if (typeof(temp) != "undefined" && temp !== null) {
					  document.getElementsByName('wiedervorlage')[0].value = data.wiedervorlage;
					}
					var temp = document.getElementsByName('wiedervorlage_zeitpunkt')[0];
					if (typeof(temp) != "undefined" && temp !== null) {
					  document.getElementsByName('wiedervorlage_zeitpunkt')[0].value = data.wiedervorlage_zeitpunkt;
					}
					var temp = document.getElementsByName('anruf_info')[0];
					if (typeof(temp) != "undefined" && temp !== null) {
					  document.getElementsByName('anruf_info')[0].value = data.anruf_info;
					}
					var temp = document.getElementsByName('letzte_wiedervorlage_info')[0];
					if (typeof(temp) != "undefined" && temp !== null) {
					  document.getElementsByName('letzte_wiedervorlage_info')[0].value = data.letzte_wiedervorlage + ' ' + data.letzte_wiedervorlage_zeitpunkt;
					}				
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
			url = "./index.php?site=ticket&ticket_id="+prev_ticket_id+"&selected_tickets="+selected_tickets+"&selected_ticket_index="+selected_ticket_index;
			window.open(url, "_self");
			return;
        });
       $("#btnNext").click(function(e) {
			next_ticket_id = document.getElementsByName("next_ticket_id")[0].value;
			selected_tickets = document.getElementsByName("selected_tickets")[0].value;
			selected_ticket_index = parseInt(document.getElementsByName("selected_ticket_index")[0].value);
			selected_ticket_index = selected_ticket_index + 1;
			url = "./index.php?site=ticket&ticket_id="+next_ticket_id+"&selected_tickets="+selected_tickets+"&selected_ticket_index="+selected_ticket_index;
			window.open(url, "_self");
			return;
        });
		
       $("#btnTelWrongNo").click(function(e) {
		   return formDoAction("OnTelWrongNo", "<?php echo App::$CURRENT->MANDANT->get_id(); ?>", "<?php echo App::$CURRENT->USER->get_id(); ?>" );
        });
       $("#btnTelNotReachable").click(function(e) {
   		   return formDoAction("OnTelNotReachable", "<?php echo App::$CURRENT->MANDANT->get_id(); ?>", "<?php echo App::$CURRENT->USER->get_id(); ?>" );
        });
        // 20201019/ab
        $("#btnTelReachable").click(function(e) {
   		   return formDoAction("OnTelReachable", "<?php echo App::$CURRENT->MANDANT->get_id(); ?>", "<?php echo App::$CURRENT->USER->get_id(); ?>" );
        });

		
       $("#callTelco1").click(function(e) {
            $this = $(this);
            e.preventDefault();
            $("#btnStart").click();

			$('#telefon_status').val('senden...');

			kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;
			kampagne_iptel_auto_vorwahl  = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;
			benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
			telNr = document.getElementsByName("telefon")[0].value;
			clientIp = document.getElementsByName("client_ip")[0].value;
			nebenstelle = document.getElementsByName("nebenstelle")[0].value;

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
					'client_ip': clientIp,
                    'nebenstelle': nebenstelle
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
                    alert(error);
					$('#telefon_status').val('Fehler');
                }
            });
        });
		
       $("#callTelco2").click(function(e) {
            $this = $(this);
            e.preventDefault();
            $("#btnStart").click();
			$('#telefon_status').val('senden...');
			kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;
			kampagne_iptel_auto_vorwahl  = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;
			benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
			telNr = document.getElementsByName("telefon2")[0].value;
			clientIp = document.getElementsByName("client_ip")[0].value;
			nebenstelle = document.getElementsByName("nebenstelle")[0].value;

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
					'client_ip': clientIp,
                    'nebenstelle': nebenstelle
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
		
       $("#callTelco3").click(function(e) {
            $this = $(this);
            e.preventDefault();
			
            $("#btnStart").click();
			$('#telefon_status').val('senden...');
			kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;
			kampagne_iptel_auto_vorwahl  = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;
			benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
			telNr = document.getElementsByName(e.target.alt)[0].value;
			clientIp = document.getElementsByName("client_ip")[0].value;
            nebenstelle = document.getElementsByName("nebenstelle")[0].value;

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
					'client_ip': clientIp,
                    'nebenstelle': nebenstelle
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
            $("#btnStart").click();
			$('#telefon_status').val('senden...');

			kampagne_iptel_destclid = document.getElementsByName("kampagne_iptel_destclid")[0].value;
			kampagne_iptel_auto_vorwahl  = document.getElementsByName("kampagne_iptel_auto_vorwahl")[0].value;
			benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
			//telNr = document.getElementsByName("telefon2")[0].value;
			telNr = $('#telefon_allg').val()
			clientIp = document.getElementsByName("client_ip")[0].value;
			nebenstelle = document.getElementsByName("nebenstelle")[0].value;

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
					'client_ip': clientIp,
                    'nebenstelle': nebenstelle
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

	// Inhalt in Zwischenablage kopieren
	function copyToClipboard(element) {
		$(document.getElementsByName(element)[0]).select();
		document.execCommand('copy');
	}
	//20210213/ab
	function setNote(typ, textfeldID, nachname, vorname) {
        var item =  document.getElementById(textfeldID);
        var kuerzel = "";
        // Benutzerkürzel erstellen
        if (vorname != "" && vorname != null) {
            kuerzel = kuerzel + vorname.substr(0,1);
        }
        if (nachname != "" && nachname != null) {
            kuerzel = kuerzel+ nachname.substr(0,1);
        }
        // Wenn Ergebnisfeld vorhanden dann Zusatzeintrag
        if (item != "undefined" && item != null ) {

            var currentDate = new Date();
            var datum = "";
            if (currentDate.getDate() < 10) {
                datum = datum + "0";
            }
            
            datum = datum + currentDate.getDate() +".";
                    
            if (currentDate.getMonth() < 9) {
                datum = datum + "0";
            }
            
        datum = datum + (currentDate.getMonth()+1) +"."+currentDate.getFullYear()+" ";

        if (currentDate.getHours() < 10) {
                datum = datum + "0";
            }
            
            datum = datum + currentDate.getHours() +".";
            if (currentDate.getMinutes() < 10) {
                datum = datum + "0";
            }
            
            datum = datum + currentDate.getMinutes() +".";

            if (currentDate.getSeconds() < 10) {
                datum = datum + "0";
            }
            datum = datum + currentDate.getSeconds();

            var zeile = datum;

            // Wenn Typ übergeben wird dieser angehängt 
            if (typ != "" && typ != null) {
                zeile = zeile + "/"+typ;
            }
            
            // Benutzerkürzel anhängen
            if (kuerzel != "" && kuerzel != null) {
                zeile = zeile + "/"+kuerzel;
            }
            zeile = zeile + ": ";
            var pos = zeile.length;
            if (item.value != "" && item.value != null) {
                zeile = zeile + "\n"+item.value;
            }
            item.value = zeile;
            // Positioniere Eingabefocus
            if (item.setSelectionRange) {
                item.setSelectionRange(pos, pos);
            }
            item.focus();
        }
    }    

</script>
<h2><table width="100%" border="0"><tr>
<td>

<?php echo TXT_LBL_TICKDETAIL; ?> (<?php echo $kamp->get_bezeichnung(); ?>)
    <?php 
		//20180529/ar  if ($kampId!=CONF_KAMPAGNE_AKT) { 
		if ( strpos(CONF_KAMPAGNE_AKT, ".".$kampId.".") == false && strpos(CONF_KAMPAGNE_TICKET_NO_TELEFON, ".".$kampId.".") === false ) { 
		?>
			
        <button id="btnStart" class="button" style="font-size:15px;" href="#"><?php echo TXT_LBL_TICKET_HIST_START ?></button>
        <button id="btnEnd" class="button" style="display: none;font-size: 15px;" href="#"><?php echo TXT_LBL_TICKET_HIST_END ?></button>
		<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;" ?>
        <button id="btnTelWrongNo" class="button" style="font-size:15px;" href="#"><?php echo "Telefonnummer falsch" ?></button>
        <button id="btnTelNotReachable" class="button" style="font-size:15px;" href="#"><?php echo "nicht erreichbar" ?></button>
        <button id="btnTelReachable" class="button" style="font-size:15px;" href="#"><?php echo "erreichbar" ?></button>
    <?php } ?>
	<?php
	if (strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") === false) {?>
	<?php echo "&nbsp;&nbsp;" ?>
        <input style="width: 170px" placeholder="Telefonnummer Direktwahl" name="telefon_allg" id="telefon_allg" class="column" type="text" value="" /> 
		<img alt="wählen" style="vertical-align: middle;" src="../images/telephone.png" id="callTelcoAllg" name="callTelcoAllg" width="20" height="20" />
        <input style="width: 70px;border:0px;background-color: transparent;color: #252525;" readonly="readonly" name="telefon_status" id="telefon_status" class="column" type="text" value="" /> 		
	</td>
	<td align="right">
        <button id="btnPrevious" title="Voriges Ticket anzeigen" class="button" style="font-size:15px;" <?php if ($prev_ticket_id=="") echo " disabled " ?> href="#"><?php echo "<" ?></button>
        <button id="btnNext" title="Nächstes Ticket anzeigen" class="button" style="font-size:15px;" <?php if ($next_ticket_id=="") echo " disabled " ?> href="#"><?php echo ">" ?></button>
	</td> <?php		
	} else {
		?>
		</td>
		<td></td><?php
	}?>

	</tr>
	</table>
</h2>

<form id="formTicket" onsubmit="return validateFormOnSave()" method="post" <?php if (!App::$CURRENT->has_permission("ticket", "UPD") || !App::$CURRENT->has_permission("ticket", "INS")) echo "disabled"; ?>>
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
	<input type="hidden" name="nebenstelle" value="<?php echo App::$CURRENT->USER->get_name() ?>" />
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

            <?php if (strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") >= 0) { ?>
                <input accesskey="S" type="submit" autofocus value="<?php echo TXT_LBL_SAVE ?>" />
            <?php } else {?>
                <input accesskey="S" type="submit" value="<?php echo TXT_LBL_SAVE ?>" />
            <?php }?>

    <?php } ?>
	<?php 
	//20180529/ar: $kampId != CONF_KAMPAGNE_AKT
	?>
    <?php if (strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") >= 0) { ?>
        <a class="button" href="./index.php?site=ticketsuch&reset=TRUE"><?php echo TXT_LBL_CANCEL ?></a>
    <?php }?>

    <?php if ($ticket_id != -1 && strpos(CONF_KAMPAGNE_AKT, ".".$kampId.".") == false && strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") === false && App::$CURRENT->has_permission("ticket", "DEL")) { ?>
        <a class="button confirm" href="./index.php?site=ticket&mode=DEL&ticket_id=<?php echo $ticket_id; ?>"><?php echo TXT_LBL_DEL ?></a>
    <?php }
    if (App::$CURRENT->has_permission("ticket", "INS") && strpos(CONF_KAMPAGNE_TICKET_NO_NEWDELETE, ".".$kampId.".") === false && App::$CURRENT->USER->get_name() !== "elsbeth" ) {
        ?>
        <a accesskey="N"  class="button" href="./index.php?site=ticket"><?php echo TXT_LBL_NEW ?></a>
    <?php } ?>
    <a> <?php echo $pageStatusInfo;?> </a>
</form>
