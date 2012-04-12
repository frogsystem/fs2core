<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST['screenx'] && $_POST['screeny'] && $_POST['thumbx'] && $_POST['thumby'] && $_POST['quickinsert'])
{
    settype($_POST['screenx'], 'integer');
    settype($_POST['screeny'], 'integer');
    settype($_POST['thumbx'], 'integer');
    settype($_POST['thumby'], 'integer');
    settype($_POST['dl_rights'], 'integer');
    $_POST['quickinsert'] = savesql($_POST['quickinsert']);
    settype($_POST['dl_show_sub_cats'], 'integer');
    
    $update = 'UPDATE '.$global_config_arr['pref']."dl_config
               SET screen_x = '$_POST[screenx]',
                   screen_y = '$_POST[screeny]',
                   thumb_x = '$_POST[thumbx]',
                   thumb_y = '$_POST[thumby]',
                   quickinsert = '$_POST[quickinsert]',
                   dl_rights = '$_POST[dl_rights]',
                   dl_show_sub_cats = '$_POST[dl_show_sub_cats]'
               ";
    mysql_query($update, $FD->sql()->conn() );
    systext('Die Konfiguration wurde aktualisiert.');
    unset($_POST);
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

if(true)
{
    if(isset($_POST['sended'])) {
        echo get_systext($TEXT['admin']->get('changes_not_saved').'<br>'.$TEXT['admin']->get('form_not_filled'), $TEXT['admin']->get('error'), 'red', $TEXT['admin']->get('icon_save_error'));
    }        
    
    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'dl_config', $FD->sql()->conn() );
    $config_arr = mysql_fetch_assoc($index);
    
    settype ( $config_arr['dl_show_sub_cats'], 'integer' );
    
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_config" name="go">
                        <input type="hidden" value="save" name="sended">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Einstellungen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top" width="70%">
                                    Max. Bildgr&ouml;&szlig;e:<br>
                                    <font class="small">Stellt die max. Upload Gr&ouml;&szlig;e der Vorschau-Bilder ein</font>
                                </td>
                                <td class="config" valign="top" width="30%">
                                    <input class="text" size="5" name="screenx" value="'.$config_arr['screen_x'].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="screeny" value="'.$config_arr['screen_y'].'" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Thumbnail Gr&ouml;&szlig;e:<br>
                                    <font class="small">Gibt die Gr&ouml;&szlig;e der Thumbnails an</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="thumbx" value="'.$config_arr['thumb_x'].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="thumby" value="'.$config_arr['thumb_y'].'" maxlength="3">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Quick-Insert Pfad:<br>
                                    <font class="small">Der Datei-Pfad der mit dem Quick-Insert Button eingef&uuml;gt wird.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="40" name="quickinsert" value="'.stripslashes(killhtml($config_arr['quickinsert'])).'" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Downloads erlauben f&uuml;r:<br>
                                    <font class="small">Wer darf die Downloads verwenden?</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="dl_rights">
                                        <option value="2"';
                                        if ($config_arr['dl_rights'] == 2)
                                            echo ' selected="selected"';
                                        echo'>alle User</option>
                                        <option value="1"';
                                        if ($config_arr['dl_rights'] == 1)
                                            echo ' selected="selected"';
                                        echo'>registrierte User</option>
                                        <option value="0"';
                                        if ($config_arr['dl_rights'] == 0)
                                            echo ' selected="selected"';
                                        echo'>niemanden</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Unterkategorien immer zeigen:<br>
                                    <font class="small">Zeigt immer alle Unterkategorien an, auch wenn Ordner nicht ge&ouml;ffnet.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input type="checkbox" name="dl_show_sub_cats" value="1" '.getchecked ( 1, $config_arr['dl_show_sub_cats'] ).'>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
