<?php

/////////////////////////////////
//// Datenbank aktualisieren ////
/////////////////////////////////

if (isset($_POST[change]))
{
    $_POST[text] = addslashes($_POST[text]);

    mysql_query("UPDATE fs_announcement SET text = '$_POST[text]'", $db);

    systext("Ankündigung wurde editiert");
}

/////////////////////////////////
/////// Formular erzeugen ///////
/////////////////////////////////

else
{
    $index = mysql_query("SELECT text FROM fs_announcement", $db);
    $text = stripslashes(mysql_result($index, 0, "text"));

    echo'
                    <form action="'.$PHP_SELF.'" method="post">
                        <input type="hidden" value="1" name="change">
                        <input type="hidden" value="allannouncement" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Ankündigung:<br>
                                    <font class="small">Leer lassen für keine. HTML ist erlaubt</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="15" cols="66" name="text">'.$text.'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>