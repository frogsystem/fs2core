<?php
///////////////////
//// Functions ////
///////////////////

function user_name_free ( $USERNAME ) {
    global $global_config_arr;
    global $FD;

    $USERNAME = savesql ( $USERNAME );
    $index = mysql_query ( '
                            SELECT `user_id`
                            FROM `'.$global_config_arr['pref']."user`
                            WHERE `user_name` = '".$USERNAME."'
    ", $FD->sql()->conn() );
    if ( mysql_num_rows ( $index ) > 0 ) {
        return FALSE;
    } else {
        return TRUE;
    }
}

/////////////////////
//// Load Config ////
/////////////////////
$index = mysql_query ( 'SELECT * FROM '.$global_config_arr['pref']."user_config WHERE `id` = '1'", $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc ( $index );

//////////////////
//// Add User ////
//////////////////

if (
        isset($_POST['user_name']) && $_POST['user_name'] != '' && user_name_free ( $_POST['user_name'] ) == TRUE
        && $_POST['user_mail'] && $_POST['user_mail'] != ''
        && (
            ( $_POST['newpwd'] && $_POST['newpwd'] != '' && $_POST['wdhpwd'] && $_POST['wdhpwd'] != '' && $_POST['newpwd'] == $_POST['wdhpwd'] )
            || $_POST['gen_password'] == 1
        )
        && $_POST['d'] && $_POST['d'] > 0 && $_POST['d'] <= 31
        && $_POST['m'] && $_POST['m'] > 0 && $_POST['m'] <= 12
        && $_POST['y'] && $_POST['y'] >= 0
    )
{
    // security functions
    $_POST['user_name'] = savesql ( $_POST['user_name'] );
    $_POST['user_mail'] = savesql ( $_POST['user_mail'] );
    $_POST['user_homepage'] = savesql ( $_POST['user_homepage'] );
    $_POST['user_icq'] = savesql ( $_POST['user_icq'] );
    $_POST['user_aim'] = savesql ( $_POST['user_aim'] );
    $_POST['user_wlm'] = savesql ( $_POST['user_wlm'] );
    $_POST['user_yim'] = savesql ( $_POST['user_yim'] );
    $_POST['user_skype'] = savesql ( $_POST['user_skype'] );

    settype ( $_POST['gen_password'], 'integer' );
    settype ( $_POST['user_is_staff'], 'integer' );
    settype ( $_POST['user_show_mail'], 'integer' );

    // get other data
    $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'], 0, 0, 0 );
    $user_date = mktime ( 0, 0, 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );

    if ( $_POST['user_group'] == 'admin' && $_POST['user_is_staff'] == 1 ) {
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

    if ( $_POST['user_homepage'] == 'http://' ) {
        $_POST['user_homepage'] = '';
    }

    if ( $_POST['gen_password'] == 1 ) {
        $_POST['newpwd'] = generate_pwd ( 15 );
    }
    $user_salt = generate_pwd ( 10 );
    $codedpwd = md5 ( $_POST['newpwd'].$user_salt );

    // MySQL-Queries
    mysql_query ( '
                    INSERT INTO `'.$global_config_arr['pref']."user`
                        ( `user_name`, `user_password`, `user_salt`,
                        `user_mail`, `user_is_staff`, `user_group`, `user_is_admin`,
                        `user_reg_date`, `user_show_mail`, `user_homepage`,
                        `user_icq`, `user_aim`, `user_wlm`, `user_yim`, `user_skype` )
                    VALUES (
                        '".$_POST['user_name']."',
                        '".$codedpwd."',
                        '".$user_salt."',
                        '".$_POST['user_mail']."',
                        '".$_POST['user_is_staff']."',
                        '".$_POST['user_group']."',
                        '".$_POST['user_is_admin']."',
                        '".$user_date."',
                        '".$_POST['user_show_mail']."',
                        '".$_POST['user_homepage']."',
                        '".$_POST['user_icq']."',
                        '".$_POST['user_aim']."',
                        '".$_POST['user_wlm']."',
                        '".$_POST['user_yim']."',
                        '".$_POST['user_skype']."'
                    )
    ", $FD->sql()->conn() );
    $user_id = mysql_insert_id ( $FD->sql()->conn() );
    $message = 'Benutzer wurde erfolgreich hinzugef&uuml;gt';

    mysql_query ( '
                    UPDATE '.$global_config_arr['pref'].'counter
                    SET `user` = `user`+1
    ', $FD->sql()->conn() );

    // upload image
    if ( $_FILES['user_pic']['name'] != '' ) {
        $upload = upload_img ( $_FILES['user_pic'], 'images/avatare/', $user_id, $config_arr['avatar_size']*1024, $config_arr['avatar_x'], $config_arr['avatar_y'] );
        $message .= '<br>' . upload_img_notice ( $upload );
    }

    // send email
    $template_mail = get_email_template ( 'signup' );
    $template_mail = str_replace ( '{..user_name..}', stripslashes ( $_POST['user_name'] ), $template_mail );
    $template_mail = str_replace ( '{..new_password..}', $_POST['newpwd'], $template_mail );
    $template_mail = replace_globalvars ( $template_mail );
    $email_subject = $FD->text("frontend", "mail_registerd_on") . $global_config_arr['virtualhost'];
    if ( @send_mail ( stripslashes ( $_POST['user_mail'] ), $email_subject, $template_mail ) ) {
        $email_message = '<br>'.$FD->text("frontend", "mail_registerd_sended");
    } else {
        $email_message = '<br>'.$FD->text("frontend", "mail_registerd_not_sended");
    }

    // system messages
    systext( $message, $FD->text("page", "'") );

    // Unset Vars
    unset ( $_POST );
}

//////////////////////
//// Display Form ////
//////////////////////

if ( TRUE )
{
    // Display Error Messages
    if ( isset ( $_POST['sended'] ) ) {
        $message = array();
        if ( user_name_free ( $_POST['user_name'] ) == FALSE ) {
            $message[] = 'Der angegebene Benutzername existiert bereits';
        }
        if ( $_POST['newpwd'] != $_POST['wdhpwd'] && $_POST['gen_password'] != 1 ) {
            $message[] = 'Das Passwort muss zweimal identisch eingegeben werden';
        }
        $message = implode ( '<br>', $message );
        if ( strlen ( $message ) == 0 ) {
            $message = $FD->text("page", "'");
        }
        systext ( $message, $FD->text("page", "'"), TRUE );
    } else {
        $_POST['gen_password'] = 1;
        $_POST['user_homepage'] = 'http://';
        $_POST['d'] = date ( 'd' );
        $_POST['m'] = date ( 'm' );
        $_POST['y'] = date ( 'Y' );
    }

    // get other data
    if ( isset($_POST['user_is_staff']) && $_POST['user_is_staff'] == 1 ) {
        $display_arr['group_tr'] = 'default';
    } else {
        $display_arr['group_tr'] = 'hidden';
    }

    if ( isset($_POST['gen_password']) && $_POST['gen_password'] == 1 ) {
        $display_arr['pwd_tr'] = 'hidden';
    } else {
        $display_arr['pwd_tr'] = 'default';
    }

    // security functions
    $_POST['user_name'] = isset($_POST['user_name']) ? killhtml ( $_POST['user_name'] ) : '';
    $_POST['user_mail'] = isset($_POST['user_mail']) ? killhtml ( $_POST['user_mail'] ) : '';
    $_POST['newpwd'] = isset($_POST['newpwd']) ? killhtml ( $_POST['newpwd'] ) : '';
    $_POST['wdhpwd'] = isset($_POST['wdhpwd']) ? killhtml ( $_POST['wdhpwd'] ) : '';
    $_POST['user_homepage'] = isset($_POST['user_homepage']) ? killhtml ( $_POST['user_homepage'] ) : '';
    $_POST['user_icq'] = isset($_POST['user_icq']) ? killhtml ( $_POST['user_icq'] ) : '';
    $_POST['user_aim'] = isset($_POST['user_aim']) ? killhtml ( $_POST['user_aim'] ) : '';
    $_POST['user_wlm'] = isset($_POST['user_wlm']) ? killhtml ( $_POST['user_wlm'] ) : '';
    $_POST['user_yim'] = isset($_POST['user_yim']) ? killhtml ( $_POST['user_yim'] ) : '';
    $_POST['user_skype'] = isset($_POST['user_skype']) ? killhtml ( $_POST['user_skype'] ) : '';

    settype ( $_POST['gen_password'], 'integer' );
    settype ( $_POST['user_is_staff'], 'integer' );
    settype ( $_POST['user_group'], 'integer' );
    settype ( $_POST['user_show_mail'], 'integer' );

    // get oterh data
    $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'], 0, 0, 0, TRUE );
    $nowbutton_array = array( 'd', 'm', 'y' );

    // Display Form
    echo'
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="go" value="user_add">
                        <input type="hidden" name="sended" value="1">
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
                                    '.js_nowbutton ( $nowbutton_array, $FD->text("page", "'") ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Passwort generieren:<br>
                                    <span class="small">Erstellt f&uuml;r den Benutzer ein zuf&auml;lliges Passwort.</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="gen_password" value="1" '.getchecked( $_POST['gen_password'], 1 ).'
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
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">Zus&auml;tzliche Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    Benutzer-Bild: <span class="small">(optional)</span>
                                </td>
                                <td class="config">
                                    <input class="text" name="user_pic" type="file" size="35"><br>
                                    <span class="small">['.$FD->text("page", "'").' '.$config_arr['avatar_x'].' '.$FD->text("page", "'").' '.$config_arr['avatar_y'].' '.$FD->text("page", "'").'] ['.$FD->text("page", "'").' '.$config_arr['avatar_size'].' '.$FD->text("page", "'").']</span>
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
                                    <span class="small">Gruppe, der der Benutzer angeh&ouml;rt.</span>
                                </td>
                                <td class="config">
                                    <select name="user_group" size="1">
                                        <option value="0"'.getselected ( $_POST['user_group'], 0 ).'>keine Gruppe</option>
    ';

    $index = mysql_query ('
                            SELECT `user_group_id`, `user_group_name`
                            FROM '.$global_config_arr['pref'].'user_groups
                            WHERE `user_group_id` > 0
                            ORDER BY `user_group_name`
    ', $FD->sql()->conn() );

    while ( $group_arr = mysql_fetch_assoc( $index ) ) {
        echo '<option value="'.$group_arr['user_group_id'].'" '.getselected ( $_POST['user_group'], $group_arr['user_group_id'] ).'>
            '.$group_arr['user_group_name'].'</option>';
    }

    $index = mysql_query ('
                            SELECT `user_group_id`, `user_group_name`
                            FROM '.$global_config_arr['pref'].'user_groups
                            WHERE `user_group_id` = 0
                            ORDER BY `user_group_name`
                            LIMIT 0,1
    ', $FD->sql()->conn() );
    $group_arr = mysql_fetch_assoc( $index );
    echo '<option value="admin" '.getselected ( $_POST['user_group'], "admin" ).'>'.$group_arr['user_group_name'].' (alle Rechte)</option>';

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
                                        '.$FD->text("page", "'").' '."Neuen Benutzer hinzuf&uuml;gen".'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
