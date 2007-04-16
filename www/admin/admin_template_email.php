<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[register] ||
    $_POST[passchange])
{
    $_POST[register] = addslashes($_POST[register]);
    $_POST[passchange] = addslashes($_POST[passchange]);

    mysql_query("update fs_template
                 set email_register = '$_POST[register]',
                     email_passchange = '$_POST[passchange]'
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
                            <input type="hidden" value="emailtemplate" name="go">
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

    $index = mysql_query("select email_register from fs_template where id = '$_POST[design]'", $db);
    $register = stripslashes(mysql_result($index, 0, "email_register"));

    $index = mysql_query("select email_passchange from fs_template where id = '$_POST[design]'", $db);
    $passchange = stripslashes(mysql_result($index, 0, "email_passchange"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="emailtemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Registrierung:<br>
                                    <font class="small">Gültige Tags: '. fetchTemplateTags($register) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="10" cols="66" name="register">'.$register.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'register\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Passwortänderung:<br>
                                    <font class="small">Gültige Tags: '. fetchTemplateTags($passchange) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="10" cols="66" name="passchange">'.$passchange.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'passchange\')">
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