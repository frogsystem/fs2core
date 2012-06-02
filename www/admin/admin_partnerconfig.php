<?php

//////////////////////////////
/// Partnerseite editieren ///
//////////////////////////////

if ($_POST['small_x'] && $_POST['small_y'] && $_POST['big_x'] && $_POST['big_y'] && $_POST['file_size'] && ($_POST['partner_anzahl'] && $_POST['partner_anzahl']>0))
{
    settype($_POST['small_x'], 'integer');
    settype($_POST['small_y'], 'integer');
    settype($_POST['big_x'], 'integer');
    settype($_POST['big_y'], 'integer');
    settype($_POST['partner_anzahl'], 'integer');
    settype($_POST['file_size'], 'integer');
    $update = 'UPDATE '.$global_config_arr['pref']."partner_config
               SET partner_anzahl = '$_POST[partner_anzahl]',
                   small_x = '$_POST[small_x]',
                   small_y = '$_POST[small_y]',
                   small_allow = '$_POST[small_allow]',
                   big_x = '$_POST[big_x]',
                   big_y = '$_POST[big_y]',
                   big_allow = '$_POST[big_allow]',
                   file_size = '$_POST[file_size]'";
    mysql_query($update, $FD->sql()->conn() );
    systext('Die Konfiguration wurde aktualisiert.');
}

//////////////////////////////
/// Partnerseite anzeigen ////
//////////////////////////////

else
{

    $index = mysql_query('SELECT * FROM '.$global_config_arr['pref'].'partner_config', $FD->sql()->conn() );
    $config_arr = mysql_fetch_assoc($index);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="partner_config" name="go">
                        <table border="0" cellpadding="4" cellspacing="0" >
                            <tr><td colspan="2" class="line">Einstellungen</td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Anzahl zuf&auml;lliger Partner:<br />
                                    <font class="small">Anzahl der zus&auml;tzlich zuf&auml;llig angezeigten Partnerbuttons.<br />
                                    <b>Permanente Partner werden grunds&auml;tzlich immer angezeigt!</b></font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="partner_anzahl" size="1" value="'.$config_arr['partner_anzahl'].'" maxlength="2"> Partnerseiten
                                    <br /><font class="small">(0 ist nicht zul&auml;ssig)</font>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td colspan="2" class="line">Bilder</td></tr>
                            <tr>
                                <td class="config" valign="top" width="70%">
                                    Abmessungen kleine Bilder:<br>
                                    <font class="small">Stellt die Gr&ouml;&szlig;e der kleinen Bilder ein.</font>
                                </td>
                                <td class="config" valign="top" width="30%">
                                    <input class="text" size="5" name="small_x" value="'.$config_arr['small_x'].'" maxlength="4">
                                    x
                                    <input class="text" size="5" name="small_y" value="'.$config_arr['small_y'].'" maxlength="4"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Kleine Bilder:<br>
                                    <font class="small">Eigenschaft der Gr&ouml;&szlig;eneinstellung.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="small_allow">
                                        <option value="0"';
                                        if ($config_arr['small_allow'] == 0)
                                            echo ' selected="selected"';
                                        echo'>m&uuml;ssen exakt diese Gr&ouml;&szlig;e haben</option>
                                        <option value="1"';
                                        if ($config_arr['small_allow'] == 1)
                                            echo ' selected="selected"';
                                        echo'>d&uuml;rfen auch kleiner sein</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Abmessungen gro&szlig;e Bilder:<br>
                                    <font class="small">Stellt die Gr&ouml;&szlig;e der gro&szlig;en Bilder ein.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <input class="text" size="5" name="big_x" value="'.$config_arr['big_x'].'" maxlength="3">
                                    x
                                    <input class="text" size="5" name="big_y" value="'.$config_arr['big_y'].'" maxlength="3"> Pixel
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="50%">
                                    Gro&szlig;e Bilder:<br>
                                    <font class="small">Eigenschaft der Gr&ouml;&szlig;eneinstellung.</font>
                                </td>
                                <td class="config" valign="top" width="50%">
                                    <select name="big_allow">
                                        <option value="0"';
                                        if ($config_arr['big_allow'] == 0)
                                            echo ' selected="selected"';
                                        echo'>m&uuml;ssen exakt diese Gr&ouml;&szlig;e haben</option>
                                        <option value="1"';
                                        if ($config_arr['big_allow'] == 1)
                                            echo ' selected="selected"';
                                        echo'>d&uuml;rfen auch kleiner sein</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" width="70%">
                                    Dateigr&ouml;&szlig;e:<br>
                                    <font class="small">Dateigr&ouml;&szlig;e, bis zu der Bilder hochgeladen werden k&ouml;nnen.</font>
                                </td>
                                <td class="config" valign="top" width="30%">
                                    <input class="text" size="5" name="file_size" value="'.$config_arr['file_size'].'" maxlength="4"> KB
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button type="submit" value="" class="button_new">
                                        '.$admin_phrases['common']['arrow'].' '.$admin_phrases['common']['save_long'].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

?>
