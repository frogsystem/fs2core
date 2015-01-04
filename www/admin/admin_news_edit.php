<?php if (!defined('ACP_GO')) die('Unauthorized access!');

function db_edit_comment ( $DATA )
{
    global $FD;

    settype ( $DATA['comment_id'], 'integer' );

    // SQL-Update-Query: Comment
    $stmt = $FD->db()->conn()->prepare('
                    UPDATE
                            '.$FD->config('pref')."comments
                    SET
                            comment_title = ?,
                            comment_text = ?
                    WHERE
                            comment_id = '".$DATA['comment_id']."'
                        AND content_type='news'");
    $stmt->execute(array($DATA['title'], $DATA['text']));

    systext( $FD->text('admin', 'changes_saved'), $FD->text('admin', 'info'), FALSE, $FD->text('admin', 'icon_save_ok') );
}

function db_delete_comment ( $DATA )
{
    global $FD;

    $DATA['comment_id'] = array_map ( 'intval', explode ( ',', $DATA['comment_id'] ) );

    // SQL-Delete-Query: Comment
    $affected = (int) $FD->db()->conn()->exec ( '
                    DELETE FROM
                            '.$FD->config('pref').'comments
                    WHERE
                            `comment_id` IN ('.implode ( ',', $DATA['comment_id'] ).')');
    $FD->db()->conn()->exec ( '
                    UPDATE `'.$FD->config('pref').'counter`
                    SET `comments` = `comments` - '.$affected);

    systext( $FD->text('page', 'comment_deleted'), $FD->text('admin', 'info'), FALSE, $FD->text('admin', 'icon_trash_ok') );
}

// Prevent further execution when included
if (ACP_GO != 'news_edit') return;

///////////////////
//// Functions ////
///////////////////
function action_delete_get_data ( $IDS )
{
    global $FD;

    unset ($return_arr);

    foreach ( $IDS as $NEWS_ID ) {
        unset ($news_arr);
        settype ( $NEWS_ID, 'integer' );

        $index = $FD->db()->conn()->query ( 'SELECT * FROM '.$FD->config('pref')."news WHERE news_id = '".$NEWS_ID."'" );
        $news_arr = $index->fetch(PDO::FETCH_ASSOC);

        $news_arr['news_date_formated'] = ''.$FD->text('admin', 'on').' <b>' . date ( $FD->text('admin', 'date_format') , $news_arr['news_date'] ) . '</b> '.$FD->text('admin', 'at').' <b>' . date ( $FD->text('admin', 'time_format') , $news_arr['news_date'] ) . '</b>';

        $index2 = $FD->db()->conn()->query("SELECT COUNT(comment_id) AS 'number' FROM ".$FD->config('pref').'comments WHERE content_id = '.$news_arr['news_id'].' AND content_type=\'news\'' );
        $news_arr['num_comments'] = $index2->fetchColumn();

        $index2 = $FD->db()->conn()->query('SELECT user_name FROM '.$FD->config('pref').'user WHERE user_id = '.$news_arr['user_id']."");
        $news_arr['user_name'] = $index2->fetchColumn();

        $index2 = $FD->db()->conn()->query('SELECT cat_name FROM '.$FD->config('pref').'news_cat WHERE cat_id = '.$news_arr['cat_id']."");
        $news_arr['cat_name'] = $index2->fetchColumn();

        $return_arr[] = $news_arr;
    }

    return $return_arr;
}

function action_delete_display_page ( $return_arr )
{
        global $FD;

        echo '
            <form action="" method="post">
                <input type="hidden" name="sended" value="delete">
                <input type="hidden" name="news_action" value="'.$_POST['news_action'].'">
                <input type="hidden" name="go" value="news_edit">
                <table class="configtable" cellpadding="4" cellspacing="0">
                    <tr><td class="line" colspan="2">'.$FD->text('page', 'news_delete_title').'</td></tr>
                    <tr>
                        <td class="config" style="width: 100%;">
                            '.$FD->text('page', 'news_delete_question').'
                        </td>
                        <td class="config right top" style="padding: 0px;">
                            '.get_yesno_table ( 'news_delete' ).'
                        </td>
                    </tr>
                </table>
                <table class="configtable" cellpadding="4" cellspacing="0">
        ';

        foreach ($return_arr as $news_arr) {
            echo '
                    <tr>
                        <td style="width:15px;"></td>
                        <td class="config">
                            <input type="hidden" name="news_id[]" value="'.$news_arr['news_id'].'">
                            '.$news_arr['news_title'].' <span class="small">(#'.$news_arr['news_id'].')</span>
                            <span class="right">
                                <a class="small" href="'.$FD->config('virtualhost').'?go=comments&amp;id='.$news_arr['news_id'].'" target="_blank">
                                    &raquo; '.$FD->text('page', 'news_delete_view_news').'
                                </a>
                            </span>
                            <br>
                            <span class="small">
                                '.$FD->text('admin', 'by_posted').' <b>'.$news_arr['user_name'].'</b>
                                '.$news_arr['news_date_formated'].'</b>
                                '.$FD->text('admin', 'in').' <b>'.$news_arr['cat_name'].'</b>,
                                <b>'.$news_arr['num_comments'].'</b> '.$FD->text('admin', 'comments').'
                            </span>
                        </td>
                        <td style="width:15px;"></td>
                    </tr>
                    <tr><td class="space"></td></tr>
            ';
        }

        echo '
                </table><br>
                <table class="configtable" cellpadding="4" cellspacing="0">
                    <tr>
                        <td class="buttontd">
                            <button class="button_new" type="submit">
                                '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'do_action_button_long').'
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        ';
}

function action_comments_select ( $DATA )
{
    global $FD;

    $DATA['news_id'] = intval($DATA['news_id']);
    // Comments Header
    echo '
                                        <form action="" method="post">
                                                <input type="hidden" name="sended" value="comment">
                                                <input type="hidden" name="news_action" value="'.$DATA['news_action'].'">
                                                <input type="hidden" name="news_id[]" value="'.$DATA['news_id'].'">
                                                <input type="hidden" name="go" value="news_edit">
                                                <table class="configtable select_list" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="4">Kommentare bearbeiten</td></tr>
                                                        <tr>
                                                            <td class="config" width="35%">Titel</td>
                                                            <td class="config" width="25%">Verfasser</td>
                                                            <td class="config" width="25%">Datum</td>
                                                            <td class="config center" width="15%">Auswahl</td>
                                                        </tr>

    ';

    // Get Number of Comments
    $index = $FD->db()->conn()->query ( "SELECT COUNT(comment_id) AS 'number' FROM ".$FD->config('pref').'comments WHERE content_id = '.$DATA['news_id'].' AND content_type=\'news\'' );
    $number = $index->fetchColumn();

    if ( $number >= 1 ) {
        $index = $FD->db()->conn()->query ( '
                        SELECT *
                        FROM '.$FD->config('pref').'comments
                        WHERE content_id = '.$DATA['news_id'].' AND content_type=\'news\'
                        ORDER BY comment_date DESC');

        // Display Comment-List
        while ( $comment_arr = $index->fetch(PDO::FETCH_ASSOC) ) {

            // Get other Data
            if ( $comment_arr['comment_poster_id'] != 0 ) {
                    $index2 = $FD->db()->conn()->query ( 'SELECT user_name FROM '.$FD->config('pref').'user WHERE user_id = '.$comment_arr['comment_poster_id']."" );
                    $comment_arr['comment_poster'] = $index2->fetchColumn();
            }
            $comment_arr['comment_date_formated'] = date ( 'd.m.Y' , $comment_arr['comment_date'] ) . ' um ' . date ( 'H:i' , $comment_arr['comment_date'] );

            echo'
                                                        <tr class="select_entry">
                                                            <td class="configthin middle">'.$comment_arr['comment_title'].'</td>
                                                            <td class="configthin middle"><span class="small">'.$comment_arr['comment_poster'].'</span></td>
                                                            <td class="configthin middle"><span class="small">'.$comment_arr['comment_date_formated'].'</span></td>
                                                            <td class="config top center">
                                                                <input class="pointer select_box" type="checkbox" name="comment_id[]" value="'.$comment_arr['comment_id'].'">
                                                            </td>
                                                        </tr>
            ';

        }
    }

    // Footer
    echo '
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                            <td class="right" colspan="4">
                                                                <select class="select_type" name="comment_action" size="1">
                                                                    <option class="select_one" value="edit" '.getselected( 'edit', isset($_POST['comment_action']) ? $_POST['comment_action'] : '').'>'.$FD->text('admin', 'selection_edit').'</option>
                                                                    <option class="select_red" value="delete" '.getselected( 'delete', isset($_POST['comment_action']) ? $_POST['comment_action'] : '' ).'>'.$FD->text('admin', 'selection_delete').'</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td class="buttontd" colspan="4">
                                                                        <button class="button_new" type="submit">
                                                                                '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'do_action_button_long').'
                                                                        </button>
                                                                </td>
                                                        </tr>
                                                </table>
                                        </form>
    ';
}

function action_comments_edit ( $DATA )
{
    global $FD;

    settype ( $DATA['comment_id'], 'integer' );
    $index = $FD->db()->conn()->query ( '
                    SELECT *
                    FROM '.$FD->config('pref').'comments
                    WHERE comment_id = '.$DATA['comment_id']." AND content_type='news'" );
    $comment_arr = $index->fetch(PDO::FETCH_ASSOC);

    // Get other Data
    if ( $comment_arr['comment_poster_id'] != 0 ) {
            $index2 = $FD->db()->conn()->query ( 'SELECT user_name FROM '.$FD->config('pref').'user WHERE user_id = '.$comment_arr['comment_poster_id'] );
            $comment_arr['comment_poster'] = $index2->fetchColumn();
    }
    $comment_arr['comment_date_formated'] = date ( 'd.m.Y' , $comment_arr['comment_date'] ) . ' um ' . date ( 'H:i' , $comment_arr['comment_date'] );

    echo '
                    <form action="" method="post">
                        <input type="hidden" name="news_action" value="comments">
                        <input type="hidden" name="comment_action" value="edit">
                        <input type="hidden" name="news_id[]" value="'.$comment_arr['content_id'].'">
                        <input type="hidden" name="comment_id" value="'.$comment_arr['comment_id'].'">
                        <input type="hidden" name="sended" value="edit">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Das Kommentar wurde geschrieben am</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr['comment_date_formated'].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Poster:<br>
                                    <font class="small">Diese Person hat das Kommentar geschrieben</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr['comment_poster'].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Titel des Kommentars</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="33" name="title" value="'.$comment_arr['comment_title'].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                </td>
                                <td valign="top">
                                    '.create_editor('text', killhtml($comment_arr['comment_text']), 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <br /><br />
                                    <input class="button" type="submit" value="&Auml;nderungen speichern">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

function action_comments_delete ( $DATA )
{
    global $FD;

    // Security Function
    $DATA['comment_id'] = ( is_array ( $DATA['comment_id'] ) ) ? $DATA['comment_id'] : array ( $DATA['comment_id'] );
    $DATA['comment_id'] = array_map ( 'intval', $DATA['comment_id'] );

    // Display Head of Table
    echo '
                    <form action="" method="post">
                        <input type="hidden" name="news_action" value="comments">
                        <input type="hidden" name="comment_action" value="delete">
                        <input type="hidden" name="news_id[]" value="'.$DATA['news_id'].'">
                        <input type="hidden" name="comment_id" value="'.implode ( ',', $DATA['comment_id'] ).'">
                        <input type="hidden" name="sended" value="delete">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$FD->text('admin', 'news_comments_delete_title').'</td></tr>
                            <tr>
                                <td class="configthin">
                                    '.$FD->text('admin', 'news_comments_delete_question').'
                                    <br><br>
    ';

    $index = $FD->db()->conn()->query ( '
                    SELECT *
                    FROM `'.$FD->config('pref').'comments`
                    WHERE `comment_id` IN ('.implode ( ',', $DATA['comment_id'] ).')' );

    while ( $comment_arr = $index->fetch(PDO::FETCH_ASSOC) ) {

        // Get other Data
        if ( $comment_arr['comment_poster_id'] != 0 ) {
                $index2 = $FD->db()->conn()->query ( 'SELECT user_name FROM '.$FD->config('pref').'user WHERE user_id = '.$comment_arr['comment_poster_id'] );
                $comment_arr['comment_poster'] = $index2->fetchColumn();
        }
        $comment_arr['comment_date_formated'] = date ( 'd.m.Y' , $comment_arr['comment_date'] ) . ' um ' . date ( 'H:i' , $comment_arr['comment_date'] );

        echo '
                                    <b>'.$comment_arr['comment_title'].'</b> <span class="small">(#'.$_POST['news_id'].')</span><br>
                                    <span class="small">gepostet von <b>'.$comment_arr['comment_poster'].'</b> am
                                                                        '.$comment_arr['comment_date_formated'].' Uhr</b><br><br>
                                    <div class="small">'.killhtml ( $comment_arr['comment_text'] ).'</div><br><br>
        ';
    }

    // Display End of Table
    echo '
                                </td>
                                <td class="config right top" style="padding: 0px;">
                                    '.get_yesno_table ( 'comment_delete' ).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'do_action_button_long').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}




###################
## Page Settings ##
###################
$FILE_SHOW_START = true;
$news_cols = array('news_id', 'cat_id', 'user_id', 'news_date', 'news_title', 'news_text', 'news_active', 'news_comments_allowed', 'news_search_update');

$FD->loadConfig('news');
$config_arr = $FD->configObject('news')->getConfigArray();
$config_arr['html'] = in_array($config_arr['html_code'], array(2, 4)) ? $FD->text("admin", "on") : $FD->text("admin", "off");
$config_arr['fs'] = in_array($config_arr['fs_code'], array(2, 4)) ? $FD->text("admin", "on") : $FD->text("admin", "off");
$config_arr['para'] = in_array($config_arr['para_handling'], array(2, 4)) ? $FD->text("admin", "on") : $FD->text("admin", "off");

$config_arr['short_url_len'] = 50;
$config_arr['short_url_rep'] = '...';


//////////////////////////
//// Database Actions ////
//////////////////////////

// Edit News
if (
    !isset($_POST['edit_link']) && !isset($_POST['add_link']) &&
    isset ( $_POST['news_id'] ) &&
    count ( $_POST['news_id'] ) == 1 &&
    isset ( $_POST['sended'] ) && $_POST['sended'] == 'edit' &&
    isset ( $_POST['news_action'] ) && $_POST['news_action'] == 'edit' &&

    isset ( $_POST['news_title'] ) && $_POST['news_title'] != '' &&
    isset ( $_POST['news_text'] ) && $_POST['news_text'] != '' &&

    isset($_POST['d']) && $_POST['d'] != '' && $_POST['d'] > 0 &&
    isset($_POST['m']) && $_POST['m'] != '' && $_POST['m'] > 0 &&
    isset($_POST['y']) && $_POST['y'] != '' && $_POST['y'] > 0 &&
    isset($_POST['h']) && $_POST['h'] != '' && $_POST['h'] >= 0 &&
    isset($_POST['i']) && $_POST['i'] != '' && $_POST['i'] >= 0 &&

    isset ( $_POST['cat_id'] ) &&
    isset ( $_POST['user_id'] )
   )
{
    // Prepare data
    $_POST['news_date'] = mktime($_POST['h'], $_POST['i'], 0, $_POST['m'], $_POST['d'], $_POST['y']);
    $_POST['news_id'] = $_POST['news_id'][0];
    $data = frompost($news_cols);

    // set edit time
    $data['news_search_update'] = time();

    // SQL-Insert-Query
    try {
        // Get User
        $user_id = $FD->db()->conn()->prepare(
                         'SELECT user_id FROM '.$FD->config('pref').'user
                         WHERE `user_name` = ? LIMIT 1');
        $user_id->execute(array($_POST['user_name']));
        $user_id = $user_id->fetchColumn();

        if (empty($user_id)) {
            Throw new FormException($FD->text('admin', 'no_user_found_for_name'));
        }

        $data['user_id'] = $user_id;

        // Save News
        $newsid = $FD->db()->save('news', $data, 'news_id');

        // delete all related links
        $FD->db()->conn()->exec('DELETE FROM '.$FD->config('pref')."news_links WHERE `news_id` = '".$newsid."'");

        // Insert Links into database
        if (!is_array($_POST['link_name']))
            $_POST['link_name'] = array();
        $stmt = $FD->db()->conn()->prepare('INSERT INTO '.$FD->config('pref').'news_links SET news_id = '.$newsid.', link_name = ?, link_url = ?, link_target = ?');
        foreach ($_POST['link_name'] as $id => $val) {
            if (!empty($_POST['link_name'][$id]) && !empty($_POST['link_url'][$id]) && !in_array($_POST['link_url'][$id], array('http://', 'https://'))) {

                // secure link target
                $_POST['link_target'][$id] = ($_POST['link_target'][$id] == 1 ? 1 : 0);

                // insert into db
                try {
                    $stmt->execute(array($_POST['link_name'][$id], $_POST['link_url'][$id], $_POST['link_target'][$id]));
                } catch (Exception $e) {
                    Throw $e;
                }
            }
        }

        // Update Search Index (or not)
        if ( $FD->config('cronjobs', 'search_index_update') === 1 ) {
            // Include searchfunctions.php
            require ( FS2SOURCE . '/includes/searchfunctions.php' );
            update_search_index ('news');
        }

        echo get_systext($FD->text('admin', 'changes_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));

        // Unset Vars
        unset ($_POST);

    } catch (FormException $e) {
        echo get_systext($FD->text('admin', 'changes_not_saved').'<br>'.$e->getMessage(),
        $FD->text('admin', 'unknown_user'), 'red', $FD->text('admin', 'icon_user_question'));
        $_POST['sended'] = "okay";
    } catch (Exception $e) {
        echo get_systext($FD->text('admin', 'changes_not_saved').'<br>'.
        (DEBUG ? 'Caught exception: '.$e->getMessage() : $FD->text('admin', 'unknown_error')),
        $FD->text('admin', 'error'), 'red', $FD->text('admin', 'icon_save_error'));
    }
}

// Delete News
elseif (
            has_perm('news_delete') &&
            isset ( $_POST['news_id'] ) &&
            isset ( $_POST['sended'] ) && $_POST['sended'] == 'delete' &&
            isset ( $_POST['news_action'] ) && $_POST['news_action'] == 'delete' &&
            isset ( $_POST['news_delete'] )
        )
{
    if ($_POST['news_delete'] == 1 ) {
        try {
            //security
            $_POST['news_id'] = array_map('intval', $_POST['news_id']);

            //delete news
            $num = $FD->db()->conn()->exec('DELETE FROM '.$FD->config('pref').'news WHERE `news_id` IN ('.implode(',',$_POST['news_id']).')');

            // Delete from Search Index
            require_once ( FS2SOURCE . '/includes/searchfunctions.php' );
            delete_search_index_for_one($_POST['news_id'], 'news');

            // delete all links
            $FD->db()->conn()->exec('DELETE FROM '.$FD->config('pref').'news_links WHERE `news_id` IN ('.implode(',',$_POST['news_id']).')');
            // delete all comments
            $comment_rows = $FD->db()->conn()->exec('DELETE FROM '.$FD->config('pref').'comments WHERE `content_id` IN ('.implode(',',$_POST['news_id']).") AND content_type='news'");

            // update counter
            try {
                $FD->db()->conn()->exec('UPDATE `'.$FD->config('pref').'counter` SET `news` = `news` - '.$num.', `comments` - '.$comment_rows.'  WHERE `id` = 1');
            } catch (Exception $e) {}


            echo get_systext($FD->text('page', 'news_deleted').'<br>'.$FD->text('admin', 'deleted_records').': '.$num, $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_trash_ok'));

        } catch (Exception $e) {
            Throw $e;
        }

    } else {
        echo get_systext($FD->text("page", "news_not_deleted"), $FD->text("admin", "info"), 'green', $FD->text("admin", "icon_trash_error"));
    }

        // Unset Vars
        unset ($_POST);
}

// Edit Comments
elseif (
                has_perm('news_comments') &&
                isset ( $_POST['news_id'] ) &&
                count ( $_POST['news_id'] ) == 1 &&
                isset ( $_POST['comment_id'] ) &&
                isset ( $_POST['sended'] ) && $_POST['sended'] == 'edit' &&
                isset ( $_POST['news_action'] ) && $_POST['news_action'] == 'comments' &&
                isset ( $_POST['comment_action'] ) && $_POST['comment_action'] == 'edit' &&

                isset ( $_POST['title'] ) && $_POST['title'] != '' &&
                isset ( $_POST['text'] ) && $_POST['text'] != ''
        )
{
    db_edit_comment ( $_POST );
    $id = $_POST['news_id'];

    // Unset Vars
    unset ( $_POST );
    $_POST['news_action'] = 'comments';
    $_POST['news_id'] = $id;
    unset ( $id );
    $FILE_SHOW_START = FALSE;
}

// Delete Comments
elseif (
                has_perm('news_comments') &&
                isset ( $_POST['news_id'] ) &&
                isset ( $_POST['comment_id'] ) &&
                isset ( $_POST['sended'] ) && $_POST['sended'] == 'delete' &&
                isset ( $_POST['news_action'] ) && $_POST['news_action'] == 'comments' &&
                isset ( $_POST['comment_action'] ) && $_POST['comment_action'] == 'delete' &&
                isset ( $_POST['comment_delete'] )
        )
{
    if ( $_POST['comment_delete'] == 1 ) {
        db_delete_comment ( $_POST );
    } else {
         systext( 'Kommentare wurden nicht gel&ouml;scht', $FD->text('admin', 'info'), FALSE, $FD->text('page', 'trash_error') );
    }

    // Unset Vars
    $id = $_POST['news_id'];
    unset ( $_POST );
    $_POST['news_action'] = 'comments';
    $_POST['comment_action'] = 'delete';
    $_POST['news_id'] = $id;
    unset ( $id );
    $FILE_SHOW_START = FALSE;
}


//////////////////////////////
//// Display Action-Pages ////
//////////////////////////////
if ( isset($_POST['news_id']) && isset($_POST['news_action']) )
{
    $FILE_SHOW_START = FALSE;
    // Edit News
    if ( $_POST['news_action'] == 'edit' && count ( $_POST['news_id'] ) == 1 )
    {
        // read first id from array
        $_POST['news_id'] = $_POST['news_id'][0];

        // script
        $adminpage->addCond('target_0', false);
        $adminpage->addCond('target_1', false);
        $adminpage->addCond('button', false);
        $adminpage->addText('name_name', 'edit_name');
        $adminpage->addText('url_name', 'edit_url');
        $adminpage->addText('target_name', 'edit_target');
        $adminpage->addText('class', 'space');
        $edit_table = $adminpage->get('edit_table', false);

        $adminpage->addText('table', $edit_table);
        $script_edit = $adminpage->get('link_edit', false);

        $script_entry = $adminpage->get('link_entry', false);
        $adminpage->addText('sul', $config_arr['short_url_len']);
        $adminpage->addText('sur', $config_arr['short_url_rep']);
        $adminpage->addText('link_entry', str_replace(array("\n","\r"), array('',''), $script_entry));
        $adminpage->addText('link_edit', str_replace(array("\n","\r"), array('',''), $script_edit));
        echo $adminpage->get('script', false);


        // link functions or error
        if (isset($_POST['sended'])) {

            //add link
            if (isset($_POST['add_link'])) {
                if (!empty($_POST['new_link_name']) && !empty($_POST['new_link_url']) && !in_array($_POST['new_link_url'], array('http://', 'https://'))) {
                    $_POST['link_name'][] = $_POST['new_link_name'];
                    $_POST['link_url'][] = $_POST['new_link_url'];
                    $_POST['link_target'][] = $_POST['new_link_target'];

                    unset($_POST['new_link_name'], $_POST['new_link_url'], $_POST['new_link_target']);
                    $_POST['new_link_url'] = 'http://';
                } else {
                    echo get_systext($FD->text("page", "link_not_added").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_link_error"));
                }

            //edit links
            } elseif (isset($_POST['edit_link'])) {

                if(isset($_POST['link']) && !empty($_POST['link_action'])) {

                    // delete
                    if ($_POST['link_action'] == 'del') {
                        unset($_POST['link_name'][$_POST['link']], $_POST['link_url'][$_POST['link']], $_POST['link_target'][$_POST['link']]);
                    }

                    //up
                    elseif ($_POST['link_action'] == "up" && $_POST['link'] != 0) {
                        // exchange values
                        list($_POST['link_name'][$_POST['link']-1], $_POST['link_name'][$_POST['link']])
                            = array($_POST['link_name'][$_POST['link']], $_POST['link_name'][$_POST['link']-1]);
                        list($_POST['link_url'][$_POST['link']-1], $_POST['link_url'][$_POST['link']])
                            = array($_POST['link_url'][$_POST['link']], $_POST['link_url'][$_POST['link']-1]);
                        list($_POST['link_target'][$_POST['link']-1], $_POST['link_target'][$_POST['link']])
                            = array($_POST['link_target'][$_POST['link']], $_POST['link_target'][$_POST['link']-1]);
                    }

                    //down
                    elseif ($_POST['link_action'] == 'down' && $_POST['link'] < count($_POST['link_name'])-1) {
                        // exchange values
                        list($_POST['link_name'][$_POST['link']+1], $_POST['link_name'][$_POST['link']])
                            = array($_POST['link_name'][$_POST['link']], $_POST['link_name'][$_POST['link']+1]);
                        list($_POST['link_url'][$_POST['link']+1], $_POST['link_url'][$_POST['link']])
                            = array($_POST['link_url'][$_POST['link']], $_POST['link_url'][$_POST['link']+1]);
                        list($_POST['link_target'][$_POST['link']+1], $_POST['link_target'][$_POST['link']])
                            = array($_POST['link_target'][$_POST['link']], $_POST['link_target'][$_POST['link']+1]);
                    }

                    //edit
                    elseif ($_POST['link_action'] == 'edit') {
                        $_POST['new_link_name'] = $_POST['link_name'][$_POST['link']];
                        $_POST['new_link_url'] = $_POST['link_url'][$_POST['link']];
                        $_POST['new_link_target'] = $_POST['link_target'][$_POST['link']];

                        unset($_POST['link_name'][$_POST['link']], $_POST['link_url'][$_POST['link']], $_POST['link_target'][$_POST['link']]);
                    }
                }

            // display error
            } elseif ($_POST['sended'] != "okay") {
                echo get_systext($FD->text("admin", "changes_not_saved").'<br>'.$FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), 'red', $FD->text("admin", "icon_save_error"));
            }

        // Get data from DB
        } else {
            $data = $FD->db()->conn()->query(
                       'SELECT  news_id, cat_id, user_id, news_date, news_title, news_text, news_active, news_comments_allowed, news_search_update
                        FROM '.$FD->config('pref').'news
                        WHERE news_id='.intval($_POST['news_id']).' LIMIT 1');
            $data = $data->fetch(PDO::FETCH_ASSOC);
            putintopost($data);

            // Get User name
            $_POST['user_name'] = $FD->db()->conn()->query('SELECT user_name FROM '.$FD->config('pref').'user WHERE user_id='.intval($_POST['user_id']).' LIMIT 1');
            $_POST['user_name'] = $_POST['user_name']->fetchColumn();

            $_POST['d'] = date('d', $_POST['news_date']);
            $_POST['m'] = date('m', $_POST['news_date']);
            $_POST['y'] = date('Y', $_POST['news_date']);
            $_POST['h'] = date('H', $_POST['news_date']);
            $_POST['i'] = date('i', $_POST['news_date']);

            $_POST['new_link_url'] = 'http://';

            //grab links from database
            $links = $FD->db()->conn()->query('SELECT link_name, link_url, link_target FROM '.$FD->config('pref').'news_links
                         WHERE `news_id` = '.intval($_POST['news_id']).' ORDER BY `link_id`');
            $links = $links->fetchAll(PDO::FETCH_ASSOC);
            $i = 0;
            foreach ($links as $link) {
                //form
                list($_POST['link_name'][$i], $_POST['link_url'][$i], $_POST['link_target'][$i])
                    = array($link['link_name'], $link['link_url'], $link['link_target']);
                $i++;
            }
        }

        // security functions
        $_POST = array_map('killhtml', $_POST);

        // Create Date-Arrays
        list($_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i'])
            = array_values(getsavedate($_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i'], 0, true));

        // cat options
        initstr($cat_options);
        $cats = $FD->db()->conn()->query('SELECT cat_id, cat_name FROM '.$FD->config('pref').'news_cat');
        $cats = $cats->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cats as $cat) {
            settype ($cat['cat_id'], 'integer');
            $cat_options .= '<option value="'.$cat['cat_id'].'" '.getselected($cat['cat_id'], $_POST['cat_id']).'>'.$cat['cat_name'].'</option>'."\n";
        }


        //link entries
        initstr($link_entries);
        $c = 0;
        if (!is_array($_POST['link_name']))
            $_POST['link_name'] = array();

        foreach($_POST['link_name'] as $id => $val) {
            $adminpage->addCond('notscript', true);
            $adminpage->addText('name', killhtml($_POST['link_name'][$id]));
            $adminpage->addText('url', killhtml($_POST['link_url'][$id]));
            $adminpage->addText('target', killhtml($_POST['link_target'][$id]));
            $adminpage->addText('short_url', killhtml(cut_in_string($_POST['link_url'][$id], $config_arr['short_url_len'], $config_arr['short_url_rep'])));
            $adminpage->addText('target_text', $_POST['link_target'][$id] == 1 ? $FD->text("page", "news_link_blank") : $FD->text("page", "news_link_self"));
            $adminpage->addText('id', $c++);
            $adminpage->addText('num', $c);
            $link_entries .= $adminpage->get('link_entry')."\n";
        }

        // link list
        $adminpage->addCond('link_edit', $c >= 1);
        $adminpage->addText('link_entries', $link_entries);
        $link_list = $adminpage->get('link_list');

        //link add
        $adminpage->addCond('target_0', isset($_POST['new_link_target']) && $_POST['new_link_target'] === 0);
        $adminpage->addCond('target_1', isset($_POST['new_link_target']) && $_POST['new_link_target'] === 1);
        $adminpage->addCond('button', true);
        $adminpage->addText('name', isset($_POST['new_link_name']) ? $_POST['new_link_name'] : '');
        $adminpage->addText('name_name', 'new_link_name');
        $adminpage->addText('url', $_POST['new_link_url']);
        $adminpage->addText('url_name', 'new_link_url');
        $adminpage->addText('target_name', 'new_link_target');
        $adminpage->addText('class', 'spacebottom');
        $edit_table = $adminpage->get('edit_table');

        $adminpage->addText('table', $edit_table);
        $link_add = $adminpage->get('link_add');

        // Conditions
        $adminpage->addCond('news_active', $_POST['news_active'] === 1);
        $adminpage->addCond('news_comments_allowed', $_POST['news_comments_allowed'] === 1);

        // Values
        foreach ($_POST as $key => $value) {
            $adminpage->addText($key, $value);
        }

        $adminpage->addText('cat_options', $cat_options);
        $adminpage->addText('html', $config_arr['html']);
        $adminpage->addText('fs', $config_arr['fs']);
        $adminpage->addText('para', $config_arr['para']);
        $adminpage->addText('the_editor', create_editor('news_text', $_POST['news_text'], '', '250px', 'full', FALSE));
        $adminpage->addText('link_list', $link_list);
        $adminpage->addText('link_add', $link_add);

        // display page
        ini_set('xdebug.var_display_max_data', 20000 );
        $t = $adminpage->get('main');
        echo $t;
    }

    // Delete News
    elseif ( $_POST['news_action'] == 'delete' && has_perm('news_delete'))
    {
        $news_arr = action_delete_get_data ( $_POST['news_id'] );
        action_delete_display_page ( $news_arr );
    }



    // Edit Comments
    elseif ( $_POST['news_action'] == 'comments' && count ( $_POST['news_id'] ) == 1 )
    {
        if (has_perm('news_comments')) {
            $_POST['news_id'] = $_POST['news_id'][0];
            settype ( $_POST['news_id'], 'integer' );
            if (
                    $_POST['news_id'] && $_POST['news_action'] == 'comments' &&
                    isset($_POST['comment_id']) && isset($_POST['comment_action'])
                )
            {
                // Edit Comment
                if ( $_POST['comment_action'] == 'edit' && count ( $_POST['comment_id'] ) == 1 ) {
                    $_POST['comment_id'] = $_POST['comment_id'][0];
                    action_comments_edit ( $_POST );
                } elseif ( $_POST['comment_action'] == 'edit' && count ( $_POST['comment_id'] ) > 1 ) {
                    systext( 'Sie k&ouml;nnen nur einen Kommentar gleichzeitig bearbeiten', $FD->text("admin", "error"), TRUE, $FD->text("page", "error") );
                    action_comments_select ( $_POST );
                } elseif ( $_POST['comment_action'] == 'delete' ) {
                    action_comments_delete ( $_POST );
                } else {
                    action_comments_select ( $_POST );
                }
            } else {
                    action_comments_select ( $_POST );
            }
        } else {

        }
    } elseif ( $_POST['news_action'] != 'delete' && count ( $_POST['news_id'] ) > 1 ) {
        systext( 'Sie k&ouml;nnen nur eine News gleichzeitig bearbeiten', $FD->text("admin", "error"), TRUE, $FD->text("page", "error") );
        $FILE_SHOW_START = TRUE;
    }
}

////////////////////////////////////////
//// Display Default News List Page ////
////////////////////////////////////////
if ($FILE_SHOW_START)
{
    // Filter
    $_REQUEST['order'] = killhtml(isset($_REQUEST['order']) && !empty($_REQUEST['order']) ? $_REQUEST['order'] : "news_date");
    $_REQUEST['sort'] = killhtml(isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) ? $_REQUEST['sort'] : "DESC");
    $_REQUEST['filter_cat'] = isset($_REQUEST['filter_cat']) && !empty($_REQUEST['filter_cat']) ? $_REQUEST['filter_cat'] : 0;
    settype($_REQUEST['filter_cat'], 'integer');
    settype($_REQUEST['search_type'], 'integer');
    $_REQUEST['filter_string'] = isset($_REQUEST['filter_string']) && !empty($_REQUEST['filter_string']) ? killhtml($_REQUEST['filter_string']) : '';

    //cat filter options
    initstr($cat_filter_options);
    $catsFD->db()sql->conn()->query('SELECT cat_id, cat_name FROM '.$FD->config('pref').'news_cat');
    $cats = $cats->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cats as $cat) {
        $cat = array_map('killhtml', $cat);
        $cat_filter_options .= '<option value="'.$cat['cat_id'].'" '.getselected($cat['cat_id'], $_REQUEST['filter_cat']).' title="'.$cat['cat_name'].'">'.cut_string($cat['cat_name'], 35, "...").'</option>'."\n";
    }

    // display filter
    for ($i=0; $i<2; $i++)
        $adminpage->addCond('search_type_'.$i, $_REQUEST['search_type'] === $i);
    $adminpage->addCond('filter_cat', $_REQUEST['filter_cat'] === 0);
    $adminpage->addCond('order_id', $_REQUEST['order'] === 'news_id');
    $adminpage->addCond('order_date', $_REQUEST['order'] === 'news_date');
    $adminpage->addCond('order_title', $_REQUEST['order'] === 'news_title');
    $adminpage->addCond('sort_asc', $_REQUEST['sort'] === 'ASC');
    $adminpage->addCond('sort_desc', $_REQUEST['sort'] === 'DESC');
    $adminpage->addText('filter_string', $_REQUEST['filter_string']);
    $adminpage->addText('filter_cat_options', $cat_filter_options);
    echo $adminpage->get('filter');


    // Pagination
    $_REQUEST['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    settype($_REQUEST['page'], 'integer');

    // Page list
    try {

        // searched?
        $searched = (!empty($_REQUEST['filter_string']) && $_REQUEST['search_type'] === 0);

        // search
        if ($searched) {
            // do the search
            $search = new Search('news', $_REQUEST['filter_string'], false);
            $search->setOrder('`'.$_REQUEST['order'].'` '.$_REQUEST['sort'], '`news_id` '.$_REQUEST['sort']);
            $search->setWhere(($_REQUEST['filter_cat'] != 0 ? '`cat_id` = '.$_REQUEST['filter_cat'] : ''));
            $search->setLimit(($_REQUEST['page']-1)*$config_arr['acp_per_page'], $config_arr['acp_per_page']);

        // just filter
        } else {
            // Set where for cat, ID and URL Filter
            $where = array();
            if ($_REQUEST['filter_cat'] != 0)
                $where[] = '`cat_id` = '.$_REQUEST['filter_cat'];

            if (!empty($_REQUEST['filter_string'])) {
                switch ($_REQUEST['search_type']) {
                    case 1:
                        $where[] = "`news_id` = '".$_REQUEST['filter_string']."'";
                        break;
                }
            }

            // build query
            if (!empty($where))
            {
              $where = 'WHERE '.implode(' AND ', $where);
            }
            else
            {
              $where = '';
            }
            $news_data = $FD->db()->conn()->query(
                               'SELECT news_id AS id, CONCAT(1) AS rank
                                FROM '.$FD->config('pref').'news
                                '.$where.'
                                ORDER BY `'.$_REQUEST['order'].'` '.$_REQUEST['sort'].', `news_id` '.$_REQUEST['sort'].'
                                LIMIT '.($_REQUEST['page']-1)*$config_arr['acp_per_page'].",".$config_arr['acp_per_page']);
            $news_data = $news_data->fetchAll(PDO::FETCH_ASSOC);
            $total_entries = $FD->db()->conn()->query('SELECT COUNT(*) FROM '.$FD->config('pref').'news '.$where);
            $total_entries = $total_entries->fetchColumn();
        }

        //run through results
        $entries = array();
        while (true) {

            // get from right source
            if ($searched) {
                 $found = $search->next();
                 $total_entries = $search->getNumberOfFounds();
            } else {
                $found = current($news_data);
                next($news_data);
            }

            // stop when last result
            if ($found === false)
                break;


            // select sqls
            switch ($config_arr['acp_view']) {
                // full (with text preview)
                case 1:
                    $news = $FD->db()->conn()->query('SELECT news_id, cat_id, user_id, news_title, news_date, news_text
                                FROM '.$FD->config('pref').'news WHERE news_id = '.intval($found['id']).' LIMIT 1');
                    $news = $news->fetch(PDO::FETCH_ASSOC);
                    break;
                // extended (but no text preview)
                case 2:
                    $news = $FD->db()->conn()->query('SELECT news_id, cat_id, user_id, news_title, news_date
                                FROM '.$FD->config('pref').'news WHERE news_id = '.intval($found['id']).' LIMIT 1');
                    $news = $news->fetch(PDO::FETCH_ASSOC);
                    break;
                //simple
                default:
                    $news = $FD->db()->conn()->query('SELECT news_id, news_title, news_date
                                FROM '.$FD->config('pref').'news WHERE news_id = '.intval($found['id']).' LIMIT 1');
                    $news = $news->fetch(PDO::FETCH_ASSOC);
                    break;
            }

            // all
            $adminpage->addText('id', $news['news_id']);
            $adminpage->addText('title', killhtml($news['news_title']));
            $adminpage->addText('date', date_loc($FD->text("admin", "date"), $news['news_date']));
            $adminpage->addText('time', date_loc($FD->text("admin", "time"), $news['news_date']));

            // extended or full
            if (in_array($config_arr['acp_view'], array(1, 2))) {
                //get additional data
                $user = $FD->db()->conn()->query('SELECT user_name FROM '.$FD->config('pref').'user WHERE user_id='.intval($news['user_id']).' LIMIT 1');
                $user = $user->fetchColumn();
                $cat = $FD->db()->conn()->query('SELECT cat_name FROM '.$FD->config('pref').'news_cat WHERE cat_id='.intval($news['cat_id']).' LIMIT 1');
                $cat = $cat->fetchColumn();
                $num_comments = $FD->db()->conn()->query('SELECT COUNT(comment_id) FROM '.$FD->config('pref').'comments
                                    WHERE `content_id` = '.intval($news['news_id'])." AND `content_type` = 'news'");
                $num_comments = $num_comments->fetchColumn();
                $num_links = $FD->db()->conn()->query('SELECT COUNT(link_id) FROM '.$FD->config('pref').'news_links
                                    WHERE `news_id` = '.intval($news['news_id']));
                $num_links = $num_links->fetchColumn();

                $adminpage->addText('user_name', $user);
                $adminpage->addText('cat_name', $cat);
                $adminpage->addText('num_comments', $num_comments);
                $adminpage->addText('num_links', $num_links);
            }
            // full
            if ($config_arr['acp_view'] == 1) { // extened
                $text_preview = cut_string(strip_tags(killfs($news['news_text'])), 250, '...');
                $adminpage->addText('text_preview', $text_preview);
            }

            // get entries
            switch ($config_arr['acp_view']) {
                case 1:  $entries[] = $adminpage->get('list_entry_full'); break;
                case 2:  $entries[] = $adminpage->get('list_entry_extended'); break;
                default: $entries[] = $adminpage->get('list_entry_simple'); break;
            }
        }

        // implode entry array
        $num_entries = count($entries);
        $entries = implode("\n", $entries);

    } catch (Exception $e) {
        $error = '<br>'.$e->getMessage();
    }

    // No entries
    if ($total_entries == 0 || !empty($error)) {
        if (!isset($error)) { $error = ''; }
        $adminpage->addText('error', $FD->text("page", "news_not_found").$error);
        $entries = $adminpage->get('list_no_entry');
    }

    // Create Pagination
    $urlFormat = '?go=news_edit&page=%d&order='.$_REQUEST['order'].'&sort='.$_REQUEST['sort'].'&filter_cat='.$_REQUEST['filter_cat'].'&filter_string='.$_REQUEST['filter_string'].'&search_type='.$_REQUEST['search_type'];
    $settings = array('perPage' => $config_arr['acp_per_page'], 'urlFormat' => $urlFormat);
    $pagination = new Pagination($total_entries, $_REQUEST['page'], $settings);

	if (!isset($_POST['news_action']))
		initstr($_POST['news_action']);

    // Display List
    $adminpage->addCond('perm_delete', has_perm('news_delete'));
    $adminpage->addCond('perm_comments', has_perm('news_comments'));
    $adminpage->addCond('action_edit', $_POST['news_action'] == 'edit');
    $adminpage->addCond('action_delete', $_POST['news_action'] == 'delete');
    $adminpage->addCond('action_comments', $_POST['news_action'] == 'comments');
    $adminpage->addText('entries', $entries);
    $adminpage->addText('total_entries', $total_entries);
    $adminpage->addCond('entries', $total_entries != 0);
    $adminpage->addCond('total_entries', $total_entries != 1);
    $adminpage->addText('pagination', $pagination->getAdminTemplate());
    echo $adminpage->get('list');
}
?>
