<?php

//////////////////////////////
/// Partnerseite editieren ///
//////////////////////////////

if (isset($_POST[name]))
{
    $_POST[name] = savesql($_POST[name]);
    $_POST[link] = savesql($_POST[link]);
    $_POST[beschreibung] = addslashes($_POST[beschreibung]);
    $_POST[beschreibung] = ereg_replace ("&lt;textarea&gt;", "<textarea>", $_POST[beschreibung]); 
    $_POST[beschreibung] = ereg_replace ("&lt;/textarea&gt;", "</textarea>", $_POST[beschreibung]); 
    settype($_POST[partnerid], 'integer'); 
    settype($_POST[editpartnerid], 'integer');
    $_POST[permanent] = isset($_POST[permanent]) ? 1 : 0;

    if ($_POST[delpartner])   // Partnerseite löschen
    {
        mysql_query("DELETE FROM fs_partner WHERE partner_id = '$_POST[editpartnerid]'", $db);
        image_delete("../images/partner/", $_POST[editpartnerid]."_small");
        image_delete("../images/partner/", $_POST[editpartnerid]."_big");
        systext('Die Partnerseite wurde gelöscht');
    }
    else   // Partnerseite editieren
    {
        $update = "UPDATE fs_partner
                   SET partner_name = '$_POST[name]',
                       partner_link = '$_POST[link]',
                       partner_beschreibung = '$_POST[beschreibung]',
                       partner_permanent = '$_POST[permanent]'
                   WHERE partner_id = '$_POST[editpartnerid]'";
        mysql_query($update, $db);
        systext("Die Partnerseite wurde editiert");
    }
}

//////////////////////////////
/// Partnerseite anzeigen ////
//////////////////////////////

elseif (isset($_POST[partnerid]))
{
    settype($_POST[partnerid], 'integer');

    $index = mysql_query("SELECT * FROM fs_partner WHERE partner_id = $_POST[partnerid]", $db);
    $partner_arr = mysql_fetch_assoc($index);
        
    // permanent anzuzeigen?
    $partnerpermanent = ($partner_arr[partner_permanent] == 1) ? 'checked="checked"' : '';

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="partneredit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$partnerid.'" name="editpartnerid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild klein:<br>
                                    <font class="small">Kleiner Partnerbutton für rechtes Men&uuml;.</font>
                                </td>
                                <td class="config" valign="top">
                                   <img src="'.image_url("../images/partner/", $_POST[partnerid]."_small").'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bild groß:<br>
                                    <font class="small">Gro&szlig; Partnerbutton für die Übersicht.</font>
                                </td>
                                <td class="config" valign="top">
                                   <img src="'.image_url("../images/partner/", $_POST[partnerid]."_big").'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Partnername:<br>
                                    <font class="small">Name der Partnerseite.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="name" size="33" value="'.$partner_arr[partner_name].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Link:<br>
                                    <font class="small">Link zur Partnerseite.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="link" size="50" value="'.$partner_arr[partner_link].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Beschreibung:<br>
                                    <font class="small">Kurze Beschreibung der Partnerseite.</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("beschreibung", $partner_arr[partner_beschreibung], 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Permanent angezeigt:<br>
                                    <font class="small">Diesen Partnerbutton permanent anzeigen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="permanent" '.$partnerpermanent.'>    
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Partnerseite löschen:<br>
                                    <font class="small">Das Ändern der Bilder ist nur über Löschen und Neuanlegen möglich.</font>
                                </td>
                                <td class="config">
                                   <input onClick=\'delalert ("delpartner", "Soll die Partnerseite wirklich gelöscht werden?")\' type="checkbox" name="delpartner" id="delpartner" value="1">
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

//////////////////////////////
/// Partnerseite auswählen ///
//////////////////////////////
else
{
        echo'
                    <form action="" method="post">
                        <input type="hidden" value="partneredit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="70%">
                                    Partnerseite
                                </td>
                                <td class="config" width="30%">
                                    bearbeiten
                                </td>
                            </tr>
        ';
        $index = mysql_query("SELECT partner_id, partner_name FROM fs_partner ORDER BY partner_name", $db);
        while ($partner_arr = mysql_fetch_assoc($index))
        {
            echo'
                            <tr>
                                <td class="configthin">
                                    '.$partner_arr[partner_name].'
                                </td>
                                <td class="configthin">
                                    <input type="radio" name="partnerid" value="'.$partner_arr[partner_id].'">
                                </td>
                            </tr>
            ';
                }
        echo'
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                   <input class="button" type="submit" value="editieren">
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
}
?>