<?php
/////////////////////
//// Config laden ///
/////////////////////
$FD->loadConfig('screens');
$config_arr = $FD->configObject('screens')->getConfigArray();

/////////////////////////////
//// Screenshot hochladen ///
/////////////////////////////

if (isset($_POST['sended']))
{
    settype($_POST['catid'], 'integer');
    $log = array();

    for ($i=1; $i<=5; $i++) {
        if ($_FILES['img'.$i]['name'] != '') {
            // Insert into DB
            $title = savesql($_POST['title'.$i]);
            mysql_query('INSERT INTO '.$FD->config('pref')."screen (`cat_id`, `screen_name`) VALUES ('".$_POST['catid']."','".$title."')", $FD->sql()->conn() );
            $id = mysql_insert_id();

            // File Operations
            $upload = upload_img($_FILES['img'.$i], 'images/screenshots/', $id, $config_arr['screen_size']*1024, $config_arr['screen_x'], $config_arr['screen_y']);
            $log[$i][] = upload_img_notice($upload);

            // Upload Failed => Delete from DB
            if ($upload != 0) {
                mysql_query('DELETE FROM '.$FD->config('pref')."screen WHERE screen_id = '".$id."'");

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
        systext('Sie m&uuml;ssen schon auch ein Bild ausw&auml;hlen...');
    }
}

/////////////////////////////
//// Screenshot Formular ////
/////////////////////////////

echo'
                    <form action="" enctype="multipart/form-data" method="post">
                        <input type="hidden" value="screens_add" name="go">
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config">
                                    Kategorie:<br>
                                    <font class="small">In welche Kategorie werden die Bilder eingeordnet</font>
                                </td>
                                <td class="config">
                                    <select class="input_width" name="catid">
';
$index = mysql_query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 1', $FD->sql()->conn() );
while ($cat_arr = mysql_fetch_assoc($index))
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
                            </tr>
                        </table>
                        <br>
                        <table border="0" cellpadding="4" cellspacing="0" width="600">
                            <tr>
                                <td class="config">#</td>
                                <td class="config">
                                    Bilddateien <span class="small">[max. '.$config_arr['screen_x'].' x '.$config_arr['screen_y'].' Pixel] [max. '.$config_arr['screen_size'].' KB]</span>
                                </td>
                                <td class="config">Titel</td>
                            </tr>
';

for ($i=1; $i<=5; $i++) {
    echo '
                            <tr class="config">
                                <td valign="middle">'.$i.'</td>
                                <td>
                                    <input type="file" class="text" name="img'.$i.'" size="40">
                                </td>
                                <td>
                                     <input type="text" class="text" name="title'.$i.'" size="40" maxlength="255">
                                </td>
                            </tr>
    ';
}
echo '
                        </table>
                        <br>
                        <input name="sended" class="button input_width" type="submit" value="Bilder hochladen">

                        <p>
                            <b>Hinweis:</b> Alle Bilder zusammen d&uuml;rfen nicht gr&ouml;&szlig;er als '.ini_get('post_max_size').'B sein (Server-Vorgabe).
                        </p>

                    </form>
';
?>
