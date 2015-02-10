<?php if (!defined('ACP_GO')) die('Unauthorized access!');

///////////////////////
//// Edit Category ////
///////////////////////

if (isset($_POST['cat_id']) && isset($_POST['cat_name']) && !emptystr($_POST['cat_name']) && $_POST['sended'] == 'edit')
{
    $_POST['cat_id'] = intval($_POST['cat_id']);
    $_POST['cat_type'] = intval($_POST['cat_type']);
    $_POST['cat_visibility'] = intval($_POST['cat_visibility']);

    $stmt = $FD->db()->conn()->prepare('UPDATE '.$FD->env('DB_PREFIX')."screen_cat
                 SET cat_name = ?,
                     cat_type = '$_POST[cat_type]',
                     cat_visibility = '$_POST[cat_visibility]'
                 WHERE cat_id = '$_POST[cat_id]'");
    $stmt->execute(array($_POST['cat_name']));

    systext($FD->text('admin', 'changes_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
}

/////////////////////////
//// Delete Category ////
/////////////////////////
elseif (isset($_POST['cat_id']) && isset($_POST['sended']) && $_POST['sended'] == 'delete')
{
  //security functions
  $_POST['cat_id'] = intval($_POST['cat_id']);
  $_POST['cat_move_to'] = intval($_POST['cat_move_to']);

  $FD->db()->conn()->exec('DELETE FROM '.$FD->env('DB_PREFIX')."screen_cat
               WHERE cat_id = '$_POST[cat_id]'");

  $FD->db()->conn()->exec('UPDATE '.$FD->env('DB_PREFIX')."screen
               SET cat_id = '$_POST[cat_move_to]'
               WHERE cat_id = '$_POST[cat_id]'");

  systext($FD->text('admin', 'cat_deleted'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_trash_ok'));
}

//////////////////////////
/// Category Functions ///
//////////////////////////

elseif (isset($_POST['cat_id']) AND isset($_POST['cat_action']))
{

/////////////////////
/// Edit Category ///
/////////////////////


  //security functions
  $_POST['cat_id'] = intval($_POST['cat_id']);

  if ($_POST['cat_action'] == 'edit')
  {
    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX')."screen_cat WHERE cat_id = '$_POST[cat_id]'");
    $admin_cat_arr = $index->fetch(PDO::FETCH_ASSOC);

    $admin_cat_arr['cat_name'] = killhtml($admin_cat_arr['cat_name']);

    $error_message = '';

    if (isset($_POST['sended']))
    {
      $error_message = 'Bitte f&uuml;llen Sie <b>alle Pflichfelder</b> aus!';
      systext($error_message, $FD->text('admin', 'error_occurred'), 'red', $FD->text('admin', 'icon_save_error'));
    }


    echo'
                    <form action="" method="post">
                        <input type="hidden" value="gallery_cat" name="go">
                        <input type="hidden" name="sended" value="edit" />
                        <input type="hidden" name="cat_action" value="'.$_POST['cat_action'].'" />
                        <input type="hidden" name="cat_id" value="'.$admin_cat_arr['cat_id'].'" />
                        <input type="hidden" name="oldname" value="'.$admin_cat_arr['cat_name'].'" />
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="2"><h3>Kategorie bearbeiten</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Name:<br>
                                    <font class="small">Name der Kategorie</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="cat_name" size="33" maxlength="100"
                                     value="'.$admin_cat_arr['cat_name'].'">
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
                                        if ($admin_cat_arr['cat_type'] == 1)
                                          echo ' selected=selected';
                                        echo'
                                        >Screenshots / Zufallsbild</option>
                                        <option value="2"';
                                        if ($admin_cat_arr['cat_type'] == 2)
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
                                        if ($admin_cat_arr['cat_visibility'] == 1)
                                          echo ' selected=selected';
                                        echo'>vollst&auml;ndig sichtbar</option>
                                        <option value="2"';
                                        if ($admin_cat_arr['cat_visibility'] == 2)
                                          echo ' selected=selected';
                                        echo'>nicht in Auswahl verf&uuml;gbar</option>
                                        <option value="0"';
                                        if ($admin_cat_arr['cat_visibility'] == 0)
                                          echo ' selected=selected';
                                        echo'>nicht aufrufbar</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td colspan="2" class="right"><input type="reset" value="Zur&uuml;cksetzen"></td></tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button type="submit" value="edit" class="button_new" name="sended">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'save_changes_button').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
  }

///////////////////////
/// Delete Category ///
///////////////////////


  elseif ($_POST['cat_action'] == 'delete')
  {
    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX')."screen_cat WHERE cat_id = '$_POST[cat_id]'");
    $admin_cat_arr = $index->fetch(PDO::FETCH_ASSOC);

    $index = $FD->db()->conn()->query('SELECT COUNT(*) AS categ_count FROM '.$FD->env('DB_PREFIX')."screen_cat WHERE cat_id != '$admin_cat_arr[cat_id]' AND cat_type = '$admin_cat_arr[cat_type]'" );
    $num_rows = $index->fetchColumn();

    if ($num_rows > 0)
    {
    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX')."screen_cat WHERE cat_id != '$admin_cat_arr[cat_id]' AND cat_type = '$admin_cat_arr[cat_type]' ORDER BY cat_name" );

    $admin_cat_arr['cat_name'] = killhtml($admin_cat_arr['cat_name']);

echo '
<form action="" method="post">
<input type="hidden" value="gallery_cat" name="go">
<input type="hidden" value="'.session_id().'" name="PHPSESSID">
<input type="hidden" name="sended" value="delete" />
<input type="hidden" name="cat_id" value="'.$admin_cat_arr['cat_id'].'" />
    <table class="content" cellpadding="0" cellspacing="0">
        <tr><td colspan="6"><h3>Kategorie l&ouml;schen</h3><hr></td></tr>
       <tr align="left" valign="top">
           <td width="50%" class="thin">
               Soll die Kategorie "<b>'.killhtml($admin_cat_arr['cat_name']).'</b>" wirklich gel&ouml;scht werden?
           </td>
           <td width="50%">
             <input type="submit" value="Ja">  <input type="button" onclick=\'location.href="?go=gallery_cat";\' value="Nein">
           </td>
       </tr>
       <tr><td height="10px"></td></tr>
       <tr align="left" valign="top">
           <td class="thin">
              Bilder der gel&ouml;schten Kategorie verschieben nach:
           </td>
           <td>
             <select name="cat_move_to" size="1" class="text">';

  while ($admin_cat_move_arr = $index->fetch(PDO::FETCH_ASSOC))
  {
    echo'<option value="'.$admin_cat_move_arr['cat_id'].'">'.$admin_cat_move_arr['cat_name'].'</option>';
  }

echo'
             </select>
           </td>
       </tr>
</table></form>';
    }
    else
    {
      echo '    <table class="content" cellpadding="0" cellspacing="0">
        <tr><td colspan="6"><h3>Kategorie l&ouml;schen</h3><hr></td></tr>
            <tr valign="top">
              <td class="thin">
                Die letzte Kategorie diesen Typs kann nicht gel&ouml;scht werden.<br>
                Bitte legen Sie zuerst eine neue Kategorie f&uuml;r diesen Typ an.</td>
              <td>
                <input type="button" onclick=\'location.href="?go=gallery_cat";\' value="Zur&uuml;ck zur &Uuml;bersicht">
              </td>
            </tr>

      </table>';
    }
  }
}
///////////////////////
/// Delete Category ///
///////////////////////

else
{
    echo'
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="6"><h3>Neue Kategorie</h3><hr></td></tr>
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
    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'screen_cat ORDER BY cat_date DESC');
    while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        $cat_arr['cat_date'] = date('d.m.Y', $cat_arr['cat_date']);

        if ( $cat_arr['cat_type'] == 2 ) {
            $number_index = $FD->db()->conn()->query('SELECT COUNT(wallpaper_id) AS number FROM '.$FD->env('DB_PREFIX')."wallpaper WHERE cat_id = $cat_arr[cat_id]");
        } else {
            $number_index = $FD->db()->conn()->query('SELECT COUNT(screen_id) AS number FROM '.$FD->env('DB_PREFIX')."screen WHERE cat_id = $cat_arr[cat_id]");
        }

        $number_rows = $number_index->fetchColumn();
        echo'
                    <form action="" method="post">
                        <input type="hidden" name="cat_id" value="'.$cat_arr['cat_id'].'" />
                        <input type="hidden" value="gallery_cat" name="go">
                            <tr>
                                <td class="thin">
                                    '.killhtml($cat_arr['cat_name']).'
                                </td>
                                <td class="thin">
                                    '.$number_rows.'
                                </td>
                                <td class="thin">';
                                    switch ($cat_arr['cat_type']) {
                                    case 1:
                                        echo 'Screenshots';
                                        break;
                                    case 2:
                                       echo 'Wallpaper';
                                       break;
                                    }
                                    echo'
                                </td>
                                <td class="thin">';
                                    switch ($cat_arr['cat_visibility']) {
                                    case 0:
                                        echo 'nicht aufrufbar';
                                        break;
                                    case 1:
                                        echo 'voll sichtbar';
                                        break;
                                    case 2:
                                       echo 'nicht in Auswahl';
                                       break;
                                    }
                                    echo'
                                </td>
                                <td class="thin">
                                    '.$cat_arr['cat_date'].'
                                </td>
                                <td class="thin">
                                    <select name="cat_action" size="1" class="text">
                                        <option value="edit">Bearbeiten</option>
                                        <option value="delete">L&ouml;schen</option>
                                    </select>
                                    <input type="submit" value="Los">
                                </td>
                            </tr>
                    </form>
        ';
    }
    echo'</table>';
}
?>
