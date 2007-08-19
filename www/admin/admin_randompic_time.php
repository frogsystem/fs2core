<?php

///////////////////////////
//// Auswahl speichern ////
///////////////////////////

if ($_POST['sended'])
{
    while (list($key, $val) = each($_POST['randompic_time']))
    {
        settype($key, 'integer');
        mysql_query("DELETE FROM fs_screen_random WHERE random_id = '". $key ."'", $db);
    }
    systext("Einstellungen wurden gespeichert!");
}

////////////////////////
/// Eingabeformular ////
////////////////////////
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="randompic_time" name="go">
                        <input type="hidden" value="1" name="sended">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="30%">
                                    Name
                                </td>
                                <td class="config" width="30%">
                                    Startzeit
                                </td>
                                <td class="config" width="30%">
                                    Endzeit
                                </td>
                                <td class="config" width="10%">
                                    L&ouml;schen?
                                </td>
                            </tr>
    ';
    $index = mysql_query("SELECT * FROM fs_screen_random a INNER JOIN fs_screen b ON(a.screen_id = b.screen_id) ORDER BY a.end DESC", $db);
    while ($random_arr = mysql_fetch_assoc($index))
    {
        $random_arr['start'] = date("d.m.Y H:i", $random_arr['start']);
        $random_arr['end'] = date("d.m.Y H:i", $random_arr['end']);
        if(empty($random_arr['name'])) $random_arr['name'] = 'Kein Name';
        echo'
                            <tr>
                                <td class="configthin">
                                    '.$random_arr['name'].'
                                </td>
                                <td class="configthin">
                                    '.$random_arr['start'].'
                                </td>
                                </td>
                                <td class="configthin">
                                    '.$random_arr['end'].'
                                </td>
                                <td class="configthin">
                                    <input type="checkbox" name="deltimed['.$random_arr['random_id'].']" id="'.$random_arr['random_id'].'" value="1"onClick=\'delalert ("'.$random_arr['random_id'].'", "Soll das zeitgesteuerte Zufallsbild wirklich gelöscht werden?")\' />
                                </td>
                            </tr>

        ';
    }
    echo'                   <tr>
                                <td colspan="4" align="center">
                                    <input class="button" type="submit" value="Auswahl speichern">
                                </td>
                            </tr>
                        </table>
                    </form>';
?>