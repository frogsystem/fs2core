<?php

////////////////////////////
//// News aktualisieren ////
////////////////////////////

if ($_POST[newsedit] && $_POST[title] && $_POST[text])
{
    settype($_POST[enewsid], 'integer');

    if (isset($_POST[delnews]))
    {
        mysql_query("DELETE FROM fs_news WHERE news_id = '$_POST[enewsid]'", $db);
        mysql_query("DELETE FROM fs_news_comments WHERE news_id = '$_POST[enewsid]'", $db);
        $numcomments = mysql_affected_rows();
        mysql_query("DELETE FROM fs_news_links WHERE news_id = '$_POST[enewsid]'", $db);
        mysql_query("UPDATE fs_counter SET news = news - 1", $db);
        mysql_query("UPDATE fs_counter SET comments = comments - $numcomments", $db);
        systext("Die News wurde gelöscht");
    }
    else
    {
        settype($_POST[catid], 'integer');
        settype($_POST[posterid], 'integer');
        $_POST[title] = savesql($_POST[title]);
        $_POST[text] = addslashes($_POST[text]);

        $newsdate = mktime($_POST[stunde], $_POST[min], 0, $_POST[monat], $_POST[tag], $_POST[jahr]);

        // News in der DB aktualisieren
        $update = "UPDATE fs_news
                   SET cat_id       = '$_POST[catid]',
                       user_id      = '$_POST[posterid]',
                       news_date    = '$newsdate',
                       news_title   = '$_POST[title]',
                       news_text    = '$_POST[text]'
                   WHERE news_id = $_POST[enewsid]";
        mysql_query($update, $db);

        // Links in der DB aktualisieren
        for ($i=0; $i<count($_POST[linkname]); $i++)
        {
            $_POST[linktarget][$i] = isset($_POST[linktarget][$i]) ? 1 : 0;

            // Link löschen
            if (isset($_POST[dellink][$i]))
            {
                settype($_POST[dellink][$i], 'integer');
                mysql_query("DELETE FROM fs_news_links WHERE link_id = " . $_POST[dellink][$i], $db);
            }
            else
            {
                $_POST[linkname][$i] = savesql($_POST[linkname][$i]);
                $_POST[linkurl][$i] = savesql($_POST[linkurl][$i]);
                settype($_POST[linkid][$i], "integer");

                // Link erzeugen
                if (!$_POST[linkid][$i] && $_POST[linkname][$i])
                {
                    mysql_query("INSERT INTO fs_news_links (news_id, link_name, link_url, link_target)
                                 VALUES ('".$_POST[enewsid]."',
                                         '".$_POST[linkname][$i]."',
                                         '".$_POST[linkurl][$i]."',
                                         '".$_POST[linktarget][$i]."');", $db);
                }
                // Link aktualisieren
                else
                {
                    $update = "UPDATE fs_news_links
                               SET link_name   = '".$_POST[linkname][$i]."',
                                   link_url    = '".$_POST[linkurl][$i]."',
                                   link_target = '".$_POST[linktarget][$i]."'
                               WHERE link_id = ".$_POST[linkid][$i];
                    mysql_query($update, $db);
                }
            }
        }
        systext("Die News wurde editiert");
    }
}

////////////////////////////
////// News editieren //////
////////////////////////////

elseif ($_POST[newsid] OR $_POST[tempid])
{
    if (isset($_POST[tempid]))
    {
        $_POST[newsid] = $_POST[tempid];
    }
    settype($_POST[newsid], 'integer');

    $index = mysql_query("SELECT * FROM fs_news WHERE news_id = '$_POST[newsid]'", $db);
    if (!isset($_POST[title]))
    {
        $_POST[title] = mysql_result($index, 0, "news_title");
    }
    $userid = mysql_result($index, 0, "user_id");
    $dbnewsdate = mysql_result($index, 0, "news_date");
    if (!isset($_POST[tag]))
    {
        $_POST[tag] = date("d", $dbnewsdate);
    }
    if (!isset($_POST[monat]))
    {
        $_POST[monat] = date("m", $dbnewsdate);
    }
    if (!isset($_POST[jahr]))
    {
        $_POST[jahr] = date("Y", $dbnewsdate);
    }
    if (!isset($_POST[stunde]))
    {
        $_POST[stunde] = date("H", $dbnewsdate);
    }
    if (!isset($_POST[min]))
    {
       $_POST[min] = date("i", $dbnewsdate);
    }
    if (!isset($_POST[catid]))
    {
       $_POST[catid] = mysql_result($index, 0, "cat_id");
    }
    if (!isset($_POST[text]))
    {
       $_POST[text] = stripslashes(mysql_result($index, 0, "news_text"));
    }

    // User auslesen
    $index = mysql_query("SELECT user_name, user_id FROM fs_user WHERE user_id = $userid", $db);
    if (!isset($_POST[poster]))
    {
        $_POST[poster] = mysql_result($index, 0, "user_name");
    }
    if (!isset($_POST[posterid]))
    {
        $_POST[posterid] = mysql_result($index, 0, "user_id");
    }

    // News Konfiguration lesen
    $index = mysql_query("SELECT html_code, fs_code FROM fs_news_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    $config_arr[html_code] = ($config_arr[html_code] > 1) ? "an" : "aus";
    $config_arr[fs_code] = ($config_arr[fs_code] > 1) ? "an" : "aus";

    // Links einlesen
    $index = mysql_query("SELECT * FROM fs_news_links WHERE news_id = '$_POST[newsid]' ORDER BY link_id", $db);
    $rows = mysql_num_rows($index);
    for($i=0; $i<$rows; $i++)
    {
        if (!isset($_POST[linkname][$i]))
        {
            $_POST[linkname][$i] = mysql_result($index, $i, "link_name");
        }
        if (!isset($_POST[linkurl][$i]))
        {
            $_POST[linkurl][$i] = mysql_result($index, $i, "link_url");
        }
        if (!isset($_POST[linkid][$i]))
        {
            $_POST[linkid][$i] = mysql_result($index, $i, "link_id");
        }
        if (!isset($_POST[linktarget][$i]))
        {
            $_POST[linktarget][$i] = mysql_result($index, $i, "link_target");
        }
    }

    if (!isset($_POST[options]))
    {
        $_POST[options] = count($_POST[linkname]);
    }
    $_POST[options] += $_POST[optionsadd];
    if ($_POST[options] < 0)
    {
        $_POST[options] = 0;
    }

    echo'
                    <form id="form" action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="newsedit" name="go">
                        <input id="send" type="hidden" value="0" name="newsedit">
                        <input type="hidden" value="'.$_POST[newsid].'" name="tempid">
                        <input type="hidden" value="'.$_POST[options].'" name="options">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$_POST[newsid].'" name="enewsid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr valign="top">
                                <td class="config">
                                    News löschen:
                                </td>
                                <td class="config">
                                    <input onClick="alert(this.value)" type="checkbox" name="delnews" value="Sicher?">
                                    <br /><br /><br />
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="30%">
                                    Kategorie:<br>
                                    <font class="small">Die News gehört zur Kategorie</font>
                                </td>
                                <td class="config" width="70%" valign="top">
                                    <select name="catid">
    ';

    // Kategorien auslesen
    $index = mysql_query("SELECT * FROM fs_news_cat", $db);
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        $sele = ($cat_arr[cat_id] == $_POST[catid]) ? "selected" : "";
        echo'
                                        <option value="'.$cat_arr[cat_id].'" '.$sele.'>'.$cat_arr[cat_name].'</option>
        ';
    }
    $_POST[title] = killhtml($_POST[title]);
    $_POST[text] = killhtml($_POST[text]);
    $_POST[title] = stripslashes($_POST[title]);
    $_POST[text] = stripslashes($_POST[text]);
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Die News erscheint am</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="2" value="'.$_POST[tag].'" name="tag" maxlength="2">
                                    <input class="text" size="2" value="'.$_POST[monat].'" name="monat" maxlength="2">
                                    <input class="text" size="4" value="'.$_POST[jahr].'" name="jahr" maxlength="4">
                                    <font class="small"> um </font>
                                    <input class="text" size="2" value="'.$_POST[stunde].'" name="stunde" maxlength="2">
                                    <input class="text" size="2" value="'.$_POST[min].'" name="min" maxlength="2">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    News Poster:<br>
                                    <font class="small">Verfasser der News</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" id="username" name="poster" value="'.$_POST[poster].'" maxlength="100" disabled>
                                    <input type="hidden" id="userid" name="posterid" value="'.$_POST[posterid].'">
                                    <input onClick=\'open("admin_finduser.php","Poster","width=360,height=300,screenX=50,screenY=50,scrollbars=YES")\' class="button" type="button" value="Ändern">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Diesen Titel bekommt die News</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="50" name="title" value="'.$_POST[title].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Html ist '.$config_arr[html_code].'. FScode ist '.$config_arr[fs_code].'</font>
                                </td>
                                <td valign="top">
                                    <textarea rows="8" cols="66" name="text">'.$_POST[text].'</textarea>
                                </td>
                            </tr>
    ';

    // Links ausgeben
    for($i=0; $i<$_POST[options]; $i++)
    {
        $j = $i + 1;
        if (isset($_POST[linkname][$i]))
        {
            $lcheck = ($_POST[linktarget][$i] == 1) ? "checked" : "";
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Link '.$j.':<br>
                                    <font class="small">Wird unter der News eingetragen<br>
                                    [Titel] [URL] [Neues Fenster] [löschen]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="22" name="linkname['.$i.']" value="'.stripslashes(killhtml($_POST[linkname][$i])).'" maxlength="100"><br />
                                    <input class="text" size="32" value="'.stripslashes(killhtml($_POST[linkurl][$i])).'" name="linkurl['.$i.']" maxlength="255">
                                    <input type="checkbox" name="linktarget['.$i.']" value="1" '.$lcheck.'><br />
                                    Löschen? <input name="dellink['.$i.']" value="'.$_POST[linkid][$i].'" type="checkbox">
                                    <input type="hidden" name="linkid['.$i.']" value="'.$_POST[linkid][$i].'">
                                </td>
                            </tr>
            ';
        }
        else
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Link '.$j.':<br>
                                    <font class="small">Wird unter der News eingetragen<br>
                                    [Titel] [URL] [Neues Fenster]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="22" name="linkname['.$i.']" maxlength="100"><br />
                                    <input class="text" size="32" name="linkurl['.$i.']" maxlength="255"> 
                                    <input type="checkbox" name="linktarget['.$i.']" value="1">
                                </td>
                            </tr>
            ';
        }

    }
    echo'
                            <tr>
                                <td class="configthin">
                                    &nbsp;
                                </td>
                                <td class="configthin">
                                    <input size="2" class="text" name="optionsadd">
                                    Linkfelder
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <br />
                                    <br />
                                    <input class="button" type="button" onClick="javascript:document.getElementById(\'send\').value=\'1\'; document.getElementById(\'form\').submit();" value="Änderungen Speichern">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

    // Kommentare anzeigen
    echo'
                    <br />
                    <hr />
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="commentedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td align="center" class="config" colspan="4">
                                    Kommentare<br /><br />
                                </td>
                            </tr>
                            <tr>
                                <td class="config" width="30%">
                                    Titel
                                </td>
                                <td class="config" width="30%">
                                    Poster
                                </td>
                                <td class="config" width="25%">
                                    Datum
                                </td>
                                <td class="config" width="15%">
                                    bearbeiten
                                </td>
                            </tr>
    ';

    // Kommentare auflisten
    $index = mysql_query("SELECT comment_id, comment_title, comment_date, comment_poster, comment_poster_id
                          FROM fs_news_comments
                          WHERE news_id = $_POST[newsid]
                          ORDER BY comment_date desc", $db);
    while ($comment_arr = mysql_fetch_assoc($index))
    {
        $dbcommentposterid = $comment_arr[comment_poster_id];
        if ($comment_arr[comment_poster_id] != 0)
        {
            $userindex = mysql_query("SELECT user_name FROM fs_user WHERE user_id = $comment_arr[comment_poster_id]", $db);
            $comment_arr[comment_poster] = mysql_result($userindex, 0, "user_name");
        }
        $comment_arr[comment_date] = date("d.m.Y" , $comment_arr[comment_date]) . " um " . date("H:i" , $comment_arr[comment_date]);
        echo'
                            <tr>
                                <td class="configthin">
                                    '.$comment_arr[comment_title].'
                                </td>
                                <td class="configthin">
                                    '.$comment_arr[comment_poster].'
                                </td>
                                <td class="configthin">
                                    '.$comment_arr[comment_date].'
                                </td>
                                <td class="configthin">
                                    <input type="radio" name="commentid" value="'.$comment_arr[comment_id].'">
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

////////////////////////////
////// News auswählen //////
////////////////////////////

else
{
    define(PERPAGE, 30);
    if (!isset($_GET[start]))
    {
        $_GET[start] = 0;
    }
    settype($_GET[start], "integer");
    $zeilen = PERPAGE + 1;
    $index = mysql_query("SELECT news_id, news_title, news_date
                          FROM fs_news
                          ORDER BY news_date DESC
                          LIMIT $_GET[start], $zeilen", $db);
    $rows = mysql_num_rows($index);

    // Mehr als PERPAGE Einträge pro seite?
    if ($rows > PERPAGE)
    {
        $start_num = $_GET[start] + PERPAGE;
        $next_page = '<a href="'.$PHP_SELF.'?go=newsedit&start='.$start_num.'&PHPSESSID='.session_id().'">weiter -></a>';
    }

    // Nicht die erste Seite?
    if ($_GET[start] > 0)
    {
        $start_num = ($_GET[start] > PERPAGE) ? ($_GET[start] - PERPAGE) : 0;
        $prev_page = '<a href="'.$PHP_SELF.'?go=newsedit&start='.$start_num.'&PHPSESSID='.session_id().'"><- zurück</a>';
    }

    // Aktueller Newsbereich
    $anfang = $_GET[start] + 1;
    $ende = $_GET[start] + $rows;
    if ($rows > PERPAGE)
    {
        $ende = $ende - 1;
    }
    $bereich = '<font class="small">'.$anfang.' ... '.$ende.'</font>';

    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="newsedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="40%">
                                    Titel
                                </td>
                                <td class="config" width="30%">
                                    Datum
                                </td>
                                <td class="config" width="20%">
                                    Kommentare
                                </td>
                                <td class="config" width="20%">
                                    bearbeiten
                                </td>
                            </tr>
    ';

    // News auslesen
    while ($news_arr = mysql_fetch_assoc($index))
    {
        $news_arr[news_date] = date("d.m.Y" , $news_arr[news_date]) . " um " . date("H:i" , $news_arr[news_date]);
        $cindex = mysql_query("SELECT comment_id FROM fs_news_comments WHERE news_id = $news_arr[news_id]", $db);
        $rows = mysql_num_rows($cindex);
        echo'
                            <tr>
                                <td class="configthin">
                                    '.$news_arr[news_title].'
                                </td>
                                <td class="configthin">
                                    '.$news_arr[news_date].'
                                </td>
                                <td class="configthin">
                                    '.$rows.'
                                </td>
                                <td class="configthin">
                                    <input type="radio" name="newsid" value="'.$news_arr[news_id].'">
                                </td>
                            </tr>
        ';
        $count += 1;
        if ($count == PERPAGE)
        {
            break;
        }
    }
    echo'
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td width="33%" class="configthin">
                                    '.$prev_page.'
                                </td>
                                <td width="33%">
                                    '.$bereich.'
                                </td>
                                <td width="33%" style="text-align:right;" class="configthin">
                                    '.$next_page.'
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
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