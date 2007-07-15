<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST[user_per_page] && $_POST[user_per_page]!=0)
{
    settype($_POST[user_per_page], 'integer');
    
    $update = "UPDATE fs_userlist_config
               SET user_per_page = '$_POST[user_per_page]'
               WHERE id = 1";
    mysql_query($update, $db);
    systext("Die Konfiguration wurde aktualisiert");
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query("SELECT * FROM fs_userlist_config", $db);
    $config_arr = mysql_fetch_assoc($index);
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="userlist" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    User pro Seite:<br>
                                    <font class="small">Gibt die Anzahl an Bildern in einer Zeile an.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="2" name="user_per_page" value="'.$config_arr[user_per_page].'" maxlength="3"> User<br /><font class="small">(0 ist nicht zulässig)</font>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>