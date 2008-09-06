<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (
		$_POST['title'] && $_POST['title'] != ""
		&& $_POST['virtualhost'] && $_POST['virtualhost'] != ""
		&& $_POST['admin_mail'] && $_POST['admin_mail'] != ""
		&& $_POST['date'] && $_POST['date'] != ""
		&& $_POST['page'] && $_POST['page'] != ""
		&& $_POST['page_next'] && $_POST['page_next'] != ""
		&& $_POST['page_prev'] && $_POST['page_prev'] != ""
		&& ( $_POST['home'] == 0 || ( $_POST['home'] == 1 && $_POST['home_text'] != "" ) )
	)
{
	// security functions
	if ( substr ( $_POST['virtualhost'], -1 ) != "/" ) {
	  $_POST['virtualhost'] = $_POST['virtualhost']."/";
	}

	$_POST['virtualhost'] = savesql ( $_POST['virtualhost'] );
	$_POST['admin_mail'] = savesql ( $_POST['admin_mail'] );
	$_POST['title'] = savesql ( $_POST['title'] );
	$_POST['description'] = savesql ( $_POST['description'] );
	$_POST['keywords'] = savesql ( $_POST['keywords'] );
	$_POST['author'] = savesql ( $_POST['author'] );
	$_POST['date'] = savesql ( $_POST['date'] );
	$_POST['page'] = savesql ( $_POST['page'] );
	$_POST['page_next'] = savesql ( $_POST['page_next'] );
	$_POST['page_prev'] = savesql ( $_POST['page_prev'] );
	$_POST['feed'] = savesql ( $_POST['feed'] );
	$_POST['language'] = savesql ( $_POST['language'] );;
	$_POST['home_text'] = savesql ( $_POST['home_text'] );

	settype ( $_POST['show_favicon'], "integer" );
	settype ( $_POST['design'], "integer" );
	settype ( $_POST['allow_other_designs'], "integer" );
	settype ( $_POST['home'], "integer" );

	// MySQL-Queries
    mysql_query ( "
					UPDATE `".$global_config_arr['pref']."global_config`
					SET
						`virtualhost` = '".$_POST['virtualhost']."',
						`admin_mail` = '".$_POST['admin_mail']."',
						`title` = '".$_POST['title']."',
						`description` = '".$_POST['description']."',
						`keywords` = '".$_POST['keywords']."',
						`author` = '".$_POST['author']."',
						`show_favicon` = '".$_POST['show_favicon']."',
						`design` = '".$_POST['design']."',
						`allow_other_designs` = '".$_POST['allow_other_designs']."',
						`date` = '".$_POST['date']."',
						`page` = '".$_POST['page']."',
						`page_next` = '".$_POST['page_next']."',
						`page_prev` = '".$_POST['page_prev']."',
						`feed` = '".$_POST['feed']."',
						`language` = '".$_POST['language']."',
						`home` = '".$_POST['home']."',
						`home_text` = '".$_POST['home_text']."'
					WHERE `id` = '1'
	", $db );
	
	// system messages
    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);

    // Unset Vars
    unset ( $_POST );
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

if ( TRUE )
{
	// Display Error Messages
	if ( isset ( $_POST['sended'] ) ) {
		systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );

	// Load Data from DB into Post
	} else {
	    $index = mysql_query ( "
								SELECT *
								FROM ".$global_config_arr['pref']."global_config
								WHERE `id` = '1'
		", $db);
	    $config_arr = mysql_fetch_assoc($index);
	    putintopost ( $config_arr );
	}

	// security functions
	$_POST['title'] = killhtml ( $_POST['title'] );
	$_POST['virtualhost'] = killhtml ( $_POST['virtualhost'] );
	$_POST['description'] = killhtml ( $_POST['description'] );
	$_POST['author'] = killhtml ( $_POST['author'] );
	$_POST['admin_mail'] = killhtml ( $_POST['admin_mail'] );
	$_POST['keywords'] = killhtml ( $_POST['keywords'] );
	$_POST['date'] = killhtml ( $_POST['date'] );
	$_POST['page'] = killhtml ( $_POST['page'] );
	$_POST['page_next'] = killhtml ( $_POST['page_next'] );
	$_POST['page_prev'] = killhtml ( $_POST['page_prev'] );
	$_POST['feed'] = killhtml ( $_POST['feed'] );
	$_POST['language'] = killhtml ( $_POST['language'] );;
	$_POST['home_text'] = killhtml ( $_POST['home_text'] );

	settype ( $_POST['show_favicon'], "integer" );
	settype ( $_POST['design'], "integer" );
	settype ( $_POST['allow_other_designs'], "integer" );
	settype ( $_POST['home'], "integer" );

	// Display Form
    echo '
					<form action="" method="post">
                        <input type="hidden" name="go" value="gen_config">
						<input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[general][pageinfo_title].'</td></tr>
							<tr>
                                <td class="config">
                                    '.$admin_phrases[general][title].':<br>
                                    <span class="small">'.$admin_phrases[general][title_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="title" maxlength="100" value="'.$_POST['title'].'" />
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][virtualhost].':<br>
                                    <span class="small">'.$admin_phrases[general][virtualhost_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="virtualhost" maxlength="255" value="'.$_POST['virtualhost'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][admin_mail].':<br>
                                    <span class="small">'.$admin_phrases[general][admin_mail_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="admin_mail" maxlength="100" value="'.$_POST['admin_mail'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][description].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[general][description_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="description" maxlength="255" value="'.$_POST['description'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][author].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[general][author_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="author" maxlength="100" value="'.$_POST['author'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][keywords].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[general][keywords_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="keywords" maxlength="255" value="'.$_POST['keywords'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][design_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][design].':<br>
                                    <span class="small">'.$admin_phrases[general][design_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="design" size="1">
	';
    $index = mysql_query ( "
							SELECT `id`, `name`
							FROM `".$global_config_arr['pref']."template`
							ORDER BY `id`
	", $db );
    while ( $design_arr = mysql_fetch_assoc ( $index ) ) {
        echo '<option value="'.$design_arr['id'].'" '.getselected ( $design_arr['id'], $_POST['design'] ).'>'.$design_arr['name'];
        if ( $design_arr['id'] == $_POST['design'] ) {
            echo ' ('.$admin_phrases[common][active].')';
        }
        echo '</option>';
    }
    echo '
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][allow_other_designs].':<br>
                                    <span class="small">'.$admin_phrases[general][allow_other_designs_desc].'</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="allow_other_designs" value="1" '.getchecked ( 1, $_POST['allow_other_designs'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][show_favicon].':<br>
                                    <span class="small">'.$admin_phrases[general][show_favicon_desc].'</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="show_favicon" value="1" '.getchecked ( 1, $_POST['show_favicon'] ).'>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][home_page].':<br>
                                    <span class="small">'.$admin_phrases[general][home_page_desc].'</span>
                                </td>
                                <td class="config">
                                    <table>
										<tr valign="bottom">
											<td class="config">
												<input class="pointer" type="radio" name="home" value="0" '.getchecked ( 0, $_POST['home'] ).'>
											</td>
											<td class="config">
												'.$admin_phrases[general][home_page_default].'
											</td>
										</tr>
										<tr valign="bottom">
 											<td class="config">
												<input class="pointer" type="radio" name="home" value="1" '.getchecked ( "1", $_POST['home'] ).'>
											</td>
											<td class="config">
												?go = <input class="text" size="20" name="home_text" maxlength="100" value="'.$_POST['home_text'].'">
											</td>
										</tr>
									</table>
									<br>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][language].':<br>
                                    <span class="small">'.$admin_phrases[general][language_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="language" size="1">
                                   		<option value="de" '.getselected ( "de", $_POST['language'] ).'>'.$admin_phrases[general][language_de].'</option>
						   				<option value="en" '.getselected ( "en", $_POST['language'] ).'>'.$admin_phrases[general][language_en].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][feed].':<br>
                                    <span class="small">'.$admin_phrases[general][feed_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="feed" size="1">
                                        <option value="rss091" '.getselected ( "rss091", $_POST['feed'] ).'>'.$admin_phrases[general][feed_rss091].'</option>
                                        <option value="rss10" '.getselected ( "rss10", $_POST['feed'] ).'>'.$admin_phrases[general][feed_rss10].'</option>
                                        <option value="rss20" '.getselected ( "rss20", $_POST['feed'] ).'>'.$admin_phrases[general][feed_rss20].'</option>
                                        <option value="atom10" '.getselected ( "atom10", $_POST['feed'] ).'>'.$admin_phrases[general][feed_atom10].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][date].': <br>
                                    <span class="small">'.$admin_phrases[general][date_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="date" maxlength="255" value="'.$_POST['date'].'"><br>
                                    <span class="small">'.$admin_phrases[general][date_info].'</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td colspan="2" class="line">'.$admin_phrases[general][pagenav_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][page].': <br>
                                    <span class="small">'.$admin_phrases[general][page_desc].'</span>
                                </td>
                                <td class="config">
                                    <textarea class="courier" name="page" wrap="virtual" style="width:275px; height:100px;">'.$_POST['page'].'</textarea><br>
									<span class="small">'.$admin_phrases[general][page_info].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][page_prev].': <br>
                                    <span class="small">'.$admin_phrases[general][page_prev_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="courier" style="width:275px;" name="page_prev" maxlength="255" value="'.$_POST['page_prev'].'"><br>
                                    <span class="small">'.$admin_phrases[general][page_prev_info].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][page_next].': <br>
                                    <span class="small">'.$admin_phrases[general][page_next_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="courier" style="width:275px;" name="page_next" maxlength="255" value="'.$_POST['page_next'].'"><br>
                                    <span class="small">'.$admin_phrases[general][page_next_info].'</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
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