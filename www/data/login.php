<?php

//////////////////////////////
//// User schon eingelogt ////
//////////////////////////////

if ($_SESSION[user_level] == "loggedin")
{
    $template = sys_message("Login<br>", $phrases[logged_in]);
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