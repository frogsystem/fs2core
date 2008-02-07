<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ( isset ( $_POST[change] ) )
{
    $_POST['text'] = savesql ( $_POST['text'] );

    mysql_query("UPDATE ".$global_config_arr['pref']."announcement
                 SET text = '".$_POST['text']."'", $db);
    
    settype($_POST['show_announcement'], "integer");
    settype($_POST['activate_announcement'], "integer");

    mysql_query("UPDATE ".$global_config_arr['pref']."global_config
                 SET show_announcement = '".$_POST['show_announcement']."',
                     activate_announcement = '".$_POST['activate_announcement']."'
                 WHERE id = 1", $db);
    
    systext($admin_phrases[common][changes_saved], $admin_phrases[common][info]);
}

/////////////////////////////////
/////// Formular erzeugen ///////
/////////////////////////////////

else
{
    $index = mysql_query("SELECT show_announcement, activate_announcement FROM ".$global_config_arr[pref]."global_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    $index = mysql_query("SELECT text FROM ".$global_config_arr[pref]."announcement", $db);
    $config_arr[text] = stripslashes(mysql_result($index, 0, "text"));

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="1" name="change">
                        <input type="hidden" value="allannouncement" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][ann_settings_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][show_announcement].':<br>
                                    <span class="small">'.$admin_phrases[general][show_announcement_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="show_announcement">
                                        <option value="1"';
                                        if ($config_arr[show_announcement] == 1)
                                            echo ' selected="selected"';
                                        echo'>'.$admin_phrases[general][show_ann_always].'</option>
                                        <option value="2"';
                                        if ($config_arr[show_announcement] == 2)
                                            echo ' selected="selected"';
                                        echo'>'.$admin_phrases[general][show_ann_news].'</option>
                                        <option value="0"';
                                        if ($config_arr[show_announcement] == 0)
                                            echo ' selected="selected"';
                                        echo'>'.$admin_phrases[general][show_ann_never].'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[general][activate_ann].':<br>
                                    <span class="small">'.$admin_phrases[general][activate_ann_desc].'</span>
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="activate_announcement" value="1"';
                                    if ($config_arr[activate_announcement] == 1)
                                        echo ' checked="checked"';
                                    echo'/>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="line" colspan="2">'.$admin_phrases[general][ann_title].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <span class="small">'.$admin_phrases[general][ann_write_desc].'</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( "text", $config_arr[text], "100%", "250px", "", FALSE ).'
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