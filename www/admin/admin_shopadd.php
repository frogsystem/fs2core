<?php

////////////////////////////
//// Artikel einstellen ////
////////////////////////////

if ($_FILES[artikelimg] && $_POST[title] && $_POST[url] && $_POST[preis])
{
    $_POST[title] = savesql($_POST[title]);
    $_POST[url] = savesql($_POST[url]);
    $_POST[preis] = savesql($_POST[preis]);
    $_POST[text] = savesql($_POST[text]);
    settype($_POST[hot], "integer");
    mysql_query("INSERT INTO ".$global_config_arr[pref]."shop (artikel_name, artikel_url, artikel_text, artikel_preis, artikel_hot)
                 VALUES ('".$_POST[title]."',
                         '".$_POST[url]."',
                         '".$_POST[text]."',
                         '".$_POST[preis]."',
                         '".$_POST[hot]."');", $db);
    $id = mysql_insert_id();

    $upload = upload_img($_FILES['artikelimg'], "images/shop/", $id, 2*1024*1024, 400, 600);
    systext(upload_img_notice($upload));
    $thumb = create_thumb_from(image_url("images/shop/",$id,FALSE, TRUE), 100, 100);
    systext(create_thumb_notice($thumb));
}

////////////////////////////
///// Artikel Formular /////
////////////////////////////

else
{
    echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="shopadd" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild auswählen, dass hochgeladen werden soll.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="artikelimg" size="33"><br />
                                    <font class="small">[max. 400 x 600 Pixel] [max. 2 MB]</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Artikelname:<br>
                                    <font class="small">Name des Artikel.<br />
                                    Kommt auch in den Hotlink</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="51" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link zum Produkt</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="url" size="51" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Artikelbeschreibung:<br>
                                    <font class="small">Kurze Artikelbeschreibung (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor("text", "", 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Preis:<br>
                                    <font class="small">Preis in &euro; (bsp 7,99)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="preis" size="10" maxlength="7"> &euro;
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Hotlink:<br>
                                    <font class="small">Hotlinks erscheinen rechts im Menü</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" name="hot" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>