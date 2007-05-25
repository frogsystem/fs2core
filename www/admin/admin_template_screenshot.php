<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[body] &&
    $_POST[cat] &&
    $_POST[cat_body] &&
    $_POST[pic])
{
    $_POST[body] = addslashes($_POST[body]);
    $_POST[cat] = addslashes($_POST[cat]);
    $_POST[cat_body] = addslashes($_POST[cat_body]);
    $_POST[pic] = addslashes($_POST[pic]);

    mysql_query("update fs_template
                 set screenshot_body = '$_POST[body]',
                     screenshot_cat = '$_POST[cat]',
                     screenshot_cat_body = '$_POST[cat_body]',
                     screenshot_pic = '$_POST[pic]'
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
                            <input type="hidden" value="screenshottemplate" name="go">
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

    $index = mysql_query("select screenshot_body from fs_template where id = '$_POST[design]'", $db);
    $body = stripslashes(mysql_result($index, 0, "screenshot_body"));

    $index = mysql_query("select screenshot_cat from fs_template where id = '$_POST[design]'", $db);
    $cat = stripslashes(mysql_result($index, 0, "screenshot_cat"));

    $index = mysql_query("select screenshot_cat_body from fs_template where id = '$_POST[design]'", $db);
    $cat_body = stripslashes(mysql_result($index, 0, "screenshot_cat_body"));

    $index = mysql_query("select screenshot_pic from fs_template where id = '$_POST[design]'", $db);
    $pic = stripslashes(mysql_result($index, 0, "screenshot_pic"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="screenshottemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Kategorie:<br>
                                    <font class="small">zeile in der Kategorie Übersicht<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($cat) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="cat">'.$cat.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'cat\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Übersicht Body:<br>
                                    <font class="small">Kategorien Übersicht<br>
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
                                    Screenshot:<br>
                                    <font class="small">Ansicht eines Screenshots<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($pic) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="pic">'.$pic.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'pic\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kategorie Body:<br>
                                    <font class="small">Ansicht einer Screenshot Kategorie<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($cat_body) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="cat_body">'.$cat_body.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'cat_body\')">
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