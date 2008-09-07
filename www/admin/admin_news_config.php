<?php
///////////////////////
//// Update Config ////
///////////////////////

// Write Data into DB
if (
		$_POST['num_news'] && $_POST['num_news'] > 0
		&& $_POST['num_head'] && $_POST['num_head'] > 0
		&& $_POST['cat_pic_x'] && $_POST['cat_pic_x'] > 0
		&& $_POST['cat_pic_y'] && $_POST['cat_pic_y'] > 0
		&& $_POST['cat_pic_size'] && $_POST['cat_pic_size'] > 0
		&& $_POST['news_headline_lenght']
		&& $_POST['acp_per_page'] && $_POST['acp_per_page'] > 0
	)
{
	// security functions
    settype ( $_POST['num_news'], "integer" );
    settype ( $_POST['num_head'], "integer" );
    settype ( $_POST['html_code'], "integer" );
    settype ( $_POST['fs_code'], "integer" );
    settype ( $_POST['para_handling'], "integer" );
    settype ( $_POST['cat_pic_x'], "integer" );
    settype ( $_POST['cat_pic_y'], "integer" );
    settype ( $_POST['cat_pic_size'], "integer" );
    settype ( $_POST['com_rights'], "integer" );
    settype ( $_POST['com_antispam'], "integer" );
    settype ( $_POST['news_headline_lenght'], "integer" );
    settype ( $_POST['acp_per_page'], "integer" );
    settype ( $_POST['acp_view'], "integer" );

    $_POST['com_sort'] = savesql ( $_POST['com_sort'] );
    $_POST['news_headline_ext'] = savesql ( $_POST['news_headline_ext'] );

	// MySQL-Update-Query
    mysql_query ("
					UPDATE `".$global_config_arr['pref']."news_config`
                 	SET
					 	`num_news` = '".$_POST['num_news']."',
                     	`num_head` = '".$_POST['num_head']."',
                     	`html_code` = '".$_POST['html_code']."',
                     	`fs_code` = '".$_POST['fs_code']."',
                     	`para_handling` = '".$_POST['para_handling']."',
                     	`cat_pic_x` = '".$_POST['cat_pic_x']."',
                     	`cat_pic_y` = '".$_POST['cat_pic_y']."',
                     	`cat_pic_size` = '".$_POST['cat_pic_size']."',
                     	`com_rights` = '".$_POST['com_rights']."',
                     	`com_antispam` = '".$_POST['com_antispam']."',
                     	`com_sort` = '".$_POST['com_sort']."',
                     	`news_headline_lenght` = '".$_POST['news_headline_lenght']."',
                     	`news_headline_ext` = '".$_POST['news_headline_ext']."',
                     	`acp_per_page` = '".$_POST['acp_per_page']."',
                     	`acp_view` = '".$_POST['acp_view']."'
                 	WHERE
					 	`id` = '1'
	", $db );

	// system messages
    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);

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
		systext ( $admin_phrases[common][note_notfilled] . "<br>" . $admin_phrases[common][only_allowed_values], $admin_phrases[common][error], TRUE );

	// Load Data from DB into Post
	} else {
	    $index = mysql_query ( "
								SELECT *
								FROM ".$global_config_arr['pref']."news_config
								WHERE `id` = '1'
		", $db);
	    $config_arr = mysql_fetch_assoc($index);
	    putintopost ( $config_arr );
	}

	// security functions
    settype ( $_POST['num_news'], "integer" );
    settype ( $_POST['num_head'], "integer" );
    settype ( $_POST['html_code'], "integer" );
    settype ( $_POST['fs_code'], "integer" );
    settype ( $_POST['para_handling'], "integer" );
    settype ( $_POST['cat_pic_x'], "integer" );
    settype ( $_POST['cat_pic_y'], "integer" );
    settype ( $_POST['cat_pic_size'], "integer" );
    settype ( $_POST['com_rights'], "integer" );
    settype ( $_POST['com_antispam'], "integer" );
    settype ( $_POST['news_headline_lenght'], "integer" );
    settype ( $_POST['acp_per_page'], "integer" );
    settype ( $_POST['acp_view'], "integer" );

    $_POST['com_sort'] = killhtml ( $_POST['com_sort'] );
    $_POST['news_headline_ext'] = killhtml ( $_POST['news_headline_ext'] );

	// Display Form
    echo'
					<form action="" method="post">
                        <input type="hidden" name="go" value="news_config">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[news][settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][news_per_page].':<br>
                                    <span class="small">'.$admin_phrases[news][news_per_page_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="2" name="num_news" maxlength="2" value="'.$_POST['num_news'].'"><br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][num_headlines].':<br>
                                    <span class="small">'.$admin_phrases[news][num_headlines_desc].'</span>
								</td>
                                <td class="config">
                                    <input class="text center" size="2" name="num_head" maxlength="2" value="'.$_POST['num_head'] .'"><br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '."Headlines kürzen auf".':<br>
                                    <span class="small">'."Max. Zeichenzahl einer Headline.".'</span>
								</td>
                                <td class="config">
                                    <input class="text center" size="3" name="news_headline_lenght" maxlength="3" value="'.$_POST['news_headline_lenght'] .'"> Zeichen<br>
                                    <span class="small">('."-1 um Headlins nicht zu kürzen".')</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="config">
                                    '."Headline-Erweiterung".': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'."Wird an eine gekürzte Headline angehängt.".'</span>
								</td>
                                <td class="config">
                                    <input class="text" size="20" name="news_headline_ext" maxlength="30" value="'.$_POST['news_headline_ext'] .'">
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
                                        <option value="1" '.getselected( $_POST['html_code'], 1 ).'>'.$admin_phrases[news][allow_code_no].'</option>
                                        <option value="2" '.getselected( $_POST['html_code'], 2 ).'>'.$admin_phrases[news][allow_code_news].'</option>
                                        <option value="3" '.getselected( $_POST['html_code'], 3 ).'>'.$admin_phrases[news][allow_code_comments].'</option>
                                        <option value="4" '.getselected( $_POST['html_code'], 4 ).'>'.$admin_phrases[news][allow_code_both].'</option>
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
                                        <option value="1" '.getselected( $_POST['fs_code'], 1 ).'>'.$admin_phrases[news][allow_code_no].'</option>
                                        <option value="2" '.getselected( $_POST['fs_code'], 2 ).'>'.$admin_phrases[news][allow_code_news].'</option>
                                        <option value="3" '.getselected( $_POST['fs_code'], 3 ).'>'.$admin_phrases[news][allow_code_comments].'</option>
                                        <option value="4" '.getselected( $_POST['fs_code'], 4 ).'>'.$admin_phrases[news][allow_code_both].'</option>
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
                                        <option value="1" '.getselected( $_POST['para_handling'], 1 ).'>'.$admin_phrases[news][allow_code_no].'</option>
                                        <option value="2" '.getselected( $_POST['para_handling'], 2 ).'>'.$admin_phrases[news][allow_code_news].'</option>
                                        <option value="3" '.getselected( $_POST['para_handling'], 3 ).'>'.$admin_phrases[news][allow_code_comments].'</option>
                                        <option value="4" '.getselected( $_POST['para_handling'], 4 ).'>'.$admin_phrases[news][allow_code_both].'</option>
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
                                    <input class="text center" size="3" name="cat_pic_x" maxlength="3" value="'.$_POST['cat_pic_x'].'"> '.$admin_phrases[common][pixel].'<br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][cat_img_max_height].':<br>
                                    <span class="small">'.$admin_phrases[news][cat_img_max_height_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="3" name="cat_pic_y" maxlength="3" value="'.$_POST['cat_pic_y'].'"> '.$admin_phrases[common][pixel].'<br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][cat_img_max_size].':<br>
                                    <span class="small">'.$admin_phrases[news][cat_img_max_size_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="4" name="cat_pic_size" maxlength="4" value="'.$_POST['cat_pic_size'].'"> '.$admin_phrases[common][kib].'<br>
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
                                        <option value="2" '.getselected( $_POST['com_rights'], 2 ).'>'.$admin_phrases[news][allow_comments_all].'</option>
                                        <option value="1" '.getselected( $_POST['com_rights'], 1 ).'>'.$admin_phrases[news][allow_comments_reg].'</option>
                                        <option value="3" '.getselected( $_POST['com_rights'], 3 ).'>'.$admin_phrases[news][allow_comments_staff].'</option>
                                        <option value="4" '.getselected( $_POST['com_rights'], 4 ).'>'."Administratoren".'</option>
                                        <option value="0" '.getselected( $_POST['com_rights'], 0 ).'>'.$admin_phrases[news][allow_comments_nobody].'</option>
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
                                        <option value="ASC" '.getselected( $_POST['com_sort'], "ASC" ).'>'.$admin_phrases[news][sort_comments_old_first].'</option>
                                        <option value="DESC" '.getselected( $_POST['com_sort'], "DESC" ).'>'.$admin_phrases[news][sort_comments_new_first].'</option>
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
                                        <option value="2" '.getselected( $_POST['com_antispam'], 2 ).'>'.$admin_phrases[news][anti_spam_comments_all].'</option>
                                        <option value="4" '.getselected( $_POST['com_antispam'], 4 ).'>'."alle außer Administratoren".'</option>
                                        <option value="3" '.getselected( $_POST['com_antispam'], 3 ).'>'.$admin_phrases[news][anti_spam_comments_staff].'</option>
                                        <option value="1" '.getselected( $_POST['com_antispam'], 1 ).'>'.$admin_phrases[news][anti_spam_comments_reg].'</option>
                                        <option value="0" '.getselected( $_POST['com_antispam'], 0 ).'>'.$admin_phrases[news][anti_spam_comments_nobody].'</option>
                                    </select>
                                </td>
                            </tr>
							<tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">Admin-CP Einstellungen</td></tr>
                            <tr>
                                <td class="config">
                                    Eintrag Ansicht:<br>
                                    <span class="small">Darstellungsart eines Eintrags in der Newsliste.</span>
                                </td>
                                <td class="config">
                                    <select name="acp_view">
                                        <option value="0" '.getselected ( 0, $_POST['acp_view'] ).'>einfache Ansicht</option>
                                        <option value="2" '.getselected ( 2, $_POST['acp_view'] ).'>erweiterte Ansicht</option>
                                        <option value="1" '.getselected ( 1, $_POST['acp_view'] ).'>vollständige Ansicht</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Einträge pro Seite:<br>
                                    <span class="small">Einträge, die pro Seite der Newsliste angezeigt werden.</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="3" name="acp_per_page" maxlength="3" value="'.$_POST['acp_per_page'].'"> Einträge<br>
                                    <span class="small">('.$admin_phrases[common][zero_not_allowed].')</span>
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