<?php

///////////////////////////////
//// Partnerbild hochladen ////
///////////////////////////////

if (isset($_FILES['bild_small']) && isset($_FILES['bild_big']) && $_POST['name'] && $_POST['link'])
{
    $_POST[name] = savesql($_POST[name]);
    $_POST[link] = savesql($_POST[link]);
    $_POST[beschreibung] = addslashes($_POST[beschreibung]);
    $_POST[permanent] = isset($_POST[permanent]) ? 1 : 0;
    mysql_query("INSERT INTO fs_partner (partner_name,
                                         partner_link,
                                         partner_beschreibung,
                                         partner_permanent)
                 VALUES ('".$_POST[name]."',
                         '".$_POST[link]."',
                         '".$_POST[beschreibung]."',
                         '".$_POST[permanent]."')", $db);
                         
    $id = mysql_insert_id();

    $index = mysql_query("SELECT * FROM fs_partner_config", $db);
    $config_arr = mysql_fetch_assoc($index);

    $allow = false;
    if ($config_arr[small_allow] == 0)
        $allow = true;

    $upload1 = upload_img($_FILES['bild_small'], "../images/partner/", $id."_small", 2*1024*1024, $config_arr[small_x], $config_arr[small_y], 0, 0, false, 100, $allow);
    
    switch ($upload1)
    {
      case 0:
        $allow = false;
        if ($config_arr[big_allow] == 0)
            $allow = true;
        $upload2 = upload_img($_FILES['bild_big'], "../images/partner/", $id."_big", 2*1024*1024, $config_arr[big_x], $config_arr[big_y], 0, 0, false, 100, $allow);

        switch ($upload2)
        {
        case 0:
          systext ("Bilder wurden erfolgreich hochgeladen!");
          systext ("Partner wurde erfolgreich hinzugefügt!");
          break;
        default:
          systext ("Großes Bild: " . upload_img_notice($upload2));
          systext ("Partner wurde nicht hinzugefügt!");
          mysql_query("DELETE FROM fs_partner WHERE partner_id = '$id'");
          image_delete("../images/partner/", $id."_small");
        }
    
        break;
      default:
        systext ("Kleines Bild: " . upload_img_notice($upload1));
        systext ("Partner wurde nicht hinzugefügt!");
        mysql_query("DELETE FROM fs_partner WHERE partner_id = '$id'");
    }
    
    
    systext ("Weiteren Partner hinzufügen:");
    
}

//////////////////////////
//// Partner Formular ////
//////////////////////////

echo'
                    <form action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="partneradd" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Partnerbutton klein:<br>
                                    <font class="small">Button zum Hochladen für das rechte Men&uuml; ausw&auml;hlen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="bild_small" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Partnerbutton groß:<br>
                                    <font class="small">Button zum Hochladen für die &Uuml;bersichtsseite ausw&auml;hlen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="bild_big" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Partnername:<br>
                                    <font class="small">Name der Partnerseite.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="name" size="50" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Link:<br>
                                    <font class="small">Link zur Partnerseite.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="link" size="50" value="http://" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Beschreibung:<br>
                                    <font class="small">Kurze Beschreibung der Partnerseite.</font>
                                </td>
                                <td class="config" valign="top">
                                    <textarea rows="5" cols="66" name="beschreibung"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Permanent angezeigt:<br>
                                    <font class="small">Diesen Partnerbutton permanent anzeigen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" value="1" name="permanent">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>