<?php

////////////////////////////
//// Artikel einstellen ////
////////////////////////////

if ($_FILES['artikelimg'] && $_POST['title'] && $_POST['url'] && $_POST['preis'])
{
    $_POST['title'] = savesql($_POST['title']);
    $_POST['url'] = savesql($_POST['url']);
    $_POST['preis'] = savesql($_POST['preis']);
    $_POST['text'] = savesql($_POST['text']);
    settype($_POST['hot'], 'integer');
    mysql_query('INSERT INTO '.$global_config_arr['pref']."shop (artikel_name, artikel_url, artikel_text, artikel_preis, artikel_hot)
                 VALUES ('".$_POST['title']."',
                         '".$_POST['url']."',
                         '".$_POST['text']."',
                         '".$_POST['preis']."',
                         '".$_POST['hot']."');", $FD->sql()->conn() );
    $id = mysql_insert_id();

    $messages = array();
    if (!empty($_FILES['artikelimg']['name']))
    {
        $upload = upload_img($_FILES['artikelimg'], 'images/shop/', $id, 2*1024*1024, 400, 600);
        $messages[] = upload_img_notice($upload);
        $thumb = create_thumb_from(image_url('images/shop/',$id,FALSE, TRUE), 100, 100);
        $messages[] = create_thumb_notice($thumb);
    }

    $messages[] = $FD->text("admin", "changes_saved");

    echo get_systext(implode('<br>', $messages), $FD->text("admin", "info"), 'green', $FD->text("admin", "icon_save_ok"));
    unset($_POST);
}

////////////////////////////
///// Artikel Formular /////
////////////////////////////

if(true)
{
    if(isset($_POST['sended'])) {
        echo get_systext($FD->text("admin", "changes_not_saved").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_save_error"));
    }

    echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="shop_add" name="go">
                        <input type="hidden" value="1" name="sended">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Produkt hinzuf&uuml;gen</h3><hr></td></tr>

                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild ausw&auml;hlen, dass hochgeladen werden soll.</font>
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
                                    '.create_editor('text', '', 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Preis:<br>
                                    <font class="small">Preis</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="preis" size="10" maxlength="10">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Hotlink:<br>
                                    <font class="small">Hotlinks erscheinen rechts im Men&uuml;</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="checkbox" name="hot" value="1">
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
}
?>
