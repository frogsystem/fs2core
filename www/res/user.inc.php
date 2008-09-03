<?php

////////////////////////////
//// User Menü anzeigen ////
////////////////////////////

if ($_SESSION[user_level] == "loggedin")
{
    $_SESSION[user_name] = killhtml($_SESSION[user_name]);
    $template = get_template ( "user_user_menu" );
    $template = str_replace("{username}", $_SESSION[user_name], $template); 
    $template = str_replace("{logout}", "?go=logout", $template);

    // Admin-Link
    $useraction = mysql_query ("
									SELECT `user_id`, `user_is_staff`, `user_is_admin`
									FROM ".$global_config_arr['pref']."user
									WHERE `user_id` = '".$_SESSION['user_id']."'
	", $db);
	$USER_ARR = mysql_fetch_assoc ( $useraction );
    if ( $USER_ARR['user_is_staff'] == 1 || $USER_ARR['user_is_admin'] == 1 || $USER_ARR['user_id'] == 1 )
    {
          $index = mysql_query("S user_admin_link from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
          $admin_link = get_template ( "user_admin_link" );
          $template = str_replace("{admin}", $admin_link, $template);
          $template = str_replace("{adminlink}", $global_config_arr['virtualhost']."admin", $template);
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
    $index = mysql_query("select user_mini_login from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "user_mini_login"));
}
?>