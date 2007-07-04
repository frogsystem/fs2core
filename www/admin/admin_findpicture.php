<?php
include("config.inc.php");
include("functions.php");
include("adminfunctions.php");

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frog System</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <div id="main" style="left:10px; top:10px; margin-left:0px;">
        <div id="mainshadow" style="width:442px;">
            <div id="maincontent" style="width:420px;">
                <img border="0" src="img/pointer.gif" width="5" height="8" alt=""> 
                <font style="font-size:8pt;"><b>BILD SUCHEN</b></font>
                <div align="center">
                    <p>
                    <form action="'.$PHP_SELF.'" method="post">
                    <table border="0" cellpadding="2" cellspacing="0" width="420">
                                <tr>
                                    <td align="center" class="configthin" width="50%">
                                        <select class="select" name="cat">
                                        ';
$index = mysql_query("SELECT * FROM fs_screen_cat WHERE cat_id != 6", $db);

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
                    <table border="0" cellpadding="2" cellspacing="0" width="420">
                        <tr>
                            <td align="center" class="config" colspan="3">
                                Bilder
                            </td>
                        </tr>
    ';
    $_POST['cat'] = savesql($_POST['cat']);
    $index = mysql_query("SELECT * FROM fs_screen WHERE cat_id = ". $_POST['cat'] ." ORDER BY screen_id DESC", $db);
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
                            <td>';
        $new_img_path = image_url("../images/screenshots/", $screen_arr['screen_id']."_s", true);
        echo'
                                <img src="'.$new_img_path.'" name="'.$screen_arr['screen_id'].'" style="cursor:pointer;"
                                    onclick="javascript:opener.document.getElementById(\'screen_id\').value=\''. $screen_arr['screen_id'] .'\';
                                         javascript:opener.document.getElementById(\'screen_selectortext\').value=\'Bild ausgew&auml;hlt!\';
                                             javascript:opener.document.getElementById(\'selected_pic\').src=\''.$new_img_path.'\';
                                              self.close();">
        ';        
        echo '
                            </td>';
        $newLineEnd = !(++$i < 3);
        if($newLineEnd)
        {
            $newLineStart = true;
            echo '
                        </tr>';
        }

    }
    echo'
                    </table>
    ';
}

echo'
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
';

?>