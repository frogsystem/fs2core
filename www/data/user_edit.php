<?php
///////////////////////////////////////////
//// Security Functions & Config Array ////
///////////////////////////////////////////
settype ( $_POST['user_id'], 'integer');

$FD->loadConfig('users');
$config_arr = $FD->configObject('users')->getConfigArray();

//////////////////////
//// Save Changes ////
//////////////////////
if (
        isset($_POST['user_mail'])
        && $_SESSION['user_id']
        && ( $_POST['old_pwd'] == '' || ( $_POST['old_pwd'] != '' && $_POST['new_pwd'] != '' && $_POST['wdh_pwd'] != '' ) )
    ) {

    // Upload & Delete User Image
    if ( isset ( $_POST['user_delete_image'] ) ) {
        image_delete ( 'media/user-images/', $_SESSION['user_id'] );
    } elseif ( $_FILES['user_image']['tmp_name'] ) {
        image_rename ( 'media/user-images/', $_SESSION['user_id'], $_SESSION['user_id'].'_old');
        $upload = upload_img ( $_FILES['user_image'], 'media/user-images/', $_SESSION['user_id'], $config_arr['avatar_size']*1024, $config_arr['avatar_x'], $config_arr['avatar_y'] );
        $message = upload_img_notice ( $upload, FALSE ).'<br>';
        if ( $upload != 0 ) {
          image_delete ( 'media/user-images/', $_SESSION['user_id'].'_old' );
        } else {
          image_rename ( 'media/user-images/', $_SESSION['user_id'].'_old', $_SESSION['user_id'] );
        }
    }

    // Update Database
    $_POST['user_show_mail'] = isset ( $_POST['user_show_mail'] ) ? 1 : 0;
    if (  trim ( $_POST['user_homepage'] ) == 'http://' ) {
        $_POST['user_homepage'] = '';
    }
    if (  $_POST['user_homepage'] && substr ( $_POST['user_homepage'], 0, 7 ) != 'http://' ) {
        $_POST['user_homepage'] = 'http://'.$_POST['user_homepage'];
    }

    $stmt = $FD->sql()->conn()->prepare('
        UPDATE '.$FD->config('pref').'user
        SET `user_mail` = ?,
            `user_show_mail` = ?,
            `user_homepage` = ?,
            `user_icq` = ?,
            `user_aim` = ?,
            `user_wlm` = ?,
            `user_yim` = ?,
            `user_skype` = ?
        WHERE `user_id` = ?');
    $stmt->execute( array(
            $_POST['user_mail'],
            $_POST['user_show_mail'],
            $_POST['user_homepage'],
            $_POST['user_icq'],
            $_POST['user_aim'],
            $_POST['user_wlm'],
            $_POST['user_yim'],
            $_POST['user_skype'],
            $_SESSION['user_id'] ) );
    $message .= $FD->text('frontend', 'user_profile_updated');

    // Save New Password
    if ( $_POST['old_pwd'] && $_POST['new_pwd'] && $_POST['wdh_pwd'] ) {
        $index = $FD->sql()->conn()->query ( '
            SELECT `user_name`, `user_password`, `user_salt`
            FROM `'.$FD->config('pref')."user`
            WHERE `user_id` = '".intval($_SESSION['user_id'])."'" );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        $old_password = $row['user_password'];
        $user_salt = $row['user_salt'];
        $user_name = $row['user_name'];

        $_POST['old_pwd'] = md5 ( $_POST['old_pwd'].$user_salt );

        if ( $_POST['old_pwd'] == $old_password )
        {
            if ( $_POST['new_pwd'] == $_POST['wdh_pwd'] )
            {
                $new_salt = generate_pwd ( 10 );
                $mail_password = $_POST['new_pwd'];
                $md5_password = md5 ( $_POST['new_pwd'].$new_salt );
                unset ( $_POST['new_pwd'] );
                unset ( $_POST['wdh_pwd'] );

                // Update Password
                $FD->sql()->conn()->exec ( '
                    UPDATE '.$FD->config('pref')."user
                    SET `user_password` = '".$md5_password."',
                        `user_salt` = '".$new_salt."'
                    WHERE `user_id` = '".$_SESSION['user_id']."'" );
                $message .= '<br>'.$FD->text("frontend", "user_password_changed");

                // Update Cookie
                if ( $_COOKIE['login'] ) {
                    set_cookie ( $user_name, $_POST['new_pwd'] );
                }

                // Send E-Mail
                $template_mail = get_email_template ( 'signup' );
                $template_mail = str_replace ( '{..user_name..}', $_SESSION['user_name'], $template_mail );
                $template_mail = str_replace ( '{..new_password..}', $mailpass, $template_mail );
                $email_subject = $FD->text('frontend', 'mail_password_changed_on') .' '. $FD->config('virtualhost');
                if (send_mail($_POST['usermail'], $email_subject, $template_mail, MailManager::getHtmlConfig())) {
                    $message .= '<br>'.$FD->text("frontend", "mail_new_password_sended");
                } else {
                    $message .= '<br>'.$FD->text("frontend", "mail_new_password_not_sended");
                }

            } else {
                $message .= '<br>' . $FD->text("frontend", "user_password_change_failed") . '<br>' . $FD->text("frontend", "user_password_change_error_new");
            }

        } else {
            $message .= '<br>' . $FD->text("frontend", "user_password_change_failed") . '<br>' . $FD->text("frontend", "user_password_change_error_old");
        }

    }

    // Meldung ausgeben
    $template .= forward_message ( $FD->text("frontend", "user_profile"), $message, url('user_edit'));
}

//////////////////////
//// Edit Profile ////
//////////////////////
else {
    if ( $_SESSION['user_level'] == 'loggedin' ) {

        //Error Messages
        if ( isset( $_POST['user_edit'] ) ) {
            $messages = sys_message ( $FD->text("frontend", "systemmessage"), $FD->text("frontend", "user_register_fulfill_form") );
        } else {
            $messages = '';
        }

        $index = $FD->sql()->conn()->query ( '
            SELECT COUNT(*)
            FROM `'.$FD->config('pref')."user`
            WHERE `user_id` = '".$_SESSION['user_id']."'" );
        $num_rows = $index->fetchColumn();
        if ( $num_rows > 0 ) {
            $index = $FD->sql()->conn()->query ( '
                SELECT * FROM `'.$FD->config('pref')."user`
                WHERE `user_id` = '".$_SESSION['user_id']."'" );

            $user_arr = $index->fetch(PDO::FETCH_ASSOC);

            $user_arr['user_name'] = kill_replacements ( $user_arr['user_name'], TRUE );
            $user_arr['user_image'] = ( image_exists ( 'media/user-images/', $user_arr['user_id'] ) ? '<img src="'.image_url ( 'media/user-images/', $user_arr['user_id'] ).'" alt="'.$FD->text("frontend", "user_image_of").' '.$user_arr['user_name'].'">' : $FD->text("frontend", "user_image_not_found") );
            $user_arr['user_homepage'] = ( $user_arr['user_homepage'] &&  trim ( $user_arr['user_homepage'] ) != 'http://' ? kill_replacements ( $user_arr['user_homepage'], TRUE ) : 'http://' );

            // Create Template
            $template = new template();

            $template->setFile ( '0_user.tpl' );
            $template->load ( 'PROFILE_EDIT' );

            $template->tag ( 'user_id', $user_arr['user_id'] );
            $template->tag ( 'user_name', $user_arr['user_name'] );
            $template->tag ( 'user_image', $user_arr['user_image'] );
            $template->tag ( 'user_image_url', image_url ( 'media/user-images/', $user_arr['user_id'] ) );
            $template->tag ( 'image_max_width', $config_arr['avatar_x'] );
            $template->tag ( 'image_max_height', $config_arr['avatar_y'] );
            $template->tag ( 'image_max_size', $config_arr['avatar_size'] );
            $template->tag ( 'image_limits_text', 'max. '.$config_arr['avatar_x'].' x '.$config_arr['avatar_y'].' Pixel & max. '.$config_arr['avatar_size'].' KiB' );
            $template->tag ( 'user_mail', kill_replacements ( $user_arr['user_mail'], TRUE ) );
            $template->tag ( 'show_mail_checked', ( $user_arr['user_show_mail'] == 1 ? ' checked' : '' ) );

            $template->tag ( 'user_homepage_url', $user_arr['user_homepage'] );
            $template->tag ( 'user_icq', kill_replacements ( $user_arr['user_icq'], TRUE ) );
            $template->tag ( 'user_aim', kill_replacements ( $user_arr['user_aim'], TRUE ) );
            $template->tag ( 'user_wlm', kill_replacements ( $user_arr['user_wlm'], TRUE ) );
            $template->tag ( 'user_yim', kill_replacements ( $user_arr['user_yim'], TRUE ) );
            $template->tag ( 'user_skype', kill_replacements ( $user_arr['user_skype'], TRUE ) );

            $template = $messages . $template->display ();
        }
    } else { // Show Login-Page
        $_SESSION['last_url'] = 'editprofil';
        include ( FS2_ROOT_PATH . 'data/login.php' );
    }
}
?>
