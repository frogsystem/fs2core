<?php

//////////////////////////////
/// Partnerseite editieren ///
//////////////////////////////

if ($_POST[small_x] && $_POST[small_y] && $_POST[big_x] && $_POST[big_y] && $_POST[partner_anzahl])
{
    settype($_POST[small_x], 'integer');
    settype($_POST[small_y], 'integer');
    settype($_POST[big_x], 'integer');
    settype($_POST[big_y], 'integer');
    settype($_POST[partner_anzahl], 'integer');
    $update = "UPDATE fs_partner_config
               SET partner_anzahl = '$_POST[partner_anzahl]',
                   small_x = '$_POST[small_x]',
                   small_y = '$_POST[small_y]',
                   small_allow = '$_POST[small_allow]',
                   big_x = '$_POST[big_x]',
                   big_y = '$_POST[big_y]',
                   big_allow = '$_POST[big_allow]'";
    mysql_query($update, $db);
    systext("Die Konfiguration wurde aktualisiert");
}

//////////////////////////////
/// Partnerseite anzeigen ////
//////////////////////////////

else
{

    $index = mysql_query("SELECT * FROM fs_partner_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="partnerconfig" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Anzahl:<br>
                                    <font class="small">Anzal der wechselnd angezeigten Partnerbuttons.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="partner_anzahl" size="1" value="'.$config_arr[partner_anzahl].'" maxlength="2">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="70%">
                                    Bildgröße kleine Bilder:<br>
                                    <font class="small">Stellt die Größe der kleinen Bilder ein.</font>
                                </td>
                                <td class="config" valign="top" width="30%">
                                    <input class="text" size="5" name="small_x" value="'.$config_arr[small_x].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="small_y" value="'.$config_arr[small_y].'" maxlength="4">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Kleine Bilder:<br>
                                    <font class="small">Eigenschaft der Größeneinstellung.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="small_allow">
                                        <option value="0"';
                                        if ($config_arr[small_allow] == 0)
                                            echo ' selected="selected"';
                                        echo'>müssen exakt diese Größe haben</option>
                                        <option value="1"';
                                        if ($config_arr[small_allow] == 1)
                                            echo ' selected="selected"';
                                        echo'>dürfen auch kleiner sein</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Bildgröße große Bilder:<br>
                                    <font class="small">Stellt die Größe der großen Bilder ein.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="big_x" value="'.$config_arr[big_x].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="big_y" value="'.$config_arr[big_y].'" maxlength="3">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Große Bilder:<br>
                                    <font class="small">Eigenschaft der Größeneinstellung.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="big_allow">
                                        <option value="0"';
                                        if ($config_arr[big_allow] == 0)
                                            echo ' selected="selected"';
                                        echo'>müssen exakt diese Größe haben</option>
                                        <option value="1"';
                                        if ($config_arr[big_allow] == 1)
                                            echo ' selected="selected"';
                                        echo'>dürfen auch kleiner sein</option>
                                    </select>
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