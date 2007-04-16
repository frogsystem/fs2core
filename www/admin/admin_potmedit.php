<?php

//////////////////////
//// POTM löschen ////
//////////////////////

if (isset($_POST[delpotm]))
{
    foreach ($_POST[delpotm] as $id)
    {
       settype($id, 'integer');
       mysql_query("DELETE FROM fs_potm WHERE potm_id = '$id'", $db);
       unlink("../images/potm/".$id."_s.jpg");
       unlink("../images/potm/".$id.".jpg");
    }
    systext('POTMs wurden gelöscht');
}

//////////////////////
/// POTMs anzeigen ///
//////////////////////

else
{
    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="potmedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="30%">
                                    Bild
                                </td>
                                <td class="config" width="50%">
                                    Bildunterschrift
                                </td>
                                <td class="config" width="20%">
                                    löschen
                                </td>
                            </tr>
    ';
    $index = mysql_query("SELECT * FROM fs_potm", $db);
    while ($potm_arr = mysql_fetch_assoc($index))
    {
        echo'
                            <tr>
                                <td class="config">
                                    <img src="../images/potm/'.$potm_arr[potm_id].'_s.jpg" width="50" height="37" alt="">
                                </td>
                                <td class="configthin">
                                    '.$potm_arr[potm_title].'
                                </td>
                                <td class="config">
                                    <input type="checkbox" name="delpotm[]" value="'.$potm_arr[potm_id].'">
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