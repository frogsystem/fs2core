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
                && is_language_text ( $_POST['language_text'] )
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
    $_POST['publisher'] = savesql ( $_POST['publisher'] );
    $_POST['copyright'] = savesql ( $_POST['copyright'] );
    $_POST['date'] = savesql ( $_POST['date'] );
    $_POST['time'] = savesql ( $_POST['time'] );
    $_POST['datetime'] = savesql ( $_POST['datetime'] );
    $_POST['page'] = savesql ( $_POST['page'] );
    $_POST['page_next'] = savesql ( $_POST['page_next'] );
    $_POST['page_prev'] = savesql ( $_POST['page_prev'] );
    $_POST['feed'] = savesql ( $_POST['feed'] );
    $_POST['language_text'] = savesql ( $_POST['language_text'] );
    $_POST['home_text'] = savesql ( $_POST['home_text'] );
    $_POST['dyn_title_ext'] = savesql ( $_POST['dyn_title_ext'] );

    settype ( $_POST['show_favicon'], "integer" );
    settype ( $_POST['style_id'], "integer" );
    settype ( $_POST['allow_other_designs'], "integer" );
    settype ( $_POST['home'], "integer" );
    settype ( $_POST['dyn_title'], "integer" );
    settype ( $_POST['auto_forward'], "integer" );
    
    $index = mysql_query ( "
                            SELECT `style_tag`
                            FROM `".$global_config_arr['pref']."styles`
                            WHERE `style_id` = ".$_POST['style_id']."
                            AND `style_id` != 0
                            AND `style_allow_use` = 1
                            LIMIT 0,1
    ", $db );
    if ( mysql_num_rows ( $index ) == 1 ) {
        $_POST['style_tag'] = stripslashes ( mysql_result ( $index, 0, "style_tag" ) );
        $style_sql_insert = "
                                            `style_id` = '".$_POST['style_id']."',
                                            `style_tag` = '".$_POST['style_tag']."',
        ";
    } else {
        $style_sql_insert = "";
    }

    // MySQL-Queries
    mysql_query ( "
                                    UPDATE `".$global_config_arr['pref']."global_config`
                                    SET
                                            `virtualhost` = '".$_POST['virtualhost']."',
                                            `admin_mail` = '".$_POST['admin_mail']."',
                                            `title` = '".$_POST['title']."',
                                            `dyn_title` = '".$_POST['dyn_title']."',
                                            `dyn_title_ext` = '".$_POST['dyn_title_ext']."',
                                            `description` = '".$_POST['description']."',
                                            `keywords` = '".$_POST['keywords']."',
                                            `publisher` = '".$_POST['publisher']."',
                                            `copyright` = '".$_POST['copyright']."',
                                            `show_favicon` = '".$_POST['show_favicon']."',
                                            ".$style_sql_insert."
                                            `allow_other_designs` = '".$_POST['allow_other_designs']."',
                                            `date` = '".$_POST['date']."',
                                            `time` = '".$_POST['time']."',
                                            `datetime` = '".$_POST['datetime']."',
                                            `page` = '".$_POST['page']."',
                                            `page_next` = '".$_POST['page_next']."',
                                            `page_prev` = '".$_POST['page_prev']."',
                                            `feed` = '".$_POST['feed']."',
                                            `language_text` = '".$_POST['language_text']."',
                                            `home` = '".$_POST['home']."',
                                            `home_text` = '".$_POST['home_text']."',
                                            `auto_forward` = '".$_POST['auto_forward']."'
                                    WHERE `id` = '1'
    ", $db );

    // system messages
    systext( $admin_phrases[common][changes_saved], $admin_phrases[common][info], FALSE, $admin_phrases[icons][save_ok] );

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
        systext ( $admin_phrases[common][changes_not_saved].'<br>'.$admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE, $admin_phrases[icons][save_error] );

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
    $_POST['publisher'] = killhtml ( $_POST['publisher'] );
    $_POST['copyright'] = killhtml ( $_POST['copyright'] );
    $_POST['admin_mail'] = killhtml ( $_POST['admin_mail'] );
    $_POST['keywords'] = killhtml ( $_POST['keywords'] );
    $_POST['date'] = killhtml ( $_POST['date'] );
    $_POST['time'] = killhtml ( $_POST['time'] );
    $_POST['datetime'] = killhtml ( $_POST['datetime'] );
    $_POST['page'] = killhtml ( $_POST['page'] );
    $_POST['page_next'] = killhtml ( $_POST['page_next'] );
    $_POST['page_prev'] = killhtml ( $_POST['page_prev'] );
    $_POST['feed'] = killhtml ( $_POST['feed'] );
    $_POST['language_text'] = killhtml ( $_POST['language_text'] );
    $_POST['home_text'] = killhtml ( $_POST['home_text'] );
    $_POST['dyn_title_ext'] = killhtml ( $_POST['dyn_title_ext'] );

    settype ( $_POST['show_favicon'], "integer" );
    settype ( $_POST['style_id'], "integer" );
    settype ( $_POST['allow_other_designs'], "integer" );
    settype ( $_POST['home'], "integer" );
    settype ( $_POST['dyn_title'], "integer" );
    settype ( $_POST['auto_forward'], "integer" );

    //get other data
    if ( $_POST['dyn_title'] == 1 ) {
        $display_arr['dyn_title_ext_tr'] = "default";
    } else {
        $display_arr['dyn_title_ext_tr'] = "hidden";
    }

    // Display Form
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="gen_config">
                        <input type="hidden" name="sended" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][pageinfo_title].'</td></tr>
                            <tr>
                                <td class="config right_space">
                                    '.$admin_phrases[general][title].':<br>
                                    <span class="small">'.$admin_phrases[general][title_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="title" maxlength="100" value="'.$_POST['title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Dynamischer Titel:<br>
                                    <span class="small">Aktiviert dynamische Seitentitel.</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="dyn_title" value="1" '.getchecked ( 1, $_POST['dyn_title'] ).'
                                           onChange="show_hidden(document.getElementById(\'dyn_title_ext_tr\'), this, true)"
                                    >
                                </td>
                            </tr>
                            <tr class="'.$display_arr['dyn_title_ext_tr'].'" id="dyn_title_ext_tr">
                                <td class="config">
                                    Dynamischer Titel-Schema:<br>
                                    <span class="small">Schema des dynamischen Seitentitels.</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="dyn_title_ext" id="dyn_title_ext" maxlength="100" value="'.$_POST['dyn_title_ext'].'"><br>
                                    <span class="small" style="padding-top: 3px; display: block;">
                                        '.$admin_phrases[common][valid_tags].':&nbsp;&nbsp;
                                        '.insert_tt( "{title}", "Seitentitel", "dyn_title_ext", FALSE ).',&nbsp;
                                        '.insert_tt( "{ext}", "seitenspezifische Erweiterung", "dyn_title_ext", FALSE ).'
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][virtualhost].':<br>
                                    <span class="small">'.$admin_phrases[general][virtualhost_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="virtualhost" maxlength="255" value="'.$_POST['virtualhost'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][admin_mail].':<br>
                                    <span class="small">'.$admin_phrases[general][admin_mail_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="admin_mail" maxlength="100" value="'.$_POST['admin_mail'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][description].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[general][description_desc].'</span>
                                </td>
                                <td class="config">
                                    <textarea class="text input_width" name="description" rows="5" wrap="virtual">'.$_POST['description'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][keywords].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[general][keywords_desc].'</span>
                                </td>
                                <td class="config">
                                    <textarea class="text input_width" name="keywords" rows="5" wrap="virtual">'.$_POST['keywords'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT['admin']->get("config_publisher_title").': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$TEXT['admin']->get("config_publisher_desc").'</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="publisher" maxlength="100" value="'.$_POST['publisher'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT['admin']->get("config_copyright_title").': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$TEXT['admin']->get("config_copyright_desc").'</span>
                                </td>
                                <td class="config">
                                    <textarea class="text input_width" name="copyright" rows="5" wrap="virtual">'.$_POST['copyright'].'</textarea>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][design_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$TEXT['admin']->get("config_style_title").':<br>
                                    <span class="small">'.$TEXT['admin']->get("config_style_desc").'</span>
                                </td>
                                <td class="config">
                                    <select name="style_id" size="1">
    ';
    $active_style = mysql_result (
                                    mysql_query ( "
                                                    SELECT `style_id`
                                                    FROM `".$global_config_arr['pref']."global_config`
                                                    WHERE `id` = 1
                                    ", $db )
    , 0, "style_id" );
    settype ( $active_style, "integer" );
    $index = mysql_query ( "
                            SELECT `style_id`, `style_tag`
                            FROM `".$global_config_arr['pref']."styles`
                            WHERE `style_id` != 0
                            AND `style_allow_use` = 1
                            ORDER BY `style_tag`
    ", $db );
    while ( $style_arr = mysql_fetch_assoc ( $index ) ) {
        settype ( $style_arr['style_id'], "integer" );
        echo '<option value="'.$style_arr['style_id'].'" '.getselected ( $style_arr['style_id'], $_POST['style_id'] ).'>'.killhtml ( $style_arr['style_tag'] );
        echo ( $style_arr['style_id'] == $active_style ) ? ' ('.$TEXT['admin']->get("active").')' : "";
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
                                    <input class="pointer" type="checkbox" name="allow_other_designs" value="1" '.getchecked ( 1, $_POST['allow_other_designs'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][show_favicon].':<br>
                                    <span class="small">'.$admin_phrases[general][show_favicon_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="pointer" type="checkbox" name="show_favicon" value="1" '.getchecked ( 1, $_POST['show_favicon'] ).'>
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
                                            <td class="config middle">
                                                    <input class="pointer" type="radio" name="home" value="0" '.getchecked ( 0, $_POST['home'] ).'>
                                            </td>
                                            <td class="config middle">
                                                    '.$admin_phrases[general][home_page_default].'
                                            </td>
                                        </tr>
                                        <tr valign="bottom">
                                             <td class="config">
                                                    <input class="pointer" type="radio" name="home" value="1" '.getchecked ( 1, $_POST['home'] ).'>
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
                                    <select name="language_text" size="1">
    ';

    $lang_dirs = scandir_filter ( FS2_ROOT_PATH . "lang", array () );
    foreach ( $lang_dirs as $lang_dir ) {
        if ( is_dir ( FS2_ROOT_PATH . "lang/" . $lang_dir ) == TRUE && is_language_text ( $lang_dir ) ) {
            echo '<option value="'.$lang_dir.'" '.getselected ($lang_dir, $_POST['language_text']).'>'.$lang_dir.'</option>';
        }
    }
    
    echo '
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
                                    <input class="text input_width" size="40" name="date" maxlength="255" value="'.$_POST['date'].'"><br>
                                    <span class="small">'.$admin_phrases[general][date_info].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Zeit: <br>
                                    <span class="small">Format, das für Zeitangaben auf der Seite verwendet wird.</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" size="40" name="time" maxlength="255" value="'.$_POST['time'].'"><br>
                                    <span class="small">'.$admin_phrases[general][date_info].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][date].' & Zeit: <br>
                                    <span class="small">Format, das für Datums- und Zeitangaben auf der Seite verwendet wird.</span>
                                </td>
                                <td class="config">
                                    <input class="text input_width" name="datetime" maxlength="255" value="'.$_POST['datetime'].'"><br>
                                    <span class="small">'.$admin_phrases[general][date_info].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '."Automatische Weiterleitung".': <br>
                                    <span class="small">Zeit, nach der die automatische Weiterleitung aktiviert wird.</span>
                                </td>
                                <td class="config">
                                    <input class="text center" size="2" name="auto_forward" maxlength="2" value="'.$_POST['auto_forward'].'"> Sekunden
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td colspan="2" class="line">'.$admin_phrases[general][pagenav_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][page].': <br>
                                    <span class="small">'.$admin_phrases[general][page_desc].'<br><br>
                                    <span style="padding-bottom:5px; display:block;">'.$admin_phrases[common][valid_tags].':<br></span>
                                    '.insert_tt( "{page_number}", "aktuelle Seite", "page" ).'
                                    '.insert_tt( "{total_pages}", "Seitenzahl", "page" ).'
                                    '.insert_tt( "{prev}", "Seite zurück", "page" ).'
                                    '.insert_tt( "{next}", "Seite weiter", "page" ).'</span>
                                </td>
                                <td class="config">
                                    <textarea class="input_width" name="page" id="page" wrap="virtual" style="height:125px;">'.$_POST['page'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][page_prev].': <br>
                                    <span class="small">'.$admin_phrases[general][page_prev_desc].'<br><br>
                                    <span style="padding-bottom:5px; display:block;">'.$admin_phrases[common][valid_tags].':<br></span>
                                    '.insert_tt( "{url}", "URL zur vorherigen Seite", "page_prev" ).'</span>
                                </td>
                                <td class="config">
                                    <textarea class="input_width" name="page_prev" id="page_prev" wrap="virtual" style="height:75px;">'.$_POST['page_prev'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][page_next].': <br>
                                    <span class="small">'.$admin_phrases[general][page_next_desc].'<br><br>
                                    <span style="padding-bottom:5px; display:block;">'.$admin_phrases[common][valid_tags].':<br></span>
                                    '.insert_tt( "{url}", "URL zur nächsten Seite", "page_next" ).'</span>
                                </td>
                                <td class="config">
                                    <textarea class="input_width" name="page_next" id="page_next" wrap="virtual" style="height:75px;">'.$_POST['page_next'].'</textarea>
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