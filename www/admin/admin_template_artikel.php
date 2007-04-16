<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[autor] && $_POST[body])
{
    $_POST[body] = addslashes($_POST[body]);
    $_POST[autor] = addslashes($_POST[autor]);

    mysql_query("update fs_template
                 set artikel_body = '$_POST[body]',
                     artikel_autor = '$_POST[autor]'
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
                            <input type="hidden" value="artikeltemplate" name="go">
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

    $index = mysql_query("select artikel_body from fs_template where id = '$_POST[design]'", $db);
    $body = stripslashes(mysql_result($index, 0, "artikel_body"));

    $index = mysql_query("select artikel_autor from fs_template where id = '$_POST[design]'", $db);
    $autor = stripslashes(mysql_result($index, 0, "artikel_autor"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="artikeltemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Autor:<br>
                                    <font class="small">Gültige Tags: '. fetchTemplateTags($autor) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="4" cols="66" name="autor">'.$autor.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'autor\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Body:<br>
                                    <font class="small">Gültige Tags: '. fetchTemplateTags($body) .'</font>
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