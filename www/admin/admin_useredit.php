<?php

////////////////////////////
//// User aktualisieren ////
////////////////////////////

if ($_POST[username] AND $_POST[usermail] AND $_POST[monat] AND $_POST[tag] AND $_POST[jahr] AND $_POST[userid] != 1 AND $_POST[userid] != $_SESSION[user_id])
{
    $_POST[username] = savesql($_POST[username]);
    $_POST[usermail] = savesql($_POST[usermail]);
    settype($_POST['userid'], 'integer');
    settype($_POST['user_is_staff'], 'integer');
    settype($_POST['user_show_mail'], 'integer');
    
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
	

    $regdate = mktime(0, 0, 0, $_POST[monat], $_POST[tag], $_POST[jahr]);
 
    // Username schon vorhanden?
    $index = mysql_query("SELECT user_id FROM ".$global_config_arr['pref']."user WHERE user_name = '$_POST[username]'", $db);
    $rows = mysql_num_rows($index);
    $dbexistid = mysql_result($index, 0, "user_id");

    // Neuer name noch nicht vorhanden, oder gleicher User
    if (($dbexistid == $_POST[userid]) || ($rows == 0))
    {
        if (!isset($_POST[deluser]))
        {
            $index = mysql_query("SELECT user_is_staff FROM ".$global_config_arr['pref']."user WHERE user_id = '$_POST[userid]'", $db);
            $dbisstaff = mysql_result($index, 0, "user_is_staff");
            
            // user is not longer in staff
            if ( $_POST['user_is_staff'] == 0 && $dbisstaff == 1 )
            {
                $dbaction = mysql_query ("
											DELETE
											FROM ".$global_config_arr['pref']."user_permissions
											WHERE `perm_for_group` = '0'
											AND `x_id` = '".$_POST[userid]."'
				", $db );
            }

            $update = "UPDATE ".$global_config_arr['pref']."user
                       SET user_name = '".$_POST['username']."',
                           user_mail = '".$_POST['usermail']."',
            ";
            
            // Neues Passwort?
            if ( $_POST[newpass] != "" ) {
                $newsalt = generate_pwd ( 10 );
                $userpass = md5 ( $_POST[newpass].$newsalt );
                $update .= "user_password = '".$userpass."',
                            user_salt = '".$newsalt."',";
            }
            
            $update .= "
							user_is_staff = '".$_POST['user_is_staff']."',
							user_group = '".$_POST['user_group']."',
				  			user_is_admin = '".$_POST['user_is_admin']."',
							user_reg_date = '".$regdate."',
							user_show_mail = '".$_POST['user_show_mail']."'
							WHERE user_id = $_POST[userid]
            ";
                       
            mysql_query($update, $db);
            echo mysql_error();
            //Avatar löschen
            if ($_POST['avatar_delete'] == 1)
            {
                if (image_delete("images/avatare/", $_POST[userid])) {
                    systext('Das Bild wurde erfolgreich gelöscht!');
                } else {
                    systext('Das Bild konnte nicht gelöscht werden, da es nicht existiert!');
                }
            }
            //Avatar neu hochladen
            elseif ($_FILES['avatar']['name'] != "")
            {
                $upload = upload_img($_FILES['avatar'], "images/avatare/", $_POST[userid], 30*1024, 110, 110);
                systext(upload_img_notice($upload));
            }

            systext('User wurde geändert');
        } 
        elseif($_POST[userid] != 1 AND $_POST[userid] != $_SESSION[user_id])  // User löschen
        {
            $dbaction = mysql_query ("
										DELETE
										FROM ".$global_config_arr['pref']."user_permissions
										WHERE `perm_for_group` = '0'
										AND `x_id` = '".$_POST['userid']."'
			", $db );
			
            $dbaction = "DELETE FROM ".$global_config_arr['pref']."user WHERE user_id = ".$_POST[userid];
            mysql_query($dbaction, $db);

            mysql_query("UPDATE ".$global_config_arr['pref']."counter SET user = user - 1", $db);
            systext('User wurde gelöscht');
        }
    }
    else
    {
        systext("Username existiert bereits");
    }
}

////////////////////////////
////// User editieren //////
////////////////////////////

if ( isset ( $_POST['edit_user_id'] ) )
{
    settype($_POST[select_user], 'integer');
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."user WHERE user_id = $_POST[select_user]", $db);
    $user_arr = mysql_fetch_assoc($index);

    if ( $user_arr['user_is_staff'] == 1 ) {
		$display_arr['group_tr'] = "default";
	} else {
		$display_arr['group_tr'] = "hidden";
	}
	
    if ( $user_arr['user_is_admin'] == 1 ) {
		$user_arr['user_group'] = "admin";
	}
    echo'
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="user_edit" name="go">
                        <input type="hidden" value="'.$user_arr[user_password].'" name="oldpass">
                        <input type="hidden" value="'.$user_arr[user_id].'" name="userid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Name:<br>
                                    <font class="small">Name des Users</font>
                                </td>
                                <td class="config" width="50%" valign="top">
                                    <input class="text" size="30" name="username" value="'.$user_arr[user_name].'" maxlength="100">
                                </td>
                            </tr>
                            <tr align="left" valign="top">
                                <td class="config">
                                    Bild: <font class="small">(optional)</font>';
    if (image_exists("images/avatare/", $user_arr[user_id])) {
        echo'<br><br><img src="'.image_url("images/avatare/", $user_arr[user_id]).'" alt=""                             border="0"><br><br>';
    }
    echo'
                                </td>
                                <td class="config">
                                    <input name="avatar" type="file" size="35" class="text" /><br />
                                    <font class="small">[max. 110 x 110 Pixel] [max. 30 KB]</font>';
    if (image_exists("images/avatare/", $user_arr[user_id]))
    echo'
                                    <br>
                                    <font class="small">
                                        <b>Nur auswählen, wenn das bisherige Bild überschrieben werden soll!</b>
                                    </font><br><br>
                                    <input type="checkbox" name="avatar_delete" id="avd" value="1" onClick=\'delalert ("avd", "Soll das Benutzerbild wirklich gelöscht werden?")\' />
                                    <font class="small"><b>Bild löschen?</b></font><br><br>';
    echo'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    E-Mail:<br>
                                    <font class="small">E-Mail Adresse, an die das Passwort gesendet wird</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" name="usermail" value="'.$user_arr[user_mail].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Passwort:<br>
                                    <font class="small">Neus Passwort eingeben um das alte zu ändern</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" type="password" size="30" name="newpass" maxlength="16">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Mitarbeiter:<br>
                                    <font class="small">User arbeitet an der Seite mit</font>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="user_is_staff" value="1" '.getchecked ( $user_arr['user_is_staff'], 1 ).'
									 onChange="show_hidden(document.getElementById(\'group_tr\'), this)">
                                </td>
                            </tr>
                            <tr class="'.$display_arr['group_tr'].'" id="group_tr">
                                <td class="config">
                                    Gruppe:<br>
                                    <font class="small">Gehört der User einer Gruppe an</font>
                                </td>
                                <td class="config">
                                    <select name="user_group" size="1">
                                        <option value="0"'.getselected ( $user_arr['user_group'], 0 ).'>keine Gruppe</option>
	';
	
	$index = mysql_query ("
							SELECT `user_group_id`, `user_group_name`
							FROM ".$global_config_arr['pref']."user_groups
							WHERE `user_group_id` > 0
							ORDER BY `user_group_name`
	", $db );
	
	while ( $group_arr = mysql_fetch_assoc( $index ) ) {
	    echo '<option value="'.$group_arr['user_group_id'].'" '.getselected ( $user_arr['user_group'], $group_arr['user_group_id'] ).'>
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
	echo '<option value="admin" '.getselected ( $user_arr['user_group'], "admin" ).'>'.$group_arr['user_group_name'].' (alle Rechte)</option>';
	
	echo '
									</select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Registriert seit</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="2" value="'.date("d",$user_arr[user_reg_date]).'" name="tag" maxlength="2">
                                    <input class="text" size="2" value="'.date("m",$user_arr[user_reg_date]).'" name="monat" maxlength="2">
                                    <input class="text" size="4" value="'.date("Y",$user_arr[user_reg_date]).'" name="jahr" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Zeige Email:<br>
                                    <font class="small">Zeigt die Email Adresse öffentlich</font>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="user_show_mail" value="1" '.getchecked ( $user_arr['user_show_mail'], 1 ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    User löschen:<br>
                                    <font class="status"><b>ACHTUNG!</b> kann nicht rückgängig gemacht werden</font>
                                </td>
                                <td class="config">
                                    <input onClick=\'delalert ("deluser","Soll der User wirklich gelöscht werden?")\' type="checkbox" name="deluser" id="deluser" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" class="button" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

////////////////////////////
////// User auswählen //////
////////////////////////////

else
{
	//security functions
	$_POST['filter'] = savesql ( $_POST['filter'] );

	// dislplay search form
    echo '
					<form action="" method="post">
						<input type="hidden" name="go" value="user_edit">
						<input type="hidden" name="search" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Benutzer suchen</td></tr>
                            <tr>
                                <td class="config">
                                    Name oder E-Mail-Adresse enthält:
                                </td>
                                <td class="config right">
                                    <input class="text" size="50" name="filter" value="'.$_POST['filter'].'">
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

	if ( isset ( $_POST['search'] ) ) {
		// start display
		echo '
					<form action="" method="post">
						<input type="hidden" name="go" value="user_edit">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="space"></td></tr>
                            <tr><td class="space"></td></tr>
							<tr><td class="line" colspan="5">Benutzer auswählen</td></tr>
		';

		// get users from db
	    $index = mysql_query ( "
								SELECT `user_id`, `user_name`, `user_mail`, `user_is_staff`, `user_is_admin`
								FROM ".$global_config_arr['pref']."user
								WHERE ( `user_name` LIKE '%".$_POST['filter']."%' OR `user_mail` LIKE '%".$_POST['filter']."%' )
								AND `user_id` != '".$_SESSION['user_id']."'
	                          	ORDER BY user_name
		", $db );

		// users found
	    if ( mysql_num_rows ( $index ) > 0 ) {
			// display table head
			echo '
							<tr>
							    <td class="config">Name</td>
							    <td class="config">E-Mail</td>
							    <td class="config" width="20">&nbsp;&nbsp;Mitarbeiter&nbsp;&nbsp;</td>
							    <td class="config" width="20">&nbsp;&nbsp;Administrator&nbsp;&nbsp;</td>
							    <td class="config" width="20"></td>
							</tr>
			';

			// display users
		    while ( $user_arr = mysql_fetch_assoc ( $index ) ) {

				// get other data
				if ( $user_arr['user_is_staff'] == 1 ) {
				    $user_arr['staff_text'] = "Ja";
				} else {
				    $user_arr['staff_text'] = "Nein";
				}
				
				if ( $user_arr['user_is_admin'] == 1 ) {
				    $user_arr['admin_text'] = "Ja";
				} else {
				    $user_arr['admin_text'] = "Nein";
				}

				echo '
							<tr class="pointer" id="tr_'.$user_arr['user_id'].'"
								onmouseover="'.color_list_entry ( "input_".$user_arr['user_id'], "#EEEEEE", "#64DC6A", "this" ).'"
								onmouseout="'.color_list_entry ( "input_".$user_arr['user_id'], "transparent", "#49c24f", "this" ).'"
                                onclick="'.color_click_entry ( "input_".$user_arr['user_id'], "#EEEEEE", "#64DC6A", "this", TRUE ).'"
							>
								<td class="configthin middle">'.killhtml($user_arr['user_name']).'</td>
								<td class="configthin middle">'.killhtml($user_arr['user_mail']).'</td>
								<td class="configthin middle center">'.killhtml($user_arr['staff_text']).'</td>
								<td class="configthin middle center">'.killhtml($user_arr['admin_text']).'</td>
								<td class="config top center">
									<input class="pointer" type="radio" name="edit_user_id" id="input_'.$user_arr['user_id'].'" value="'.$user_arr['user_id'].'"
													onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$user_arr['user_id'], TRUE ).'"
								</td>
							</tr>
				';
		    }
		    
		    // display footer with button
		    echo'
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="5">
									<button class="button_new" type="submit">
										'.$admin_phrases[common][arrow].' '."Benutzer bearbeiten".'
									</button>
								</td>
							</tr>
			';

		// no users found
	    } else {

			echo'
                            <tr><td class="space"></td></tr>
							<tr>
								<td class="config center" colspan="5">Keine Benutzer gefunden!</td>
							</tr>
							<tr><td class="space"></td></tr>
	        ';
	    }
		echo '
						</table>
					</form>
		';
	}
}
?>