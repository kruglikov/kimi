<?php

function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    $ub = "UNKNOWN";

    // Next get the name of the useragent yes seperately and for good reason
    if ((preg_match('/MSIE/i', $u_agent) || preg_match('/Trident/i', $u_agent)) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    } elseif (preg_match('/Moilla/i', $u_agent)) {
        $bname = 'Mozila';
        $ub = "Mozila";
}
//echo "browser=".$u_agent." <br>";


    // finally get the correct version number
    $known = array('Version', $ub, 'other', 'rv');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ :]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ( $i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            if (count($matches["version"]) >= 2) {
                $version = $matches['version'][1];
            }
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }
    if ($bname == 'Mozilla') {
        $version = 11;
    }
//echo "Version: ".$version;
    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}
function param($name, $nullvalue = NULL) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    } else if (isset($_GET[$name])) {
        return $_GET[$name];
    }
    else if (isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    }
    return $nullvalue;
}

function sess($name, $nullvalue = NULL, $sessionprefix = "portal-") {
    if (isset($_SESSION["$sessionprefix$name"])) {
        return $_SESSION["$sessionprefix$name"];
    }
    return $nullvalue;
}

require_once './config/config.php';
session_name('kimiSB');
session_start();
if (isset($_SESSION["lang"])) {
    $lang = strtolower($_SESSION["lang"]);

    $filename = './config/lang/' . strtolower($lang) . '.php';

    if (!file_exists($filename)) {
        $filename = './config/lang/de.php';
    }
} else {
    $filename = './config/lang/de.php';
}
session_commit();

require_once $filename;

require_once './libs/database.php';
require_once './libs/application.php';
?>
