<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[body] &&
    $_POST[hot] &&
    $_POST[main_body] &&
    $_POST[artikel])
{
    $_POST[body] = addslashes($_POST[body]);
    $_POST[hot] = addslashes($_POST[hot]);
    $_POST[main_body] = addslashes($_POST[main_body]);
    $_POST[artikel] = addslashes($_POST[artikel]);

    mysql_query("update fs_template
                 set shop_body = '$_POST[body]',
                     shop_hot = '$_POST[hot]',
                     shop_main_body = '$_POST[main_body]',
                     shop_artikel = '$_POST[artikel]'
                 where id = '$_POST[design]'", $db);

    systext("Template wurde aktualisiert");
}

/////////////////////////////////
/////// Formular erzeugen ///////
/////////////////////////////////

else
{
    // Design ermittlen
    echo'
                    <div align="left">
                        <form action="'.$PHP_SELF.'" method="post">
                            <input type="hidden" value="shoptemplate" name="go">
                            <input type="hidden" value="'.$_POST[design].'" name="design">
                            <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                            <select name="design" onChange="this.form.submit();">
                                <option value="">Design auswählen</option>
                                <option value="">------------------------</option>
    ';

    $index = mysql_query("select id, name from fs_template ORDER BY id", $db);
    while ($design_arr = mysql_fetch_assoc($index))
    {
      echo '<option value="'.$design_arr[id].'"';
      if ($design_arr[id] == $_POST[design])
        echo ' selected=selected';
      echo '>'.$design_arr[name];
      if ($design_arr[id] == $global_config_arr[design])
        echo ' (aktiv)';
      echo '</option>';
    }

    echo'
                            </select> <input class="button" value="Los" type="submit">
                        </form>
                    </div>
    ';

    if (($_POST[design] OR $_POST[design]==0) AND $_POST[design]!="")
    {

    $index = mysql_query("select shop_body from fs_template where id = '$_POST[design]'", $db);
    $body = stripslashes(mysql_result($index, 0, "shop_body"));

    $index = mysql_query("select shop_hot from fs_template where id = '$_POST[design]'", $db);
    $hot = stripslashes(mysql_result($index, 0, "shop_hot"));

    $index = mysql_query("select shop_main_body from fs_template where id = '$_POST[design]'", $db);
    $main_body = stripslashes(mysql_result($index, 0, "shop_main_body"));

    $index = mysql_query("select shop_artikel from fs_template where id = '$_POST[design]'", $db);
    $artikel = stripslashes(mysql_result($index, 0, "shop_artikel"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="shoptemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Hot Link:<br>
                                    <font class="small">Hot Link für die rechte Menü Leiste<br>
                                    Gültige Tags:<br>
                                   '. fetchTemplateTags($hot) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="hot">'.$hot.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'hot\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Mini Shop Body:<br>
                                    <font class="small">Mini Shop im rechten Menü<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($body) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="body">'.$body.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'body\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Artikel:<br>
                                    <font class="small">Ansicht eines Artikels<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($artikel) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="artikel">'.$artikel.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'artikel\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Shop Body:<br>
                                    <font class="small">Detailseite des Shops<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($main_body) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="main_body">'.$main_body.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'main_body\')">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
    }
}
?>