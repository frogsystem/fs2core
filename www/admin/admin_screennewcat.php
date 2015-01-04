<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//////////////////////
//// Add category ////
//////////////////////

if (isset($_POST['cat_name']) && !emptystr($_POST['cat_name']))
{
    $_POST['cat_type'] = intval($_POST['cat_type']);
    $_POST['cat_visibility'] = intval($_POST['cat_visibility']);

    $time = time();
    $stmt = $FD->db()->conn()->prepare(
                'INSERT INTO '.$FD->config('pref')."screen_cat (cat_name, cat_type, cat_visibility, cat_date)
                 VALUES (?,
                         '".$_POST['cat_type']."',
                         '".$_POST['cat_visibility']."',
                         '$time')");
    $stmt->execute(array($_POST['cat_name']));

    systext($FD->text('admin', 'cat_added'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_add'));
}

/////////////////////////
///// Category Form /////
/////////////////////////

else
{
    if (isset($_POST['sended'])) {
      $error_message = 'Bitte f&uuml;llen Sie <b>alle Pflichfelder</b> aus!';
      systext($error_message, $FD->text('admin', 'error_occurred'), 'red', $FD->text('admin', 'icon_save_error'));
    }

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="gallery_newcat" name="go">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="2"><h3>Neue Kategorie</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Name:<br>
                                    <font class="small">Name der neuen Kategorie</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="cat_name" size="33" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Art:<br>
                                    <font class="small">Kategorie-Typ</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="cat_type" size="1">
                                        <option value="1">Screenshots / Zufallsbild</option>
                                        <option value="2">Wallpaper</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Sichtbarkeit:<br>
                                    <font class="small">Wird die Kategorie angezeigt</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="cat_visibility" size="1">
                                        <option value="1">vollst&auml;ndig sichtbar</option>
                                        <option value="2">nicht in Auswahl verf&uuml;gbar</option>
                                        <option value="0">nicht aufrufbar</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button type="submit" value="1" class="button_new" name="sended">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'cat_add').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
