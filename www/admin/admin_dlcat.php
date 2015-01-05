<?php if (!defined('ACP_GO')) die('Unauthorized access!');

/////////////////////////
//// Change category ////
/////////////////////////

if (isset($_POST['catname']))
{
    settype($_POST['catid'], 'integer');
    if (isset($_POST['delcat']))
    {
        $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref').'dl_cat WHERE cat_id = '.$_POST['catid']);
        systext('Die Kategorie wurde gel&ouml;scht');
    }
    else
    {
        settype($_POST['subcatof'], 'integer');

        $stmt = $FD->sql()->conn()->prepare(
                  'UPDATE '.$FD->config('pref')."dl_cat
                   SET subcat_id = '$_POST[subcatof]',
                       cat_name = ?
                   WHERE cat_id = $_POST[catid]");
        $stmt->execute(array($_POST['catname']));
        systext('Die Kategorie wurde editiert');
    }
    unset($_POST);
}

/////////////////////
/// Category Form ///
/////////////////////

if (isset($_POST['editcatid']))
{
    $_POST['editcatid'] = $_POST['editcatid'][0];
    if(isset($_POST['sended'])) {
        echo get_systext($FD->text("admin", "changes_not_saved").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_save_error"));
    }



    settype ($_POST['editcatid'], 'integer');

    $valid_ids = array();
    get_dl_categories ($valid_ids, $_POST['editcatid']);

    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."dl_cat WHERE cat_id = '$_POST[editcatid]'");
    $cat_arr = $index->fetch(PDO::FETCH_ASSOC);
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_cat" name="go">
                        <input type="hidden" value="edit" name="sended">
                        <input type="hidden" value="'.$cat_arr['cat_id'].'" name="catid">
                        <input type="hidden" value="'.$cat_arr['cat_id'].'" name="editcatid[0]">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Kategorie bearbeiten</h3><hr></td></tr>

                            <tr>
                                <td class="config" valign="top">
                                    Name:<br>
                                    <font class="small">Name der neuen Kategorie</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="catname" size="33" value="'.$cat_arr['cat_name'].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Subkategorie von:<br>
                                    <font class="small">Macht diese Kategorie zu einer Unterkategorie einer anderen</font>
                                </td>
                                <td class="configthin" valign="top">
                                    <select name="subcatof">
                                        <option value="0">Keine Subkategorie</option>
                                        <option value="0">--------------------------</option>
    ';
    foreach ($valid_ids as $cat)
    {
        $sele = ($cat_arr['subcat_id'] == $cat['cat_id']) ? 'selected' : '';
        echo'
                                        <option value="'.$cat['cat_id'].'" '.$sele.'>'.str_repeat('&nbsp;&nbsp;&nbsp;', $cat['level']).$cat['cat_name'].'</option>
        ';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Kategorie l&ouml;schen:
                                </td>
                                <td class="config">
                                    <input onClick=\'delalert ("delcat", "Soll die Downloadkategorie wirklich gelöscht werden?")\' type="checkbox" name="delcat" id="delcat" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <br><input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

///////////////////////
/// Select Category ///
///////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_cat" name="go">
                        <table class="content select_list" cellpadding="3" cellspacing="0">
                            <tr><td colspan="3"><h3>Kategorie bearbeiten</h3><hr></td></tr>
                            <tr>
                                <td class="config" width="40%">
                                    Name
                                </td>
                                <td class="config" width="40%">
                                    Subkategorie
                                </td>
                                <td class="config" width="20%">
                                    bearbeiten
                                </td>
                            </tr>
    ';
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref').'dl_cat ORDER BY cat_name');
    while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        $sub = ($cat_arr['subcat_id'] == 0) ? 'Nein' : 'Ja';
        echo'
                            <tr class="thin select_entry">
                                <td class="configthin">
                                    '.$cat_arr['cat_name'].'
                                </td>
                                <td class="configthin">
                                    '.$sub.'
                                </td>
                                <td class="config">
                                    <input class="select_box" type="checkbox" name="editcatid[]" value="'.$cat_arr['cat_id'].'">
                                </td>
                            </tr>
        ';
    }
    echo'
                            <tr style="display:none">
                                <td colspan="3">
                                    <select class="select_type" name="cat_action" size="1">
                                        <option class="select_one" value="edit">'.$FD->text('admin', 'selection_edit').'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                    <input class="button" type="submit" value="editieren">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
