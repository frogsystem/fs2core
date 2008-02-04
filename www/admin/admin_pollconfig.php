<?php

/////////////////////////////////////
//// Konfiguration aktualisieren ////
/////////////////////////////////////

if ($_POST[answerbar_width])
{
    settype($_POST[answerbar_width], 'integer');
    settype($_POST[answerbar_type], 'integer');
    
    mysql_query("UPDATE ".$global_config_arr[pref]."poll_config
                 SET answerbar_width = '$_POST[answerbar_width]',
                     answerbar_type  = '$_POST[answerbar_type]'", $db);
    systext("Die Konfiguration wurde aktualisiert");
}

/////////////////////////////////////
////// Konfiguration Formular ///////
/////////////////////////////////////

else
{
    $index = mysql_query("select * from ".$global_config_arr[pref]."poll_config", $db);
    $config_arr = mysql_fetch_assoc($index);
 
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="pollconfig" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Antwortbalken - Breite:<br>
                                    <font class="small">Breite des Antwortbalkens bei 100% der Stimmen</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="answerbar_width" value="'.$config_arr[answerbar_width].'" maxlength="3">
                                    <select name="answerbar_type">
                                        <option value="0"';
                                        if ($config_arr[answerbar_type] == 0)
                                            echo ' selected="selected"';
                                        echo'>Pixel</option>
                                        <option value="1"';
                                        if ($config_arr[answerbar_type] == 1)
                                            echo ' selected="selected"';
                                        echo'>Prozent</option>
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