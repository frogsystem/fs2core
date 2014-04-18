<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('partner_anzahl', 'small_x', 'small_y', 'small_allow', 'big_x', 'big_y', 'big_allow', 'file_size');


///////////////////////////
/// Edit affiliate site ///
///////////////////////////

if (isset($_POST['small_x']) && isset($_POST['small_y']) && isset($_POST['big_x']) && isset($_POST['big_y']) && isset($_POST['file_size']) && (isset($_POST['partner_anzahl']) && $_POST['partner_anzahl']>0))
{
    // prepare data
    $data = frompost($used_cols);

    // save config
    try {
        $FD->saveConfig('affiliates', $data);
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

///////////////////////////////
/// Display affiliate site ////
///////////////////////////////

if ( TRUE )
{

    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $FD->loadConfig('affiliates');
        $data = $FD->configObject('affiliates')->getConfigArray();
        putintopost($data);
    }

    // security functions
    $_POST = array_map('killhtml', $_POST);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="partner_config" name="go">
                        <input type="hidden" value="1" name="sended">
                        <table border="0" cellpadding="4" cellspacing="0" >
                            <tr><td colspan="2" class="line">Einstellungen</td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Anzahl zuf&auml;lliger Partner:<br />
                                    <font class="small">Anzahl der zus&auml;tzlich zuf&auml;llig angezeigten Partnerbuttons.<br />
                                    <b>Permanente Partner werden grunds&auml;tzlich immer angezeigt!</b></font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="partner_anzahl" size="1" value="'.$_POST['partner_anzahl'].'" maxlength="2"> Partnerseiten
                                    <br /><font class="small">(0 ist nicht zul&auml;ssig)</font>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td colspan="2" class="line">Bilder</td></tr>
                            <tr>
                                <td class="config" valign="top" width="70%">
                                    Abmessungen kleine Bilder:<br>
                                    <font class="small">Stellt die Gr&ouml;&szlig;e der kleinen Bilder ein.</font>
                                </td>
                                <td class="config" valign="top" width="30%">
                                    <input class="text" size="5" name="small_x" value="'.$_POST['small_x'].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="small_y" value="'.$_POST['small_y'].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Kleine Bilder:<br>
                                    <font class="small">Eigenschaft der Gr&ouml;&szlig;eneinstellung.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="small_allow">
                                        <option value="0"';
                                        if ($_POST['small_allow'] == 0)
                                            echo ' selected="selected"';
                                        echo'>m&uuml;ssen exakt diese Gr&ouml;&szlig;e haben</option>
                                        <option value="1"';
                                        if ($_POST['small_allow'] == 1)
                                            echo ' selected="selected"';
                                        echo'>d&uuml;rfen auch kleiner sein</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Abmessungen gro&szlig;e Bilder:<br>
                                    <font class="small">Stellt die Gr&ouml;&szlig;e der gro&szlig;en Bilder ein.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="big_x" value="'.$_POST['big_x'].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="big_y" value="'.$_POST['big_y'].'" maxlength="3"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Gro&szlig;e Bilder:<br>
                                    <font class="small">Eigenschaft der Gr&ouml;&szlig;eneinstellung.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="big_allow">
                                        <option value="0"';
                                        if ($_POST['big_allow'] == 0)
                                            echo ' selected="selected"';
                                        echo'>m&uuml;ssen exakt diese Gr&ouml;&szlig;e haben</option>
                                        <option value="1"';
                                        if ($_POST['big_allow'] == 1)
                                            echo ' selected="selected"';
                                        echo'>d&uuml;rfen auch kleiner sein</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="70%">
                                    Dateigr&ouml;&szlig;e:<br>
                                    <font class="small">Dateigr&ouml;&szlig;e, bis zu der Bilder hochgeladen werden k&ouml;nnen.</font>
                                </td>
                                <td class="config" valign="top" width="30%">
                                    <input class="text" size="5" name="file_size" value="'.$_POST['file_size'].'" maxlength="4"> KB
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button type="submit" value="" class="button_new">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'save_changes_button').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

?>
