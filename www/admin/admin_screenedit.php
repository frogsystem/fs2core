<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//load config
$FD->loadConfig('screens');
$config_arr = $FD->configObject('screens')->getConfigArray();

//////////////////////////////
//// Screenshot editieren ////
//////////////////////////////

if (isset($_POST['title']) AND $_POST['do'] == 'edit')
{
    settype($_POST['catid'], 'integer');
    settype($_POST['editscreenid'], 'integer');
    if ($_POST['delscreen'])   // Screenshot löschen
    {
        $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."screen WHERE screen_id = $_POST[editscreenid]");
        image_delete('images/screenshots/', $_POST['editscreenid']);
        image_delete('images/screenshots/', "$_POST[editscreenid]_s");
        systext('Screenshot wurde gel&ouml;scht');
    }
    else   // Screenshot editieren
    {
        $stmt = $FD->sql()->conn()->prepare(
                  'UPDATE '.$FD->config('pref')."screen
                   SET cat_id = $_POST[catid],
                   screen_name = ?
                   WHERE screen_id = $_POST[editscreenid]");
        $stmt->execute(array($_POST['title']));
        systext('Der Screenshot wurde editiert');
    }
}


//////////////////////////////
//// Screenshot anzeigen /////
//////////////////////////////

elseif (isset($_POST['screenid']))
{

/////////////////////////////
//// Thumb neu erstellen ////
/////////////////////////////


    //security functions
    settype($_POST['screenid'], 'integer');

    if (isset($_POST['do']) && $_POST['do'] == 'newthumb')
    {
        image_delete('images/screenshots/',$_POST['screenid'].'_s');

        $newthumb = @create_thumb_from(image_url('images/screenshots/',$_POST['screenid'],FALSE, TRUE),$config_arr['screen_thumb_x'],$config_arr['screen_thumb_y']);
        systext(create_thumb_notice($newthumb));
    }

    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."screen WHERE screen_id = $_POST[screenid]");
    $screen_arr = $index->fetch(PDO::FETCH_ASSOC);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="screens_edit" name="go">
                        <input type="hidden" value="newthumb" name="do">
                        <input type="hidden" value="'.$screen_arr['screen_id'].'" name="screenid">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="2"><h3>Bild bearbeiten</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Bild:<br>
                                    <font class="small">Thumbnail des Screenshots</font>
                                </td>
                                <td class="config" valign="top">
                                   <img src="'.image_url('images/screenshots/',$screen_arr['screen_id'].'_s').'?cachebreaker='.time().'" />
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Thumbnail neu erstellen:<br>
                                    <font class="small">Erstellt ein neues Thumbnail von der Vorlage.</font>
                                </td>
                                <td class="config" valign="top" align="left">
                                  <input type="submit" value="Jetzt neu erstellen">
                                </td>
                            </tr>
                    </form>
                    <form action="" method="post">
                        <input type="hidden" value="screens_edit" name="go">
                        <input type="hidden" value="edit" name="do">
                        <input type="hidden" value="'.$screen_arr['screen_id'].'" name="editscreenid">
                            <tr>
                                <td class="config" valign="top">
                                    Bildtitel:<br>
                                    <font class="small">Bilduntertiel (optional)</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="33" value="'.$screen_arr['screen_name'].'" maxlength="255">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kategorie:<br>
                                    <font class="small">In welche Kategorie soll der Screenshot eingeordnet werden</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="catid">
    ';
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 1');
    while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        $sele = ($screen_arr['cat_id'] == $cat_arr['cat_id']) ? 'selected' : '';
        echo'
                                        <option value="'.$cat_arr['cat_id'].'" '.$sele.'>
                                            '.$cat_arr['cat_name'].'
                                        </option>
        ';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Screenshot l&ouml;schen:
                                </td>
                                <td class="config">
                                   <input onClick=\'delalert ("delscreen", "Soll der Screenshot wirklich gelöscht werden?")\' type="checkbox" name="delscreen" id="delscreen" value="1">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input class="button" type="submit" value="Absenden">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

/////////////////////////////
/// Screenshot Kategorien ///
/////////////////////////////

else
{
    if (isset($_POST['screencatid']))
    {
        settype($_POST['screencatid'], 'integer');
        $wherecat = 'WHERE cat_id = ' . $_POST['screencatid'];
    } else {
        $_POST['screencatid'] = null;
    }

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="screens_edit" name="go">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td><h3>Kategorie auswählen</h3><hr></td></tr>
                            <tr>
                                <td class="thin" width="40%">
                                    Dateien der Kategorie
                                    <select name="screencatid">
    ';
    $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref').'screen_cat WHERE cat_type = 1');
    while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        $sele = ($_POST['screencatid'] == $cat_arr['cat_id']) ? 'selected' : '';
        echo'
                                        <option value="'.$cat_arr['cat_id'].'" '.$sele.'>
                                            '.$cat_arr['cat_name'].'
                                        </option>
        ';
    }
    echo'
                                    </select>
                                    <input type="submit" value="Anzeigen">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';

//////////////////////////////
//// Screenshot auswählen ////
//////////////////////////////

    if (isset($_POST['screencatid']))
    {
        echo'<br>
                    <form action="" method="post">
                        <input type="hidden" value="screens_edit" name="go">
                        <table class="content" cellpadding="0" cellspacing="0">
                            <tr><td colspan="4"><h3>Bild auswählen</h3><hr></td></tr>
                            <tr>
                                <td class="config" width="30%">
                                    Bild
                                </td>
                                <td class="config" width="35%">
                                    Titel
                                </td>
                                <td class="config" width="35%">
                                    Kategorie
                                </td>
                                <td class="config" width="15%">

                                </td>
                            </tr>
        ';
        $index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."screen $wherecat ORDER BY screen_id DESC");
        while ($screen_arr = $index->fetch(PDO::FETCH_ASSOC))
        {
            $index2 = $FD->sql()->conn()->query('SELECT cat_name FROM '.$FD->config('pref')."screen_cat WHERE cat_id = $screen_arr[cat_id]");
            $db_cat_name = $index2->fetchColumn();

            echo'
                            <tr style="cursor:pointer;"
                                onmouseover="javascript:this.style.backgroundColor=\'#EEEEEE\'"
                                onmouseout="javascript:this.style.backgroundColor=\'transparent\'"
                                onClick=\'document.getElementById("'.$screen_arr['screen_id'].'").checked="true";\'>
                                <td class="configthin">
                                    <img src="'.image_url('images/screenshots/',killhtml($screen_arr['screen_id']).'_s').'"  style="max-width:200px; max-height:100px;">
                                </td>
                                <td class="thin">
                                    '.killhtml($screen_arr['screen_name']).'
                                </td>
                                <td class="thin">
                                    '.killhtml($db_cat_name).'
                                </td>
                                <td class="thin">
                                    <input type="radio" name="screenid" id="'.$screen_arr['screen_id'].'" value="'.$screen_arr['screen_id'].'">
                                </td>
                            </tr>
            ';
        }
        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="4" class="buttontd">
                                    <button type="submit" value="1" class="button_new" name="sended">
                                        '.$FD->text('admin', 'button_arrow').' Bild bearbeiten
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}
?>
