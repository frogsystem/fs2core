<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if ($_POST[mini_login] ||
    $_POST[user_menu] ||
    $_POST[admin_link] ||
    $_POST[login] ||
    $_POST[profiledit] ||
    $_POST[profil] ||
    $_POST[register])
{
    $_POST[mini_login] = addslashes($_POST[mini_login]);
    $_POST[user_menu] = addslashes($_POST[user_menu]);
    $_POST[admin_link] = addslashes($_POST[admin_link]);
    $_POST[login] = addslashes($_POST[login]);
    $_POST[profiledit] = addslashes($_POST[profiledit]);
    $_POST[profil] = addslashes($_POST[profil]);
    $_POST[register] = addslashes($_POST[register]);

    mysql_query("update fs_template
                 set user_mini_login = '$_POST[mini_login]',
                     user_user_menu = '$_POST[user_menu]',
                     user_admin_link = '$_POST[admin_link]',
                     user_login = '$_POST[login]',
                     user_profiledit = '$_POST[profiledit]',
                     user_profil = '$_POST[profil]',
                     user_register = '$_POST[register]'
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
                            <input type="hidden" value="usertemplate" name="go">
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

    $index = mysql_query("select user_mini_login from fs_template where id = '$_POST[design]'", $db);
    $mini_login = stripslashes(mysql_result($index, 0, "user_mini_login"));

    $index = mysql_query("select user_user_menu from fs_template where id = '$_POST[design]'", $db);
    $user_menu = stripslashes(mysql_result($index, 0, "user_user_menu"));

    $index = mysql_query("select user_admin_link from fs_template where id = '$_POST[design]'", $db);
    $admin_link = stripslashes(mysql_result($index, 0, "user_admin_link"));

    $index = mysql_query("select user_login from fs_template where id = '$_POST[design]'", $db);
    $login = stripslashes(mysql_result($index, 0, "user_login"));

    $index = mysql_query("select user_profiledit from fs_template where id = '$_POST[design]'", $db);
    $profiledit = stripslashes(mysql_result($index, 0, "user_profiledit"));

    $index = mysql_query("select user_profil from fs_template where id = '$_POST[design]'", $db);
    $profil = stripslashes(mysql_result($index, 0, "user_profil"));

    $index = mysql_query("select user_register from fs_template where id = '$_POST[design]'", $db);
    $register = stripslashes(mysql_result($index, 0, "user_register"));

    echo'
                    <input type="hidden" value="" name="editwhat">
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="usertemplate" name="go">
                        <input type="hidden" value="'.$_POST[design].'" name="design">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Mini Login Menü:<br>
                                    <font class="small">Kleines Loginmenü im rechten Menü</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="mini_login">'.$mini_login.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'mini_login\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    User Menü:<br>
                                    <font class="small">User Links im rechten Menü<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($user_menu) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="10" cols="66" name="user_menu">'.$user_menu.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'user_menu\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    AdminCP Link:<br>
                                    <font class="small">Link zum Admin Menü im User Menü<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($admin_link) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="admin_link">'.$admin_link.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'admin_link\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Login Formular:<br>
                                    <font class="small">Login Formularseite</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="login">'.$login.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'login\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Profil editieren:<br>
                                    <font class="small">Formularseite um die Profildaten zu ändern<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($profiledit) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="profiledit">'.$profiledit.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'profiledit\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Profil:<br>
                                    <font class="small">Benutzer Profil<br>
                                    Gültige Tags:<br>
                                    '. fetchTemplateTags($profil) .'</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="profil">'.$profil.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'profil\')">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Registrieren:<br>
                                    <font class="small">Registrierungs Formular</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="20" cols="66" name="register">'.$register.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top"></td>
                                <td class="config" valign="top">
                                    <input type="button" class="button" Value="Editor" onClick="openedit(\'register\')">
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