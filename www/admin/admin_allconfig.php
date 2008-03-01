<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST['title'] AND $_POST['virtualhost'] AND $_POST['admin_mail']
AND $_POST['date'] AND $_POST['page'] AND $_POST['page_next'] AND $_POST['page_prev'] )
{

  if (substr($_POST[virtualhost], -1) != "/")
  {
      $_POST[virtualhost] = $_POST[virtualhost]."/";
  }

  $_POST[title] = savesql($_POST[title]);
  $_POST[virtualhost] = savesql($_POST[virtualhost]);
  $_POST[description] = savesql($_POST[description]);
  $_POST[author] = savesql($_POST[author]);
  $_POST[admin_mail] = savesql($_POST[admin_mail]);
  $_POST[keywords] = savesql($_POST[keywords]);
  $_POST[date] = savesql($_POST[date]);
  $_POST[page] = savesql($_POST[page]);
  $_POST[page_next] = savesql($_POST[page_next]);
  $_POST[page_prev] = savesql($_POST[page_prev]);
  $_POST[feed] = savesql($_POST[feed]);
  $_POST[language] = savesql($_POST[language]);
  
  mysql_query("UPDATE ".$global_config_arr[pref]."global_config
               SET virtualhost = '$_POST[virtualhost]',
                   admin_mail = '$_POST[admin_mail]',
                   title = '$_POST[title]',
                   description = '$_POST[description]',
                   keywords = '$_POST[keywords]',
                   author = '$_POST[author]',
                   show_favicon = '$_POST[show_favicon]',
                   design = '$_POST[design]',
                   allow_other_designs = '$_POST[allow_other_designs]',
                   show_announcement = '$_POST[show_announcement]',
                   date = '$_POST[date]',
                   page = '$_POST[page]',
                   page_next = '$_POST[page_next]',
                   page_prev = '$_POST[page_prev]',
                   registration_antispam = '$_POST[registration_antispam]',
                   feed = '$_POST[feed]',
                   language = '$_POST[language]'
               WHERE id = 1", $db);
    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."global_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    if (isset($_POST['sended']))
    {
        $config_arr[title] = $_POST['title'];
        $config_arr[virtualhost] = $_POST['virtualhost'];
        $config_arr[admin_mail] = $_POST['admin_mail'];
        $config_arr[description] = $_POST['description'];
        $config_arr[author] = $_POST['author'];
        $config_arr[keywords] = $_POST['keywords'];
        $config_arr[show_favicon] = $_POST['show_favicon'];
        $config_arr[feed] = $_POST['feed'];
        $config_arr[language] = $_POST['language'];
        $config_arr[design] = $_POST['design'];
        $config_arr[allow_other_designs] = $_POST['allow_other_designs'];
        $config_arr[show_announcement] = $_POST['show_announcement'];
        $config_arr[registration_antispam] = $_POST['registration_antispam'];
        $config_arr[date] = $_POST['date'];
        $config_arr[page] = $_POST['page'];
        $config_arr[page_next] = $_POST['page_next'];
        $config_arr[page_prev] = $_POST['page_prev'];
    
        systext($admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE);
    }

        $config_arr[title] = killhtml($config_arr[title]);
        $config_arr[virtualhost] = killhtml($config_arr[virtualhost]);
        $config_arr[description] = killhtml($config_arr[description]);
        $config_arr[author] = killhtml($config_arr[author]);
        $config_arr[admin_mail] = killhtml($config_arr[admin_mail]);
        $config_arr[keywords] = killhtml($config_arr[keywords]);
        $config_arr[design] = killhtml($config_arr[design]);
        $config_arr[allow_other_designs] = killhtml($config_arr[allow_other_designs]);
        $config_arr[date] = killhtml($config_arr[date]);
        $config_arr[page] = killhtml($config_arr[page]);
        $config_arr[page_next] = killhtml($config_arr[page_next]);
        $config_arr[page_prev] = killhtml($config_arr[page_prev]);


    echo'
					<form action="" method="post">
						<input type="hidden" value="allconfig" name="go">
                        <input type="hidden" name="sended" value="1">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[general][pageinfo_title].'</td></tr>
							<tr>
                                <td class="config">
                                    '.$admin_phrases[general][title].':<br>
                                    <span class="small">'.$admin_phrases[general][title_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="title" maxlength="100" value="'.$config_arr[title].'" />
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][virtualhost].':<br>
                                    <span class="small">'.$admin_phrases[general][virtualhost_desc].'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="40" name="virtualhost" maxlength="255" value="'.$config_arr[virtualhost].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][admin_mail].':<br>
                                    <span class="small">'.$admin_phrases[general][admin_mail_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="admin_mail" maxlength="100" value="'.$config_arr[admin_mail].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][description].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[general][description_desc].'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="40" name="description" maxlength="255" value="'.$config_arr[description].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][author].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[general][author_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="author" maxlength="100" value="'.$config_arr[author].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][keywords].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[general][keywords_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="40" name="keywords" maxlength="255" value="'.$config_arr[keywords].'">
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
                                    <select name="design" size="1">';

                                    $index = mysql_query("select id, name from ".$global_config_arr[pref]."template ORDER BY id", $db);
                                    while ($design_arr = mysql_fetch_assoc($index))
                                    {
                                        echo '<option value="'.$design_arr[id].'"';
                                        if ( $design_arr[id] == $global_config_arr[design] ) {
                                            echo ' selected=selected';
                                        }
                                        echo '>'.$design_arr[name];
                                        if ( $design_arr[id] == $global_config_arr[design] ) {
                                            echo ' ('.$admin_phrases[common][active].')';
                                        }
                                        echo '</option>';
                                    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][allow_other_designs].':<br>
                                    <span class="small">'.$admin_phrases[general][allow_other_designs_desc].'</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="allow_other_designs" value="1"';
                                    if ( $config_arr[allow_other_designs] == 1 ) {
                                        echo " checked=checked";
                                    }
                                    echo'/>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][show_favicon].':<br>
                                    <span class="small">'.$admin_phrases[general][show_favicon_desc].'</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="show_favicon" value="1"';
                                    if ( $config_arr[show_favicon] == 1 ) {
                                        echo " checked=checked";
                                    }
                                    echo'/>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][language].':<br>
                                    <span class="small">'.$admin_phrases[general][language_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="language" size="1">';
                                    echo '<option value="de"';
                                    if ( $config_arr[language] == "de" ) {
                                        echo ' selected="selected"';
                                    }
                                    echo '>'.$admin_phrases[general][language_de].'</option>';

                                    echo '<option value="en"';
                                    if ( $config_arr[language] == "en" ) {
                                        echo ' selected="selected"';
                                    }
                                    echo '>'.$admin_phrases[general][language_en].'</option>';
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][feed].':<br>
                                    <span class="small">'.$admin_phrases[general][feed_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="feed" size="1">';
                                        echo '<option value="rss091"';
                                        if ( $config_arr[feed] == "rss091" ) {
                                            echo ' selected="selected"';
                                        }
                                        echo '>'.$admin_phrases[general][feed_rss091].'</option>';

                                        echo '<option value="rss10"';
                                        if ( $config_arr[feed] == "rss10" ) {
                                            echo ' selected="selected"';
                                        }
                                        echo '>'.$admin_phrases[general][feed_rss10].'</option>';

                                        echo '<option value="rss20"';
                                        if ( $config_arr[feed] == "rss20" )  {
                                            echo ' selected="selected"';
                                        }
                                        echo '>'.$admin_phrases[general][feed_rss20].'</option>';

                                        echo '<option value="atom10"';
                                        if ( $config_arr[feed] == "atom10" ) {
                                            echo ' selected="selected"';
                                        }
                                        echo '>'.$admin_phrases[general][feed_atom10].'</option>';
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$admin_phrases[general][show_announcement].':<br>
                                    <span class="small">'.$admin_phrases[general][show_announcement_desc].'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="show_announcement">

                                        <option value="1"';
                                        if ( $config_arr[show_announcement] == 1 ) {
                                            echo ' selected="selected"';
                                        }
                                        echo'>'.$admin_phrases[general][show_ann_always].'</option>
                                        
                                        <option value="2"';
                                        if ( $config_arr[show_announcement] == 2 ) {
                                            echo ' selected="selected"';
                                        }
                                        echo'>'.$admin_phrases[general][show_ann_news].'</option>
                                        
                                        <option value="0"';
                                        if ( $config_arr[show_announcement] == 0 ) {
                                            echo ' selected="selected"';
                                        }
                                        echo'>'.$admin_phrases[general][show_ann_never].'</option>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$admin_phrases[general][reg_antispam].':<br>
                                    <span class="small">'.$admin_phrases[general][reg_antispam_desc].'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input type="checkbox" name="registration_antispam" value="1"';
                                    if ($config_arr[registration_antispam] == 1 ) {
                                        echo ' checked="checked"';
                                    }
                                    echo'/>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$admin_phrases[general][date].': <br>
                                    <span class="small">'.$admin_phrases[general][date_desc].'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="40" name="date" maxlength="255" value="'.$config_arr[date].'"><br />
                                    <span class="small">'.$admin_phrases[general][date_info].'</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td colspan="2" class="line">'.$admin_phrases[general][pagenav_title].'</td></tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$admin_phrases[general][page].': <br>
                                    <span class="small">'.$admin_phrases[general][page_desc].'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <textarea class="courier" name="page" wrap="virtual" style="width:275px; height:50px;">'.$config_arr[page].'</textarea>
                                    <br /><span class="small">'.$admin_phrases[general][page_info].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$admin_phrases[general][page_prev].': <br>
                                    <span class="small">'.$admin_phrases[general][page_prev_desc].'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="courier" style="width:275px;" name="page_prev" maxlength="255" value="'.$config_arr[page_prev].'"><br />
                                    <span class="small">'.$admin_phrases[general][page_prev_info].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    '.$admin_phrases[general][page_next].': <br>
                                    <span class="small">'.$admin_phrases[general][page_next_desc].'</span>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="courier" style="width:275px;" name="page_next" maxlength="255" value="'.$config_arr[page_next].'"><br />
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