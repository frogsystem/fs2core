<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//////////////////////////////////////////
//// Insert new Pre-, Re or Interview ////
//////////////////////////////////////////

if ((isset($_POST['title']) AND $_POST['title'] != '')
    && (isset($_POST['url']) AND $_POST['url'] != '')
    && (isset($_POST['day']) AND $_POST['day'] != '')
    && (isset($_POST['month']) AND $_POST['month'] != '')
    && (isset($_POST['year']) AND $_POST['year'] != '')
    && (isset($_POST['text']) AND $_POST['text'] != '')
    && $_POST['sended'] == 'add')
{
    settype($_POST['day'], 'integer');
    settype($_POST['month'], 'integer');
    settype($_POST['year'], 'integer');
    $datum = mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']);

    settype($_POST['game'], 'integer');
    settype($_POST['cat'], 'integer');
    settype($_POST['lang'], 'integer');

    $stmt = $FD->db()->conn()->prepare(
                'INSERT INTO
                 '.$FD->config('pref')."press (press_title,
                           press_url,
                           press_date,
                           press_intro,
                           press_text,
                           press_note,
                           press_lang,
                           press_game,
                           press_cat)
                 VALUES (?,
                         ?,
                         '$datum',
                         ?,
                         ?,
                         ?,
                         '$_POST[lang]',
                         '$_POST[game]',
                         '$_POST[cat]')");
    $stmt->execute(array($_POST['title'],
                         $_POST['url'],
                         $_POST['intro'],
                         $_POST['text'],
                         $_POST['note']));

    systext('Pressebericht wurde gespeichert.');
    unset($_POST);
}

//////////////////////////////////////
///// Pre-, Re or Interview Form /////
//////////////////////////////////////
if(true)
{
    //Initialise values
    $press_arr['press_title'] = '';
    $press_arr['press_url'] = 'http://';
    $press_arr['press_intro'] = '';
    $press_arr['press_text'] = '';
    $press_arr['press_note'] = '';
    $press_arr['press_game'] = 0;
    $press_arr['press_cat'] = 0;
    $press_arr['press_lang'] = 0;

    $date['tag'] = '';
    $date['monat'] = '';
    $date['jahr'] = '';


    //Time Array for "Today" Button
    $heute['time'] = time();
    $heute['tag'] = date('d', $heute['time']);
    $heute['monat'] = date('m', $heute['time']);
    $heute['jahr'] = date('Y', $heute['time']);

    //Error Message
    if (isset($_POST['sended']) && $_POST['sended'] == 'add') {
        echo get_systext($FD->text("admin", "changes_not_saved").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_save_error"));


        $press_arr['press_title'] = killhtml($_POST['title']);
        $press_arr['press_url'] = killhtml($_POST['url']);
        $press_arr['press_intro'] = killhtml($_POST['intro']);
        $press_arr['press_text'] = killhtml($_POST['text']);
        $press_arr['press_note'] = killhtml($_POST['note']);

        $date['tag'] = $_POST['day']; settype($date['tag'], 'integer'); if($date['tag']==0){$date['tag']='';}
        $date['monat'] = $_POST['month']; settype($date['month'], 'integer'); if($date['month']==0){$date['month']='';}
        $date['jahr'] = $_POST['year']; settype($date['year'], 'integer'); if($date['year']==0){$date['year']='';}

        $press_arr['press_game'] = $_POST['game'];
        $press_arr['press_cat'] = $_POST['cat'];
        $press_arr['press_lang'] = $_POST['lang'];
        settype($_POST['press_game'], 'integer');
        settype($_POST['press_cat'], 'integer');
        settype($_POST['press_lang'], 'integer');
    }

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="press_add" name="go">
                        <input type="hidden" value="add" name="sended">
                        <table class="content" cellpadding="3" cellspacing="0">
                            <tr><td colspan="2"><h3>Pressebreicht hinzuf&uuml;gen</h3><hr></td></tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Der Name der Website.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="title" size="51" maxlength="150" value="'.$press_arr['press_title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    URL:<br>
                                    <font class="small">Link zum Artikel.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" name="url" size="51" maxlength="255" value="'.$press_arr['press_url'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Datum der Ver&ouml;ffentlichung.</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="1" name="day" id="day" maxlength="2" value="'.$date['tag'].'"> .
                                    <input class="text" size="1" name="month" id="month"  maxlength="2" value="'.$date['monat'].'"> .
                                    <input class="text" size="3" name="year" id="year"  maxlength="4" value="'.$date['jahr'].'">&nbsp;
                                    <input  type="button" value="Heute"
                                     onClick=\'document.getElementById("day").value="'.$heute['tag'].'";
                                               document.getElementById("month").value="'.$heute['monat'].'";
                                               document.getElementById("year").value="'.$heute['jahr'].'";\'>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Einleitung: <font class="small">'.$FD->text("admin", "optional").'</font><br />
                                    <font class="small">Eine kurze Einleitung zum Pressebericht.</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor('intro', $press_arr['press_intro'], 408, 75, '', false).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                    <font class="small">Ein kleiner Auszug aus dem vorgestellten Pressebericht.</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor('text', $press_arr['press_text'], 330, 150).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Anmerkungen: <font class="small">'.$FD->text("admin", "optional").'</font><br />
                                    <font class="small">Anmerkungen zum Pressebericht.<br />
                                    (z.B. die Wertung eines Tests)</font>
                                </td>
                                <td class="config" valign="top">
                                    '.create_editor('note', $press_arr['press_note'], 408, 75, '', false).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Spiel:<br>
                                    <font class="small">Spiel, auf das sich der Artikel bezieht.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="game" size="1" class="text">';

    $index = $FD->db()->conn()->query(
                 'SELECT * FROM '.$FD->config('pref')."press_admin
                  WHERE type = '1' ORDER BY title");
    while ($game_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        echo'<option value="'.$game_arr['id'].'"';
        if ($game_arr['id'] == $press_arr['press_game']) {echo' selected="selected"';}
        echo'>'.$game_arr['title'].'</option>';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Kategorie:<br>
                                    <font class="small">Die Kategorie, der der Artikel angeh&ouml;rt.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="cat" size="1" class="text">';

    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->config('pref')."press_admin
                                        WHERE type = '2' ORDER BY title" );
    while ($cat_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        echo'<option value="'.$cat_arr['id'].'"';
        if ($cat_arr['id'] == $press_arr['press_cat']) {echo' selected="selected"';}
        echo'>'.$cat_arr['title'].'</option>';
    }
    echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Sprache:<br>
                                    <font class="small">Sprache, in der der Artikel verfasst wurde.</font>
                                </td>
                                <td class="config" valign="top">
                                    <select name="lang" size="1" class="text">';

    $index = $FD->db()->conn()->query('SELECT * FROM '.$FD->config('pref')."press_admin
                                        WHERE type = '3' ORDER BY title");
    while ($lang_arr = $index->fetch(PDO::FETCH_ASSOC))
    {
        echo'<option value="'.$lang_arr['id'].'"';
        if ($lang_arr['id'] == $press_arr['press_lang']) {echo' selected="selected"';}
        echo'>'.$lang_arr['title'].'</option>';
    }
    echo'
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text("admin", "button_arrow").' Pressebericht hinzuf&uuml;gen
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
