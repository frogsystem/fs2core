<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ( TRUE
    && ( $_POST['signup'] && $_POST['signup'] != "" )
    && ( $_POST['change_password'] && $_POST['change_password'] != "" )
    && ( $_POST['use_admin_mail'] == 1 || ( $_POST['use_admin_mail'] == 0 && $_POST['email'] != "" ) )
   )
{
    // security functions
    settype ( $_POST['use_admin_mail'], "integer" );
    settype ( $_POST['html'], "integer" );

    $_POST['signup'] = savesql ( $_POST['signup'] );
    $_POST['change_password'] = savesql ( $_POST['change_password'] );
    #$_POST['delete_account'] = savesql ( $_POST['delete_account'] );
    $_POST['email'] = savesql ( $_POST['email'] );
    
    // MySQL-Queries
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."email`
                    SET
                        `signup` = '".$_POST['signup']."',
                        `change_password` = '".$_POST['change_password']."',
                        `use_admin_mail` = '".$_POST['use_admin_mail']."',
                        `email` = '".$_POST['email']."',
                        `html` = '".$_POST['html']."'
                    WHERE `id` = '1'
    ", $db );

    // system messages
    systext( $admin_phrases[common][changes_saved], $admin_phrases[common][info], FALSE, $admin_phrases[icons][save_ok] );

    // Unset Vars
    unset ( $_POST );
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
    // Display Error Messages
    if ( isset ( $_POST['sended'] ) ) {
        systext ( $admin_phrases[common][changes_not_saved].'<br>'.$admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE, $admin_phrases[icons][save_error] );

    // Load Data from DB into Post
    } else {
        $index = mysql_query ( "
                                SELECT *
                                FROM ".$global_config_arr['pref']."email
                                WHERE `id` = '1'
        ", $db);
        $email_arr = mysql_fetch_assoc($index);
        putintopost ( $email_arr );
    }

    // security functions
    settype ( $_POST['use_admin_mail'], "integer" );
    settype ( $_POST['html'], "integer" );

    $_POST['signup'] = killhtml ( $_POST['signup'] );
    $_POST['change_password'] = killhtml ( $_POST['change_password'] );
    #$_POST['delete_account'] = killhtml ( $_POST['delete_account'] );
    $_POST['email'] = killhtml ( $_POST['email'] );
    
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="gen_emails">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    Abesender-Adresse:<br>
                                    <span class="small">Absender-Adresse die bei gesendeten E-Mails angegeben wird.</span>
                                </td>
                                <td class="config">
                                    <table>
                                        <tr valign="bottom">
                                            <td class="config">
                                                <input class="pointer" type="radio" name="use_admin_mail" value="1" '.getchecked ( 1, $_POST['use_admin_mail'] ).'>
                                            </td>
                                            <td class="config">
                                                Standard ('.$global_config_arr['admin_mail'].')
                                            </td>
                                        </tr>
                                        <tr valign="bottom">
                                             <td class="config">
                                                <input class="pointer" type="radio" name="use_admin_mail" value="0" '.getchecked ( 0, $_POST['use_admin_mail'] ).'>
                                            </td>
                                            <td class="config">
                                                <input class="text" size="20" name="email" maxlength="100" value="'.$_POST['email'].'">
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    als HTML senden:<br>
                                    <span class="small">Sendet die E-Mails im HTML-Format.</span>
                                </td>
                                <td class="config">
                                    &nbsp;<input class="pointer middle" type="checkbox" name="html" value="1" '.getchecked ( 1, $_POST['html'] ).'>
                                    <span class="small">[Ermöglicht die Verwendung von HTML und FSCode.]</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][email_templates_title].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[general][email_reg_title].'<br />
                                    <font class="small">'.$admin_phrases[general][email_reg_desc].'</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <span class="small" style="padding-bottom:5px; display:block;"><b>'.$admin_phrases[common][valid_tags].':</b></span>
                                    <span class="small">
                                        '.insert_tt("{..user_name..}",$admin_phrases[general][email_username],"signup").'
                                        '.insert_tt("{..new_password..}",$admin_phrases[general][email_password],"signup").'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor("signup", $_POST['signup'], "100%", "200px", "", FALSE).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[general][email_newpwd_title].'<br />
                                    <font class="small">'.$admin_phrases[general][email_newpwd_desc].'</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <span class="small" style="padding-bottom:5px; display:block;"><b>'.$admin_phrases[common][valid_tags].':</b></span>
                                    <span class="small">
                                        '.insert_tt("{..user_name..}",$admin_phrases[general][email_username],"change_password").'
                                        '.insert_tt("{..new_password..}",$admin_phrases[general][email_password],"change_password").'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor("change_password", $_POST['change_password'], "100%", "200px", "", FALSE).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

/*
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[general][email_delete_title].'<br />
                                    <font class="small">'.$admin_phrases[general][email_delete_desc].'</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <span class="small" style="padding-bottom:5px; display:block;"><b>'.$admin_phrases[common][valid_tags].':</b></span>
                                    <span class="small">
                                        '.insert_tt("{..X..}",$admin_phrases[general][email_username],"delete_account").'
                                        '.insert_tt("{..X..}",$admin_phrases[general][email_password],"delete_account").'
                                        '.insert_tt("{..X..}",$admin_phrases[general][email_virtualhost],"delete_account").'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor("delete_account", $_POST['delete_account'], "100%", "200px", "", FALSE).'
                                </td>
                            </tr>
*/
?>