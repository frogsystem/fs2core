<?php if (!defined('ACP_GO')) die('Unauthorized access!');

////////////////////
//// Load Config ///
////////////////////
$FD->loadConfig('screens');
$config_arr = $FD->configObject('screens')->getConfigArray();

//////////////////////////
//// Screenshot Upload ///
//////////////////////////

if (isset($_FILES['sizeimg_0']) AND isset($_POST['size']['0']) AND !emptystr($_POST['wallpaper_name']) AND isset($_POST['wpadd']) AND $_POST['wpadd'] == 1)
{

$index = $FD->db()->conn()->prepare('SELECT COUNT(*) AS wp_count FROM '.$FD->env('DB_PREFIX').'wallpaper WHERE wallpaper_name = ?');
$index->execute(array($_POST['wallpaper_name']));
$row = $index->fetch(PDO::FETCH_ASSOC);
if ($row['wp_count']==0) {

    for ($i=1; $i<=$_POST['options']; $i++)
    {
      $j = $i - 1;
      $filesname = "sizeimg_$j";
      if (!isset($_FILES[$filesname]))
        $_POST['size'][$j] = '';
    }

    $_POST['catid'] = intval($_POST['catid']);
    $stmt = $FD->db()->conn()->prepare('INSERT INTO '.$FD->env('DB_PREFIX')."wallpaper (wallpaper_name, wallpaper_title, cat_id)
                 VALUES (?,
                         ?,
                         '".$_POST['catid']."')");
    $stmt->execute(array($_POST['wallpaper_name'], $_POST['wallpaper_title']));
    $wp_id = $FD->db()->conn()->lastInsertId();

    $message = '';

    for ($i=1; $i<=$_POST['options']; $i++)
    {
      $j = $i - 1;
      $filesname = "sizeimg_$j";
      if (isset($_FILES[$filesname]) AND $_POST['size'][$j] != '')
      {
        $j = $i - 1;
        $upload = upload_img($_FILES[$filesname], 'images/wallpaper/', $_POST['wallpaper_name'].'_'.$_POST['size'][$j], $config_arr['wp_size']*1024, $config_arr['wp_x'], $config_arr['wp_y']);
        $message .= "WP Gr&ouml;&szlig;e $i: ".upload_img_notice($upload).'<br>';
        switch ($upload)
        {
        case 0:
          $stmt = $FD->db()->conn()->prepare('INSERT INTO '.$FD->env('DB_PREFIX')."wallpaper_sizes (wallpaper_id, size)
                       VALUES ('".$wp_id."', ?)");
          $stmt->execute(array($_POST['size'][$j]));
          break;
        }

      }
    }
    if (image_exists('images/wallpaper/', $_POST['wallpaper_name'].'_'.$_POST['size'][0]))
    {
      create_thumb_from(image_url('images/wallpaper/', $_POST['wallpaper_name'].'_'.$_POST['size'][0], FALSE, TRUE), $config_arr['wp_thumb_x'], $config_arr['wp_thumb_y']);
      $message .= create_thumb_notice($upload).'<br>';
      image_rename('images/wallpaper/', $_POST['wallpaper_name'].'_'.$_POST['size'][0].'_s', $_POST['wallpaper_name'].'_s');
    }

  $message .= '<br>Weiteres Wallpaper hinzuf&uuml;gen:';
  systext($message);
  $_POST['wallpaper_name'] = '';
  $_POST['wallpaper_title'] = '';
  for ($i=1; $i<=$_POST['options']; $i++)
  {
    $j = $i - 1;
    $_POST['size'][$j] = '';
  }
}
else
  {
    systext('Es existiert bereits ein Wallpaper mit diesem Namen!');
  }

}

////////////////////////
//// Wallpaper Form ////
////////////////////////

    if (!isset($_POST['options']))
    {
        $_POST['options'] = 5;
    }
    if (!isset($_POST['optionsadd']))
    {
        $_POST['optionsadd'] = 0;
    }
    $_POST['options'] = $_POST['options'] + $_POST['optionsadd'];

    if (!isset($_POST['wallpaper_name'])) $_POST['wallpaper_name'] = '';
    if (!isset($_POST['wallpaper_title'])) $_POST['wallpaper_title'] = '';

echo'
                    <form id="form" action="" enctype="multipart/form-data" method="post">
                        <input id="send" type="hidden" value="0" name="wpadd">
                        <input type="hidden" value="'.$_POST['options'].'" name="options">
                        <input type="hidden" value="wp_add" name="go">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="2"><h3>Wallpaper hochladen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top" width="150">
                                    Dateiname:<br>
                                    <font class="small">Name unter dem gespeichert wird.</font>
                                </td>
                                <td class="config" valign="top" width="450">
                                    <input class="text" name="wallpaper_name" size="33" maxlength="100" value="'.$_POST['wallpaper_name'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Titel des Wallpapers.<br>(optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="wallpaper_title" size="33" maxlength="255" value="'.$_POST['wallpaper_title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kategorie:<br>
                                    <font class="small">Kategorie in die das WP eingeordnet wird</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="catid">
';
$index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'screen_cat WHERE cat_type = 2');
while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
{
    echo'
                                        <option value="'.$cat_arr['cat_id'].'">
                                            '.$cat_arr['cat_name'].'
                                        </option>
    ';
}
echo'
                                    </select>
                                </td>
                            </tr>';

    for ($i=1; $i<=$_POST['options']; $i++)
    {
        $j = $i - 1;
        if (isset($_POST['size'][$j]))
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Gr&ouml;&szlig;e '.$i.':<br>
                                    <font class="small">Format und WP ausw&auml;hlen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" id="size'.$j.'" name="size['.$j.']" size="12" maxlength="30" value="'.$_POST['size'][$j].'">&nbsp;
                                    <select onChange=\'document.getElementById("size'.$j.'").value=this.value; this.selectedIndex = 0\'>
                                        <option value="">Gr&ouml;&szlig;e ausw&auml;hlen...</option>
                                        <option value="">-----------</option>
                                        <option value="800x600">800x600</option>
                                        <option value="1024x768">1024x768</option>
                                        <option value="1280x768">1280x768</option>
                                        <option value="1280x800">1280x800</option>
                                        <option value="1280x1024">1280x1024</option>
                                        <option value="1366x768">1366x768</option>
                                        <option value="1440x900">1440x900</option>
                                        <option value="1680x1050">1680x1050</option>
                                        <option value="1920x1080">1920x1080</option>
                                        <option value="1920x1200">1920x1200</option>
                                    </select><br>
                                    <input type="file" class="text" name="sizeimg_'.$j.'" size="40">
                                    <br><br>
                                </td>
                            </tr>
            ';
        }
        else
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Gr&ouml;&szlig;e '.$i.':<br>
                                    <font class="small">Format und WP ausw&auml;hlen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text left" id="size'.$j.'" name="size['.$j.']" size="12" maxlength="30" value="">&nbsp;
                                    <select onChange=\'document.getElementById("size'.$j.'").value=this.value; this.selectedIndex = 0\'>
                                        <option value="">Gr&ouml;&szlig;e ausw&auml;hlen...</option>
                                        <option value="">-----------</option>
                                        <option value="800x600">800x600</option>
                                        <option value="1024x768">1024x768</option>
                                        <option value="1280x768">1280x768</option>
                                        <option value="1280x800">1280x800</option>
                                        <option value="1280x1024">1280x1024</option>
                                        <option value="1366x768">1366x768</option>
                                        <option value="1440x900">1440x900</option>
                                        <option value="1680x1050">1680x1050</option>
                                        <option value="1920x1080">1920x1080</option>
                                        <option value="1920x1200">1920x1200</option>
                                    </select><br>
                                    <input type="file" class="text" name="sizeimg_'.$j.'" size="40">
                                    <br><br>
                                </td>
                            </tr>
            ';
        }
    }

echo'
                            <tr>
                                <td class="configthin">
                                    &nbsp;
                                </td>
                                <td class="configthin">
                                    <input size="2" class="text" name="optionsadd">
                                    Wallpaper
                                    <input type="submit" value="Hinzuf&uuml;gen">
                                </td>
                            </tr>
                            <tr>
                                <td align="left" colspan="2">
                                    <input class="button" type="button" onClick="javascript:document.getElementById(\'send\').value=\'1\'; document.getElementById(\'form\').submit();" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>
