<?php
/*commented out, because script is usually not called via index.php, but via
  JavaScript open() Thus, ACP_GO is not set, even for authorized users. */
//if (!defined('ACP_GO')) die('Unauthorized access!');

// Start Session
session_start();

// fs2 include path
set_include_path ( '.' );
define ( 'FS2_ROOT_PATH', './../', TRUE );
require( FS2_ROOT_PATH . 'login.inc.php');
require( FS2_ROOT_PATH . 'includes/imagefunctions.php');
require( FS2_ROOT_PATH . 'includes/adminfunctions.php');

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frogsystem 2 - Bild ausw&auml;hlen</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body id="find_body">

            <div id="find_head">
                &nbsp;<img border="0" src="img/pointer.png" alt="" align="top" />
                <b>BILD AUSW&Auml;HLEN</b>
            </div>
            <div align="center">

                    <form action="'.$_SERVER['PHP_SELF'].'" method="post">
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
            </div>
        </div>
    </div>
</body>
</html>
';

?>
