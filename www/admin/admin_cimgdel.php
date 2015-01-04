<?php if (!defined('ACP_GO')) die('Unauthorized access!');

define('CIMG_PATH', FS2MEDIA.'/content/', true);
$cimg_path = CIMG_PATH;

if(isset($_GET['file'])){
    $file = intval($_GET['file']);
    $qry = $FD->sql()->conn()->query('SELECT * FROM `'.$FD->config('pref').'cimg` WHERE `id`='.$file);
    $row = $qry->fetch(PDO::FETCH_ASSOC);
    if($row !== false){
        if(file_exists(CIMG_PATH."{$row['name']}.{$row['type']}")){
            if(!isset($_POST['edit'])){ // edit file
                        $imageinfo = getimagesize(CIMG_PATH."{$row['name']}.{$row['type']}");
                        $qry = $FD->sql()->conn()->query('SELECT * FROM `'.$FD->config('pref').'cimg_cats`');
                        $cats = array(array('id' => 0, 'name' => 'Keine Kategorie', 'description' => ''));
                        while(($cat = $qry->fetch(PDO::FETCH_ASSOC)) !== false){
                            $cats[] = $cat;
                        }
                        $tableheight = ($row['hasthumb'] == 0) ? 6 : 6;
                        echo <<< FS2_STRING
<form action="" method="post">
    <input type="hidden" name="edit" value="1">
    <table class="configtable" cellpadding="4" cellspacing="0">
        <thead>
            <tr><td class="line" colspan="3">Inhaltsbild bearbeiten</td></tr>
            <tr>
                <td colspan="3">Datei <b>{$row['name']}.{$row['type']}</b> bearbeiten</td>
            </tr>
            <tr><td class="space"></td></tr>
        </thead>
        <tfoot>
            <tr><td class="space"></td></tr>
            <tr>
                <td class="buttontd" colspan="3">
                    <button class="button_new" type="submit">
                        {$FD->text("admin", "button_arrow")} {$FD->text("admin", "save_changes_button")}
                    </button>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr valign="top">
                <td rowspan="{$tableheight}" valign="top">
                    <a href="{$cimg_path}{$row['name']}.{$row['type']}" target="_blank" title="In Originalgr&ouml;&szlig;e anzeigen">
                        <img src="{$cimg_path}{$row['name']}.{$row['type']}" alt="{$row['name']}" style="max-width: 200px;">
                    </a>
                </td>
                <td class="config">
                    Dateiname:
                </td>
                <td width="300">
                    <input class="text" name="name" size="30" maxlength="255" type="text" value="{$row['name']}"><b>.{$row['type']}</b>
                </td>
            </tr>
FS2_STRING;
if($row['hasthumb'] == 0){
    echo <<< FS2_STRING
            <tr valign="top">
                <td class="config">
                    Thumbnail:<br>
                    <font class="small">Soll ein Vorschaubild erstellt werden?</font>
                </td>
                <td>
                    {$FD->text('admin', 'checkbox')}
                    <input class="hidden" name="thumb" size="10" type="checkbox" value="1" onChange="$('.thumb_settings').toggle()">
                </td>
            </tr>
FS2_STRING;
} else {
    echo <<< FS2_STRING
            <tr valign="top">
                <td class="config">
                    Thumbnail:<br>
                    <span class="small">Soll ein neues Vorschaubild erstellt werden?</span>
                </td>
                <td>
                    {$FD->text('admin', 'checkbox')}
                    <input class="hidden" name="thumb" size="10" type="checkbox" value="1" onChange="$('.thumb_settings').toggle()">
                    <br><span class="small">Es existiert bereits ein Vorschaubild. Soll das aktuelle Vorschaubild durch ein neues ersetzt werden?</span>
                </td>
            </tr>
FS2_STRING;
}
    echo <<< FS2_STRING
            <tr valign="top" class="thumb_settings hidden">
                <td class="config" rowspan="2">
                    Thumbnail-Ma&szlig;e:
                    <br>
                    <span class="small">(Breite x H&ouml;he)<br>
                    Max. Abmessungen des Thumbnails.</span>
                </td>
                <td class="config">
                    <input class="text" maxlength="4" size="5" name="width" value="">
                    x
                    <input class="text" maxlength="4" size="5" name="height" value="">
                    Pixel
                    <br>
                    <font class="small">
                        <b>Hinweis:</b>
                        Das Seitenverh&auml;ltnis wird beibehalten!
                    </font>
                </td>
            </tr>
            <tr valign="top" class="thumb_settings hidden">
                <td>
                    <button class="pointer" id="calcbutton" onclick="calcsite(); return false;">Andere Seite berechnen</button>
                    <script type="text/javascript">
                        <!--
                            function calcsite(){
                                var width = $('input[name="width"]').get(0).value, height = $('input[name="height"]').get(0).value;
                                if(width == "" && height == "") return false;
                                var ratio = {$imageinfo[0]}/{$imageinfo[1]};
                                if(width == ""){
                                    $('input[name="width"]').get(0).value = Math.round(height * ratio);
                                } else if(height == ""){
                                    $('input[name="height"]').get(0).value = Math.round(width / ratio);
                                } else {
                                    if(height == Math.round(width / ratio)){
                                        alert("Das Seitenverhältnis passt");
                                    } else {
                                        alert("Das Seitenverhältnis passt nicht");
                                    }
                                }
                                return false;
                            }

                            $("#calcbutton").css("display", "block");
                        // -->
                    </script>
                </td>
            </tr>
            <tr valign="top">
                <td class="config">
                    Kategorie:
                </td>
                <td>
                    <select class="text" name="cat">
FS2_STRING;

foreach($cats as $cat){
    echo '<option value="'.$cat['id'].'" title="'.$cat['description'].'"'.getselected($cat['id'], $row['cat']).'>'.$cat['name'].'</option>';
}
echo <<< FS2_STRING
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <td class="config">
                    L&ouml;schen:<br>
                    <font class="small">Soll die Datei endg&uuml;ltig gel&ouml;scht werden?</font>
                </td>
                <td>
                    {$FD->text('admin', 'checkbox')}
                    <input class="hidden cb-red" name="delete" type="checkbox" id="cpd" value="1" onchange='delalert("cpd", "{$FD->text("admin", "js_delete_image")}")'>
                </td>
            </tr>
        </tbody>
    </table>
</form>
FS2_STRING;
            } else { // save changes
                if(!isset($_POST['name']) || empty($_POST['name'])) $_POST['delete'] = 1;
                if(isset($_POST['delete'])){
                    unlink(CIMG_PATH.$row['name'].'.'.$row['type']);
                    $FD->sql()->conn()->exec('DELETE FROM `'.$FD->config('pref').'cimg` WHERE `id`='.intval($file));
                    $text = 'Die Datei "'.$row['name'].'" wurde gel&ouml;scht!';
                    if($row['hasthumb'] == 1 && file_exists(CIMG_PATH."{$row['name']}_s.{$row['type']}")){
                        unlink(CIMG_PATH.$row['name'].'_s.'.$row['type']);
                        $text .= '<br>Das Vorschaubild wurde gel&ouml;scht!';
                    }
                    systext($text);
                } else {
                    $text = array();
                    if($_POST['name'] != $row['name']){
                        rename(CIMG_PATH.$row['name'].'.'.$row['type'], CIMG_PATH.$_POST['name'].'.'.$row['type']);
                        $text[] = 'Die Datei wurde umbenannt!';
                        $row['name'] = $_POST['name'];
                        if($row['hasthumb'] == 1 && file_exists(CIMG_PATH."{$row['name']}_s.{$row['type']}")){
                            rename(CIMG_PATH.$row['name'].'_s.'.$row['type'], CIMG_PATH.$_POST['name'].'_s.'.$row['type']);
                            $text[] = 'Das Vorschaubild wurde umbenannt!';
                        }
                        $stmt = $FD->sql()->conn()->prepare('UPDATE `'.$FD->config('pref').'cimg` SET `name`= ? WHERE `id`='.intval($file));
                        $stmt->execute(array($_POST['name']));
                    }

                    if($_POST['cat'] != $row['cat']){
                        $FD->sql()->conn()->exec('UPDATE `'.$FD->config('pref')."cimg` SET `cat`='".intval($_POST['cat'])."' WHERE `id`=".$file);
                        $text[] = 'Die Kategorie wurde erfolgreich ge&auml;ndert.';
                    }

                    if(isset($_POST['thumb']) && !empty($_POST['width']) && !empty($_POST['height'])){
                        $thumb = create_thumb_from(image_url('media/content/', $row['name'], FALSE, TRUE), $_POST['width'], $_POST['height']);
                        $text[] = create_thumb_notice($thumb);
                        $FD->sql()->conn()->exec('UPDATE `'.$FD->config('pref').'cimg` SET `hasthumb`=1 WHERE `id`='.$file);
                    } elseif (isset($_POST['thumb'])) {
                        $text[] = 'Bitte Abmessung f&uuml;r das Vorschaubild angeben';
                    }

                    if (empty($text)) {
                        $text[] = 'Keine &Auml;nderungen vorgenommen';
                    }

                    systext(implode('<br>', $text));
                }
                unset($_GET['file']);
            }
        } else {
            $FD->sql()->conn()->exec('DELETE FROM `'.$FD->config('pref').'cimg` WHERE `id`='.$file);
            systext('Die angegebene Datei wurde nicht im Dateisystem gefunden.<br>Der Eintrag in der Datenbank wurde gel&ouml;scht.', false, true);
            unset($_GET['file']);
        }
    } else {
        systext('Die angegebene Datei existiert nicht.', false, true);
        unset($_GET['file']);
    }
}

if(!isset($_GET['file'])){ // select file
    $num = $FD->sql()->conn()->exec('UPDATE `'.$FD->config('pref').'cimg` SET `cat` = 0 WHERE `cat` != 0 AND `cat` NOT IN (SELECT DISTINCT `id` FROM `'.$FD->config('pref').'cimg_cats`)');
    if ($num == 1) {
        systext('Ein Datensatz wurde automatisch korrigiert.');
    } elseif($num > 1) {
        systext($num.' Datens&auml;tze wurden automatisch korrigiert.');
    }
    $qry = $FD->sql()->conn()->query('SELECT COUNT(*) FROM `'.$FD->config('pref').'cimg`');
    if ($qry->fetchColumn() > 0) {
        echo <<< FS2_STRING
            <script type="text/javascript">
                $(document).ready(function() {
                    $("a.thumbpreview").hover(function(e){
                        var img = $(this).parents('td:first').find('img.thumbpreview');
                        if (!img.attr("src")) {
                            img.attr("src", $(this).attr("href")).css("border", "1px solid #434343");
                        }
                        img.show();
                    }, function(e) {
                        $(this).parents('td:first').find('img.thumbpreview').hide();
                    });
                });
            </script>
FS2_STRING;


        echo '<table class="content" cellpadding="0" cellspacing="0">';
        $actcat = array('id' => 0, 'name' => 'Dateien ohne Kategorie', 'description' => '');
        $first = true;
        $qry = $FD->sql()->conn()->query('SELECT * FROM `'.$FD->config('pref').'cimg` ORDER BY `cat`');
        while(($row = $qry->fetch(PDO::FETCH_ASSOC)) !== false) {
            if($row['cat'] != $actcat['id']){
                $qry2 = $FD->sql()->conn()->query('SELECT * FROM `'.$FD->config('pref').'cimg_cats` WHERE `id`='.intval($row['cat']));
                $actcat = $qry2->fetch(PDO::FETCH_ASSOC);
                $first = true;
            }
            if($first){
                echo '
                    <tr><td class="space" colspan="2"></td></tr>
                    <tr>
                        <td colspan="3">
                            <h3> Kategorie: '.$actcat['name'].'
                                <span class="small atright">
                                    <a id="cat'.$actcat['id'].'_collapslink1" href="#" onclick="$(\'.cat'.$actcat['id'].'\').css(\'display\', \'none\'); $(this).css(\'display\', \'none\'); $(\'#cat'.$actcat['id'].'_collapslink2\').css(\'display\', \'inline\'); return false;">Einklappen</a>
                                    <a id="cat'.$actcat['id'].'_collapslink2" href="#" onclick="$(\'.cat'.$actcat['id'].'\').css(\'display\', \'table-row\'); $(this).css(\'display\', \'none\'); $(\'#cat'.$actcat['id'].'_collapslink1\').css(\'display\', \'inline\'); return false;" style="display:none;">Ausklappen</a>
                                </span>
                            </h3>
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:70%">
                            <span class="small">'.$actcat['description'].'</span>
                        </td>
                        <td class="center">
                            <span class="cat'.$actcat['id'].'">Vorschaubild</span>
                        </td>
                        <td>
                        </td>
                    </tr>
                ';
                $first = false;
            }
            echo '
                <tr align="left" class="cat'.$actcat['id'].'" valign="top">
                    <td>
                        '.$row['name'].' <span class="small">(<a class="thumbpreview" href="'.$cimg_path.$row['name'].'.'.$row['type'].'" target="_blank">ansehen</a>)</span>
                        <img class="thumbpreview hidden" style="position: absolute; margin-left:5px; margin-top:5px; max-width: 200px; max-height: 400px;">
                    </td>
                    <td class="center">
                        <span class="small">'.($row['hasthumb']?$FD->text('admin', 'yes'):$FD->text('admin', 'no')).'</span>
                    </td>
                    <td class="right">
                        <a href="./?go='.$_GET['go'].'&amp;file='.$row['id'].'">Bearbeiten</a>
                    </td>
                </tr>
            ';
        }
        echo '</table>';
    } else {
        systext('Es wurden keine Bilder gefunden.');
    }
}
?>
