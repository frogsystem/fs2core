<?php if (!defined('ACP_GO')) die('Unauthorized access!');

/////////////////////////
//// Database update ////
/////////////////////////

if (   ( isset($_POST['signup']) && $_POST['signup'] != '' )
    && ( isset($_POST['change_password']) && $_POST['change_password'] != '' )
    && !empty($_POST['change_password_ack'])
    && ( $_POST['use_admin_mail'] == 1 || ( $_POST['use_admin_mail'] == 0 && $_POST['email'] != '' ) )
   )
{
    // security functions
    settype ( $_POST['use_admin_mail'], 'integer' );
    settype ( $_POST['html'], 'integer' );

    // SQL-Queries
    $stmt = $sql->conn()->prepare ( '
                UPDATE `'.$FD->config('pref')."email`
                SET
                    `signup` = ?,
                    `change_password` = ?,
                    `change_password_ack` = ?,
                    `use_admin_mail` = '".$_POST['use_admin_mail']."',
                    `email` = ?,
                    `html` = '".$_POST['html']."'
                WHERE `id` = '1'" );
    $stmt->execute( array(
                        $_POST['signup'],
                        $_POST['change_password'],
                        $_POST['change_password_ack'],
                        $_POST['email'] ));
    // system messages
    systext( $FD->text('page', 'changes_saved'), $FD->text('page', 'info'), FALSE, $FD->text('page', 'save_ok') );

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
        systext ( $FD->text('page', 'changes_not_saved').'<br>'.$FD->text('page', 'note_notfilled'), $FD->text('page', 'error'), TRUE, $FD->text('page', 'save_error') );

    // Load Data from DB into Post
    } else {
        $index = $sql->conn()->query ( '
                        SELECT *
                        FROM '.$FD->config('pref')."email
                        WHERE `id` = '1'" );
        $email_arr = $index->fetch(PDO::FETCH_ASSOC);
        putintopost ( $email_arr );
    }

    // security functions
    settype ( $_POST['use_admin_mail'], 'integer' );
    settype ( $_POST['html'], 'integer' );

    $_POST['signup'] = killhtml ( $_POST['signup'] );
    $_POST['change_password'] = killhtml ( $_POST['change_password'] );
    $_POST['change_password_ack'] = killhtml ( $_POST['change_password_ack'] );
    $_POST['email'] = killhtml ( $_POST['email'] );

    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="gen_emails">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'sender_email').':<br>
                                    <span class="small">'.$FD->text('page', 'sender_email_desc').'</span>
                                </td>
                                <td class="config">
                                    <table>
                                        <tr valign="bottom">
                                            <td class="config">
                                                <input class="pointer" type="radio" name="use_admin_mail" value="1" '.getchecked ( 1, $_POST['use_admin_mail'] ).'>
                                            </td>
                                            <td class="config">
                                                '.$FD->text('admin', 'default').' ('.$FD->config('admin_mail').')
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
                                    '.$FD->text('page', 'send_as_html').':<br>
                                    <span class="small">'.$FD->text('page', 'send_as_html_desc').'</span>
                                </td>
                                <td class="config">
                                    &nbsp;<input class="pointer middle" type="checkbox" name="html" value="1" '.getchecked ( 1, $_POST['html'] ).'>
                                    <span class="small">['.$FD->text('page', 'send_as_html_info').']</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$FD->text('page', 'email_templates_title').'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$FD->text("page", "email_reg_title").'<br />
                                    <span class="small">'.$FD->text('page', 'email_reg_desc').'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <span class="small" style="padding-bottom:5px; display:block;"><b>'.$FD->text('page', 'valid_tags').':</b></span>
                                    <span class="small">
                                        '.insert_tt('{..user_name..}',$FD->text('page', 'email_username'),'signup').'
                                        '.insert_tt('{..new_password..}',$FD->text('page', 'email_password'),'signup').'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor('signup', $_POST['signup'], '100%', '200px', '', FALSE).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$FD->text('page', 'email_newpwd_title').'<br />
                                    <span class="small">'.$FD->text('page', 'email_newpwd_desc').'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <span class="small" style="padding-bottom:5px; display:block;"><b>'.$FD->text('page', 'valid_tags').':</b></span>
                                    <span class="small">
                                        '.insert_tt('{..user_name..}',$FD->text('page', 'email_username'),'change_password').'
                                        '.insert_tt('{..new_password..}',$FD->text('page', 'email_password'),'change_password').'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor('change_password', $_POST['change_password'], '100%', '200px', '', FALSE).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$FD->text('page', 'change_password_ack_title').'<br />
                                    <span class="small">'.$FD->text('page', 'change_password_ack_desc').'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    <span class="small" style="padding-bottom:5px; display:block;"><b>'.$FD->text('page', 'valid_tags').':</b></span>
                                    <span class="small">
                                        '.insert_tt('{..user_name..}',$FD->text('page', 'email_username'),'change_password_ack').'
                                        '.insert_tt('{..new_password_url...}',$FD->text('page', 'new_password_url'),'change_password_ack').'
                                    </span>
                                </td>
                                <td class="config">
                                    '.create_editor('change_password_ack', $_POST['change_password_ack'], '100%', '200px', '', FALSE).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>

                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'save_changes_button').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

?>
