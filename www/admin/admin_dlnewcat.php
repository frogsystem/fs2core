<?php if (!defined('ACP_GO')) die('Unauthorized access!');

/////////////////////////////////
//// Insert Category into DB ////
/////////////////////////////////

if (!empty($_POST['catname']))
{
    settype($_POST['subcatof'], 'integer');
    $stmt = $FD->db()->conn()->prepare(
                'INSERT INTO '.$FD->env('DB_PREFIX')."dl_cat (subcat_id, cat_name)
                 VALUES ('".$_POST['subcatof']."', ?)");
    $stmt->execute(array($_POST['catname']));
    systext('Kategorie wurde hinzugef&uuml;gt');

    unset($_POST);
}

///////////////////////////////////
///////// Kategorie Form //////////
///////////////////////////////////

if(true)
{
    if(isset($_POST['sended'])) {
        echo get_systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));
    }

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_newcat" name="go">
                        <input type="hidden" value="add" name="sended">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Kategorie hinzuf&uuml;gen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Name:<br>
                                    <font class="small">Name der neuen Kategorie</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="catname" size="33" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Subkategorie von:<br>
                                    <font class="small">Macht diese Kategorie zu einer Unterkategorie einer anderen</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="subcatof">
                                        <option value="0">Keine Subkategorie</option>
                                        <option value="0">--------------------------------------</option>
    ';

    $valid_ids = array();
    get_dl_categories ($valid_ids, -1);

    foreach ($valid_ids as $cat)
    {
        echo'
                                        <option value="'.$cat['cat_id'].'">'.str_repeat('&nbsp;&nbsp;&nbsp;', $cat['level']).$cat['cat_name'].'</option>
        ';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <br><input class="button" type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
