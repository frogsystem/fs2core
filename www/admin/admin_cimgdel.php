<?php
define(CIMG_PATH, FS2_ROOT_PATH."media/content/", true);
$cimg_path = CIMG_PATH;

if(isset($_GET['file'])){
    $file = intval($_GET['file']);
    $qry = mysql_query("SELECT * FROM `".$global_config_arr['pref']."cimg` WHERE `id`=".$file);
    if(mysql_num_rows($qry) > 0){
        $row = mysql_fetch_assoc($qry);
        if(file_exists(CIMG_PATH."{$row['name']}.{$row['type']}")){
            if(!isset($_POST['edit'])){ // edit file        
                        $imageinfo = getimagesize(CIMG_PATH."{$row['name']}.{$row['type']}");
                        $qry = mysql_query("SELECT * FROM `".$global_config_arr['pref']."cimg_cats`");
                        $cats = array(array("id" => 0, "name" => "Keine Kategorie", "description" => ""));
                        while(($cat = mysql_fetch_assoc($qry)) !== false){
                            $cats[] = $cat;
                        }
                        $tableheight = ($row['hasthumb'] == 0) ? 6 : 3;
                        echo <<< FS2_STRING
<form action="" method="post">
    <table>
        <thead>
            <tr>
                <td colspan="3" class="config">Datei {$row['name']} bearbeiten</td>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: center"><input class="button" name="edit" type="submit" value="Änderungen speichern"></td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td rowspan="{$tableheight}">
                    <img src="{$cimg_path}{$row['name']}.{$row['type']}" alt="{$row['name']}" style="max-width: 200px;">
                </td>
                <td class="config">
                    Dateiname:
                </td>
                <td>
                    <input class="text" name="name" size="10" type="text" value="{$row['name']}">
                </td>
            </tr>
FS2_STRING;
if($row['hasthumb'] == 0){
    echo <<< FS2_STRING
            <tr>
                <td class="config">
                    Thumbnail:<br>
                    <font class="small">Soll ein Thumbnail (Vorschaubild) erstellt werden?</font>
                </td>
                <td>
                    <input class="text" name="thumb" size="10" type="checkbox" value="1">
                </td>
            </tr>
            <tr>
                <td class="config" rowspan="2">
                    Thumbnail-Maße:
                    <font class="small">(Breite x Höhe)</font>
                    <br>
                    <font class="small">Max. Abemsseungen des Thumbnails.</font>
                </td>
                <td class="config">
                    <input class="text" maxlength="4" size="5" name="width" value="">
                    x
                    <input class="text" maxlength="4" size="5" name="height" value="">
                    Pixel
                    <br>
                    <font class="small">
                        <b>Hinweis:</b>
                        Das Seitenverhältnis wird beibehalten!
                    </font>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="button" id="calcbutton" onclick="calcsite(); return false;" style="display: none; padding: 2px; text-align: center;">Andere Seite berechnen</div>
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
FS2_STRING;
}
echo <<< FS2_STRING
            <tr>
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
            <tr>
                <td class="config">
                    Löschen:<br>
                    <font class="small">Soll die Datei endgültig gelöscht werden?</font>
                </td>
                <td>
                    <input class="text" name="delete" size="10" type="checkbox" onchange="checkdel(this);" value="1">
                    <script type="text/javascript">
                        <!--
                            function checkdel(element){
                                if(element.checked == true){
                                    var check = confirm("Soll die Datei wirklich gelöscht werden?");
                                    if(!check)
                                       element.checked = false;
                                }
                            }
                        // -->
                    </script>
                </td>
            </tr>
        </tbody>
    </table>
</form>
FS2_STRING;
            } else { // save changes
                if(!isset($_POST['name']) || empty($_POST['name'])) $_POST['delete'] = 1;
                if(isset($_POST['delete'])){
                    unlink(CIMG_PATH.$row['name'].".".$row['type']);
                    mysql_query("DELETE FROM `".$global_config_arr['pref']."cimg` WHERE `id`=".$file);
                    $text = "Die Datei \"".$row['name']."\" wurde gelöscht!";
                    if($row['hasthumb'] == 1 && file_exists(CIMG_PATH."{$row['name']}_s.{$row['type']}")){
                        unlink(CIMG_PATH.$row['name']."_s.".$row['type']);
                        $text .= "<br>Das Vorschaubild wurde gelöscht!";
                    }
                    systext($text);
                } else {
                    $text = array();
                    if($_POST['name'] != $row['name']){
                        rename(CIMG_PATH.$row['name'].".".$row['type'], CIMG_PATH.$_POST['name'].".".$row['type']);
                        $text[] = "Die Datei wurde umbenannt!";
                        $row['name'] = $_POST['name'];
                        if($row['hasthumb'] == 1 && file_exists(CIMG_PATH."{$row['name']}_s.{$row['type']}")){
                            rename(CIMG_PATH.$row['name']."_s.".$row['type'], CIMG_PATH.$_POST['name']."_s.".$row['type']);
                            $text[] = "Das Vorschaubild wurde umbenannt!";
                        }
                        mysql_query("UPDATE `".$global_config_arr['pref']."cimg` SET `name`='".mysql_real_escape_string($_POST['name'])."' WHERE `id`=".$file);
                    }
                    
                    if($_POST['cat'] != $row['cat']){
                        mysql_query("UPDATE `".$global_config_arr['pref']."cimg` SET `cat`='".intval($_POST['cat'])."' WHERE `id`=".$file);
                        $text[] = "Die Kategorie wurde erfolgreich geändert.";
                    }
                    
                    if(isset($_POST['thumb'])){
                        $thumb = create_thumb_from(image_url("media/content/", $row['name'], FALSE, TRUE), $_POST['width'], $_POST['height']);
                        $text[] = create_thumb_notice($thumb);
                        mysql_query("UPDATE `".$global_config_arr['pref']."cimg` SET `hasthumb`=1 WHERE `id`=".$file);
                    }
                    
                    systext(implode("<br>", $text));
                }
                unset($_GET['file']);
            }
        } else {
            mysql_query("DELETE FROM `".$global_config_arr['pref']."cimg` WHERE `id`=".$file);
            systext("Die angegebene Datei wurde nicht im Dateisystem gefunden.<br>Der Eintrag in der Datenbank wurde gelöscht.", false, true);
            unset($_GET['file']);
        }
    } else {
        systext("Die angegebene Datei existiert nicht.", false, true);
        unset($_GET['file']);
    }
}

if(!isset($_GET['file'])){ // select file
    $qry = mysql_query("UPDATE `".$global_config_arr['pref']."cimg` SET `cat` = 0 WHERE `cat` != 0 AND `cat` NOT IN (SELECT DISTNICT `id` FROM `".$global_config_arr['pref']."cimg_cats`)");
    $num = mysql_affected_rows();
    if($num == 1){
        systext("Ein Datensatz wurde automatisch korrigiert.");
    } elseif($num > 1){
        systext($num." Datensätze wurden automatisch korrigiert.");
    }
    $qry = mysql_query("SELECT * FROM `".$global_config_arr['pref']."cimg` ORDER BY `cat`");
    if(mysql_num_rows($qry) > 0){
        echo '<table border="0" cellpadding="4" cellspacing="0" width="600">';
        $actcat = array("id" => 0, "name" => "Dateien ohne Kategorie", "description" => "");
        $first = true;
        while(($row = mysql_fetch_assoc($qry)) !== false) {
            if($row['cat'] != $actcat['id']){
                $qry2 = mysql_query("SELECT * FROM `".$global_config_arr['pref']."cimg_cats` WHERE `id`=".intval($row['cat']));
                $actcat = mysql_fetch_assoc($qry2);
                $first = true;
            }
            if($first){
                echo '    <tr><td class="space" colspan="2"></td></tr>
    <tr align="left" valign="top">
        <td class="config">
            Kategorie: <i>'.$actcat['name'].'</i><br><font class="small">'.$actcat['description'].'</font>
        </td>
        <td style="text-align: right;">
            <a id="cat'.$actcat['id'].'_collapslink1" href="#" onclick="$(\'.cat'.$actcat['id'].'\').css(\'display\', \'none\'); $(this).css(\'display\', \'none\'); $(\'#cat'.$actcat['id'].'_collapslink2\').css(\'display\', \'inline\'); return false;">Einklappen</a>
            <a id="cat'.$actcat['id'].'_collapslink2" href="#" onclick="$(\'.cat'.$actcat['id'].'\').css(\'display\', \'table-row\'); $(this).css(\'display\', \'none\'); $(\'#cat'.$actcat['id'].'_collapslink1\').css(\'display\', \'inline\'); return false;" style="display:none;">Ausklappen</a>
        </td>
    </tr>';
                $first = false;
            }
            echo '    <tr align="left" class="cat'.$actcat['id'].'" valign="top">
        <td class="config" width="75%">
            '.$row['name'].' <font class="small">(<a href="'.$cimg_path.$row['name'].'.'.$row['type'].'" target="_blank">ansehen</a>)</font>
        </td>
        <td class="config" width="25%">
            <a class="button" href="./?go='.$_GET['go'].'&amp;file='.$row['id'].'" style="display: block; font-weight: bold; padding: 2px; text-align: center;">Bearbeiten</a>
        </td>
    </tr>';
        }
        echo '</table>';
    } else {
        systext("Es wurden keine Bilder gefunden.");
    }
}
?>
