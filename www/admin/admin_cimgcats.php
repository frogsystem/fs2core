<?php if (!defined('ACP_GO')) die('Unauthorized access!');

if(!isset($_POST['name'])) $_POST['name'] = '';
if(!isset($_POST['description'])) $_POST['description'] = '';
if(isset($_POST['add'])){
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    if(!empty($name)){
        $stmt = $FD->db()->conn()->prepare('INSERT INTO `'.$FD->env('DB_PREFIX').'cimg_cats` (`name`, `description`) VALUES (?, ?)');
        $stmt->execute(array($name, $desc));
        $_POST['name'] = '';
        $_POST['description'] = '';
        systext('Kategorie erfolgreich angelegt!');
    } else {
        systext('Es muss ein Name f&uuml;r die Kategorie angegeben werden!', false, true);
    }
} elseif(isset($_POST['change']) && isset($_POST['cat_action']) && $_POST['cat_action'] == "save"){
    if(isset($_POST['cat'])){
        $count = 0;
        $stmt = $FD->db()->conn()->prepare('UPDATE `'.$FD->env('DB_PREFIX').'cimg_cats` SET `name`=?, `description`=? WHERE `id`=?');
        foreach($_POST['cat'] as $cat){
            $name = trim($_POST['cat'.$cat]['name']);
            $desc = trim($_POST['cat'.$cat]['description']);
            if(!empty($name)){
                $stmt->execute(array($name, $desc, intval($cat)));
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
} elseif(isset($_POST['change']) && isset($_POST['cat_action']) && $_POST['cat_action'] == "delete"){
    if(isset($_POST['cat'])){
        $count = 0;
        $stmt = $FD->db()->conn()->prepare('UPDATE `'.$FD->env('DB_PREFIX')."cimg` SET `cat`=? WHERE `cat`=?");
        foreach($_POST['cat'] as $cat){
            $FD->db()->conn()->exec('DELETE FROM `'.$FD->env('DB_PREFIX').'cimg_cats` WHERE `id`='.intval($cat));
            $stmt->execute(array(trim($_POST['newcat']), intval($cat)));
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
        <input type="hidden" name="add" value="1">
        <table class="configtable" cellpadding="4" cellspacing="0">
        <tr><td class="line" colspan="2">{$FD->text('admin', 'cat_new')}</td></tr>
        <tr>
            <td class="config">
                Name:
            </td>
            <td>
                <input class="text" name="name" size="40" maxlength="25" type="text" value="{$_POST['name']}">
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
        <tr><td class="space"></td></tr>
        <tr>
            <td class="buttontd" colspan="2">
                <button class="button_new" type="submit">
                    {$FD->text("admin", "button_arrow")} {$FD->text("admin", "cat_add")}
                </button>
            </td>
        </tr>
        <tr><td class="space"></td></tr>
    </table>
</form>
<p></p>
<form action="" method="post">
    <input type="hidden" name="change" value="1">
    <table class="configtable" cellpadding="4" cellspacing="0">
        <tr><td class="space"></td></tr>
        <tr><td class="line" colspan="3">{$FD->text('admin', 'cats_edit')}</td></tr>
FS2_STRING;
$qry = $FD->db()->conn()->query('SELECT COUNT(*) FROM `'.$FD->env('DB_PREFIX').'cimg_cats`');
if($qry->fetchColumn() > 0){
    echo <<< FS2_STRING
        <tr class="config">
            <td>
                Auswahl
            </td>
            <td>
                Name
            </td>
            <td>
                Beschreibung
            </td>
        </tr>
FS2_STRING;

    // entries
    $options = '<option value="0">Keine Kategorie</option>';
    $qry = $FD->db()->conn()->query('SELECT * FROM `'.$FD->env('DB_PREFIX').'cimg_cats`');
    while(($row = $qry->fetch(PDO::FETCH_ASSOC)) !== false){
    $options .= '<option value="'.$row['id'].'" title="'.$row['description'].'">'.$row['name'].'</option>';
        echo <<< FS2_STRING
        <tr>
            <td style="vertical-align: top;">
                {$FD->text('admin', 'checkbox')}
                <input class="hidden" name="cat[]" type="checkbox" value="{$row['id']}">
            </td>
            <td style="vertical-align: top;">
                <input class="text" name="cat{$row['id']}[name]" size="30" maxlength="25" type="text" value="{$row['name']}">
            </td>
            <td>
                <textarea class="text" name="cat{$row['id']}[description]" cols="30" rows="5">{$row['description']}</textarea>
            </td>
        </tr>
FS2_STRING;
    }

    echo <<< FS2_STRING
        <tr><td class="space"></td></tr>
        <tr>

        </tr>
        <tr><td class="space"></td></tr>
        <tr>
            <td class="config" colspan="3">
                <div class="atleft small">
                    Bilder beim L&ouml;schen verschieben nach
                    <select name="newcat">{$options}</select>
                </div>
                <div class="atright">
                    <select name="cat_action" size="1">
                        <option value="save">{$FD->text("admin", "selection_save")}</option>
                        <option value="delete">{$FD->text("admin", "selection_delete")}</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr><td class="space"></td></tr>
        <tr>
            <td class="buttontd" colspan="3">
                <button class="button_new" type="submit">
                    {$FD->text("admin", "button_arrow")} {$FD->text("admin", "do_action_button_long")}
                </button>
            </td>
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
