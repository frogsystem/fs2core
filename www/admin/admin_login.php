<?php

////////////////////////////
/////// User prüfen ////////
////////////////////////////

if ($_POST[username] &&
    $_POST[userpassword])
{
    $loggedin = admin_login($_POST[username], $_POST[userpassword], false);
    switch ($loggedin)
    {
        case 0:
            systext('Login war erfolgreich<br>Herzlich Willkommen im Admin-CP des Frogsystem 2');
            break;
        case 1:
            systext('Login fehlgeschlagen<br>Username existiert nicht');
            break;
        case 2:
            systext('Login fehlgeschlagen<br>Passwort inkorrekt');
            break;
        case 3:
            systext('Login fehlgeschlagen<br>Du hast keine Rechte für den Administartionsbereich');
            break;
    }
}

////////////////////////////
///// Schon eingeloggt /////
////////////////////////////

elseif ($_SESSION[user_level] == "authorised")
{
    systext('Herzlich Willkommen im Admin-CP des Frogsystem 2!');
}

////////////////////////////
/////// Loginabfrage ///////
////////////////////////////

else
{
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" name="login" value="1">
                        <table width="600" border="0" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="config" width="50%">
                                    Name:
                                </td>
                                <td class="config" width="50%">
                                    <input class="text" size="33" name="username" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Passwort:
                                </td>
                                <td class="config">
                                    <input class="text" size="33" type="password" name="userpassword" maxlength="16">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Angemeldet bleiben?:
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="stayonline" value="1" checked>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input class="button" type="submit" value="Login">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

?>