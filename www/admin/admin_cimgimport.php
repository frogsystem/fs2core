<?php if (!defined('ACP_GO')) die('Unauthorized access!');

#TODO: file access

# Define Upload Path
define('UPLOAD_PATH', FS2_ROOT_PATH.'upload/', true);
define('CIMG_PATH', FS2_ROOT_PATH.'media/content/', true);

if(isset($_POST['import'])){
    if (!isset($_POST['thumb']))
        $_POST['thumb'] = array();

    if(count($_POST['image']) > 0){
        $count = 0;
        foreach($_POST['image'] as $image){
            $thumb = (in_array($image, $_POST['thumb'])) ? 1 : 0;
            $name = mysql_real_escape_string(substr($image, 0, strrpos($image, '.')));
            $type = mysql_real_escape_string(substr($image, strrpos($image, '.') + 1));
            mysql_query('INSERT INTO `'.$FD->config('pref')."cimg` (`name`, `type`, `hasthumb`, `cat`) VALUES ('".$name."', '".$type."', ".$thumb.', '.intval($_POST['cat']).')');
            $count++;

            copy (UPLOAD_PATH.$name.'.'.$type, CIMG_PATH.$name.'.'.$type);
            unlink (UPLOAD_PATH.$name.'.'.$type);
            if ($thumb) {
                copy (UPLOAD_PATH.$name.'_s.'.$type, CIMG_PATH.$name.'_s.'.$type);
                unlink(UPLOAD_PATH.$name.'_s.'.$type);
            }
        }
        if($count == 1){
            systext('Ein Bild importiert!');
        } else {
            systext($count.' Bilder importiert!');
        }
    } else {
        systext('Es m&uuml;ssen Bilder ausgew&auml;hlt werden!');
    }
    unset($_POST['import']);
} elseif(isset($_POST['delete'])){
    if(count($_POST['image']) > 0){
        $count1 = 0;
        $count2 = 0;
        foreach($_POST['image'] as $image){
            $name = mysql_real_escape_string(substr($image, 0, strrpos($image, '.')));
            $type = mysql_real_escape_string(substr($image, strrpos($image, '.') + 1));
            if(file_exists(UPLOAD_PATH.$name.'.'.$type)){
                unlink(UPLOAD_PATH.$name.'.'.$type);
                $count1++;
            }
            if(file_exists(UPLOAD_PATH.$name.'_s.'.$type)){
                unlink(UPLOAD_PATH.$name.'_s.'.$type);
                $count2++;
            }
        }
        if($count1 == 1){
            $str = 'Ein Bild ';
        } else {
            $str = $count1.' Bild ';
        }

        if($count2 == 1){
            $str .= 'und ein Thumbnail';
        } else {
            $str .= 'und '.$count2.' Thumbnails';
        }
        systext($str.' gel&ouml;scht!');
    } else {
        systext('Es m&uuml;ssen Bilder ausgew&auml;hlt werden!');
    }
    unset($_POST['delete']);
}

if(!isset($_POST['import']) && !isset($_POST['delete'])){
    $qry = mysql_query('SELECT * FROM `'.$FD->config('pref').'cimg`');
    $img = array();
    while(($row = mysql_fetch_assoc($qry)) !== false){
        $img[] = $row['name'];
        if($row['hasthumb'] == 1){
           $img[] = $row['name'].'_s';
        }
    }
    $ordner=opendir(UPLOAD_PATH); // gib hier den gewünschten Pfad an

    $ext_arr = array('.jpg', '.jpeg', '.gif', '.png', '.JPG', '.JPEG', '.GIF', '.PNG');
    $bildnamen = array();
    $found = 0;

    while(($datei=readdir($ordner))!== false){
        $name = substr($datei, 0, strrpos($datei, '.'));
        $suffix = substr($name, strlen($name) - 2);
        $extension = substr($datei, strrpos($datei, '.'));
        if($datei!='.' AND $datei!='..' AND in_array($extension,$ext_arr) AND !in_array($name, $img) AND $suffix != '_s'){
            $found++;
            $bildnamen[] = array($name, file_exists(UPLOAD_PATH.$name.'_s'.$extension), $extension);
        }
    }

    if($found > 0){
        if($found == 1){
            systext($found.' neues Bild gefunden');
        } else {
            systext($found.' neue Bilder gefunden');
        }
        $upload_path = UPLOAD_PATH;
        echo '<form action="" method="post"><table cellspacing="0" cellpadding="4" border="0" width="600"><tbody>';
        foreach($bildnamen as $bild){
            echo <<< FS2_STRING
    <tr>
        <td><input type="checkbox" name="image[]" value="{$bild[0]}{$bild[2]}"></td>
        <td class="config">{$bild[0]} <font class="small">(<a href="{$upload_path}{$bild[0]}{$bild[2]}" target="_blank">ansehen</a>)</font>
FS2_STRING;
if($bild[1]) echo '<br><font class="small">Thumbnail gefunden</font><input type="hidden" name="thumb[]" value="'.$bild[0].$bild[2].'">';
echo '    </tr>';
        }
        echo '    <tr><td class="config" rowspan="2">Auswahl:</td><td><input class="button" type="submit" name="delete" value="l&ouml;schen!"></td></tr>';
        echo '    <tr><td class="config">in die Kategorie <select name="cat"><option value="0">Keine Kategorie</option>';
        $qry = mysql_query('SELECT * FROM `'.$FD->config('pref').'cimg_cats`');
        while(($cat = mysql_fetch_assoc($qry)) !== false){
            echo '<option value="'.$cat['id'].'" title="'.$cat['description'].'">'.$cat['name'].'</option>';
        }
        echo '</select> <input class="button" type="submit" name="import" value="importieren!"></td></tr></table></form>';
    } else {
        systext('Keine neuen Bilder gefunden');
    }
}
?>
