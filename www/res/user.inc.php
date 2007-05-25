<?php

////////////////////////////
//// User Menü anzeigen ////
////////////////////////////

if ($_SESSION[user_level] == "loggedin")
{
    $_SESSION[user_name] = killhtml($_SESSION[user_name]);
    $index = mysql_query("select user_user_menu from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "user_user_menu"));
    $template = str_replace("{username}", $_SESSION[user_name], $template); 

    // Admin-Link
    $isadmin = mysql_query("select is_admin from fs_user where user_id = '$_SESSION[user_id]'", $db);
    if (mysql_result($isadmin, 0, "is_admin") == 1)
    {
          $index = mysql_query("select user_admin_link from fs_template where id = '$global_config_arr[design]'", $db);
          $admin_link = stripslashes(mysql_result($index, 0, "user_admin_link"));
          $template = str_replace("{admin}", $admin_link, $template);
    }
    else
    {
    $template = str_replace("{admin}", "", $template);
    }
    $template = str_replace("{virtualhost}", $global_config_arr[virtualhost], $template);
}

////////////////////////////
//// Loginfeld anzeigen ////
////////////////////////////

else
{
    $index = mysql_query("select user_mini_login from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "user_mini_login"));
}
?>