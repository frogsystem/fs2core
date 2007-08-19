<?php
///////////////////
//// Anti-Spam ////
///////////////////
session_start();
function encrypt($string, $key) {
$result = '';
for($i=0; $i<strlen($string); $i++) {
   $char = substr($string, $i, 1);
   $keychar = substr($key, ($i % strlen($key))-1, 1);
   $char = chr(ord($char)+ord($keychar));
   $result.=$char;
}
return base64_encode($result);
}
$sicherheits_eingabe = encrypt($_POST["spam"], "3g9sp3hr45");
$sicherheits_eingabe = str_replace("=", "", $sicherheits_eingabe);

///////////////////////////
///// User hinzufügen /////
///////////////////////////

if ($global_config_arr[registration_antispam]==0) {
    $anti_spam = true;
} elseif ($sicherheits_eingabe == $_SESSION['rechen_captcha_spam'] AND is_numeric($_POST["spam"]) == true AND $sicherheits_eingabe == true) {
    $anti_spam = true;
} else {
    $anti_spam = false;
}

if ($_POST[username] && $_POST[userpass1] && $_POST[usermail])
{
    $_POST[username] = savesql($_POST[username]);
    $_POST[usermail] = savesql($_POST[usermail]);
    $userpass = $_POST[userpass1];
    $_POST[userpass2] = md5(savesql($_POST[userpass1]));

    // Username schon vorhanden? oder anti spam falsch?
    $index = mysql_query("select user_name from fs_user where user_name = '$_POST[username]'", $db);
    if (mysql_num_rows($index) > 0 OR $anti_spam != true)
    {
        $sysmeldung = "";
        if (mysql_num_rows($index) > 0) { $sysmeldung .= $phrases[user_exists]; }
        if (mysql_num_rows($index) > 0 AND $anti_spam != true) { $sysmeldung .= "<br />"; }
        if ($anti_spam != true) { $sysmeldung .= $phrases[user_antispam]; }
        $template .= sys_message($phrases[sysmessage], $sysmeldung);
        
        // Registerformular erneut ausgeben
        $index = mysql_query("select user_spam from fs_template where id = '$global_config_arr[design]'", $db);
        $user_spam = stripslashes(mysql_result($index, 0, "user_spam"));
        $user_spam = str_replace("{captcha_url}", "res/rechen-captcha.inc.php", $user_spam);

        $index = mysql_query("select user_spamtext from fs_template where id = '$global_config_arr[design]'", $db);
        $user_spam_text = stripslashes(mysql_result($index, 0, "user_spamtext"));

        $index = mysql_query("select user_register from fs_template where id = '$global_config_arr[design]'", $db);
        $template_form .= stripslashes(mysql_result($index, 0, "user_register"));
        $template_form = str_replace("{antispam}", $user_spam, $template_form);
        $template_form = str_replace("{antispamtext}", $user_spam_text, $template_form);
        $template .= $template_form;
    }

    else
    {
        $regdate = time();
        $index = mysql_query("select email_register from fs_template where id = '$global_config_arr[design]'", $db);
        $template_mail = stripslashes(mysql_result($index, 0, "email_register"));
        $template_mail = str_replace("{username}", $_POST[username], $template_mail);
        $template_mail = str_replace("{password}", $_POST[userpass1], $template_mail);

        $email_betreff = $phrases[registration] . " @ " . $global_config_arr[virtualhost];
        $header  = "From: ".$global_config_arr[admin_mail]."\n";
        $header .= "Reply-To: ".$global_config_arr[admin_mail]."\n";
        $header .= "X-Mailer: PHP/" . phpversion(). "\n"; 
        $header .= "X-Sender-IP: $REMOTE_ADDR\n"; 
        $header .= "Content-Type: text/plain";
        mail($_POST[usermail], $email_betreff, $template_mail, $header);

        $adduser = 'INSERT INTO fs_user (user_name, user_password, user_mail, reg_date)
                    VALUES ("'.$_POST[username].'",
                            "'.$_POST[userpass2].'",
                            "'.$_POST[usermail].'",
                            "'.$regdate.'");';
        mysql_query($adduser, $db);
        mysql_query("update fs_counter set user=user+1", $db);
        $template = sys_message($phrases[sysmessage], $phrases[registered]);
    }
}

///////////////////////////
//// Register Formular ////
///////////////////////////

else
{
    $index = mysql_query("select user_spam from fs_template where id = '$global_config_arr[design]'", $db);
    $user_spam = stripslashes(mysql_result($index, 0, "user_spam"));
    $user_spam = str_replace("{captcha_url}", "res/rechen-captcha.inc.php", $user_spam);

    $index = mysql_query("select user_spamtext from fs_template where id = '$global_config_arr[design]'", $db);
    $user_spam_text = stripslashes(mysql_result($index, 0, "user_spamtext"));

    if ($global_config_arr[registration_antispam]==0)
    {
        $user_spam = "";
        $user_spam_text = "";
    }

    $index = mysql_query("select user_register from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "user_register"));
    $template = str_replace("{antispam}", $user_spam, $template);
    $template = str_replace("{antispamtext}", $user_spam_text, $template);
}
?>