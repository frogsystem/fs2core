<?php if (!defined('ACP_GO')) die('Unauthorized access!');

////////////////////////
//// settings and co ///
////////////////////////
$defaults = array(
  'oldname' => 1,
  'newname' => '',
  'cat' => '',
  'thumb' => 0,
  'width' => '',
  'height' => '',
);


//////////////////////////
//// Upload Screenshot ///
//////////////////////////


$catsqry = $FD->db()->conn()->query('SELECT * FROM `'.$FD->env('DB_PREFIX').'cimg_cats`');
$cats = array();
while(($cat = $catsqry->fetch(PDO::FETCH_ASSOC)) !== false){
    $cats[] = $cat;
}

unset($catsqry, $cat);

if (isset($_FILES['cimg']) AND (isset($_POST['newname']) OR $_POST['oldname'] == 1))
{
  if ($_POST['thumb'] == 1) {
      $make_thumb = true;
  } else {
      $make_thumb = false;
  }

  $oldname_data = pathinfo($_FILES['cimg']['name'], PATHINFO_EXTENSION);

  if ($_POST['oldname'] == 1) {
      $_POST['newname'] = basename ($_FILES['cimg']['name'],'.'.$oldname_data);
  }
  
  $oldname_data = strtolower($oldname_data);

  settype ($_POST['cat'], 'integer');
  settype ($_POST['width'], 'integer');
  settype ($_POST['height'], 'integer');

  if (!image_exists('media/content/',$_POST['newname'])  AND !image_exists('media/content/',$_POST['newname'].'_s'))
  {
    $upload = upload_img($_FILES['cimg'], 'media/content/', $_POST['newname'], 1024*1024*5, 9999, 9999);
    $message = upload_img_notice ( $upload );
    if ($make_thumb) {
      $thumb = create_thumb_from ( image_url ( 'media/content/', $_POST['newname'], FALSE, TRUE ) , $_POST['width'], $_POST['height'] );
      $message .= '<br>' . create_thumb_notice ( $thumb );
    }
    $stmt = $FD->db()->conn()->prepare('
                  INSERT INTO `'.$FD->env('DB_PREFIX')."cimg` (`name`, `type`, `hasthumb`, `cat`)
                  VALUES (?, ?, ".intval($_POST['thumb']).', '.intval($_POST['cat']).')');
    $stmt->execute(array($_POST['newname'], $oldname_data));
    unset($_POST['width']);
    unset($_POST['height']);
    unset($_POST['oldname']);
    unset($_POST['newname']);
    unset($_POST['thumb']);
    unset($_POST['sended']);
  }
  else
  {
    $message = 'Ein Bild mit gleichem Namen existiert bereits!';
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

/////////////////////////
//// Screenshot Form ////
/////////////////////////
    $error_message = '';

    if (isset($_POST['sended']))
    {
      $error_message = 'Bitte f&uuml;llen Sie <b>alle Pflichfelder</b> aus!';
      systext($error_message);
    }

    // set defaults
    $_POST = $_POST+$defaults;

echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="cimg_add" name="go">
                        <input type="hidden" name="sended" value="">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">Inhaltsbild hochladen</td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Bild ausw&auml;hlen, dass hochgeladen werden soll.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="file" class="text" name="cimg" size="33"><br>
                                    <font class="small">Erlaubte Dateiendungen: *.jpg, *.gif und *.png; max. 5 MB</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Alten Bildname verwenden:<br>
                                    <font class="small">Soll das Bild den urspr&uuml;nglichen Namen behalten?</font>
                                </td>
                                <td class="config" valign="middle">
                                  '.$FD->text("admin", "checkbox").'
                                  <input class="hidden" class="text" type="checkbox" name="oldname" id="newname" value="1"'.getchecked($_POST['oldname'], 1).'>
                                </td>
                            </tr>
                            <tr class="hidden" id="newname_line">
                                <td valign="top" class="config">
                                    Neuer Bildname:<br>
                                    <font class="small">ohne Dateiendung</font>
                                </td>
                                <td valign="top" class="config">
                                    <input class="text" name="newname" id="newname" size="25" maxlength="100" value="'.$_POST['newname'].'"><br>
                                    <font class="small">Erstellt das Bild als <b>bildname.jpg/.gif/.png</b> (s.o.)</font>
                                </td>
                            </tr>';
if(count($cats) > 0){
    $echo = '
                            <tr>
                                <td valign="top" class="config">
                                    Kategorie:<br>
                                    <font class="small">ohne Dateiendung</font>
                                </td>
                                <td valign="top" class="config">
                                    <select name="cat">
                                        <option value="0"'.getselected($_POST['cat'], 0).'>Keine Kategorie</option>';
    foreach($cats as $cat){
        $echo .= '                                        <option title="'.$cat['description'].'" value="'.$cat['id'].'"'.getselected($_POST['cat'], $cat['id']).'>'.$cat['name'].'</option>';
    }
    echo $echo.'
                                    </select>
                                </td>
                            </tr>';
}
if(!isset($_POST['thumb']))
  $_POST['thumb'] = 0;
if(!isset($_POST['width']))
  $_POST['width'] = '';
if(!isset($_POST['height']))
  $_POST['height'] = '';
echo '
                            <tr>
                                <td class="config" valign="top">
                                    Thumbnail:<br>
                                    <font class="small">Soll ein Thumbnail (Vorschaubild) erstellt werden?</font>
                                </td>
                                <td class="config" valign="middle">
                                  <input class="text" style="vertical-align:middle;" type="checkbox" name="thumb" value="1"'.getchecked($_POST['thumb'], 1).'/>
                                  <font class="small">Erstellt ein Thumbnail als <b>bildname_s.jpg/.gif/.png</b> (s.o.)</font>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Thumbnail-Ma&szlig;e: <font class="small">(Breite x H&ouml;he)</font><br />
                                    <font class="small">Max. Abmessungen des Thumbnails.</font>
                                </td>
                                <td class="config" valign="top">
                                  <input class="text" name="width" size="5" maxlength="4" value="'.$_POST['width'].'" /> x <input class="text" name="height" size="5" maxlength="4" value="'.$_POST['height'].'" /> Pixel<br />
                                    <font class="small"><b>Hinweis:</b> Das Seitenverh&auml;ltnis wird beibehalten!</font>
                                </td>
                            </tr>
							<tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "upload_image_button").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <script type="text/javascript">
                        jQuery(document).ready(function(){
                            $("#newname").change(function(event) {
                                if ($(this).is(":checked")) {
                                    $("#newname_line").hide();
                                } else {
                                    $("#newname_line").show();
                                }
                            });
                        });
                    
                    </script>
';
?>
