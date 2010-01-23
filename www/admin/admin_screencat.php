<?php

//////////////////////////////
//// Kategorie bearbeiten ////
//////////////////////////////

if ($_POST['cat_id'] && $_POST['cat_name'] && $_POST['sended'] == "edit")
{
    $_POST[cat_name] = savesql($_POST[cat_name]);

    mysql_query("UPDATE ".$global_config_arr[pref]."screen_cat
                 SET cat_name = '$_POST[cat_name]',
                     cat_type = '$_POST[cat_type]',
                     cat_visibility = '$_POST[cat_visibility]'
                 WHERE cat_id = '$_POST[cat_id]'", $db);
    systext("Kategorie wurde aktualisiert");
}

///////////////////////////
//// Kategorie löschen ////
///////////////////////////
elseif ($_POST['cat_id'] && $_POST['sended'] == "delete")
{
  mysql_query("DELETE FROM ".$global_config_arr[pref]."screen_cat
               WHERE cat_id = '$_POST[cat_id]'", $db);

  mysql_query("UPDATE ".$global_config_arr[pref]."screen
               SET cat_id = '$_POST[cat_move_to]'
               WHERE cat_id = '$_POST[cat_id]'", $db);

  systext("Die Kategorie wurde gelöscht!");
}

//////////////////////////
/// Kategorie Funktion ///
//////////////////////////

elseif ($_POST['cat_id'] AND $_POST['cat_action'])
{

////////////////////////////
/// Kategorie bearbeiten ///
////////////////////////////


  if ($_POST['cat_action'] == "edit")
  {
    $index = mysql_query("select * from ".$global_config_arr[pref]."screen_cat WHERE cat_id = '$_POST[cat_id]'", $db);
    $admin_cat_arr = mysql_fetch_assoc($index);

    $admin_cat_arr['cat_name'] = killhtml($admin_cat_arr['cat_name']);
    
    $error_message = "";

    if (isset($_POST['sended']))
    {
      $error_message = "Bitte füllen Sie <b>alle Pflichfelder</b> aus!";
    }
    systext($error_message);
    
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="gallery_cat" name="go">
                        <input type="hidden" name="sended" value="edit" />
                        <input type="hidden" name="cat_action" value="'.$_POST[cat_action].'" />
                        <input type="hidden" name="cat_id" value="'.$admin_cat_arr[cat_id].'" />
                        <input type="hidden" name="oldname" value="'.$admin_cat_arr[cat_name].'" />
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config" valign="top">
                                    Name:<br>
                                    <font class="small">Name der Kategorie</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="cat_name" size="33" maxlength="100"
                                     value="'.$admin_cat_arr[cat_name].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Art:<br>
                                    <font class="small">Kategorie-Typ</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="cat_type" size="1">
                                        <option value="1"';
                                        if ($admin_cat_arr[cat_type] == 1)
                                          echo ' selected=selected';
                                        echo'
                                        >Screenshots / Zufallsbild</option>
                                        <option value="2"';
                                        if ($admin_cat_arr[cat_type] == 2)
                                          echo ' selected=selected';
                                        echo'>Wallpaper</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Sichtbarkeit:<br>
                                    <font class="small">Wird die Kategorie angezeigt</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="cat_visibility" size="1">
                                        <option value="1"';
                                        if ($admin_cat_arr[cat_visibility] == 1)
                                          echo ' selected=selected';
                                        echo'>vollständig sichtbar</option>
                                        <option value="2"';
                                        if ($admin_cat_arr[cat_visibility] == 2)
                                          echo ' selected=selected';
                                        echo'>nicht in Auswahl verfügbar</option>
                                        <option value="0"';
                                        if ($admin_cat_arr[cat_visibility] == 0)
                                          echo ' selected=selected';
                                        echo'>nicht aufrufbar</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Speichern" class="button" /> <input type="reset" value="Zurücksetzen" class="button" />
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
  }
  
/////////////////////////
/// Kategorie löschen ///
/////////////////////////

  
  elseif ($_POST['cat_action'] == "delete")
  {
    $index = mysql_query("select * from ".$global_config_arr[pref]."screen_cat", $db);

    if (mysql_num_rows($index) > 1)
    {

    $index = mysql_query("select * from ".$global_config_arr[pref]."screen_cat WHERE cat_id = '$_POST[cat_id]'", $db);
    $admin_cat_arr = mysql_fetch_assoc($index);

    $admin_cat_arr['cat_name'] = killhtml($admin_cat_arr['cat_name']);

echo '
<form action="" method="post">
<table width="100%" cellpadding="4" cellspacing="0">
<input type="hidden" value="gallery_cat" name="go">
<input type="hidden" value="'.session_id().'" name="PHPSESSID">
<input type="hidden" name="sended" value="delete" />
<input type="hidden" name="cat_id" value="'.$admin_cat_arr[cat_id].'" />
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
             <input type="submit" value="Ja" class="button" />  <input type="button" onclick=\'location.href="?go=gallery_cat";\' value="Nein" class="button" />
           </td>
       </tr>
       <tr><td height="10px"></td></tr>
       <tr align="left" valign="top">
           <td class="config">
              Bilder der gelöschten Kategorie verschieben nach:
           </td>
           <td>
             <select name="cat_move_to" size="1" class="text">';

  $index = mysql_query("select * from ".$global_config_arr[pref]."screen_cat WHERE cat_id != '$admin_cat_arr[cat_id]' ORDER BY cat_name", $db);
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
                <input type="button" onclick=\'location.href="?go=gallery_cat";\' value="Zurück zur Übersicht" class="button" />
              </td>
            </tr>

      </table>';
    }
  }
}
///////////////////////////
/// Kategorie auswählen ///
///////////////////////////

else
{
    echo'
                        <table border="0" cellpadding="2" cellspacing="0" width="600">
                            <tr>
                                <td class="config" width="20%">
                                    Name
                                </td>
                                <td class="config" width="6%">
                                    Pics
                                </td>
                                <td class="config" width="15%">
                                    Art
                                </td>
                                <td class="config" width="19%">
                                    Sichtbarkeit
                                </td>
                                <td class="config" width="15%">
                                    erstellt am
                                </td>
                                <td class="config" width="25%">
                                </td>
                            </tr>
    ';
    $index = mysql_query("select * from ".$global_config_arr[pref]."screen_cat order by cat_date desc", $db);
    while ($cat_arr = mysql_fetch_assoc($index))
    {
        $cat_arr[cat_date] = date("d.m.Y", $cat_arr[cat_date]);

        if ( $cat_arr[cat_type] == 2 ) {
            $number_index = mysql_query("SELECT COUNT(wallpaper_id) AS number FROM ".$global_config_arr[pref]."wallpaper WHERE cat_id = $cat_arr[cat_id]", $db);
        } else {
            $number_index = mysql_query("SELECT COUNT(screen_id) AS number FROM ".$global_config_arr[pref]."screen WHERE cat_id = $cat_arr[cat_id]", $db);
        }
        



        $number_rows = mysql_result($number_index, 0, "number");
        echo'
                    <form action="" method="post">
                        <input type="hidden" name="cat_id" value="'.$cat_arr[cat_id].'" />
                        <input type="hidden" value="gallery_cat" name="go">
                            <tr>
                                <td class="configthin">
                                    '.$cat_arr[cat_name].'
                                </td>
                                <td class="configthin">
                                    '.$number_rows.'
                                </td>
                                <td class="configthin">';
                                    switch ($cat_arr[cat_type]) {
                                    case 1:
                                        echo "Screenshots";
                                        break;
                                    case 2:
                                       echo "Wallpaper";
                                       break;
                                    }
                                    echo'
                                </td>
                                <td class="configthin">';
                                    switch ($cat_arr[cat_visibility]) {
                                    case 0:
                                        echo "nicht aufrufbar";
                                        break;
                                    case 1:
                                        echo "voll sichtbar";
                                        break;
                                    case 2:
                                       echo "nicht in Auswahl";
                                       break;
                                    }
                                    echo'
                                </td>
                                <td class="configthin">
                                    '.$cat_arr[cat_date].'
                                </td>
                                <td class="configthin">
                                    <select name="cat_action" size="1" class="text">
                                        <option value="edit">Bearbeiten</option>
                                        <option value="delete">Löschen</option>
                                    </select> <input class="button" type="submit" value="Los" />
                                </td>
                            </tr>
                    </form>
        ';
    }
    echo'</table>';
}
?>