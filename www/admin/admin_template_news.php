<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[link] ||
    $_POST[body] ||
    $_POST[relatedlinks] ||
    $_POST[headline] ||
    $_POST[headline_body] ||
    $_POST[comment_body] ||
    $_POST[comment_autor] ||
    $_POST[comment_form] ||
    $_POST[comment_form_name] ||
    $_POST[search_form])
{
    $_POST[body] = savesql($_POST[body]);
    $_POST[link] = savesql($_POST[link]);
    $_POST[relatedlinks] = savesql($_POST[relatedlinks]);
    $_POST[headline] = savesql($_POST[headline]);
    $_POST[headline_body] = savesql($_POST[headline_body]);
    $_POST[comment_body] = savesql($_POST[comment_body]);
    $_POST[comment_autor] = savesql($_POST[comment_autor]);
    $_POST[comment_form] = savesql($_POST[comment_form]);
    $_POST[comment_form_name] = savesql($_POST[comment_form_name]);
    $_POST[search_form] = savesql($_POST[search_form]);

    mysql_query("update fs_template
                 set news_body = '$_POST[body]',
                     news_link = '$_POST[link]',
                     news_related_links = '$_POST[relatedlinks]',
                     news_headline = '$_POST[headline]',
                     news_headline_body = '$_POST[headline_body]',
                     news_comment_body = '$_POST[comment_body]',
                     news_comment_autor = '$_POST[comment_autor]',
                     news_comment_form = '$_POST[comment_form]',
                     news_comment_form_name = '$_POST[comment_form_name]',
                     news_search_form = '$_POST[search_form]'
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
                            <input type="hidden" value="newstemplate" name="go">
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

    $index = mysql_query("select news_body from fs_template where id = '$_POST[design]'", $db);
    $body = killhtml(mysql_result($index, 0, "news_body"));

    $index = mysql_query("select news_related_links from fs_template where id = '$_POST[design]'", $db);
    $related_links = killhtml(mysql_result($index, 0, "news_related_links"));

    $index = mysql_query("select news_link from fs_template where id = '$_POST[design]'", $db);
    $link = killhtml(mysql_result($index, 0, "news_link"));

    $index = mysql_query("select news_headline from fs_template where id = '$_POST[design]'", $db);
    $headline = killhtml(mysql_result($index, 0, "news_headline"));

    $index = mysql_query("select news_headline_body from fs_template where id = '$_POST[design]'", $db);
    $headline_body = killhtml(mysql_result($index, 0, "news_headline_body"));

    $index = mysql_query("select news_comment_body from fs_template where id = '$_POST[design]'", $db);
    $comment_body = killhtml(mysql_result($index, 0, "news_comment_body"));

    $index = mysql_query("select news_comment_autor from fs_template where id = '$_POST[design]'", $db);
    $comment_autor = killhtml(mysql_result($index, 0, "news_comment_autor"));

    $index = mysql_query("select news_comment_form from fs_template where id = '$_POST[design]'", $db);
    $comment_form = killhtml(mysql_result($index, 0, "news_comment_form"));
    
    $index = mysql_query("select news_comment_form_name from fs_template where id = '$_POST[design]'", $db);
    $comment_form_name = killhtml(mysql_result($index, 0, "news_comment_form_name"));

    $index = mysql_query("select news_search_form from fs_template where id = '$_POST[design]'", $db);
    $search_form = killhtml(mysql_result($index, 0, "news_search_form"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="newstemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Related Link Zeile:<br>
                                    <font class="small">Eine Zeile der Related Links<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{name}","Der Titel den der Link trägt.").'
                                    '.insert_tt("{target}","Das Ziel-Fenster des Links.").'
                                    '.insert_tt("{url}","Die URL auf die verlinkt werden soll.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="6" cols="66" name="link">'.$link.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'link\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Related Links Body:<br>
                                    <font class="small">Die Related Links unter einer News<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{links}","Bindet nacheinander die angegebenen Links ein.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="relatedlinks">'.$related_links.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'relatedlinks\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    News Body:<br>
                                    <font class="small">Der News Body, in dem alles zusammenläuft<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{newsid}","ID der News, für die eindeutige Ansteuerung auf der Startseite.").'
                                    '.insert_tt("{titel}","Der Titel der News.").'
                                    '.insert_tt("{datum}","Das Datum an dem die News veröffentlicht wurde.").'
                                    '.insert_tt("{text}","Der Text der News.").'
                                    '.insert_tt("{autor}","Der Name des News-Schreibers.").'
                                    '.insert_tt("{autor_profilurl}","URL zum Profil des Autors.").'
                                    '.insert_tt("{kategorie_bildname}","URL zum Kategorie-Bild.").'
                                    '.insert_tt("{kategorie_name}","Der Titel der Kategorie.").'
                                    '.insert_tt("{kommentar_url}","URL zur Kommentaransicht der News.").'
                                    '.insert_tt("{kommentar_anzahl}","Anzahl der zur News abgegebenen Kommentare.").'
                                    '.insert_tt("{related_links}","Bindet die Related Links der News ein.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="25" cols="66" name="body">'.$body.'</textarea>
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
                                    Headline:<br>
                                    <font class="small">Zeile im Headline Body<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{titel}","Der Titel der News.").'
                                    '.insert_tt("{datum}","Das Datum an dem die News veröffentlicht wurde.").'
                                    '.insert_tt("{url}","URL zur News.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="6" cols="66" name="headline">'.$headline.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'headline\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Headline Body:<br>
                                    <font class="small">Headline Kasten oben auf der Seite<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{headlines}","Bindet die Headlines ein.").'
                                    '.insert_tt("{downloads}","Bindet die Downloads ein.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="headline_body">'.$headline_body.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'headline_body\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kommentar Autor:<br>
                                    <font class="small">Link zum Kommentar Autor<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{name}","Der Name des Kommentar-Schreibers.").'
                                    '.insert_tt("{url}","URL zum Profil des Autors.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="comment_autor">'.$comment_autor.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'comment_autor\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kommentar Body:<br>
                                    <font class="small">Der Kommentar Body, in dem alles zusammenläuft<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{titel}","Der Titel des Kommentars.").'
                                    '.insert_tt("{datum}","Das Datum an dem der Kommentar geschrieben wurde.").'
                                    '.insert_tt("{text}","Der Text des Kommentars.").'
                                    '.insert_tt("{autor}","Bindet das \"Kommentar Autor\" Template ein.").'
                                    '.insert_tt("{autor_avatar}","Bindet einen evtl. Avatar des Autors ein.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="25" cols="66" name="comment_body">'.$comment_body.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'comment_body\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Formular Name:<br>
                                    <font class="small">Wird angezeigt, wenn der User nicht registriert ist.
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="4" cols="66" name="comment_form_name">'.$comment_form_name.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'comment_form_name\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kommentar Formular:<br>
                                    <font class="small">Formular zum schreiben von Kommentaren<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{newsid}","ID der News, um sie eindeutig zu identifizieren.").'
                                    '.insert_tt("{name_input}","Bindet den Namen des angemeldeten Users, bzw. das Template \"Forumlar Name\" ein.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="comment_form">'.$comment_form.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'comment_form\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Such Formular:<br>
                                    <font class="small">Formular für die Suche im Archiv<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{years}","Fügt die Jahre ein, für die News verfügbar sind.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="25" cols="66" name="search_form">'.$search_form.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'search_form\')">
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