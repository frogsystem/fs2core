<?php
///////////////////////////////////
//// User is already logged in ////
///////////////////////////////////
if ( $_SESSION['user_level'] == "loggedin" && $_POST['login'] == 1 ) {
    $template = forward_message ( $TEXT['frontend']->get("user_login"), $TEXT['frontend']->get("user_login_ok"), '?go='.$global_config_arr['home_real']);
} elseif ( $_SESSION['user_level'] == "loggedin" ) {
    $template = sys_message ( $TEXT['frontend']->get("user_login"), $TEXT['frontend']->get("user_login_ok") );
}

////////////////////////////
//// Display Login Form ////
////////////////////////////
else {
    // Error Messages
    switch ( $global_config_arr['login_state'] ) {
        case 2: // Wrong Password
            $error_message = $TEXT['frontend']->get("user_login_error");
            break;
        case 1: // Wrong Username
            $error_message = $TEXT['frontend']->get("user_login_error");
            break;
    }

    if ( $global_config_arr['login_state'] == 1 || $global_config_arr['login_state'] == 2 ) {
        $template = forward_message ( $TEXT['frontend']->get("user_login_error_title"), $error_message, "?go=login" );
    } else {
        $template = new template();
        $template->setFile ( "0_user.tpl" );
        $template->load ( "LOGIN" );
        $template = $template->display ();
    }
}
?>
