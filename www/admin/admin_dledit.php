<?php

////////////////////////////////
//// Download aktualisieren ////
////////////////////////////////

if ($_POST[dledit] && $_POST[title] && $_POST[text] && $_POST[fname][0] && $_POST[furl][0] && $_POST[fsize][0])
{
    settype ($_POST['editdlid'], 'integer');

    // Download löschen
    if (isset($_POST[deldl]))
    {
        mysql_query("DELETE FROM ".$global_config_arr[pref]."dl WHERE dl_id = '$_POST[editdlid]'", $db);
        mysql_query("DELETE FROM ".$global_config_arr[pref]."dl_files WHERE dl_id = '$_POST[editdlid]'", $db);
        image_delete("images/dl/", "$_POST[editdlid]_s");
        image_delete("images/dl/", $_POST[editdlid]);
        systext('Download wurde gelöscht');

        // Delete from Search Index
        require_once ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
        delete_search_index_for_one ( $_POST['editdlid'], "dl" );
    }
    else
    {
        $_POST[title] = savesql($_POST[title]);
        $_POST[text] = savesql($_POST[text]);
        $_POST[autor] = savesql($_POST[autor]);
        $_POST[autorurl] = savesql($_POST[autorurl]);
        for($i=0; $i<count($_POST[fname]); $i++)
        {
            $_POST[fname][$i] = savesql($_POST[fname][$i]);
            $_POST[furl][$i] = savesql($_POST[furl][$i]);
            settype($_POST[fsize][$i], 'integer');
            settype($_POST[fcount][$i], 'integer');
            settype($_POST[fid][$i], 'integer');
            $_POST[fmirror][$i] = isset($_POST[fmirror][$i]) ? 1 : 0;
        }

        // Neues Bild hochladen
        $index = mysql_query("select * from ".$global_config_arr[pref]."dl_config", $db);
        $admin_dl_config_arr = mysql_fetch_assoc($index);
        if ($_FILES[dlimg][name] != "")
        {
            $upload = upload_img($_FILES['dlimg'], "images/downloads/", $_POST['editdlid'], 2*1024*1024, $admin_dl_config_arr[screen_x], $admin_dl_config_arr[screen_y]);
            systext(upload_img_notice($upload));
            $thumb = create_thumb_from(image_url("images/downloads/",$_POST['editdlid'],FALSE, TRUE), $admin_dl_config_arr[thumb_x], $admin_dl_config_arr[thumb_y]);
            systext(create_thumb_notice($thumb));
        }

        $dlopen = isset($_POST[dlopen]) ? 1 : 0;

        $update = "UPDATE ".$global_config_arr[pref]."dl
                   SET cat_id       = '$_POST[catid]',
                       dl_name      = '$_POST[title]',
                       dl_text      = '$_POST[text]',
                       dl_autor     = '$_POST[autor]',
                       dl_autor_url = '$_POST[autorurl]',
                       dl_open      = '$_POST[dlopen]',
                       dl_search_update = '".time()."'
                   WHERE dl_id = $_POST[editdlid]";
        mysql_query($update, $db);

        // Update Search Index (or not)
        if ( $global_config_arr['search_index_update'] === 1 ) {
            // Include searchfunctions.php
            require_once ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
            update_search_index ( "dl" );
        }


        // Files  aktualisieren
        for ($i=0; $i<count($_POST[fname]); $i++)
        {
            if ($_POST[delf][$i])
            {
                settype($_POST[delf][$i], 'integer');
                mysql_query("DELETE FROM ".$global_config_arr[pref]."dl_files WHERE file_id = " . $_POST[delf][$i], $db);
            }
            else
            {
                if (!isset($_POST[fcount][$i]))
                {
                    $_POST[fcount][$i] = 0;
                }

                if ($_POST[fnew][$i]==1 && $_POST[fname][$i]!="")
                {
                    $insert = "INSERT INTO ".$global_config_arr[pref]."dl_files (dl_id, file_count, file_name, file_url, file_size, file_is_mirror)
                               VALUES ('".$_POST[editdlid]."',
                                       '".$_POST[fcount][$i]."',
                                       '".$_POST[fname][$i]."',
                                       '".$_POST[furl][$i]."',
                                       '".$_POST[fsize][$i]."',
                                       '".$_POST[fmirror][$i]."')";
                    mysql_query($insert, $db);

                }
                elseif ($_POST[fnew][$i]==0)
                {
                    $update = "UPDATE ".$global_config_arr[pref]."dl_files
                               SET file_count       = '".$_POST[fcount][$i]."',
                                   file_name        = '".$_POST[fname][$i]."',
                                   file_url         = '".$_POST[furl][$i]."',
                                   file_size        = '".$_POST[fsize][$i]."',
                                   file_is_mirror   = '".$_POST[fmirror][$i]."'
                               WHERE file_id = ".$_POST[fid][$i];
                    mysql_query($update, $db);
                }
            }
        }
        systext("Download wurde aktualisiert");
    }
}

////////////////////////////////
////// Download editieren //////
////////////////////////////////

elseif ($_POST[dlid] || $_POST[optionsadd])
{
    if (isset($_POST[tempid]))
    {
        $_POST[dlid] = $_POST[tempid];
    }
    settype($_POST[dlid], 'integer');

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."dl WHERE dl_id =  '$_POST[dlid]'", $db);
    if (!isset($_POST[title]))
    {
        $_POST[title] = mysql_result($index, 0, "dl_name");
    }
    if (!isset($_POST[catid]))
    {
        $_POST[catid] = mysql_result($index, 0, "cat_id");
    }
    if (!isset($_POST[text]))
    {
        $_POST[text] = mysql_result($index, 0, "dl_text");
    }
    if (!isset($_POST[autor]))
    {
        $_POST[autor] = mysql_result($index, 0, "dl_autor");
    }
    if (!isset($_POST[autorurl]))
    {
        $_POST[autorurl] = mysql_result($index, 0, "dl_autor_url");
    }
    if (!isset($_POST[dlopen]))
    {
        $_POST[dlopen] = mysql_result($index, 0, "dl_open");
    }

    $_POST[dlopen] = ($_POST[dlopen] == 1) ? "checked" : "";

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."dl_files WHERE dl_id = '$_POST[dlid]' ORDER BY file_id", $db);
    $rows = mysql_num_rows($index);
    for($i=0; $i<$rows; $i++)
    {
        if (!isset($_POST[fname][$i]))
        {
            $_POST[fname][$i] = mysql_result($index, $i, "file_name");
        }
        if (!isset($_POST[fid][$i]))
        {
            $_POST[fid][$i] = mysql_result($index, $i, "file_id");
        }
        if (!isset($_POST[fcount][$i]))
        {
            $_POST[fcount][$i] = mysql_result($index, $i, "file_count");
        }
        if (!isset($_POST[furl][$i]))
        {
            $_POST[furl][$i] = mysql_result($index, $i, "file_url");
        }
        if (!isset($_POST[fsize][$i]))
        {
            $_POST[fsize][$i] = mysql_result($index, $i, "file_size");
        }
        if (!isset($_POST[fnew][$i]))
        {
            $_POST[fnew][$i] = 0;
        }
        $_POST[fmirror][$i] = mysql_result($index, $i, "file_is_mirror");
    }

    if (!isset($_POST[options]))
    {
        $_POST[options] = count($_POST[fname]);
    }
    $_POST[options] += $_POST[optionsadd];

    $index = mysql_query("select * from ".$global_config_arr[pref]."dl_config", $db);
    $admin_dl_config_arr = mysql_fetch_assoc($index);

    echo'
                    <form id="form" action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="go" value="dl_edit">
                        <input id="send" type="hidden" value="0" name="dledit">
                        <input type="hidden" value="'.$_POST[dlid].'" name="tempid">
                        <input type="hidden" value="'.$_POST[options].'" name="options">
                        <input type="hidden" value="'.$_POST[dlid].'" name="editdlid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="40%">
                                    Kategorie:<br>
                                    <font class="small">Die News gehört zur Kategorie</font>
                                </td>
                                <td class="config" width="60%" valign="top">
                                    <select name="catid">
    ';
    // Kategorien auflisten
    $valid_ids = array();
    get_dl_categories (&$valid_ids, -1);

    foreach ($valid_ids as $cat)
    {
        $sele = ($_POST[catid] == $cat[cat_id]) ? "selected" : "";
        echo'
                                        <option value="'.$cat[cat_id].'" '.$sele.'>'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $cat[ebene]).$cat[cat_name].'</option>
        ';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Downloadname:<br>
                                    <font class="small">unter welchem Namen soll der Download erscheinen</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="53" name="title" value="'.killhtml($_POST[title]).'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Beschreibung:<br>
                                    <font class="small">Diese Beschreibung erscheint unter dem Download</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("text", killhtml($_POST[text]), 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Autor:<br>
                                    <font class="small">[Name des Autors]<br />
                                    [Homepage des Autors]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="autor" value="'.killhtml($_POST[autor]).'" maxlength="100">
                                    <br />
                                    <input class="text" size="30" name="autorurl" value="'.killhtml($_POST[autorurl]).'" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Screenshot: <font class="small">(optional)</font><br>
                                    <font class="small">Nur angeben wenn ein neues Bild erzeugt werden soll.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="dlimg" size="35"><br />
                                    <font class="small">[max. '.$admin_dl_config_arr[screen_x].'x'.$admin_dl_config_arr[screen_y].'] [2MB] [jpg/gif/png]</font>
                                </td>
                            </tr>
    ';

    // Mirros auflisten
    for ($i=1; $i<=$_POST[options]; $i++)
    {
        $j = $i - 1;
        if ($_POST[fname][$j] OR $_POST[furl][$j] OR $_POST[fsize][$j] OR isset($fmirror[$j]))
        {
            if ($_POST[fmirror][$j] == 1)
               $f_checked='checked="checked"';
            else
               $f_checked='';


            echo'
                            <tr>
                                <td class="config" valign="top">
                                    File '.$i.':<br>
                                    <font class="small">[Titel]<br>[URL]<br>[Große in KB]<br>[Anzahl der DLs]<br>[Mirror?]<br>[löschen]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="fname['.$j.']" value="'.killhtml($_POST[fname][$j]).'" maxlength="100"><br />
                                    <input class="text" size="30" value="'.killhtml($_POST[furl][$j]).'" name="furl['.$j.']" maxlength="255" id="furl'.$j.'">
                                    <input class="button" type="button" onClick=\'document.getElementById("furl'.$j.'").value="'.$admin_dl_config_arr[quickinsert].'";\' value="Quick-Insert Pfad"><br />
                                    <input class="text" size="30" value="'.killhtml($_POST[fsize][$j]).'" name="fsize['.$j.']" maxlength="8"> KB<br />
                                    <input class="text" size="30" value="'.$_POST[fcount][$j].'" name="fcount['.$j.']" maxlength="100"> Downloads<br />
                                    Ja, Mirror: <input type="checkbox" name="fmirror['.$j.'] '.$f_checked.'"><br />
                                    Löschen: <input name="delf['.$j.']" id="delf['.$j.']" value="'.$_POST[fid][$j].'" type="checkbox"
                                    onClick=\'delalert ("delf['.$j.']", "Soll das File (Nr. '.$i.') wirklich gelöscht werden?")\'>
                                    <input type="hidden" name="fid['.$j.']" value="'.$_POST[fid][$j].'">
                                    <input type="hidden" name="fnew['.$j.']" value="'.$_POST[fnew][$j].'">
                                </td>
                            </tr>
            ';
        }
        else
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    File '.$i.':<br>
                                    <font class="small">[Titel]<br />[URL]<br />[Große in KB]<br />[Anzahl der DLs]<br />[Mirror?]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="fname['.$j.']" maxlength="100"><br />
                                    <input class="text" size="30" name="furl['.$j.']" maxlength="255" id="furl'.$j.'">
                                    <input class="button" type="button" onClick=\'document.getElementById("furl'.$j.'").value="'.$admin_dl_config_arr[quickinsert].'";\' value="Quick-Insert Pfad"><br />
                                    <input class="text" size="30" name="fsize['.$j.']" maxlength="8"> KB<br />
                                    <input class="text" size="30" name="fcount['.$j.']" maxlength="100"> Downloads<br />
                                    Ja, Mirror: <input type="checkbox" name="fmirror['.$j.']">
                                    <input type="hidden" name="fnew['.$j.']" value="1">
                                </td>
                            </tr>
            ';
        }
    }

    echo'
                            <tr>
                                <td class="configthin">
                                    &nbsp;
                                </td>
                                <td class="configthin">
                                    <input size="2" class="text" name="optionsadd">
                                    Files
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Download veröffentlichen:<br>
                                    <font class="small">Aktiviert den Download</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="dlopen" '.$_POST[dlopen].'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Download löschen:
                                </td>
                                <td class="config">
                                    <input onClick=\'delalert ("deldl", "Soll der Download wirklich gelöscht werden?")\' type="checkbox" name="deldl" id="deldl" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="button" type="button" onClick="javascript:document.getElementById(\'send\').value=\'1\'; document.getElementById(\'form\').submit();" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
    
    //List of download comments
    echo '<form action="" method="post">
            <input type="hidden" name="go" value="dlcommentedit">
            <input type="hidden" name="PHPSESSID" value="'.session_id().'">
          <table border="0" cellpadding="4" cellspacing="0" width="600">
              <tr>
                  <td class="config" colspan="4" valign="top">
                      <br><br>Kommentare
                  </td>
              </tr>
              ';
    $comments = mysql_query('SELECT * FROM `'.$global_config_arr['pref'].'comments` WHERE content_type=\'dl\' AND content_id=\''.$_POST['dlid']."'", $db);
    if (mysql_num_rows($comments)===0)
    {
      echo '<tr>
              <td class="configthin" colspan="4" align="center">Keine Kommentare vorhanden!</td>
            </tr>';
    }
    else
    {
      echo '<tr>
                  <td class="config" width="30%" valign="top">Titel</td>
                  <td class="config" width="30%" valign="top">Poster</td>
                  <td class="config" width="25%" valign="top">Datum</td>
                  <td class="config" width="15%" valign="top">bearbeiten</td>
            </tr>';
      while ($row = mysql_fetch_assoc($comments))
      {
        echo '<tr>
                <td class="configthin">'.htmlentities($row['comment_title']).'</td>
                <td class="configthin">';
        if ($row['comment_poster_id']!=0)
        {
          $user = mysql_query('SELECT user_id, user_name FROM `'.$global_config_arr['pref'].'user` WHERE user_id=\''.$row['comment_poster_id']."' LIMIT 1", $db);
          $user = mysql_fetch_assoc($user);
          $row['comment_poster'] = $user['user_name'];
        }
        echo $row['comment_poster'].'</td>
                  <td class="configthin">'.date('d.m.Y, H:i', $row['comment_date']).'</td>
                  <td class="configthin"><input type="radio" value="'.$row['comment_id'].'" name="commentid">
              </tr>';
      }//while
      echo '<tr>
              <td colspan="4"> &nbsp; </td>
            </tr>
            <tr>
              <td align="center" colspan="4">
                <input class="button" type="submit" value="Editieren">
              </td>
            </tr>';
    }
    echo '</table>
         </form>';
}

////////////////////////////////
////// Download auswählen //////
////////////////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_edit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="40%">
                                    Nur dateien der Kategorie
                                    <select name="dlcatid">
    ';

    /*/ Kategorie Auswahl erzeugen
    $index = mysql_query("SELECT cat_id, cat_name FROM ".$global_config_arr[pref]."dl_cat", $db);
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        $sele = ($_POST[dlcatid] == $cat_arr[cat_id]) ? "selected" : "";
        echo'
                                        <option value="'.$cat_arr[cat_id].'" '.$sele.'>'.$cat_arr[cat_name].'</option>
        ';
    }  */

    $valid_ids = array();
    get_dl_categories (&$valid_ids, -1);

    foreach ($valid_ids as $cat)
    {
        $sele = ($_POST[dlcatid] == $cat[cat_id]) ? "selected" : "";
        echo'
                                        <option value="'.$cat[cat_id].'" '.$sele.'>'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $cat[ebene]).$cat[cat_name].'</option>
        ';
    }

    echo'
                                    </select>
                                    <input class="button" type="submit" value="Anzeigen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_edit" name="go">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="40%">
                                    Titel
                                </td>
                                <td class="config" width="40%">
                                    Kategorie
                                </td>
                                <td class="config" width="20%">
                                    bearbeiten
                                </td>
                            </tr>
    ';

    // Daten aus der DB lesen
    if (isset($_POST[dlcatid]))
    {
        settype($_POST[dlcatid], 'integer');
        $wherecat = "WHERE cat_id = " . $_POST[dlcatid];
    }
    $index = mysql_query("SELECT dl_id, dl_name, cat_id FROM ".$global_config_arr[pref]."dl $wherecat ORDER BY dl_name", $db);
    while ($dl_arr = mysql_fetch_assoc($index))
    {
        $catindex = mysql_query("SELECT cat_name from ".$global_config_arr[pref]."dl_cat WHERE cat_id = '$dl_arr[cat_id]'", $db);
        $dbcatname = mysql_result($catindex, 0, "cat_name");
        echo'
                            <tr>
                                <td class="configthin">
                                    '.$dl_arr[dl_name].'
                                </td>
                                <td class="configthin">
                                    '.$dbcatname.'
                                </td>
                                <td class="configthin">
                                    <input type="radio" name="dlid" value="'.$dl_arr[dl_id].'">
                                </td>
                            </tr>
        ';
    }

    echo'
                            <tr>
                                <td colspan="3">
                                    &nbsp;
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