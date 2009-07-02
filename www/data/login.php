<?php
///////////////////////
//// User loggd in ////
///////////////////////
if ( $_SESSION['user_level'] == "loggedin" && $_POST['login'] == 1 ) {
    $template = forward_message ( "Login", $phrases['logged_in'], "?go=news" );
} elseif ( $_SESSION['user_level'] == "loggedin" ) {
    $template = sys_message ( "Login", $phrases['logged_in'] );
}

///////////////////////////
//// Create Login Form ////
///////////////////////////
else {
    switch ( $global_config_arr['login_state'] ) {
        case 2: // Wrong Password
            $error_template = sys_message ( $phrases['wrong_login_title'], $phrases['wrong_login'] );
            break;
        case 1: // Wrong Username
            $error_template = sys_message ( $phrases['wrong_login_title'], $phrases['wrong_login'] );
            break;
        default:
            $error_template = "";
            break;
    }

    $index = mysql_query("select user_login from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = $error_template . stripslashes(mysql_result($index, 0, "user_login"));
}
?>