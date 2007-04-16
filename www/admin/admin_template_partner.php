<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[main_body] && $_POST[eintrag] && $_POST[navi_eintrag] && $_POST[navi_body])
{
    $_POST[main_body] = addslashes($_POST[main_body]);
    $_POST[eintrag] = addslashes($_POST[eintrag]);

    mysql_query("update fs_template
                 set partner_main_body = '$_POST[main_body]',
                     partner_eintrag = '$_POST[eintrag]',
                     partner_navi_eintrag = '$_POST[navi_eintrag]',
                     partner_navi_body = '$_POST[navi_body]'
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
                            <input type="hidden" value="partnertemplate" name="go">
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

    $index = mysql_query("select partner_eintrag from fs_template where id = '$_POST[design]'", $db);
    $eintrag = stripslashes(mysql_result($index, 0, "partner_eintrag"));

    $index = mysql_query("select partner_main_body from fs_template where id = '$_POST[design]'", $db);
    $main_body = stripslashes(mysql_result($index, 0, "partner_main_body"));
    
    $index = mysql_query("select partner_navi_eintrag from fs_template where id = '$_POST[design]'", $db);
    $navi_eintrag = stripslashes(mysql_result($index, 0, "partner_navi_eintrag"));

    $index = mysql_query("select partner_navi_body from fs_template where id = '$_POST[design]'", $db);
    $navi_body = stripslashes(mysql_result($index, 0, "partner_navi_body"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="partnertemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Eintrag:<br>
                                    <font class="small">Ansicht eines Eintrags.<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($eintrag) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="eintrag">'.$eintrag.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'eintrag\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Partner Übersicht:<br>
                                    <font class="small">Lister aller eingetragenen Partner<br>
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
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Eintrag in der Navi:<br>
                                    <font class="small">Aussehen eines Eintrags in der Navi.<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($navi_eintrag) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="navi_eintrag">'.$navi_eintrag.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'navi_eintrag\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Navi Body:<br>
                                    <font class="small">Gesamt-Aussehen der Partner in der Navi.<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($navi_body) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="navi_body">'.$navi_body.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'navi_body\')">
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