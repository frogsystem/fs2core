<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST[numhead] && $_POST[numnews] && $_POST[cat_pic_x] && $_POST[cat_pic_y] && $_POST[com_rights])
{
    settype($_POST[numnews], 'integer');
    settype($_POST[numhead], 'integer');
    settype($_POST[htmlcode], 'integer');
    settype($_POST[cat_pic_x], 'integer');
    settype($_POST[cat_pic_y], 'integer');
    settype($_POST[com_rights], 'integer');
    
    mysql_query("UPDATE fs_news_config
                 SET num_news  = '$_POST[numnews]',
                     num_head  = '$_POST[numhead]',
                     html_code = '$_POST[htmlcode]',
                     fs_code   = '$_POST[fscode]',
                     cat_pic_x   = '$_POST[cat_pic_x]',
                     cat_pic_y   = '$_POST[cat_pic_y]',
                     com_rights   = '$_POST[com_rights]'", $db);
    systext("Die Konfiguration wurde aktualisiert");
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query("select * from fs_news_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    switch ($config_arr[html_code])
    {
        case 1:
            $htmlop1 = "selected";
            break;
        case 2:
            $htmlop2 = "selected";
            break;
        case 3:
            $htmlop3 = "selected";
            break;
    }
    switch ($config_arr[fs_code])
    {
        case 1:
            $fsop1 = "selected";
            break;
        case 2:
            $fsop2 = "selected";
            break;
        case 3:
            $fsop3 = "selected";
            break;
    }
 
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="newsconfig" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    News pro Seite:<br>
                                    <font class="small">Anzahl der News die auf der Hauptseite angezeigt werden</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="numnews" value="'.$config_arr[num_news].'" maxlength="2">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Headlines:<br>
                                    <font class="small">Anzahl der Headlines auf der Seite</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="5" name="numhead" value="'.$config_arr[num_head] .'" maxlength="2">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    HTML code:<br>
                                    <font class="small">Erlaubt Html code in</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="htmlcode">
                                        <option '.$htmlop1.' value="1">Aus</option>
                                        <option '.$htmlop2.' value="2">News</option>
                                        <option '.$htmlop3.' value="3">News & Kommentaren</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    FS code:<br>
                                    <font class="small">Erlaubt FS code in</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="fscode">
                                        <option '.$fsop1.' value="1">Aus</option>
                                        <option '.$fsop2.' value="2">News</option>
                                        <option '.$fsop3.' value="3">News & Kommentaren</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Kategorie Bild - max. Breite:<br>
                                    <font class="small">Wie breit ein Kategorie Bild max. sein darf</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="cat_pic_x" value="'.$config_arr[cat_pic_x].'" maxlength="3"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Kategorie Bild - max. Höhe:<br>
                                    <font class="small">Wie hoch ein Kategorie Bild max. sein darf</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="cat_pic_y" value="'.$config_arr[cat_pic_y].'" maxlength="3"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Kommentare erlauben für:<br>
                                    <font class="small">Wer darf Kommentare schreiben?</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="com_rights">
                                        <option value="2"';
                                        if ($config_arr[com_rights] == 2)
                                            echo ' selected="selected"';
                                        echo'>alle User</option>
                                        <option value="1"';
                                        if ($config_arr[com_rights] == 1)
                                            echo ' selected="selected"';
                                        echo'>registrierte User</option>
                                        <option value="0"';
                                        if ($config_arr[com_rights] == 0)
                                            echo ' selected="selected"';
                                        echo'>niemanden</option>
                                    </select>
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