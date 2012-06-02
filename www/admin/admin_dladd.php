<?php

/////////////////////////////
//// Download hinzufügen ////
/////////////////////////////

if ($_POST['dladd'] && $_POST['title'] && $_POST['text'])
{
    $_POST['title'] = savesql($_POST['title']);
    $_POST['text'] = savesql($_POST['text']);
    $_POST['autor'] = savesql($_POST['autor']);
    $_POST['autorurl'] = savesql($_POST['autorurl']);
    settype ($_POST['catid'], 'integer');
    settype ($_POST['userid'], 'integer');

    for ($i=0; $i<count($_POST['fname']); $i++)
    {
        $_POST['fname'][$i] = savesql($_POST['fname'][$i]);
        $_POST['furl'][$i] = savesql($_POST['furl'][$i]);
        settype ($_POST['fsize'][$i], 'integer');
        $_POST['fmirror'][$i] = isset($_POST['fmirror'][$i]) ? 1 : 0;
    }

    $_POST['dlopen'] = isset($_POST['dlopen']) ? 1 : 0;
    $dldate = time();

    // Download eintragen
    mysql_query('INSERT INTO '.$global_config_arr['pref']."dl (cat_id, user_id, dl_date, dl_name, dl_text, dl_autor,
                                    dl_autor_url, dl_open, dl_search_update)
                 VALUES ('".$_POST['catid']."',
                         '".$_POST['userid']."',
                         '$dldate',
                         '".$_POST['title']."',
                         '".$_POST['text']."',
                         '".$_POST['autor']."',
                         '".$_POST['autorurl']."',
                         '".$_POST['dlopen']."',
                         '".time()."')
    ", $FD->sql()->conn() );
    
    // Update Search Index (or not)
    if ( $global_config_arr['search_index_update'] === 1 ) {
        // Include searchfunctions.php
        require ( FS2_ROOT_PATH . 'includes/searchfunctions.php' );
        update_search_index ( 'dl' );
    }

    $id = mysql_insert_id();

    // Bild auswerten und hochladen
    $index = mysql_query('select * from '.$global_config_arr['pref'].'dl_config', $FD->sql()->conn() );
    $admin_dl_config_arr = mysql_fetch_assoc($index);
    
    if ($_FILES['dlimg']['name'] != '')
    {
        $upload = upload_img($_FILES['dlimg'], 'images/downloads/', $id, 2*1024*1024, $admin_dl_config_arr['screen_x'], $admin_dl_config_arr['screen_y']);
        systext(upload_img_notice($upload));
        $thumb = create_thumb_from(image_url('images/downloads/',$id,FALSE, TRUE), $admin_dl_config_arr['thumb_x'],  $admin_dl_config_arr['thumb_y']);
        systext(create_thumb_notice($thumb));
    }

    // Files eintragen
    for ($i=0; $i<count($_POST['fname']); $i++)
    {
        if ($_POST[fname][$i] != '' AND $_POST['furl'][$i] != '' AND $_POST['fsize'][$i] != '')
        {
            mysql_query('INSERT INTO '.$global_config_arr['pref']."dl_files (dl_id, file_name, file_url, file_size, file_is_mirror)
                         VALUES ('$id',
                                 '".$_POST['fname'][$i]."',
                                 '".$_POST['furl'][$i]."',
                                 '".$_POST['fsize'][$i]."',
                                 '".$_POST['fmirror'][$i]."');", $FD->sql()->conn() );
        }
    }
    systext('Download wurde hinzugef&uuml;gt');

    unset($_POST);
}

/////////////////////////////
///// Download Formular /////
/////////////////////////////

if(true)
{
    if(isset($_POST['sended']) && !isset($_POST['files_add'])) {
        echo get_systext($TEXT['admin']->get('changes_not_saved').'<br>'.$TEXT['admin']->get('form_not_filled'), $TEXT['admin']->get('error'), 'red', $TEXT['admin']->get('icon_save_error'));
    }

    if (!isset($_POST['options']))
    {
        $_POST['options'] = 1;
    }
    $_POST['options'] = $_POST['options'] + $_POST['optionsadd'];

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'dl_config', $FD->sql()->conn() );
    $admin_dl_config_arr = mysql_fetch_assoc($index);

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
    $index = mysql_query('SELECT `ftp_id` FROM '.$global_config_arr['pref']."ftp WHERE `ftp_type` = 'dl' LIMIT 0,1", $FD->sql()->conn() );
    $ftp = ($index !== FALSE && mysql_num_rows($index) == 1);  

    for ($i=1; $i<=$_POST['options']; $i++)
    {
        $j = $i - 1;
        if ($_POST['fname'][$j] OR $_POST['furl'][$j] OR $_POST['fsize'][$j] OR isset($fmirror[$j]))
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
                                    <input  type="button" onClick=\''.openpopup ( '?go=find_file&amp;id='.$j, 600, 800 ).'\' value="'.$TEXT['admin']->get('file_select_button').'">&nbsp;
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
                                    <input  type="button" onClick=\''.openpopup ( '?go=find_file&amp;id='.$j, 600, 800 ).'\' value="'.$TEXT['admin']->get('file_select_button').'">&nbsp;
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
