<?php
////////////////////////////
//// Pressadmin add ////////
////////////////////////////
if ($_POST['entry_action'] == "add"
    && $_POST['entry_is']
    && ($_POST['title'] AND $_POST['title'] != "")
   )
{
    $_POST[title] = savesql($_POST[title]);
    settype($_POST[entry_is], 'integer');

    mysql_query("INSERT INTO ".$global_config_arr[pref]."press_admin
                 (type, title)
                 VALUES ('$_POST[entry_is]', '$_POST[title]')", $FD->sql()->conn() );
    $msg = array();
    $msg[] = 'Eintrag wurde hinzugefügt!';

    if ($_FILES['entry_pic']['name'] != "") {
        $id = mysql_insert_id();
        $upload = upload_img($_FILES['entry_pic'], "images/press/", $_POST[entry_is]."_".$id, 1024*1024, 999, 999);
        $msg[] = upload_img_notice($upload);
    } else {
        $msg[] = 'Es wurde kein Bild zum Upload ausgewählt.';
    }
    
    echo get_systext(implode("<br>", $msg), $TEXT['admin']->get("info"), "green", $TEXT['admin']->get("icon_save_add"));
}

////////////////////////////
//// Pressadmin edit ///////
////////////////////////////
elseif (($_POST['title'] AND $_POST['title'] != "")
    && $_POST['entry_action'] == "edit"
    && $_POST['sended'] == "edit"
    && isset($_POST['entry_id'][0])
   )
{
    $_POST['entry_id'] = $_POST['entry_id'][0];
    settype($_POST[entry_id], 'integer');
    settype($_POST[entry_is], 'integer');
    $_POST['title'] = savesql($_POST['title']);

    mysql_query("UPDATE ".$global_config_arr[pref]."press_admin
                 SET title = '$_POST[title]',
                     type = '$_POST[entry_is]'
                 WHERE id = '$_POST[entry_id]'", $FD->sql()->conn() );
    systext("Der Eintrag wurde aktualisiert!");
    
    if ($_POST['entry_pic_delete'] == 1)
    {
      if (image_delete("images/press/", $_POST[entry_is]."_".$_POST[entry_id]))
      {
        systext('Das Bild wurde erfolgreich gelöscht!');
      }
    }
    elseif ($_FILES['entry_pic']['name'] != "")
    {
        $upload = upload_img($_FILES['entry_pic'], "images/press/", $_POST[entry_is]."_".$_POST[entry_id], 1024*1024, 999, 999);
        systext(upload_img_notice($upload));
    }

    unset($_POST['entry_action']);
    unset($_POST['sended']);
    unset($_POST['entry_id']);
}

////////////////////////////
//// Pressadmin löschen ////
////////////////////////////
elseif ($_POST['entry_action'] == "delete"
    && $_POST['sended'] == "delete"
    && isset($_POST['entry_move_to'])
    && isset($_POST['entry_id'])
   )
{
    settype($_POST[entry_id], 'integer');
    settype($_POST[entry_is], 'integer');
    
    if ($_POST['delete_press_admin'])   // Partnerseite löschen
    {
        $index = mysql_query("SELECT type FROM ".$global_config_arr[pref]."press_admin WHERE id = '$_POST[entry_id]'", $FD->sql()->conn() );
        $entry_arr['type'] = mysql_result($index, 0, "type");

        switch ($entry_arr[type])
        {
            case 3:
                $entry_arr[type_set] = "SET press_lang = '$_POST[entry_move_to]'";
                $entry_arr[type_where] = "WHERE press_lang = '$_POST[entry_id]'";
                break;
            case 2:
                $entry_arr[type_set] = "SET press_cat = '$_POST[entry_move_to]'";
                $entry_arr[type_where] = "WHERE press_cat = '$_POST[entry_id]'";
                break;
            default:
                $entry_arr[type_set] = "SET press_game = '$_POST[entry_move_to]'";
                $entry_arr[type_where] = "WHERE press_game = '$_POST[entry_id]'";
                break;
        }
        
        mysql_query("UPDATE ".$global_config_arr[pref]."press"." ".$entry_arr[type_set]." ".$entry_arr[type_where], $FD->sql()->conn() );

        mysql_query("DELETE FROM ".$global_config_arr[pref]."press_admin
                     WHERE id = '$_POST[entry_id]'", $FD->sql()->conn() );

        $msg[] = "Der Eintrag wurde gelöscht!";

        if (image_delete("images/press/", $entry_arr[type]."_".$_POST[entry_id]))
        {
            $msg[] = 'Das Bild wurde erfolgreich gelöscht!';
        }
        
        echo get_systext(implode("<br>", $msg), $TEXT['admin']->get("info"), "green", $TEXT['admin']->get("icon_trash_ok"));

    }
    else
    {
        $msg[] = "Der Eintrag wurde nicht gelöscht!";
        echo get_systext(implode("<br>", $msg), $TEXT['admin']->get("info"), "green", $TEXT['admin']->get("icon_info"));        
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
elseif ($_POST['entry_action'] == "edit"
    && isset($_POST['entry_id'])
   )
{
    $_POST['entry_id'] = $_POST['entry_id'][0];
    settype($_POST[entry_id], 'integer');
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE id = $_POST[entry_id]", $FD->sql()->conn() );
    $entry_arr = mysql_fetch_assoc($index);

    $entry_arr['title'] = killhtml($entry_arr['title']);
    
    //Error Message
    if ($_POST['sended'] == "edit") {
        systext ($admin_phrases[common][note_notfilled]);

        $entry_arr['title'] = killhtml($_POST['title']);
        $entry_arr['type'] = $_POST['entry_is'];
        settype($entry_arr['type'], 'integer');
    }

    echo'
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="press_admin" name="go">
                        <input type="hidden" value="edit" name="entry_action">
                        <input type="hidden" value="edit" name="sended">
                        <input type="hidden" value="'.$entry_arr[id].'" name="entry_id[0]">
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

    if (image_exists("images/press/", $entry_arr[type]."_".$entry_arr[id]))
    {
        echo'<img src="'.image_url("images/press/", $entry_arr[type]."_".$entry_arr[id]).'" alt="" /><br /><br />';
    }

    echo'<input name="entry_pic" type="file" size="40" class="text" /><br />';
                                
    if (image_exists("images/press/", $entry_arr[type]."_".$entry_arr[id]))
    {
        echo'
                                    <font class="small">
                                        Nur auswählen, wenn das bisherige Bild überschrieben werden soll!
                                    </font><br /><br />
                                    <input style="cursor:pointer; vertical-align:middle;" type="checkbox" name="entry_pic_delete" id="epd" value="1" onClick=\'delalert ("epd", "Soll das Bild wirklich gelöscht werden?")\' />
                                    <font class="small"><b>Bild löschen?</b></font><br /><br />
        ';
    }
    
    echo'
                                </td>
                            </tr>
                            <tr align="left" valign="top">
                                <td class="config" colspan="2">
                                    <input type="submit" value="Änderungen Speichern" class="button">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

////////////////////////////
//// Pressadmin löschen ////
////////////////////////////
elseif ($_POST['entry_action'] == "delete"
    && isset($_POST['entry_id'])
   )
{
    $_POST['entry_id'] = $_POST['entry_id'][0];
    settype($_POST[entry_id], 'integer');
    $index = mysql_query("SELECT COUNT(id) AS number FROM ".$global_config_arr[pref]."press_admin
                          WHERE type = (SELECT type FROM ".$global_config_arr[pref]."press_admin WHERE id = $_POST[entry_id])", $FD->sql()->conn() );

    if (mysql_result($index,0,"number") > 1)
    {
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE id = $_POST[entry_id]", $FD->sql()->conn() );
        $entry_arr = mysql_fetch_assoc($index);

        $entry_arr['title'] = killhtml($entry_arr['title']);
        switch ($entry_arr[type])
        {
            case 3:
                $entry_arr[type_text] = "Sprache";
                break;
            case 2:
                $entry_arr[type_text] = "Kategorie";
                break;
            default:
                $entry_arr[type_text] = "Spiel";
                break;
        }

        echo'
                    <form action="" method="post">
                        <input type="hidden" value="press_admin" name="go">
                        <input type="hidden" value="delete" name="entry_action">
                        <input type="hidden" value="delete" name="sended">
                        <input type="hidden" value="'.$entry_arr[id].'" name="entry_id">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>'.$admin_phrases[press][delpage].': '.$entry_arr[type_text].'</h3><hr></td></tr>
                            
                            <tr align="left" valign="top">
                                <td class="config" colspan="2" style="padding:0px; margin:0px;">
                                    <table border="0" cellpadding="4" cellspacing="0" width="600">
                                        <tr valign="middle">
                                             <td class="configthin">
                                                 <b>Titel:</b><br />
                                                 '.$entry_arr[title].'
                                             </td>
                                             <td class="configthin">
                                                 <b>Typ:</b><br />
                                                 '.$entry_arr[type_text].'
                                             </td>
                                            <td class="configthin">
        ';
        if (image_exists("images/press/", $entry_arr[type]."_".$entry_arr[id])) {
            echo'<img src="'.image_url("images/press/", $entry_arr[type]."_".$entry_arr[id]).'" alt="" />';
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
                                    '.$admin_phrases[press][delpage_question].'
                                </td>
                                <td width="50%" align="right">
                                    <select name="delete_press_admin" size="1">
                                        <option value="0">'.$admin_phrases[press][delnotconfirm].'</option>
                                        <option value="1">'.$admin_phrases[press][delconfirm].'</option>
                                    </select>
                                    <input type="submit" value="'.$admin_phrases[common][do_button].'">
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr align="left" valign="top">
                                <td class="config">
                                    Pressberichte des gelöschten Eintrags verschieben nach:
                                </td>
                                <td align="right">
                                    <select name="entry_move_to" size="1" class="text">';

        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin
                              WHERE type = '$entry_arr[type]' AND id != '$entry_arr[id]'
                              ORDER BY title", $FD->sql()->conn() );
        while ($entry_move_arr = mysql_fetch_assoc($index))
        {
            echo'<option value="'.$entry_move_arr[id].'">'.$entry_move_arr[title].'</option>';
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
        $index = mysql_query("SELECT type FROM ".$global_config_arr[pref]."press_admin WHERE id = $_POST[entry_id]", $FD->sql()->conn() );
        $entry_arr[type] = mysql_result($index, 0, "type");

        switch ($entry_arr[type])
        {
            case 3:
                $entry_arr[type_text] = "Sprache";
                break;
            case 2:
                $entry_arr[type_text] = "Kategorie";
                break;
            default:
                $entry_arr[type_text] = "Spiel";
                break;
        }

        echo'
                    <form action="" method="post">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr valign="middle">
                                <td class="config">
                                    Der letzte Eintrag eines Typs kann nicht gelöscht werden.<br>
                                    Bitte zuerst einen neuen Eintrag des Typs „'.$entry_arr[type_text].'“ anlegen.
                                </td>
                                <td>
                                    <input class="button" type="submit" value="zurück zur Übersicht">
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
if (!isset($_POST[entry_id]))
{
    echo'
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="press_admin" name="go">
                        <input type="hidden" value="add" name="entry_action">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="4"><h3>Neuen Eintrag hinzufügen</h3><hr></td></tr>
                            <tr align="left" valign="top">
                                <td valign="top">
                                    <span class="small">Bild auswählen: (optional)</span>
                                </td>
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
                                    <input class="text" size="20" name="entry_pic" type="file" />
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="25" name="title" maxlength="100" value="" />
                                </td>
                                <td class="config" valign="top">
                                    <select name="entry_is" size="1">
                                        <option value="0" selected="selected">----------</option>
                                        <option value="1">Spiel</option>
                                        <option value="2">Kategorie</option>
                                        <option value="3">Sprache</option>
                                    </select>
                                </td>
                                <td class="config" valign="top">
                                    <input type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

    echo'<p></p>
                        <table class="content " cellpadding="3" cellspacing="0">
                            <tr><td colspan="4"><h3>Spiele bearbeiten</h3><hr></td></tr>
    ';

    for ($i=1;$i<=3;$i++)
    {
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin WHERE type='$i' ORDER BY type, title");
        if (mysql_num_rows($index) > 0)
        {
            switch ($i)
            {
                case 3:
                    $head = "Sprachen";
                    break;
                case 2:
                    $head = "Kategorien";
                    break;
                default:
                    $head = "Spiele";
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
            switch ($entry_arr[type])
            {
                case 3:
                    $entry_arr[type_text] = "Sprache";
                    break;
                case 2:
                    $entry_arr[type_text] = "Kategorie";
                    break;
                default:
                    $entry_arr[type_text] = "Spiel";
                    break;
            }

            echo '
                            <tr class="thin select_entry">
                                <td>
            ';
            if (image_exists("images/press/", $entry_arr[type]."_".$entry_arr[id])) {
                echo'<img src="'.image_url("images/press/", $entry_arr[type]."_".$entry_arr[id]).'" alt="">';
            }
            echo'
                                </td>
                                <td>'.$entry_arr[title].'</td>
                                <td>'.$entry_arr[type_text].'</td>
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
                                     <option class="select_one" value="edit">'.$admin_phrases[common][selection_edit].'</option>
                                     <option class="select_red select_one" value="delete">'.$admin_phrases[common][selection_del].'</option>
                                   </select>
                                   <input class="button" type="submit" value="'.$admin_phrases[common][do_button].'">
                                </td>
                            </tr>
                        </tbody>
                    </form>
            ';
        
        }
    }
    echo '</table>';
}
