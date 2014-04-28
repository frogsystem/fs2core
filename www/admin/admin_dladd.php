<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//////////////////////
//// Add Download ////
//////////////////////

if (isset($_POST['dladd']) && isset($_POST['title']) && isset($_POST['text']))
{
    settype ($_POST['catid'], 'integer');
    settype ($_POST['userid'], 'integer');

    for ($i=0; $i<count($_POST['fname']); $i++)
    {
        settype ($_POST['fsize'][$i], 'integer');
        $_POST['fmirror'][$i] = isset($_POST['fmirror'][$i]) ? 1 : 0;
    }

    $_POST['dlopen'] = isset($_POST['dlopen']) ? 1 : 0;
    $dldate = time();

    // Insert Download
    $stmt = $FD->sql()->conn()->prepare(
                'INSERT INTO '.$FD->config('pref')."dl (cat_id, user_id, dl_date, dl_name, dl_text, dl_autor,
                    dl_autor_url, dl_open, dl_search_update)
                 VALUES ('".$_POST['catid']."',
                         '".$_POST['userid']."',
                         '$dldate',
                         ?,
                         ?,
                         ?,
                         ?,
                         '".$_POST['dlopen']."',
                         '".time()."')");
    $stmt->execute(array($_POST['title'], $_POST['text'], $_POST['autor'], $_POST['autorurl']));

    $id = $FD->sql()->conn()->lastInsertId();

    // Update Search Index (or not)
    if ( $FD->config('cronjobs', 'search_index_update') === 1 ) {
        // Include searchfunctions.php
        require ( FS2_ROOT_PATH . 'includes/searchfunctions.php' );
        update_search_index ( 'dl' );
    }

    // process and upload image
    $FD->loadConfig('downloads');
    $admin_dl_config_arr = $FD->configObject('downloads')->getConfigArray();

    if ($_FILES['dlimg']['name'] != '')
    {
        $upload = upload_img($_FILES['dlimg'], 'images/downloads/', $id, 2*1024*1024, $admin_dl_config_arr['screen_x'], $admin_dl_config_arr['screen_y']);
        systext(upload_img_notice($upload));
        $thumb = create_thumb_from(image_url('images/downloads/',$id,FALSE, TRUE), $admin_dl_config_arr['thumb_x'],  $admin_dl_config_arr['thumb_y']);
        systext(create_thumb_notice($thumb));
    }

    // Insert Files
    $stmt = $FD->sql()->conn()->prepare(
                    'INSERT INTO '.$FD->config('pref')."dl_files (dl_id, file_name, file_url, file_size, file_is_mirror)
                     VALUES ('$id',
                             ?,
                             ?,
                             ?,
                             ?)");
    for ($i=0; $i<count($_POST['fname']); $i++)
    {
        if ($_POST['fname'][$i] != '' AND $_POST['furl'][$i] != '' AND $_POST['fsize'][$i] != '')
        {
            $stmt->execute(array(
                               $_POST['fname'][$i],
                               $_POST['furl'][$i],
                               $_POST['fsize'][$i],
                               $_POST['fmirror'][$i]));
        }
    }
    systext('Download wurde hinzugef&uuml;gt');

    unset($_POST);
}

/////////////////////////
///// Download Form /////
/////////////////////////

if(true)
{
    if(isset($_POST['sended']) && !isset($_POST['files_add'])) {
        echo get_systext($FD->text("admin", "changes_not_saved").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_save_error"));
    }

    if (!isset($_POST['options']))
    {
        $_POST['options'] = 1;
    }
    if (!isset($_POST['optionsadd'])) $_POST['optionsadd'] = 0;
    $_POST['options'] = $_POST['options'] + $_POST['optionsadd'];
    $_POST = $_POST+array_fill_keys(array('title', 'text', 'autor', 'autorurl'), null);

    $FD->loadConfig('downloads');
    $admin_dl_config_arr = $FD->configObject('downloads')->getConfigArray();

    echo'
                    <form id="form" action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="dl_add" name="go">
                        <input type="hidden" value="add" name="sended">
                        <input id="send" type="hidden" value="0" name="dladd">
                        <input type="hidden" value="'.$_POST['options'].'" name="options">
                        <input type="hidden" value="'.$_SESSION['user_id'].'" name="userid">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Download hinzuf&uuml;gen</h3><hr></td></tr>

                            <tr>
                                <td class="config" valign="top" width="40%">
                                    Kategorie:<br>
                                    <font class="small">Die News geh&ouml;rt zur Kategorie</font>
                                </td>
                                <td class="config" width="60%" valign="top">
                                    <select name="catid">
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
                                <td class="config" valign="top">
                                    Downloadname:<br>
                                    <font class="small">unter welchem Namen soll der Download erscheinen</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="53" value="'.killhtml($_POST['title']).'" name="title" maxlength="100">
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
                                    Autor:<span class="small">(optional)</span><br>
                                    <font class="small">[Autor der Datei]<br />
                                    [Homepage des Autors]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="autor" value="'.killhtml($_POST['autor']).'" maxlength="100">
                                    <br />
                                    <input class="text" size="30" value="'.killhtml($_POST['autorurl']).'" name="autorurl" maxlength="255" id="test">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Screenshot: <font class="small">(optional)</font><br>
                                    <font class="small">Dient als Vorschau f&uuml;r den Download.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="dlimg" size="35"><br />
                                    <font class="small">[max. '.$admin_dl_config_arr['screen_x'].'x'.$admin_dl_config_arr['screen_y'].'] [2MB] [jpg/gif/png] (optional)</font>
                                </td>
                            </tr>
    ';
    $index = $FD->sql()->conn()->query('SELECT `ftp_id` FROM '.$FD->config('pref')."ftp WHERE `ftp_type` = 'dl' LIMIT 0,1");
    $ftp = ($index !== FALSE && $index->fetch(PDO::FETCH_ASSOC) !== FALSE);

    for ($i=1; $i<=$_POST['options']; $i++)
    {
        $j = $i - 1;
        if (isset($_POST['fname'][$j]) OR isset($_POST['furl'][$j]) OR isset($_POST['fsize'][$j]) OR isset($fmirror[$j]))
        {
            if (isset($fmirror[$j]))
               $f_checked='checked="checked"';
            else
               $f_checked='';

            echo'
                            <tr>
                                <td class="config" valign="top">
                                    File '.$i.':<br>
                                    <font class="small">[Titel]<br />[URL]<br />[Gr&ouml;&szlig;e in KB]<br />[Mirror?]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="fname['.$j.']" value="'.killhtml($_POST['fname'][$j]).'" maxlength="100"><br />
                                    <input class="text" size="70" value="'.killhtml($_POST['furl'][$j]).'" name="furl['.$j.']" maxlength="255" id="furl'.$j.'"><br>
            ';
            if ($ftp) {
                echo '
                                    <input  type="button" onClick=\''.openpopup ( '?go=find_file&amp;id='.$j, 600, 800 ).'\' value="'.$FD->text("admin", "file_select_button").'">&nbsp;
                ';
            }
            echo '
                                    <input  type="button" onClick=\'document.getElementById("furl'.$j.'").value="'.$admin_dl_config_arr['quickinsert'].'";\' value="Quick-Insert Pfad"><br>
                                    <input class="text" size="30" value="'.killhtml($_POST['fsize'][$j]).'" name="fsize['.$j.']" maxlength="8" id="fsize'.$j.'"> KB<br />
                                    Ja, Mirror: <input type="checkbox" name="fmirror['.$j.'] '.$f_checked.'">
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
                                    <font class="small">[Titel]<br />[URL]<br />[Gr&ouml;&szlig;e in KB]<br />[Mirror?]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="fname['.$j.']" maxlength="100"><br />
                                    <input class="text" size="70" name="furl['.$j.']" maxlength="255" id="furl'.$j.'"><br>
            ';
            if ($ftp) {
                echo '
                                    <input  type="button" onClick=\''.openpopup ( '?go=find_file&amp;id='.$j, 600, 800 ).'\' value="'.$FD->text("admin", "file_select_button").'">&nbsp;
                ';
            }
            echo '
                                    <input  type="button" onClick=\'document.getElementById("furl'.$j.'").value="'.$admin_dl_config_arr['quickinsert'].'";\' value="Quick-Insert Pfad"><br>
                                    <input class="text" size="30" name="fsize['.$j.']" maxlength="8" id="fsize'.$j.'"> KB<br />
                                    Ja, Mirror: <input type="checkbox" name="fmirror['.$j.']">
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
                                    <input name="files_add" type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Download ver&ouml;ffentlichen:<br>
                                    <font class="small">Aktiviert den Download</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" name="dlopen" checked>
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
}
?>
