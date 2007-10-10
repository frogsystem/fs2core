<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if (($_POST[screen_x] AND $_POST[screen_x] != "")
    && ($_POST[screen_y] AND $_POST[screen_y] != "")
    && ($_POST[screen_thumb_x] AND $_POST[screen_thumb_x] != "")
    && ($_POST[screen_thumb_y] AND $_POST[screen_thumb_y] != "")
    && ($_POST[screen_size] AND $_POST[screen_size] != "")
    && ($_POST[screen_rows] AND $_POST[screen_rows] != "" AND $_POST[screen_rows] != "0")
    && ($_POST[screen_cols] AND $_POST[screen_cols] != "" AND $_POST[screen_cols] != "0")
    && ($_POST[show_img_x] AND $_POST[show_img_x] != "")
    && ($_POST[show_img_y] AND $_POST[show_img_y] != "")
    
    && ($_POST[wp_x] AND $_POST[wp_x] != "")
    && ($_POST[wp_y] AND $_POST[wp_y] != "")
    && ($_POST[wp_thumb_x] AND $_POST[wp_thumb_x] != "")
    && ($_POST[wp_thumb_y] AND $_POST[wp_thumb_y] != "")
    && ($_POST[wp_size] AND $_POST[wp_size] != "")
    && ($_POST[wp_rows] AND $_POST[wp_rows] != "" AND $_POST[wp_rows] != "0")
    && ($_POST[wp_cols] AND $_POST[wp_cols] != "" AND $_POST[wp_cols] != "0")
   )
{
    settype($_POST[screen_x], 'integer');
    settype($_POST[screen_y], 'integer');
    settype($_POST[screen_thumb_x], 'integer');
    settype($_POST[screen_thumb_y], 'integer');
    settype($_POST[screen_size], 'integer');
    settype($_POST[screen_rows], 'integer');
    settype($_POST[screen_cols], 'integer');
    settype($_POST[show_img_x], 'integer');
    settype($_POST[show_img_y], 'integer');
    
    settype($_POST[wp_x], 'integer');
    settype($_POST[wp_y], 'integer');
    settype($_POST[wp_thumb_x], 'integer');
    settype($_POST[wp_thumb_y], 'integer');
    settype($_POST[wp_size], 'integer');
    settype($_POST[wp_rows], 'integer');
    settype($_POST[wp_cols], 'integer');
    
    $update = "UPDATE ".$global_config_arr[pref]."screen_config
               SET screen_x = '$_POST[screen_x]',
                   screen_y = '$_POST[screen_y]',
                   screen_thumb_x = '$_POST[screen_thumb_x]',
                   screen_thumb_y = '$_POST[screen_thumb_y]',
                   screen_size = '$_POST[screen_size]',
                   screen_rows = '$_POST[screen_rows]',
                   screen_cols = '$_POST[screen_cols]',
                   screen_sort = '$_POST[screen_sort]',
                   show_img_x = '$_POST[show_img_x]',
                   show_img_y = '$_POST[show_img_y]',
                   
                   wp_x = '$_POST[wp_x]',
                   wp_y = '$_POST[wp_y]',
                   wp_thumb_x = '$_POST[wp_thumb_x]',
                   wp_thumb_y = '$_POST[wp_thumb_y]',
                   wp_size = '$_POST[wp_size]',
                   wp_rows = '$_POST[wp_rows]',
                   wp_cols = '$_POST[wp_cols]',
                   wp_sort = '$_POST[wp_sort]'";
                   
    mysql_query($update, $db);
    systext("Die Konfiguration wurde aktualisiert");
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="screenconfig" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="65%">
                                    Bilder max. Abmessungen:<br>
                                    <font class="small">Die max. Abmessungen, bis zu denen Bilder hochgeladen werden können.</font>
                                </td>
                                <td class="config" valign="top" width="35%">
                                    <input class="text" size="5" name="screen_x" value="'.$config_arr[screen_x].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="screen_y" value="'.$config_arr[screen_y].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bilder Vorschaugröße:<br>
                                    <font class="small">Die Größe der Bilder-Thumbnails.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="screen_thumb_x" value="'.$config_arr[screen_thumb_x].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="screen_thumb_y" value="'.$config_arr[screen_thumb_y].'" maxlength="3"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bilder max. Dateigröße:<br>
                                    <font class="small">Die max. Dateigröße, bis zu der Bilder hochgeladen werden können.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="12" name="screen_size" value="'.$config_arr[screen_size].'" maxlength="7"> KB
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bilder Anzahl:<br>
                                    <font class="small">Die Anzahl der Bildern die auf einer Seite angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="1" name="screen_rows" value="'.$config_arr[screen_rows].'" maxlength="2"> Reihen à <input class="text" size="1" name="screen_cols" value="'.$config_arr[screen_cols].'" maxlength="2"> Bilder<br /><font class="small">(0 ist nicht zulässig)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bilder Sortierung:<br>
                                    <font class="small">Die Reihenfolge, in der die Bilder angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="screen_sort">
                                        <option value="asc"';
                                        if ($config_arr[screen_sort] == asc)
                                          echo ' selected="selected"';
                                        echo'>alte Bilder zuerst</option>
                                        <option value="desc"';
                                        if ($config_arr[screen_sort] == desc)
                                          echo ' selected="selected"';
                                        echo'>neue Bilder zuerst</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bildbetrachter max. Anzeigegröße:<br>
                                    <font class="small">Die Größe in der die Bilder im Bilderbetrachter max. angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="show_img_x" value="'.$config_arr[show_img_x].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="show_img_y" value="'.$config_arr[show_img_y].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Wallpaper max. Abmessungen:<br>
                                    <font class="small">Die max. Abmessungen, bis zu denen Wallpaper hochgeladen werden können.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="wp_x" value="'.$config_arr[wp_x].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="wp_y" value="'.$config_arr[wp_y].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Wallpaper Vorschaugröße:<br>
                                    <font class="small">Die Größe der Wallpaper-Thumbnails.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="wp_thumb_x" value="'.$config_arr[wp_thumb_x].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="wp_thumb_y" value="'.$config_arr[wp_thumb_y].'" maxlength="3"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Wallpaper max. Dateigröße:<br>
                                    <font class="small">Die max. Dateigröße, bis zu der Wallpaper hochgeladen werden können.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="12" name="wp_size" value="'.$config_arr[wp_size].'" maxlength="7"> KB
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Wallpaper Anzahl:<br>
                                    <font class="small">Die Anzahl der Wallpaper die auf einer Seite angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="1" name="wp_rows" value="'.$config_arr[wp_rows].'" maxlength="2"> Reihen à <input class="text" size="1" name="wp_cols" value="'.$config_arr[wp_cols].'" maxlength="2"> Wallpaper<br /><font class="small">(0 ist nicht zulässig)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Wallpaper Sortierung:<br>
                                    <font class="small">Die Reihenfolge, in der Wallpaper angezeigt werden.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="wp_sort">
                                        <option value="asc"';
                                        if ($config_arr[wp_sort] == asc)
                                          echo ' selected="selected"';
                                        echo'>alte Wallpaper zuerst</option>
                                        <option value="desc"';
                                        if ($config_arr[wp_sort] == desc)
                                          echo ' selected="selected"';
                                        echo'>neue Wallpaper zuerst</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Änderungen Speichern">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>