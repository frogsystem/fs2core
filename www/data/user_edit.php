<?php
///////////////////////////////////////////
//// Security Functions & Config Array ////
///////////////////////////////////////////
settype ( $_POST['user_id'], "integer");

$index = mysql_query ( "
    SELECT *
    FROM `".$global_config_arr['pref']."user_config`
    WHERE `id` = '1'
", $db );
$config_arr = mysql_fetch_assoc ( $index );

//////////////////////
//// Save Changes ////
//////////////////////
if (
        $_POST['user_mail']
        && $_SESSION['user_id']
        && ( $_POST['old_pwd'] == "" || ( $_POST['old_pwd'] != "" && $_POST['new_pwd'] != "" && $_POST['wdh_pwd'] != "" ) )
    ) {

    // Upload & Delete User Image
    if ( isset ( $_POST['user_delete_image'] ) ) {
        image_delete ( "media/user-images/", $_SESSION['user_id'] );
    } elseif ( $_FILES['user_image']['tmp_name'] ) {
        image_rename ( "media/user-images/", $_SESSION['user_id'], $_SESSION['user_id']."_old");
        $upload = upload_img ( $_FILES['user_image'], "media/user-images/", $_SESSION['user_id'], $config_arr['avatar_size']*1024, $config_arr['avatar_x'], $config_arr['avatar_y'] );
        $message = upload_img_notice ( $upload, FALSE )."<br>";
        if ( $upload != 0 ) {
          image_delete ( "media/user-images/", $_SESSION['user_id']."_old" );
        } else {
          image_rename ( "media/user-images/", $_SESSION['user_id']."_old", $_SESSION['user_id'] );
        }
    }

    // Update Database
    $_POST['user_show_mail'] = isset ( $_POST['user_show_mail'] ) ? 1 : 0;
    if (  trim ( $_POST['user_homepage'] ) == "http://" ) {
        $_POST['user_homepage'] = "";
    }
    if (  $_POST['user_homepage'] && substr ( $_POST['user_homepage'], 0, 7 ) != "http://" ) {
        $_POST['user_homepage'] = "http://".$_POST['user_homepage'];
    }
    
    mysql_query ( "
        UPDATE ".$global_config_arr['pref']."user
        SET `user_mail` = '".savesql ( $_POST['user_mail'] )."',
            `user_show_mail` = '".$_POST['user_show_mail']."',
            `user_homepage` = '".savesql ( $_POST['user_homepage'] )."',
            `user_icq` = '".savesql ( $_POST['user_icq'] )."',
            `user_aim` = '".savesql ( $_POST['user_aim'] )."',
            `user_wlm` = '".savesql ( $_POST['user_wlm'] )."',
            `user_yim` = '".savesql ( $_POST['user_yim'] )."',
            `user_skype` = '".savesql ( $_POST['user_skype'] )."'
        WHERE `user_id` = '".$_SESSION['user_id']."'
    ", $db);
    $message .= $TEXT->get("user_profile_updated");

    // Save New Password
    if ( $_POST['old_pwd'] && $_POST['new_pwd'] && $_POST['wdh_pwd'] ) {
        $index = mysql_query ( "
            SELECT `user_name`, `user_password`, `user_salt`
            FROM `".$global_config_arr['pref']."user`
            WHERE `user_id` = '".$_SESSION['user_id']."'
        ", $db );
        $old_password = mysql_result($index, 0, "user_password");
        $user_salt = mysql_result($index, 0, "user_salt");
        $user_name = mysql_result($index, 0, "user_name");
        
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
                mysql_query ( "
                    UPDATE ".$global_config_arr['pref']."user
                    SET `user_password` = '".$md5_password."',
                        `user_salt` = '".$new_salt."'
                    WHERE `user_id` = '".$_SESSION['user_id']."'
                ", $db);
                $message .= "<br>".$TEXT->get("user_password_changed");
                
                // Update Cookie
                if ( $_COOKIE['login'] ) {
                    set_cookie ( $user_name, $_POST['new_pwd'] );
                }
                
                // Send E-Mail
                $template_mail = get_email_template ( "signup" );
                $template_mail = str_replace ( "{..user_name..}", stripslashes ( $_SESSION['user_name'] ), $template_mail );
                $template_mail = str_replace ( "{..new_password..}", $mailpass, $template_mail );
                $template_mail = replace_globalvars ( $template_mail );
                $email_subject = $TEXT->get("mail_password_changed_on") . $global_config_arr['virtualhost'];
                if ( @send_mail ( stripslashes ( $_POST['usermail'] ), $email_subject, $template_mail ) ) {
                    $message .= "<br>".$TEXT->get("mail_new_password_sended");
                } else {
                    $message .= "<br>".$TEXT->get("mail_new_password_not_sended");
                }

            } else {
                $message .= "<br>" . $TEXT->get("user_password_change_failed") . "<br>" . $TEXT->get("user_password_change_error_new");
            }

        } else {
            $message .= "<br>" . $TEXT->get("user_password_change_failed") . "<br>" . $TEXT->get("user_password_change_error_old");
        }

    }

    // Meldung ausgeben
    $template .= forward_message ( $TEXT->get("user_profile"), $message, $_SERVER['REQUEST_URI'] );
}

//////////////////////
//// Edit Profile ////
//////////////////////
else {
    if ( $_SESSION['user_level'] == "loggedin" ) {
    
        //Error Messages
        if ( isset( $_POST['user_edit'] ) ) {
            $messages = sys_message ( $TEXT->get("systemmessage"), $TEXT->get("user_register_fulfill_form") );
        } else {
            $messages = "";
        }
        
        $index = mysql_query ( "
            SELECT *
            FROM `".$global_config_arr['pref']."user`
            WHERE `user_id` = '".$_SESSION['user_id']."'
        ", $db );

        if ( mysql_num_rows ( $index ) > 0 ) {
            $user_arr = mysql_fetch_assoc ( $index );
            
            $user_arr['user_name'] = kill_replacements ( $user_arr['user_name'], TRUE );
            $user_arr['user_image'] = ( image_exists ( "media/user-images/", $user_arr['user_id'] ) ? '<img src="'.image_url ( "media/user-images/", $user_arr['user_id'] ).'" alt="'.$TEXT->get("user_image_of")." ".$user_arr['user_name'].'">' : $TEXT->get("user_image_not_found") );
            $user_arr['user_homepage'] = ( $user_arr['user_homepage'] &&  trim ( $user_arr['user_homepage'] ) != "http://" ? kill_replacements ( $user_arr['user_homepage'], TRUE ) : "http://" );

            // Create Template
            $template = new template();

            $template->setFile ( "0_user.tpl" );
            $template->load ( "PROFILE_EDIT" );

            $template->tag ( "user_id", $user_arr['user_id'] );
            $template->tag ( "user_name", $user_arr['user_name'] );
            $template->tag ( "user_image", $user_arr['user_image'] );
            $template->tag ( "user_image_url", image_url ( "media/user-images/", $user_arr['user_id'] ) );
            $template->tag ( "image_max_width", $config_arr['avatar_x'] );
            $template->tag ( "image_max_height", $config_arr['avatar_y'] );
            $template->tag ( "image_max_size", $config_arr['avatar_size'] );
            $template->tag ( "image_limits_text", 'max. '.$config_arr['avatar_x'].' x '.$config_arr['avatar_y'].' Pixel & max. '.$config_arr['avatar_size'].' KiB' );
            $template->tag ( "user_mail", kill_replacements ( $user_arr['user_mail'], TRUE ) );
            $template->tag ( "show_mail_checked", ( $user_arr['user_show_mail'] == 1 ? " checked" : "" ) );

            $template->tag ( "user_homepage_url", $user_arr['user_homepage'] );
            $template->tag ( "user_icq", kill_replacements ( $user_arr['user_icq'], TRUE ) );
            $template->tag ( "user_aim", kill_replacements ( $user_arr['user_aim'], TRUE ) );
            $template->tag ( "user_wlm", kill_replacements ( $user_arr['user_wlm'], TRUE ) );
            $template->tag ( "user_yim", kill_replacements ( $user_arr['user_yim'], TRUE ) );
            $template->tag ( "user_skype", kill_replacements ( $user_arr['user_skype'], TRUE ) );

            $template = $messages . $template->display ();
        }
    } else { // Show Login-Page
        $_SESSION['last_url'] = "editprofil";
        include ( FS2_ROOT_PATH . "data/login.php" );
    }
}
?>