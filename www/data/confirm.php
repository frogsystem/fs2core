<?php

// confirm by hash
if (isset($_GET['h'])) {
    
    // hash mapper
    $hm = new HashMapper();
    try {
		$hash = $hm->getByHash($_GET['h']);

        // switch cases
        switch($hash->getType()) {
            case "newpassword":
                //load user data from db
                $userdata = $FD->sql()->getById("user", array("user_id", "user_name", "user_mail"), $hash->getTypeId(), "user_id");
            
                // create new Password
                $newpassword = generate_pwd(15);
                $salt = generate_pwd(10);
                $userdata['user_password'] = md5($newpassword.$salt);
                $userdata['user_salt'] = $salt;
                
                // save password todb
                $FD->sql()->save("user", $userdata, "user_id");
        
                // set message
                $messages = array($FD->text('frontend', "new_password_confirmed_text"));
    
                // send email
                $mm = new MailManager();

                $mail_subject = $FD->text('frontend', "mail_password_changed_on") . $FD->cfg('virtualhost');
                $content = get_email_template ("change_password");
                $content = str_replace ( "{..user_name..}", $userdata['user_name'], $content );
                $content = str_replace ( "{..new_password..}", $newpassword, $content );
                if ($mm->getHtmlConfig())
                    $content = fscode($content, true, true, true);
                $content = tpl_functions($content, 0, array("VAR"));
                
                // Build Mail and send
                $mail = new Mail($mm->getDefaultSender(), $userdata['user_mail'], $mail_subject, $content, $mm->getHtmlConfig());
                if ($mail->send()) {
                    $messages[] = $FD->text('frontend', "mail_new_password_sended");
                } else {
                    $messages[] = $FD->text('frontend', "mail_new_password_not_sended");
                }
                
                // forward
                $template = forward_message($FD->text('frontend', "new_password_confirmed_title"), implode("<br>", $messages), '?go='.$FD->cfg('home_real'));
                break;
                
            default:
                $template = sys_message($FD->text('frontend', "error"), $FD->text('frontend', "hash_not_found"));
                break;
        }

        // Delete Hash
        $hm->delete($hash);
        
	} catch (Exception $e) {
        $template = sys_message($FD->text('frontend', "error"), $FD->text('frontend', "hash_not_found"));
	}
// Default Page
} else {
    $template = sys_message($FD->text('frontend', "error"), $FD->text('frontend', "hash_not_found"));
}

?>
