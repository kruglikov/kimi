<?php
header('Content-type: text/html; charset=utf-8'); 

require_once './libs/init.php';
session_name('kimiSB');
session_start();

$browser = getBrowser();

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];

    session_unset();

    $_SESSION["user"] = $user;
    $_SESSION["lang"] = $user->get_sprache();
    $mandanten = Mandant::load_mandanten($user);

    if (count($mandanten) == 1) {
        header("Location: ./index.php?mandant=" . $mandanten[0]->get_id() . "");
    }
} else {
    session_unset();
}
?>
<!DOCTYPE HTML>
<html lang="de">
    <head>
		<meta http-equiv="X-UA-Compatible" content="IE=10">
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8"> 
		
        <title>KiMi Login</title>
        <link rel="stylesheet" href="../css/theme-modern.css">
        <link rel="stylesheet" href="../css/kimi-blue-modern/jquery-ui-1.10.3.custom.css">
		
        <script src="./js/jquery.js" type="text/javascript"></script>
        <script src="./js/jquery-ui.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(window).load(function() {
                $("#login-button").click(function(e) {
                    e.preventDefault();
                    $("#wrong-credentials").hide();
                    $.ajax({
                        url: "./index.php?ajax=true&site=check-login",
                        type: "POST",
                        data: {
                            username: $("#email").val(),
                            password: $("#password").val()
                        },
                        statusCode: {
                            200: function() {
                                location.reload();
                            },
                            403: function() {
                                $("#wrong-credentials").show();
                            }
                        },
                        xhrFields: {
                            withCredentials: true
                        }
                    });
                });

                $("input[type=submit], input[type=button], button, .button").button();
                /*$("#login-container").dialog({
                 modal: true,
                 closeOnExcape: false,
                 dialogClass: 'no-close'
                 });*/

                $("#email, #password").keyup(function(e) {
                    var code = (e.keyCode ? e.keyCode : e.which);
                    if (code === 13) {
                        $("#login-button").click();
                    }
                });

                $("#email").focus();
            });
        </script>
    </head>
    <body>
        <div id="mainframe">
			<div id="header">
				<div class="bg">
					<div class="img-holder">
						<img src="../images/theme-modern/kimi-plus_logo_nav.png" />
<!--						<ul style="text-align: center;">
							<li><a href="../index.html">Homepage</a></li>
						</ul> -->
					</div>
				</div>
			</div>
			<div title="Login" id="login-container">
				<?php if (param("overrideBrowser", FALSE) || ($browser["name"] == "Internet Explorer" && $browser["version"] > 9) ||
						($browser["name"] == "Mozilla Firefox" && $browser["version"] >= 4) ||
						($browser["name"] == "Mozilla" && $browser["version"] >= 4) ||
						($browser["name"] == "Google Chrome" && $browser["version"] > 10) || 1==1 ) { ?>
					<div class="shadow" style="padding:1px 10px; border-radius: 5px">
						<?php if (!isset($user)) { ?>
							<div id="login-div">
								<span class="headlines-subtext">LOGIN (<?php echo CONF_MYSQL_DB?>)</span>
								<hr style="padding:0; margin:0;" />
								<div class="space"></div>
								<p id="wrong-credentials" class='warning hidden'>Logininformationen falsch</p>
								<table>
									<tr>
										<td>Benutzername</td>
										<td><input tabindex="1" type='text' id="email" name='email' placeholder="Benutzername" <?php if (isset($user)) echo "value=\"" . $user->get_name() . "\" disabled" ?> /></td>
									</tr>
									<tr>
										<td>Passwort</td>
										<td><input tabindex="2" type='password' id="password" name='password' placeholder="Passwort" /></td>
									</tr>
								</table>
								<div class="space"></div>
								<input tabindex="3" type="button" id="login-button" value="Login" />
								<div style="height:10px"></div>
							</div>
						<?php } else {
                                                    $user->set_default_belegdatum("");
                                                    $user->set_default_bua_bgr_key("");
                                                    Benutzer::update_default_werte($user->get_id(), NULL, NULL);
                                                }
                                                ?>
						<form <?php if (!isset($user)) echo "class=\"hidden\"" ?> action="index.php" id="mandant-form">
							<span class="headlines-subtext">MANDANTENAUSWAHL</span>
							<hr style="padding:0; margin:0;" />
							<div class="space"></div>
							<table style="text-align:left;">
								<tr>
									<td>Benutzername</td>
									<td><input type='text' id="email-after" name='email' placeholder="E-Mail Adresse" disabled value="<?php if (isset($user)) echo $user->get_name() ?>" /></td>
								</tr>
								<tr>
									<td>Mandant</td>
									<td>
										<select id="mandant" name="mandant">
											<?php
											if (isset($mandanten)) {
												foreach ($mandanten as $value) {
													?>
													<option <?php if (isset($_SESSION["mandant"]) && $_SESSION["mandant"]->get_id() == $value->get_id()) echo "selected"; ?> value="<?php echo $value->get_id(); ?>"><?php echo $value->get_text(); ?></option>
													<?php
												}
											}
											?>
										</select>
									</td>
								</tr>
							</table>
							<div class="space"></div>
							<input id="submit-btn" type="submit" value="Auswählen" />
							<div class="space"></div>
						</form>
					</div>
				<?php } else { ?>
					<div class="shadow" style="padding:1px 10px; border-radius: 5px">
						<h2>Browser nicht unterstützt</h2>
						<p>Bitte aktualisieren Sie auf einen neueren Browser.</p>
						<p>Unterstütze Browser:</p>
						<ul class="checked-list" style="padding-left: 0">
							<li><a target="_blank" href="http://windows.microsoft.com/de-at/internet-explorer/download-ie">Microsoft Internet Explorer (Ab Version 10)</a></li>
							<li><a target="_blank" href="https://www.google.com/intl/de/chrome/browser/">Google Chrome (Ab Version 11)</a></li>
							<li><a target="_blank" href="https://www.mozilla.org/en-US/firefox/all/">Mozilla Firefox (Ab Version 4)</a></li>
							<li><a target="_blank" href="http://www.opera.com/de">Opera (Aktuelle Versionen)</a></li>
						</ul>
					</div>
				<?php } ?>
			</div>
			<div class="footer shadow" style="bottom:1px">
				<div class="holder">
					<div class="left">Folge KIMI - plus auf <a href="https://www.xing.com/profiles/Franz_Tausch" target="_blank"><img src="../images/theme-modern/xing_icon.png" /></a> und <a href='https://www.facebook.com/pages/KIMI-Plus/523126284409214' target="_blank"><img src="../images/theme-modern/facebook_icon.png" /></a></div>
					<div class="right"><a href="../impressum.html" target="_blank">Impressum <img src="../images/theme-modern/impressum_icon.png" /></a></div>
					<div class="right"><a href="../datenschutz.html" target="_blank">Datenschutz</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;</div>                   
					<div class="right"><a href="../AGB_Betreiberdienstleistung.pdf" target="_blank">AGB</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;</div>                   
					<div class="center">&copy; KIMI-Plus</div>
				</div>
			</div>
		</div>
    </body>
</html>