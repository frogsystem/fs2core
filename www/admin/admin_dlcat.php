<?php

//////////////////////////
//// Kategorie ändern ////
//////////////////////////

if (isset($_POST[catname]))
{
    if (isset($_POST[delcat]))
    {
        settype($_POST[catid], "integer");
        mysql_query("DELETE FROM ".$global_config_arr[pref]."dl_cat WHERE cat_id = ".$_POST[catid], $db);
        systext("Die Kategorie wurde gelöscht");
    }
    else
    {
        $_POST[catname] = savesql($_POST[catname]);
        settype($_POST[subcatof], "integer");

        $update = "UPDATE ".$global_config_arr[pref]."dl_cat
                   SET subcat_id = '$_POST[subcatof]',
                       cat_name = '$_POST[catname]'
                   WHERE cat_id = $_POST[catid]";
        mysql_query($update, $db);
        systext("Die Kategorie wurde editiert");
    }
}

//////////////////////////
/// Kategorie Formular ///
//////////////////////////

elseif (isset($_POST[editcatid]))
{
    settype ($_POST[editcatid], 'integer');

    $valid_ids = array();
    get_dl_categories (&$valid_ids, $_POST[editcatid]);

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."dl_cat WHERE cat_id = '$_POST[editcatid]'", $db);
    $cat_arr = mysql_fetch_assoc($index);
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_cat" name="go">
                        <input type="hidden" value="'.$cat_arr[cat_id].'" name="catid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Name:<br>
                                    <font class="small">Name der neuen Kategorie</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="catname" size="33" value="'.$cat_arr[cat_name].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Subkategorie von:<br>
                                    <font class="small">Macht diese Kategorie zu einer Unterkategorie einer anderen</font>
                                </td>
                                <td class="configthin" valign="top">
                                    <select name="subcatof">
                                        <option value="0">Keine Subkategorie</option>
                                        <option value="0">--------------------------</option>
    ';
    foreach ($valid_ids as $cat)
    {
        $sele = ($cat_arr[subcat_id] == $cat[cat_id]) ? "selected" : "";
        echo'
                                        <option value="'.$cat[cat_id].'" '.$sele.'>'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $cat[ebene]).$cat[cat_name].'</option>
        ';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Kategorie löschen:
                                </td>
                                <td class="config">
                                    <input onClick=\'delalert ("delcat", "Soll die Downloadkategorie wirklich gelöscht werden?")\' type="checkbox" name="delcat" id="delcat" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <br><input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

//////////////////////////
/// Kategorie auswählen //
//////////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="dl_cat" name="go">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="40%">
                                    Name
                                </td>
                                <td class="config" width="40%">
                                    Subkategorie
                                </td>
                                <td class="config" width="20%">
                                    bearbeiten
                                </td>
                            </tr>
    ';
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."dl_cat ORDER BY cat_name");
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        $sub = ($cat_arr[subcat_id] == 0) ? "Nein" : "Ja";
        echo'
                            <tr>
                                <td class="configthin">
                                    '.$cat_arr[cat_name].'
                                </td>
                                <td class="configthin">
                                    '.$sub.'
                                </td>
                                <td class="config">
                                    <input type="radio" name="editcatid" value="'.$cat_arr[cat_id].'">
                                </td>
                            </tr>
        ';
    }
    echo'
                            <tr>
                                <td colspan="3">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                    <input class="button" type="submit" value="editieren">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>