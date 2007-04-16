<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[body] ||
    $_POST[line] ||
    $_POST[no_poll] ||
    $_POST[result] ||
    $_POST[result_line] ||
    $_POST[list_line] ||
    $_POST[liste] ||
    $_POST[main_body] ||
    $_POST[main_line])
{
    $_POST[body] = addslashes($_POST[body]);
    $_POST[line] = addslashes($_POST[line]);
    $_POST[no_poll] = addslashes($_POST[no_poll]);
    $_POST[result] = addslashes($_POST[result]);
    $_POST[result_line] = addslashes($_POST[result_line]);
    $_POST[list_line] = addslashes($_POST[list_line]);
    $_POST[liste] = addslashes($_POST[liste]);
    $_POST[main_body] = addslashes($_POST[main_body]);
    $_POST[main_line] = addslashes($_POST[main_line]);

    mysql_query("update fs_template
                 set poll_body = '$_POST[body]',
                     poll_line = '$_POST[line]',
                     poll_no_poll = '$_POST[no_poll]',
                     poll_result = '$_POST[result]',
                     poll_result_line = '$_POST[result_line]',
                     poll_list_line = '$_POST[list_line]',
                     poll_list = '$_POST[liste]',
                     poll_main_body = '$_POST[main_body]',
                     poll_main_line = '$_POST[main_line]'
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
                            <input type="hidden" value="polltemplate" name="go">
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

    $index = mysql_query("select poll_body from fs_template where id = '$_POST[design]'", $db);
    $body = stripslashes(mysql_result($index, 0, "poll_body"));

    $index = mysql_query("select poll_line from fs_template where id = '$_POST[design]'", $db);
    $line = stripslashes(mysql_result($index, 0, "poll_line"));

    $index = mysql_query("select poll_no_poll from fs_template where id = '$_POST[design]'", $db);
    $no_poll = stripslashes(mysql_result($index, 0, "poll_no_poll"));

    $index = mysql_query("select poll_result from fs_template where id = '$_POST[design]'", $db);
    $result = stripslashes(mysql_result($index, 0, "poll_result"));

    $index = mysql_query("select poll_result_line from fs_template where id = '$_POST[design]'", $db);
    $result_line = stripslashes(mysql_result($index, 0, "poll_result_line"));

    $index = mysql_query("select poll_list_line from fs_template where id = '$_POST[design]'", $db);
    $list_line = stripslashes(mysql_result($index, 0, "poll_list_line"));

    $index = mysql_query("select poll_list from fs_template where id = '$_POST[design]'", $db);
    $liste = stripslashes(mysql_result($index, 0, "poll_list"));

    $index = mysql_query("select poll_main_body from fs_template where id = '$_POST[design]'", $db);
    $main_body = stripslashes(mysql_result($index, 0, "poll_main_body"));

    $index = mysql_query("select poll_main_line from fs_template where id = '$_POST[design]'", $db);
    $main_line = stripslashes(mysql_result($index, 0, "poll_main_line"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="polltemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Antwort Zeile:<br>
                                    <font class="small">Antwortmöglichkeit im rechten Menü<br>
                                    Gültige Tags:<br>
                                    '.insert_tt("{answer}","Der Antworttext.").'
                                    '.insert_tt("{answer_id}","Die ID der Antwort, damit das Script auch weiß, für was abgestimmt wurde").'
                                    '.insert_tt("{type}","Der Umfragentyp. Notwendig, da die beiden Typen verschiedene Auswahlmöglichkeiten erfordern.").'
                                    '.insert_tt("{multiple}","Erweiterung für Multiple-Choice Umfragen.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="line">'.$line.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'line\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Umfrage Body:<br>
                                    <font class="small">Body der Umfrage im Menü<br>
                                    Gültige Tags:<br>
                                    '.insert_tt("{question}","Die Frage, nach der in der Umfrage gefragt wird.").'
                                    '.insert_tt("{answers}","Markiert die Stelle, an der hintereinander alle Antworten eingefügt werden. (Template \"Antwort Zeile\")").'
                                    '.insert_tt("{poll_id}","Die ID der Umfrage, damit das Script weiß welche Umfrage das ist.").'
                                    '.insert_tt("{button_state}","Stellt den Status des Abstimmen-Buttons ein. Wichtig für die Abstimmsicherheit.").'
                                    </font>
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
                                <td class="config" valign="top">
                                    Keine Umfrage:<br>
                                    <font class="small">Altenative, wenn keine Umfrage aktiv ist</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="no_poll">'.$no_poll.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'no_poll\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Resultat Zeile:<br>
                                    <font class="small">Resultat im rechten Menü<br>
                                    Gültige Tags:<br>
                                    '.insert_tt("{answer}","Der Antworttext.").'
                                    '.insert_tt("{votes}","Die Anzahl der Stimmen die eine Antwort erhalten hat.").'
                                    '.insert_tt("{percentage}","Der Stimmenanteil einer Antwort in Prozent. (Mit Prozentzeichen!)").'
                                    '.insert_tt("{bar_width}","Die Breite des Antwortbalkens bei der grafischen Stimmendarstellung.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="result_line">'.$result_line.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'result_line\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Resultat:<br>
                                    <font class="small">Ergebnis der Umfrage im Menü<br>
                                    Gültige Tags:<br>
                                    '.insert_tt("{question}","Die Frage, nach der in der Umfrage gefragt wird.").'
                                    '.insert_tt("{answers}","Markiert die Stelle, an der hintereinander alle Antworten eingefügt werden. (Template \"Resultat Zeile\")").'
                                    '.insert_tt("{all_votes}","Die Anzahl aller abgegebenen Stimmen.").'
                                    '.insert_tt("{participants}","Die Anzahl aller Umfrageteilnehmer.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="result">'.$result.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'result\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Umfrage:<br>
                                    <font class="small">Zeile in der Übersichtsseite der bisherigen Umfragen<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($first_line) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="list_line">'.$list_line.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'list_line\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Umfragen Übersicht:<br>
                                    <font class="small">Übersichtsseite der bisherigen Umfragen<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($liste) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="liste">'.$liste.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'liste\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Archiv Antwort:<br>
                                    <font class="small">Antwort einer archivierten Umfrage<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($main_line) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="main_line">'.$main_line.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'main_line\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Archiv Umfrage:<br>
                                    <font class="small">Archivierte Umfrage<br>
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