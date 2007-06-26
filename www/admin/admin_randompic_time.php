<?php

///////////////////////////
//// Auswahl speichern ////
///////////////////////////

if ($_POST['sended'])
{
    while (list($key, $val) = each($_POST['randompic_cat']))
    {
        mysql_query("UPDATE fs_screen_random
                     SET potm = '$val'
                     WHERE cat_id = '$key'", $db);
    }
    systext("Einstellungen wurden gespeichert!");
}

////////////////////////
/// Eingabeformular ////
////////////////////////
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
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
    $index = mysql_query("select * from fs_screen_random a inner join fs_screen b order by a.end desc", $db);
    while ($random_arr = mysql_fetch_assoc($index))
    {
	$random_arr['start'] = date("d.m.Y H:i", $random_arr['start']);
        $random_arr['end'] = date("d.m.Y H:i", $random_arr['end']);
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
                                    '.$cat_arr['end'].'
                                </td>
                                <td class="configthin">
                                    <input type="checkbox" name="randompic_time['.$random_arr['random_id'].']" value="1"';
                                        echo'
                                    >
                                </td>
                            </tr>

        ';
    }
    echo'                   <tr>
                                <td colspan="2" align="center">
                                    <input class="button" type="submit" value="Auswahl speichern">
				</td>
				<td colspan="2" align="center">
				    <input type="button" onClick=\'open("admin/admin_findpicture.php","Bild","width=500,height=500,screenX=50,screenY=50,scrollbars=YES")\' class="button" value="Hinzuf&uuml;gen">
				</td>
                            </tr>
                        </table>
                    </form>';
?>
