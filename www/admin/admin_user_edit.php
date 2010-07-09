<?php
///////////////////
//// Functions ////
///////////////////

function user_name_free_or_itself ( $USERNAME, $USER_ID ) {
    global $global_config_arr;
    global $db;

    $USER_ID = savesql ( $USER_ID );
    $USERNAME = savesql ( $USERNAME );
    $index = mysql_query ( "
                            SELECT `user_id`
                            FROM `".$global_config_arr['pref']."user`
                            WHERE `user_name` = '".$USERNAME."'
                            LIMIT 0,1
    ", $db );
    if ( mysql_num_rows ( $index ) > 0 && $USER_ID != mysql_result ( $index, 0, "user_id" ) ) {
        return FALSE;
    } else {
        return TRUE;
    }
}

/////////////////////
//// Load Config ////
/////////////////////
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."user_config WHERE `id` = '1'", $db );
$config_arr = mysql_fetch_assoc ( $index );


/////////////////////
//// update user ////
/////////////////////

if (

        isset ( $_POST['sended'] ) && $_POST['sended'] == "edit"
        && isset ( $_POST['user_action'] ) && $_POST['user_action'] == "edit"
        && isset ( $_POST['user_id'] ) && $_POST['user_id'] != 1 && $_POST['user_id'] != $_SESSION['user_id']

        && $_POST['user_name'] && $_POST['user_name'] != "" && user_name_free_or_itself ( $_POST['user_name'], $_POST['user_id'] ) == TRUE
        && $_POST['user_mail'] && $_POST['user_mail'] != ""
        && ( ( (
            ( $_POST['newpwd'] && $_POST['newpwd'] != "" && $_POST['wdhpwd'] && $_POST['wdhpwd'] != "" && $_POST['newpwd'] == $_POST['wdhpwd'] )
            || $_POST['gen_password'] == 1
        ) && $_POST['new_password'] == 1 ) || $_POST['new_password'] == 0 )
        && $_POST['d'] && $_POST['d'] > 0 && $_POST['d'] <= 31
        && $_POST['m'] && $_POST['m'] > 0 && $_POST['m'] <= 12
        && $_POST['y'] && $_POST['y'] >= 0
    )
{
    // security functions
    $_POST['user_id'] = savesql ( $_POST['user_id'] );
    $_POST['user_name'] = savesql ( $_POST['user_name'] );
    $_POST['user_mail'] = savesql ( $_POST['user_mail'] );
    $_POST['user_homepage'] = savesql ( $_POST['user_homepage'] );
    $_POST['user_icq'] = savesql ( $_POST['user_icq'] );
    $_POST['user_aim'] = savesql ( $_POST['user_aim'] );
    $_POST['user_wlm'] = savesql ( $_POST['user_wlm'] );
    $_POST['user_yim'] = savesql ( $_POST['user_yim'] );
    $_POST['user_skype'] = savesql ( $_POST['user_skype'] );

    settype ( $_POST['gen_password'], "integer" );
    settype ( $_POST['mail_password'], "integer" );
    settype ( $_POST['user_is_staff'], "integer" );
    settype ( $_POST['user_show_mail'], "integer" );

    // get other data
    $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'], 0, 0, 0 );
    $user_date = mktime ( 0, 0, 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );

    if ( $_POST['user_group'] == "admin" && $_POST['user_is_staff'] == 1 ) {
        $_POST['user_group'] = 0;
        $_POST['user_is_admin'] = 1;
    } else {
        $_POST['user_is_admin'] = 0;
    }
    settype($_POST['user_group'], 'integer');

    if ( $_POST['user_is_staff'] == 0 ) {
        $_POST['user_group'] = 0;
        $_POST['user_is_admin'] = 0;
    }

    if ( $_POST['user_homepage'] == "http://" ) {
        $_POST['user_homepage'] = "";
    }

    if ( $_POST['new_password'] == 1 && $_POST['gen_password'] == 1 ) {
        $_POST['newpwd'] = generate_pwd ( 15 );
    }
    $user_salt = generate_pwd ( 10 );
    $pw_update = "
                        `user_password` = '".md5 ( $_POST['newpwd'].$user_salt )."',
                        `user_salt` = '".$user_salt."',
    ";
    if ( $_POST['new_password'] != 1 ) {
        $pw_update = "";
    }

    $index = mysql_query ( "
                            SELECT `user_is_staff`, `user_is_admin`
                            FROM ".$global_config_arr['pref']."user
                            WHERE `user_id` = '".$_POST['user_id']."'
                            LIMIT 0,1
    ", $db);
    $was_staff = mysql_result ( $index, 0, "user_is_staff" );
    $was_admin = mysql_result ( $index, 0, "user_is_admin" );

    // user is not longer in staff
    if ( $was_staff == 1 && $_POST['user_is_staff'] == 0 ) {
        mysql_query ("
                        DELETE
                        FROM ".$global_config_arr['pref']."user_permissions
                        WHERE `perm_for_group` = '0'
                        AND `x_id` = '".$_POST['user_id']."'
        ", $db );
    }

    // MySQL-Queries
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."user`
                    SET
                        `user_name` = '".$_POST['user_name']."',
                        ".$pw_update."
                        `user_mail` = '".$_POST['user_mail']."',
                        `user_is_staff` = '".$_POST['user_is_staff']."',
                        `user_group` = '".$_POST['user_group']."',
                        `user_is_admin` = '".$_POST['user_is_admin']."',
                        `user_reg_date` = '".$user_date."',
                        `user_show_mail` = '".$_POST['user_show_mail']."',
                        `user_homepage` = '".$_POST['user_homepage']."',
                        `user_icq` = '".$_POST['user_icq']."',
                        `user_aim` = '".$_POST['user_aim']."',
                        `user_wlm` = '".$_POST['user_wlm']."',
                        `user_yim` = '".$_POST['user_yim']."',
                        `user_skype` = '".$_POST['user_skype']."'
                    WHERE `user_id` = '".$_POST['user_id']."'
    ", $db );
    $messages = array ( $TEXT["admin"]->get("changes_saved") );

    // image operations
    if ( $_POST['user_pic_delete'] == 1 ) {
        if ( image_delete ( "images/avatare/", $_POST['user_id'] ) ) {
            $messages[] = $admin_phrases[common][image_deleted];
        } else {
            $messages[] = $admin_phrases[common][image_not_deleted];
        }
    } elseif ( $_FILES['user_pic']['name'] != "" ) {
        $upload = upload_img ( $_FILES['user_pic'], "images/avatare/", $_POST['user_id'], $config_arr['avatar_size']*1024, $config_arr['avatar_x'], $config_arr['avatar_y'] );
        $messages[] = upload_img_notice ( $upload );
    }

    if ( $_POST['new_password'] == 1 && $_POST['mail_password'] == 1 ) {
        // send email
        $template_mail = get_email_template ( "change_password" );
        $template_mail = str_replace ( "{..user_name..}", stripslashes ( $_POST['user_name'] ), $template_mail );
        $template_mail = str_replace ( "{..new_password..}", $_POST['newpwd'], $template_mail );
        $template_mail = replace_globalvars ( $template_mail );
        $email_subject = $TEXT['frontend']->get("mail_password_changed_on") . $global_config_arr['virtualhost'];
        if ( @send_mail ( stripslashes ( $_POST['user_mail'] ), $email_subject, $template_mail ) ) {
            $messages[] = $TEXT['frontend']->get("mail_new_password_sended");
        } else {
            $messages[] = $TEXT['frontend']->get("mail_new_password_not_sended");
        }
    }

    // Display Message
    systext ( implode ( "<br>", $messages ),
        $TEXT["admin"]->get("info"), FALSE, $TEXT["admin"]->get("icon_save_ok") );

    // save Vars
    $filter = $_POST['filter'];

    // Unset Vars
    unset ( $_POST );

    // rewrite Vars
    $_POST['filter'] = $filter;
    $_POST['search'] = 1;
}

// delete user
elseif (
        isset ( $_POST['sended'] ) && $_POST['sended'] == "delete"
        && isset ( $_POST['user_action'] ) && $_POST['user_action'] == "delete"
        && isset ( $_POST['user_id'] ) && $_POST['user_id'] != 1 && $_POST['user_id'] != $_SESSION['user_id']
        && isset ( $_POST['user_delete'] )
    )
{
    if ( $_POST['user_delete'] == 1 ) {
        // Security-Functions
        settype ( $_POST['user_id'], "integer" );

        // get data from db
        $index = mysql_query ( "
                                SELECT `user_name`
                                FROM ".$global_config_arr['pref']."user
                                WHERE `user_id` = '".$_POST['user_id']."'
                                LIMIT 0,1
        ", $db );
        $user_arr = mysql_fetch_assoc ( $index );

        // Delete Permissions
        mysql_query ( "
                        DELETE
                        FROM ".$global_config_arr['pref']."user_permissions
                        WHERE `perm_for_group` = '0'
                        AND `x_id` = '".$_POST['user_id']."'
        ", $db );
        
        // update stats
        mysql_query ( "
                        UPDATE ".$global_config_arr['pref']."counter
                        SET `user` = `user`-1
        ", $db );
        
        // update groups
        mysql_query ( "
                        UPDATE ".$global_config_arr['pref']."user_groups
                        SET `user_group_user` = '1'
                        WHERE `user_group_user` = '".$_POST['user_id']."'
        ", $db );
        
        // update articles
        mysql_query ( "
                        UPDATE ".$global_config_arr['pref']."articles
                        SET `article_user` = '0'
                        WHERE `article_user` = '".$_POST['user_id']."'
        ", $db );
        
        // update articles_cat
        mysql_query ( "
                        UPDATE ".$global_config_arr['pref']."articles_cat
                        SET `cat_user` = '1'
                        WHERE `cat_user` = '".$_POST['user_id']."'
        ", $db );

        // update dl
        mysql_query ( "
                        UPDATE ".$global_config_arr['pref']."dl
                        SET `user_id` = '1'
                        WHERE `user_id` = '".$_POST['user_id']."'
        ", $db );

        // update news
        mysql_query ( "
                        UPDATE ".$global_config_arr['pref']."news
                        SET `user_id` = '1'
                        WHERE `user_id` = '".$_POST['user_id']."'
        ", $db );

        // update news_cat
        mysql_query ( "
                        UPDATE ".$global_config_arr['pref']."news_cat
                        SET `cat_user` = '1'
                        WHERE `cat_user` = '".$_POST['user_id']."'
        ", $db );

        // update news_comments
        mysql_query ( "
                        UPDATE ".$global_config_arr['pref']."news_comments
                        SET `comment_poster_id` = '0',
                            `comment_poster` = '".$user_arr['user_name']."'
                        WHERE `comment_poster_id` = '".$_POST['user_id']."'
        ", $db );

        // MySQL-Delete-Query
        mysql_query ("
                        DELETE FROM ".$global_config_arr['pref']."user
                         WHERE user_id = '".$_POST['user_id']."'
        ", $db );
        $message = "Benutzer wurde erfolgreich gelöscht";

        // Delete Image
        if ( image_delete ( "images/avatare/", $_POST['user_id'] ) ) {
            $message .= "<br>" . $admin_phrases[common][image_deleted];
        }
    } else {
        $message = "Benutzer wurde nicht gelöscht";
    }

    // Display Message
    systext ( $message, $admin_phrases[common][info] );

    // save Vars
    $filter = $_POST['filter'];

    // Unset Vars
    unset ( $_POST );
    
    // rewrite Vars
    $_POST['filter'] = $filter;
    $_POST['search'] = 1;
}



//////////////////////
//// Display Form ////
//////////////////////

if (  isset ( $_POST['user_id'] ) && is_array ( $_POST['user_id'] ) &&  $_POST['user_action'] )
{
    // security functions
    $_POST['user_id'] = array_map ( "intval", $_POST['user_id'] );

    // Edit user
    if ( $_POST['user_action'] == "edit" && count ( $_POST['user_id'] ) == 1 )
    {
        $_POST['user_id'] = $_POST['user_id'][0];

        // Display Error Messages
        if ( $_POST['sended'] == "edit" ) {
            if ( $_POST['user_id'] == 1 ) {
                $message[] = "Der Super-Administrator kann nicht bearbeitet werden";
            }
            if ( $_POST['user_id'] == $_SESSION['user_id'] ) {
                $message[] = "Sie können sich nicht selbst bearbeiten";
            }
            if ( user_name_free_or_itself ( $_POST['user_name'], $_POST['user_id'] ) == FALSE ) {
                $message[] = "Der angegebene Benutzername existiert bereits";
            }
            if ( $_POST['newpwd'] != $_POST['wdhpwd'] && $_POST['gen_password'] != 1 && $_POST['new_password'] == 1 ) {
                $message[] = "Das Passwort muss zweimal identisch eingegeben werden";
            }
            $message = implode ( "<br>", $message );
            if ( strlen ( $message ) == 0 ) {
                $message = $admin_phrases[common][note_notfilled];
            }
            systext ( $message, $admin_phrases[common][error], TRUE );
        } else {
            $index = mysql_query ( "
                                    SELECT *
                                    FROM ".$global_config_arr['pref']."user
                                    WHERE `user_id` = '".$_POST['user_id']."'
                                    LIMIT 0,1
            ", $db );
            $user_arr = mysql_fetch_assoc ( $index );
            putintopost ( $user_arr );
            $_POST['d'] = date ( "d", $_POST['user_reg_date'] );
            $_POST['m'] = date ( "m", $_POST['user_reg_date'] );
            $_POST['y'] = date ( "Y", $_POST['user_reg_date'] );
            $_POST['new_password'] = 0;
            $_POST['gen_password'] = 1;
            $_POST['mail_password'] = 1;
            if ( $_POST['user_homepage'] == "" ) {
                $_POST['user_homepage'] = "http://";
            }
            if ( $user_arr['user_is_admin'] == 1 ) {
                $_POST['user_group'] = "admin";
            }
        }
        
        // get other data
        if ( $_POST['user_is_staff'] == 1 ) {
            $display_arr['group_tr'] = "default";
        } else {
            $display_arr['group_tr'] = "hidden";
        }

        if ( $_POST['new_password'] == 1 ) {
            $display_arr['pwd_tr'] = "default";
            $display_arr['pwd_gen_tr'] = "default";
            $display_arr['pwd_mail_tr'] = "default";
        } else {
            $display_arr['pwd_tr'] = "hidden";
            $display_arr['pwd_gen_tr'] = "hidden";
            $display_arr['pwd_mail_tr'] = "hidden";
        }

        if ( $_POST['gen_password'] == 1 ) {
            $display_arr['pwd_tr'] = "hidden";
        } else {
            $display_arr['pwd_tr'] = "default";
        }

        // security functions
        $_POST['user_name'] = killhtml ( $_POST['user_name'] );
        $_POST['user_mail'] = killhtml ( $_POST['user_mail'] );
        $_POST['newpwd'] = killhtml ( $_POST['newpwd'] );
        $_POST['wdhpwd'] = killhtml ( $_POST['wdhpwd'] );
        $_POST['user_homepage'] = killhtml ( $_POST['user_homepage'] );
        $_POST['user_icq'] = killhtml ( $_POST['user_icq'] );
        $_POST['user_aim'] = killhtml ( $_POST['user_aim'] );
        $_POST['user_wlm'] = killhtml ( $_POST['user_wlm'] );
        $_POST['user_yim'] = killhtml ( $_POST['user_yim'] );
        $_POST['user_skype'] = killhtml ( $_POST['user_skype'] );

        settype ( $_POST['gen_password'], "integer" );
        settype ( $_POST['mail_password'], "integer" );
        settype ( $_POST['user_is_staff'], "integer" );
        if ( $_POST['user_group'] != "admin" ) {
            settype ( $_POST['user_group'], "integer" );
        }
        settype ( $_POST['user_show_mail'], "integer" );

        // filter
        $_POST['filter'] = savesql ( $_POST['filter'] );

        // get oterh data
        $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'], 0, 0, 0, TRUE );
        $nowbutton_array = array( "d", "m", "y" );

        // Display Form
        echo '
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="go" value="user_edit">
                        <input type="hidden" name="user_action" value="edit">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" name="user_id" value="'.$_POST['user_id'].'">
                        <input type="hidden" name="filter" value="'.$_POST['filter'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Hauptinformationen</td></tr>
                            <tr>
                                <td class="config">
                                    Benutzername:<br>
                                    <span class="small">Das Pseudonym des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" name="user_name" value="'.$_POST['user_name'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    E-Mail:<br>
                                    <span class="small">E-Mail-Adresse, an die das Passwort gesendet wird.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" name="user_mail" value="'.$_POST['user_mail'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Registrierdatum:<br>
                                    <span class="small">Datum, an dem der Benutzer registriert wurde.</span>
                                </td>
                                <td class="config">
                                    <span class="small">
                                        <input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                        <input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                        <input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'">&nbsp;
                                    </span>
                                    '.js_nowbutton ( $nowbutton_array, $admin_phrases[common][today] ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Neues Passwort:<br>
                                    <span class="small">Erstellt ein neues Passwort für den Benutzer.</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="new_password" value="1" '.getchecked( $_POST['new_password'], 1 ).'
                                        onChange="show_hidden(document.getElementById(\'genpwd_tr\'), this, true);
                                        show_hidden(document.getElementById(\'mailpwd_tr\'), this, true);
                                        show_hidden(document.getElementById(\'newpwd_tr\'), document.getElementById(\'genpwd\'), !(document.getElementById(\'genpwd\').checked) && !(this.checked));
                                        show_hidden(document.getElementById(\'wdhpwd_tr\'), document.getElementById(\'genpwd\'), !(document.getElementById(\'genpwd\').checked) && !(this.checked))"
                                    >
                                </td>
                            </tr>
                            <tr class="'.$display_arr['pwd_gen_tr'].'" id="genpwd_tr">
                                <td class="config">
                                    Passwort generieren:<br>
                                    <span class="small">Erstellt für den Benutzer ein zufälliges Passwort.</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="gen_password" id="genpwd" value="1" '.getchecked( $_POST['gen_password'], 1 ).'
                                        onChange="show_hidden(document.getElementById(\'newpwd_tr\'), this, false);
                                        show_hidden(document.getElementById(\'wdhpwd_tr\'), this, false)"
                                    >
                                </td>
                            </tr>
                            <tr class="'.$display_arr['pwd_tr'].'" id="newpwd_tr">
                                <td class="config">
                                    Passwort:<br>
                                    <span class="small">Das Passwort des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" type="password" size="30" maxlength="100" name="newpwd" value="'.$_POST['newpwd'].'">
                                </td>
                            </tr>
                            <tr class="'.$display_arr['pwd_tr'].'" id="wdhpwd_tr">
                                <td class="config">
                                    Passwort wiederholen:<br>
                                    <span class="small">Sicherheits-Wiederholung des Passworts.</span>
                                </td>
                                <td class="config">
                                    <input class="text" type="password" size="30" maxlength="100" name="wdhpwd" value="'.$_POST['wdhpwd'].'">
                                </td>
                            </tr>
                            <tr class="'.$display_arr['pwd_mail_tr'].'" id="mailpwd_tr">
                                <td class="config">
                                    E-Mail verschicken:<br>
                                    <span class="small">Schickt eine E-Mail mit dem neuen Passwort an dern Benutzer.</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="mail_password" id="mailpwd" value="1" '.getchecked( $_POST['mail_password'], 1 ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">Zusätzliche Einstellungen</td></tr>
                            <tr align="left" valign="top">
                                <td class="config">
                                    Benutzer-Bild: <span class="small">(optional)</span>
        ';
        if ( image_exists ( "images/avatare/", $_POST['user_id'] ) ) {
            echo '<br><br><img src="'.image_url( "images/avatare/", $_POST['user_id'] ).'" alt="" border="0"><br><br>';
        }
        echo '
                                </td>
                                <td class="config">
                                    <input class="text" name="user_pic" type="file" size="35"><br>
                                    <span class="small">['.$admin_phrases[common][max].' '.$config_arr['avatar_x'].' '.$admin_phrases[common][resolution_x].' '.$config_arr['avatar_y'].' '.$admin_phrases[common][pixel].'] ['.$admin_phrases[common][max].' '.$config_arr['avatar_size'].' '.$admin_phrases[common][kib].']</span>
        ';
        if ( image_exists ( "images/avatare/", $_POST['user_id'] ) ) {
            echo '
                                    <br>
                                    <span class="small"><b>Nur auswählen, wenn das bisherige Bild überschrieben werden soll!</b></span><br><br>
                                    <input class="pointer middle" type="checkbox" name="user_pic_delete" id="upd" value="1"
                                        onClick=\'delalert ("upd", "Soll das aktuelle Benutzer-Bild wirklich gelöscht werden?")\'
                                    >
                                    <span class="small middle"><b>Bild löschen?</b></span><br><br>
            ';
        }
        echo '
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Mitarbeiter:<br>
                                    <span class="small">Benutzer arbeitet an der Seite mit.</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="user_is_staff" value="1" '.getchecked ( $_POST['user_is_staff'], 1 ).'
                                        onChange="show_hidden(document.getElementById(\'group_tr\'), this, true)"
                                    >
                                </td>
                            </tr>
                            <tr class="'.$display_arr['group_tr'].'" id="group_tr">
                                <td class="config">
                                    Gruppe:<br>
                                    <span class="small">Gruppe, der der Benutzer angehört.</span>
                                </td>
                                <td class="config">
                                    <select name="user_group" size="1">
                                        <option value="0"'.getselected ( $_POST['user_group'], 0 ).'>keine Gruppe</option>';

        $index = mysql_query ("
                                SELECT `user_group_id`, `user_group_name`
                                FROM ".$global_config_arr['pref']."user_groups
                                WHERE `user_group_id` > 0
                                ORDER BY `user_group_name`
        ", $db );

        while ( $group_arr = mysql_fetch_assoc( $index ) ) {
            settype ( $group_arr['user_group_id'], "integer" );
            echo '
                                        <option value="'.$group_arr['user_group_id'].'" '.getselected ( $_POST['user_group'], $group_arr['user_group_id'] ).'>'.$group_arr['user_group_name'].'</option>';
        }

        $index = mysql_query ("
                                SELECT `user_group_id`, `user_group_name`
                                FROM ".$global_config_arr['pref']."user_groups
                                WHERE `user_group_id` = 0
                                ORDER BY `user_group_name`
                                LIMIT 0,1
        ", $db );
        $group_arr = mysql_fetch_assoc( $index );
        echo '
                                        <option value="admin" '.getselected ( $_POST['user_group'], "admin" ).'>'.$group_arr['user_group_name'].' (alle Rechte)</option>';
        echo '
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    E-Mail anzeigen:<br>
                                    <span class="small">E-Mail-Adresse im Profil anzeigen.</span>
                                </td>
                                <td class="config">
                                  <input class="pointer" type="checkbox" name="user_show_mail" value="1" '.getchecked ( $_POST['user_show_mail'], 1 ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">Kontaktinformationen</td></tr>
                            <tr>
                                <td class="config">
                                    Homepage: <span class="small">(optional)</span><br>
                                    <span class="small">Homepage des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" name="user_homepage" value="'.$_POST['user_homepage'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    ICQ: <span class="small">(optional)</span><br>
                                    <span class="small">ICQ-Nummer des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="20" maxlength="50" name="user_icq" value="'.$_POST['user_icq'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    AOL Instant Messenger: <span class="small">(optional)</span><br>
                                    <span class="small">AIM-Name des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="20" maxlength="50" name="user_aim" value="'.$_POST['user_aim'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Windows Live Messenger: <span class="small">(optional)</span><br>
                                    <span class="small">Windows Live E-Mail-Adresse des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="20" maxlength="50" name="user_wlm" value="'.$_POST['user_wlm'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Yahoo! Messenger: <span class="small">(optional)</span><br>
                                    <span class="small">Y!M-Username des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="20" maxlength="50" name="user_yim" value="'.$_POST['user_yim'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Skype: <span class="small">(optional)</span><br>
                                    <span class="small">Skype-ID des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="20" maxlength="50" name="user_skype" value="'.$_POST['user_skype'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';

    // Delete User
    } elseif ( $_POST['user_action'] == "delete" && !in_array ( 1, $_POST['user_id'] ) && !in_array ( $_SESSION['user_id'], $_POST['user_id'] ) ) {
        // get data from db
        $index = $sql->query ( "
                                SELECT U.`user_name`, U.`user_is_admin`, U.`user_is_staff`, U.`user_group`, G.`user_group_name`
                                FROM `{..pref..}user` U, `{..pref..}user_groups` G
                                WHERE U.`user_id` IN (".implode ( ",", $_POST['user_id'] ).")
                                AND U.`user_group` = G.`user_group_id`
        " );
                                echo mysql_error();
        // security functions
        $user_arr['user_name'] = killhtml ( $user_arr['user_name'] );
        $_POST['filter'] = savesql ( $_POST['filter'] );
        
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="user_edit">
                        <input type="hidden" name="user_action" value="delete">
                        <input type="hidden" name="sended" value="delete">
                        <input type="hidden" name="user_id" value="'.implode( ",", $_POST['user_id'] ).'">
                        <input type="hidden" name="filter" value="'.$_POST['filter'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Benutzer löschen</td></tr>
                            <tr>
                                <td class="configthin">
                                    Sollen die folgenden Benutzer wirklich gelöscht werden:
                                    <ul>';
        while ( $user_arr = mysql_fetch_assoc ( $index ) ) {
            // security functions
            $user_arr['user_name'] = killhtml ( $user_arr['user_name'] );
            $user_arr['user_admin_text'] = ( $user_arr['user_is_admin'] == 1 ) ? "Administrator" : "";
            $user_arr['user_staff_text'] = ( $user_arr['user_is_staff'] == 1 && $user_arr['user_is_admin'] == 0 ) ? "Mitarbeiter, " : "";
            $user_arr['user_group_text'] = ( $user_arr['user_group'] != 0 ) ? "Gruppe: " .killhtml ( $user_arr['user_group_name'] ) : "keine Gruppe";
            $user_arr['user_group_text'] = ( $user_arr['user_is_admin'] == 1 ) ? "" : $user_arr['user_group_text'];
            
            echo '
                                        <li><b>'.$user_arr['user_name'].'</b> ('.$user_arr['user_admin_text'].$user_arr['user_staff_text'].$user_arr['user_group_text'].')</li>';
        }

        echo '
                                    </ul>
                                </td>
                                <td class="config right top" style="padding: 0px;">
                                '.get_yesno_table ( "user_delete" ).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}



////////////////////////////
////// User auswählen //////
////////////////////////////

if ( !isset ( $_POST['user_id'] ) )
{
if ( isset ( $_POST['search'] ) || ( $_POST['group_action'] == "show" && count ( $_POST['group_id'] ) >= 1 ) ) {
        //security functions
        $theFilter = killhtml ( $_POST['filter'] );
        $_POST['filter'] = savesql ( $_POST['filter'] );


        // Set Form Title
        $listTitle = "Benutzer auswählen";

        // get users from db
        if (  $_POST['search'] == 1 ) {
            $user = $sql->query ( "
                                    SELECT `user_id`, `user_name`, `user_mail`, `user_is_staff`, `user_is_admin`
                                    FROM `{..pref..}user`
                                    WHERE ( `user_name` LIKE '%".$_POST['filter']."%' OR `user_mail` LIKE '%".$_POST['filter']."%' )
                                    AND `user_id` != '".(int) $_SESSION['user_id']."'
                                    AND `user_id` != '1'
                                    ORDER BY `user_name`
            " );
            $listTitle .= " - Suche nach &quot;".$theFilter."&quot;";
        } else if ( $_POST['group_action'] == "show" ) {
            $_POST['group_id'] = array_map ( "intval", $_POST['group_id'] );
            $user = $sql->query ( "
                                    SELECT `user_id`, `user_name`, `user_mail`, `user_is_staff`, `user_is_admin`
                                    FROM `{..pref..}user`
                                    WHERE `user_group` IN (".implode ( ",", $_POST['group_id'] ).")
                                    AND ( `user_group` != 0 OR ( `user_group` = 0 AND `user_is_staff` = 1 AND `user_is_admin` = 1 ) )
                                    AND `user_id` != '".(int) $_SESSION['user_id']."'
                                    AND `user_id` != '1'
                                    ORDER BY `user_name`
            " );
            // get groups from db
            $groups = $sql->getData ( "user_groups", "user_group_name", "WHERE `user_group_id` IN (".implode ( ",", $_POST['group_id'] ).") ORDER BY `user_group_name`" );
            if ( count ( $groups ) > 1 ) {
                $implodeArray = array ();
                foreach ( $groups as $line ) {
                    $implodeArray[] = $line['user_group_name'];
                }
                $listTitle .= " - Gruppen: ".implode ( ", ", $implodeArray );
            } else {
                $listTitle .= " - Gruppe: ".$groups[0]['user_group_name'];
            }
        }


        // generate list
        $theList = new SelectList ( "user", $listTitle, TRUE, 5 );
        $theList->addInput ( "hidden", "filter", $_POST['filter'] );
        $theList->addInput ( "hidden", "search", 1 );
        $theList->setColumns ( array (
            array ( "Name" ),
            array ( "E-Mail" ),
            array ( '&nbsp;&nbsp;Mitarbeiter&nbsp;&nbsp;', array(), 20 ),
            array ( '&nbsp;&nbsp;Administrator&nbsp;&nbsp;', array(), 20 ),
            array ( "", array(), 20 )
        ) );
        $theList->setNoLinesText ( "Keine Benutzer gefunden!" );
        $theList->addAction ( "edit", $admin_phrases[common][selection_edit], array ( "select_one" ), TRUE, TRUE );
        $theList->addAction ( "delete", $admin_phrases[common][selection_del], array ( "select_red" ), $_SESSION['user_delete'] );
        $theList->addButton();


        // user found
        if ( $user !== FALSE && mysql_num_rows ( $user ) > 0 ) {
            while ( $data_arr = mysql_fetch_assoc ( $user ) ) {
                $theList->addLine ( array (
                    array ( ( $_POST['filter'] != "" ) ? highlight_part ( $data_arr['user_name'],  $_POST['filter'], TRUE ) : killhtml ( $data_arr['user_name'] ), array ( "middle" ) ),
                    array ( ( $_POST['filter'] != "" ) ? highlight_part ( $data_arr['user_mail'],  $_POST['filter'], TRUE ) : killhtml ( $data_arr['user_mail'] ), array ( "middle" ) ),
                    array ( ( $data_arr['user_is_staff'] == 1 ) ? $TEXT["admin"]->get("yes") : $TEXT["admin"]->get("no"), array ( "middle", "center" ) ),
                    array ( ( $data_arr['user_is_admin'] == 1 ) ? $TEXT["admin"]->get("yes") : $TEXT["admin"]->get("no"), array ( "middle", "center" ) ),
                    array ( TRUE, $data_arr['user_id'] )
                ) );
            }
        }
        // Output
        echo $theList;
        echo "<p>&nbsp;</p>";

    }

    // dislplay search form
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="user_edit">
                        <input type="hidden" name="search" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Nach Benutzern suchen</td></tr>
                            <tr>
                                <td class="config">
                                    Name oder E-Mail-Adresse enthält:
                                </td>
                                <td class="config right">
                                    <input class="text" size="50" name="filter" value="'.$theFilter.'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '."Nach Benutzern suchen".'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

    // get groups from db
    $group = $sql->query ( "
                            SELECT DISTINCT G.`user_group_id`, G.`user_group_name`, COUNT( U.`user_id` ) AS 'num_users'
                            FROM `{..pref..}user_groups` G, `{..pref..}user` U
                            WHERE G.`user_group_id` = U.`user_group`
                            AND U.`user_id` != '".(int) $_SESSION['user_id']."'
                            AND U.`user_id` != 1
                            AND U.`user_is_staff` != 0
                            GROUP BY ( G.`user_group_id` )
                            ORDER BY G.`user_group_name`
    " );
    
    // generate list
    $theList = new SelectList ( "group", "Benutzer nach Gruppe auswählen", TRUE, 3 );
    $theList->setColumns ( array (
        array ( "Gruppenname & Grafik" ),
        array ( '&nbsp;&nbsp;Mitglieder&nbsp;&nbsp;', array(), 20 ),
        array ( "", array(), 20 )
    ) );
    $theList->setSpaceAfterCaptions ( TRUE );
    $theList->setNoLinesText ( "Keine Gruppen gefunden!" );
    $theList->addAction ( "show", "", array (), TRUE, TRUE );
    $theList->setActionSelection ( FALSE );
    $theList->addButton( "Benutzer der gewählten Gruppen anzeigen" );


    // groups found
    if ( $group !== FALSE && mysql_num_rows ( $group ) > 0 ) {
        while ( $data_arr = mysql_fetch_assoc ( $group ) ) {
            $aGroup = '<b>'.$data_arr['user_group_name'].'</b>';
            if ( image_exists ( "images/groups/", "staff_".$data_arr['user_group_id'] ) ) {
                $aGroup .= '<br><img src="'.image_url ( "images/groups/", "staff_".$data_arr['user_group_id'] ).'" alt="'.$data_arr['user_group_name'].'" border="0">';
            }
            $theList->addLine ( array (
                array ( $aGroup, array ( "middle" ) ),
                array ( $data_arr['num_users'], array ( "middle", "center" ) ),
                array ( TRUE, $data_arr['user_group_id'] )
            ) );
        }
    }
    // Output
    echo "<p>&nbsp;</p>";
    echo $theList;
}
?>