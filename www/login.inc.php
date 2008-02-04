<?php
///////////////////////
//// DB Login Data ////
///////////////////////
$host = "localhost";                //Hostname
$user = "frogsystem";                        //Database User
$data = "frogsystem";                //Database Name
$pass = "frogsystem";                //Password
$pref = "fs_";                //Password


//////////////////////////
//// Andere Variablen ////
//////////////////////////
$spam = "QdbNFgEcn0";                //Anti-Spam Verschlüssungs-Code


////////////////////////
////// DB Connect //////
////////////////////////
@$db = mysql_connect ( $host, $user, $pass );
if ( $db && mysql_select_db ( $data, $db ) ) {

    ////////////////////////
    //// Seitenvariablen ///
    ////////////////////////

    // Allgemeine Config + Infos
    $index = mysql_query ( "SELECT * FROM ".$pref."global_config", $db );
    $global_config_arr = mysql_fetch_assoc ( $index );

    //write $pref into $global_config_arr['pref']
    $global_config_arr['pref'] = $pref;
    //write $spam into $global_config_arr['spam']
    $global_config_arr['spam'] = $spam;

}

unset($host);
unset($user);
unset($pass);
unset($pref);
unset($spam);
?>