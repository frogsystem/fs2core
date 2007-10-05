<?php

//////////////////////////////////////////////////
//// Neues Pre-, Re oder Interview einstellen ////
//////////////////////////////////////////////////

if (($_POST['title'] AND $_POST['title'] != "")
    && ($_POST['url'] AND $_POST['url'] != "")
    && ($_POST['day'] AND $_POST['day'] != "")
    && ($_POST['month'] AND $_POST['month'] != "")
    && ($_POST['year'] AND $_POST['year'] != "")
    && ($_POST['text'] AND $_POST['text'] != ""))
{
    settype($_POST['day'], 'integer');
    settype($_POST['month'], 'integer');
    settype($_POST['year'], 'integer');
    $datum = mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']);

    $_POST['title'] = savesql($_POST['title']);
    $_POST['url'] = savesql($_POST['url']);
    $_POST['intro'] = savesql($_POST['intro']);
    $_POST['text'] = savesql($_POST['text']);
    $_POST['note'] = savesql($_POST['note']);
    
    settype($_POST['game'], 'integer');
    settype($_POST['cat'], 'integer');
    settype($_POST['lang'], 'integer');

    mysql_query("INSERT INTO
                 ".$global_config_arr[pref]."press (press_title,
                           press_url,
                           press_date,
                           press_intro,
                           press_text,
                           press_note,
                           press_lang,
                           press_game,
                           press_cat)
                 VALUES ('$_POST[title]',
                         '$_POST[url]',
                         '$datum',
                         '$_POST[intro]',
                         '$_POST[text]',
                         '$_POST[note]',
                         '$_POST[lang]',
                         '$_POST[game]',
                         '$_POST[cat]')", $db);

    systext("Pressebericht wurde gespeichert.");
}

////////////////////////////////////////////
///// Pre-, Re oder Interview Formular /////
////////////////////////////////////////////
else
{
    //Zeit-Array für Heute Button
    $heute[time] = time();
    $heute[tag] = date("d", $heute[time]);
    $heute[monat] = date("m", $heute[time]);
    $heute[jahr] = date("Y", $heute[time]);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="press_add" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Der Name der Website.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="51" maxlength="150">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link zum Artikel.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="url" size="51" maxlength="255" value="http://">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Datum der Veröffentlichung.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="1" name="day" id="day" maxlength="2"> .
                                    <input class="text" size="1" name="month" id="month"  maxlength="2"> .
                                    <input class="text" size="3" name="year" id="year"  maxlength="4">&nbsp;
                                    <input class="button" type="button" value="Heute"
                                     onClick=\'document.getElementById("day").value="'.$heute[tag].'";
                                               document.getElementById("month").value="'.$heute[monat].'";
                                               document.getElementById("year").value="'.$heute[jahr].'";\'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Einleitung: <font class="small">'.$admin_phrases[common][optional].'</font><br />
                                    <font class="small">Eine kurze Einleitung zum Pressebericht.</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("intro", "", 408, 75, "", false).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Ein kleiner Auszug aus dem vorgestellten Pressebericht.</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("text", "", 330, 150).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Anmerkungen: <font class="small">'.$admin_phrases[common][optional].'</font><br />
                                    <font class="small">Anmerkungen zum Pressebericht.<br />
                                    (z.B. die Wertung eines Tests)</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("note", "", 408, 75, "", false).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Spiel:<br>
                                    <font class="small">Spiel, auf das sich der Artikel bezieht.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="game" size="1" class="text">';

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin
                          WHERE type = '1' ORDER BY title", $db);
    while ($game_arr = mysql_fetch_assoc($index))
    {
        echo'<option value="'.$game_arr[id].'">'.$game_arr[title].'</option>';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kategorie:<br>
                                    <font class="small">Die Kategorie, der der Artikel angeh&ouml;rt.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="cat" size="1" class="text">';

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin
                          WHERE type = '2' ORDER BY title", $db);
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        echo'<option value="'.$cat_arr[id].'">'.$cat_arr[title].'</option>';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Sprache:<br>
                                    <font class="small">Sprache, in der der Artikel verfasst wurde.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="lang" size="1" class="text">';

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."press_admin
                          WHERE type = '3' ORDER BY title", $db);
    while ($lang_arr = mysql_fetch_assoc($index))
    {
        echo'<option value="'.$lang_arr[id].'">'.$lang_arr[title].'</option>';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td></td>
                                <td align="left">
                                    <input class="button" type="submit" value="Pressebericht hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>