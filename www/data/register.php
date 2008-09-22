<?php
/////////////////////
//// Load Config ////
/////////////////////
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."user_config", $db );
$config_arr = mysql_fetch_assoc($index);
$show_form = TRUE;
$template = "";

///////////////////
//// Anti-Spam ////
///////////////////
$anti_spam = check_captcha ( $_POST['spam'], $config_arr['registration_antispam'] );

//////////////////
//// Add User ////
//////////////////

if ( $_POST['username'] && $_POST['usermail'] && $_POST['newpwd'] && $_POST['wdhpwd'] )
{
    $_POST['username'] = savesql ( $_POST['username'] );
    $_POST['usermail'] = savesql ( $_POST['usermail'] );
    $user_salt = generate_pwd ( 10 );
    $userpass = md5 ( $_POST['newpwd'].$user_salt );
    $userpass_mail = $_POST['newpwd'];
    
    // user exists or nagative anti spam
    $index = mysql_query ( "
							SELECT COUNT(`user_id`) AS 'number'
							FROM ".$global_config_arr['pref']."user
							WHERE user_name = '".$_POST['username']."'
	", $db);
    $existing_users = mysql_result ( $index, 0, "number" );
    
	// get error message
	if ( $existing_users > 0 || $anti_spam != TRUE || $_POST['newpwd'] != $_POST['wdhpwd'] )
    {
        unset( $sysmeldung );
        if ( $existing_users > 0 ) {
            $sysmeldung[] = $phrases[user_exists];
        }
        if ( $anti_spam != TRUE ) {
            $sysmeldung[] = $phrases[user_antispam];
        }
        if ( $_POST['newpwd'] != $_POST['wdhpwd']) {
            $sysmeldung[] = $phrases[passnotequal];
        }
        $template .= sys_message ( $phrases[sysmessage], implode ( "<br>", $sysmeldung ) );

	    // Unset Vars
	    unset ( $_POST );
    }

    else
    {
        $regdate = time();
        
		// send email
		$template_mail = get_email_template ( "signup" );
		$template_mail = str_replace ( "{username}", stripslashes ( $_POST['username'] ), $template_mail );
		$template_mail = str_replace ( "{password}", $userpass_mail, $template_mail );
		$template_mail = str_replace ( "{virtualhost}", $global_config_arr['virtualhost'], $template_mail );
		$email_betreff = $phrases['registration'] . $global_config_arr['virtualhost'];
		@send_mail ( stripslashes ( $_POST['usermail'] ), $email_betreff, $template_mail );

        $adduser = "INSERT INTO ".$global_config_arr['pref']."user
						(user_name, user_password, user_salt, user_mail, user_reg_date)
                    VALUES ('".$_POST['username']."',
                            '".$userpass."',
                            '".$user_salt."',
                            '".$_POST['usermail']."',
                            '".$regdate."')";
        mysql_query ( $adduser, $db );
        
        $index = mysql_query ( "SELECT COUNT(user_id) AS user FROM ".$global_config_arr['pref']."user", $db );
        $new_user_num = mysql_result ( $index,0,"user" );
        mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET user = '".$new_user_num."'", $db );
        
        $template .= sys_message($phrases[sysmessage], $phrases[registered]);
        
        unset($_POST);
        $show_form = false;
    }
}

/////////////////////////////
//// Bereits Registriert ////
/////////////////////////////

if ($_SESSION["user_id"])
{
    $show_form = false;
    $template .= sys_message($phrases[sysmessage], $phrases[not_twice]);
}


///////////////////////////
//// Register Formular ////
///////////////////////////

if ($show_form == true)
{
    $index = mysql_query("SELECT user_spam FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
    $user_spam = stripslashes(mysql_result($index, 0, "user_spam"));
    $user_spam = str_replace("{captcha_url}", "res/rechen-captcha.inc.php?i=".generate_pwd(8), $user_spam);

    $index = mysql_query("SELECT user_spamtext FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
    $user_spam_text = stripslashes(mysql_result($index, 0, "user_spamtext"));

    if ($config_arr[registration_antispam]==0)
    {
        $user_spam = "";
        $user_spam_text = "";
    }

    $index = mysql_query("SELECT user_register FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
    $template_form = stripslashes(mysql_result($index, 0, "user_register"));
    $template_form = str_replace("{antispam}", $user_spam, $template_form);
    $template_form = str_replace("{antispamtext}", $user_spam_text, $template_form);
    $template .= $template_form;
}
?>