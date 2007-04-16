<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[search_field] &&
    $_POST[navigation] &&
    $_POST[body] &&
    $_POST[datei_preview] &&
    $_POST[file_body] &&
    $_POST[file]&&
    $_POST[file_is_mirror]&&
    $_POST[stats] &&
    $_POST[quick_links])
{
    $_POST[search_field] = addslashes($_POST[search_field]);
    $_POST[navigation] = addslashes($_POST[navigation]);
    $_POST[body] = addslashes($_POST[body]);
    $_POST[datei_preview] = addslashes($_POST[datei_preview]);
    $_POST[file_body] = addslashes($_POST[file_body]);
    $_POST[file] = addslashes($_POST[file]);
    $_POST[file_is_mirror] = addslashes($_POST[file_is_mirror]);
    $_POST[stats] = addslashes($_POST[stats]);
    $_POST[quick_links] = addslashes($_POST[quick_links]);

    mysql_query("update fs_template
                 set dl_search_field = '$_POST[search_field]',
                     dl_navigation = '$_POST[navigation]',
                     dl_body = '$_POST[body]',
                     dl_datei_preview = '$_POST[datei_preview]',
                     dl_file_body = '$_POST[file_body]',
                     dl_file = '$_POST[file]',
                     dl_file_is_mirror = '$_POST[file_is_mirror]',
                     dl_stats = '$_POST[stats]',
                     dl_quick_links = '$_POST[quick_links]'
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
                            <input type="hidden" value="dltemplate" name="go">
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

    $index = mysql_query("select dl_search_field from fs_template where id = '$_POST[design]'", $db);
    $search_field = stripslashes(mysql_result($index, 0, "dl_search_field"));

    $index = mysql_query("select dl_navigation from fs_template where id = '$_POST[design]'", $db);
    $navigation = stripslashes(mysql_result($index, 0, "dl_navigation"));

    $index = mysql_query("select dl_body from fs_template where id = '$_POST[design]'", $db);
    $body = stripslashes(mysql_result($index, 0, "dl_body"));

    $index = mysql_query("select dl_datei_preview from fs_template where id = '$_POST[design]'", $db);
    $datei_preview = stripslashes(mysql_result($index, 0, "dl_datei_preview"));

    $index = mysql_query("select dl_file_body from fs_template where id = '$_POST[design]'", $db);
    $file_body = stripslashes(mysql_result($index, 0, "dl_file_body"));

    $index = mysql_query("select dl_file from fs_template where id = '$_POST[design]'", $db);
    $file = stripslashes(mysql_result($index, 0, "dl_file"));
    
    $index = mysql_query("select dl_file_is_mirror from fs_template where id = '$_POST[design]'", $db);
    $file_is_mirror = stripslashes(mysql_result($index, 0, "dl_file_is_mirror"));
    
    $index = mysql_query("select dl_stats from fs_template where id = '$_POST[design]'", $db);
    $stats = stripslashes(mysql_result($index, 0, "dl_stats"));

    $index = mysql_query("select dl_quick_links from fs_template where id = '$_POST[design]'", $db);
    $quick_links = stripslashes(mysql_result($index, 0, "dl_quick_links"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="dltemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Such Feld:<br>
                                    <font class="small">Kleines Suchfeld, dass auf jeder Seite angezeigt werden kann<br />
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($search_field) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="10" cols="66" name="search_field">'.$search_field.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'search_field\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Navigation:<br>
                                    <font class="small">Zeile der Navigation<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($navigation) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="navigation">'.$navigation.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'navigation\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Quick Links:<br>
                                    <font class="small">Quick Links Feld auf der Newsseite<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($quick_links) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="quick_links">'.$quick_links.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'quick_links\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datei Vorschau:<br>
                                    <font class="small">Vorschau einer Datei in der Übersicht<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($datei_preview) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="datei_preview">'.$datei_preview.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'datei_preview\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Download Übersicht:<br>
                                    <font class="small">Übersichtsseite für die Downloads. Wird auch für die Suchergebnisse genutzt<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($body) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="body">'.$body.'</textarea>
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
                                    File:<br>
                                    <font class="small">Zeile für ein File<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($file) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="file">'.$file.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'file\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Statistik:<br>
                                    <font class="small">Zeile für die Statistik unter den Files<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($stats) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="stats">'.$stats.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'stats\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Mirror:<br>
                                    <font class="small">Anzeige, wenn das File ein Mirror ist<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($file_is_mirror) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="file_is_mirror">'.$file_is_mirror.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'file_is_mirror\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datei Body:<br>
                                    <font class="small">Detailseite für einen Download<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($file_body) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="25" cols="66" name="file_body">'.$file_body.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'file_body\')">
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