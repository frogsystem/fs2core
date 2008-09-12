<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if (TRUE
    && ( $_POST['signup'] && $_POST['signup'] != "" )
    && ( $_POST['change_password'] && $_POST['change_password'] != "" )
    && ( $_POST['delete_account'] && $_POST['delete_account'] != "" )
   )
{
    $_POST['signup'] = savesql ( $_POST['signup'] );
    $_POST['change_password'] = savesql ( $_POST['change_password'] );
    $_POST['delete_account'] = savesql ( $_POST['delete_account'] );
    
    mysql_query ( "UPDATE ".$global_config_arr['pref']."email_template
                   SET template_text = '".$_POST['signup']."'
                   WHERE template_name = 'signup'", $db );
                   
    mysql_query ( "UPDATE ".$global_config_arr['pref']."email_template
                   SET template_text = '".$_POST['change_password']."'
                   WHERE template_name = 'change_password'", $db );
                   
    mysql_query ( "UPDATE ".$global_config_arr['pref']."email_template
                   SET template_text = '".$_POST['delete_account']."'
                   WHERE template_name = 'delete_account'", $db );


    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);
}

/////////////////////////////////
/////// Formular erzeugen ///////
/////////////////////////////////

else
{
    $index = mysql_query ( "SELECT template_text FROM ".$global_config_arr[pref]."email_template WHERE template_name = 'signup'", $db );
    $config_arr['signup'] = mysql_result ( $index, 0, "template_text" );
    $index = mysql_query ( "SELECT template_text FROM ".$global_config_arr[pref]."email_template WHERE template_name = 'change_password'", $db );
    $config_arr['change_password'] = mysql_result ( $index, 0, "template_text" );
    $index = mysql_query ( "SELECT template_text FROM ".$global_config_arr[pref]."email_template WHERE template_name = 'delete_account'", $db );
    $config_arr['delete_account'] = mysql_result ( $index, 0, "template_text" );

    if (isset($_POST['sended']))
    {
        $config_arr['signup'] = $_POST['signup'];
        $config_arr['change_password'] = $_POST['change_password'];
        $config_arr['delete_account'] = $_POST['delete_account'];

        systext($admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE);
    }

    $config_arr['signup'] = killhtml ( $config_arr['signup'] );
    $config_arr['change_password'] = killhtml ( $config_arr['change_password'] );
    $config_arr['delete_account'] = killhtml ( $config_arr['delete_account'] );

    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="gen_emails">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][email_info].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <font class="small">'.$admin_phrases[general][email_info_text].'</font>
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
                                        '.insert_tt("{username}",$admin_phrases[general][email_username],"signup").'
                                        '.insert_tt("{password}",$admin_phrases[general][email_password],"signup").'
                                        '.insert_tt("{virtualhost}",$admin_phrases[general][email_virtualhost],"signup").'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor("signup", $config_arr['signup'], "100%", "150px", "", FALSE).'
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
                                        '.insert_tt("{username}",$admin_phrases[general][email_username],"change_password").'
                                        '.insert_tt("{password}",$admin_phrases[general][email_password],"change_password").'
                                        '.insert_tt("{virtualhost}",$admin_phrases[general][email_virtualhost],"change_password").'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor("change_password", $config_arr['change_password'], "100%", "150px", "", FALSE).'
                                </td>
                            </tr>
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
                                        '.insert_tt("{username}",$admin_phrases[general][email_username],"delete_account").'
                                        '.insert_tt("{password}",$admin_phrases[general][email_password],"delete_account").'
                                        '.insert_tt("{virtualhost}",$admin_phrases[general][email_virtualhost],"delete_account").'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor("delete_account", $config_arr['delete_account'], "100%", "150px", "", FALSE).'
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
?>