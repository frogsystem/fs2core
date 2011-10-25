<?php if (ACP_GO == "news_edit") {

///////////////////
//// Functions ////
///////////////////
function default_get_pagenav_data ()
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;
        global $config_arr;
        
        // Set Default Start Value
    if ( !isset ( $_GET['start'] ) ) { $_GET['start'] = 0; }
        settype ( $_GET['start'], 'integer' );
        $limit = $config_arr['acp_per_page'];

        // Create Where Clause for Category Filter
        unset ( $where_clause );
    if ( $_REQUEST['cat_id'] != 0 )
        {
        $where_clause = "WHERE cat_id = '".$_REQUEST['cat_id']."'";
    }

        // Create Pagenavigation
    $index = mysql_query ( "
                                                        SELECT COUNT(news_id) AS 'number'
                                                        FROM ".$global_config_arr['pref']."news
                                                        ".$where_clause."
        ", $FD->sql()->conn() );
        
        $pagenav_arr = get_pagenav_start ( mysql_result ( $index, 0, "number" ), $limit, $_GET['start'] );

        return $pagenav_arr;
}

function default_display_pagenav ( $pagenav_arr )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

        // Prev & Next Page Links
    if ( $pagenav_arr['newpage_exists'] )
    {
        $next_page = '<a href="'.$PHP_SELF.'?go=news_edit&order='.$_REQUEST['order'].'&sort='.$_REQUEST['sort'].'&cat_id='.$_REQUEST['cat_id'].'&start='.$pagenav_arr['new_start'].'">'.$admin_phrases[news][news_edit_next_news].' »</a>';
    }
    if ( $pagenav_arr['old_start_exists'] )
    {
        $prev_page = '<a href="'.$PHP_SELF.'?go=news_edit&order='.$_REQUEST['order'].'&sort='.$_REQUEST['sort'].'&cat_id='.$_REQUEST['cat_id'].'&start='.$pagenav_arr['old_start'].'">« '.$admin_phrases[news][news_edit_prev_news].'</a>';
    }

    // Current Range
    $range_begin = $pagenav_arr['cur_start'] + 1;
    $range_end = $pagenav_arr['cur_start'] + $pagenav_arr['entries_per_page'];
        if ( $range_end > $pagenav_arr['total_entries'] )
        {
        $range_end = $pagenav_arr['total_entries'];
        }
    $range = '<span class="small">'.$admin_phrases[news][news_edit_show_news].'<br><b>'.$range_begin.'</b> '.$admin_phrases[common][to].' <b>'.$range_end.'</b></span>';

    // Pagenavigation Template
    $pagenav = '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr valign="middle">
                                <td width="33%" class="configthin middle">
                                    '.$prev_page.'
                                </td>
                                <td width="33%" align="center" class="middle">
                                    '.$range.'
                                </td>
                                <td width="33%" style="text-align:right;" class="configthin middle">
                                    '.$next_page.'
                                </td>
                            </tr>
                                   </table>
    ';
    
        if ( $pagenav_arr['total_entries'] <= 0 )
        {
        $pagenav = $admin_phrases[news][news_edit_no_news];
        }
    
    return $pagenav;
}



function action_delete_get_data ( $IDS )
{
    global $FD;
    global $global_config_arr;
    global $admin_phrases;

    unset ($return_arr);

    foreach ( $IDS as $NEWS_ID ) {
        unset ($news_arr);
        settype ( $NEWS_ID, "integer" );

        $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news WHERE news_id = '".$NEWS_ID."'", $FD->sql()->conn() );
        $news_arr = mysql_fetch_assoc ( $index );

        $news_arr['news_date_formated'] = "".$admin_phrases[common][on]." <b>" . date ( $admin_phrases[common][date_format] , $news_arr['news_date'] ) . "</b> ".$admin_phrases[common][at]." <b>" . date ( $admin_phrases[common][time_format] , $news_arr['news_date'] ) . "</b>";

        $index2 = mysql_query("SELECT COUNT(comment_id) AS 'number' FROM ".$global_config_arr['pref']."news_comments WHERE news_id = ".$news_arr['news_id']."", $FD->sql()->conn() );
        $news_arr['num_comments'] = mysql_result ( $index2, 0, "number" );

        $index2 = mysql_query("SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$news_arr['user_id']."", $FD->sql()->conn() );
        $news_arr['user_name'] = mysql_result ( $index2, 0, "user_name" );

        $index2 = mysql_query("SELECT cat_name FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = ".$news_arr['cat_id']."", $FD->sql()->conn() );
        $news_arr['cat_name'] = mysql_result ( $index2, 0, "cat_name" );
        
        $return_arr[] = $news_arr;
    }
    
    return $return_arr;
}

function action_delete_display_page ( $return_arr )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;
        

        
        echo '
            <form action="" method="post">
                <input type="hidden" name="sended" value="delete">
                <input type="hidden" name="news_action" value="'.$_POST['news_action'].'">
                <input type="hidden" name="go" value="news_edit">
                <table class="configtable" cellpadding="4" cellspacing="0">
                    <tr><td class="line" colspan="2">'.$admin_phrases[news][news_delete_title].'</td></tr>
                    <tr>
                        <td class="config" style="width: 100%;">
                            '.$admin_phrases[news][news_delete_question].'
                        </td>
                        <td class="config right top" style="padding: 0px;">
                            '.get_yesno_table ( "news_delete" ).'
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
                                <a class="small" href="'.$global_config_arr['virtualhost'].'?go=comments&id='.$news_arr['news_id'].'" target="_blank">
                                    » '.$admin_phrases[news][news_delete_view_news].'
                                </a>
                            </span>
                            <br>
                            <span class="small">
                                '.$admin_phrases[common][by_posted].' <b>'.$news_arr['user_name'].'</b>
                                '.$news_arr['news_date_formated'].'</b>
                                '.$admin_phrases[common][in].' <b>'.$news_arr['cat_name'].'</b>,
                                <b>'.$news_arr['num_comments'].'</b> '.$admin_phrases[common][comments].'
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
                                '.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        ';
}

function action_comments_select ( $DATA )
{
        global $global_config_arr, $FD, $TEXT;
        global $admin_phrases;
        
                // Comments Header
                echo '
                                        <form action="" method="post">
                                                <input type="hidden" name="sended" value="comment">
                                                <input type="hidden" name="news_action" value="'.$DATA['news_action'].'">
                                                <input type="hidden" name="news_id" value="'.$DATA['news_id'].'">
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
                  $index = mysql_query ( "SELECT COUNT(comment_id) AS 'number' FROM ".$global_config_arr['pref']."news_comments WHERE news_id = ".$DATA['news_id']."", $FD->sql()->conn() );
                  $number = mysql_result ( $index, 0, "number" );

                  if ( $number >= 1 ) {
                        $index = mysql_query ( "
                                                                        SELECT *
                                                                        FROM ".$global_config_arr['pref']."news_comments
                                                                        WHERE news_id = ".$DATA['news_id']."
                                                                        ORDER BY comment_date DESC
                        ", $FD->sql()->conn() );

                        // Display Comment-List
                        while ( $comment_arr = mysql_fetch_assoc ( $index ) ) {

                                // Get other Data
                                if ( $comment_arr['comment_poster_id'] != 0 ) {
                                        $index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $FD->sql()->conn() );
                                        $comment_arr['comment_poster'] = mysql_result ( $index2, 0, "user_name" );
                                }
                                $comment_arr['comment_date_formated'] = date ( "d.m.Y" , $comment_arr['comment_date'] ) . " um " . date ( "H:i" , $comment_arr['comment_date'] );

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
                echo'
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                            <td class="right" colspan="4">
                                                                <select class="select_type" name="comment_action" size="1">
                                                                    <option class="select_one" value="edit" '.getselected( "edit", $_POST['comment_action'] ).'>'.$TEXT["admin"]->get("selection_edit").'</option>
                                                                    <option class="select_red" value="delete" '.getselected( "delete", $_POST['comment_action'] ).'>'.$TEXT["admin"]->get("selection_delete").'</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td class="buttontd" colspan="4">
                                                                        <button class="button_new" type="submit">
                                                                                '.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
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
        global $global_config_arr;
        global $admin_phrases;

    settype ( $_POST['comment_id'], 'integer' );
    $index = mysql_query ( "
                                                        SELECT *
                                                        FROM ".$global_config_arr['pref']."news_comments
                                                        WHERE comment_id = ".$_POST['comment_id']."
        ", $FD->sql()->conn() );
    $comment_arr = mysql_fetch_assoc ( $index );

        // Get other Data
        if ( $comment_arr['comment_poster_id'] != 0 ) {
                        $index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $FD->sql()->conn() );
                        $comment_arr['comment_poster'] = mysql_result ( $index2, 0, "user_name" );
        }
        $comment_arr['comment_date_formated'] = date ( "d.m.Y" , $comment_arr['comment_date'] ) . " um " . date ( "H:i" , $comment_arr['comment_date'] );

    echo'
                    <form action="" method="post">
                                                <input type="hidden" name="go" value="news_edit">
                                                <input type="hidden" name="news_action" value="'.$_POST['news_action'].'">
                                                <input type="hidden" name="comment_action" value="'.$_POST['comment_action'].'">
                                                <input type="hidden" name="news_id" value="'.$comment_arr['news_id'].'">
                                                <input type="hidden" name="comment_id" value="'.$comment_arr['comment_id'].'">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Das Kommentar wurde geschreiben am</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr['comment_date_formated'].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Poster:<br>
                                    <font class="small">Diese Person hat das Komemntar geschreiben</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr[comment_poster].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Titel des Kommentars</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="33" name="title" value="'.$comment_arr[comment_title].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                </td>
                                <td valign="top">
                                    '.create_editor("text", killhtml($comment_arr[comment_text]), 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <br /><br />
                                    <input class="button" type="submit" value="Änderungen speichern">
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

function action_comments_delete ( $DATA )
{
        global $global_config_arr, $FD, $TEXT;
        global $admin_phrases;
        
        // Security Function
        $_POST['comment_id'] = ( is_array ( $_POST['comment_id'] ) ) ? $_POST['comment_id'] : array ( $_POST['comment_id'] );
        $_POST['comment_id'] = array_map ( "intval", $_POST['comment_id'] );
        settype ( $_POST['news_id'], "integer" );

        // Display Head of Table
        echo '
                    <form action="" method="post">
                        <input type="hidden" name="go" value="news_edit">
                        <input type="hidden" name="news_action" value="comments">
                        <input type="hidden" name="comment_action" value="delete">
                        <input type="hidden" name="news_id" value="'.$_POST['news_id'].'">
                        <input type="hidden" name="comment_id" value="'.implode ( ",", $_POST['comment_id'] ).'">
                        <input type="hidden" name="sended" value="delete">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="2">'.$TEXT["admin"]->get("news_comments_delete_title").'</td></tr>
                            <tr>
                                <td class="configthin">
                                    '.$TEXT["admin"]->get("news_comments_delete_question").'
                                    <br><br>
        ';

        $index = mysql_query ( "
                                SELECT *
                                FROM `".$global_config_arr['pref']."news_comments`
                                WHERE `comment_id` IN (".implode ( ",", $_POST['comment_id'] ).")
        ", $FD->sql()->conn() );

        while ( $comment_arr = mysql_fetch_assoc ( $index ) ) {

            // Get other Data
            if ( $comment_arr['comment_poster_id'] != 0 ) {
                            $index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $FD->sql()->conn() );
                            $comment_arr['comment_poster'] = mysql_result ( $index2, 0, "user_name" );
            }
            $comment_arr['comment_date_formated'] = date ( "d.m.Y" , $comment_arr['comment_date'] ) . " um " . date ( "H:i" , $comment_arr['comment_date'] );

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
                                    '.get_yesno_table ( "comment_delete" ).'
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$TEXT["admin"]->get("button_arrow").' '.$TEXT["admin"]->get("do_action_button_long").'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
        
}

function db_edit_comment ( $DATA )
{
    global $FD;
    global $global_config_arr;
    global $admin_phrases;

    $DATA['title'] = savesql ( $DATA['title'] );
    $DATA['text'] = savesql ( $DATA['text'] );
    settype ( $DATA['comment_id'], "integer" );

    // MySQL-Update-Query: Comment
    mysql_query ( "
                    UPDATE
                            ".$global_config_arr['pref']."news_comments
                    SET
                            comment_title = '".$DATA['title']."',
                            comment_text = '".$DATA['text']."'
                    WHERE
                            comment_id = '".$DATA['comment_id']."'
    ", $FD->sql()->conn() );

    systext( $admin_phrases[common][changes_saved], $admin_phrases[common][info], FALSE, $admin_phrases[icons][save_ok] );
}

function db_delete_comment ( $DATA )
{
    global $FD;
    global $global_config_arr;
    global $admin_phrases;

    $DATA['comment_id'] = array_map ( "intval", explode ( ",", $DATA['comment_id'] ) );

    // MySQL-Delete-Query: Comment
    mysql_query ( "
                    DELETE FROM
                            ".$global_config_arr['pref']."news_comments
                    WHERE
                            `comment_id` IN (".implode ( ",", $DATA['comment_id'] ).")
    ", $FD->sql()->conn() );
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."counter`
                    SET `comments` = `comments` - ".mysql_affected_rows ()."
    ", $FD->sql()->conn() );

    systext( $admin_phrases[news][news_comment_deleted], $admin_phrases[common][info], FALSE, $admin_phrases[icons][trash_ok] );
}




    

    

###################
## Page Settings ##
###################
$FILE_SHOW_START = true;
$news_cols = array("news_id", "cat_id", "user_id", "news_date", "news_title", "news_text", "news_active", "news_comments_allowed", "news_search_update");

$config_arr = $sql->getById("news_config", array("html_code", "fs_code", "para_handling", "acp_view", "acp_per_page"), 1);
$config_arr['html'] = in_array($config_arr['html_code'], array(2, 4)) ? $TEXT['admin']->get("on") : $TEXT['admin']->get("off");
$config_arr['fs'] = in_array($config_arr['fs_code'], array(2, 4)) ? $TEXT['admin']->get("on") : $TEXT['admin']->get("off");
$config_arr['para'] = in_array($config_arr['para_handling'], array(2, 4)) ? $TEXT['admin']->get("on") : $TEXT['admin']->get("off");

$config_arr['short_url_len'] = 50;
$config_arr['short_url_rep'] = "...";



//////////////////////////
//// Database Actions ////
//////////////////////////

// Edit News
if (
        !isset($_POST['edit_link']) && !isset($_POST['add_link']) &&
        isset ( $_POST['news_id'] ) &&
        count ( $_POST['news_id'] ) == 1 &&
        isset ( $_POST['sended'] ) && $_POST['sended'] == "edit" &&
        isset ( $_POST['news_action'] ) && $_POST['news_action'] == "edit" &&

        $_POST['news_title'] && $_POST['news_title'] != "" &&
        $_POST['news_text'] && $_POST['news_text'] != "" &&

        $_POST['d'] && $_POST['d'] != "" && $_POST['d'] > 0 &&
        $_POST['m'] && $_POST['m'] != "" && $_POST['m'] > 0 &&
        $_POST['y'] && $_POST['y'] != "" && $_POST['y'] > 0 &&
        $_POST['h'] && $_POST['h'] != "" && $_POST['h'] >= 0 &&
        $_POST['i'] && $_POST['i'] != "" && $_POST['i'] >= 0 &&

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

    // MySQL-Insert-Query
    try {
        $newsid = $sql->save("news", $data, "news_id");

        // delete all links
        $sql->delete("news_links", array('W' => "`news_id` = '".$newsid."'"));
        
        // Insert Links to database
        if (!is_array($_POST['link_name']))
            $_POST['link_name'] = array();
        foreach ($_POST['link_name'] as $id => $val) {
            if (!empty($_POST['link_name'][$id]) && !empty($_POST['link_url'][$id]) && !in_array($_POST['link_url'][$id], array("http://", "https://"))) {

                // secure link target
                $_POST['link_target'][$id] = ($_POST['link_target'][$id] == 1 ? 1 : 0);           

                $linkdata = array(
                    'news_id' => $newsid,
                    'link_name' => $_POST['link_name'][$id],
                    'link_url' => $_POST['link_url'][$id],
                    'link_target' => $_POST['link_target'][$id]
                );
                
                // insert into db                
                try {
                    $sql->save("news_links", $linkdata, "link_id");
                } catch (Exception $e) {
                    Throw $e;
                }
            }
        }
        
        // Update Search Index (or not)
        if ( $global_config_arr['search_index_update'] === 1 ) {
            // Include searchfunctions.php
            require ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
            update_search_index ("news");
        }             
        
        echo get_systext($TEXT['admin']->get("changes_saved"), $TEXT['admin']->get("info"), "green", $TEXT['admin']->get("icon_save_ok"));

        // Unset Vars
        unset ($_POST);

    } catch (Exception $e) {
        echo get_systext($TEXT['admin']->get("changes_not_saved")."<br>Caught exception: ".$e->getMessage(), $TEXT['admin']->get("error"), "red", $TEXT['admin']->get("icon_save_error"));
    }
}

// Delete News
elseif (
            isset ( $_POST['news_id'] ) &&
            isset ( $_POST['sended'] ) && $_POST['sended'] == "delete" &&
            isset ( $_POST['news_action'] ) && $_POST['news_action'] == "delete" &&
            isset ( $_POST['news_delete'] )
        )
{
    if ($_POST['news_delete'] == 1 ) {
        try {
            //security
            $_POST['news_id'] = array_map("intval", $_POST['news_id']);
            
            //delete news
            $num = $sql->delete("news", array('W' => "`news_id` IN (".implode(",",$_POST['news_id']).")"));
            
            // Delete from Search Index
            require_once ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
            delete_search_index_for_one($_POST['news_id'], "news");            
            
            // delete all links
            $sql->delete("news_links", array('W' => "`news_id` = '".$_POST['news_id']."'"));
            // delete all comments
            $comment_rows = $sql->delete("news_comments", array('W' => "`news_id` = '".$_POST['news_id']."'"));
                       
            // update counter
            try {
                $sql->doQuery("UPDATE `{..pref..}counter` SET `news` = `news` - 1 WHERE `id` = 1");
                $sql->doQuery("UPDATE `{..pref..}counter` SET `comments` = `comments` - ".$comment_rows." WHERE `id` = 1");
            } catch (Exception $e) {}
            
            
            echo get_systext($TEXT['page']->get("news_deleted")."<br>".$TEXT['admin']->get("deleted_records").": ".$num, $TEXT['admin']->get("info"), "green", $TEXT['admin']->get("icon_trash_ok"));
            
        } catch (Exception $e) {
            Throw $e;
        }
        
    } else {
        echo get_systext($TEXT['page']->get("news_not_deleted"), $TEXT['admin']->get("info"), "green", $TEXT['admin']->get("icon_trash_error"));
    }    
    
        // Unset Vars
        unset ($_POST);
}

// Edit Comments
elseif (
                isset ( $_POST['news_id'] ) &&
                count ( $_POST['news_id'] ) == 1 &&
                isset ( $_POST['comment_id'] ) &&
                isset ( $_POST['sended'] ) && $_POST['sended'] == "edit" &&
                isset ( $_POST['news_action'] ) && $_POST['news_action'] == "comments" &&
                isset ( $_POST['comment_action'] ) && $_POST['comment_action'] == "edit" &&

                $_POST['title'] && $_POST['title'] != "" &&
                $_POST['text'] && $_POST['text'] != ""
        )
{
    db_edit_comment ( $_POST );
    $id = $_POST['news_id'];

    // Unset Vars
    unset ( $_POST );
    $_POST['news_action'] = "comments";
    $_POST['news_id'] = $id;
    unset ( $id );
    $FILE_SHOW_START = FALSE;
}

// Delete Comments
elseif (
                isset ( $_POST['news_id'] ) &&
                isset ( $_POST['comment_id'] ) &&
                isset ( $_POST['sended'] ) && $_POST['sended'] == "delete" &&
                isset ( $_POST['news_action'] ) && $_POST['news_action'] == "comments" &&
                isset ( $_POST['comment_action'] ) && $_POST['comment_action'] == "delete" &&
                isset ( $_POST['comment_delete'] )
        )
{
    if ( $_POST['comment_delete'] == 1 ) {
        db_delete_comment ( $_POST );
    } else {
         systext( "Kommentare wurden nicht gelöscht", $admin_phrases[common][error], FALSE, $admin_phrases[icons][trash_error] );
    }

    // Unset Vars
    $id = $_POST['news_id'];
    unset ( $_POST );
    $_POST['news_action'] = "comments";
    $_POST['comment_action'] = "delete";
    $_POST['news_id'] = $id;
    unset ( $id );
    $FILE_SHOW_START = FALSE;
}


//////////////////////////////
//// Display Action-Pages ////
//////////////////////////////
if ( $_POST['news_id'] && $_POST['news_action'] )
{
    $FILE_SHOW_START = FALSE;
    // Edit News
    if ( $_POST['news_action'] == "edit" && count ( $_POST['news_id'] ) == 1 )
    {
        // read first id from array
        $_POST['news_id'] = $_POST['news_id'][0];
        
        // script
        $adminpage->addCond("target_0", false);
        $adminpage->addCond("target_1", false);
        $adminpage->addCond("button", false);
        $adminpage->addText("name_name", "edit_name");
        $adminpage->addText("url_name", "edit_url");
        $adminpage->addText("target_name", "edit_target");
        $adminpage->addText("class", "space");
        $edit_table = $adminpage->get("edit_table", false);

        $adminpage->addText("table", $edit_table);
        $script_edit = $adminpage->get("link_edit", false);

        $script_entry = $adminpage->get("link_entry", false);
        $adminpage->addText("sul", $config_arr['short_url_len']);
        $adminpage->addText("sur", $config_arr['short_url_rep']);
        $adminpage->addText("link_entry", str_replace(array("\n","\r"), array("",""), $script_entry));
        $adminpage->addText("link_edit", str_replace(array("\n","\r"), array("",""), $script_edit));
        echo $adminpage->get("script", false);
        
        
        // link functions or error
        if (isset($_POST['sended'])) {            
            
            //add link
            if (isset($_POST['add_link'])) {
                if (!empty($_POST['new_link_name']) && !empty($_POST['new_link_url']) && !in_array($_POST['new_link_url'], array("http://", "https://"))) {
                    $_POST['link_name'][] = $_POST['new_link_name'];
                    $_POST['link_url'][] = $_POST['new_link_url'];
                    $_POST['link_target'][] = $_POST['new_link_target'];
                    
                    unset($_POST['new_link_name'], $_POST['new_link_url'], $_POST['new_link_target']);
                    $_POST['new_link_url'] = "http://";
                } else {
                    echo get_systext($TEXT['page']->get("link_not_added")."<br>".$TEXT['admin']->get("form_not_filled"), $TEXT['admin']->get("error"), "red", $TEXT['admin']->get("icon_link_error"));
                }
            
            //edit links
            } elseif (isset($_POST['edit_link'])) {
            
                if(isset($_POST['link']) && !empty($_POST['link_action'])) {
                
                    // löschen
                    if ($_POST['link_action'] == "del") {
                        unset($_POST['link_name'][$_POST['link']], $_POST['link_url'][$_POST['link']], $_POST['link_target'][$_POST['link']]);
                    }
                    
                    //up
                    elseif ($_POST['link_action'] == "up" && $_POST['link'] != 0) {
                        // werte tauschen
                        list($_POST['link_name'][$_POST['link']-1], $_POST['link_name'][$_POST['link']])
                            = array($_POST['link_name'][$_POST['link']], $_POST['link_name'][$_POST['link']-1]);
                        list($_POST['link_url'][$_POST['link']-1], $_POST['link_url'][$_POST['link']])
                            = array($_POST['link_url'][$_POST['link']], $_POST['link_url'][$_POST['link']-1]);
                        list($_POST['link_target'][$_POST['link']-1], $_POST['link_target'][$_POST['link']])
                            = array($_POST['link_target'][$_POST['link']], $_POST['link_target'][$_POST['link']-1]);
                    }
                    
                    //down
                    elseif ($_POST['link_action'] == "down" && $_POST['link'] < count($_POST['link_name'])-1) {
                        // werte tauschen
                        list($_POST['link_name'][$_POST['link']+1], $_POST['link_name'][$_POST['link']])
                            = array($_POST['link_name'][$_POST['link']], $_POST['link_name'][$_POST['link']+1]);
                        list($_POST['link_url'][$_POST['link']+1], $_POST['link_url'][$_POST['link']])
                            = array($_POST['link_url'][$_POST['link']], $_POST['link_url'][$_POST['link']+1]);
                        list($_POST['link_target'][$_POST['link']+1], $_POST['link_target'][$_POST['link']])
                            = array($_POST['link_target'][$_POST['link']], $_POST['link_target'][$_POST['link']+1]);
                    }
                    
                    //bearbeiten
                    elseif ($_POST['link_action'] == "edit") {
                        $_POST['new_link_name'] = $_POST['link_name'][$_POST['link']];
                        $_POST['new_link_url'] = $_POST['link_url'][$_POST['link']];
                        $_POST['new_link_target'] = $_POST['link_target'][$_POST['link']];
                        
                        unset($_POST['link_name'][$_POST['link']], $_POST['link_url'][$_POST['link']], $_POST['link_target'][$_POST['link']]);
                    }
                }
            
            // display error
            } else {
                echo get_systext($TEXT['admin']->get("changes_not_saved")."<br>".$TEXT['admin']->get("form_not_filled"), $TEXT['admin']->get("error"), "red", $TEXT['admin']->get("icon_save_error"));
            }
            
        // Get data from DB
        } else {
            $data = $sql->getById("news", $news_cols, $_POST['news_id'], "news_id");
            putintopost($data);
            
            $_POST['d'] = date("d", $_POST['news_date']);
            $_POST['m'] = date("m", $_POST['news_date']);
            $_POST['y'] = date("Y", $_POST['news_date']);
            $_POST['h'] = date("H", $_POST['news_date']);
            $_POST['i'] = date("i", $_POST['news_date']);            
            
            $_POST['new_link_url'] = "http://";
            
            //grab links from database
            $links = $sql->get("news_links", array("link_name", "link_url", "link_target"), array(
                'W' => "`news_id` = '".$_POST['news_id']."'",
                'O' => "`link_id`"
            ));
            $i = 0;
            foreach ($links['data'] as $link) {
                //form
                list($_POST['link_name'][$i], $_POST['link_url'][$i], $_POST['link_target'][$i])
                    = array($link['link_name'], $link['link_url'], $link['link_target']);
                $i++;
            }                
        }
        
        // Get User
        $_POST['user_name'] = $sql->getFieldById("user", "user_name", $_POST['user_id'], "user_id");
        
        // security functions
        $_POST = array_map("killhtml", $_POST);

        // Create Date-Arrays
        list($_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i']) 
            = array_values(getsavedate($_POST['d'], $_POST['m'], $_POST['y'], $_POST['h'], $_POST['i'], 0, true));

        // cat options
        initstr($cat_options);
        $cats = $sql->get("news_cat", array("cat_id", "cat_name"));
        foreach ($cats['data'] as $cat) {
            settype ($cat['cat_id'], "integer");
            $cat_options .= '<option value="'.$cat['cat_id'].'" '.getselected($cat['cat_id'], $_POST['cat_id']).'>'.$cat['cat_name'].'</option>'."\n";
        }
        
        
        //link entries
        initstr($link_entries);
        $c = 0;
        if (!is_array($_POST['link_name']))
            $_POST['link_name'] = array();
            
        foreach($_POST['link_name'] as $id => $val) {       
            $adminpage->addCond("notscript", true);
            $adminpage->addText("name", killhtml($_POST['link_name'][$id]));
            $adminpage->addText("url", killhtml($_POST['link_url'][$id]));
            $adminpage->addText("target", killhtml($_POST['link_target'][$id]));
            $adminpage->addText("short_url", killhtml(cut_in_string($_POST['link_url'][$id], $config_arr['short_url_len'], $config_arr['short_url_rep'])));
            $adminpage->addText("target_text", $_POST['link_target'][$id] == 1 ? $TEXT['page']->get("news_link_blank") : $TEXT['page']->get("news_link_self"));
            $adminpage->addText("id", $c++);
            $adminpage->addText("num", $c);
            $link_entries .= $adminpage->get("link_entry")."\n";
        }
        
        // link list
        $adminpage->addCond("link_edit", $c >= 1);    
        $adminpage->addText("link_entries", $link_entries);
        $link_list = $adminpage->get("link_list");    

        //link add
        $adminpage->addCond("target_0", $_POST['new_link_target'] === 0);
        $adminpage->addCond("target_1", $_POST['new_link_target'] === 1);
        $adminpage->addCond("button", true);
        $adminpage->addText("name", $_POST['new_link_name']);
        $adminpage->addText("name_name", "new_link_name");
        $adminpage->addText("url", $_POST['new_link_url']);
        $adminpage->addText("url_name", "new_link_url");
        $adminpage->addText("target_name", "new_link_target");
        $adminpage->addText("class", "spacebottom");
        $edit_table = $adminpage->get("edit_table");
        
        $adminpage->addText("table", $edit_table);
        $link_add = $adminpage->get("link_add");
        
        // Conditions
        $adminpage->addCond("news_active", $_POST['news_active'] === 1);
        $adminpage->addCond("news_comments_allowed", $_POST['news_comments_allowed'] === 1);
            
        // Values
        foreach ($_POST as $key => $value) {
            $adminpage->addText($key, $value);
        }
        
        $adminpage->addText("cat_options", $cat_options);
        $adminpage->addText("html", $config_arr['html']);
        $adminpage->addText("fs", $config_arr['fs']);
        $adminpage->addText("para", $config_arr['para']);
        $adminpage->addText("the_editor", create_editor("news_text", $_POST['news_text'], "", "250px", "full", FALSE));
        $adminpage->addText("link_list", $link_list);
        $adminpage->addText("link_add", $link_add);
        
        // display page
        ini_set('xdebug.var_display_max_data', 20000 );
        $t = $adminpage->get("main");
        #var_dump($t);
        echo $t;
    }

    // Delete News
    elseif ( $_POST['news_action'] == "delete" )
    {
        $news_arr = action_delete_get_data ( $_POST['news_id'] );
        action_delete_display_page ( $news_arr );
    }
    
    
    
    
    
    
    
    // Edit Comments
    elseif ( $_POST['news_action'] == "comments" && count ( $_POST['news_id'] ) == 1 )
    {
        $_POST['news_id'] = $_POST['news_id'][0];
        if (
                $_POST['news_id'] && $_POST['news_action'] == "comments" &&
                $_POST['comment_id'] && $_POST['comment_action']
            )
        {
            // Edit Comment
            if ( $_POST['comment_action'] == "edit" && count ( $_POST['comment_id'] ) == 1 ) {
                $_POST['comment_id'] = $_POST['comment_id'][0];
                action_comments_edit ( $_POST );
            } elseif ( $_POST['comment_action'] != "delete" && count ( $_POST['comment_id'] ) > 1 ) {
                systext( "Sie kann nur einen Kommentar gleichzeitig bearbeiten", $admin_phrases[common][error], TRUE, $admin_phrases[icons][error] );
                action_comments_select ( $_POST );
            } elseif ( $_POST['comment_action'] == "delete" ) {
                action_comments_delete ( $_POST );
            } else {
                action_comments_select ( $_POST );
            }
        } else {
                action_comments_select ( $_POST );
        }
    } elseif ( $_POST['news_action'] != "delete" && count ( $_POST['news_id'] ) > 1 ) {
        systext( "Sie kann nur eine News gleichzeitig bearbeiten", $admin_phrases[common][error], TRUE, $admin_phrases[icons][error] );
        $FILE_SHOW_START = TRUE;
    }
}

////////////////////////////////////////
//// Display Default News List Page ////
////////////////////////////////////////
if ($FILE_SHOW_START)
{
    // Filter
    $_REQUEST['order'] = killhtml(isset($_REQUEST['order']) ? $_REQUEST['order'] : "news_date");
    $_REQUEST['sort'] = killhtml(isset($_REQUEST['sort']) ? $_REQUEST['sort'] : "DESC");
    $_REQUEST['filter_cat'] = isset($_REQUEST['filter_cat']) ? $_REQUEST['filter_cat'] : 0;
    settype($_REQUEST['filter_cat'], "integer");
    settype($_REQUEST['search_type'], "integer");
    $_REQUEST['filter_string'] = isset($_REQUEST['filter_string']) ? killhtml($_REQUEST['filter_string']) : "";

    //cat filter options
    initstr($cat_filter_options);
    $cats = $sql->get("news_cat", array("cat_id", "cat_name"));
    foreach ($cats['data'] as $cat) {
        $cat = array_map("killhtml", $cat);
        $cat_filter_options .= '<option value="'.$cat['cat_id'].'" '.getselected($cat['cat_id'], $_REQUEST['filter_cat']).' title="'.$cat['cat_name'].'">'.cut_string($cat['cat_name'], 35, "...").'</option>'."\n";
    }
    
    // display filter
    for ($i=0; $i<2; $i++)
        $adminpage->addCond("search_type_".$i, $_REQUEST['search_type'] === $i);
    $adminpage->addCond("filter_cat", $_REQUEST['filter_cat'] === 0);
    $adminpage->addCond("order_id", $_REQUEST['order'] === "news_id");
    $adminpage->addCond("order_date", $_REQUEST['order'] === "news_date");
    $adminpage->addCond("order_title", $_REQUEST['order'] === "news_title");
    $adminpage->addCond("sort_asc", $_REQUEST['sort'] === "ASC");
    $adminpage->addCond("sort_desc", $_REQUEST['sort'] === "DESC");
    $adminpage->addText("filter_string", $_REQUEST['filter_string']);
    $adminpage->addText("filter_cat_options", $cat_filter_options);   
    echo $adminpage->get("filter");

    
    // Page list
    try {
        //TODO: pagenav

        
        // serached?
        $searched = !empty($_REQUEST['filter_string']) && $_REQUEST['search_type'] === 0;
        
        // search
        if ($searched) {
            // do the search
            $search = new Search("news", $_REQUEST['filter_string'], false);
            $search->setOrder("`".$_REQUEST['order']."` ".$_REQUEST['sort'], "`news_id` ".$_REQUEST['sort']);
            $search->setWhere(($_REQUEST['filter_cat'] != 0 ? "`cat_id` = ".$_REQUEST['filter_cat'] : ""));
            $search->setLimit($config_arr['acp_per_page']);

        // just filter
        } else {
            // Set where for cat, ID and URL Filter
            $where = array();
            if ($_REQUEST['filter_cat'] != 0)
                $where[] = "`cat_id` = ".$_REQUEST['filter_cat'];
                
            if (!empty($_REQUEST['filter_string'])) {
                switch ($_REQUEST['search_type']) {
                    case 1:
                        $where[] = "`news_id` = '".$_REQUEST['filter_string']."'";
                        break;
                }
            }
            
            // build query
            $news_data = $sql->get("news", array(
                array('COL' => "news_id", 'AS' => "id"),
                array('FUNC' => "CONCAT", 'ARG' => 1, 'AS' => "rank")
            ), array(
                'W' => implode(" AND ", $where),
                'O' => "`".$_REQUEST['order']."` ".$_REQUEST['sort'].", `news_id` ".$_REQUEST['sort']."",
                'L' => $config_arr['acp_per_page']
            ), false, true);
            $total_entries = $news_data['num_all'];
            $news_data = $news_data['data'];
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
                    $news = $sql->getById("news", array("news_id", "cat_id", "user_id", "news_title", "news_date", "news_text"), $found['id'], "news_id");
                    break;
                // extended (but no text preview)
                case 2:
                    $news = $sql->getById("news", array("news_id", "cat_id", "user_id", "news_title", "news_date"), $found['id'], "news_id");
                    break;
                //simple
                default:
                    $news = $sql->getById("news", array("news_id", "news_title", "news_date"), $found['id'], "news_id");            
                    break;
            }
            
            // all
            $adminpage->addText("id", $news['news_id']);
            $adminpage->addText("title", killhtml($news['news_title']));
            $adminpage->addText("date", date_loc($TEXT['admin']->get("date"), $news['news_date']));
            $adminpage->addText("time", date_loc($TEXT['admin']->get("time"), $news['news_date']));
            
            // extended or full
            if (in_array($config_arr['acp_view'], array(1, 2))) {
                //get additional data
                $user = $sql->getFieldById("user", "user_name", $news['user_id'], "user_id");
                $cat = $sql->getFieldById("news_cat", "cat_name", $news['cat_id'], "cat_id");
                $num_comments = $sql->getField("news_comments",
                    array('COL' => "comment_id", 'AS' => "news_comments", 'FUNC' => "count"),
                    array('W' => "`news_id` = '".$news['news_id']."'")
                );
                $num_links = $sql->getField("news_links",
                    array('COL' => "link_id", 'AS' => "num_links", 'FUNC' => "count"),
                    array('W' => "`news_id` = '".$news['news_id']."'")
                );            
                
                $adminpage->addText("user_name", $user);
                $adminpage->addText("cat_name", $cat);
                $adminpage->addText("num_comments", $num_comments);
                $adminpage->addText("num_links", $num_links);
            }
            // full
            if ($config_arr['acp_view'] == 1) { // extened
                $text_preview = cut_string(killfs($news['news_text']), 250, "...");
                $adminpage->addText("text_preview", $text_preview);
            }
            
            // get entries
            switch ($config_arr['acp_view']) {
                case 1:  $entries[] = $adminpage->get("list_entry_full"); break;
                case 2:  $entries[] = $adminpage->get("list_entry_extended"); break;
                default: $entries[] = $adminpage->get("list_entry_simple"); break;
            }
        }
        
        // implode entry array
        $num_entries = count($entries);
        $entries = implode("\n", $entries);

    } catch (Exception $e) {   
        $error = "<br>".$e->getMessage();
    }

    // No entries
    if ($total_entries == 0 || !empty($error)) {
        $adminpage->addText("error", $TEXT['page']->get('news_not_found').$error);
        $entries = $adminpage->get("list_no_entry");
    }
    
    // Display List
    $adminpage->addCond("perm_delete", $_SESSION['news_delete'] === 1);
    $adminpage->addCond("perm_comments", $_SESSION['news_comments'] === 1);
    $adminpage->addCond("action_edit", $_POST['news_action'] == "edit");
    $adminpage->addCond("action_delete", $_POST['news_action'] == "delete");
    $adminpage->addCond("action_comments", $_POST['news_action'] == "comments");
    $adminpage->addText("entries", $entries);      
    $adminpage->addText("total_entries", $total_entries);      
    $adminpage->addCond("entries", $total_entries != 0);      
    $adminpage->addCond("total_entries", $total_entries != 1);      
    echo $adminpage->get("list");
    
    
    
    //default_display_page ( default_display_all_entries ( default_get_pagenav_data () ), //default_get_pagenav_data (), $_REQUEST  );
}




} ?>
