<?php if (!defined('ACP_GO')) die('Unauthorized access!');

/////////////////////
//// Config laden ///
/////////////////////

$FD->loadConfig('screens');
$config_arr = $FD->configObject('screens')->getConfigArray();

////////////////////////////
//// Wallpaper editieren ///
////////////////////////////
if (isset($_POST['wallpaper_id']) AND isset($_POST['sended']) AND $_POST['sended'] == 'edit' AND !emptystr($_POST['wallpaper_name']) AND isset($_POST['size'][0]) AND isset($_POST['wpedit'])  AND $_POST['wpedit'] == 1)
{
    $index = $FD->sql()->conn()->prepare('SELECT COUNT(*) FROM '.$FD->config('pref').'wallpaper WHERE wallpaper_name = ?');
    $index->execute(array($_POST['wallpaper_name']));

    if (count($_POST['size']) == count(array_unique($_POST['size'])) AND ($index->fetchColumn()==0 OR $_POST['wallpaper_name'] == $_POST['oldname']))
    {
    //IF Beginn

    //security functions
    $_POST['catid'] = intval($_POST['catid']);
    $_POST['wallpaper_id'] = intval($_POST['wallpaper_id']);

    $update = $FD->sql()->conn()->prepare('UPDATE '.$FD->config('pref')."wallpaper
               SET wallpaper_name = ?,
                   wallpaper_title  = ?,
                   cat_id      = '$_POST[catid]'
               WHERE wallpaper_id = $_POST[wallpaper_id]");
    $update->execute(array($_POST['wallpaper_name'], $_POST['wallpaper_title']));

    // Files  aktualisieren
        for ($i=0; $i<count($_POST['size']); $i++)
        {
            if (isset($_POST['delwp'][$i]) && $_POST['delwp'][$i])
            {
                settype($_POST['delwp'][$i], 'integer');
                $index = $FD->sql()->conn()->query('SELECT size FROM '.$FD->config('pref')."wallpaper_sizes WHERE size_id = '".$_POST['delwp'][$i]."'");
                $size_name = $index->fetchColumn();
                $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."wallpaper_sizes WHERE size_id = '".$_POST['delwp'][$i]."'");
                image_delete('images/wallpaper/', "$_POST[oldname]_$size_name");
            }
            else
            {
                $filesname = "sizeimg_$i";
                if (isset($_FILES[$filesname]) && $_POST['wpnew'][$i]==1 && $_POST['size'][$i]!='' && !emptystr($_FILES["sizeimg_".$i]['tmp_name']))
                {
                    $upload = upload_img($_FILES[$filesname], 'images/wallpaper/', $_POST['oldname'].'_'.$_POST['size'][$i].'a', $config_arr['wp_size']*1024, $config_arr['wp_x'], $config_arr['wp_y']);
                    systext(upload_img_notice($upload));
                    switch ($upload)
                    {
                    case 0:
                        $insert = $FD->sql()->conn()->prepare('INSERT INTO '.$FD->config('pref')."wallpaper_sizes (wallpaper_id, size)
                                   VALUES ('".$_POST['wallpaper_id']."', ?)");
                        $insert->execute(array($_POST['size'][$i]));
                    break;
                    }
                }
                elseif ($_POST['wpnew'][$i]==0)
                {
                    $_POST['size_id'][$i] = intval($_POST['size_id'][$i]);
                    $index = $FD->sql()->conn()->query('SELECT size FROM '.$FD->config('pref')."wallpaper_sizes WHERE size_id = '".$_POST['size_id'][$i]."'" );
                    $size_name = $index->fetchColumn();

                    image_rename('images/wallpaper/', $_POST['oldname'].'_'.$size_name, $_POST['oldname'].'_'.$_POST['size'][$i].'a');

                    $update = $FD->sql()->conn()->prepare('UPDATE '.$FD->config('pref')."wallpaper_sizes
                               SET size = ?
                               WHERE size_id = ".$_POST['size_id'][$i]);
                    $update->execute(array($_POST['size'][$i]));

                    if (isset($_FILES[$filesname]) && !emptystr($_FILES["sizeimg_".$i]['tmp_name']))
                    {
                        $upload = upload_img($_FILES[$filesname], 'images/wallpaper/', $_POST['oldname'].'_'.$_POST['size'][$i].'a', $config_arr['wp_size']*1024, $config_arr['wp_x'], $config_arr['wp_y']);
                        systext(upload_img_notice($upload));
                    }
                }
            }
        }

     //Rename
     $index2 = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]'");
     while ($sizes_arr = $index2->fetch(PDO::FETCH_ASSOC))
     {
          image_rename('images/wallpaper/', $_POST['oldname'].'_'.$sizes_arr['size'].'a', $_POST['wallpaper_name'].'_'.$sizes_arr['size']);
     }
     image_rename('images/wallpaper/', $_POST['oldname'].'_s', $_POST['wallpaper_name'].'_s');

     systext($FD->text('admin', 'changes_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));

   //IF Ende
   }
   else
   {
       systext('Fehler bei der Bearbeitung:<br><br>
       - Jede Gr&ouml;&szlig;e darf nur einmal vorkommen<br>
       - Der Wallpapername muss einzigartig sein<br><br>
       Da nicht beide Bedingungen nicht erf&uuml;llt sind, wurde die Bearbeitung abgebrochen!');
   }
}
//////////////////////////
//// Wallpaper löschen ///
//////////////////////////
elseif (isset($_POST['wallpaper_id']) AND isset($_POST['sended']) AND $_POST['sended'] == 'delete')
{
    //security functions
    $_POST['wallpaper_id'] = intval($_POST['wallpaper_id']);

    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'");
    $wp_del_array = $index->fetch(PDO::FETCH_ASSOC);
    $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'");
    image_delete('images/wallpaper/', $wp_del_array['wallpaper_name'].'_s');

    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]'");
    while ($wp_sizes_del_array = $index->fetch(PDO::FETCH_ASSOC))
    {
      image_delete('images/wallpaper/', $wp_del_array['wallpaper_name'].'_'.$wp_sizes_del_array['size']);
    }
    $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]'");

    systext('Wallpaper wurden gel&ouml;scht');
}

//////////////////////////
/// Wallpaper Funktion ///
//////////////////////////

elseif (isset($_POST['wallpaper_id']) AND isset($_POST['wp_action']))
{
  //security function
  $_POST['wallpaper_id'] = intval($_POST['wallpaper_id']);

////////////////////////////
/// Wallpaper bearbeiten ///
////////////////////////////


  if ($_POST['wp_action'] == 'edit')
  {

    //Thumb neu erstellen
    if (isset($_POST['sended']) && $_POST['sended'] == 'newthumb')
    {
        $index = $FD->sql()->conn()->query('SELECT wallpaper_name FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'");
        $wp_name = $index->fetchColumn();

        $index = $FD->sql()->conn()->query('SELECT size FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]' LIMIT 1");
        $wp_size = $index->fetchColumn();

        image_delete('images/wallpaper/', $wp_name.'_s');

        $newthumb = create_thumb_from(image_url('images/wallpaper/', $wp_name.'_'.$wp_size, FALSE, TRUE), $config_arr['wp_thumb_x'], $config_arr['wp_thumb_y']);

        image_rename('images/wallpaper/', $wp_name.'_'.$wp_size.'_s', $wp_name.'_s');

        systext(create_thumb_notice($newthumb).'<br />(Cache leeren nicht vergessen!)');
    }

    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'");
    $admin_wp_arr = $index->fetch(PDO::FETCH_ASSOC);

    $admin_wp_arr['old_name'] = killhtml($admin_wp_arr['wallpaper_name']);

    $error_message = '';

    if (isset($_POST['sended']) && $_POST['sended'] !='newthumb' && !isset($_POST['wp_edit']) )
    {
      $admin_wp_arr['wallpaper_name'] = $_POST['wallpaper_name'];
      $admin_wp_arr['wallpaper_title'] = $_POST['wallpaper_title'];
      $admin_wp_arr['cat_id'] = $_POST['catid'];

      $error_message = 'Bitte f&uuml;llen Sie <b>alle Pflichfelder</b> aus!';
    }

    if ( $error_message != '' ) {
        systext($error_message);
    }

    //EDIT ANFANG

    $index2 = $FD->sql()->conn()->query('SELECT COUNT(*) FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]'");
    $index2_num_rows = (int) $index2->fetchColumn();
    $index2 = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]' ORDER BY size_id ASC LIMIT 1");
    $admin_sizes_arr = $index2->fetch(PDO::FETCH_ASSOC);
    $index2 = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]' ORDER BY size_id ASC");

    for($i=0; $i<$index2_num_rows; $i++)
    {
        $admin_sizes_arr['wp_exists'][$i] = '<font class="small">Dieses Wallpaper existiert bereits!<br />
        W&auml;hlen sie nur ein Neues aus, wenn das Alte &uuml;berschrieben werden soll!</font><br />';
        $i2_row = $index2->fetch(PDO::FETCH_ASSOC);
        if (!isset($_POST['size'][$i]))
        {
            $_POST['size'][$i] = $i2_row['size'];
        }
        if (!isset($_POST['size_id'][$i]))
        {
            $_POST['size_id'][$i] = $i2_row['size_id'];
        }
    }

    if (!isset($_POST['options']))
    {
        $_POST['options'] = $index2_num_rows;
    }
    $_POST['options'] = $_POST['options'] + (isset($_POST['optionsadd']) ? $_POST['optionsadd'] : 0);

    echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="'.$_POST['options'].'" name="options">
                        <input type="hidden" value="wp_edit" name="go">
                        <input type="hidden" name="sended" value="newthumb">
                        <input type="hidden" name="wp_action" value="'.$_POST['wp_action'].'" />
                        <input type="hidden" name="wallpaper_id" value="'.$admin_wp_arr['wallpaper_id'].'" />
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="2"><h3>Wallpaper bearbeiten</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top" width="170">
                                    Wallpaper:<br>
                                    <font class="small">Thumbnail des Wallpapers.</font>
                                </td>
                                <td class="config" valign="top" width="550">
                                   <img src="'.image_url('images/wallpaper/', $admin_wp_arr['wallpaper_name'].'_s').'" />
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Thumbnail neu erstellen:<br>
                                    <font class="small">Erstellt ein neues Thumbnail von der Vorlage.</font>
                                </td>
                                <td class="config" valign="top" align="left">
                                  <input type="submit" value="Jetzt neu erstellen">
                                </td>
                            </tr>
                    </form>
                    <form id="form" action="" enctype="multipart/form-data" method="post">
                        <input id="send" type="hidden" value="0" name="wpedit">
                        <input type="hidden" value="'.$_POST['options'].'" name="options">
                        <input type="hidden" value="wp_edit" name="go">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" name="wp_action" value="'.$_POST['wp_action'].'" />
                        <input type="hidden" name="wallpaper_id" value="'.$admin_wp_arr['wallpaper_id'].'" />
                        <input type="hidden" name="oldname" value="'.$admin_wp_arr['old_name'].'" />
                            <tr>
                                <td class="config" valign="top">
                                    Dateiname:<br>
                                    <font class="small">Name unter dem gespeichert wird.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="wallpaper_name" size="33" maxlength="100" value="'.$admin_wp_arr['wallpaper_name'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Titel des Wallpapers.<br>(optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="wallpaper_title" size="33" maxlength="255" value="'.$admin_wp_arr['wallpaper_title'].'">
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
$index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 2');
while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
{
    echo'
                                        <option value="'.$cat_arr['cat_id'].'"';
                                        if ($cat_arr['cat_id'] == $admin_wp_arr['cat_id'])
                                            echo ' selected="selected"';
                                        echo '>'.$cat_arr['cat_name'].'</option>
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
                                    <input type="hidden" name="wpnew['.$j.']" value="'.(isset($_POST['wpnew'][$j])?$_POST['wpnew'][$j]:0).'">
                                    <input type="hidden" name="size_id['.$j.']" value="'.(isset($_POST['size_id'][$j])?$_POST['size_id'][$j]:'').'" />
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
                                    <input type="file" class="text" name="sizeimg_'.$j.'" size="40">&nbsp;<label for="'.$j.'" class="small middle pointer"><b>L&ouml;schen:</b></label><input class="pointer middle" name="delwp['.$j.']" id="'.$j.'" value="'.$_POST['size_id'][$j].'" type="checkbox" onClick=\'delalert ("'.$j.'", "Soll die Größe '.$i.' des Wallpapers wirklich gelöscht werden?")\'>
                                    <br>'.(isset($admin_sizes_arr['wp_exists'][$j])?$admin_sizes_arr['wp_exists'][$j]:'').'
                                    <br>
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
                                <input type="hidden" name="wpnew['.$j.']" value="1">
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
                                    <input type="submit" name="wp_edit" value="Hinzuf&uuml;gen">
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
  }

/////////////////////////
/// Wallpaper löschen ///
/////////////////////////


  elseif ($_POST['wp_action'] == 'delete')
  {
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'");
    $wallpaper_arr = $index->fetch(PDO::FETCH_ASSOC);

echo '
<form action="" method="post">
<input type="hidden" value="wp_edit" name="go">
<input type="hidden" name="sended" value="delete" />
<input type="hidden" name="wallpaper_id" value="'.$wallpaper_arr['wallpaper_id'].'" />
<table class="content" cellpadding="0" cellspacing="0">
    <tr><td colspan="4"><h3>Wallpaper löschen</h3><hr></td></tr>
       <tr align="left" valign="top">
           <td class="config" colspan="4">
               <b>Wallpaper l&ouml;schen:</b><br><br>
           </td>
       </tr>
       <tr align="left" valign="top">
           <td class="thin" colspan="3">
               Soll das untenstehende Wallpaper wirklich gel&ouml;scht werden?
           </td>
           <td width="25%">
             <input type="submit" value="Ja">  <input type="button" onclick=\'location.href="?go=wp_edit";\' value="Nein">
           </td>
       <tr>
       <tr>
           <td class="config">
               <img src="'.image_url('images/wallpaper/', $wallpaper_arr['wallpaper_name'].'_s', false).'" style="max-width:200px; max-height:100px;"><br>
           </td>
           <td class="thin"><b>'.$wallpaper_arr['wallpaper_name'].'</b>';

           $index2 = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$wallpaper_arr[wallpaper_id]' ORDER BY size_id ASC");
           while ($sizes_arr = $index2->fetch(PDO::FETCH_ASSOC))
           {
             echo '<br>'.$sizes_arr['size'];
           }
           echo'</td>';
           $index2 = $FD->sql()->conn()->query('SELECT cat_name FROM '.$FD->config('pref')."screen_cat WHERE cat_id = $wallpaper_arr[cat_id]");
           $db_cat_name = htmlspecialchars($index2->fetchColumn());
           echo'
           <td class="configthin">
               '.$db_cat_name.'
           </td>
       </tr>
</table></form>';
  }
}

///////////////////////////
/// Kategorie auswählen ///
///////////////////////////

else
{
    if (isset($_POST['wpcatid']))
    {
        settype($_POST['wpcatid'], 'integer');
        $wherecat = 'WHERE cat_id = ' . $_POST['wpcatid'];
    }

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="wp_edit" name="go">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td><h3>Kategorie ausw&auml;hlen</h3><hr></td></tr>
                            <tr>
                                <td class="thin" width="40%">
                                    Dateien der Kategorie
                                    <select name="wpcatid">
    ';
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 2');
    while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        $sele = ($_POST['wpcatid'] == $cat_arr['cat_id']) ? 'selected' : '';
        echo'
                                        <option value="'.$cat_arr['cat_id'].'" '.$sele.'>
                                            '.$cat_arr['cat_name'].'
                                        </option>
        ';
    }
    echo'
                                    </select>
                                    <input type="submit" value="Anzeigen">
                                </td>
                            </tr>
                        </table>
                    </form><br>
    ';


///////////////////////////
/// Wallpaper auswählen ///
///////////////////////////

    if (isset($_POST['wpcatid']))
    {
        echo'
                    <form action="" method="post">
                        <input type="hidden" value="wp_edit" name="go">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="4"><h3>Wallpaper ausw&auml;hlen</h3><hr></td></tr>
                            <tr>
                                <td class="config" width="25%">
                                    Wallpaper
                                </td>
                                <td class="config" width="30%">
                                    Name / Gr&ouml;&szlig;en
                                </td>
                                <td class="config" width="20%">
                                    Kategorie
                                </td>
                                <td class="config" width="25%">
                                </td>
                            </tr>
        ';
        $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper $wherecat ORDER BY wallpaper_id DESC");
        while ($wallpaper_arr = $index->fetch(PDO::FETCH_ASSOC))
        {
            echo'
                    <form action="" method="post">
                        <input type="hidden" name="wallpaper_id" value="'.$wallpaper_arr['wallpaper_id'].'" />
                        <input type="hidden" value="wp_edit" name="go">
                            <tr>
                                <td class="thin">
                                    <img src="'.image_url('images/wallpaper/', killhtml(($wallpaper_arr['wallpaper_name'])).'_s').'" style="max-width:200px; max-height:100px;"><br>

                                </td>
                                <td class="thin">'.killhtml(($wallpaper_arr['wallpaper_name']));

            $index2 = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$wallpaper_arr[wallpaper_id]' ORDER BY size_id ASC");
            $sizes = array();
            while ($sizes_arr = $index2->fetch(PDO::FETCH_ASSOC))
            {
              $sizes[] = $sizes_arr['size'];
            }
            if (!empty($sizes)) {
                echo '<br><span class="small">'.implode(', ', $sizes).'</span>';
            }
            echo'</td>';
            $index2 = $FD->sql()->conn()->query('SELECT cat_name FROM '.$FD->config('pref')."screen_cat WHERE cat_id = $wallpaper_arr[cat_id]");
            $db_cat_name = $index2->fetchColumn();

            echo'
                                <td class="thin">
                                    '.killhtml(($db_cat_name)).'
                                </td>
                                <td class="thin">
                                    <select name="wp_action" size="1" class="text">
                                        <option value="edit">Bearbeiten</option>
                                        <option value="delete">L&ouml;schen</option>
                                    </select> <input type="submit" value="Los" />
                                </td>
                            </tr>
                    </form>
            ';
        }
        echo'</table>';
    }
}
?>
