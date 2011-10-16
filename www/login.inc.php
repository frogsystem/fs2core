<?php
///////////////////////
//// DB Login Vars ////
///////////////////////
$dbc['host'] = "localhost"; //Database Hostname
$dbc['user'] = "frogsystem"; //Database Username
$dbc['pass'] = "frogsystem"; //Database User-Password
$dbc['data'] = "fs2"; //Database Name
$dbc['pref'] = "fs2_"; //Table Prefix


////////////////////////
//// Hardcoded Vars ////
////////////////////////
$spam = "wKAztWWB2Z"; //Anti-Spam Encryption-Code
$path = dirname(__FILE__) . "/"; //Dateipfad
define('SLASH', TRUE);


///////////////////////
//// DB Connection ////
///////////////////////

// Initialize sql-class 
require_once(FS2_ROOT_PATH . "libs/class_GlobalData.php");
require_once(FS2_ROOT_PATH . "libs/class_lang.php");
require_once(FS2_ROOT_PATH . "libs/class_sql.php");
require_once(FS2_ROOT_PATH . "includes/functions.php");  

try {
    // Connect to DB-Server
    $sql = new sql($dbc['host'], $dbc['data'], $dbc['user'], $dbc['pass'], $dbc['pref']);
    
    // Frogsystem Global Data Array
    $global_data = new GlobalData($sql);
    $FD =& $global_data; // Use shorthand $FD 

//////////////////////////////
//// DB Connection failed ////
//////////////////////////////
} catch (Exception $e) {
    
    // Include lang-class
    require(FS2_ROOT_PATH . "libs/class_lang.php");

    // get language
    $de = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], "de");
    $en = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], "en");

    if ($de !== false && $de < $en)
        $TEXT['frontend'] = new lang ("de_DE", "frontend");
    else
        $TEXT['frontend'] = new lang ("en_US", "frontend");

    // No-Connection-Page Template
    $template = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>'.$TEXT['frontend']->get("no_connection").'</title>
    </head>
    <body>
        <b>'.$TEXT['frontend']->get("no_connection_to_the_server").'</b>
    </body>
</html>
    ';

    // Display No-Connection-Page
    echo $template;
}


///////////////////////////////////////////////////
//// Unset Hardcoded Vars for Security Reasons ////
///////////////////////////////////////////////////
unset($spam);

////////////////////////
//// Init Some Vars ////
////////////////////////
$_SESSION['user_level'] = !isset($_SESSION['user_level']) ? "unknown" : $_SESSION['user_level'];
?>
