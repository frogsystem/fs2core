<?php


//////////////////////////
//// get old page nav ////
// => should be replaced by a generic Pagination class
function get_page_nav ( $PAGE, $NUM_OF_PAGES, $PER_PAGE, $NUM_OF_ENTRIES, $URL_TEMPLATE )
{
    global $FD;

    // Security Functions
    settype ( $PAGE, 'integer' );
    settype ( $NUM_OF_PAGES, 'integer' );
    settype ( $PER_PAGE, 'integer' );
    settype ( $NUM_OF_ENTRIES, 'integer' );

    // Prev Template
    $template_prev = '';
    $prev_url = str_replace ( array('{..page_num..}', urlencode('{..page_num..}')), $PAGE-1, $URL_TEMPLATE );
    $prev_url = str_replace ( '{..page_num..}', $PAGE-1, $prev_url );
    if ( $PAGE > 1 ) {
        $template_prev = str_replace ( '{..url..}', $prev_url, $FD->config('page_prev') );
    }

    // Next Template
    $template_next = '';
    $next_url = str_replace ( array('{..page_num..}', urlencode('{..page_num..}')), $PAGE+1, $URL_TEMPLATE );
    if ( ( $PAGE*$PER_PAGE ) < $NUM_OF_ENTRIES ) {
        $template_next = str_replace ( '{..url..}', $next_url, $FD->config('page_next') );
    }

    // Main Template
    $template = str_replace ( '{..page_number..}', $PAGE, $FD->config('page') );
    $template = str_replace ( '{..total_pages..}', $NUM_OF_PAGES, $template );
    $template = str_replace ( '{..prev..}', $template_prev, $template );
    $template = str_replace ( '{..next..}', $template_next, $template );

    return $template;
}


/////////////////////////////////
//// Check Anti-Spam Captcha ////
// => should be in a future captcha class
function check_captcha ( $SOLUTION, $ACTIVATION )
{
    global $FD;

    function encrypt_captcha ( $STRING, $KEY ) {
        $result = '';
        for ( $i = 0; $i < strlen ( $STRING ); $i++ ) {
            $char = substr ( $STRING, $i, 1 );
               $keychar = substr ( $KEY, ( $i % strlen ( $KEY ) ) -1, 1 );
               $char = chr ( ord ( $char ) + ord ( $keychar ) );
            $result .= $char;
        }
        return base64_encode($result);
    }

    $sicherheits_eingabe = encrypt_captcha ( $SOLUTION, $FD->env('SPAM_KEY') );
    $sicherheits_eingabe = str_replace ('=', '', $sicherheits_eingabe );

    if ( $ACTIVATION === 0 ) {
        return TRUE;
    } elseif ( $ACTIVATION == 1 && isset($_SESSION['user_id']) && 0 !== $_SESSION['user_id']) {
        return TRUE;
    } elseif ( $ACTIVATION == 3 && isset($_SESSION['user_id']) && is_in_staff ( $_SESSION['user_id'] ) ) {
        return TRUE;
    } elseif ( $ACTIVATION == 4 && isset($_SESSION['user_id']) && is_admin ( $_SESSION['user_id'] ) ) {
        return TRUE;
    } elseif ( isset($_SESSION['captcha']) && $sicherheits_eingabe == $_SESSION['captcha'] && $sicherheits_eingabe == TRUE && is_numeric( $SOLUTION ) == TRUE ) {
        return TRUE;
    } else {
        return FALSE;
    }
}




////////////////////////////////
///// Download Categories //////
// ==> should be some generic categories, taxonmy class
function get_dl_categories (&$IDs, $CAT_ID, $SHOW_SUB = 1, $ID = 0, $LEVEL = -1 )
{
    global $FD;

    $index = $FD->db()->conn()->query ( '
                            SELECT * FROM `'.$FD->env('DB_PREFIX')."dl_cat`
                            WHERE `subcat_id` = '".$ID."'
                            ORDER BY `cat_name`" );

    while ( $line = $index->fetch(PDO::FETCH_ASSOC) ) {
        $line['level'] = $LEVEL + 1;
        $IDs[] = $line;
        if ( $SHOW_SUB == 1 || $line['cat_id'] == $CAT_ID || in_array ( $CAT_ID, get_sub_cats ( $line['cat_id'], array () ) ) ) {
            get_dl_categories ( $IDs, $CAT_ID, $SHOW_SUB, $line['cat_id'], $line['level'] );
        }
    }
}
//////////////////////////////
//// Get IDs of DL-Subcat ////
//////////////////////////////
function get_sub_cats ( $CAT_ID, $REC_SUB_CAT_ARRAY )
{
    global $FD;
    static $sub_cat_ids = array();
    $sub_cat_ids = $REC_SUB_CAT_ARRAY;

    $subcat_index = $FD->db()->conn()->query ( '
        SELECT `cat_id`
        FROM `'.$FD->env('DB_PREFIX')."dl_cat`
        WHERE `subcat_id` = '".$CAT_ID."'" );

    while ( $subcats = $subcat_index->fetch(PDO::FETCH_ASSOC) ) {
        $sub_cat_ids[] = $subcats['cat_id'];
        get_sub_cats ( $subcats['cat_id'], $sub_cat_ids );
    }
    return $sub_cat_ids;
}




///////////////////////////////////////////////////////////////
// Check if the visitor has already voted in the given poll  //
///////////////////////////////////////////////////////////////
function checkVotedPoll($pollid) {

    global $FD;

    settype($pollid, 'integer');

    if (isset($_COOKIE['polls_voted'])) {
        $votes = explode(',', $_COOKIE['polls_voted']);
        if (in_array($pollid, $votes )) {
            return true;
        }
    }
    $one_day_ago = time()-60*60*24;
    $FD->db()->conn()->exec('DELETE FROM '.$FD->env('DB_PREFIX')."poll_voters WHERE time <= '".$one_day_ago."'"); //Delete old IPs
    $query_id = $FD->db()->conn()->prepare('SELECT COUNT(voter_id) FROM '.$FD->env('DB_PREFIX')."poll_voters WHERE poll_id = $pollid AND ip_address = ? AND time > '".$one_day_ago."' LIMIT 1"); //Save IP for 1 Day
    $query_id->execute(array($_SERVER['REMOTE_ADDR']));
    return ( $query_id->fetchColumn() > 0 );
}

///////////////////////////////////////////////////////////////
//// Register the voter in the db to avoid multiple votes  ////
///////////////////////////////////////////////////////////////
function registerVoter($pollid, $voter_ip) {

    global $FD;

    settype($pollid, 'integer');

    $FD->db()->conn()->exec('INSERT INTO '.$FD->env('DB_PREFIX')."poll_voters VALUES ('', '$pollid', '$voter_ip', '".time()."')");
    if (!isset($_COOKIE['polls_voted'])) {
        setcookie('polls_voted', $pollid, time()+60*60*24*60); //2 months
    } else {
        setcookie('polls_voted', $_COOKIE['polls_voted'].','.$pollid, time()+60*60*24*60);
    }
}







////////////////////////////////////////
//// Get Preview Image by Timetable ////
////////////////////////////////////////
function get_timed_pic ()
{
    global $FD;

    $time = time();
    $index = $FD->db()->conn()->query ( "
                    SELECT COUNT(R.`screen_id`) AS 'images'
                    FROM `".$FD->env('DB_PREFIX').'screen_random` R
                    WHERE R.`start` <= '.$time.' AND R.`end` >= '.$time.' ' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $num_images = $row['images'];
    if ( $num_images > 0 ) {
        // Get random number
        $rand = rand ( 0, $num_images - 1 );
        $index =  $FD->db()->conn()->query ( '
                        SELECT S.`screen_id`, S.`screen_name`, C.`cat_id`, C.`cat_name`
                        FROM `'.$FD->env('DB_PREFIX').'screen_random` R, `'.$FD->env('DB_PREFIX').'screen` S, `'.$FD->env('DB_PREFIX').'screen_cat` C
                        WHERE R.`start` <= '.$time.' AND R.`end` >= '.$time.'
                        AND R.`screen_id` = S.`screen_id`
                        LIMIT '.$rand.',1' );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        $dbscreen['id'] = $row['screen_id'];
        settype ( $dbscreen['id'], 'integer' );
        $dbscreen['caption'] = $row['screen_name'];
        $dbscreen['cat_id'] = $row['cat_id'];
        settype ( $dbscreen['cat_id'], 'integer' );
        $dbscreen['cat_title'] = $row['cat_name'];
        $dbscreen['type'] = 1;

        return $dbscreen;
    } else {
        return FALSE;
    }
}

//////////////////////////////////
//// Get Random Preview Image ////
//////////////////////////////////
function get_random_pic ()
{
    global $FD;

    // Get number of possible Screens
    $index = $FD->db()->conn()->query ( "
                    SELECT COUNT(S.`screen_id`) AS 'images'
                    FROM `".$FD->env('DB_PREFIX').'screen` S, `'.$FD->env('DB_PREFIX').'screen_cat` C
                    WHERE C.`randompic` = 1
                    AND C.`cat_id` = S.`cat_id`' );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $num_images = $row['images'];
    if ( $num_images > 0 ) {
        // Get random number
        $rand = rand ( 0, $num_images - 1 );
        $index = $FD->db()->conn()->query ( '
                        SELECT S.`screen_id`, S.`screen_name`, C.`cat_id`, C.`cat_name`
                        FROM `'.$FD->env('DB_PREFIX').'screen` S, `'.$FD->env('DB_PREFIX').'screen_cat` C
                        WHERE C.`randompic` = 1
                        AND C.`cat_id` = S.`cat_id`
                        LIMIT '.$rand.',1' );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        $dbscreen['id'] = $row['screen_id'];
        settype ( $dbscreen['id'], 'integer' );
        $dbscreen['caption'] = $row['screen_name'];
        $dbscreen['cat_id'] = $row['cat_id'];
        settype ( $dbscreen['cat_id'], 'integer' );
        $dbscreen['cat_title'] = $row['cat_name'];
        $dbscreen['type'] = 2;

        return $dbscreen;
    } else {
        return FALSE;
    }
}

//////////////////////////////////////////////////////////
//// clean database from expired timed preview_images ////
//////////////////////////////////////////////////////////
function clean_timed_preview_images () {
    global $FD;
    $FD->loadConfig('preview_images');

    // do we want to remove old entries?
    if ($FD->config('preview_images', 'timed_deltime') != -1) {
        // remove old entries
        $FD->db()->conn()->query('DELETE FROM '.$FD->env('DB_PREFIX')."screen_random WHERE `end` < '".($FD->env('time')-$FD->config('preview_images', 'timed_deltime'))."'");
    }
}



////////////////////////////////
//////// Display News //////////
////////////////////////////////

function display_news ($news_arr, $html_code, $fs_code, $para_handling)
{
    global $FD;

    $news_arr['news_date'] = date_loc( $FD->config('datetime') , $news_arr['news_date']);
    $news_arr['comment_url'] = url('comments', array('id' => $news_arr['news_id']));

    // Kategorie lesen
    $index2 = $FD->db()->conn()->query('SELECT cat_name FROM '.$FD->env('DB_PREFIX')."news_cat WHERE cat_id = '".$news_arr['cat_id']."'");
    $row = $index2->fetch(PDO::FETCH_ASSOC);
    $news_arr['cat_name'] = $row['cat_name'];
    $news_arr['cat_pic'] = image_url('/cat', 'news_'.$news_arr['cat_id']);

    // Text formatieren
    switch ($html_code)
    {
        case 1:
            $html = false;
            break;
        case 2:
            $html = true;
            break;
        case 3:
            $html = false;
            break;
        case 4:
            $html = true;
            break;
    }
    switch ($fs_code)
    {
        case 1:
            $fs = false;
            break;
        case 2:
            $fs = true;
            break;
        case 3:
            $fs = false;
            break;
        case 4:
            $fs = true;
            break;
    }
    switch ($para_handling)
    {
        case 1:
            $para = false;
            break;
        case 2:
            $para = true;
            break;
        case 3:
            $para = false;
            break;
        case 4:
            $para = true;
            break;
    }

    $news_arr['news_text'] = fscode ( $news_arr['news_text'], $fs, $html, $para );
    $news_arr['news_title'] = killhtml ( $news_arr['news_title'] );

    // User auslesen
    $index2 = $FD->db()->conn()->query('SELECT user_name FROM '.$FD->env('DB_PREFIX').'user WHERE user_id = '.$news_arr['user_id'].'' );
    $row = $index2->fetch(PDO::FETCH_ASSOC);
    $news_arr['user_name'] = kill_replacements ( $row['user_name'], TRUE );
    $news_arr['user_url'] = url('user', array('id' => $news_arr['user_id']));

    // Kommentare lesen
    $index2 = $FD->db()->conn()->query('SELECT comment_id FROM '.$FD->env('DB_PREFIX').'comments WHERE content_id = '.$news_arr['news_id'].' AND content_type=\'news\'' );
    $all_comment_ids = $index2->fetchAll(PDO::FETCH_ASSOC);
    $news_arr['kommentare'] = count($all_comment_ids);

    // Get Related Links
    $link_tpl = '';
    $index2 = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'news_links WHERE news_id = '.$news_arr['news_id'].' ORDER BY link_id');
    while ($link_arr = $index2->fetch(PDO::FETCH_ASSOC))
    {
        $link_arr['link_name'] = killhtml ( $link_arr['link_name'] );
        $link_arr['link_url'] = killhtml ( $link_arr['link_url'] );
        $link_arr['link_target'] = ( $link_arr['link_target'] == 1 ) ? '_blank' : '_self';

        // Get Link Line Template
        $link = new template();
        $link->setFile('0_news.tpl');
        $link->load('LINKS_LINE');

        $link->tag('title', $link_arr['link_name'] );
        $link->tag('url', $link_arr['link_url'] );
        $link->tag('target', $link_arr['link_target'] );

        $link = $link->display ();
        $link_tpl .= $link;
    }
    if ($link_tpl!=='') {
        // Get Links Body Template
        $related_links = new template();
        $related_links->setFile('0_news.tpl');
        $related_links->load('LINKS_BODY');
        $related_links->tag('links', $link_tpl );
        $related_links = $related_links->display ();
    } else {
        $related_links = '';
    }

    // Template lesen und füllen
    $template = new template();
    $template->setFile('0_news.tpl');
    $template->load('NEWS_BODY');

    $template->tag('news_id', $news_arr['news_id'] );
    $template->tag('titel', $news_arr['news_title'] );
    $template->tag('date', $news_arr['news_date'] );
    $template->tag('text', $news_arr['news_text'] );
    $template->tag('user_name', $news_arr['user_name'] );
    $template->tag('user_url', $news_arr['user_url'] );
    $template->tag('cat_name', $news_arr['cat_name'] );
    $template->tag('cat_image', $news_arr['cat_pic'] );
    $template->tag('comments_url', $news_arr['comment_url'] );
    $template->tag('comments_number', $news_arr['kommentare'] );
    $template->tag('related_links', $related_links );

    $template = $template->display ();
    $news_template = $template;
    return $news_template;
}
?>
