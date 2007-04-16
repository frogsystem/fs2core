<?php

//////////////////////
//// User löschen ////
//////////////////////

if ($_POST[deluser])
{
    foreach ($_POST[deluser] as $id)
    {
        settype($id, 'integer');
        mysql_query("DELETE FROM fs_cmap_user WHERE user_id = '$id'", $db);
    }
    systext('User wurden gelöscht');
}

//////////////////////
//// User anzeigen ///
//////////////////////

else
{
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="map" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="50%">
                                    Username
                                </td>
                                <td class="config" width="50%">
                                    Ort
                                </td>
                                <td class="config" width="20%">
                                    löschen
                                </td>
                            </tr>
    ';
    $index = mysql_query("SELECT user_id, user_name, user_ort
                          FROM fs_cmap_user
                          WHERE land_id = $_GET[landid]
                          ORDER BY user_name", $db);
    while($user_arr = mysql_fetch_assoc($index))
    {
        echo'
                            <tr style="cursor:pointer;"
                                onmouseover="javascript:this.style.backgroundColor=\'#DDDDDD\'"
                                onmouseout="javascript:this.style.backgroundColor=\'#EEEEEE\'">
                                <td class="configthin">
                                    '.utf8_decode($user_arr[user_name]).'
                                </td>
                                <td class="configthin">
                                    '.utf8_decode($user_arr[user_ort]).'
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="deluser[]" value="'.$user_arr[user_id].'">
                                </td>
                            </tr>
        ';
    }
    echo'
                            <tr>
                                <td colspan="3">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                    <input class="button" type="submit" value="Löschen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>