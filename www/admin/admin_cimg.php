<?php

/////////////////////////////
//// Screenshot hochladen ///
/////////////////////////////

if (isset($_FILES['cimg']) && $_POST['name'])
{
  if ($_POST['thumb'] == 1)
    $make_thumb = true;
  else
    $make_thumb = false;

  settype ($_POST['width'],integer);
  settype ($_POST['height'],integer);
  
  if (!image_exists("../images/content/",$_POST[name])  AND !image_exists("../images/content/","$_POST[name]_s"))
  {
    $upload = upload_img($_FILES['cimg'], "../images/content/", $_POST['name'], 1024*1024, 9999, 9999, $_POST['width'], $_POST['height'], $make_thumb);
    systext(upload_img_notice($upload));
    unset($_POST['width']);
    unset($_POST['height']);
    unset($_POST['name']);
    unset($_POST['thumb']);
    unset($_POST['sended']);
  }
  else
  {
    systext("Bild mit gleichem Namen existiert bereits!");
  }
}

/////////////////////////////
//// Screenshot Formular ////
/////////////////////////////
    $error_message = "";

    if (isset($_POST['sended']))
    {
      $error_message = "Bitte füllen Sie <b>alle Pflichfelder</b> aus!";
    }

    systext($error_message);
    
echo'
                    <form action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="cimgadd" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <input type="hidden" name="sended" value="">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild auswählen, dass hochgeladen werden soll</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="cimg" size="33"><br>
                                    <font class="small">Erlaubte Dateiendungen: *.jpg, *.gif und *.png; max. 5 MB</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bildname:<br>
                                    <font class="small">ohne Dateiendung</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="name" size="25" maxlength="100" value="'.$_POST['name'].'"><br>
                                    <font class="small">Erstellt das Bild als <b>bildname.jpg/.gif/.png</b> (s.o.)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Thumbnail:<br>
                                    <font class="small">Soll ein Thumbnail (Vorschaubild) erstellt werden?</font>
                                </td>
                                <td class="config" valign="bottom">
                                  <input class="text" type="checkbox" name="thumb" value="1" ';
                                  if ($_POST['thumb'] == 1)
                                    echo 'checked=cehcked';
echo'
                                   />
                                  <font class="small">Erstellt Thumbnail als <b>bildname_s.jpg/.gif/.png</b> (s.o.)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top" h>
                                    Thumbnail-Maße:<br>
                                    <font class="small">Max. Abemsseungen des Thumbnails<br>
                                    (Breite x Höhe in Pixeln)</font>
                                </td>
                                <td class="config" valign="top">
                                  <input class="text" name="width" size="15" maxlength="15" value="'.$_POST['width'].'" /> x <input class="text" name="height" size="15" maxlength="15" value="'.$_POST['height'].'" /><br>
                                    <font class="small"><b>Hinweis:</b> Das Seitenverhältnis wird beibehalten!</font>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Hochladen">
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>