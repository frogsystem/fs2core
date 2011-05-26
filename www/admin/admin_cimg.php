<?php

/////////////////////////////
//// Screenshot hochladen ///
/////////////////////////////

if (!empty($_FILES['cimg']['name']) AND ($_POST['newname'] OR $_POST['oldname'] == 1))
{
  if ($_POST['thumb'] == 1) {
      $make_thumb = true;
  } else {
      $make_thumb = false;
  }

  if ($_POST['oldname'] == 1) {
      $oldname_data = pathinfo($_FILES['cimg']['name']);
      $_POST['newname'] = basename ($_FILES['cimg']['name'],".".$oldname_data['extension']);
  }

  settype ($_POST['width'],integer);
  settype ($_POST['height'],integer);
  
  if (!image_exists("images/content/",$_POST[newname])  AND !image_exists("images/content/",$_POST[newname]."_s"))
  {
    $upload = upload_img($_FILES['cimg'], "images/content/", $_POST['newname'], 1024*1024, 9999, 9999);
    $message = upload_img_notice ( $upload );
    if ($make_thumb) {
      $thumb = create_thumb_from ( image_url ( "images/content/", $_POST['newname'], FALSE, TRUE ) , $_POST['width'], $_POST['height'] );
      $message .= "<br>" . create_thumb_notice ( $thumb );
    }
    unset($_POST['width']);
    unset($_POST['height']);
    unset($_POST['oldname']);
    unset($_POST['newname']);
    unset($_POST['thumb']);
    unset($_POST['sended']);
  }
  else
  {
    $message = "Ein Bild mit gleichem Namen existiert bereits!";
    unset($_POST['sended']);
    if ($_POST['oldname'] == 1) {
        unset($_POST['newname']);
    }
    if ($_POST['thumb'] != 1) {
        unset($_POST['width']);
        unset($_POST['height']);
    }
  }
  
	systext ( $message );
}

/////////////////////////////
//// Screenshot Formular ////
/////////////////////////////
    $error_message = "";

    if (isset($_POST['sended']))
    {
      $error_message = "Bitte füllen Sie <b>alle Pflichfelder</b> aus!";
      systext($error_message);
    }

    if (!isset($_POST['oldname']))
        $_POST['oldname'] = 1;
        
    if (!isset($_POST['thumb']))
        $_POST['thumb'] = 0;        
    
echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="cimg_add" name="go">
                        <input type="hidden" name="sended" value="upload">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Inhaltsbilder hinzufügen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild auswählen, dass hochgeladen werden soll.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="cimg" size="33"><br>
                                    <font class="small">Erlaubte Dateiendungen: *.jpg, *.gif und *.png; max. 5 MB</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Alten Bildname verwenden:<br>
                                    <font class="small">Soll das Bild den ursprünglichen Namen behalten?</font>
                                </td>
                                <td class="config" valign="middle">
                                  <img class="checkbox" src="images/checkbox.png" alt="[_]">
                                  <input class="hidden" type="checkbox" name="oldname" id="newname" value="1"';
                                  if ($_POST['oldname'] == 1)
                                    echo ' checked ';
echo'
                                   onChange="$(\'#new_name_tr\').toggle(!$(this).prop(\'checked\'))">
                                </td>
                            </tr>
                            <tr id="new_name_tr" class="';
                                  if ($_POST['oldname'] == 1)
                                    echo 'hidden';
echo'
                            ">
                                <td valign="top" class="config">
                                    Neuer Bildname:<br>
                                    <font class="small">ohne Dateiendung</font>
                                </td>
                                <td valign="top" class="config">
                                    <input class="text" name="newname" id="newname" size="25" maxlength="100" value="'.$_POST['newname'].'"><br>
                                    <font class="small">Erstellt das Bild als <b>bildname.jpg/.gif/.png</b> (s.o.)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Thumbnail:<br>
                                    <font class="small">Soll ein Thumbnail (Vorschaubild) erstellt werden?</font>
                                </td>
                                <td class="config" valign="middle">
                                  <img class="checkbox middle" src="images/checkbox.png" alt="[_]">
                                  <input class="hidden" type="checkbox" name="thumb" id="thumb" value="1"';
                                  if ($_POST['thumb'] == 1)
                                    echo ' checked ';
echo'
                                   onChange="$(\'#thumb_tr\').toggle($(this).prop(\'checked\'))" >
                                  <label class="small" for="thumb">Erstellt ein Thumbnail als <b>bildname_s.jpg/.gif/.png</b> (s.o.)</label>
                                </td>
                            </tr>
                            <tr id="thumb_tr" class="';
                                  if ($_POST['thumb'] != 1)
                                    echo 'hidden';
echo'
                            ">
                                <td class="config" valign="top">
                                    Thumbnail-Maße: <font class="small">(Breite x Höhe)</font><br />
                                    <font class="small">Max. Abemsseungen des Thumbnails.</font>
                                </td>
                                <td class="config" valign="top">
                                  <input class="text" name="width" size="5" maxlength="4" value="'.$_POST['width'].'" /> x <input class="text" name="height" size="5" maxlength="4" value="'.$_POST['height'].'" /> Pixel<br />
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
