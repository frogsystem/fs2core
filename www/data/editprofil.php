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
        $valid_pic = pic_upload($_FILES[userpic], "images/avatare/", $_SESSION[user_id], 110, 110, 0, 0, false, 80, "gif");
        switch ($valid_pic)
        {
            case 0:
                $message = $phrases[avatar_loaded].'<br>';
                break;
            case 1:
                $message = $phrases[avatar_no_jpggif].'<br>';
                break;
            case 2:
                $message = $phrases[avatar_to_big].'<br>';
                break;
        }
    }

    // User Daten aktualisieren
    $_POST[showmail] = isset($_POST[showmail]) ? 1 : 0;
    $update = "update fs_user
               set user_mail = '$_POST[usermail]',
                   show_mail = '$_POST[showmail]'
               where user_id = $_SESSION[user_id]";
    mysql_query($update, $db);

    // Neues Passwort eintragen 
    if ($_POST[userpassword])
    {
        $_POST[usermail] = savesql($_POST[usermail]);
        $mailpass = $_POST[userpassword];

        $index = mysql_query("select email_passchange from fs_template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index, 0, "email_passchange"));
        $template = str_replace("{username}", $_SESSION[user_name], $template); 
        $template = str_replace("{passwort}", $mailpass, $template);

        $email_betreff = $phrases[pass_change] . " @ " . $global_config_arr[virtualhost];
        $header="From: ".$phrases[registration]." @ ".$global_config_arr[virtualhost]."\n"; 
        $header .= "Reply-To: ".$phrases[registration]." @ ".$global_config_arr[virtualhost]."\n"; 
        $header .= "Bcc: $usermail\n"; 
        $header .= "X-Mailer: PHP/" . phpversion(). "\n"; 
        $header .= "X-Sender-IP: $REMOTE_ADDR\n"; 
        $header .= "Content-Type: text/plain"; 
        mail($_POST[usermail], $email_betreff, $template, $header); 
        $_POST[userpassword] = md5($_POST[userpassword]);
        $update = "update fs_user set user_password = '$_POST[userpassword]' where user_id = $_SESSION[user_id]";
        mysql_query($update, $db);
    }

    // Meldung ausgeben
    $message .= $phrases[profile_update];
    $template .= sys_message("Profil", $message);
}

//////////////////////////////
////// Profil editieren //////
//////////////////////////////

else
{
    if ($_SESSION[user_level] == "loggedin")
    {
        $index = mysql_query("select * from fs_user where user_id = $_SESSION[user_id]", $db);
        $user_arr = mysql_fetch_assoc($index);
        $dbshowmail = $user_arr[show_mail];
        $user_arr[show_mail] = ($user_arr[show_mail] == 1) ? "checked" : "";

        // Avatar vorhanden?
        if (file_exists("images/avatare/".$_SESSION[user_id].".gif"))
        {
            $user_arr[user_avatar] = '<img src="images/avatare/'.$_SESSION[user_id].'.gif">';
        }
        else
        {
            $user_arr[user_avatar] = $phrases[no_avatar];
        }

        // Template aufbauen
        $index = mysql_query("select user_profiledit from fs_template where id = '$global_config_arr[design]'", $db);
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