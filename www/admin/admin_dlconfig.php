<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('screen_x', 'screen_y', 'thumb_x', 'thumb_y', 'quickinsert', 'dl_rights', 'dl_show_sub_cats');

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (isset($_POST['screen_x']) && isset($_POST['screen_y']) && isset($_POST['thumb_x']) && isset($_POST['thumb_y']) && isset($_POST['quickinsert']))
{
    settype($_POST['screen_x'], 'integer');
    settype($_POST['screen_y'], 'integer');
    settype($_POST['thumb_x'], 'integer');
    settype($_POST['thumb_y'], 'integer');
    settype($_POST['dl_rights'], 'integer');
    settype($_POST['dl_show_sub_cats'], 'integer');

    // prepare data
    $data = frompost($used_cols);

    // save config
    try {
        $FD->saveConfig('downloads', $data);
        systext($FD->text('admin', 'config_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
    } catch (Exception $e) {
        systext(
            $FD->text('admin', 'config_not_saved').'<br>'.
            (DEBUG ? $e->getMessage() : $FD->text('admin', 'unknown_error')),
            $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error')
        );
    }

    // Unset Vars
    unset($_POST);
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

if(true)
{
    if(isset($_POST['sended'])) {
        echo get_systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));
    } else {
        $FD->loadConfig('downloads');
        $data = $FD->configObject('downloads')->getConfigArray();
        putintopost($data);
    }

    $_POST = array_map('killhtml', $_POST);

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
                                    <input class="text" size="5" name="screen_x" value="'.$_POST['screen_x'].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="screen_y" value="'.$_POST['screen_y'].'" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Thumbnail Gr&ouml;&szlig;e:<br>
                                    <font class="small">Gibt die Gr&ouml;&szlig;e der Thumbnails an</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="thumb_x" value="'.$_POST['thumb_x'].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="thumb_y" value="'.$_POST['thumb_y'].'" maxlength="3">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Quick-Insert Pfad:<br>
                                    <font class="small">Der Datei-Pfad der mit dem Quick-Insert Button eingef&uuml;gt wird.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="40" name="quickinsert" value="'.($_POST['quickinsert']).'" maxlength="255">
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
                                        if ($_POST['dl_rights'] == 2)
                                            echo ' selected="selected"';
                                        echo'>alle User</option>
                                        <option value="1"';
                                        if ($_POST['dl_rights'] == 1)
                                            echo ' selected="selected"';
                                        echo'>registrierte User</option>
                                        <option value="0"';
                                        if ($_POST['dl_rights'] == 0)
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
                                    <input type="checkbox" name="dl_show_sub_cats" value="1" '.getchecked ( 1, $_POST['dl_show_sub_cats'] ).'>
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
