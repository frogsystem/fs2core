<?php

//////////////////////////////
//// User schon eingelogt ////
//////////////////////////////

if ($_SESSION[user_level] == "loggedin")
{
    $template = forward_message ( "Login", $phrases[logged_in], "?go=news" );
}

//////////////////////////////
// Login Formular erzeugen ///
//////////////////////////////

else
{
    $index = mysql_query("select user_login from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "user_login"));
}
?>