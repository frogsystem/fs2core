<?php
///////////////////////
//// DB Login Vars ////
///////////////////////
$dbc['host'] = 'localhost'; //Database Hostname
$dbc['user'] = 'frogsystem'; //Database Username
$dbc['pass'] = 'frogsystem'; //Database User-Password
$dbc['data'] = 'fs2'; //Database Name
$dbc['pref'] = 'fs2_'; //Table Prefix

////////////////////////
//// Hardcoded Vars ////
////////////////////////
$spam = 'wKAztWWB2Z'; //Anti-Spam Encryption-Code
$path = dirname(__FILE__) . '/'; //Dateipfad
define('SLASH', TRUE);


// TODO: Pre-Import Hook

////////////////////////////////////////
//// Include important files & libs ////
////////////////////////////////////////
require_once(FS2_ROOT_PATH . 'libs/class_GlobalData.php');
require_once(FS2_ROOT_PATH . 'libs/class_lang.php');
require_once(FS2_ROOT_PATH . 'libs/class_sql.php');
require_once(FS2_ROOT_PATH . 'includes/functions.php');

///////////////////////
//// DB Connection ////
///////////////////////

// TODO: Pre-Connection Hook

try {
    // Connect to DB-Server
    $sql = new sql($dbc['host'], $dbc['data'], $dbc['user'], $dbc['pass'], $dbc['pref']);

    // Frogsystem Global Data Array
    $global_data = new GlobalData($sql);
    $FD =& $global_data; // Use shorthand $FD

    // Unset unused vars
    unset($spam, $dbc, $path);

//////////////////////////////
//// DB Connection failed ////
//////////////////////////////
} catch (Exception $e) {
	// log connection error
	error_log($e->getMessage(), 0);

    // Set header
    header(http_response_text(503), true, 503);
    header('Retry-After: '.(string)(60*15)); // 15 Minutes

    // Include lang-class
    require_once(FS2_ROOT_PATH . 'libs/class_lang.php');

    // get language
    $de = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'de');
    $en = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en');

    if ($de !== false && $de < $en)
        $TEXT['frontend'] = new lang ('de_DE', 'frontend');
    else
        $TEXT['frontend'] = new lang ('en_US', 'frontend');

    // No-Connection-Page Template
    $template = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>'.$TEXT['frontend']->get('no_connection').'</title>
    </head>
    <body>
		<p>
			<b>'.$TEXT['frontend']->get('no_connection_to_the_server').'</b>
        </p>
    </body>
</html>
    ';

    // Display No-Connection-Page
    echo $template;
    exit();
}

////////////////////////
//// Init Some Vars ////
////////////////////////

//TODO: First Init Hook

$_SESSION['user_level'] = !isset($_SESSION['user_level']) ? 'unknown' : $_SESSION['user_level'];
?>
