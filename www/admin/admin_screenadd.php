<?php
/////////////////////
//// Config laden ///
/////////////////////
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen_config");  // Screenshot Konfiguration auslesen
$config_arr = mysql_fetch_assoc($index);

/////////////////////////////
//// Screenshot hochladen ///
/////////////////////////////

if (isset($_FILES['screenimg']))
{


    settype($_POST[catid], 'integer');
    $_POST[title] = savesql($_POST[title]);
    mysql_query("INSERT INTO ".$global_config_arr[pref]."screen (cat_id, screen_name)
                 VALUES ('".$_POST[catid]."',
                         '".$_POST[title]."');", $db);
    $id = mysql_insert_id();
    
    $upload = upload_img($_FILES['screenimg'], "images/screenshots/", $id, $config_arr[screen_size]*1024, $config_arr[screen_x], $config_arr[screen_y]);
    systext(upload_img_notice($upload));
    switch ($upload)
    {
      case 0:
        break;
      default:
        mysql_query("DELETE FROM ".$global_config_arr[pref]."screen WHERE screen_id = '$id'");
        break;
    }
    $thumb = create_thumb_from(image_url("images/screenshots/", $id, FALSE, TRUE), $config_arr[screen_thumb_x], $config_arr[screen_thumb_y]);
    systext(create_thumb_notice($thumb));
}

/////////////////////////////
//// Screenshot Formular ////
/////////////////////////////

echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="screens_add" name="go">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild auswählen, dass hochgeladen werden soll</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="screenimg" size="33"><br />
                                    <font class="small">[max. '.$config_arr[screen_x].' x '.$config_arr[screen_y].' Pixel] [max. '.$config_arr[max_size].' KB]</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bildtitel: <font class="small">(optional)</font><br>
                                    <font class="small">Bilduntertitel</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="33" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kategorie:<br>
                                    <font class="small">In welche Kategorie soll der Screenshot eingeordnet werden</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="catid">
';
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen_cat WHERE cat_type = 1", $db);
while ($cat_arr = mysql_fetch_assoc($index))
{
    echo'
                                        <option value="'.$cat_arr[cat_id].'">
                                            '.$cat_arr[cat_name].'
                                        </option>
    ';
}
echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>