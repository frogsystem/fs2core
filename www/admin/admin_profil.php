<?php

//////////////////////////////
// Userdaten Aktualisieren ///
//////////////////////////////

if ($_SESSION[user_level] == "authorised")  // Wenn eingeloggt
{
    if ($_POST[new_user_mail])
    {
        if ($_POST[new_user_pass] == $_POST[new_user_pass_2])  // Beide Passwörter gleich oder leeres Feld
        {
            if ($_POST[new_user_pass]) // Neues Passwort setzen
            {
                $new_user_pass = md5($_POST[new_user_pass]);
                $update = "UPDATE ".$global_config_arr[pref]."user
                           SET user_password = '$new_user_pass'
                           WHERE user_id = $_SESSION[user_id]";
                mysql_query($update, $db);
            }
            $new_user_mail = savesql($_POST[new_user_mail]);
            $update = "UPDATE ".$global_config_arr[pref]."user
                       SET user_mail = '$new_user_mail'
                       WHERE user_id = $_SESSION[user_id]";
            mysql_query($update, $db);
            systext('Deine Daten wurden aktualisiert');
        }
        else
        {
            systext('Passwörter sind unterschiedlich');
        }
    }

//////////////////////////////
///// Userdaten Ausgeben /////
//////////////////////////////

    else
    {
        $non_html_username = killhtml($_SESSION[user_name]);
        echo'
                    <form action="" method="post">
                        <input type="hidden" value="profil" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                            <table border="0" cellpadding="4" cellspacing="0" width="600">
                                <tr>
                                    <td class="config" width="50%">
                                        Name:<br>
                                        <font class="small">Dein Username</font>
                                    </td>
                                    <td class="config" width="50%">
                                        '.$non_html_username.'
                                    </td>
                                </tr>
                                <tr>
                                    <td class="config">
                                        E-Mail:<br>
                                        <font class="small">Deine E-Mail Adresse</font>
                                    </td>
                                    <td class="config">
                                        <input class="text" size="33" name="new_user_mail" value="'.$_SESSION[user_mail].'" maxlength="100">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="config">
                                        Passwort:<br>
                                        <font class="small">Neues Passwort eingeben um altes zu ersetzen</font>
                                    </td>
                                    <td class="config">
                                        <input class="text" size="33" type="password" name="new_user_pass" maxlength="16">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="config">
                                        Passwort wiederholen:<br>
                                        <font class="small">Passwort zur sicherheit wiederholen</font>
                                    </td>
                                    <td class="config">
                                        <input class="text" size="33" type="password" name="new_user_pass_2" maxlength="16">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input class="button" type="submit" value="Absenden">
                                    </td>
                                </tr>
                            </table>
                        </form>
        ';
    }
}
else
{
    systext('Du bist nicht eingeloggt');
}
?>