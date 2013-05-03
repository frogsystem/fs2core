<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$used_cols = array('game_navi', 'cat_navi', 'lang_navi', 'show_press', 'show_root', 'order_by', 'order_type');

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (isset($_POST['sended'])
   )
{
    // prepare data
    $data = frompost($used_cols);

    // save config
    try {
        $FD->saveConfig('press', $data);
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
    // Display Error Messages
    if (isset($_POST['sended'])) {
        systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));

    // Load Data from DB into Post
    } else {
        $FD->loadConfig('press');
        $data = $FD->configObject('press')->getConfigArray();
        putintopost($data);
    }

    // security functions
    $_POST = array_map('killhtml', $_POST);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="press_config" name="go">
                        <input type="hidden" name="sended" value="save">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Einstellungen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Presseberichte anzeigen:<br>
                                    <font class="small">In welchen Ordnern der Navigation sollen Presseberichte angezeigt werden?</font>
                                    </td>
                                    <td class="config" valign="top" width="50%">
                                    <select name="show_press">
                                    <option value="1"';
                 if ($_POST['show_press'] == 1)
                   echo ' selected="selected"';
                 echo'>in allen Ordnern</option>
                                  <option value="0"';
                 if ($_POST['show_press'] == 0)
                   echo ' selected="selected"';
                 echo'>nur in Ordnern der letzten Ebene</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Alle Presseberichte anzeigen:<br>
                                    <font class="small">Sollen beim Seitenaufruf ohne Parameter alle Presseberichte angezeigt werden?</font>
                                    </td>
                                    <td class="config" valign="top" width="50%">
                                    <select name="show_root">
                                    <option value="0"';
                 if ($_POST['show_root'] == 0)
                   echo ' selected="selected"';
                 echo'>nicht anzeigen</option>
                           <option value="1"';
                   if ($_POST['show_root'] == 1)
                   echo ' selected="selected"';
                 echo'>anzeigen</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    In Navigation anzeigen:<br>
                                    <font class="small">Ausgew&auml;hlte werden in der Navigation als Ordner angezeigt.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input type="checkbox" style="vertical-align:middle;" name="game_navi" value="1"';
    if ($_POST['game_navi'] == 1) {echo " checked=checked";}
    echo'>Spiele<br />
                                    <input type="checkbox" style="vertical-align:middle;" name="cat_navi" value="1"';
    if ($_POST['cat_navi'] == 1) {echo " checked=checked";}
    echo'>Kategorien<br />
                                    <input type="checkbox" style="vertical-align:middle;" name="lang_navi" value="1"';
    if ($_POST['lang_navi'] == 1) {echo " checked=checked";}
    echo'>Sprachen
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Sortierung:<br>
                                    <font class="small">Wie sollen die Presseberichte sortiert werden?</font>
                                    </td>
                                    <td class="config" valign="top" width="50%">
                                    sortieren
                                    <select name="order_by">
                                    <option value="press_title"';
                 if ($_POST['order_by'] == "press_title")
                   echo ' selected="selected"';
                 echo'>nach Titel</option>
                                  <option value="press_date"';
                 if ($_POST['order_by'] == "press_date")
                   echo ' selected="selected"';
                 echo'>nach Datum</option>
                                    </select>,
                                    <select name="order_type">
                                    <option value="asc"';
                 if ($_POST['order_type'] == "asc")
                   echo ' selected="selected"';
                 echo'>aufsteigend</option>
                                  <option value="desc"';
                 if ($_POST['order_type'] == "desc")
                   echo ' selected="selected"';
                 echo'>absteigend</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "save_changes_button").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
