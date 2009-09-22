<?php
///////////////////////
//// DB Login Vars ////
///////////////////////
$dbc['host'] = "localhost";                //Datebase Hostname
$dbc['user'] = "frogsystem";                //Database Username
$dbc['pass'] = "frogsystem";                //Database User-Password
$dbc['data'] = "frogsystem";                //Database Name
$dbc['pref'] = "fs_";                //Table Prefix


////////////////////////
//// Hardcoded Vars ////
////////////////////////
$spam = "QdbNFgEcn0";                //Anti-Spam Encryption-Code


///////////////////////
//// DB Connection ////
///////////////////////
@$db = mysql_connect ( $dbc['host'], $dbc['user'], $dbc['pass'] );
if ( $db && mysql_select_db ( $dbc['data'], $db ) ) {

    /////////////////////
    //// Global Vars ////
    /////////////////////

    // General Config + Infos
    $index = mysql_query ( "SELECT * FROM ".$dbc['pref']."global_config", $db );
    $global_config_arr = mysql_fetch_assoc ( $index );
    $global_config_arr = array_map ("stripslashes", $global_config_arr );

    //write $pref into $global_config_arr['pref']
    $global_config_arr['pref'] = $dbc['pref'];
    //write $spam into $global_config_arr['spam']
    $global_config_arr['spam'] = $spam;
    //write $data into $global_config_arr['data']
    $global_config_arr['data'] = $dbc['data'];
    //write systemüath into $global_config_arr['path']
    $global_config_arr['path'] = dirname(__FILE__) . "/";
    //write real home page into $global_config_arr['home_real']
    if ( $global_config_arr['home'] == 1 ) {
        $global_config_arr['home_real'] = stripslashes ( $global_config_arr['home_text'] );
    } else {
        $global_config_arr['home_real'] = "news";
    }
}


///////////////////////////////////////////////////
//// Unset Hardcoded Vars for Security Reasons ////
///////////////////////////////////////////////////
unset($dbc);
unset($spam);
?>