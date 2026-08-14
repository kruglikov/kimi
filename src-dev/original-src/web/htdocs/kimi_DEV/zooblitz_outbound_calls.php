<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../css/theme-modern.css" />
        <link rel="stylesheet" href="../css/kimi-blue-modern/jquery-ui-1.10.3.custom.css" />
        <title>KiMi Telefonie - Zooblitz Outbound Anrufe</title>
        <script src="./js/jquery.js" lang="javascript"></script>
        <script src="./js/jquery-ui.js" lang="javascript"></script>
		
<script type="text/javascript">
    var closable = true;
    $(document).ready(function() {
		
       $("#callTelco").click(function(e) {
            $this = $(this);
            e.preventDefault();
			$('#telefon_status').val('');
			//var land = document.getElementById("land").value
			
			var land = $('input[name=land]:checked').val();
			
			if (land==null) {
				alert('Kein Land gewählt');
				exit;
			}
			destClId=''
			if (land=='AT') {
				destClId='0732264009';
			} else if (land=='DE') {
				// DE
				destClId='004985137956009';
			}
	
			if (destClId=='') {
				alert('Keine gültige Absendertelefonnummer für Land ' + land + ' zugeordnet!' );
				exit;
			}
			$('#telefon_status').val('senden...');
			
			//destClId = document.getElementsByName("destClId")[0].value;
			//benutzer_iptel_durchwahl = document.getElementsByName("benutzer_iptel_durchwahl")[0].value;
			telNr = document.getElementsByName("telefon")[0].value;
			
//			if (telNr=='') {
//				alert('Keine Telefonnummer eingetragen!');
//				exit;
//			}
			
			clientIp = document.getElementsByName("client_ip")[0].value;

            $.ajax({
                url: "./index.php?site=callInntelco&ajax=true",
                type: "POST",
                data: {
                    'objekt': 'callTelNo',
					'user': 'ZooblitzCall',
					'iptel_durchwahl': '',
					'kampagne_iptel_destclid': destClId,
					'kampagne_iptel_auto_vorwahl': '',
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
                    alert(error);
					$('#telefon_status').val('Fehler');
                }
            });
        });
    });
</script>
     </head>
    <body>
	
        <div id="mainframe">
            <div id="header" style="left: 0">
                <div style="width: 100%; background-image: url('../images/theme-modern/header_bg_middle.png'); background-position: bottom;">
                    <div class="img-holder">
                        <img src="../images/theme-modern/kimi-plus_logo_nav.png" />
                    </div>
                </div>
            </div>
            <div id="content-portal" style="padding-top: 130px; padding-left: 20px; padding-right: 20px;">
                <div id="notifications" title="<?php echo TXT_LBL_NOTIFICATION ?>"></div>
                <div class="container">

					<h2>Zooblitz Outbound Anrufe</h2>
					<form id="formTicket">
					<input type="hidden" name="client_ip" value="<?php echo $_SERVER['REMOTE_ADDR']  ?>" />
					
					<b>Auswahl Land:</b>
					<table width="100%" border="0">
					<tr>
					<td width="50px"></td>
						<td>
							<input type="radio" name="land" id="land_at" value="AT" /> Österreich (0732264009)
						</td>
					</tr>
					<tr>
					<td width="50px"></td>
						<td>
							<input type="radio" name="land" id="land_de" value="DE" /> Deutschland (004985137956009)
						</td>
					</tr>
					</table>
					<br>
					<b>Telefonnummer:</b>
                <input style="width: 170px" placeholder="Telefonnummer" name="telefon" class="column" type="text" value="" /> 
				<img style="vertical-align: middle;" src="../images/telephone.png" id="callTelco" name="callTelco" width="20" height="20" />
				<input style="width: 70px;border:0px;background-color: transparent;color: #252525;" readonly="readonly" name="telefon_status" id="telefon_status" class="column" type="text" value="" />
				</div>
				</form>
				</div>
			</div>
		
            <div class="footer shadow" style="bottom:1px">
                <div class="holder">
                    <div class="center">&copy; KIMI-Plus</div>
                </div>
            </div>
        </div>
    </body>
</html>
