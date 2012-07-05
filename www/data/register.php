<?php
/////////////////////
//// Load Config ////
/////////////////////
$FD->loadConfig('users');
$config_arr = $FD->configObject('users')->getConfigArray();
$show_form = TRUE;


///////////////////
//// Anti-Spam ////
///////////////////
$anti_spam = check_captcha ( $_POST['captcha'], $config_arr['registration_antispam'] );

/////////////////////////////
//// Bereits Registriert ////
/////////////////////////////

if ( $_SESSION['user_id'] ) {
    $show_form = FALSE;
    $messages = forward_message ( $FD->text("frontend", "systemmessage"), $FD->text("frontend", "user_register_not_twice"), '?go='.$FD->config('home_real') );
}

//////////////////
//// Add User ////
//////////////////

elseif ( $_POST['user_name'] && $_POST['user_mail'] && $_POST['new_pwd'] && $_POST['wdh_pwd'] )
{
    $_POST['user_name'] = savesql ( $_POST['user_name'] );
    $_POST['user_mail'] = savesql ( $_POST['user_mail'] );
    $user_salt = generate_pwd ( 10 );
    $userpass = md5 ( $_POST['new_pwd'].$user_salt );
    $userpass_mail = $_POST['new_pwd'];

    // user exists or existing email negative anti spam
    $index = mysql_query ( "
                            SELECT COUNT(`user_id`) AS 'number'
                            FROM ".$FD->config('pref')."user
                            WHERE user_name = '".$_POST['user_name']."'
    ", $FD->sql()->conn() );
    $existing_users = mysql_result ( $index, 0, 'number' );
    $index = mysql_query ( "
                            SELECT COUNT(`user_id`) AS 'number'
                            FROM ".$FD->config('pref')."user
                            WHERE user_mail = '".$_POST['user_mail']."'
    ", $FD->sql()->conn() );
    $existing_mails = mysql_result ( $index, 0, 'number' );

    // get error message
    if ( $existing_users > 0 || $existing_mails > 0 || $anti_spam != TRUE || $_POST['new_pwd'] != $_POST['wdh_pwd'] ) {
        $error_array = array();
        if ( $existing_users > 0 ) {
            $error_array[] = $FD->text("frontend", "user_name_exists");
        }
        if ( $existing_mails > 0 ) {
            $error_array[] = $FD->text("frontend", "user_mail_exists");
        }
        if ( $anti_spam != TRUE ) {
            $error_array[] = $FD->text("frontend", "user_antispam");
        }
        if ( $_POST['new_pwd'] != $_POST['wdh_pwd']) {
            $error_array[] = $FD->text("frontend", "user_register_password_error");
        }
        $messages = sys_message ( $FD->text("frontend", "systemmessage"), implode ( '<br>', $error_array ) ) . '<br><br>';

        // Unset Vars
        unset ( $_POST );
    }

    // Register User
    else {
        $regdate = time();

        // Send Email
        $template_mail = get_email_template ( 'signup' );
        $template_mail = str_replace ( '{..user_name..}', stripslashes ( $_POST['user_name'] ), $template_mail );
        $template_mail = str_replace ( '{..new_password..}', $userpass_mail, $template_mail );
        $template_mail = replace_globalvars ( $template_mail );
        $email_subject = $FD->text("frontend", "mail_registerd_on") . $FD->config('virtualhost');
        if ( @send_mail ( stripslashes ( $_POST['user_mail'] ), $email_subject, $template_mail ) ) {
            $email_message = '<br>'.$FD->text("frontend", "mail_registerd_sended");
        } else {
            $email_message = '<br>'.$FD->text("frontend", "mail_registerd_not_sended");
        }

        mysql_query ( '
                        INSERT INTO
                            `'.$FD->config('pref')."user`
                            (`user_name`, `user_password`, `user_salt`, `user_mail`, `user_reg_date`)
                        VALUES (
                            '".$_POST['user_name']."',
                            '".$userpass."',
                            '".$user_salt."',
                            '".$_POST['user_mail']."',
                            '".$regdate."'
                        )
        ", $FD->sql()->conn() );

        $index = mysql_query ( 'SELECT COUNT(`user_id`) AS `user_number` FROM '.$FD->config('pref').'user', $FD->sql()->conn() );
        $new_user_num = mysql_result ( $index, 0, 'user_number' );
        mysql_query ( 'UPDATE `'.$FD->config('pref')."counter` SET `user` = '".$new_user_num."'", $FD->sql()->conn() );

        $messages = forward_message ( $FD->text("frontend", "systemmessage"), $FD->text("frontend", "user_registered").$email_message, '?go=login' );

        unset($_POST);
        $show_form = FALSE;
    }
}

//////////////////////
//// Fulfill Form ////
//////////////////////

elseif ( isset( $_POST['register'] ) ) {
    $messages = sys_message ( $FD->text("frontend", "systemmessage"), $FD->text("frontend", "user_register_fulfill_form") ) . '<br>';
}

////////////////////////////
//// Show Register Form ////
////////////////////////////

if ( $show_form == TRUE ) {
    // Get some Data
    $captcha_url = FS2_ROOT_PATH . 'resources/captcha/captcha.php?i='.generate_pwd(8);

    // Check Cpatcha Use
    if ( $config_arr['registration_antispam'] == 0 ) {
        $captcha_template = '';
        $captcha_text_template = '';
    } else {
        // Create Captcha Template
        $captcha_template = new template();

        $captcha_template->setFile ( '0_user.tpl' );
        $captcha_template->load ( 'CAPTCHA_LINE' );
        $captcha_template->tag ( 'captcha_url', $captcha_url );
        $captcha_template = $captcha_template->display ();

        // Create Captcha-Text Template
        $captcha_text_template = new template();
        $captcha_text_template->setFile ( '0_user.tpl' );
        $captcha_text_template->load ( 'CAPTCHA_TEXT' );
        $captcha_text_template = $captcha_text_template->display ();
    }

    // Create Template
    $template = new template();

    $template->setFile ( '0_user.tpl' );
    $template->load ( 'REGISTER' );

    $template->tag ( 'captcha_line', $captcha_template );
    $template->tag ( 'captcha_url', $captcha_url );
    $template->tag ( 'captcha_text', $captcha_text_template );

    $template = $template->display ();

    // Add Messages
    $template =  $messages . $template;
} else {
    $template =  $messages;
}
?>
