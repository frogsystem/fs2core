<?php
// fs2 include path
set_include_path ( '.' );
$fs_root_path = "./";

//////////////////////////////
//// Profil aktualisieren ////
//////////////////////////////

if ($_POST[usermail] && $_SESSION[user_id])
{
    settype($_POST[userid], "integer");

    // Avatar hochladen, wenn vorhanden
    if ($_FILES[userpic][tmp_name])
    {
        image_rename("images/avatare/", $_SESSION[user_id], $_SESSION[user_id]."_old");
        $upload = upload_img($_FILES[userpic], "images/avatare/", $_SESSION[user_id], 30*1024, 110, 110);
        $message = upload_img_notice($upload)."<br />";
        if ($upload == 0) {
          image_delete("images/avatare/", $_SESSION[user_id]."_old");
        } else {
          image_rename("images/avatare/", $_SESSION[user_id]."_old", $_SESSION[user_id]);
        }
    }

    //Email Daten
    $mailto = $_POST[usermail];

    // User Daten aktualisieren
    $_POST[usermail] = savesql($_POST[usermail]);
    $_POST[showmail] = isset($_POST[showmail]) ? 1 : 0;
    $update = "UPDATE ".$global_config_arr[pref]."user
               SET user_mail = '$_POST[usermail]',
                   show_mail = '$_POST[showmail]'
               WHERE user_id = $_SESSION[user_id]";
    mysql_query($update, $db);
    $message .= $phrases[profile_update];

    // Neues Passwort eintragen 
    if ($_POST[oldpwd] && $_POST[oldpwd] != ""
        && $_POST[newpwd] && $_POST[newpwd] != ""
        && $_POST[wdhpwd] && $_POST[wdhpwd] != "")
    {
        $index = mysql_query("SELECT user_password, user_salt FROM ".$global_config_arr['pref']."user WHERE user_id = '".$_SESSION['user_id']."'", $db);
        $oldpass = mysql_result($index, 0, "user_password");
        $user_salt = mysql_result($index, 0, "user_salt");
        
        $_POST[oldpwd] = md5 ( $_POST[oldpwd].$user_salt );

        if ( $_POST[oldpwd] == $oldpass )
        {
            if ( $_POST[newpwd] == $_POST[wdhpwd] )
            {
				$new_salt = generate_pwd ( 10 );
				$mailpass = $_POST[newpwd];
				$codedpass = md5 ( $_POST[newpwd].$new_salt );
				unset($_POST[newpwd]);
				unset($_POST[wdhpwd]);

				//UPDATE PASSWORD
				$update = "UPDATE ".$global_config_arr['pref']."user
				          SET user_password = '".$codedpass."',
				              user_salt = '".$new_salt."'
				          WHERE user_id = ".$_SESSION['user_id']."";
				mysql_query($update, $db);
				$message .= "<br>".$phrases[pass_update];
				
				// send email
				$template_mail = get_email_template ( "signup" );
				$template_mail = str_replace ( "{username}", stripslashes ( $_SESSION['user_name'] ), $template_mail );
				$template_mail = str_replace ( "{password}", $mailpass, $template_mail );
				$template_mail = str_replace ( "{virtualhost}", $global_config_arr['virtualhost'], $template_mail );
				$email_betreff = $phrases['pass_change'] . $global_config_arr['virtualhost'];
				if ( @send_mail ( stripslashes ( $_POST['usermail'] ), $email_betreff, $template_mail ) ) {
				    $message .= "<br>E-Mail mit neuen Zugangsdaten wurde erfolgreich gesendet";
				} else {
				    $message .= "<br>E-Mail mit neuen Zugangsdaten konnte nicht gesendet werden";
				}

            } else {
                $message .= "<br>" . $phrases[pass_failed] . "<br>" . $phrases[pass_newwrong];
            }

        } else {
            $message .= "<br>" . $phrases[pass_failed] . "<br>" . $phrases[pass_oldwrong];
        }

    }

    // Meldung ausgebena
    $template .= sys_message("Profil", $message);
}

//////////////////////////////
////// Profil editieren //////
//////////////////////////////

else
{
    if ($_SESSION[user_level] == "loggedin")
    {
        $index = mysql_query("SELECT * FROM ".$global_config_arr['pref']."user WHERE user_id = $_SESSION[user_id]", $db);
        $user_arr = mysql_fetch_assoc($index);
        $dbshowmail = $user_arr[show_mail];
        $user_arr[show_mail] = ($user_arr[show_mail] == 1) ? "checked" : "";

        // Avatar vorhanden?
        if (image_exists("images/avatare/", $_SESSION[user_id]))
        {
            $user_arr[user_avatar] = '<img src="'.image_url("images/avatare/",$_SESSION[user_id]).'" />';
        }
        else
        {
            $user_arr[user_avatar] = $phrases[no_avatar];
        }

        // Template aufbauen
        $index = mysql_query("SELECT user_profiledit FROM ".$global_config_arr['pref']."template WHERE id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index, 0, "user_profiledit"));
        $template = str_replace("{avatar}", $user_arr[user_avatar], $template); 
        $template = str_replace("{email}", $user_arr[user_mail], $template); 
        $template = str_replace("{email_zeigen}", $user_arr[show_mail], $template);
        $template = str_replace("{username}", $user_arr[user_name], $template);

    }
    else  // Login Formular anzeigen
    {
        $_SESSION[last_url] = "editprofil";
        include( FS2_ROOT_PATH . "data/login.php");
    }
}

?>