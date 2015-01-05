<?php
/////////////////////
//// Load Config ////
/////////////////////
$FD->loadConfig('screens');
$config_arr = $FD->configObject('screens')->getConfigArray();

///////////////////////////
//// Screenshot Upload ////
///////////////////////////

if (isset($_POST['sended']))
{
    settype($_POST['catid'], 'integer');
    $log = array();

    for ($i=1; $i<=5; $i++) {
        if ($_FILES['img'.$i]['name'] != '') {
            // Insert into DB
            $stmt = $FD->db()->conn()->prepare('INSERT INTO '.$FD->env('DB_PREFIX')."screen (`cat_id`, `screen_name`) VALUES ('".$_POST['catid']."', ?)");
            $stmt->execute(array($_POST['title'.$i]));
            $id = $FD->db()->conn()->lastInsertId();

            // File Operations
            $upload = upload_img($_FILES['img'.$i], 'images/screenshots/', $id, $config_arr['screen_size']*1024, $config_arr['screen_x'], $config_arr['screen_y']);
            $log[$i][] = upload_img_notice($upload);

            // Upload Failed => Delete from DB
            if ($upload != 0) {
                $FD->db()->conn()->exec('DELETE FROM '.$FD->env('DB_PREFIX')."screen WHERE screen_id = '".$id."'");

            // Else create Thumb
            } else {
                $thumb = create_thumb_from(image_url('images/screenshots/', $id, FALSE, TRUE), $config_arr['screen_thumb_x'], $config_arr['screen_thumb_y']);
                $log[$i][] = create_thumb_notice($thumb);
            }

        }
    }

    $systext = '';
    foreach ($log as $num => $msg) {
        $systext .= '<p>Bild '.$num.':<br>';
        foreach ($msg as $text) {
            $systext .= '&nbsp;&nbsp;&nbsp;'.$text.'<br>';
        }
        $systext .= '</p>';
    }

    if ($systext != '') {
        systext($systext);
    } else {
        systext('Du musst schon auch ein Bild ausw&auml;hlen...', $FD->text('admin', 'error_occurred'), 'red', $FD->text('admin', 'icon_save_error'));
    }
}

/////////////////////////
//// Screenshot Form ////
/////////////////////////

echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="screens_add" name="go">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="2"><h3>Bilder hochladen</h3><hr></td></tr>
                            <tr>
                                <td class="config">
                                    Kategorie:<br>
                                    <span class="small">In welche Kategorie werden die Bilder eingeordnet</span>
                                </td>
                                <td class="config">
                                    <select class="input_width" name="catid">
';
if (!isset($_POST['catid']))
{
  $_POST['catid'] = -1;
}
$index = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'screen_cat WHERE cat_type = 1');
while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
{
    echo'
                                        <option value="'.$cat_arr['cat_id'].'"'.($_POST['catid']==$cat_arr['cat_id'] ? ' selected' : '').'>
                                            '.$cat_arr['cat_name'].'
                                        </option>
    ';
}
echo'
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="thin">#&nbsp;</td>
                                <td class="config">
                                    Bilddateien <span class="small">[max. '.$config_arr['screen_x'].' x '.$config_arr['screen_y'].' Pixel] [max. '.$config_arr['screen_size'].' KB]</span>
                                </td>
                                <td class="config">Titel</td>
                            </tr>
';

for ($i=1; $i<=5; $i++) {
    echo '
                            <tr class="config">
                                <td valign="middle" class="thin">'.$i.'</td>
                                <td>
                                    <input type="file" class="text" name="img'.$i.'" size="30">
                                </td>
                                <td width="50%">
                                     <input type="text" class="text half" name="title'.$i.'" size="40" maxlength="255">
                                </td>
                            </tr>
    ';
}
echo '
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="3" class="buttontd">
                                    <button type="submit" value="1" class="button_new" name="sended">
                                        '.$FD->text('admin', 'button_arrow').' Bilder hochladen
                                    </button>
                                </td>
                            </tr>
                        </table>

                        <p>
                            <b>Hinweis:</b> Alle Bilder zusammen d&uuml;rfen nicht gr&ouml;&szlig;er als '.ini_get('post_max_size').'B sein (Server-Vorgabe).
                        </p>
                    </form>
';
?>
