<?php

/////////////////////////////
//// Kommentar editieren ////
/////////////////////////////

if ($_POST[title] && $_POST[text])
{
    settype($_POST[ecommentid], 'integer');

    if (!isset($_POST[delcomment]))
    {
        settype($_POST[commentposterid], 'integer');
        settype($_POST[commentdate], 'integer');
        settype($_POST[newsid], 'integer');
        $_POST[title] = savesql($_POST[title]);
        $_POST[text] = savesql($_POST[text]);

        if ($_POST[commentposterid] != 0)
        {
            $_POST[commentposter] = "";
        }
        else
        {
            $_POST[commentposter] = savesql($_POST[commentposter]);
            $_POST[commentposterid] = 0;
        }

        $update = "UPDATE fs_news_comments
                   SET comment_id        = '$_POST[ecommentid]',
                       news_id           = '$_POST[newsid]',
                       comment_poster    = '$_POST[commentposter]',
                       comment_poster_id = '$_POST[commentposterid]',
                       comment_date      = '$_POST[commentdate]',
                       comment_title     = '$_POST[title]',
                       comment_text      = '$_POST[text]'
                   WHERE comment_id = $_POST[ecommentid]";
        mysql_query($update, $db);
        systext("Das Kommentar wurde editiert");
    }
    else
    {
        mysql_query("DELETE FROM fs_news_comments WHERE comment_id = $_POST[ecommentid]", $db);
        mysql_query("UPDATE fs_counter SET comments = comments - 1", $db);
        systext("Der Kommentar wurde gelöscht");
    }
}

/////////////////////////////
//// Kommentar Formular /////
/////////////////////////////

if (isset($_POST[commentid]))
{
    settype($_POST[commentid], 'integer');
    $index = mysql_query("SELECT * FROM fs_news_comments WHERE comment_id = $_POST[commentid]", $db);
    $comment_arr = mysql_fetch_assoc($index);

    // Falls registrierter User, Name ermitteln
    if ($comment_arr[comment_poster_id] != 0)
    {
        $index = mysql_query("select user_name from fs_user where user_id = $comment_arr[comment_poster_id]", $db);
        $comment_arr[comment_poster] = mysql_result($index, 0, "user_name");
    }

    $dbcommentdate = $comment_arr[comment_date];
    $comment_arr[comment_date] = date("d.m.Y" , $comment_arr[comment_date]) . " um " . date("H:i" , $comment_arr[comment_date]);
 
    // FS/HTML Code aktiv?
    $index = mysql_query("SELECT html_code, fs_code FROM fs_news_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    $config_arr[html_code] = ($config_arr[html_code] == 3) ? "an" : "aus";
    $config_arr[fs_code] = ($config_arr[fs_code] == 3) ? "an" : "aus";

    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="commentedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$_POST[commentid].'" name="ecommentid">
                        <input type="hidden" value="'.$comment_arr[comment_poster].'" name="commentposter">
                        <input type="hidden" value="'.$comment_arr[comment_poster_id].'" name="commentposterid">
                        <input type="hidden" value="'.$dbcommentdate.'" name="commentdate">
                        <input type="hidden" value="'.$comment_arr[news_id].'" name="newsid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr valign="top">
                                <td class="config">
                                    Kommentar löschen:
                                </td>
                                <td class="config">
                                    <input onClick=\'delalert ("delcomment","Soll der Kommentar wirklich gelöscht werden?")\' type="checkbox" name="delcomment" id="delcomment" value="1">
                                    <br /><br /><br />
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Das Kommentar wurde geschreiben am</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr[comment_date].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Poster:<br>
                                    <font class="small">Diese Person hat das Komemntar geschreiben</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr[comment_poster].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Titel des Kommentars</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="33" name="title" value="'.$comment_arr[comment_title].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Html ist '.$config_arr[html_code].'. FScode ist '.$config_arr[fs_code].'</font>
                                </td>
                                <td valign="top">
                                    <textarea rows="8" cols="66" name="text">'.$comment_arr[comment_text].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <br /><br />
                                    <input class="button" type="submit" value="Änderungen speichern">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>