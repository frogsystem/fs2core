<?php

///////////////////////////
//// Auswahl speichern ////
///////////////////////////

if ($_POST['sended'])
{
    while (list($key, $val) = each($_POST['randompic_cat']))
    {
        mysql_query("UPDATE ".$global_config_arr[pref]."screen_cat
                     SET randompic = '$val'
                     WHERE cat_id = '$key'", $FD->sql()->conn() );
    }
    systext("Einstellungen wurden gespeichert!");
}

////////////////////////
/// Eingabeformular ////
////////////////////////
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="randompic_cat" name="go">
                        <input type="hidden" value="1" name="sended">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="30%">
                                    Name
                                </td>
                                <td class="config" width="10%">
                                    Pics
                                </td>
                                <td class="config" width="20%">
                                    Sichtbarkeit
                                </td>
                                <td class="config" width="20%">
                                    erstellt am
                                </td>
                                <td class="config" width="20%">
                                    Zufallsbild-Kategorie
                                </td>
                            </tr>
    ';
    $index = mysql_query("select * from ".$global_config_arr[pref]."screen_cat WHERE cat_type != 2 order by cat_name asc", $FD->sql()->conn() );
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        $cat_arr[cat_date] = date("d.m.Y", $cat_arr[cat_date]);
        $screen_index = mysql_query("select cat_id from ".$global_config_arr[pref]."screen where cat_id = $cat_arr[cat_id]", $FD->sql()->conn() );
        $screen_rows = mysql_num_rows($screen_index);
        echo'
                            <input type="hidden" name="randompic_cat['.$cat_arr[cat_id].']" value="0">
                            <tr>
                                <td class="configthin">
                                    '.$cat_arr[cat_name].'
                                </td>
                                <td class="configthin">
                                    '.$screen_rows.'
                                </td>
                                <td class="configthin">';
                                    switch ($cat_arr[cat_visibility]) {
                                    case 0:
                                        echo "Nicht aufrufbar";
                                        break;
                                    case 1:
                                        echo "Sichtbar";
                                        break;
                                    case 2:
                                       echo "Nicht in Auswahl";
                                       break;
                                    }
                                    echo'
                                </td>
                                <td class="configthin">
                                    '.$cat_arr[cat_date].'
                                </td>
                                <td class="configthin">
                                    <input type="checkbox" name="randompic_cat['.$cat_arr[cat_id].']" value="1"';
                                        if ($cat_arr[randompic] == 1)
                                          echo ' checked=checked';
                                        echo'
                                    >
                                </td>
                            </tr>

        ';
    }
    echo'                   <tr>
                                <td colspan="5" align="center">
                                    <input class="button" type="submit" value="Auswahl speichern">
                                </td>
                            </tr>
                        </table>
                    </form>';
?>
