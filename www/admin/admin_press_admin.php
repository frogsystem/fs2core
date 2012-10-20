<?php if (!defined('ACP_GO')) die('Unauthorized access!');

////////////////////////////
//// Pressadmin add ////////
////////////////////////////
if (isset($_POST['entry_action'])
    && $_POST['entry_action'] == 'add'
    && isset($_POST['entry_is'])&& !empty($_POST['entry_is'])
    && (isset($_POST['title']) AND $_POST['title'] != '')
   )
{
    $_POST['title'] = savesql($_POST['title']);
    settype($_POST['entry_is'], 'integer');

    mysql_query('INSERT INTO '.$FD->config('pref')."press_admin
                 (type, title)
                 VALUES ('$_POST[entry_is]', '$_POST[title]')", $FD->sql()->conn() );
    $msg = array();
    $msg[] = 'Eintrag wurde hinzugef&uuml;gt!';

    if ($_FILES['entry_pic']['name'] != '') {
        $id = mysql_insert_id();
        $upload = upload_img($_FILES['entry_pic'], 'images/press/', $_POST['entry_is'].'_'.$id, 1024*1024, 999, 999);
        $msg[] = upload_img_notice($upload);
    } else {
        $msg[] = 'Es wurde kein Bild zum Upload ausgew&auml;hlt.';
    }

    echo get_systext(implode('<br>', $msg), $FD->text("admin", "info"), 'green', $FD->text("admin", "icon_save_add"));
    unset($_POST);
}

////////////////////////////
//// Pressadmin edit ///////
////////////////////////////
elseif ((isset($_POST['title']) AND $_POST['title'] != '')
    && $_POST['entry_action'] == 'edit'
    && $_POST['sended'] == 'edit'
    && isset($_POST['entry_id'][0])
   )
{
    $_POST['entry_id'] = $_POST['entry_id'][0];
    settype($_POST['entry_id'], 'integer');
    settype($_POST['entry_is'], 'integer');
    $_POST['title'] = savesql($_POST['title']);

    mysql_query('UPDATE '.$FD->config('pref')."press_admin
                 SET title = '$_POST[title]',
                     type = '$_POST[entry_is]'
                 WHERE id = '$_POST[entry_id]'", $FD->sql()->conn() );
    systext('Der Eintrag wurde aktualisiert!');

    if ($_POST['entry_pic_delete'] == 1)
    {
      if (image_delete('images/press/', $_POST['entry_is'].'_'.$_POST['entry_id']))
      {
        systext('Das Bild wurde erfolgreich gel&ouml;scht!');
      }
    }
    elseif ($_FILES['entry_pic']['name'] != '')
    {
        $upload = upload_img($_FILES['entry_pic'], 'images/press/', $_POST['entry_is'].'_'.$_POST['entry_id'], 1024*1024, 999, 999);
        systext(upload_img_notice($upload));
    }

    unset($_POST['entry_action']);
    unset($_POST['sended']);
    unset($_POST['entry_id']);
}

////////////////////////////
//// Pressadmin löschen ////
////////////////////////////
elseif (isset($_POST['entry_action'])
    && $_POST['entry_action'] == 'delete'
    && $_POST['sended'] == 'delete'
    && isset($_POST['entry_move_to'])
    && isset($_POST['entry_id'])
   )
{
    settype($_POST['entry_id'], 'integer');
    settype($_POST['entry_is'], 'integer');

    if ($_POST['delete_press_admin'])   // Partnerseite löschen
    {
        $index = mysql_query('SELECT type FROM '.$FD->config('pref')."press_admin WHERE id = '$_POST[entry_id]'", $FD->sql()->conn() );
        $entry_arr['type'] = mysql_result($index, 0, 'type');

        switch ($entry_arr[type])
        {
            case 3:
                $entry_arr['type_set'] = "SET press_lang = '$_POST[entry_move_to]'";
                $entry_arr['type_where'] = "WHERE press_lang = '$_POST[entry_id]'";
                break;
            case 2:
                $entry_arr['type_set'] = "SET press_cat = '$_POST[entry_move_to]'";
                $entry_arr['type_where'] = "WHERE press_cat = '$_POST[entry_id]'";
                break;
            default:
                $entry_arr['type_set'] = "SET press_game = '$_POST[entry_move_to]'";
                $entry_arr['type_where'] = "WHERE press_game = '$_POST[entry_id]'";
                break;
        }

        mysql_query('UPDATE '.$FD->config('pref').'press '.$entry_arr['type_set'].' '.$entry_arr['type_where'], $FD->sql()->conn() );

        mysql_query('DELETE FROM '.$FD->config('pref')."press_admin
                     WHERE id = '$_POST[entry_id]'", $FD->sql()->conn() );

        $msg[] = 'Der Eintrag wurde gel&ouml;scht!';

        if (image_delete('images/press/', $entry_arr['type'].'_'.$_POST['entry_id']))
        {
            $msg[] = 'Das Bild wurde erfolgreich gel&ouml;scht!';
        }

        echo get_systext(implode('<br>', $msg), $FD->text("admin", "info"), 'green', $FD->text("admin", "icon_trash_ok"));

    }
    else
    {
        $msg[] = 'Der Eintrag wurde nicht gel&ouml;scht!';
        echo get_systext(implode('<br>', $msg), $FD->text("admin", "info"), 'green', $FD->text("admin", "icon_info"));
    }

    unset($_POST['delete_press_admin']);
    unset($_POST['entry_action']);
    unset($_POST['sended']);
    unset($_POST['entry_id']);
    unset($_POST['entry_move_to']);
}

////////////////////////////
//// Pressadmin anzeigen ///
////////////////////////////
elseif (isset($_POST['entry_action'])
    && $_POST['entry_action'] == 'edit'
    && isset($_POST['entry_id'])
   )
{
    $_POST['entry_id'] = $_POST['entry_id'][0];
    settype($_POST['entry_id'], 'integer');
    $index = mysql_query('SELECT * FROM '.$FD->config('pref')."press_admin WHERE id = $_POST[entry_id]", $FD->sql()->conn() );
    $entry_arr = mysql_fetch_assoc($index);

    $entry_arr['title'] = killhtml($entry_arr['title']);

    //Error Message
    if ($_POST['sended'] == 'edit') {
        systext ($FD->text("admin", "note_notfilled"));

        $entry_arr['title'] = killhtml($_POST['title']);
        $entry_arr['type'] = $_POST['entry_is'];
        settype($entry_arr['type'], 'integer');
    }

    echo'
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="press_admin" name="go">
                        <input type="hidden" value="edit" name="entry_action">
                        <input type="hidden" value="edit" name="sended">
                        <input type="hidden" value="'.$entry_arr['id'].'" name="entry_id[0]">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Eintrag bearbeiten</h3><hr></td></tr>

                            <tr align="left" valign="top">
                                <td class="config">
                                    Titel:<br />
                                    <font class="small">Der Titel des Eintrags.</font>
                                </td>
                                <td>
                                    <input name="title" size="40" maxlength="100" value="'.$entry_arr['title'].'"                                 class="text" />
                                </td>
                            </tr>
                            <tr align="left" valign="top">
                                <td class="config">
                                    Typ:<br />
                                    <font class="small">Der Typ des Eintrag.</font>
                                </td>
                                <td>
                                    <select name="entry_is" size="1">
                                        <option value="1"';
                                            if($entry_arr['type'] == 1) {echo' selected=selected';} echo'
                                        >Spiel</option>
                                        <option value="2"';
                                            if($entry_arr['type'] == 2) {echo' selected=selected';} echo'
                                        >Kategorie</option>
                                        <option value="3"';
                                            if($entry_arr['type'] == 3) {echo' selected=selected';} echo'
                                        >Sprache</option>
                                    </select>
                                </td>
                            </tr>
                            <tr align="left" valign="top">
                                <td class="config">
                                    Bild: <font class="small">(optional)</font>
                                </td>
                                <td class="config">
    ';

    if (image_exists('images/press/', $entry_arr['type'].'_'.$entry_arr['id']))
    {
        echo'<img src="'.image_url('images/press/', $entry_arr['type'].'_'.$entry_arr['id']).'" alt="" /><br /><br />';
    }

    echo'<input name="entry_pic" type="file" size="40" class="text" /><br />';

    if (image_exists('images/press/', $entry_arr['type'].'_'.$entry_arr['id']))
    {
        echo'
                                    <font class="small">
                                        Nur ausw&auml;hlen, wenn das bisherige Bild &uuml;berschrieben werden soll!
                                    </font><br /><br />
                                    <input style="cursor:pointer; vertical-align:middle;" type="checkbox" name="entry_pic_delete" id="epd" value="1" onClick=\'delalert ("epd", "Soll das Bild wirklich gelöscht werden?")\' />
                                    <font class="small"><b>Bild l&ouml;schen?</b></font><br /><br />
        ';
    }

    echo'
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

////////////////////////////
//// Pressadmin löschen ////
////////////////////////////
elseif (isset($_POST['entry_action'])
    && $_POST['entry_action'] == 'delete'
    && isset($_POST['entry_id'])
   )
{
    $_POST['entry_id'] = $_POST['entry_id'][0];
    settype($_POST['entry_id'], 'integer');
    $index = mysql_query('SELECT COUNT(id) AS number FROM '.$FD->config('pref').'press_admin
                          WHERE type = (SELECT type FROM '.$FD->config('pref')."press_admin WHERE id = $_POST[entry_id])", $FD->sql()->conn() );

    if (mysql_result($index,0,'number') > 1)
    {
        $index = mysql_query('SELECT * FROM '.$FD->config('pref')."press_admin WHERE id = $_POST[entry_id]", $FD->sql()->conn() );
        $entry_arr = mysql_fetch_assoc($index);

        $entry_arr['title'] = killhtml($entry_arr['title']);
        switch ($entry_arr['type'])
        {
            case 3:
                $entry_arr['type_text'] = 'Sprache';
                break;
            case 2:
                $entry_arr['type_text'] = 'Kategorie';
                break;
            default:
                $entry_arr['type_text'] = 'Spiel';
                break;
        }

        echo'
                    <form action="" method="post">
                        <input type="hidden" value="press_admin" name="go">
                        <input type="hidden" value="delete" name="entry_action">
                        <input type="hidden" value="delete" name="sended">
                        <input type="hidden" value="'.$entry_arr['id'].'" name="entry_id">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>'.$FD->text("page", "delpage").': '.$entry_arr['type_text'].'</h3><hr></td></tr>

                            <tr align="left" valign="top">
                                <td class="config" colspan="2" style="padding:0px; margin:0px;">
                                    <table border="0" cellpadding="4" cellspacing="0" width="600">
                                        <tr valign="middle">
                                             <td class="configthin">
                                                 <b>Titel:</b><br />
                                                 '.$entry_arr['title'].'
                                             </td>
                                             <td class="configthin">
                                                 <b>Typ:</b><br />
                                                 '.$entry_arr['type_text'].'
                                             </td>
                                            <td class="configthin">
        ';
        if (image_exists('images/press/', $entry_arr['type'].'_'.$entry_arr['id'])) {
            echo'<img src="'.image_url('images/press/', $entry_arr['type'].'_'.$entry_arr['id']).'" alt="" />';
        }
        echo'
                                             </td>
                                         </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr valign="top">
                                <td width="50%" class="config">
                                    '.$FD->text("page", "delpage_question").'
                                </td>
                                <td width="50%" align="right">
                                    <select name="delete_press_admin" size="1">
                                        <option value="0">'.$FD->text("page", "delnotconfirm").'</option>
                                        <option value="1">'.$FD->text("page", "delconfirm").'</option>
                                    </select>
                                    <input type="submit" value="'.$FD->text("admin", "do_action_button_long").'">
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr align="left" valign="top">
                                <td class="config">
                                    Pressberichte des gel&ouml;schten Eintrags verschieben nach:
                                </td>
                                <td align="right">
                                    <select name="entry_move_to" size="1" class="text">';

        $index = mysql_query('SELECT * FROM '.$FD->config('pref')."press_admin
                              WHERE type = '$entry_arr[type]' AND id != '$entry_arr[id]'
                              ORDER BY title", $FD->sql()->conn() );
        while ($entry_move_arr = mysql_fetch_assoc($index))
        {
            echo'<option value="'.$entry_move_arr['id'].'">'.$entry_move_arr['title'].'</option>';
        }

        echo'
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>';
    }
    else
    {
        $index = mysql_query('SELECT type FROM '.$FD->config('pref')."press_admin WHERE id = $_POST[entry_id]", $FD->sql()->conn() );
        $entry_arr['type'] = mysql_result($index, 0, 'type');

        switch ($entry_arr['type'])
        {
            case 3:
                $entry_arr['type_text'] = 'Sprache';
                break;
            case 2:
                $entry_arr['type_text'] = 'Kategorie';
                break;
            default:
                $entry_arr['type_text'] = 'Spiel';
                break;
        }

        echo'
                    <form action="" method="post">
                        <table class="content"  cellpadding="0" cellspacing="0" width="100%">
                            <tr><td colspan="4"><h3>Eintrag l&ouml;schen</h3><hr></td></tr>
                            <tr valign="middle">
                                <td class="config">
                                    Der letzte Eintrag eines Typs kann nicht gel&ouml;scht werden.<br>
                                    Bitte zuerst einen neuen Eintrag des Typs &bdquo;'.$entry_arr['type_text'].'&rdquo; anlegen.
                                </td>
                                <td>
                                    <input type="submit" value="zur&uuml;ck zur &Uuml;bersicht">
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    } //END if/else: del-or-not
} //END if: entry_action = delete

////////////////////////////
////// Admin list //////////
////////////////////////////
if (!isset($_POST['entry_id']))
{

    //Error Message
    if ($_POST['sended'] == 'add') {
        systext ("Eintrag wurde nicht hinzugef&uuml;gt<br>".$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), "red", $FD->text("admin", "icon_save_error"));

        $entry_arr['title'] = killhtml($_POST['title']);
        settype($_POST['entry_is'], 'integer');
    } else {
        $_POST['title'] = "";
        $_POST['entry_is'] = 0;
    } 
    
    echo'
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="press_admin" name="go">
                        <input type="hidden" value="add" name="entry_action">
                        <input type="hidden" value="add" name="sended">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="4"><h3>Neuen Eintrag hinzuf&uuml;gen</h3><hr></td></tr>
                            <tr align="left" valign="top">
                                <td valign="top">
                                    <span class="small">Titel:</span>
                                </td>
                                <td valign="top">
                                    <span class="small">Eintrag ist:</span>
                                </td>
                                <td valign="top"></td>
                            </tr>
                            <tr align="left" valign="top">
                                <td class="config" valign="top">
                                    <input class="text" size="25" name="title" maxlength="100" value="'.$_POST['title'].'">
                                </td>
                                <td class="config" valign="top">
                                    <select name="entry_is" size="1">
                                        <option value="0" '.getselected($_POST['entry_is'], 0).'>'.$FD->text('admin', 'please_select').'</option>
                                        <option value="0">----------</option>
                                        <option value="1" '.getselected($_POST['entry_is'], 1).'>Spiel</option>
                                        <option value="2" '.getselected($_POST['entry_is'], 2).'>Kategorie</option>
                                        <option value="3" '.getselected($_POST['entry_is'], 3).'>Sprache</option>
                                    </select>
                                </td>
                                <td class="config" valign="top">
                                    <input type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                            <tr align="left" valign="top">
                                <td valign="top" colspan="4">
                                    <span class="small">Bild ausw&auml;hlen: (optional)</span>
                                </td>
                            </tr>
                            <tr align="left" valign="top">
                                <td class="config" valign="top" colspan="4">
                                    <input class="text" size="20" name="entry_pic" type="file">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

    echo'<p></p>
                        <table class="content " cellpadding="3" cellspacing="0">
                            <tr><td colspan="4"><h3>Eintr&auml;ge bearbeiten</h3><hr></td></tr>
    ';

    for ($i=1;$i<=3;$i++)
    {
        $index = mysql_query('SELECT * FROM '.$FD->config('pref')."press_admin WHERE type='$i' ORDER BY type, title");
        if (mysql_num_rows($index) > 0)
        {
            switch ($i)
            {
                case 3:
                    $head = 'Sprachen';
                    break;
                case 2:
                    $head = 'Kategorien';
                    break;
                default:
                    $head = 'Spiele';
                    break;
            }

            echo'
                    <form action="" method="post">
                        <input type="hidden" value="press_admin" name="go">


                        <tbody class="select_list">
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td class="config">'.$head.':</td>
                                <td class="config">Titel</td>
                                <td class="config">Typ</td>
                                <td class="config" style="text-align:right;">Auswahl</td>
                            </tr>
            ';
            unset($head);
        }

        while ($entry_arr = mysql_fetch_assoc($index))
        {
            switch ($entry_arr['type'])
            {
                case 3:
                    $entry_arr['type_text'] = 'Sprache';
                    break;
                case 2:
                    $entry_arr['type_text'] = 'Kategorie';
                    break;
                default:
                    $entry_arr['type_text'] = 'Spiel';
                    break;
            }

            echo '
                            <tr class="thin select_entry">
                                <td>
            ';
            if (image_exists('images/press/', $entry_arr['type'].'_'.$entry_arr['id'])) {
                echo'<img src="'.image_url('images/press/', $entry_arr['type'].'_'.$entry_arr['id']).'" alt="">';
            }
            echo'
                                </td>
                                <td>'.$entry_arr['title'].'</td>
                                <td>'.$entry_arr['type_text'].'</td>
                                <td>
                                    <input class="select_box" type="checkbox" name="entry_id[]" value="'. $entry_arr['id'] .'">
                                </td>
                            </tr>
            ';
        }

        if (mysql_num_rows($index) > 0)
        {
            echo'
                            <tr>
                                <td class="config" colspan="4" style="text-align:right;">
                                   <select class="select_type" name="entry_action" size="1">
                                     <option class="select_one" value="edit">'.$FD->text("admin", "selection_edit").'</option>
                                     <option class="select_red select_one" value="delete">'.$FD->text("admin", "selection_delete").'</option>
                                   </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="buttontd" colspan="4">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text('admin', 'do_action_button_long').'
                                    </button>
                                </td>
                            </tr>                              
                        </tbody>
                    </form>
            ';

        }
    }
    echo '</table>';
}
?>
