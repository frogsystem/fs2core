<?php
//////////////////////
//// Config laden ////
//////////////////////
$index = mysql_query("select * from fs_news_config", $db);
$admin_news_config_arr = mysql_fetch_assoc($index);

//////////////////////////////////
///// Kategorie aktualisieren ////
//////////////////////////////////

if ($_POST['cat_id'] AND $_POST['name'] AND $_POST['sended'] == "edit")
{
    $_POST[name] = savesql($_POST[name]);
    $_POST[description] = savesql($_POST[description]);

    mysql_query("UPDATE fs_news_cat
                 SET cat_name = '$_POST[name]',
                     cat_description = '$_POST[description]'
                 WHERE cat_id = '$_POST[cat_id]'", $db);
    systext("Die Kategorie wurde aktualisiert!");

    if ($_POST['cat_pic_delete'] == 1)
    {
      if (image_delete("../images/news_cat/", $_POST[cat_id]))
      {
        systext('Das Bild wurde erfolgreich gelöscht!');
      }
      else
      {
        systext('Das Bild konnte nicht gelöscht werden, da es nicht existiert!');
      }
    }
    elseif ($_FILES['cat_pic']['name'] != "")
    {
      $upload = upload_img($_FILES['cat_pic'], "../images/news_cat/", $_POST[cat_id], 5*1024*1024, $admin_news_config_arr[cat_pic_x], $admin_news_config_arr[cat_pic_y]);
      systext(upload_img_notice($upload));
    }

}
elseif ($_POST['cat_id'] AND $_POST['sended'] == "delete")
{
  mysql_query("DELETE FROM fs_news_cat
               WHERE cat_id = '$_POST[cat_id]'", $db);

  mysql_query("UPDATE fs_news
               SET cat_id = '$_POST[cat_move_to]'
               WHERE cat_id = '$_POST[cat_id]'", $db);

  systext("Die Kategorie wurde gelöscht!");

  if (image_delete("../images/news_cat/", $_POST[cat_id]))
  {
    systext('Das Bild wurde erfolgreich gelöscht!');
  }
}

elseif ($_POST['cat_id'] AND $_POST['cat_action'])
{

  if ($_POST['cat_action'] == "edit")
  {
    $index = mysql_query("select * from fs_news_cat WHERE cat_id = '$_POST[cat_id]'", $db);
    $admin_cat_arr = mysql_fetch_assoc($index);

    $admin_cat_arr['cat_name'] = killhtml($admin_cat_arr['cat_name']);
    $admin_cat_arr['cat_description'] = killhtml($admin_cat_arr['cat_description']);

    $error_message = "";

    if (isset($_POST['sended']))
    {
      $admin_cat_arr['cat_description'] = $_POST['description'];
      $error_message = "Bitte füllen Sie <b>alle Pflichfelder</b> aus!";
    }

systext($error_message);
echo '
<form action="" method="post" enctype="multipart/form-data">
<table width="100%" cellpadding="4" cellspacing="0">
<input type="hidden" name="sended" value="edit" />
<input type="hidden" name="cat_action" value="'.$_POST[cat_action].'" />
<input type="hidden" name="cat_id" value="'.$admin_cat_arr[cat_id].'" />
<input type="hidden" name="oldname" value="'.$admin_cat_arr[cat_name].'" />
<input type="hidden" value="news_cat_manage" name="go">
<input type="hidden" value="'.session_id().'" name="PHPSESSID">
       <tr align="left" valign="top">
           <td class="config">
               <b>Kategorie bearbeiten:</b><br><br>
           </td>
           <td></td>
       </tr>
       <tr align="left" valign="top">
           <td class="config">
               Name:<br>
               <font class="small">Name der Kategorie</font>
           </td>
           <td>
             <input name="name" size="40" maxlength="100" value="'.$admin_cat_arr['cat_name'].'" class="text" />
           </td>
       </tr>
       <tr align="left" valign="top">
           <td class="config">
             Bild: <font class="small">(optional)</font>';
             if (image_exists("../images/news_cat/", $admin_cat_arr[cat_id]))
               echo '<br><br><img src="'.image_url("../images/news_cat/", $admin_cat_arr[cat_id]).'" alt="" border="0"><br><br>';
             echo'
           </td>
           <td class="config">
             <input name="cat_pic" type="file" size="40" class="text" /><br />
               <font class="small">
                 [max. '.$admin_news_config_arr[cat_pic_x].' x '.$admin_news_config_arr[cat_pic_y].' Pixel] [max. 1 MB]
               </font>';
             if (image_exists("../images/news_cat/", $admin_cat_arr[cat_id]))
               echo'
             <br>
             <font class="small"><b>Nur auswählen, wenn das bisherige Bild überschrieben werden soll!</b></font><br><br>
             <input type="checkbox" name="cat_pic_delete" id="cpd" value="1" onClick=\'delalert ("cpd", "Soll das Kategorie Bild wirklich gelöscht werden?")\' /> <font class="small"><b>Bild löschen?</b></font><br><br>';
           echo'
           </td>
       </tr>
       <tr align="left" valign="top">
           <td class="config">
               Beschreibung: <font class="small">(optional)</font><br>
               <font class="small">Beschreibung der Kategorie</font>
           </td>
           <td>
             <textarea class="text" name="description" rows="2" cols="50" wrap="virtual">'.$admin_cat_arr['cat_description'].'</textarea>
           </td>
       </tr>
       <tr align="left" valign="top"><td></td>
           <td class="config">
               <input type="submit" value="Speichern" class="button" /> <input type="reset" value="Zurücksetzen" class="button" />
           </td>
       </tr>
</table></form>';
  }
  elseif ($_POST['cat_action'] == "delete")
  {
    $index = mysql_query("select * from fs_news_cat", $db);

    if (mysql_num_rows($index) > 1)
    {

    $index = mysql_query("select * from fs_news_cat WHERE cat_id = '$_POST[cat_id]'", $db);
    $admin_cat_arr = mysql_fetch_assoc($index);

    $admin_cat_arr['cat_name'] = killhtml($admin_cat_arr['cat_name']);

echo '
<form action="" method="post">
<table width="100%" cellpadding="4" cellspacing="0">
<input type="hidden" name="sended" value="delete" />
<input type="hidden" name="cat_id" value="'.$admin_cat_arr[cat_id].'" />
<input type="hidden" name="oldname" value="'.$admin_cat_arr[cat_name].'" />
<input type="hidden" value="news_cat_manage" name="go">
<input type="hidden" value="'.session_id().'" name="PHPSESSID">
       <tr align="left" valign="top">
           <td class="config">
               <b>Kategorie löschen:</b><br><br>
           </td>
           <td></td>
       </tr>
       <tr align="left" valign="top">
           <td width="50%" class="config">
               Soll die Kategorie "'.$admin_cat_arr[cat_name].'" wirklich gelöscht werden?
           </td>
           <td width="50%">
             <input type="submit" value="Ja" class="button" />  <input type="button" onclick=\'location.href="?mid=content&go=news_cat_manage";\' value="Nein" class="button" />
           </td>
       </tr>
       <tr><td height="10px"></td></tr>
       <tr align="left" valign="top">
           <td class="config">
              News der gelöschten Kategorie verschieben nach:
           </td>
           <td>
             <select name="cat_move_to" size="1"  class="text">';

  $index = mysql_query("select * from fs_news_cat WHERE cat_id != '$admin_cat_arr[cat_id]' ORDER BY cat_name", $db);
  while ($admin_cat_move_arr = mysql_fetch_assoc($index))
  {
    echo'<option value="'.$admin_cat_move_arr[cat_id].'">'.$admin_cat_move_arr[cat_name].'</option>';
  }

echo'
             </select>
           </td>
       </tr>
</table></form>';
    }
    else
    {
      echo '<table cellpadding="0" cellspacing="0" width="100%">
            <tr valign="top">
              <td class="config">
                Die letzte Kategorie kann nicht gelöscht werden.<br>
                Bitte legen Sie zuerst eine neue Kategorie an.</td>
              <td>
                <input type="button" onclick=\'location.href="?mid=content&go=news_cat_manage";\' value="Zurück zur Übersicht" class="button" />
              </td>
            </tr>

      </table>';
    }
  }
}
else
{
  systext('Wählen Sie die Kategorie aus, die Sie verändern möchten:<br><br>');
  echo '<table width="100%" cellspacing="0" cellpadding="4">';
  $index = mysql_query("select * from fs_news_cat ORDER BY cat_name", $db);
  while ($admin_cat_arr = mysql_fetch_assoc($index))
  {
    echo '<form action="" method="post">
       <input type="hidden" name="cat_id" value="'.$admin_cat_arr[cat_id].'" />
       <input type="hidden" value="news_cat_manage" name="go">
       <input type="hidden" value="'.session_id().'" name="PHPSESSID">
       <tr align="left" valign="middle">
           <td class="config">';
    if (image_exists("../images/news_cat/", $admin_cat_arr[cat_id]))
      echo '<img src="'.image_url("../images/news_cat/", $admin_cat_arr[cat_id]).'" alt="" border="0">';
    echo'
           </td>
           <td class="config">
             <b>'.$admin_cat_arr[cat_name].'</b><br>
             <font class="small">'.$admin_cat_arr[cat_description].'</font>
           </td>
           <td class="config">
             <select name="cat_action" size="1" class="text">
              <option value="edit">Bearbeiten</option>
              <option value="delete">Löschen</option>
             </select> <input class="button" type="submit" value="Los" />
           </td>
       </tr>
       </form>';
  }
  echo '</table>';
}
?>