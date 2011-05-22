<?php
///////////////////////
//// DB Login Vars ////
///////////////////////
$dbc['host'] = "localhost"; //Database Hostname
$dbc['user'] = "frogsystem"; //Database Username
$dbc['pass'] = "frogsystem"; //Database User-Password
$dbc['data'] = "test"; //Database Name
$dbc['pref'] = "fs2_"; //Table Prefix


////////////////////////
//// Hardcoded Vars ////
////////////////////////
$spam = "wKAztWWB2Z"; //Anti-Spam Encryption-Code


///////////////////////
//// DB Connection ////
///////////////////////

// Initialize sql-class
require(FS2_ROOT_PATH . "libs/class_sql.php");

try {
    // Connect to DB-Server
    $sql = new sql($dbc['host'], $dbc['data'], $dbc['user'], $dbc['pass'], $dbc['pref']);
    $db = $sql->conn();


    /////////////////////
    //// Global Vars ////
    /////////////////////

    // General Config + Infos
    $global_config_arr = $sql->getById("global_config", "*", 1);
    $global_config_arr = array_map("stripslashes", $global_config_arr);

    //write vars into $global_config_arr
    $global_config_arr['pref'] = $dbc['pref'];
    $global_config_arr['spam'] = $spam;
    $global_config_arr['data'] = $dbc['data'];
    $global_config_arr['path'] = dirname(__FILE__) . "/";
    
    //write real home page into $global_config_arr['home_real']
    if ($global_config_arr['home'] == 1) {
        $global_config_arr['home_real'] = stripslashes($global_config_arr['home_text']);
    } else {
        $global_config_arr['home_real'] = "news";
    }
    
    //get short_language code
    $global_config_arr['language'] = (preg_match("/[a-z]{2}_[A-Z]{2}/", $global_config_arr['language_text']) === 1) ? substr($global_config_arr['language_text'], 0, 2) : $global_config_arr['language_text'];
    
    // set default style (but may be changed later)
    $global_config_arr['style'] = $global_config_arr['style_tag'];
    settype($global_config_arr['style_id'], "integer");

    // Security Funtcions for some important values
    settype($global_config_arr['search_index_update'], "integer");
    
    // get other configs
    $global_config_arr['system'] = $sql->getById("config_system", "*", 1);
   
    $global_config_arr['env']['date'] = time();
    $global_config_arr['env']['year'] = date("Y", $global_config_arr['env']['date']);
    $global_config_arr['env']['month'] = date("m", $global_config_arr['env']['date']);
    $global_config_arr['env']['day'] = date("d", $global_config_arr['env']['date']);
    $global_config_arr['env']['hour'] = date("H", $global_config_arr['env']['date']);
    $global_config_arr['env']['min'] = date("i", $global_config_arr['env']['date']);


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
unset($dbc);
unset($spam);
?>
