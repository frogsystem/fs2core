<?php if (!defined('ACP_GO')) die('Unauthorized access!');

#TODO: file access

# Define Upload Path
define('UPLOAD_PATH', FS2UPLOAD.'/', true);
define('CIMG_PATH', FS2MEDIA.'/content/', true);

if(isset($_POST['sended']) && isset($_POST['cat_action']) && $_POST['cat_action'] == "import"){
    if (!isset($_POST['thumb']))
        $_POST['thumb'] = array();
		
	if(count($_POST['image']) > 0 && !is_writable ( CIMG_PATH )){ 
		systext('Keine Schreibrechte auf das Verzeichnis '.CIMG_PATH.'.');
	}elseif(count($_POST['image']) > 0){
        $count = 0;
        $stmt = $FD->sql()->conn()->prepare('INSERT INTO `'.$FD->config('pref').'cimg` (`name`, `type`, `hasthumb`, `cat`) VALUES (?, ?, ?, ?)');
        foreach($_POST['image'] as $image){
            $thumb = (in_array($image, $_POST['thumb'])) ? 1 : 0;
            $name = substr($image, 0, strrpos($image, '.'));
            $type = substr($image, strrpos($image, '.') + 1);
            $stmt->execute(array($name, $type, $thumb, intval($_POST['cat'])));
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
    unset($_POST);
} elseif(isset($_POST['sended']) && isset($_POST['cat_action']) && $_POST['cat_action'] == "delete"){
    if(count($_POST['image']) > 0){
        $count1 = 0;
        $count2 = 0;
        foreach($_POST['image'] as $image){
            $name = substr($image, 0, strrpos($image, '.'));
            $type = substr($image, strrpos($image, '.') + 1);
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
    unset($_POST);
}

if(!isset($_POST['cat_action']) || !isset($_POST['sended'])){
    $qry = $FD->sql()->conn()->query('SELECT * FROM `'.$FD->config('pref').'cimg`');
    $img = array();
    while(($row = $qry->fetch(PDO::FETCH_ASSOC)) !== false){
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
        $select_all_none = '<span class="small">
                         (<span class="link" onclick="groupselect(\'#image_list\', true)">alle</span> / <span class="link" onclick="groupselect(\'#image_list\', false)">keine</span>  ausw&auml;hlen)
                    </span>';

        systext($found.sp_string($found, ' neues Bild', ' neue Bilder').' gefunden&nbsp;'.$select_all_none, "Bilder aus Upload-Ordner importieren");
        $upload_path = UPLOAD_PATH;

        echo '<form action="" method="post">
            <input type="hidden" name="sended" value="1">
        <table class="configtable" cellpadding="4" cellspacing="0" id="image_list">
        <tbody>';
        foreach($bildnamen as $bild){
            echo <<< FS2_STRING
    <tr>
        <td width="20">
            {$FD->text('admin', 'checkbox')}
            <input class="hidden" type="checkbox" name="image[]" value="{$bild[0]}{$bild[2]}" id="img_{$bild[0]}{$bild[2]}">
        </td>
        <td><label for="img_{$bild[0]}{$bild[2]}">{$bild[0]} <span class="small">(<a href="{$upload_path}{$bild[0]}{$bild[2]}" target="_blank">ansehen</a>)</span></label>
FS2_STRING;
if($bild[1]) echo '<br><font class="small">Thumbnail gefunden</font><input type="hidden" name="thumb[]" value="'.$bild[0].$bild[2].'">';
echo '    </tr>';
        }

        echo '

            <tr><td class="space"></td></tr>
            <tr>
                <td colspan="2">
                    <div class="atleft" id="import_to">
                        Bilder in diese Kategorie importieren: <select name="cat"><option value="0">Keine Kategorie</option>';
                            $qry = $FD->sql()->conn()->query('SELECT * FROM `'.$FD->config('pref').'cimg_cats`');
                            while(($cat = $qry->fetch(PDO::FETCH_ASSOC)) !== false){
                                echo '<option value="'.$cat['id'].'" title="'.$cat['description'].'">'.$cat['name'].'</option>';
                            }
                            echo '</select>
                    </div>
                    <div class="atright">
                        <select name="cat_action" size="1" onchange=\'if ($(this).val()=="import") {$("#import_to").show();} else {$("#import_to").hide();}\'>
                            <option value="import">'.$FD->text('admin', 'selection_import').'</option>
                            <option value="delete">'.$FD->text('admin', 'selection_delete').'</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr><td class="space"></td></tr>
            <tr>
                <td class="buttontd" colspan="5">
                    <button class="button_new" type="submit">
                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'do_action_button_long').'
                    </button>
                </td>
            </tr>
        </table></form>';
    } else {
        systext('Keine neuen Bilder gefunden');
    }
}
?>
