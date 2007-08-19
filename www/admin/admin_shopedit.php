<?php

////////////////////////////////
//// Artikel aktualiesieren ////
////////////////////////////////

if ($_POST[title] && $_POST[url] && $_POST[preis])
{
    settype($_POST[editartikelid], 'integer');
    if (isset($_POST[delartikel]))
    {
        mysql_query("DELETE FROM fs_shop WHERE artikel_id = $_POST[editartikelid]", $db);
        unlink("../images/shop/".$_POST[editartikelid]."_s.jpg");
        unlink("../images/shop/".$_POST[editartikelid].".jpg");
        systext('Artikel wurde gelöscht');
    }
    else
    {
        $_POST[title] = savesql($_POST[title]);
        $_POST[url] = savesql($_POST[url]);
        $_POST[preis] = savesql($_POST[preis]);
        $_POST[text] = savesql($_POST[text]);
        $_POST[hot] = isset($_POST[hot]) ? 1 : 0;

        if (isset($_FILES[artikelimg]))
        {
            $upload = upload_img($_FILES[artikelimg], "../images/shop/", $_POST[editartikelid], 2*1024*1024, 400, 600);
            systext(upload_img_notice($upload));
            $thumb = create_thumb_from(image_url("../images/shop/",$_POST[editartikelid],false), 100, 100);
            systext(create_thumb_notice($thumb));
        }
        $update = "UPDATE fs_shop
                   SET artikel_name  = '$_POST[title]',
                       artikel_url   = '$_POST[url]',
                       artikel_text  = '$_POST[text]',
                       artikel_preis = '$_POST[preis]',
                       artikel_hot   = '$_POST[hot]'
                   WHERE artikel_id = '$_POST[editartikelid]'";
        mysql_query($update, $db);
        systext("Artikel wurde aktualisiert");
    }
}

////////////////////////////////
////// Artikel editieren ///////
////////////////////////////////

elseif ($_POST[artikelid])
{
    settype($_POST[artikelid], 'integer');
    $index = mysql_query("SELECT * FROM fs_shop WHERE artikel_id = $_POST[artikelid]", $db);
    $artikel_arr = mysql_fetch_assoc($index);
    $dbartikelhot = ($artikel_arr[artikel_hot] == 1) ? "checked" : "";

    echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="shopedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" value="'.$artikel_arr[artikel_id].'" name="editartikelid">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Aktuelles Artikelbild</font>
                                </td>
                                <td class="config" valign="top">
                                    <img src="../images/shop/'.$_POST[artikelid].'_s.jpg">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Neues Bild:<br>
                                    <font class="small">Nur ausfüllen, wenn das alte ersetzt werden soll.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="artikelimg" size="33"><br />
                                    <font class="small">[max. 400 x 600 Pixel] [max. 2 MB]</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Artikelname:<br>
                                    <font class="small">Name des Artikel. Kommt auch in den Hotlink</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="51" value="'.$artikel_arr[artikel_name].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link zum Produkt</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="url" size="51" value="'.$artikel_arr[artikel_url].'" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Artikelbeschreibung:<br>
                                    <font class="small">Kurze Artikelbeschreibung (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("text", $artikel_arr[artikel_text], 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Preis:<br>
                                    <font class="small">Preis in &euro; (bsp 7,99)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="preis" size="10" value="'.$artikel_arr[artikel_preis].'" maxlength="7"> &euro;
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Hotlink:<br>
                                    <font class="small">Hotlinks erscheinen rechts im Menü</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" name="hot" value="1" '.$dbartikelhot.'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Artikel löschen:
                                </td>
                                <td class="config">
                                    <input onClick=\'delalert ("delartikel", "Soll der Shop-Artikel wirklich gelöscht werden?")\' type="checkbox" name="delartikel" id="delartikel" value="1">
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

////////////////////////////////
////// Artikel auswählen ///////
////////////////////////////////

else
{
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="shopedit" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="20%">
                                    Bild
                                </td>
                                <td class="config" width="40%">
                                    Artikelname
                                </td>
                                <td class="config" width="20%">
                                    Preis
                                </td>
                                <td class="config" width="20%">
                                    bearbeiten
                                </td>
                            </tr>
    ';
    $index = mysql_query("SELECT artikel_id, artikel_name, artikel_preis
                          FROM fs_shop
                          ORDER BY artikel_name DESC", $db);
    while ($artikel_arr = mysql_fetch_assoc($index))
    {
        echo'
                            <tr>
                                <td class="config">
                                    <img src="../images/shop/'.$artikel_arr[artikel_id].'_s.jpg">
                                </td>
                                <td class="configthin">
                                    '.$artikel_arr[artikel_name].'
                                </td>
                                <td class="configthin">
                                    '.$artikel_arr[artikel_preis].'
                                </td>
                                <td class="config">
                                    <input type="radio" name="artikelid" value="'.$artikel_arr[artikel_id].'">
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