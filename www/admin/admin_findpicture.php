<?php if (!defined('ACP_GO')) die('Unauthorized access!');


echo'
            <div align="center">

                    <form action="?go=find_gallery_img" method="post">
                    <table border="0" cellpadding="2" cellspacing="0" width="287">
                                <tr>
                                    <td align="left" class="configthin">
                                        <select class="select" name="cat">
                                        ';
$index = mysql_query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 1', $FD->sql()->conn() );

while($cat_arr = mysql_fetch_array($index)) {
        echo '                                  <option value="'.$cat_arr['cat_id'].'"'. ($_POST['cat']==$cat_arr['cat_id']?'selected':'') .'>'. $cat_arr['cat_name'] .'</option>';
}
echo '
                                        </select>
                                        <input class="button" type="submit" value="Anzeigen">
                                    </td>
                                </tr>
                    </table>
                    </form>

';
if (isset($_POST['cat']))
{
    echo'
            <br />
    <div id="find_container">
        <div id="find_top">Bilder</div>
        <table border="0" cellpadding="2" cellspacing="0" width="287" style="padding-left:13px;"
    ';
    $_POST['cat'] = savesql($_POST['cat']);
    $index = mysql_query('SELECT * FROM '.$FD->config('pref').'screen WHERE cat_id = '. $_POST['cat'] .' ORDER BY screen_id DESC', $FD->sql()->conn() );
    $newLineStart = true;
    while ($screen_arr = mysql_fetch_array($index))
    {
        if($newLineStart)
        {
            $newLineStart = false;
            $i = 0;
            echo '
                        <tr>';
        }
        echo '
                            <td align="center" style="padding-bottom:10px; padding-top:10px;"
                                onmouseover="this.style.backgroundColor=\'#EEEEEE\';"
                                onmouseout="this.style.backgroundColor=\'transparent\';"
                            >';
        $new_img_path = image_url('images/screenshots/', $screen_arr['screen_id'].'_s', true);
        echo'
                                <img src="'.$new_img_path.'" name="'.$screen_arr['screen_id'].'" style="cursor:pointer;"
                                    onclick="javascript:opener.document.getElementById(\'screen_id\').value=\''. $screen_arr['screen_id'] .'\';
                                             javascript:opener.document.getElementById(\'screen_selectortext\').value=\'Bild ausgew&auml;hlt!\';
                                             javascript:opener.document.getElementById(\'selected_pic\').src=\''.$new_img_path.'\';
                                             self.close();">
        ';
        echo '
                            </td>';
        $newLineEnd = !(++$i < 2);
        if($newLineEnd)
        {
            $newLineStart = true;
            echo '
                        </tr>';
        }

    }
    if (mysql_num_rows($index) <= 0) {
        echo '<table border="0" cellpadding="2" cellspacing="0" width="287" style="padding-left:13px;">
                  <tr>
                      <td>Keine Bilder gefunden!</td>
                  </tr>';
    }
    echo'
                    </table>
    </div>
         <div id="find_foot"></div>
    ';
}

echo'
        </div>
';

?>
