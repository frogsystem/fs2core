<?php

//////////////////////////////
//// Screenshot editieren ////
//////////////////////////////

if (isset($_POST[title]))
{
    settype($_POST[catid], 'integer');
    settype($_POST[editscreenid], 'integer');
    $_POST[title] = savesql($_POST[title]);
    if ($_POST[delscreen])   // Screenshot löschen
    {
        mysql_query("DELETE FROM fs_screen WHERE screen_id = $_POST[editscreenid]", $db);
        image_delete("../images/screenshots/", $_POST[editscreenid]);
        image_delete("../images/screenshots/", "$_POST[editscreenid]_s");
        systext('Screenshot wurde gelöscht');
    }
    else   // Screenshot editieren
    {
        $update = "UPDATE fs_screen
                   SET cat_id = $_POST[catid],
                   screen_name = '$_POST[title]'
                   WHERE screen_id = $_POST[editscreenid]";
        mysql_query($update, $db);
        systext("Der Screenshot wurde editiert");
    }
}

//////////////////////////////
//// Screenshot anzeigen /////
//////////////////////////////

elseif (isset($_POST[screenid]))
{
    settype($_POST[screenid], 'integer');

    $index = mysql_query("SELECT * FROM fs_screen WHERE screen_id = $_POST[screenid]", $db);
    $screen_arr = mysql_fetch_assoc($index);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="screenedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$screen_arr[screen_id].'" name="editscreenid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Thumbnail des Screenshots</font>
                                </td>
                                <td class="config" valign="top">
                                   <img src="../images/screenshots/'.$_POST[screenid].'_s.jpg">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bildtitel:<br>
                                    <font class="small">Bilduntertiel (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="33" value="'.$screen_arr[screen_name].'" maxlength="100">
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
        $sele = ($screen_arr[cat_id] == $cat_arr[cat_id]) ? "selected" : "";
        echo'
                                        <option value="'.$cat_arr[cat_id].'" '.$sele.'>
                                            '.$cat_arr[cat_name].'
                                        </option>
        ';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Screenshot löschen:
                                </td>
                                <td class="config">
                                   <input onClick=\'delalert ("delscreen", "Soll der Screenshot wirklich gelöscht werden?")\' type="checkbox" name="delscreen" id="delscreen" value="1">
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

//////////////////////////////
/// Screenshot Kategrorien ///
//////////////////////////////

else
{
    if (isset($_POST[screencatid]))
    {
        settype($_POST[screencatid], 'integer');
        $wherecat = "WHERE cat_id = " . $_POST[screencatid];
    }

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="screenedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="40%">
                                    Dateien der Kategorie
                                    <select name="screencatid">
    ';
    $index = mysql_query("SELECT * FROM fs_screen_cat WHERE cat_type = 1", $db);
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        $sele = ($_POST[screencatid] == $cat_arr[cat_id]) ? "selected" : "";
        echo'
                                        <option value="'.$cat_arr[cat_id].'" '.$sele.'>
                                            '.$cat_arr[cat_name].'
                                        </option>
        ';
    }
    echo'
                                    </select>
                                    <input class="button" type="submit" value="Anzeigen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

//////////////////////////////
//// Screenshot auswählen ////
//////////////////////////////

    if (isset($_POST[screencatid]))
    {
        echo'<br>
                    <form action="" method="post">
                        <input type="hidden" value="screenedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="25%">
                                    Bild
                                </td>
                                <td class="config" width="30%">
                                    Titel
                                </td>
                                <td class="config" width="30%">
                                    Kategorie
                                </td>
                                <td class="config" width="15%">
                                    bearbeiten
                                </td>
                            </tr>
        ';
        $index = mysql_query("SELECT * FROM fs_screen $wherecat ORDER BY screen_id DESC", $db);
        while ($screen_arr = mysql_fetch_assoc($index))
        {
            $index2 = mysql_query("select cat_name from fs_screen_cat where cat_id = $screen_arr[cat_id]", $db);
            $db_cat_name = mysql_result($index2, 0, "cat_name");
            echo'
                            <tr style="cursor:pointer;"
                                onmouseover="javascript:this.style.backgroundColor=\'#EEEEEE\'"
                                onmouseout="javascript:this.style.backgroundColor=\'transparent\'"
                                onClick=\'document.getElementById("'.$screen_arr[screen_id].'").checked="true";\'>
                                <td class="configthin">
                                    <img src="../images/screenshots/'.$screen_arr[screen_id].'_s.jpg" width="50" height="37" alt="">
                                </td>
                                <td class="configthin">
                                    '.$screen_arr[screen_name].'
                                </td>
                                <td class="configthin">
                                    '.$db_cat_name.'
                                </td>
                                <td class="configthin">
                                    <input type="radio" name="screenid" id="'.$screen_arr[screen_id].'" value="'.$screen_arr[screen_id].'">
                                </td>
                            </tr>
            ';
        }
        echo'
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                   <input class="button" type="submit" value="editieren">
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}
?>