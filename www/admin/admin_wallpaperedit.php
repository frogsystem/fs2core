<?php
/////////////////////
//// Config laden ///
/////////////////////
$index = mysql_query('SELECT * FROM '.$FD->config('pref').'screen_config');  // WP Konfiguration auslesen
$config_arr = mysql_fetch_assoc($index);

////////////////////////////
//// Wallpaper editieren ///
////////////////////////////
if (isset($_POST['wallpaper_id']) AND $_POST['sended'] == 'edit' AND isset($_POST['size'][0]) AND isset($_POST['wpedit']))
{
    $_POST['wallpaper_name'] = savesql($_POST['wallpaper_name']);
    $_POST['wallpaper_title'] = savesql($_POST['wallpaper_title']);

    $index = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_name = '$_POST[wallpaper_name]'", $FD->sql()->conn() );

    if (count($_POST['size']) == count(array_unique($_POST['size'])) AND (mysql_num_rows($index)==0 OR $_POST['wallpaper_name'] == $_POST['oldname']))
    {
    //IF Beginn

    //security functions
    $_POST['catid'] = intval($_POST['catid']);
    $_POST['wallpaper_id'] = intval($_POST['wallpaper_id']);

    $update = 'UPDATE '.$FD->config('pref')."wallpaper
               SET wallpaper_name = '$_POST[wallpaper_name]',
                   wallpaper_title  = '$_POST[wallpaper_title]',
                   cat_id      = '$_POST[catid]'
               WHERE wallpaper_id = $_POST[wallpaper_id]";
    mysql_query($update, $FD->sql()->conn() );

    // Files  aktualisieren
        for ($i=0; $i<count($_POST['size']); $i++)
        {
            if ($_POST['delwp'][$i])
            {
                settype($_POST['delwp'][$i], 'integer');
                $index = mysql_query('SELECT size FROM '.$FD->config('pref')."wallpaper_sizes WHERE size_id = '".$_POST['delwp'][$i]."'", $FD->sql()->conn() );
                $size_name = mysql_result($index, 'size');
                mysql_query('DELETE FROM '.$FD->config('pref')."wallpaper_sizes WHERE size_id = '".$_POST['delwp'][$i]."'", $FD->sql()->conn() );
                image_delete('images/wallpaper/', "$_POST[oldname]_$size_name");
            }
            else
            {
                $filesname = "sizeimg_$i";
                $_POST['size'][$i] = savesql($_POST['size'][$i]);
                if (isset($_FILES[$filesname]) && $_POST['wpnew'][$i]==1 && $_POST['size'][$i]!='')
                {
                    $upload = upload_img($_FILES[$filesname], 'images/wallpaper/', $_POST['oldname'].'_'.$_POST['size'][$i].'a', $config_arr['wp_size']*1024, $config_arr['wp_x'], $config_arr['wp_y']);
                    systext(upload_img_notice($upload));
                    switch ($upload)
                    {
                    case 0:
                        $insert = 'INSERT INTO '.$FD->config('pref')."wallpaper_sizes (wallpaper_id, size)
                                   VALUES ('".$_POST['wallpaper_id']."',
                                       '".$_POST['size'][$i]."')";
                        mysql_query($insert, $FD->sql()->conn() );
                    break;
                    }
                }
                elseif ($_POST['wpnew'][$i]==0)
                {
                    $_POST['size_id'][$i] = intval($_POST['size_id'][$i]);
                    $index = mysql_query('SELECT size FROM '.$FD->config('pref')."wallpaper_sizes WHERE size_id = '".$_POST['size_id'][$i]."'", $FD->sql()->conn() );
                    $size_name = mysql_result($index, 'size');

                    image_rename('images/wallpaper/', $_POST['oldname'].'_'.$size_name, $_POST['oldname'].'_'.$_POST['size'][$i].'a');

                    $update = 'UPDATE '.$FD->config('pref')."wallpaper_sizes
                               SET size = '".$_POST['size'][$i]."'
                               WHERE size_id = ".$_POST['size_id'][$i];
                    mysql_query($update, $FD->sql()->conn() );

                    if (isset($_FILES[$filesname]))
                    {
                        $upload = upload_img($_FILES[$filesname], 'images/wallpaper/', $_POST['oldname'].'_'.$_POST['size'][$i].'a', $config_arr['wp_size']*1024, $config_arr['wp_x'], $config_arr['wp_y']);
                        systext(upload_img_notice($upload));
                    }
                }
            }
        }

     //Rename
     $index2 = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]'", $FD->sql()->conn() );
     while ($sizes_arr = mysql_fetch_assoc($index2))
     {
          image_rename('images/wallpaper/', $_POST['oldname'].'_'.$sizes_arr['size'].'a', $_POST['wallpaper_name'].'_'.$sizes_arr['size']);
     }
     image_rename('images/wallpaper/', $_POST['oldname'].'_s', $_POST['wallpaper_name'].'_s');

   //IF Ende
   }
   else
   {
       systext('Fehler bei der Bearbeitung:<br><br>
       - Jede Gr&ouml;%szlig;e darf nur einmal vorkommen<br>
       - Der Wallpapername muss einzigartig sein<br><br>
       Da nicht beide Bedingungen nicht erf&uuml;llt sind, wurde die Bearbeitung abgebrochen!');
   }
}
//////////////////////////
//// Wallpaper löschen ///
//////////////////////////
elseif (isset($_POST['wallpaper_id']) AND $_POST['sended'] == 'delete')
{
    //security functions
    $_POST['wallpaper_id'] = intval($_POST['wallpaper_id']);

    $index = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'", $FD->sql()->conn() );
    $wp_del_array = mysql_fetch_assoc($index);
    mysql_query('DELETE FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'", $FD->sql()->conn() );
    image_delete('images/wallpaper/', $wp_del_array['wallpaper_name'].'_s');

    $index = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]'", $FD->sql()->conn() );
    while ($wp_sizes_del_array = mysql_fetch_assoc($index))
    {
      image_delete('images/wallpaper/', $wp_del_array['wallpaper_name'].'_'.$wp_sizes_del_array['size']);
    }
    mysql_query('DELETE FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]'", $FD->sql()->conn() );

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
    if ($_POST['sended'] == 'newthumb')
    {
        $index = mysql_query('SELECT * FROM '.$FD->config('pref').'screen_config');  // WP Konfiguration auslesen
        $config_arr = mysql_fetch_assoc($index);

        $index = mysql_query('SELECT wallpaper_name FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'", $FD->sql()->conn() );
        $wp_name = mysql_result($index,0,'wallpaper_name');

        $index = mysql_query('SELECT size FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]' LIMIT 1", $FD->sql()->conn() );
        $wp_size = mysql_result($index,0,'size');

        image_delete('images/wallpaper/', $wp_name.'_s');

        $newthumb = create_thumb_from(image_url('images/wallpaper/', $wp_name.'_'.$wp_size, FALSE, TRUE), $config_arr['wp_thumb_x'], $config_arr['wp_thumb_y']);

        image_rename('images/wallpaper/', $wp_name.'_'.$wp_size.'_s', $wp_name.'_s');

        systext(create_thumb_notice($newthumb).'<br />(Cache leeren nicht vergessen!)');
    }

    $index = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'", $FD->sql()->conn() );
    $admin_wp_arr = mysql_fetch_assoc($index);

    $admin_wp_arr['old_name'] = killhtml($admin_wp_arr['wallpaper_name']);

    $error_message = '';

    if (isset($_POST['sended']) && $_POST['sended'] !='newthumb' && !isset($_POST['wp_add']) )
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

    $index2 = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$_POST[wallpaper_id]' ORDER BY size_id ASC", $FD->sql()->conn() );
    $admin_sizes_arr = mysql_fetch_assoc($index2);

    for($i=0; $i<mysql_num_rows($index2); $i++)
    {
        $admin_sizes_arr['wp_exists'][$i] = '<font class="small">Dieses Wallpaper existiert bereits!<br />
        W&auml;hlen sie nur ein Neues aus, wenn das Alte &uuml;berschrieben werden soll!</font><br />';
        if (!isset($_POST['size'][$i]))
        {
            $_POST['size'][$i] = mysql_result($index2, $i, 'size');
        }
        if (!isset($_POST['size_id'][$i]))
        {
            $_POST['size_id'][$i] = mysql_result($index2, $i, 'size_id');
        }
    }

    if (!isset($_POST['options']))
    {
        $_POST['options'] = mysql_num_rows($index2);
    }
    $_POST['options'] = $_POST['options'] + $_POST['optionsadd'];

    echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="'.$_POST['options'].'" name="options">
                        <input type="hidden" value="wp_edit" name="go">
                        <input type="hidden" name="sended" value="newthumb">
                        <input type="hidden" name="wp_action" value="'.$_POST['wp_action'].'" />
                        <input type="hidden" name="wallpaper_id" value="'.$admin_wp_arr['wallpaper_id'].'" />
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
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
                                  <input class="button" type="submit" value="Jetzt neu erstellen">
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
$index = mysql_query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 2', $FD->sql()->conn() );
while ($cat_arr = mysql_fetch_assoc($index))
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
        if ($_POST['size'][$j])
        {
            echo'
                            <tr>
                                <td class="config" valign="top">
                                    Gr&ouml;&szlig;e '.$i.':<br>
                                    <font class="small">Format und WP ausw&auml;hlen.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input type="hidden" name="wpnew['.$j.']" value="'.$_POST['wpnew'][$j].'">
                                    <input type="hidden" name="size_id['.$j.']" value="'.$_POST['size_id'][$j].'" />
                                    <input class="text center" id="size'.$j.'" name="size['.$j.']" size="13" maxlength="30" value="'.$_POST['size'][$j].'">&nbsp;&nbsp;
                                    <input type="file" class="text" name="sizeimg_'.$j.'" size="25">&nbsp;
                                    <label for="'.$j.'" class="small middle pointer"><b>L&ouml;schen:</b></label><input class="pointer middle" name="delwp['.$j.']" id="'.$j.'" value="'.$_POST['size_id'][$j].'" type="checkbox" onClick=\'delalert ("'.$j.'", "Soll die Größe '.$i.' des Wallpapers wirklich gelöscht werden?")\'><br>
                                    '.$admin_sizes_arr['wp_exists'][$j].'<br>
                                    <fieldset>
                                        <legend class="small"><b>Schnellauswahl</b></legend>
                                        <input style="margin-bottom:5px;" class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="800x600";\' value="800x600">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x768";\' value="1280x768">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x1024";\' value="1280x1024">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1440x900";\' value="1440x900">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1920x1080";\' value="1920x1080"><br>
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1024x768";\' value="1024x768">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x800";\' value="1280x800">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1366x768";\' value="1366x768">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1680x1050";\' value="1680x1050">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1920x1200";\' value="1920x1200">
                                    </fieldset><br>
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
                                    <input class="text center" id="size'.$j.'" name="size['.$j.']" size="13" maxlength="30" value="">&nbsp;&nbsp;
                                    <input type="file" class="text" name="sizeimg_'.$j.'" size="33"><br><br>
                                    <fieldset>
                                        <legend class="small"><b>Schnellauswahl</b></legend>
                                        <input style="margin-bottom:5px;" class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="800x600";\' value="800x600">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x768";\' value="1280x768">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x1024";\' value="1280x1024">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1440x900";\' value="1440x900">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1920x1080";\' value="1920x1080"><br>
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1024x768";\' value="1024x768">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1280x800";\' value="1280x800">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1366x768";\' value="1366x768">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1680x1050";\' value="1680x1050">
                                        <input class="size-button" type="button" onClick=\'document.getElementById("size'.$j.'").value="1920x1200";\' value="1920x1200">
                                    </fieldset><br>
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
                                    <input class="button" type="submit" name="wp_add" value="Hinzuf&uuml;gen">
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
  }

/////////////////////////
/// Wallpaper löschen ///
/////////////////////////


  elseif ($_POST['wp_action'] == 'delete')
  {
    $index = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper WHERE wallpaper_id = '$_POST[wallpaper_id]'", $FD->sql()->conn() );
    $wallpaper_arr = mysql_fetch_assoc($index);

echo '
<form action="" method="post">
<table width="100%" cellpadding="4" cellspacing="0">
<input type="hidden" value="wp_edit" name="go">
<input type="hidden" name="sended" value="delete" />
<input type="hidden" name="wallpaper_id" value="'.$wallpaper_arr['wallpaper_id'].'" />
       <tr align="left" valign="top">
           <td class="config" colspan="4">
               <b>Wallpaper l&ouml;schen:</b><br><br>
           </td>
       </tr>
       <tr align="left" valign="top">
           <td class="config" colspan="3">
               Soll das untenstehende Wallpaper wirklich gel&ouml;scht werden?
           </td>
           <td width="25%">
             <input type="submit" value="Ja" class="button">  <input type="button" onclick=\'location.href="?go=wp_edit";\' value="Nein" class="button">
           </td>
       <tr>
       <tr>
           <td class="config">
               <img src="'.image_url('images/wallpaper/', $wallpaper_arr['wallpaper_name'].'_s', false).'" width="100" height="75" alt=""><br>
           </td>
           <td class="configthin"><b>'.$wallpaper_arr['wallpaper_name'].'</b>';

           $index2 = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$wallpaper_arr[wallpaper_id]' ORDER BY size_id ASC", $FD->sql()->conn() );
           while ($sizes_arr = mysql_fetch_assoc($index2))
           {
             echo '<br>'.$sizes_arr['size'];
           }
           echo'</td>';
           $index2 = mysql_query('SELECT cat_name FROM '.$FD->config('pref')."screen_cat WHERE cat_id = $wallpaper_arr[cat_id]", $FD->sql()->conn() );
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
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="40%">
                                    Dateien der Kategorie
                                    <select name="wpcatid">
    ';
    $index = mysql_query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 2', $FD->sql()->conn() );
    while ($cat_arr = mysql_fetch_assoc($index))
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
                                    <input class="button" type="submit" value="Anzeigen">
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
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
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
        $index = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper $wherecat ORDER BY wallpaper_id DESC", $FD->sql()->conn() );
        while ($wallpaper_arr = mysql_fetch_assoc($index))
        {
            echo'
                    <form action="" method="post">
                        <input type="hidden" name="wallpaper_id" value="'.$wallpaper_arr['wallpaper_id'].'" />
                        <input type="hidden" value="wp_edit" name="go">
                            <tr>
                                <td class="config">
                                    <img src="'.image_url('images/wallpaper/', $wallpaper_arr['wallpaper_name'].'_s').'" width="100" height="75" alt=""><br>

                                </td>
                                <td class="configthin"><b>'.$wallpaper_arr['wallpaper_name'].'</b>';

            $index2 = mysql_query('SELECT * FROM '.$FD->config('pref')."wallpaper_sizes WHERE wallpaper_id = '$wallpaper_arr[wallpaper_id]' ORDER BY size_id ASC", $FD->sql()->conn() );
            while ($sizes_arr = mysql_fetch_assoc($index2))
            {
              echo '<br>'.$sizes_arr['size'];
            }
            echo'</td>';
            $index2 = mysql_query('SELECT cat_name FROM '.$FD->config('pref')."screen_cat WHERE cat_id = $wallpaper_arr[cat_id]", $FD->sql()->conn() );
            echo'
                                <td class="configthin">
                                    '.$db_cat_name.'
                                </td>
                                <td class="configthin">
                                    <select name="wp_action" size="1" class="text">
                                        <option value="edit">Bearbeiten</option>
                                        <option value="delete">L&ouml;schen</option>
                                    </select> <input class="button" type="submit" value="Los" />
                                </td>
                            </tr>
                    </form>
            ';
        }
        echo'</table>';
    }
}
?>
