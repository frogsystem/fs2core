<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[indexphp] ||
    $_POST[error] ||
    $_POST[pic_viewer] ||
    $_POST[main_menu] ||
    $_POST[community_map] ||
    $_POST[statistik] ||
    $_POST[announcement])
{
    $_POST[indexphp] = savesql($_POST[indexphp]);
    $_POST[error] = savesql($_POST[error]);
    $_POST[pic_viewer] = savesql($_POST[pic_viewer]);
    $_POST[main_menu] = savesql($_POST[main_menu]);
    $_POST[community_map] = savesql($_POST[community_map]);
    $_POST[announcement] = savesql($_POST[announcement]);

    mysql_query("update fs_template
                 set indexphp = '$_POST[indexphp]',
                     error = '$_POST[error]',
                     pic_viewer = '$_POST[pic_viewer]',
                     main_menu = '$_POST[main_menu]',
                     community_map = '$_POST[community_map]',
                     announcement = '$_POST[announcement]'
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
                            <input type="hidden" value="alltemplate" name="go">
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

    $index = mysql_query("select indexphp from fs_template where id = '$_POST[design]'", $db);
    $indexphp = killhtml(mysql_result($index, 0, "indexphp"));

    $index = mysql_query("select error from fs_template where id = '$_POST[design]'", $db);
    $error = killhtml(mysql_result($index, 0, "error"));

    $index = mysql_query("select pic_viewer from fs_template where id = '$_POST[design]'", $db);
    $pic_viewer = killhtml(mysql_result($index, 0, "pic_viewer"));

    $index = mysql_query("select main_menu from fs_template where id = '$_POST[design]'", $db);
    $main_menu = killhtml(mysql_result($index, 0, "main_menu"));

    $index = mysql_query("select community_map from fs_template where id = '$_POST[design]'", $db);
    $community_map = killhtml(mysql_result($index, 0, "community_map"));

    $index = mysql_query("select statistik from fs_template where id = '$_POST[design]'", $db);
    $statistik = killhtml(mysql_result($index, 0, "statistik"));

    $index = mysql_query("select announcement from fs_template where id = '$_POST[design]'", $db);
    $announcement = killhtml(mysql_result($index, 0, "announcement"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="alltemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Index.php:<br>
                                    <font class="small">Hauptdesign der Seite<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{main_menu}","Bindet das Template \"Haupt Menü\" ein.").'
                                    '.insert_tt("{announcement}","Bindet die Ankündigung ein.").'
                                    '.insert_tt("{content}","Markiert die Stelle, an der Seiteninhalt eingefügt wird.").'
                                    '.insert_tt("{user}","Bindet das User-Menü ein.").'
                                    '.insert_tt("{randompic}","Bindet das Zufallsbild ein.").'
                                    '.insert_tt("{poll}","Bindet das Umfragensystem ein.").'
                                    '.insert_tt("{stats}","Bindet die Statistik ein.").'
                                    '.insert_tt("{shop}","Bindet den Shop ein.").'
                                    '.insert_tt("{partner}","Bindet das Partnersystem ein.").'
                                    </font>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="indexphp">'.$indexphp.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'indexphp\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Error Meldung:<br>
                                    <font class="small">Systemmeldung, wenn ein Fehler auftritt<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{titel}","Der Titel der Systemmeldung.").'
                                    '.insert_tt("{meldung}","Der Text der Systemmeldung.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="error">'.$error.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'error\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Picture Viewer:<br>
                                    <font class="small">Popup zum darstellen von Bildern<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{bannercode}","Bindet die Werbung ein.").'
                                    '.insert_tt("{weiter_grafik}","Bildadresse der Grafik \"images/icons/weiter.gif\".").'
                                    '.insert_tt("{zurück_grafik}","Bildadresse der Grafik \"images/icons/zurueck.gif\".").'
                                    '.insert_tt("{bild}","Bildadresse des Galerie-Bildes.").'
                                    '.insert_tt("{text}","Beschreibungs-Text des Bildes.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="25" cols="66" name="pic_viewer">'.$pic_viewer.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'pic_viewer\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Haupt Menü:<br>
                                    <font class="small">Linke Menüleiste<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{virtualhost}","Die unter Konfiguration angegebene Adresse der Seite, auf die Links umgeschaltet werden.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="25" cols="66" name="main_menu">'.$main_menu.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'main_menu\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Community Map:<br>
                                    <font class="small">Gerüst für die Community Map<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{karte}","Bindet die Karte ein.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="community_map">'.$community_map.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'community_map\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Statistik:<br>
                                    <font class="small">Besucher und Seiten Statistik<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{visits}","Anzahl aller Besucher der Seite.").'
                                    '.insert_tt("{visits_heute}","Zahl aller Besucher am aktuellen Tag.").'
                                    '.insert_tt("{hits}","Anzahl aller Seitenaufrufe.").'
                                    '.insert_tt("{hits_heute}","Zahl aller Seitenaufrufe am aktuellen Tag.").'
                                    '.insert_tt("{user_online}","Zahl aller Besucher die sich zurzeit auf der Seite befinden.").'
                                    '.insert_tt("{news}","Anzahl der geschriebenen News.").'
                                    '.insert_tt("{user}","Anzahl der registrierten User.").'
                                    '.insert_tt("{artikel}","Anzahl der geschriebenen Artikel.").'
                                    '.insert_tt("{kommentare}","Anzahl der abgegebenen Kommentare.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="statistik">'.$statistik.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'statistik\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Ankündigung:<br>
                                    <font class="small">Globale Ankündigung<br /><br />
                                    Gültige Tags:<br>
                                    '.insert_tt("{meldung}","Fügt die angegebene Meldung ein.").'
                                    </font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="announcement">'.$announcement.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'announcement\')">
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