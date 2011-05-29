<?php

////////////////////////////
/////// User prüfen ////////
////////////////////////////

if ( isset ( $_POST['username'] ) && isset ( $_POST['userpassword'] ) )
{
    $loggedin = admin_login($_POST['username'], $_POST['userpassword'], false);
    
    switch ($loggedin)
    {
        case 0:
            systext('Herzlich Willkommen im Admin-CP des Frogsystem 2!<br>Sie sind jetzt eingeloggt', 'Herzlich Willkommen!', FALSE, $TEXT['admin']->get("icon_login") );
            break;
        case 1:
            systext('Der Benutzer existiert nicht', $TEXT['admin']->get("error"), TRUE, $TEXT['admin']->get("icon_error") );
            break;
        case 2:
            systext('Das Passwort ist nicht korrekt', $TEXT['admin']->get("error"), TRUE, $TEXT['admin']->get("icon_error") );
            break;
        case 3:
            systext('Sie haben keine Rechte für diese Seite', $TEXT['admin']->get("error"), TRUE, $TEXT['admin']->get("icon_error") );
            break;
    }
}

////////////////////////////
///// Schon eingeloggt /////
////////////////////////////

elseif (is_authorized()) 
{
            systext('Herzlich Willkommen im Admin-CP des Frogsystem 2!', 'Herzlich Willkommen!', FALSE, $TEXT['admin']->get("icon_login") );
}

////////////////////////////
/////// Loginabfrage ///////
////////////////////////////

else
{
    echo'
                    <form action="?go=login" method="post">
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
                                        '.$admin_phrases['common']['arrow'].' Einloggen
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

?>
