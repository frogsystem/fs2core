<?php
/*
    Frogsystem Download comments - admin script
    Copyright (C) 2007  Stefan Bollmann

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

    Additional permission under GNU GPL version 3 section 7

    If you modify this Program, or any covered work, by linking or combining it
    with Frogsystem 2 (or a modified version of Frogsystem 2), containing parts
    covered by the terms of Creative Commons Attribution-ShareAlike 3.0, the
    licensors of this Program grant you additional permission to convey the
    resulting work. Corresponding Source for a non-source form of such a
    combination shall include the source code for the parts of Frogsystem used
    as well as that of the covered work.
*/

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
        $_POST[dlid] = savesql($_POST[dlid]);
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

        $update = "UPDATE fsplus_dl_comments
                   SET dl_comment_id = '$_POST[ecommentid]',
                       dl_id   		 = '$_POST[dlid]',
                       comment_poster    = '$_POST[commentposter]',
                       comment_poster_id = '$_POST[commentposterid]',
                       comment_date      = '$_POST[commentdate]',
                       comment_title     = '$_POST[title]',
                       comment_text      = '$_POST[text]'
                   WHERE dl_comment_id = $_POST[ecommentid]";
        mysql_query($update, $db);
        systext('Der Kommentar wurde editiert');
    }
    else
    {
        mysql_query("DELETE FROM fsplus_dl_comments WHERE dl_comment_id = $_POST[ecommentid]", $db);
        mysql_query('UPDATE fs_counter SET comments = comments - 1', $db);
        systext('Der Kommentar wurde gelöscht');
    }
}

/////////////////////////////
//// Kommentar Formular /////
/////////////////////////////

if (isset($_POST[commentid]))
{
    settype($_POST[commentid], 'integer');
    $index = mysql_query("SELECT * FROM fsplus_dl_comments WHERE dl_comment_id = '$_POST[commentid]'", $db);
    $comment_arr = mysql_fetch_assoc($index);
	echo mysql_error();
    // Falls registrierter User, Name ermitteln
    if ($comment_arr[comment_poster_id] != 0)
    {
        $index = mysql_query("select user_name from fs_user where user_id = $comment_arr[comment_poster_id]", $db);
        $comment_arr[comment_poster] = mysql_result($index, 0, 'user_name');
    }

    $dbcommentdate = $comment_arr[comment_date];
    $comment_arr[comment_date] = date('d.m.Y' , $comment_arr[comment_date]) . ' um ' . date('H:i' , $comment_arr[comment_date]);

    // FS/HTML Code aktiv?
    $index = mysql_query('SELECT html_code, fs_code FROM fs_news_config', $db);
    $config_arr = mysql_fetch_assoc($index);
    $config_arr[html_code] = ($config_arr[html_code] == 3) ? 'an' : 'aus';
    $config_arr[fs_code] = ($config_arr[fs_code] == 3) ? 'an' : 'aus';

    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="dlcommentedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$comment_arr[dl_comment_id].'" name="ecommentid">
                        <input type="hidden" value="'.$comment_arr[comment_poster].'" name="commentposter">
                        <input type="hidden" value="'.$comment_arr[comment_poster_id].'" name="commentposterid">
                        <input type="hidden" value="'.$dbcommentdate.'" name="commentdate">
                        <input type="hidden" value="'.$comment_arr[dl_id].'" name="dlid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Der Kommentar wurde geschreiben am</font>
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
                                <td class="config">
                                    Kommentar löschen:
                                </td>
                                <td class="config">
                                    <input onClick="alert(this.value)" type="checkbox" name="delcomment" value="Sicher?">
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
?>