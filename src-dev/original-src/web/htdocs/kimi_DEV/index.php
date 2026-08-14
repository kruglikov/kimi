<?php
error_reporting(E_ALL);

include_once './libs/init.php';
session_name('kimiSB');
session_start();


$_SESSION["autoLogin"] = false;
if (param('autologin',FALSE) ) {
    $_SESSION["autoLogin"] = true;
    $user = User::getFromName(param('loginuser', ""));

    $_SESSION["user"] = $user;
    $mandant = Mandant::get(param('mandant', ""));
    $_SESSION["mandant"] = $mandant;
    $_SESSION["kampId"]=param('kId',"");
    
}

if (isset($_SESSION["user"])) {
    App::$CURRENT->USER = $_SESSION["user"];
}


if (param('ajax', FALSE)) {
	
	App::$CURRENT->MANDANT = $_SESSION["mandant"];
    $module = param("site");
	
    if (file_exists('./ajax/' . $module . '.php')) {
        require_once './ajax/' . $module . '.php';
    } else {
        header("HTTP/1.0 404 Not Found");
    }
    exit;
}

//20210530/ab
$IgnoreHeader = FALSE;
if (param('noHeader', FALSE) === 'true') {
	$IgnoreHeader = TRUE;
}

$telefonStarten= "X";
if (param('telefonStarten', "X") != 'X') {
	$telefonStarten = param('telefonStarten', "X");
}


if (param("site", FALSE)) {
    if (file_exists('./modules/gui/' . param("site") . '.php')) {
        $module = param("site");
    } else {
        $module = "404";
    }
} else {
    $module = "portal";
}

if (isset($_SESSION["user"])) {
    App::$CURRENT->USER = $_SESSION["user"];
} else {
    header("Location: ./login.php");
}

if (param("mandant", FALSE)) {
    $_SESSION["mandant"] = Mandant::get(param("mandant"));
} else if (!isset($_SESSION["mandant"]) || $_SESSION["mandant"] == NULL) {
    header("Location: ./login.php");
    
    exit;
}
App::$CURRENT->MANDANT = $_SESSION["mandant"];


if (!$_SESSION["autoLogin"] &&  !App::$CURRENT->has_permission($module, "*") && $module != "np") {
    header("Location: ./index.php?site=np");
    
}
if (file_exists('./modules/initial/' . $module . '.php')) {
    require_once './modules/initial/' . $module . '.php';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=10">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../css/theme-modern.css" />
        <link rel="stylesheet" href="../css/kimi-blue-modern/jquery-ui-1.10.3.custom.css" />
        <title>KiMi Portal</title>
        <script src="./js/jquery.js" lang="javascript"></script>
        <script src="./js/jquery-ui.js" lang="javascript"></script>
        <script lang="javascript">
            $(window).load(function() {
                $(document).on("click", ".confirm", function() {
                    if (!confirm("<?php echo MSG_CONF_DELETE ?>")) {
                        return false;
                    }
                    return true;
                });

                $not = $("#notifications");
                $err = $("#errors");
                $inf = $("#infos");

                $not.append($err);
                $not.append($inf);
                $not.css("margin-top", "20px");

                $("input[type=submit], button, .button").button();
                $(".buttongroup").buttonset();

                $(".button-left").button({
                    icons: {
                        primary: "ui-icon-carat-1-w"
                    },
                    text: false
                });
                $(".button-right").button({
                    icons: {
                        primary: "ui-icon-carat-1-e"
                    },
                    text: false
                });
                $(".buttonset").buttonset();
                $("input[type=date]").datepicker({
                    dateFormat: "dd.mm.yy"
                });
                $(".disabled").button("disable");

                $('input[type="date"]').prop('type', 'text');
		
                $(".close ").click(function(e) {
                    e.preventDefault();
                    $(this).parent().slideUp(200);
                });
            });
        </script>
        <script type="text/javascript">
            function AskDelete() {
                return confirm('<?php echo TXT_LBL_CONFIRM_DELETE ?>');
            }
        </script>
		
		<script>
			$(document).ready(function(){
				/* Hier der jQuery-Code */
				$('#clickMandant').click(function(){
					if ( document.getElementById('changeMandantClick').value == "0" ) {
						$(this).parent().find("ul.login-extend").slideDown(200);
						$(this).css("border", "1px solid #999");
						document.getElementById('changeMandantClick').value = "1";
					} else {
						$(this).parent().find("ul.login-extend").slideUp(200);
                        $(this).css("border", "1px solid transparent");
						document.getElementById('changeMandantClick').value = "0";
					}
				});
			});
		</script>
		
	
    </head>
    <body>
        <div id="mainframe">
		<input type="hidden" id="changeMandantClick" value="0" />
        <input type="hidden" id="loginUserName" value="<?php echo App::$CURRENT->USER->get_name()?>" />
		<?php
		if ($IgnoreHeader == FALSE) { ?>
            <div id="header" style="left: 0">
                <div style="width: 100%; background-image: url('../images/theme-modern/header_bg_middle.png'); background-position: bottom;">
                    <div class="img-holder">
                        <img src="../images/theme-modern/kimi-plus_logo_nav.png" width="130px" />
                        <ul style="padding-bottom: 10px;">
                            <li><a href="./index.php"><?php echo TXT_LBL_PORTAL ?></a></li>
                            <?php
                            $menu = array();
                            $menu_filename = './modules/menu/' . $module . '.php';

                            if (file_exists($menu_filename)) {
                                include $menu_filename;

                                foreach ($menu as $item) {
                                    ?>
                                    <li>|</li>
                                    <li><a href="<?php echo $item->get_link(); ?>"><?php echo $item->get_text() ?></a></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div id="clickMandant"  class="login-men" style="background-color: white;  border:1px solid transparent; padding: 5px; cursor:default; position: absolute; right: 10px; width: 150px; top: 0px; line-height: 16px">
                    <div class="bold">Hallo <?php
                        if (App::$CURRENT->USER->get_vorname() != "" && App::$CURRENT->USER->get_nachname() != "") {
                            echo App::$CURRENT->USER->get_vorname() . " " . App::$CURRENT->USER->get_nachname();
                        } else {
                            echo App::$CURRENT->USER->get_name();
                        }
                        ?>
                    </div>
                    <div>
                        <i><?php echo App::$CURRENT->MANDANT->get_text()." (".CONF_MYSQL_DB.")"; ?></i>
                    </div>
                    <ul class="login-extend hidden clear" style="background-color: white; width: 150px;margin-top: 2px;margin-left:0px;">
                        <li><a href="./login.php"><img style="height: 12px; line-height: 40px;" src="../images/theme-modern/user_icon.png" /> <?php echo TXT_LBL_CHANGE_MANDANT; ?></a></li>
                        <li><a href="index.php?site=logout"><img style="height: 10px; line-height: 40px;" src="../images/theme-modern/logout_icon.png" /> <?php echo TXT_LBL_LOGOUT ?></a></li>
                    </ul>
                    <table class="hidden">
                        <tr>
                            <td><?php echo TXT_LBL_CUR_USR ?></td>
                            <td><?php
                                if (App::$CURRENT->USER->get_vorname() != "" && App::$CURRENT->USER->get_nachname() != "") {
                                    echo App::$CURRENT->USER->get_vorname() . " " . App::$CURRENT->USER->get_nachname();
                                } else {
                                    echo App::$CURRENT->USER->get_name();
                                }
                                ?> 
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><?php echo TXT_LBL_CUR_MAN ?></td>
                            <td><a href="./login.php"><?php echo App::$CURRENT->MANDANT->get_text(); ?></a></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
			<div id="content-portal" style="padding-top: 60px; padding-left: 20px; padding-right: 20px;">
		<?php } else { ?>
            <div id="content-portal" style="padding-top: 10px; padding-left: 20px; padding-right: 20px;">
		<?php } ?>
                <div id="notifications" title="<?php echo TXT_LBL_NOTIFICATION ?>"></div>
				<?php if ($IgnoreHeader == FALSE) { ?>
                <div class="container">
				<?php } else { ?>
				<div style="padding-bottom: 20px;">
				<?php } ?>
                    <?php include './modules/gui/' . $module . '.php'; ?>

                    <?php if (count(App::$CURRENT->ERRORS) > 0) { ?>
                        <div id="errors" class="ui-state-error shadow" style="position: absolute; z-index:999; left: 0; padding-left: 100px; top: 150px; right: 0">
                            <?php
                            foreach (App::$CURRENT->ERRORS as $val) {
                                echo "$val<br />";
                            }
                            ?>
                            <a style="color:black" href="#" class="close"><?php echo TXT_LBL_CLOSE ?></a>
                        </div>
                    <?php } ?>

                    <?php if (count(App::$CURRENT->INFORMATION) > 0) { ?>
                        <div id="infos" class="ui-state-highlight shadow" style="height: 25px;position: absolute; left: 1px; padding-left: 25px; top: 133px; right: 0">
                            <?php
							$n = 0;
                            foreach (App::$CURRENT->INFORMATION as $val) {
								if ($n > 0) {
									echo ", ";
								};
								$n = $n + 1;
                                echo "$val";
                            }
							echo "&nbsp;&nbsp;&nbsp;";
                            ?>
                            <a style="color:black;text-decoration: underline" href="#" class="close"><?php echo TXT_LBL_CLOSE ?></a>
                        </div>
                    <?php } ?>                    
                </div>
            </div>
			<?php if ($IgnoreHeader == FALSE) { ?> 
            <div class="footer shadow" style="bottom:1px">
                <div class="holder">
                    <div class="left">Folge KIMI - plus auf <a href="https://www.xing.com/profiles/Franz_Tausch" target="_blank"><img src="../images/theme-modern/xing_icon.png" /></a> und <a href='https://www.facebook.com/pages/KIMI-Plus/523126284409214' target="_blank"><img src="../images/theme-modern/facebook_icon.png" /></a></div>
                    <div class="right"><a href="../impressum.html" target="_blank">Impressum <img src="../images/theme-modern/impressum_icon.png" /></a></div>
                    <div class="right"><a href="../datenschutz.html" target="_blank">Datenschutz</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;</div>                   
                    <div class="right"><a href="../AGB_Betreiberdienstleistung.pdf" target="_blank">AGB</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;</div>                   
                    <div class="center">&copy; KIMI-Plus</div>
                </div>
            </div>
			<?php } ?>
        </div>
    </body>
</html>
