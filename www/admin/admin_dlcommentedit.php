<?php
/*
    Frogsystem Download comments - admin script
    Copyright (C) 2006-2007  Stefan Bollmann
    Copyright (C) 2012       Thoronador (adjustments for alix5)

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

if (isset($_POST['title']) && isset($_POST['text']))
{
    settype($_POST['ecommentid'], 'integer');

    if (!isset($_POST['delcomment']))
    {
        settype($_POST['commentposterid'], 'integer');
        $_POST['title'] = savesql($_POST['title']);
        $_POST['text'] = savesql($_POST['text']);

        $update = 'UPDATE `'.$global_config_arr['pref']."comments`
                   SET comment_title     = '".$_POST['title']."',
                       comment_text      = '".$_POST['text']."'
                   WHERE comment_id = ".$_POST['ecommentid']." AND content_type='dl'";
        mysql_query($update, $db);
        echo mysql_error($db);
        systext('Der Kommentar wurde editiert.');
    }
    else
    {
        mysql_query('DELETE FROM `'.$global_config_arr['pref'].'comments` WHERE comment_id = '.$_POST['ecommentid']." AND content_type='dl' LIMIT 1", $db);
        if (mysql_affected_rows($db)>0)
        {
          mysql_query('UPDATE fs_counter SET comments = comments - 1', $db);
          systext('Der Kommentar wurde gel&ouml;scht.');
        }
        else
        {
          systext('Der Kommentar wurde <i>nicht</i> gel&ouml;scht!');
        }
    }
}

/////////////////////////////
//// Kommentar Formular /////
/////////////////////////////

if (isset($_POST['commentid']))
{
    settype($_POST['commentid'], 'integer');
    $index = mysql_query('SELECT * FROM `'.$global_config_arr['pref'].'comments` WHERE comment_id = '.$_POST['commentid']." AND content_type='dl'", $db);
    $comment_arr = mysql_fetch_assoc($index);
	echo mysql_error();
    // Falls registrierter User, Name ermitteln
    if ($comment_arr['comment_poster_id'] != 0)
    {
        $index = mysql_query('SELECT user_name FROM `'.$global_config_arr['pref'].'user` WHERE user_id = '.$comment_arr['comment_poster_id'], $db);
        $comment_arr['comment_poster'] = mysql_result($index, 0, 'user_name');
    }

    $comment_arr['comment_date'] = date('d.m.Y' , $comment_arr['comment_date']) . ' um ' . date('H:i' , $comment_arr['comment_date']);

    // FS/HTML Code aktiv?
    $index = mysql_query('SELECT html_code, fs_code FROM `'.$global_config_arr['pref'].'news_config`', $db);
    $config_arr = mysql_fetch_assoc($index);
    $config_arr['html_code'] = ($config_arr['html_code'] == 3) ? 'an' : 'aus';
    $config_arr['fs_code'] = ($config_arr['fs_code'] == 3) ? 'an' : 'aus';

    echo'
                    <form action="'.$_SERVER['PHP_SELF'].'" method="post">
                        <input type="hidden" value="dlcommentedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$comment_arr['comment_id'].'" name="ecommentid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Der Kommentar wurde geschreiben am</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr['comment_date'].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Poster:<br>
                                    <font class="small">Diese Person hat das Kommentar geschreiben</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr['comment_poster'].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Titel des Kommentars</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="33" name="title" value="'.$comment_arr['comment_title'].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">HTML ist '.$config_arr['html_code'].'. FS-Code ist '.$config_arr['fs_code'].'</font>
                                </td>
                                <td valign="top">
                                    <textarea rows="8" cols="66" name="text">'.$comment_arr['comment_text'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Kommentar l&ouml;schen:
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
