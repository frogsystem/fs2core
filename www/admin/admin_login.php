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
            systext('Herzlich Willkommen im Admin-CP des Frogsystem 2!<br>Sie sind jetzt eingeloggt', 'Herzlich Willkommen!', FALSE, $admin_phrases[icons][ok]);
            break;
        case 1:
            systext('Der Benutzer existiert nicht', $admin_phrases[common][error], TRUE, $admin_phrases[icons][error] );
            break;
        case 2:
            systext('Das Passwort ist nicht korrekt',  $admin_phrases[common][error], TRUE, $admin_phrases[icons][error] );
            break;
        case 3:
            systext('Sie haben keine Rechte für diese Seite',  $admin_phrases[common][error], TRUE, $admin_phrases[icons][error] );
            break;
    }
}

////////////////////////////
///// Schon eingeloggt /////
////////////////////////////

elseif ($_SESSION[user_level] == "authorised")
{
    systext('Herzlich Willkommen im Admin-CP des Frogsystem 2!', 'Herzlich Willkommen!');
}

////////////////////////////
/////// Loginabfrage ///////
////////////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="login" value="1">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Benutzerdaten eingeben</td></tr>
                            <tr>
                                <td class="config" width="200">
                                    Name:
                                </td>
                                <td class="config">
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
                                    Angemeldet bleiben:
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="stayonline" value="1" checked>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' Einloggen
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

?>