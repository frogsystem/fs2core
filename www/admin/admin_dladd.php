<?php

/////////////////////////////
//// Download hinzufügen ////
/////////////////////////////

if ($_POST[dladd] && $_POST[title] && $_POST[text] && $_POST[fname][0] && $_POST[furl][0] && $_POST[fsize][0])
{
    $_POST[title] = savesql($_POST[title]);
    $_POST[text] = savesql($_POST[text]);
    $_POST[autor] = savesql($_POST[autor]);
    $_POST[autorurl] = savesql($_POST[autorurl]);
    settype ($_POST[catid], 'integer');
    settype ($_POST[userid], 'integer');

    for ($i=0; $i<count($_POST[fname]); $i++)
    {
        $_POST[fname][$i] = savesql($_POST[fname][$i]);
        $_POST[furl][$i] = savesql($_POST[furl][$i]);
        settype ($_POST[fsize][$i], 'integer');
        $_POST[fmirror][$i] = isset($_POST[fmirror][$i]) ? 1 : 0;
    }

    $_POST[dlopen] = isset($_POST[dlopen]) ? 1 : 0;
    $dldate = time();

    // Download eintragen
    mysql_query("INSERT INTO fs_dl (cat_id, user_id, dl_date, dl_name, dl_text, dl_autor,
                                    dl_autor_url, dl_open)
                 VALUES ('".$_POST[catid]."',
                         '".$_POST[userid]."',
                         '$dldate',
                         '".$_POST[title]."',
                         '".$_POST[text]."',
                         '".$_POST[autor]."',
                         '".$_POST[autorurl]."',
                         '".$_POST[dlopen]."');", $db);
                         
    $id = mysql_insert_id();
    
    // Bild auswerten und hochladen
    $index = mysql_query("select * from fs_dl_config", $db);
    $admin_dl_config_arr = mysql_fetch_assoc($index);
    
    if ($_FILES[dlimg] && ($_FILES[dlimg] != "none"))
    {
        $upload = upload_img($_FILES['dlimg'], "../images/downloads/", $id, 2*1024*1024, $admin_dl_config_arr[screen_x], $admin_dl_config_arr[screen_y]);
        systext(upload_img_notice($upload));
        $thumb = create_thumb_from(image_url("../images/downloads/",$id,false), $admin_dl_config_arr[thumb_x],  $admin_dl_config_arr[thumb_y]);
        systext(create_thumb_notice($thumb));
    }

    // Files eintragen
    for ($i=0; $i<count($_POST[fname]); $i++)
    {
        if ($_POST[fname][$i] != "" AND $_POST[furl][$i] != "" AND $_POST[fsize][$i] != "")
        {
            mysql_query("INSERT INTO fs_dl_files (dl_id, file_name, file_url, file_size, file_is_mirror)
                         VALUES ('$id',
                                 '".$_POST[fname][$i]."',
                                 '".$_POST[furl][$i]."',
                                 '".$_POST[fsize][$i]."',
                                 '".$_POST[fmirror][$i]."');", $db);
        }
    }
    systext("Download wurde hinzugefügt");
}

/////////////////////////////
///// Download Formular /////
/////////////////////////////

else
{
    if (!isset($_POST[options]))
    {
        $_POST[options] = 1;
    }
    $_POST[options] = $_POST[options] + $_POST[optionsadd];

    $index = mysql_query("select * from fs_dl_config", $db);
    $admin_dl_config_arr = mysql_fetch_assoc($index);

    echo'
                    <form id="form" action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="dladd" name="go">
                        <input id="send" type="hidden" value="0" name="dladd">
                        <input type="hidden" value="'.$_POST[options].'" name="options">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$_SESSION[user_id].'" name="userid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="40%">
                                    Kategorie:<br>
                                    <font class="small">Die News gehört zur Kategorie</font>
                                </td>
                                <td class="config" width="60%" valign="top">
                                    <select name="catid">
    ';
    $valid_ids = array();
    get_dl_categories (&$valid_ids, -1);

    foreach ($valid_ids as $cat)
    {
        echo'
                                        <option value="'.$cat[cat_id].'">'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $cat[ebene]).$cat[cat_name].'</option>
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
                                    <input class="text" size="53" value="'.$_POST[title].'" name="title" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Beschreibung:<br>
                                    <font class="small">Diese Beschreibung erscheint unter dem Download</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("text", $_POST[text], 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Autor:<br>
                                    <font class="small">[Autor der Datei]<br />
                                    [Homepage des Autors]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="autor" value="'.$_POST[autor].'" maxlength="100">
                                    <br />
                                    <input class="text" size="30" value="'.$_POST[autorurl].'" name="autorurl" maxlength="255" id="test">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Screenshot: <font class="small">(optional)</font><br>
                                    <font class="small">Dient als Vorschau für den Download.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="dlimg" size="35"><br />
                                    <font class="small">[max. '.$admin_dl_config_arr[screen_x].'x'.$admin_dl_config_arr[screen_y].'] [2MB] [jpg/gif/png] (optional)</font>
                                </td>
                            </tr>
    ';
    for ($i=1; $i<=$_POST[options]; $i++)
    {
        $j = $i - 1;
        if ($_POST[fname][$j] OR $_POST[furl][$j] OR $_POST[fsize][$j] OR isset($fmirror[$j]))
        {
            if (isset($fmirror[$j]))
               $f_checked='checked="checked"';
            else
               $f_checked='';

            echo'
                            <tr>
                                <td class="config" valign="top">
                                    File '.$i.':<br>
                                    <font class="small">[Titel]<br />[URL]<br />[Große in KB]<br />[Mirror?]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="fname['.$j.']" value="'.$_POST[fname][$j].'" maxlength="100"><br />
                                    <input class="text" size="30" value="'.$_POST[furl][$j].'" name="furl['.$j.']" maxlength="255" id="furl'.$j.'"><input class="button" type="button" onClick=\'document.getElementById("furl'.$j.'").value="'.$admin_dl_config_arr[quickinsert].'";\' value="Quick-Insert Pfad"><br />
                                    <input class="text" size="30" value="'.$_POST[fsize][$j].'" name="fsize['.$j.']" maxlength="8"> KB<br />
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
                                    <font class="small">[Titel]<br />[URL]<br />[Große in KB]<br />[Mirror?]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="20" name="fname['.$j.']" maxlength="100"><br />
                                    <input class="text" size="30" name="furl['.$j.']" maxlength="255" id="furl'.$j.'">
                                    <input class="button" type="button" onClick=\'document.getElementById("furl'.$j.'").value="'.$admin_dl_config_arr[quickinsert].'";\' value="Quick-Insert Pfad"><br />
                                    <input class="text" size="30" name="fsize['.$j.']" maxlength="8"> KB<br />
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
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Download veröffentlichen:<br>
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