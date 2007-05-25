<?php

/////////////////////////
//// News hinzufügen ////
/////////////////////////

if ($_POST[newsadd] && $_POST[title] && $_POST[text])
{
    $newsdate = mktime($_POST[stunde], $_POST[min], 0, $_POST[monat], $_POST[tag], $_POST[jahr]);
  
    // News in die DB eintragen
    settype($_POST[catid], 'integer');
    settype($_POST[posterid], 'integer');
    $_POST[title] = savesql($_POST[title]);
    $_POST[text] = addslashes($_POST[text]);
    mysql_query("INSERT INTO fs_news (cat_id, user_id, news_date, news_title, news_text)
                 VALUES ('".$_POST[catid]."',
                         '".$_POST[posterid]."',
                         '$newsdate',
                         '".$_POST[title]."',
                         '".$_POST[text]."');", $db);

    // Links in die DB eintragen
    $index = mysql_query("SELECT news_id FROM fs_news WHERE news_title = '".$_POST[title]."'");
    $id = mysql_result($index, 0, "news_id");
    for ($i=0; $i<count($_POST[linkname]); $i++)
    {
        $_POST[linkname][$i] = savesql($_POST[linkname][$i]);
        $_POST[linkurl][$i] = savesql($_POST[linkurl][$i]);
        $_POST[linktarget][$i] = isset($_POST[linktarget][$i]) ? 1 : 0;

        if ($_POST[linkname][$i] != "")
        {
            mysql_query("INSERT INTO fs_news_links (news_id, link_name, link_url, link_target)
                         VALUES ('$id',
                                 '".$_POST[linkname][$i]."',
                                 '".$_POST[linkurl][$i]."',
                                 '".$_POST[linktarget][$i]."');", $db);
        }
    }

    mysql_query("UPDATE fs_counter SET news = news + 1", $db);
    systext("News wurde hinzugefügt");
}

/////////////////////////
///// News Formular /////
/////////////////////////

else
{
    if (!isset($_POST[tag]))
    {
        $_POST[tag] = date("d");
    }
    if (!isset($_POST[monat]))
    {
        $_POST[monat] = date("m");
    }
    if (!isset($_POST[jahr]))
    {
        $_POST[jahr] = date("Y");
    }
    if (!isset($_POST[stunde]))
    {
        $_POST[stunde] = date("H");
    }
    if (!isset($_POST[min]))
    {
        $_POST[min] = date("i");
    }

    if (!isset($_POST[posterid]))
    {
        $_POST[posterid] = $_SESSION[user_id];
    }
    // User auslesen
    $index = mysql_query("SELECT user_name, user_id FROM fs_user WHERE user_id = $_POST[posterid]", $db);
    if (!isset($_POST[poster]))
    {
        $_POST[poster] = mysql_result($index, 0, "user_name");
    }

    // News Konfiguration lesen
    $index = mysql_query("SELECT html_code, fs_code FROM fs_news_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    $config_arr[html_code] = ($config_arr[html_code] > 1) ? "an" : "aus";
    $config_arr[fs_code] = ($config_arr[fs_code] > 1) ? "an" : "aus";

    if (!isset($_POST[options]))
    {
        $_POST[options] = 2;
    }
    $_POST[options] += $_POST[optionsadd];
    if ($_POST[options] < 0)
    {
        $_POST[options] = 0;
    }

    echo'
                    <form id="form" action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="newsadd" name="go">
                        <input id="send" type="hidden" value="0" name="newsadd">
                        <input type="hidden" value="'.$_POST[options].'" name="options">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="30%">
                                    Kategorie:<br>
                                    <font class="small">Die News gehört zur Kategorie</font>
                                </td>
                                <td class="config" width="70%" valign="top">
                                    <select name="catid">
    ';

    // Kategorien auflisten
    $index = mysql_query("SELECT * FROM fs_news_cat", $db);
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        $catcheck = ($_POST[catid] == $cat_arr[cat_id]) ? "selected" : "";
        echo'
                                        <option value="'.$cat_arr[cat_id].'" '.$catcheck.'>'.$cat_arr[cat_name].'</option>
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
                                    <input onClick=\'open("admin/admin_finduser.php","Poster","width=360,height=300,screenX=50,screenY=50,scrollbars=YES")\' class="button" type="button" value="Ändern">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Diesen Titel bekommt die News</font>
                                </td>
                                <td class="config" valign="top">
                                    <input value="'.$_POST[title].'" class="text" size="50" name="title" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Html ist '.$config_arr[html_code].'. FScode ist '.$config_arr[fs_code].'</font>
                                </td>
                                <td valign="top" align="left">
                                    '.code_textarea("text", $_POST[text], 328, 130).'
                                </td>
                            </tr>
    ';

    // Linkfelder generieren
    for ($i=1; $i<$_POST[options]+1; $i++)
    {
        $j = $i - 1;
        if (isset($_POST[linkname][$j]))
        {
            $lcheck = ($_POST[linktarget][$j] == 1) ? "checked" : "";
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Link '.$i.':<br>
                                    <font class="small">Wird unter der News eingetragen<br>[Titel] [URL] [Neues Fenster]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="23" name="linkname['.$j.']" value="'.stripslashes(killhtml($_POST[linkname][$j])).'" maxlength="100"><br />
                                    <input class="text" size="35" value="'.stripslashes(killhtml($_POST[linkurl][$j])).'" name="linkurl['.$j.']" maxlength="255">
                                    <input type="checkbox" name="linktarget['.$j.']" value="1" '.$lcheck.'>
                                </td>
                            </tr>
            ';
        }
        else
        { 
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Link '.$i.':<br>
                                    <font class="small">Wird unter der News eingetragen<br>[Titel] [URL] [Neues Fenster]</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="23" name="linkname['.$j.']" maxlength="100"><br />
                                    <input class="text" size="35" name="linkurl['.$j.']" maxlength="255"> 
                                    <input type="checkbox" name="linktarget['.$j.']" value="1">
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
                                <td colspan="2" align="center"><br /><br />
                                    <input class="button" type="button" onClick="javascript:document.getElementById(\'send\').value=\'1\'; document.getElementById(\'form\').submit();" value="News eintragen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>