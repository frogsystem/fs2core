<?php if (!defined('ACP_GO')) die('Unauthorized access!');

if (!isset($_POST['cat']))
    $_POST['cat'] = null;

// search form
echo '
    <form action="" method="post" id="img_search">
        <table class="content" cellpadding="0" cellspacing="0">
            <tr>
                <td class="center">
                    <select class="select" name="cat" onchange="$(\'#img_search\').submit();">';

$index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 1' );
while($cat_arr = $index->fetch(PDO::FETCH_ASSOC)) {
    echo '
                        <option value="'.$cat_arr['cat_id'].'"'. ($_POST['cat']==$cat_arr['cat_id']?'selected':'') .'>'. $cat_arr['cat_name'] .'</option>';
}
echo '
                    </select>
                    <input type="submit" value="Anzeigen">
                </td>
            </tr>
        </table>
    </form>';

// display images
if (isset($_POST['cat']))
{
    $index = $FD->sql()->conn()->prepare('SELECT COUNT(*) FROM '.$FD->config('pref').'screen WHERE cat_id = ?');
    $index->execute(array($_POST['cat']));
    $num_rows = $index->fetchColumn();

    // nothing found
    if ($num_rows <= 0) {
        $main = '
            <table class="content" cellpadding="0" cellspacing="0">
                <tr><td><h3>Bild ausw&auml;hlen</h3><hr></td></tr>
                <tr>
                    <td class="center thin">
                        Keine Bilder gefunden!
                    </td>
                </tr>
            </table>';

    // found images
    } else {

        $newLineStart = true;
        $lines = "";

        $index = $FD->sql()->conn()->prepare('SELECT * FROM '.$FD->config('pref').'screen WHERE cat_id = ? ORDER BY screen_id DESC');
        $index->execute(array($_POST['cat']));
        while ($screen_arr = $index->fetch())
        {
            if($newLineStart)
            {
                $newLineStart = false;
                $i = 0;
                $lines .= '
                            <tr>';
            }
            $lines .= '
                                <td align="center" valign="middle" style="padding-bottom:10px; padding-top:10px; text-align:center; vertical-align:middle;"
                                    onmouseover="this.style.backgroundColor=\'#EEEEEE\';"
                                    onmouseout="this.style.backgroundColor=\'transparent\';"
                                >';
            $new_img_path = image_url('images/screenshots/', $screen_arr['screen_id'].'_s', true);
            $lines .= '
                                    <img src="'.$new_img_path.'" name="'.$screen_arr['screen_id'].'" style="cursor:pointer;"
                                        onclick="javascript:opener.document.getElementById(\'screen_id\').value=\''. $screen_arr['screen_id'] .'\';
                                                 javascript:opener.document.getElementById(\'screen_selectortext\').value=\'Bild ausgew&auml;hlt!\';
                                                 javascript:opener.document.getElementById(\'selected_pic\').src=\''.$new_img_path.'\';
                                                 self.close();">
            ';
            $lines .= '
                                </td>';
            $newLineEnd = !(++$i < 2);
            if($newLineEnd)
            {
                $newLineStart = true;
                $lines .= '
                            </tr>';
            }

        }

        $main = '
        <table class="content" cellpadding="0" cellspacing="0">
            <tr><td colspan="2"><h3>Bild auswählen</h3><hr></td></tr>
            '.$lines.'
        </table>';
    }

    //display table
    echo get_content_container('&nbsp;', $main);
}

?>
