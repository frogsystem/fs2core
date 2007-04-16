<?php

///////////////////////////
///// User hinzufügen /////
///////////////////////////

if ($_POST[username] && $_POST[userpass1] && $_POST[usermail])
{
    $_POST[username] = savesql($_POST[username]);
    $_POST[usermail] = savesql($_POST[usermail]);
    $userpass = $_POST[userpass1];
    $_POST[userpass2] = md5(savesql($_POST[userpass1]));

    // Username schon vorhanden?
    $index = mysql_query("select user_name from fs_user where user_name = '$_POST[username]'", $db);
    if (mysql_num_rows($index) > 0)
    {
        sys_message($phrases[sysmessage], $phrases[user_exists]);

        // Registerformular erneut ausgeben
        $index = mysql_query("select user_register from fs_template where id = '$global_config_arr[design]'", $db);
        echo stripslashes(mysql_result($index, 0, "user_register"));
    }

    else
    {
        $regdate = time();
        $index = mysql_query("select email_register from fs_template where id = '$global_config_arr[design]'", $db);
        $template = stripslashes(mysql_result($index, 0, "email_register"));
        $template = str_replace("{username}", $_POST[username], $template); 
        $template = str_replace("{passwort}", $_POST[userpass1], $template);

        $email_betreff = $phrases[registration] . " @ " . $global_config_arr[virtual_host];
        $header="From: ".$phrases[registration]." @ ".$global_config_arr[virtual_host]."\n"; 
        $header .= "Reply-To: ".$phrases[registration]." @ ".$global_config_arr[virtual_host]."\n"; 
        $header .= "Bcc: $_POST[usermail]\n"; 
        $header .= "X-Mailer: PHP/" . phpversion(). "\n"; 
        $header .= "X-Sender-IP: $REMOTE_ADDR\n"; 
        $header .= "Content-Type: text/html"; 
        mail($_POST[usermail], $email_betreff, $template,$header); 

        $adduser = 'INSERT INTO fs_user (user_name, user_password, user_mail, reg_date)
                    VALUES ("'.$_POST[username].'",
                            "'.$_POST[userpass2].'",
                            "'.$_POST[usermail].'",
                            "'.$regdate.'");';
        mysql_query($adduser, $db);
        mysql_query("update fs_counter set user=user+1", $db);
        sys_message($phrases[sysmessage], $phrases[registered]);
    }
}

///////////////////////////
//// Register Formular ////
///////////////////////////

else
{
    $index = mysql_query("select user_register from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "user_register"));
}
?>