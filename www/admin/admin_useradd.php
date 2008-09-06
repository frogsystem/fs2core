<?php
/////////////////////
//// Load Config ////
/////////////////////
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."user_config", $db );
$config_arr = mysql_fetch_assoc ( $index );

//////////////////
//// Add User ////
//////////////////

if ( $_POST['user_per_page'] && ( $_POST['user_per_page'] > 0 || $_POST['user_per_page'] == -1 ) )
{
	// security functions
    settype ( $_POST['user_per_page'], "integer" );
    settype ( $_POST['registration_antispam'], "integer" );

	// MySQL-Queries
    mysql_query ( "
					UPDATE `".$global_config_arr['pref']."user_config`
					SET
						`user_per_page` = '".$_POST['user_per_page']."',
						`registration_antispam` = '".$_POST['registration_antispam']."'
					WHERE `id` = '1'
	", $db );

	// system messages
    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);

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
		systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
	} else {
	    $_POST['gen_password'] = 1;
	    $_POST['user_homepage'] = "http://";
	}

	// get other data
    if ( $_POST['user_is_staff'] == 1 ) {
		$display_arr['group_tr'] = "default";
	} else {
		$display_arr['group_tr'] = "hidden";
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

	settype ( $_POST['gen_password'], "integer" );
    settype ( $_POST['user_is_staff'], "integer" );
    settype ( $_POST['user_group'], "integer" );
    settype ( $_POST['user_show_mail'], "integer" );

	// Display Form
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="user_add">
						<input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Hauptinformationen</td></tr>
                            <tr>
                                <td class="config">
                                    Name:<br>
                                    <span class="small">Der Name des Benutzers.</span>
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
                                    Passwort generieren:<br>
                                    <span class="small">Erstellt für den Benutzer ein zufälliges Passwort.</span>
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
                                    <input class="text" size="30" maxlength="100" name="newpwd" value="'.$_POST['newpwd'].'">
                                </td>
                            </tr>
                            <tr class="'.$display_arr['pwd_tr'].'" id="wdhpwd_tr">
                                <td class="config">
                                    Passwort wiederholen:<br>
                                    <span class="small">Sicherheits-Wiederholung des Passworts.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" name="wdhpwd" value="'.$_POST['wdhpwd'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="2">Zusätzliche Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    Benutzer-Bild: <span class="small">(optional)</span>
                                </td>
                                <td class="config">
                                    <input class="text" name="user_pic" type="file" size="35"><br>
                                    <span class="small">['.$admin_phrases[common][max].' '.$config_arr['avatar_x'].' '.$admin_phrases[common][resolution_x].' '.$config_arr['avatar_y'].' '.$admin_phrases[common][pixel].'] ['.$admin_phrases[common][max].' '.$config_arr['avatar_size'].' '.$admin_phrases[common][kib].']</span>
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
                                        <option value="0"'.getselected ( $_POST['user_group'], 0 ).'>keine Gruppe</option>
	';

	$index = mysql_query ("
							SELECT `user_group_id`, `user_group_name`
							FROM ".$global_config_arr['pref']."user_groups
							WHERE `user_group_id` > 0
							ORDER BY `user_group_name`
	", $db );

	while ( $group_arr = mysql_fetch_assoc( $index ) ) {
	    echo '<option value="'.$group_arr['user_group_id'].'" '.getselected ( $_POST['user_group'], $group_arr['user_group_id'] ).'>
			'.$group_arr['user_group_name'].'</option>';
	}

	$index = mysql_query ("
							SELECT `user_group_id`, `user_group_name`
							FROM ".$global_config_arr['pref']."user_groups
							WHERE `user_group_id` = 0
							ORDER BY `user_group_name`
							LIMIT 0,1
	", $db );
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
                                    Homepage:<br>
                                    <span class="small">Homepage des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" name="user_homepage" value="'.$_POST['user_homepage'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    ICQ:<br>
                                    <span class="small">ICQ-Nummer des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="15" maxlength="50" name="user_icq" value="'.$_POST['user_icq'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    AOL Instant Messenger:<br>
                                    <span class="small">AIM-Name des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="15" maxlength="50" name="user_aim" value="'.$_POST['user_aim'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Windows Live Messenger:<br>
                                    <span class="small">Windows Live E-Mail-Adresse des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="15" maxlength="50" name="user_wlm" value="'.$_POST['user_wlm'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Yahoo! Messenger:<br>
                                    <span class="small">Y!M-Username des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="15" maxlength="50" name="user_yim" value="'.$_POST['user_yim'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Skype:<br>
                                    <span class="small">Skype-ID des Benutzers.</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="15" maxlength="50" name="user_skype" value="'.$_POST['user_skype'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '."Neuen Benutzer hinzufügen".'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}



//////////////////////////
//// Benutzer anlegen ////
//////////////////////////

if ($_POST[username] && $_POST[usermail])
{
    $_POST[username] = savesql($_POST[username]);
    $_POST[usermail] = savesql($_POST[usermail]);
    settype($_POST[regdate], "integer");

    // existiert dieser Username schon?
    $index = mysql_query("SELECT user_name FROM ".$global_config_arr[pref]."user WHERE user_name = '$_POST[username]'", $db);
    $rows = mysql_num_rows($index);

    if ($rows == 0)
    {
        $newpass = generate_pwd ( 15 );
        $user_salt = generate_pwd ( 10 );
        $codedpass = md5 ( $newpass.$user_salt );
        $_POST[username] = savesql($_POST[username]);
        $_POST[usermail] = savesql($_POST[usermail]);
        $_POST[showmail] = isset($_POST[showmail]) ? 1 : 0;

        $sqlquery = "INSERT INTO ".$global_config_arr[pref]."user
						(user_name, user_password, user_salt, user_mail, user_reg_date, user_show_mail)
                     VALUES ('".$_POST[username]."',
                             '".$codedpass."',
                             '".$user_salt."',
                             '".$_POST[usermail]."',
                             '".$_POST[regdate]."',
                             '".$_POST[showmail]."')";
        mysql_query($sqlquery, $db);

        // Mail versenden
        $template_mail = get_template ( "email_register" );
        $template_mail = str_replace("{username}", $_POST[username], $template_mail);
        $template_mail = str_replace("{password}", $newpass, $template_mail);

        $email_betreff = $phrases[registration] . " @ " . $global_config_arr[virtualhost];
        $header  = "From: ".$global_config_arr[admin_mail]."\n";
        $header .= "Reply-To: ".$global_config_arr[admin_mail]."\n";
        $header .= "X-Mailer: PHP/" . phpversion(). "\n"; 
        $header .= "X-Sender-IP: $REMOTE_ADDR\n"; 
        $header .= "Content-Type: text/plain";
        mail($usermail, $email_betreff, $template_mail, $header);

        $index = mysql_query("SELECT COUNT(user_id) AS user FROM ".$global_config_arr[pref]."user", $db);
        $new_user_num = mysql_result($index,0,"user");
        mysql_query("UPDATE ".$global_config_arr[pref]."counter SET user = '".$new_user_num."'", $db);

        systext('User wurde hinzugefügt');
    }
    else
    {
        systext('Username existiert bereits');
    }
}

//////////////////////////
//// Benutzer Formular ///
//////////////////////////

else
{
    echo'
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config">
                                    Registrierdatum:<br>
                                    <font class="small">Anmeldedatum des Users</font>
                                </td>
                                <td align="center" class="config">
                                    '.date("d.m.Y", $reg_time).'
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>