<?php

//////////////////////////////
//// Kategorie hinzufügen ////
//////////////////////////////

if (isset($_POST['cat_name']))
{
    $_POST['cat_name'] = savesql($_POST['cat_name']);
    $_POST['cat_type'] = intval($_POST['cat_type']);
    $_POST['cat_visibility'] = intval($_POST['cat_visibility']);

    $time = time();
    mysql_query('INSERT INTO '.$FD->config('pref')."screen_cat (cat_name, cat_type, cat_visibility, cat_date)
                 VALUES ('".$_POST['cat_name']."',
                         '".$_POST['cat_type']."',
                         '".$_POST['cat_visibility']."',
                         '$time')", $FD->sql()->conn() );
    systext('Kategorie wurde hinzugef&uuml;gt');
}

//////////////////////////////
///// Kategorie Formular /////
//////////////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="gallery_newcat" name="go">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Name:<br>
                                    <font class="small">Name der neuen Kategorie</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="cat_name" size="33" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Art:<br>
                                    <font class="small">Kategorie-Typ</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="cat_type" size="1">
                                        <option value="1">Screenshots / Zufallsbild</option>
                                        <option value="2">Wallpaper</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Sichtbarkeit:<br>
                                    <font class="small">Wird die Kategorie angezeigt</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="cat_visibility" size="1">
                                        <option value="1">vollst&auml;ndig sichtbar</option>
                                        <option value="2">nicht in Auswahl verf&uuml;gbar</option>
                                        <option value="0">nicht aufrufbar</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="button" type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
