<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST[screenx] && $_POST[screeny] && $_POST[thumbx] && $_POST[thumby] && $_POST[max_size])
{
    settype($_POST[screenx], 'integer');
    settype($_POST[screeny], 'integer');
    settype($_POST[thumbx], 'integer');
    settype($_POST[thumby], 'integer');
    settype($_POST[max_size], 'integer');
    $update = "UPDATE fs_screen_config
               SET screen_x = '$_POST[screenx]',
                   screen_y = '$_POST[screeny]',
                   thumb_x = '$_POST[thumbx]',
                   thumb_y = '$_POST[thumby]',
                   max_size = '$_POST[max_size]'";
    mysql_query($update, $db);
    systext("Die Konfiguration wurde aktualisiert");
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query("SELECT * FROM fs_screen_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="screenconfig" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="70%">
                                    Max Bildgröße:<br>
                                    <font class="small">Stellt die maximale Größe ein, bis zu den Bilder hochgeladen werden können</font>
                                </td>
                                <td class="config" valign="top" width="30%">
                                    <input class="text" size="5" name="screenx" value="'.$config_arr[screen_x].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="screeny" value="'.$config_arr[screen_y].'" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Vorschaugröße:<br>
                                    <font class="small">Gibt die Größe der Thumbnails an</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="thumbx" value="'.$config_arr[thumb_x].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="thumby" value="'.$config_arr[thumb_y].'" maxlength="3">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Max. Dateigröße:<br>
                                    <font class="small">Gibt die max. Dateigröße an, bis zu den Bilder hochgeladen werden können</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="12" name="max_size" value="'.$config_arr[max_size].'" maxlength="7"> KB
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>