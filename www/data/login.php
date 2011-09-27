<?php
///////////////////////////////////
//// User is already logged in ////
///////////////////////////////////
if ( $_SESSION['user_level'] == "loggedin" && $_POST['login'] == 1 ) {
    $template = forward_message ( $TEXT['frontend']->get("user_login"), $TEXT['frontend']->get("user_login_ok"), '?go='.$global_config_arr['home_real']);
} elseif ( $_SESSION['user_level'] == "loggedin" ) {
    $template = sys_message ( $TEXT['frontend']->get("user_login"), $TEXT['frontend']->get("user_login_ok") );
}

//////////////////////////////
//// Request new password ////
//////////////////////////////
elseif (isset($_GET['newpassword']) && $_POST['login'] != 1) {
    
    // Check Mail
    if (isset($_POST['newpassword_mail'])) {
        
        // check for mail
        $user = $FD->sql()->getRow("user", array("user_id", "user_name", "user_mail"), array('W' => "`user_mail` = '".$FD->sql()->escape($_POST['newpassword_mail'])."'"));
        
        //mail found
        if (!empty($user)) {
            
            //create Hash
            $hm = new HashMapper();
            $hash = $hm->createForNewPassword($user['user_id']);
            
            // set message
            $messages = array($FD->text('frontend', "new_password_request_successful"));            
            
            // send email
            $mm = new MailManager();

            $mail_subject = $FD->text('frontend', "mail_new_password_request_on") . $FD->cfg('virtualhost');
            $content = get_email_template ("change_password_ack");
            $content = str_replace ( "{..user_name..}", $user['user_name'], $content );
            $content = str_replace ( "{..new_password_url..}", $FD->cfg('virtualhost').$hash->getURL(), $content );
            if ($mm->getHtmlConfig())
                $content = fscode($content, true, true, true);
            $content = tpl_functions($content, 0, array("VAR"));
            
            // Build Mail and send
            $mail = new Mail($mm->getDefaultSender(), $user['user_mail'], $mail_subject, $content, $mm->getHtmlConfig());
            if ($mail->send()) {
                $messages[] = $FD->text('frontend', "mail_new_password_request_sended");
            } else {
                $messages[] = $FD->text('frontend', "mail_new_password_request_not_sended");
            }
            
            // forward
            $template = sys_message($FD->text('frontend', "new_password_request"), implode("<br>", $messages));          
        }
        
        // no user found
        else {$FD->text('frontend', "new_password_user_not_found");
            $template = forward_message ( $FD->text('frontend', "new_password_user_not_found"), $FD->text('frontend', "new_password_user_not_found_text"), "?go=login&amp;newpassword" );
        }
        
        
        
    // Show Form
    } else {
        $template = new template();
        $template->setFile ( "0_user.tpl" );
        $template->load ( "NEW_PASSWORD" );
        $template = $template->display ();
    }
}

////////////////////////////
//// Display Login Form ////
////////////////////////////
else {
    // Error Messages
    switch ( $FD->cfg('login_state') ) {
        case 2: // Wrong Password
            $error_message = $TEXT['frontend']->get("user_login_error");
            break;
        case 1: // Wrong Username
            $error_message = $TEXT['frontend']->get("user_login_error");
            break;
    }

    if ( $FD->cfg('login_state') == 1 || $FD->cfg('login_state') == 2 ) {
        $template = forward_message ( $TEXT['frontend']->get("user_login_error_title"), $error_message, "?go=login" );
    } else {
        $template = new template();
        $template->setFile ( "0_user.tpl" );
        $template->load ( "LOGIN" );
        $template = $template->display ();
    }
}
?>
