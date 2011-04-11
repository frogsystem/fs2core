<?php
///////////////////////
//// DB Login Vars ////
///////////////////////
$dbc['host'] = ""; //Database Hostname
$dbc['user'] = ""; //Database Username
$dbc['pass'] = ""; //Database User-Password
$dbc['data'] = ""; //Database Name
$dbc['pref'] = ""; //Table Prefix


////////////////////////
//// Hardcoded Vars ////
////////////////////////
$spam = ""; //Anti-Spam Encryption-Code


///////////////////////
//// DB Connection ////
///////////////////////
@$db = mysql_connect ( $dbc['host'], $dbc['user'], $dbc['pass'] );
if ( $db !== FALSE && mysql_select_db ( $dbc['data'], $db ) ) {

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
    //get short_language code
    $global_config_arr['language'] = ( preg_match ( "/[a-z]{2}_[A-Z]{2}/", $global_config_arr['language_text'] ) === 1 ) ? substr ( $global_config_arr['language_text'], 0, 2 ) : $global_config_arr['language_text'];
    // set style (but may be changed later)
    $global_config_arr['style'] = $global_config_arr['style_tag'];
    settype ( $global_config_arr['style_id'], "integer" );

    // Security Funtcions for some important values
    settype ( $global_config_arr['search_index_update'], "integer" );
}


///////////////////////////////////////////////////
//// Unset Hardcoded Vars for Security Reasons ////
///////////////////////////////////////////////////
unset($dbc);
unset($spam);
?>