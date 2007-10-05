<?php

//////////////////////////////
//// Profil aktualisieren ////
//////////////////////////////

if ($_POST[usermail] && $_SESSION[user_id])
{
    include("adminfunctions.php");

    settype($_POST[userid], "integer");

    // Avatar hochladen, wenn vorhanden
    if ($_FILES[userpic][tmp_name])
    {
        image_delete("images/avatare/", $_SESSION[user_id]);
        $upload = upload_img($_FILES[userpic], "images/avatare/", $_SESSION[user_id], 30*1024, 110, 110);
        $message = upload_img_notice($upload)."<br />";
    }

    // User Daten aktualisieren
    $_POST[showmail] = isset($_POST[showmail]) ? 1 : 0;
    $update = "update ".$global_config_arr[pref]."user
               set user_mail = '$_POST[usermail]',
                   show_mail = '$_POST[showmail]'
               where user_id = $_SESSION[user_id]";
    mysql_query($update, $db);
    $message .= $phrases[profile_update];

    // Neues Passwort eintragen 
    if ($_POST[userpassword])
    {
        $_POST[usermail] = savesql($_POST[usermail]);
        $mailpass = $_POST[userpassword];
        $_POST[userpassword] = md5($_POST[userpassword]);
        
        $index = mysql_query("SELECT user_password FROM ".$global_config_arr[pref]."user WHERE user_id = '$_SESSION[user_id]'", $db);
        $oldpass = mysql_result($index, 0, "user_password");
        
        if ($_POST[userpassword]!=$oldpass)
        {
            //MAIl TEMPLATE
            $index = mysql_query("SELECT email_passchange FROM ".$global_config_arr[pref]."template WHERE id = $global_config_arr[design]", $db);
            $template_mail = stripslashes(mysql_result($index, 0, "email_passchange"));
            $template_mail = str_replace("{username}", $_SESSION[user_name], $template_mail);
            $template_mail = str_replace("{password}", $mailpass, $template_mail);

            //SEND MAIL
            $email_betreff = $phrases[pass_change] . " @ " . $global_config_arr[virtualhost];
            $header="From: ".$global_config_arr[admin_mail]."\n";
            $header .= "Reply-To: ".$global_config_arr[admin_mail]."\n";
            $header .= "X-Mailer: PHP/" . phpversion(). "\n";
            $header .= "X-Sender-IP: $REMOTE_ADDR\n";
            $header .= "Content-Type: text/plain";
            mail($_POST[usermail], $email_betreff, $template_mail, $header);
            
            //UPDATE PASSWORD
            $update = "UPDATE ".$global_config_arr[pref]."user SET user_password = '$_POST[userpassword]' WHERE user_id = $_SESSION[user_id]";
            mysql_query($update, $db);
            $message .= "<br />".$phrases[pass_update];
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
        $index = mysql_query("select * from ".$global_config_arr[pref]."user where user_id = $_SESSION[user_id]", $db);
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
        $index = mysql_query("select user_profiledit from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index, 0, "user_profiledit"));
        $template = str_replace("{avatar}", $user_arr[user_avatar], $template); 
        $template = str_replace("{email}", $user_arr[user_mail], $template); 
        $template = str_replace("{email_zeigen}", $user_arr[show_mail], $template);
        $template = str_replace("{username}", $user_arr[user_name], $template);

    }
    else  // Login Formular anzeigen
    {
        $_SESSION[last_url] = "editprofil";
        include("data/login.php");
    }
}

?>