<?php

/////////////////////////////
//// Screenshot hochladen ///
/////////////////////////////

if (isset($_FILES['sizeimg_0']) AND $_POST['size']['0'] AND $_POST['wallpaper_name'] AND $_POST['wpadd'])
{
    $_POST[wallpaper_name] = savesql($_POST[wallpaper_name]);
    $_POST[wallpaper_title] = savesql($_POST[wallpaper_title]);
    
$index = mysql_query("SELECT * FROM fs_wallpaper WHERE wallpaper_name = '$_POST[wallpaper_name]'", $db);
if (mysql_num_rows($index)==0) {
    
    for ($i=1; $i<=$_POST[options]; $i++)
    {
      $j = $i - 1;
      $_POST['size'][$j] = savesql($_POST['size'][$j]);
      $filesname = "sizeimg_$j";
      if (!isset($_FILES[$filesname]))
        $_POST['size'][$j] = "";
    }
    
    mysql_query("INSERT INTO fs_wallpaper (wallpaper_name, wallpaper_title, cat_id)
                 VALUES ('".$_POST[wallpaper_name]."',
                         '".$_POST[wallpaper_title]."',
                         '".$_POST[catid]."')", $db);
    $wp_id = mysql_insert_id();

    for ($i=1; $i<=$_POST[options]; $i++)
    {
      $j = $i - 1;
      $filesname = "sizeimg_$j";
      if (isset($_FILES[$filesname]) AND $_POST['size'][$j] != "")
      {
        $j = $i - 1;
        $upload = upload_img($_FILES[$filesname], "../images/wallpaper/", $_POST['wallpaper_name']."_".$_POST['size'][$j], 5*1024*1024, 9999, 9999, 0, 0, false);
        systext(upload_img_notice($upload));
        switch ($upload)
        {
        case 0:
          mysql_query("INSERT INTO fs_wallpaper_sizes (wallpaper_id, size)
                       VALUES ('".$wp_id."',
                               '".$_POST['size'][$j]."')", $db);
          break;
        }

      }
    }
    if (image_exists("../images/wallpaper/", $_POST['wallpaper_name']."_".$_POST['size'][0]))
    {
      create_thumb_from(image_url("../images/wallpaper/", $_POST['wallpaper_name']."_".$_POST['size'][0], false), 200, 200);
      systext(create_thumb_notice($upload));
      rename(image_url("../images/wallpaper/", $_POST['wallpaper_name']."_".$_POST['size'][0]."_s", false), "../images/wallpaper/$_POST[wallpaper_name]_s.jpg");
    }

  systext("Weiteres Wallpaper hinzufügen:");
  $_POST[wallpaper_name] = "";
  $_POST[wallpaper_title] = "";
  for ($i=1; $i<=$_POST[options]; $i++)
  {
    $j = $i - 1;
    $_POST['size'][$j] = "";
  }
}
else
  {
    systext("Es existiert bereits ein Wallpaper mit diesem Namen!");
  }

}

////////////////////////////
//// Wallpaper Formular ////
////////////////////////////

    if (!isset($_POST[options]))
    {
        $_POST[options] = 3;
    }
    $_POST[options] = $_POST[options] + $_POST[optionsadd];

echo'
                    <form id="form" action="'.$PHP_SELF.'" enctype="multipart/form-data" method="post">
                        <input id="send" type="hidden" value="0" name="wpadd">
                        <input type="hidden" value="'.$_POST[options].'" name="options">
                        <input type="hidden" value="wallpaperadd" name="go">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top" width="125px">
                                    Dateiname:<br>
                                    <font class="small">Name unter dem gespeichert wird.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="wallpaper_name" size="33" maxlength="100" value="'.$_POST[wallpaper_name].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Titel des Wallpapers.<br>(optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="wallpaper_title" size="33" maxlength="100" value="'.$_POST[wallpaper_title].'">
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
$index = mysql_query("SELECT * FROM fs_screen_cat WHERE cat_type = 2", $db);
while ($cat_arr = mysql_fetch_assoc($index))
{
    echo'
                                        <option value="'.$cat_arr[cat_id].'">
                                            '.$cat_arr[cat_name].'
                                        </option>
    ';
}
echo'
                                    </select>
                                </td>
                            </tr>';

    for ($i=1; $i<=$_POST[options]; $i++)
    {
        $j = $i - 1;
        if ($_POST[size][$j])
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Größe '.$i.':<br>
                                    <font class="small">Format und WP auswählen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" id="size'.$j.'" name="size['.$j.']" size="10" maxlength="30" value="'.$_POST[size][$j].'"> <input type="file" class="text" name="sizeimg_'.$j.'" size="33"><br>
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="800x600";\' value="800x600">
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1024x768";\' value="1024x768">
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x960";\' value="1280x960">
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x1024";\' value="1280x1024">
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1600x1200";\' value="1600x1200">
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
                                    Größe '.$i.':<br>
                                    <font class="small">Format und WP auswählen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" id="size'.$j.'" name="size['.$j.']" size="10" maxlength="30" value=""> <input type="file" class="text" name="sizeimg_'.$j.'" size="33"><br>
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="800x600";\' value="800x600">
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1024x768";\' value="1024x768">
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x960";\' value="1280x960">
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x1024";\' value="1280x1024">
                                    <input class="button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1600x1200";\' value="1600x1200">
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
                                    <input class="button" type="submit" value="Hinzufügen">
                                </td>
                            </tr>
                            <tr>
                                <td class="configthin">
                                    &nbsp;
                                </td>
                                <td align="left"><br>
                                    <input class="button" type="button" onClick="javascript:document.getElementById(\'send\').value=\'1\'; document.getElementById(\'form\').submit();" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
';
?>