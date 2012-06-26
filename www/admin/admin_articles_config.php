<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('acp_per_page', 'html_code', 'fs_code', 'para_handling', 'cat_pic_x', 'cat_pic_y', 'cat_pic_size', 'com_rights', 'com_antispam', 'com_sort', 'acp_per_page', 'acp_view');

///////////////////////
//// Update Config ////
///////////////////////
if (
	isset($_POST['cat_pic_x']) && $_POST['cat_pic_x'] > 0
	&& isset($_POST['cat_pic_y']) && $_POST['cat_pic_y'] > 0
	&& isset($_POST['cat_pic_size']) && $_POST['cat_pic_size'] > 0
	&& isset($_POST['acp_per_page']) && $_POST['acp_per_page'] > 0
    )
{
    // prepare data
    $data = frompost($used_cols);

    // save config
    try {
        $FD->saveConfig('articles', $data);
        systext($FD->text('admin', 'changes_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
    } catch (Exception $e) {
        systext($FD->text('admin', 'changes_not_saved'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));
    }

    // Unset Vars
    unset($_POST);
}

/////////////////////
//// Config Form ////
/////////////////////

if ( TRUE )
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $data = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'articles'"));
        $data = json_array_decode($data['config_data']);
        putintopost($data);
    }    

    // security functions
    $_POST = array_map('killhtml', $_POST);

    // Display Form
    echo '
					<form action="" method="post">
                        <input type="hidden" name="go" value="articles_config">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text("page", "post_settings_title").'</td></tr>
                            <tr>
								<td class="config" colspan="2">
								    <span class="small">'.$FD->text("page", "post_settings_info").'<br><br></span>
								</td>
							</tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "allow_html").':<br>
                                    <span class="small">'.$FD->text("page", "allow_html_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="html_code">
                                        <option value="1" '.getselected ( 1, $_POST['html_code'] ).'>'.$FD->text("page", "allow_code_no").'</option>
                                        <option value="2" '.getselected ( 2, $_POST['html_code'] ).'>'.$FD->text("page", "allow_code_articles").'</option>
                                        <option value="3" '.getselected ( 3, $_POST['html_code'] ).'>'.$FD->text("page", "allow_code_comments").'</option>
                                        <option value="4" '.getselected ( 4, $_POST['html_code'] ).'>'.$FD->text("page", "allow_code_both").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "allow_fs").':<br>
                                    <span class="small">'.$FD->text("page", "allow_fs_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="fs_code">
                                        <option value="1" '.getselected ( 1, $_POST['fs_code'] ).'>'.$FD->text("page", "allow_code_no").'</option>
                                        <option value="2" '.getselected ( 2, $_POST['fs_code'] ).'>'.$FD->text("page", "allow_code_articles").'</option>
                                        <option value="3" '.getselected ( 3, $_POST['fs_code'] ).'>'.$FD->text("page", "allow_code_comments").'</option>
                                        <option value="4" '.getselected ( 4, $_POST['fs_code'] ).'>'.$FD->text("page", "allow_code_both").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "allow_para").':<br>
                                    <span class="small">'.$FD->text("page", "allow_para_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="para_handling">
                                        <option value="1" '.getselected ( 1, $_POST['para_handling'] ).'>'.$FD->text("page", "allow_code_no").'</option>
                                        <option value="2" '.getselected ( 2, $_POST['para_handling'] ).'>'.$FD->text("page", "allow_code_articles").'</option>
                                        <option value="3" '.getselected ( 3, $_POST['para_handling'] ).'>'.$FD->text("page", "allow_code_comments").'</option>
                                        <option value="4" '.getselected ( 4, $_POST['para_handling'] ).'>'.$FD->text("page", "allow_code_both").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$FD->text("page", "cat_settings_title").'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "cat_img_max_width").':<br>
                                    <span class="small">'.$FD->text("page", "cat_img_max_width_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="3" name="cat_pic_x" maxlength="3" value="'.$_POST['cat_pic_x'].'"> '.$FD->text("admin", "pixel").'<br>
                                    <span class="small">('.$FD->text("admin", "zero_not_allowed").')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "cat_img_max_height").':<br>
                                    <span class="small">'.$FD->text("page", "cat_img_max_height_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="3" name="cat_pic_y" maxlength="3" value="'.$_POST['cat_pic_y'].'"> '.$FD->text("admin", "pixel").'<br>
                                    <span class="small">('.$FD->text("admin", "zero_not_allowed").')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "cat_img_max_size").':<br>
                                    <span class="small">'.$FD->text("page", "cat_img_max_size_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="4" name="cat_pic_size" maxlength="4" value="'.$_POST['cat_pic_size'].'"> '.$FD->text("admin", "kib").'<br>
                                    <span class="small">('.$FD->text("admin", "zero_not_allowed").')</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$FD->text("page", "comment_settings_title").' - Noch ohne Funktion</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "allow_comments").':<br>
                                    <span class="small">'.$FD->text("page", "allow_comments_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="com_rights">
                                        <option value="2" '.getselected ( 2, $_POST['com_rights'] ).'>'.$FD->text("page", "allow_comments_all").'</option>
                                        <option value="3" '.getselected ( 3, $_POST['com_rights'] ).'>'.$FD->text("page", "allow_comments_staff").'</option>
                                        <option value="1" '.getselected ( 1, $_POST['com_rights'] ).'>'.$FD->text("page", "allow_comments_reg").'</option>
                                        <option value="0" '.getselected ( 0, $_POST['com_rights'] ).'>'.$FD->text("page", "allow_comments_nobody").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "sort_comments").':<br>
                                    <span class="small">'.$FD->text("page", "sort_comments_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="com_sort">
                                        <option value="ASC" '.getselected ( 'ASC', $_POST['com_sort'] ).'>'.$FD->text("page", "sort_comments_old_first").'</option>
                                        <option value="DESC" '.getselected ( 'DESC', $_POST['com_sort'] ).'>'.$FD->text("page", "sort_comments_new_first").'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "spam_comments").':<br>
                                    <span class="small">'.$FD->text("page", "spam_comments_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="com_antispam">
                                        <option value="2" '.getselected ( 2, $_POST['com_antispam'] ).'>'.$FD->text("page", "spam_comments_all").'</option>
                                        <option value="3" '.getselected ( 3, $_POST['com_antispam'] ).'>'.$FD->text("page", "spam_comments_staff").'</option>
                                        <option value="1" '.getselected ( 1, $_POST['com_antispam'] ).'>'.$FD->text("page", "spam_comments_reg").'</option>
                                        <option value="0" '.getselected ( 0, $_POST['com_antispam'] ).'>'.$FD->text("page", "spam_comments_nobody").'</option>
                                    </select>
                                </td>
                            </tr>
							<tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">Admin-CP Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    Eintrag Ansicht:<br>
                                    <span class="small">Darstellungsart eines Eintrags in der Artikelliste.</span>
                                </td>
                                <td class="config">
                                    <select name="acp_view">
                                        <option value="0" '.getselected ( 0, $_POST['acp_view'] ).'>einfache Ansicht</option>
                                        <option value="2" '.getselected ( 2, $_POST['acp_view'] ).'>erweiterte Ansicht</option>
                                        <option value="1" '.getselected ( 1, $_POST['acp_view'] ).'>vollst&auml;ndige Ansicht</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Eintr&auml;ge pro Seite:<br>
                                    <span class="small">Eintr&auml;ge, die pro Seite der Artikelliste angezeigt werden.</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="3" name="acp_per_page" maxlength="3" value="'.$_POST['acp_per_page'].'"> Eintr&auml;ge<br>
                                    <span class="small">('.$FD->text("admin", "zero_not_allowed").')</span>
                                </td>
                            </tr>
							<tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "save_long").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
