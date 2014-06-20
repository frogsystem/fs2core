<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('answerbar_width', 'answerbar_type');

//////////////////////////////
//// Configuration update ////
//////////////////////////////

if (isset($_POST['answerbar_width']))
{
    // prepare data
    $data = frompost($used_cols);

    // save config
    try {
        $FD->saveConfig('polls', $data);
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

/////////////////////////////////
////// Konfiguration Form ///////
/////////////////////////////////

if(true)
{
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $FD->loadConfig('polls');
        $data = $FD->configObject('polls')->getConfigArray();
        putintopost($data);
    }

    // security functions
    $_POST = array_map('killhtml', $_POST);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="poll_config" name="go">
                        <input type="hidden" value="1" name="sended">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Einstellungen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Antwortbalken - Breite:<br>
                                    <font class="small">Breite des Antwortbalkens bei 100% der Stimmen</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="answerbar_width" value="'.$_POST['answerbar_width'].'" maxlength="3">
                                    <select name="answerbar_type">
                                        <option value="0"';
                                        if ($_POST['answerbar_type'] == 0)
                                            echo ' selected="selected"';
                                        echo'>Pixel</option>
                                        <option value="1"';
                                        if ($_POST['answerbar_type'] == 1)
                                            echo ' selected="selected"';
                                        echo'>Prozent</option>
                                    </select>
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
