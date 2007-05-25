<?php

/////////////////////////////
//// Screenshot hochladen ///
/////////////////////////////

if (isset($_FILES['screenimg']))
{
    $index = mysql_query("SELECT * FROM fs_screen_config");  // Screenshot Konfiguration auslesen
    $db_screenx = mysql_result($index, 0, "screen_x");
    $db_screeny = mysql_result($index, 0, "screen_y");
    $db_thumbx = mysql_result($index, 0, "thumb_x");
    $db_thumby = mysql_result($index, 0, "thumb_y");
    $max_size = mysql_result($index, 0, "max_size");

    settype($_POST[catid], 'integer');
    $_POST[title] = savesql($_POST[title]);
    mysql_query("INSERT INTO fs_screen (cat_id, screen_name)
                 VALUES ('".$_POST[catid]."',
                         '".$_POST[title]."');", $db);
    $id = mysql_insert_id();
    
    $upload = upload_img($_FILES['screenimg'], "../images/screenshots/", $id, $max_size*1024, $db_screenx, $db_screeny, $db_thumbx, $db_thumby);
    systext(upload_img_notice($upload));
    switch ($upload)
    {
      case 0:
        break;
      case 1:
        mysql_query("DELETE FROM fs_screen WHERE screen_id = '$id'");
        break;
      case 2:
        mysql_query("DELETE FROM fs_screen WHERE screen_id = '$id'");
        break;
      case 3:
        mysql_query("DELETE FROM fs_screen WHERE screen_id = '$id'");
        break;
      case 4:
        mysql_query("DELETE FROM fs_screen WHERE screen_id = '$id'");
        break;
      case 5:
        mysql_query("DELETE FROM fs_screen WHERE screen_id = '$id'");
        image_delete("../images/screenshots/", $id);
        break;
  }
}

/////////////////////////////
//// Screenshot Formular ////
/////////////////////////////

echo'
                    <form action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="screenadd" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild auswählen, dass hochgeladen werden soll</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="screenimg" size="33">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bildtitel:<br>
                                    <font class="small">Bilduntertiel (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="33" maxlength="100">
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
$index = mysql_query("SELECT * FROM fs_screen_cat WHERE cat_type = 1", $db);
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