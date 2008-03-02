<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (
		$_POST['num_news'] && $_POST['num_news'] > 0 &&
		$_POST['num_head'] && $_POST['num_head'] > 0 &&
		$_POST['cat_pic_x'] && $_POST['cat_pic_x'] > 0 &&
		$_POST['cat_pic_y'] && $_POST['cat_pic_y'] > 0 &&
		$_POST['cat_pic_size'] && $_POST['cat_pic_size'] > 0
	)
{
    settype($_POST['num_news'], 'integer');
    settype($_POST['num_head'], 'integer');
    settype($_POST['html_code'], 'integer');
    settype($_POST['fs_code'], 'integer');
    settype($_POST['para_handling'], 'integer');
    settype($_POST['cat_pic_x'], 'integer');
    settype($_POST['cat_pic_y'], 'integer');
    settype($_POST['cat_pic_size'], 'integer');
    settype($_POST['com_rights'], 'integer');
    settype($_POST['com_antispam'], 'integer');

	$_POST['com_sort'] = savesql ( $_POST['com_sort'] );
    
    mysql_query("UPDATE ".$global_config_arr['pref']."news_config
                 SET num_news = '".$_POST['num_news']."',
                     num_head = '".$_POST['num_head']."',
                     html_code = '".$_POST['html_code']."',
                     fs_code = '".$_POST['fs_code']."',
                     para_handling = '".$_POST['para_handling']."',
                     cat_pic_x = '".$_POST['cat_pic_x']."',
                     cat_pic_y = '".$_POST['cat_pic_y']."',
                     cat_pic_size = '".$_POST['cat_pic_size']."',
                     com_rights = '".$_POST['com_rights']."',
                     com_antispam = '".$_POST['com_antispam']."',
                     com_sort = '".$_POST['com_sort']."'
                 WHERE id = '1'", $db);

	systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_config", $db );
    $config_arr = mysql_fetch_assoc ( $index );

    if ( isset ( $_POST['sended'] ) )
    {
        $config_arr = getfrompost ( $config_arr );

        systext($admin_phrases[common][note_notfilled]."<br />".$admin_phrases[common][only_allowed_values], $admin_phrases[common][error], TRUE);
    }


    switch ( $config_arr['html_code'] )
    {
        case 1: $htmlop1 = 'selected="selected"'; break;
        case 2: $htmlop2 = 'selected="selected"'; break;
        case 3: $htmlop3 = 'selected="selected"'; break;
        case 4: $htmlop4 = 'selected="selected"'; break;
    }
    switch ( $config_arr['fs_code'] )
    {
        case 1: $fsop1 = 'selected="selected"'; break;
        case 2: $fsop2 = 'selected="selected"'; break;
        case 3: $fsop3 = 'selected="selected"'; break;
        case 4: $fsop4 = 'selected="selected"'; break;
    }
    switch ( $config_arr['para_handling'] )
    {
        case 1: $paraop1 = 'selected="selected"'; break;
        case 2: $paraop2 = 'selected="selected"'; break;
        case 3: $paraop3 = 'selected="selected"'; break;
        case 4: $paraop4 = 'selected="selected"'; break;
    }
    switch ( $config_arr['com_rights'] )
    {
        case 0: $rightsop0 = 'selected="selected"'; break;
        case 1: $rightsop1 = 'selected="selected"'; break;
        case 2: $rightsop2 = 'selected="selected"'; break;
        case 3: $rightsop3 = 'selected="selected"'; break;
    }
    switch ( $config_arr['com_sort'] )
    {
        case "ASC": $sortop1 = 'selected="selected"'; break;
        case "DESC": $sortop2 = 'selected="selected"'; break;
    }
    switch ( $config_arr['com_antispam'] )
    {
        case 0: $spamop0 = 'selected="selected"'; break;
        case 1: $spamop1 = 'selected="selected"'; break;
        case 2: $spamop2 = 'selected="selected"'; break;
        case 3: $spamop3 = 'selected="selected"'; break;
    }
 
    echo'
					<form action="" method="post">
                        <input type="hidden" value="newsconfig" name="go">
                        <input type="hidden" name="sended" value="1">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[news][settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][news_per_page].':<br>
                                    <span class="small">'.$admin_phrases[news][news_per_page_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="2" name="num_news" maxlength="2" value="'.$config_arr['num_news'].'"><br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][num_headlines].':<br>
                                    <span class="small">'.$admin_phrases[news][num_headlines_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="2" name="num_head" maxlength="2" value="'.$config_arr['num_head'] .'"><br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[news][post_settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][allow_html].':<br>
                                    <span class="small">'.$admin_phrases[news][allow_html_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="html_code">
                                        <option '.$htmlop1.' value="1">'.$admin_phrases[news][allow_code_no].'</option>
                                        <option '.$htmlop2.' value="2">'.$admin_phrases[news][allow_code_news].'</option>
                                        <option '.$htmlop3.' value="3">'.$admin_phrases[news][allow_code_comments].'</option>
                                        <option '.$htmlop4.' value="4">'.$admin_phrases[news][allow_code_both].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][allow_fs].':<br>
                                    <span class="small">'.$admin_phrases[news][allow_fs_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="fs_code">
                                        <option '.$fsop1.' value="1">'.$admin_phrases[news][allow_code_no].'</option>
                                        <option '.$fsop2.' value="2">'.$admin_phrases[news][allow_code_news].'</option>
                                        <option '.$fsop3.' value="3">'.$admin_phrases[news][allow_code_comments].'</option>
                                        <option '.$fsop4.' value="4">'.$admin_phrases[news][allow_code_both].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][allow_para].':<br>
                                    <span class="small">'.$admin_phrases[news][allow_para_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="para_handling">
                                        <option '.$paraop1.' value="1">'.$admin_phrases[news][allow_code_no].'</option>
                                        <option '.$paraop2.' value="2">'.$admin_phrases[news][allow_code_news].'</option>
                                        <option '.$paraop3.' value="3">'.$admin_phrases[news][allow_code_comments].'</option>
                                        <option '.$paraop4.' value="4">'.$admin_phrases[news][allow_code_both].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[news][cat_settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][cat_img_max_width].':<br>
                                    <span class="small">'.$admin_phrases[news][cat_img_max_width_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="3" name="cat_pic_x" maxlength="3" value="'.$config_arr['cat_pic_x'].'"> '.$admin_phrases[common][pixel].'<br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][cat_img_max_height].':<br>
                                    <span class="small">'.$admin_phrases[news][cat_img_max_height_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="3" name="cat_pic_y" maxlength="3" value="'.$config_arr['cat_pic_y'].'"> '.$admin_phrases[common][pixel].'<br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][cat_img_max_size].':<br>
                                    <span class="small">'.$admin_phrases[news][cat_img_max_size_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="4" name="cat_pic_size" maxlength="4" value="'.$config_arr['cat_pic_size'].'"> '.$admin_phrases[common][kib].'<br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[news][comment_settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][allow_comments].':<br>
                                    <span class="small">'.$admin_phrases[news][allow_comments_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="com_rights">
                                        <option '.$rightsop2.' value="2">'.$admin_phrases[news][allow_comments_all].'</option>
                                        <option '.$rightsop3.' value="3">'.$admin_phrases[news][allow_comments_staff].'</option>
                                        <option '.$rightsop1.' value="1">'.$admin_phrases[news][allow_comments_reg].'</option>
                                        <option '.$rightsop0.' value="0">'.$admin_phrases[news][allow_comments_nobody].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][sort_comments].':<br>
                                    <span class="small">'.$admin_phrases[news][sort_comments_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="com_sort">
                                        <option '.$sortop1.' value="ASC">'.$admin_phrases[news][sort_comments_old_first].'</option>
                                        <option '.$sortop2.' value="DESC">'.$admin_phrases[news][sort_comments_new_first].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][anti_spam_comments].':<br>
                                    <span class="small">'.$admin_phrases[news][anti_spam_comments_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="com_antispam">
                                        <option '.$spamop2.' value="2">'.$admin_phrases[news][anti_spam_comments_all].'</option>
                                        <option '.$spamop3.' value="3">'.$admin_phrases[news][anti_spam_comments_staff].'</option>
                                        <option '.$spamop1.' value="1">'.$admin_phrases[news][anti_spam_comments_reg].'</option>
                                        <option '.$spamop0.' value="0">'.$admin_phrases[news][anti_spam_comments_nobody].'</option>
                                    </select>
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