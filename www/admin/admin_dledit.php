<?php if (!defined('ACP_GO')) die('Unauthorized access!');

////////////////////////////////
//// Download aktualisieren ////
////////////////////////////////

if (isset($_POST['dledit']) && isset($_POST['title']) && isset($_POST['text']))
{
    settype ($_POST['editdlid'], 'integer');

    // Download löschen
    if (isset($_POST['deldl']))
    {
        $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."dl WHERE dl_id = '$_POST[editdlid]'");
        $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."dl_files WHERE dl_id = '$_POST[editdlid]'");
        image_delete('images/dl/', "$_POST[editdlid]_s");
        image_delete('images/dl/', $_POST['editdlid']);
        systext('Download wurde gel&ouml;scht');

        // Delete from Search Index
        require_once ( FS2_ROOT_PATH . 'includes/searchfunctions.php' );
        delete_search_index_for_one ( $_POST['editdlid'], 'dl' );
    }
    else
    {
        settype($_POST['catid'], 'integer');
        for($i=0; $i<count($_POST['fname']); $i++)
        {
            settype($_POST['fsize'][$i], 'integer');
            settype($_POST['fcount'][$i], 'integer');
            settype($_POST['fid'][$i], 'integer');
            $_POST['fmirror'][$i] = isset($_POST['fmirror'][$i]) ? 1 : 0;
        }

        // Neues Bild hochladen
        $FD->loadConfig('downloads');
        $admin_dl_config_arr = $FD->configObject('downloads')->getConfigArray();

        if ($_FILES['dlimg']['name'] != '')
        {
            $upload = upload_img($_FILES['dlimg'], 'images/downloads/', $_POST['editdlid'], 2*1024*1024, $admin_dl_config_arr['screen_x'], $admin_dl_config_arr['screen_y']);
            systext(upload_img_notice($upload));
            $thumb = create_thumb_from(image_url('images/downloads/',$_POST['editdlid'],FALSE, TRUE), $admin_dl_config_arr['thumb_x'], $admin_dl_config_arr['thumb_y']);
            systext(create_thumb_notice($thumb));
        }

        $dlopen = isset($_POST['dlopen']) ? 1 : 0;

        $stmt = $FD->sql()->conn()->prepare('UPDATE '.$FD->config('pref')."dl
                   SET cat_id       = '$_POST[catid]',
                       dl_name      = ?,
                       dl_text      = ?,
                       dl_autor     = ?,
                       dl_autor_url = ?,
                       dl_open      = '$dlopen',
                       dl_search_update = '".time()."'
                   WHERE dl_id = $_POST[editdlid]");
        $stmt->execute(array($_POST['title'],
                             $_POST['text'],
                             $_POST['autor'],
                             $_POST['autorurl']));

        // Update Search Index (or not)
        if ( $FD->config('cronjobs', 'search_index_update') === 1 ) {
            // Include searchfunctions.php
            require_once ( FS2_ROOT_PATH . 'includes/searchfunctions.php' );
            update_search_index ( 'dl' );
        }


        // Files  aktualisieren
        for ($i=0; $i<count($_POST['fname']); $i++)
        {
            if (isset($_POST['delf'][$i]) && $_POST['delf'][$i]!=0)
            {
                settype($_POST['delf'][$i], 'integer');
                $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref').'dl_files WHERE file_id = ' . $_POST['delf'][$i]);
            }
            else
            {
                if (!isset($_POST['fcount'][$i]))
                {
                    $_POST['fcount'][$i] = 0;
                }

                if ($_POST['fnew'][$i]==1 && $_POST['fname'][$i]!='')
                {
                    $stmt = $FD->sql()->conn()->prepare(
                                'INSERT INTO '.$FD->config('pref')."dl_files
                                    (dl_id, file_count, file_name, file_url, file_size, file_is_mirror)
                                 VALUES ('".$_POST['editdlid']."',
                                       '".$_POST['fcount'][$i]."',
                                       ?,
                                       ?,
                                       '".$_POST['fsize'][$i]."',
                                       '".$_POST['fmirror'][$i]."')");
                    $stmt->execute(array($_POST['fname'][$i], $_POST['furl'][$i]));
                }
                elseif ($_POST['fnew'][$i]==0)
                {
                    $stmt = $FD->sql()->conn()->prepare('UPDATE '.$FD->config('pref')."dl_files
                               SET file_count     = '".$_POST['fcount'][$i]."',
                                   file_name      = ?,
                                   file_url       = ?,
                                   file_size      = '".$_POST['fsize'][$i]."',
                                   file_is_mirror = '".$_POST['fmirror'][$i]."'
                               WHERE file_id = ".$_POST['fid'][$i]);
                    $stmt->execute(array($_POST['fname'][$i], $_POST['furl'][$i]));
                }
            }
        }
        systext('Download wurde aktualisiert');
    }
    unset($_POST);
}

////////////////////////////////
////// Download editieren //////
////////////////////////////////

if (isset($_POST['dlid']) || isset($_POST['optionsadd']))
{
    $_POST['dlid'] = $_POST['dlid'][0];
    if(isset($_POST['sended']) && !isset($_POST['files_add'])) {
        echo get_systext($FD->text('admin', 'changes_not_saved').'<br>'.$FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));
    }


    if (isset($_POST['tempid']))
    {
        $_POST['dlid'] = $_POST['tempid'];
    }
    settype($_POST['dlid'], 'integer');

    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."dl WHERE dl_id =  '$_POST[dlid]'");
    $row = $index->fetch(PDO::FETCH_ASSOC);
    if (!isset($_POST['title']))
    {
        $_POST['title'] = $row['dl_name'];
    }
    if (!isset($_POST['catid']))
    {
        $_POST['catid'] = $row['cat_id'];
    }
    if (!isset($_POST['text']))
    {
        $_POST['text'] = $row['dl_text'];
    }
    if (!isset($_POST['autor']))
    {
        $_POST['autor'] = $row['dl_autor'];
    }
    if (!isset($_POST['autorurl']))
    {
        $_POST['autorurl'] = $row['dl_autor_url'];
    }
    if (!isset($_POST['dlopen']))
    {
        $_POST['dlopen'] = $row['dl_open'];
    }

    $_POST['dlopen'] = ($_POST['dlopen'] == 1) ? 'checked' : '';

    $index = $FD->sql()->conn()->query('SELECT COUNT(*) FROM '.$FD->config('pref')."dl_files WHERE dl_id = '$_POST[dlid]'");
    $rows = $index->fetchColumn();
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."dl_files WHERE dl_id = '$_POST[dlid]' ORDER BY file_id");
    for($i=0; $i<$rows; $i++)
    {
        $row = $index->fetch(PDO::FETCH_ASSOC);
        if (!isset($_POST['fname'][$i]))
        {
            $_POST['fname'][$i] = $row['file_name'];
        }
        if (!isset($_POST['fid'][$i]))
        {
            $_POST['fid'][$i] = $row['file_id'];
        }
        if (!isset($_POST['fcount'][$i]))
        {
            $_POST['fcount'][$i] = $row['file_count'];
        }
        if (!isset($_POST['furl'][$i]))
        {
            $_POST['furl'][$i] = $row['file_url'];
        }
        if (!isset($_POST['fsize'][$i]))
        {
            $_POST['fsize'][$i] = $row['file_size'];
        }
        if (!isset($_POST['fnew'][$i]))
        {
            $_POST['fnew'][$i] = 0;
        }
        $_POST['fmirror'][$i] = $row['file_is_mirror'];
    }

    if (!isset($_POST['options']))
    {
        $_POST['options'] = count($_POST['fname']);
    }
    $_POST['options'] += isset($_POST['optionsadd']) ? $_POST['optionsadd'] : 0;

    $FD->loadConfig('downloads');
    $admin_dl_config_arr = $FD->configObject('downloads')->getConfigArray();

    echo'
                    <form id="form" action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="go" value="dl_edit">
                        <input type="hidden" name="sended" value="edit">
                        <input id="send" type="hidden" value="0" name="dledit">
                        <input type="hidden" value="'.$_POST['dlid'].'" name="tempid">
                        <input type="hidden" value="'.$_POST['options'].'" name="options">
                        <input type="hidden" value="'.$_POST['dlid'].'" name="editdlid">
                        <input type="hidden" value="'.$_POST['dlid'].'" name="dlid[0]">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Download bearbeiten</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top" width="40%">
                                    Kategorie:<br>
                                    <font class="small">Der Download geh&ouml;rt zur Kategorie</font>
                                </td>
                                <td class="config" width="60%" valign="top">
                                    <select name="catid">
    ';
    // Kategorien auflisten
    $valid_ids = array();
    get_dl_categories ($valid_ids, -1);

    foreach ($valid_ids as $cat)
    {
        $sele = ($_POST['catid'] == $cat['cat_id']) ? 'selected' : '';
        echo'
                                        <option value="'.$cat['cat_id'].'" '.$sele.'>'.str_repeat('&nbsp;&nbsp;&nbsp;', $cat['level']).$cat['cat_name'].'</option>
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
                                    <input class="text" size="53" name="title" value="'.killhtml($_POST['title']).'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Beschreibung:<br>
                                    <font class="small">Diese Beschreibung erscheint unter dem Download</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor('text', killhtml($_POST['text']), 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Autor: <span class="small">(optional)</span><br>
                                    <font class="small">[Name des Autors]<br />
                                    [Homepage des Autors]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="autor" value="'.killhtml($_POST['autor']).'" maxlength="100">
                                    <br />
                                    <input class="text" size="30" name="autorurl" value="'.killhtml($_POST['autorurl']).'" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Screenshot: <font class="small">(optional)</font><br>
                                    <font class="small">Nur angeben wenn ein neues Bild erzeugt werden soll.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="dlimg" size="35"><br />
                                    <font class="small">[max. '.$admin_dl_config_arr['screen_x'].'x'.$admin_dl_config_arr['screen_y'].'] [2MB] [jpg/gif/png]</font>
                                </td>
                            </tr>
    ';
    $index = $FD->sql()->conn()->query('SELECT `ftp_id` FROM '.$FD->config('pref')."ftp WHERE `ftp_type` = 'dl' LIMIT 0,1");
    $ftp = ($index !== FALSE && $index->fetch(PDO::FETCH_ASSOC) !== FALSE);

    // Mirrors auflisten
    for ($i=1; $i<=$_POST['options']; $i++)
    {
        $j = $i - 1;
        if ($_POST['fname'][$j] OR $_POST['furl'][$j] OR $_POST['fsize'][$j] OR isset($fmirror[$j]))
        {
            if ($_POST['fmirror'][$j] == 1)
               $f_checked='checked="checked"';
            else
               $f_checked='';


            echo'
                            <tr>
                                <td class="config" valign="top">
                                    File '.$i.':<br>
                                    <font class="small">[Titel]<br>[URL]<br>[Gr&ouml;&szlig;e in KB]<br>[Anzahl der DLs]<br>[Mirror?]<br>[l&ouml;schen]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="fname['.$j.']" value="'.killhtml($_POST['fname'][$j]).'" maxlength="100"><br />
                                    <input class="text" size="70" value="'.killhtml($_POST['furl'][$j]).'" name="furl['.$j.']" maxlength="255" id="furl'.$j.'"><br>
            ';
            if ($ftp) {
                echo '
                                    <input  type="button" onClick=\''.openpopup ( '?go=find_file&amp;id='.$j, 600, 800 ).'\' value="'.$FD->text('admin', 'file_select_button').'">&nbsp;
                ';
            }
            echo '
                                    <input  type="button" onClick=\'document.getElementById("furl'.$j.'").value="'.$admin_dl_config_arr['quickinsert'].'";\' value="Quick-Insert Pfad"><br>
                                    <input class="text" size="30" value="'.killhtml($_POST['fsize'][$j]).'" name="fsize['.$j.']" maxlength="8" id="fsize'.$j.'"> KB<br />
                                    <input class="text" size="30" value="'.$_POST['fcount'][$j].'" name="fcount['.$j.']" maxlength="100"> Downloads<br />
                                    Ja, Mirror: <input type="checkbox" name="fmirror['.$j.']" '.$f_checked.'><br />
                                    L&ouml;schen: <input name="delf['.$j.']" id="delf['.$j.']" value="'.$_POST['fid'][$j].'" type="checkbox"
                                    onClick=\'delalert ("delf['.$j.']", "Soll das File (Nr. '.$i.') wirklich gelöscht werden?")\'>
                                    <input type="hidden" name="fid['.$j.']" value="'.$_POST['fid'][$j].'">
                                    <input type="hidden" name="fnew['.$j.']" value="'.$_POST['fnew'][$j].'">
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
                                    <font class="small">[Titel]<br />[URL]<br />[Gr&ouml;&szlig;e in KB]<br />[Anzahl der DLs]<br />[Mirror?]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="fname['.$j.']" maxlength="100"><br />
                                    <input class="text" size="70" name="furl['.$j.']" maxlength="255" id="furl'.$j.'"><br>
            ';
            if ($ftp) {
                echo '
                                    <input  type="button" onClick=\''.openpopup ( '?go=find_file&amp;id='.$j, 600, 800 ).'\' value="'.$FD->text('admin', 'file_select_button').'">&nbsp;
                ';
            }
            echo '
                                    <input  type="button" onClick=\'document.getElementById("furl'.$j.'").value="'.$admin_dl_config_arr['quickinsert'].'";\' value="Quick-Insert Pfad"><br>
                                    <input class="text" size="30" name="fsize['.$j.']" maxlength="8" id="fsize'.$j.'"> KB<br />
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
                                    <input name="files_add"  type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Download ver&ouml;ffentlichen:<br>
                                    <font class="small">Aktiviert den Download</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="dlopen" '.$_POST['dlopen'].'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Download l&ouml;schen:
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
          <table border="0" cellpadding="4" cellspacing="0" width="600" class="content">
              <tr>
                  <td class="config" colspan="4" valign="top">
                      <br><br><h3>Kommentare</h3>
                      <hr>
                  </td>
              </tr>
              ';
    $comments = mysql_query('SELECT * FROM `'.$FD->config('pref').'comments` WHERE content_type=\'dl\' AND content_id=\''.$_POST['dlid']."'", $FD->sql()->conn());
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
                <td class="configthin small">'.htmlentities($row['comment_title']).'</td>
                <td class="configthin small">';
        if ($row['comment_poster_id']!=0)
        {
          $user = mysql_query('SELECT user_id, user_name FROM `'.$FD->config('pref').'user` WHERE user_id=\''.$row['comment_poster_id']."' LIMIT 1", $FD->sql()->conn());
          $user = mysql_fetch_assoc($user);
          $row['comment_poster'] = $user['user_name'];
        }
        echo $row['comment_poster'].'</td>
                  <td class="configthin small">'.date('d.m.Y, H:i', $row['comment_date']).'</td>
                  <td class="configthin small"><input type="radio" value="'.$row['comment_id'].'" name="commentid">
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
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Filter</h3><hr></td></tr>
                            <tr>
                                <td class="thin">
                                    Nur Dateien der Kategorie
                                    <select name="dlcatid" class="third">
    ';

    echo'
                                        <option value="0">Alle Kategorien</option>
                                        <option value="0">--------------------------------------</option>
    ';

    $valid_ids = array();
    get_dl_categories ($valid_ids, -1);
    if (!isset($_POST['dlcatid']))
        $_POST['dlcatid'] = null;

    foreach ($valid_ids as $cat)
    {
        $sele = ($_POST['dlcatid'] == $cat['cat_id']) ? 'selected' : '';
        echo'
                                        <option value="'.$cat['cat_id'].'" '.$sele.'>'.str_repeat('&nbsp;&nbsp;&nbsp;', $cat['level']).$cat['cat_name'].'</option>
        ';
    }

    echo'
                                    </select>
                                    <input type="submit" value="anzeigen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

    echo'<p>&nbsp;</p>
                    <form action="" method="post">
                        <input type="hidden" value="dl_edit" name="go">
                        <table class="content select_list" cellpadding="3" cellspacing="0">
                            <tr><td colspan="3"><h3>Download ausw&auml;hlen</h3><hr></td></tr>
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
    $wherecat = '';
    if (isset($_POST['dlcatid']) && $_POST['dlcatid'] != 0)
    {
        settype($_POST['dlcatid'], 'integer');
        $wherecat = 'WHERE cat_id = ' . $_POST['dlcatid'];
    }
    $index = $FD->sql()->conn()->query('SELECT dl_id, dl_name, cat_id FROM '.$FD->config('pref')."dl $wherecat ORDER BY dl_name");
    while ($dl_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        $catindex = $FD->sql()->conn()->query('SELECT cat_name FROM '.$FD->config('pref')."dl_cat WHERE cat_id = '$dl_arr[cat_id]'");
        $dbcatname = $catindex->fetchColumn();
        echo'
                            <tr class="thin select_entry">
                                <td class="configthin">
                                    '.$dl_arr['dl_name'].'
                                </td>
                                <td class="configthin">
                                    '.$dbcatname.'
                                </td>
                                <td class="top center">
                                    <input class="select_box" type="checkbox" name="dlid[]" value="'.$dl_arr['dl_id'].'">
                                </td>
                            </tr>
        ';
    }

    echo'
                            <tr style="display:none">
                                <td colspan="3">
                                    <select class="select_type" name="dl_action" size="1">
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
