<?php
if(!isset($_POST['name'])) $_POST['name'] = '';
if(!isset($_POST['description'])) $_POST['description'] = '';
if(isset($_POST['add'])){
    $name = mysql_real_escape_string(trim($_POST['name']));
    $desc = mysql_real_escape_string(trim($_POST['description']));
    if(!empty($name)){
        mysql_query('INSERT INTO `'.$FD->config('pref')."cimg_cats` (`name`, `description`) VALUES ('".$name."', '".$desc."')");
        $_POST['name'] = '';
        $_POST['description'] = '';
        systext('Kategorie erfolgreich angelegt!');
    } else {
        systext('Es muss ein Name f&uuml;r die Kategorie angegeben werden!', false, true);
    }
} elseif(isset($_POST['edit'])){
    if(isset($_POST['cat'])){
        $count = 0;
        foreach($_POST['cat'] as $cat){
            $name = mysql_real_escape_string(trim($_POST['cat'.$cat]['name']));
            $desc = mysql_real_escape_string(trim($_POST['cat'.$cat]['description']));
            if(!empty($name)){
                mysql_query('UPDATE `'.$FD->config('pref')."cimg_cats` SET `name`='".$name."', `description`='".$desc."' WHERE `id`=".intval($cat));
                $count++;
            }
        }
        if($count == 1){
            systext('Eine &Auml;nderung &uuml;bernommen');
        } else {
            systext($count.' &Auml;nderungen &uuml;bernommen');
        }
    } else {
        systext('Es muss eine Auswahl getroffen werden.');
    }
} elseif(isset($_POST['delete'])){
    if(isset($_POST['cat'])){
        $count = 0;
        foreach($_POST['cat'] as $cat){
            mysql_query('DELETE FROM `'.$FD->config('pref').'cimg_cats` WHERE `id`='.intval($cat));
            mysql_query('UPDATE `'.$FD->config('pref')."cimg` SET `cat`='".mysql_real_escape_string(trim($_POST['newcat']))."' WHERE `cat`=".intval($cat));
            $count++;
        }
        if($count == 1){
            systext('Eine Kategorie gel&ouml;scht');
        } else {
            systext($count.' Kategorien gel&ouml;scht.');
        }
    } else {
        systext('Es muss eine Auswahl getroffen werden.');
    }
}
echo <<< FS2_STRING
<form action="" method="post">
    <table cellspacing="0" cellpadding="4" border="0" width="600">
        <tr>
            <td class="config" colspan="2">Neue Kategorie hinzuf&uuml;gen</td>
        </tr>
        <tr>
            <td class="config">
                Name:
            </td>
            <td>
                <input class="text" name="name" size="50" type="text" value="{$_POST['name']}">
            </td>
        </tr>
        <tr>
            <td class="config">
                Beschreibung:
            </td>
            <td>
                <textarea class="text" cols="50" name="description" rows="5">{$_POST['description']}</textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input class="button" name="add" type="submit" value="Neue Kategorie anlegen">
            </td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="4" border="0" width="600" style="margin-top: 15px;">
        <tr>
            <td class="config" colspan="3">Kategorie bearbeiten</td>
        </tr>
FS2_STRING;
$qry = mysql_query('SELECT * FROM `'.$FD->config('pref').'cimg_cats`');
if(mysql_num_rows($qry) > 0){
    $options = '<option value="0">Keine Kategorie</option>';
    while(($row = mysql_fetch_assoc($qry)) !== false){
    $options .= '<option value="'.$row['id'].'" title="'.$row['description'].'">'.$row['name'].'</option>';
        echo <<< FS2_STRING
        <tr>
            <td style="vertical-align: top;">
                <input name="cat[]" type="checkbox" value="{$row['id']}">
            </td>
            <td style="vertical-align: top;">
                <input class="text" name="cat{$row['id']}[name]" size="20" type="text" value="{$row['name']}">
            </td>
            <td>
                <textarea class="text" name="cat{$row['id']}[description]" cols="20" rows="5">{$row['description']}</textarea>
            </td>
        </tr>
FS2_STRING;
    }
    echo <<< FS2_STRING
        <tr>
            <td class="config" rowspan="2">Auswahl:</td>
            <td class="config" colspan="2"><input class="button" type="submit" name="delete" value="l&ouml;schen"><br>und eventuelle Bilder in die Kategorie <select name="newcat">{$options}</select> verschieben!</td>
        </tr>
        <tr>
            <td colspan="2"><input class="button" type="submit" name="edit" value="speichern!"></td>
        </tr>
FS2_STRING;
} else {
    echo '<tr><td colspn="3">';
    systext('Es wurde keine Kategorie angelegt.');
    echo '</td></tr>';
}
?>
    </table>
</form>
