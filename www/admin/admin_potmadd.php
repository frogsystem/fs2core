<?php

////////////////////////
//// Bild hochladen ////
////////////////////////

if (isset($_FILES['potmimg']))
{
    $_POST[title] = savesql($_POST[title]);
    mysql_query("INSERT INTO fs_potm (potm_title)
                 VALUES ('".$_POST[title]."');", $db);
    $index = mysql_query("SELECT potm_id FROM fs_potm WHERE potm_title = '".$_POST[title]."'", $db);
    $id = mysql_result($index, 0, "potm_id");

    $valid_pic = pic_upload($_FILES['potmimg'], "../images/potm/", $id, 800, 600, 100, 75);
    switch ($valid_pic)
    {
        case 0:
            systext("POTM wurde hinzugef¸gt<br>Weiteres Bild hochladen:<p>");
            break;
        case 1:
            mysql_query("DELETE FROM fs_potm WHERE potm_id = '$id'", $db);
            systext("Das Bild muss ein JPG oder GIF sein<p>");
            break;
        case 2:
            mysql_query("DELETE FROM fs_potm WHERE potm_id = '$id'", $db);
            systext("Das Bild ist zu groﬂ<p>");
            break;
    }
}

////////////////////////
/// Eingabeformular ////
////////////////////////

echo'
                    <form action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="potmadd" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild ausw‰hlen, dass hochgeladen werden soll</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="potmimg" size="33">
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
                                <td colspan="2">
                                    <input class="button" type="submit" value="Hinzuf¸gen">
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>