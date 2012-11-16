<?php
require_once(FS2_ROOT_PATH . 'includes/newfunctions.php');


////////////////////
//// IPs Online ///
////////////////////
function get_online_ips () {
    global $FD;

    // init array
    $numbers = array('users' => 0, 'guests' => 0, 'all' => 0);

    // get values from db
    $numbers['users'] = $FD->sql()->getField('useronline',
        array('COL' => 'user_id', 'FUNC' => 'COUNT', 'AS' => 'users'),
        array('W' => "`date` > '".($FD->env('time')-300)."' AND `user_id` != 0")
    );
    $numbers['guests'] = $FD->sql()->getField('useronline',
        array('COL' => 'user_id', 'FUNC' => 'COUNT', 'AS' => 'guests'),
        array('W' => "`date` > '".($FD->env('time')-300)."' AND `user_id` = 0")
    );

    //calc all
    $numbers['all'] = $numbers['users'] + $numbers['guests'];

    return $numbers;
}

/////////////////////////
//// Delete Referrers ///
/////////////////////////
function delete_referrers ($days, $hits, $contact, $age, $amount, $time = null) {

    global $FD;

    // set now
    if (empty($time))
        $time = $FD->cfg('time');

    // get last date
    $del_date = $time - $days * 86400;

    // security and sql prepartion
    settype($hits, 'integer');
    switch ($contact) {
        case 'first': $contact = 'first'; break;
        default: $contact = 'last'; break;
    }
    switch ($age) {
        case 'older': $age = '<'; break;
        default: $age = '>'; break;
    }
    switch ($amount) {
        case 'less': $amount = '<'; break;
        default: $amount = '>'; break;
    }

    return $FD->sql()->delete('counter_ref', array(
        'W' => '`ref_'.$contact.'` '.$age." '".$del_date."' AND `ref_count` ".$amount." '".$hits."'"));
}

////////////////////
//// create URL ////
////////////////////
function url ($go, $args = array(), $full = false) {
    global $FD;

    switch ($FD->cfg('url_style')) {
        case 'seo':
            $url = url_seo($go, $args);
            break;

        default:
            // check for empty go
            if (!empty($go))
                $args = array('go' => $go)+$args;

            $url = http_build_query($args, 'p', '&amp;');
            if (!empty($url))
                $url = '?'.$url;
            break;
    }

    // create full url?
    if ($full)
        $url = $FD->cfg('virtualhost').$url;

    // return url
    return $url;
}


//////////////////////////
//// get old page nav ////
//////////////////////////
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


/////////////////////////////
//// scandir with filter ////
/////////////////////////////

function scandir_filter ( $FOLDER, $EXTRA = array(), $BAD = array ( '.', '..', '.DS_Store', '_notes', 'Thumbs.db', '.svn' ) )
{
    if ( !is_dir ( $FOLDER ) ) {
        return FALSE;
    }

    $bad = array_merge ( $EXTRA, $BAD );
    $contents = @scandir ( $FOLDER );
    if ( is_array ( $contents ) ) {
        $contents = array_diff ( $contents, $bad );
        natcasesort ( $contents );
    } else {
        $contents = array();
    }
    return $contents;
}


//////////////////////////////////////////////////
//// scandir for files with certain extention ////
//////////////////////////////////////////////////

function scandir_ext ( $FOLDER, $FILE_EXT, $EXTRA = array(), $BAD = array ( '.', '..', '.DS_Store', '_notes', 'Thumbs.db', '.svn' ) )
{
    if ( $files = scandir_filter ( $FOLDER, $EXTRA, $BAD ) ) {
        $file_names = array();
        foreach ( $files as $file ) {
            if ( pathinfo ( $file, PATHINFO_EXTENSION ) == $FILE_EXT ) {
                $file_names[] = pathinfo ( $file, PATHINFO_BASENAME );
            }
        }
        return $file_names;
    }
    return FALSE;
}



///////////////////////
//// Localize Date ////
///////////////////////
function get_user_rank ( $GROUP_ID, $IS_ADMIN = 0 )
{
    global $FD;

    if ( $GROUP_ID == 0 && $IS_ADMIN != 1 ) {
        $retrun_arr['user_group_id'] = 0;
        $retrun_arr['user_group_name'] = '';
        $retrun_arr['user_group_title'] = '';
        $retrun_arr['user_group_rank'] = '';
    } else {
        $index = mysql_query ( '
            SELECT *
            FROM `'.$FD->config('pref')."user_groups`
            WHERE `user_group_id` = '".$GROUP_ID."'
        ", $FD->sql()->conn() );
        $group_arr = mysql_fetch_assoc ( $index );

        settype ( $group_arr['user_group_id'], 'integer' );
        $group_arr['user_group_name'] = stripslashes ( $group_arr['user_group_name'] );
        $group_arr['user_group_title'] = stripslashes ( $group_arr['user_group_title'] );
        $group_arr['user_group_image'] = ( image_exists ( 'media/group-images/staff_', $group_arr['user_group_id'] ) ? '<img src="'.image_url ( 'media/group-images/staff_', $group_arr['user_group_id'] ).'" alt="'.$FD->text("frontend", "group_image_of").' '.$group_arr['user_group_name'].'">' : '' );

        unset ( $title_style );
        $title_style .= ( $group_arr['user_group_color'] != -1 ? 'color:#'.stripslashes ( $group_arr['user_group_color'] ).';' : '' );
        switch ( $group_arr['user_group_highlight'] ) {
            case 1:
                $highlight_css = 'font-weight:bold;';
                break;
            case 2:
                $highlight_css = 'font-style:italic;';
                break;
            case 5:
                $highlight_css = 'font-weight:bold;font-style:italic;';
                break;
        }
        $title_style .= ( $highlight_css != '' ? $highlight_css : '' );
        $group_arr['user_group_title_colored'] = '<span style="'.$title_style.'">'.$group_arr['user_group_title'].'</span>';

        $rank_template = new template();
        $rank_template->setFile ( '0_user.tpl' );
        $rank_template->load ( 'USERRANK' );
        $rank_template->tag ( 'group_name', $group_arr['user_group_name'] );
        $rank_template->tag ( 'group_image', $group_arr['user_group_image'] );
        $rank_template->tag ( 'group_image_url', image_url ( 'media/group-images/staff_', $group_arr['user_group_id'] ) );
        $rank_template->tag ( 'group_title', $group_arr['user_group_title_colored'] );
        $rank_template->tag ( 'group_title_text_only', $group_arr['user_group_title'] );
        $rank_template = $rank_template->display ();

        $retrun_arr['user_group_id'] = $group_arr['user_group_id'];
        $retrun_arr['user_group_name'] = $group_arr['user_group_name'];
        $retrun_arr['user_group_title'] = $group_arr['user_group_title'];
        $retrun_arr['user_group_rank'] = $rank_template;
    }
    return $retrun_arr;
}



//////////////////////////////
//// Get IDs of DL-Subcat ////
//////////////////////////////
function get_sub_cats ( $CAT_ID, $REC_SUB_CAT_ARRAY )
{
    global $FD;
    static $sub_cat_ids = array();
    $sub_cat_ids = $REC_SUB_CAT_ARRAY;

    $subcat_index = mysql_query ( '
        SELECT `cat_id`
        FROM `'.$FD->config('pref')."dl_cat`
        WHERE `subcat_id` = '".$CAT_ID."'
    ", $FD->sql()->conn() );

    while ( $subcats = mysql_fetch_assoc ( $subcat_index ) ) {
        $sub_cat_ids[] = $subcats['cat_id'];
        get_sub_cats ( $subcats['cat_id'], $sub_cat_ids );
    }
    return $sub_cat_ids;
}

/////////////////////////////////
//// Create DL-Folder-System ////
/////////////////////////////////
function create_dl_cat ($CAT_ID, $GET_ID, $NAVI_TEMPLATE) {
    global $FD;
    static $navi;
    static $i = 0;

    $i++;
    $data[$CAT_ID] = mysql_query ( '
        SELECT *
        FROM `'.$FD->config('pref')."dl_cat`
        WHERE `subcat_id` = '".$CAT_ID."'
    ", $FD->sql()->conn() );

    while ( $array = mysql_fetch_assoc ( $data[$CAT_ID] ) ) {
        $index = mysql_query ( '
            SELECT `cat_id`
            FROM `'.$FD->config('pref')."dl_cat`
            WHERE `subcat_id` = '".$array['cat_id']."'
        ", $FD->sql()->conn() );
        $num_subcat = mysql_num_rows ( $index );

        unset ( $ids );
        $ids = get_sub_cats ( $array['cat_id'], array() );

        $template = $NAVI_TEMPLATE;
        $cat_url = url('download', array('catid' => $array['cat_id']));
        $top_url = url('download', array('catid' => $array['subcat_id']));
        $folder = ( $array['cat_id'] == $GET_ID ? 'folder_open.gif' : 'folder.gif' );
        $open = ( ( $array['cat_id'] == $GET_ID || in_array ( $GET_ID, $ids ) ) ? 'minus.gif' : 'plus.gif' );
        $open_url = ( ( $array['cat_id'] == $GET_ID || in_array ( $GET_ID, $ids ) ) ? $top_url : $cat_url );
        $nbsp = str_repeat( '&nbsp;', $i-1);

        $template = str_repeat( '<img class="textmiddle" src="images/design/null.gif" alt="" border="0" align="absmiddle" width="16" height="0">', $i-1) . $template;

        if ( $num_subcat <= 0 ) {
            $template = str_replace( '{open_link}', $nbsp.'<img class="textmiddle" src="images/design/null.gif" alt="" width="16" height="0">', $template );
        }
        $template = str_replace( '{open_link}', $nbsp.'<a class="textmiddle" href="'.$open_url.'"><img class="textmiddle" style="margin-left:4px; margin-right:3px;" src="images/icons/dl/'.$open.'" alt="" border="0" align="absmiddle"></a>', $template );
        $template = str_replace( '{folder_link}', '&nbsp;<a class="textmiddle" href="'.$cat_url.'"><img class="textmiddle" src="images/icons/dl/'.$folder.'" alt="" border="0" align="absmiddle"></a>', $template );

        $template = str_replace( '{cat_url}', $cat_url, $template);
        $template = str_replace( '{cat_name}', $array['cat_name'], $template );
        $template = str_replace( '{class}', ( $array['cat_id'] == $GET_ID ? ' active' : '' ), $template);

        $navi .= $template;
        if ( $array['cat_id'] == $GET_ID || in_array ( $GET_ID, $ids ) ) {
            create_dl_cat ( $array['cat_id'], $GET_ID, $NAVI_TEMPLATE );
        }
    }
    $i--;
    return $navi;
}


////////////////////////////////////////
//// Get Preview Image by Timetable ////
////////////////////////////////////////
function get_timed_pic ()
{
    global $FD;

    $time = time();
    $index = mysql_query ( "
                            SELECT COUNT(R.`screen_id`) AS 'images'
                            FROM `".$FD->config('pref').'screen_random` R
                            WHERE R.`start` <= '.$time.' AND R.`end` >= '.$time.'
    ', $FD->sql()->conn() );

    $num_images = mysql_result ( $index, 0, 'images' );
    if ( $num_images > 0 ) {
        // Get random number
        $rand = rand ( 0, $num_images - 1 );
        $index = mysql_query ( '
                                SELECT S.`screen_id`, S.`screen_name`, C.`cat_id`, C.`cat_name`
                                FROM `'.$FD->config('pref').'screen_random` R, `'.$FD->config('pref').'screen` S, `'.$FD->config('pref').'screen_cat` C
                                WHERE R.`start` <= '.$time.' AND R.`end` >= '.$time.'
                                AND R.`screen_id` = S.`screen_id`
                                LIMIT '.$rand.',1
        ', $FD->sql()->conn() );

        $dbscreen['id'] = mysql_result ( $index, 0, 'screen_id' );
        settype ( $dbscreen['id'], 'integer' );
        $dbscreen['caption'] = stripslashes ( mysql_result ( $index, 0, 'screen_name' ) );
        $dbscreen['cat_id'] = mysql_result ( $index, 0, 'cat_id' );
        settype ( $dbscreen['cat_id'], 'integer' );
        $dbscreen['cat_title'] = stripslashes ( mysql_result ( $index, 0, 'cat_name' ) );
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
    $index = mysql_query ( "
                            SELECT COUNT(S.`screen_id`) AS 'images'
                            FROM `".$FD->config('pref').'screen` S, `'.$FD->config('pref').'screen_cat` C
                            WHERE C.`randompic` = 1
                            AND C.`cat_id` = S.`cat_id`
    ', $FD->sql()->conn() );

    $num_images = mysql_result ( $index, 0, 'images' );
    if ( $num_images > 0 ) {
        // Get random number
        $rand = rand ( 0, $num_images - 1 );
        $index = mysql_query ( '
                                SELECT S.`screen_id`, S.`screen_name`, C.`cat_id`, C.`cat_name`
                                FROM `'.$FD->config('pref').'screen` S, `'.$FD->config('pref').'screen_cat` C
                                WHERE C.`randompic` = 1
                                AND C.`cat_id` = S.`cat_id`
                                LIMIT '.$rand.',1
        ', $FD->sql()->conn() );

        $dbscreen['id'] = mysql_result ( $index, 0, 'screen_id' );
        settype ( $dbscreen['id'], 'integer' );
        $dbscreen['caption'] = stripslashes ( mysql_result ( $index, 0, 'screen_name' ) );
        $dbscreen['cat_id'] = mysql_result ( $index, 0, 'cat_id' );
        settype ( $dbscreen['cat_id'], 'integer' );
        $dbscreen['cat_title'] = stripslashes ( mysql_result ( $index, 0, 'cat_name' ) );
        $dbscreen['type'] = 2;

        return $dbscreen;
    } else {
        return FALSE;
    }
}

/////////////////////////////////////////
//// Pagenav Array with Start Number ////
/////////////////////////////////////////
function get_pagenav_start ( $NUM_OF_ENTRIES, $ENTRIES_PER_PAGE, $START )
{
    if ( ! isset ( $START ) ) { $START = 0; }
    if ( ! is_int ( $START ) ) { $START = 0; }
    if ( $START < 0 ) { $START = 0; }
    if ( $START > $NUM_OF_ENTRIES ) { $START = $NUM_OF_ENTRIES - $ENTRIES_PER_PAGE; }

    $OLDSTART = $START - $ENTRIES_PER_PAGE;
    if ( $OLDSTART < 0 ) { $OLDSTART = 0; }
    $NEWSTART = $START + $ENTRIES_PER_PAGE;
    if ( $NEWSTART > $NUM_OF_ENTRIES ) { $NEWSTART = $NUM_OF_ENTRIES - $ENTRIES_PER_PAGE; }

    $PAGENAV_DATA['total_entries'] = $NUM_OF_ENTRIES;
    $PAGENAV_DATA['entries_per_page'] = $ENTRIES_PER_PAGE;
    $PAGENAV_DATA['old_start'] = $OLDSTART;
    $PAGENAV_DATA['cur_start'] = $START;
    $PAGENAV_DATA['new_start'] = $NEWSTART;

    if ( $START > 1 ) { $PAGENAV_DATA['old_start_exists'] = TRUE; }
    else { $PAGENAV_DATA['old_start_exists'] = FALSE; }
    if ( ( $START + $ENTRIES_PER_PAGE ) < $NUM_OF_ENTRIES ) { $PAGENAV_DATA['newpage_exists'] = TRUE; }
    else { $PAGENAV_DATA['newpage_exists'] = FALSE; }

    return $PAGENAV_DATA;
}

//////////////////////////////////////
//// Where Clause for Text-Filter ////
//////////////////////////////////////
function get_filter_where ( $FILTER, $SEARCH_FIELD )
{
    $filterarray = explode ( ',', $FILTER );
    $filterarray = array_map ( 'trim', $filterarray );
    $query = '';
    $and_query = '';
    $or_query = '';

    $first_and = true;
    $first_or = true;

    foreach ( $filterarray as $string )
    {
        if ( substr ( $string, 0, 1 ) == '!' && substr ( $string, 1 ) != '' )
        {
            $like = $SEARCH_FIELD.' NOT LIKE';
            $string = substr ( $string, 1 );
            if ( !$first_and )
            {
                $and_query .= ' AND ';
            }
            $and_query .= $like . " '%" . $string . "%'";
            $first_and = false;
        }
        elseif ( substr ( $string, 0, 1 ) != '!' && $string != '' )
        {
            $like = $SEARCH_FIELD.' LIKE';
            if ( !$first_or )
            {
                $or_query .= ' OR ';
            }
            $or_query .= $like . " '%" . $string . "%'";
            $first_or = false;
        }
    }

    if ( $or_query != '' )
    {
        $or_query = '('.$or_query.')';
        if ( $and_query != '' )
        {
            $and_query = ' AND '.$and_query;
        }
    }

    if ( $or_query != '' || $and_query != '' )
    {
        $query = 'WHERE ';
    }
    $query .= $or_query . $and_query;

    return $query;
}



/////////////////////////////////
//// Check Anti-Spam Captcha ////
/////////////////////////////////

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

    $sicherheits_eingabe = encrypt_captcha ( $SOLUTION, $FD->config('spam') );
    $sicherheits_eingabe = str_replace ('=', '', $sicherheits_eingabe );

    if ( $ACTIVATION == 0 ) {
        return TRUE;
    } elseif ( $ACTIVATION == 1 && $_SESSION['user_id'] ) {
        return TRUE;
    } elseif ( $ACTIVATION == 3 && $_SESSION['user_id'] && is_in_staff ( $_SESSION['user_id'] ) ) {
        return TRUE;
    } elseif ( $ACTIVATION == 4 && $_SESSION['user_id'] && is_admin ( $_SESSION['user_id'] ) ) {
        return TRUE;
    } elseif ( $sicherheits_eingabe == $_SESSION['captcha'] && $sicherheits_eingabe == TRUE && is_numeric( $SOLUTION ) == TRUE ) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//////////////////////////
//// User is in Staff ////
//////////////////////////

function is_in_staff ( $USER_ID )
{
    global $FD;

    settype ( $USER_ID, 'integer' );

    if ( $USER_ID ) {
        $index = mysql_query ( '
                                SELECT user_id, user_is_staff, user_is_admin
                                FROM '.$FD->config('pref')."user
                                WHERE user_id = '".$USER_ID."'
                                LIMIT 0,1
        ", $FD->sql()->conn() );
        if ( mysql_num_rows ( $index ) > 0 ) {
            if ( mysql_result ( $index, 0, 'user_is_staff' ) == 1 || mysql_result ( $index, 0, 'user_is_admin' ) == 1 || mysql_result ( $index, 0, 'user_id' ) == 1 ) {
                 return TRUE;
            }
        }
    }
    return FALSE;
}

///////////////////////
//// User is Admin ////
///////////////////////

function is_admin ( $USER_ID )
{
    global $FD;

    settype ( $USER_ID, 'integer' );

    if ( $USER_ID ) {
        $index = mysql_query ( '
                                SELECT user_id, user_is_admin
                                FROM '.$FD->config('pref')."user
                                WHERE user_id = '".$USER_ID."'
                                LIMIT 0,1
        ", $FD->sql()->conn() );
        if ( mysql_num_rows ( $index ) > 0 ) {
            if ( mysql_result ( $index, 0, 'user_is_admin' ) == 1 || mysql_result ( $index, 0, 'user_id' ) == 1 ) {
                 return TRUE;
            }
        }
    }
    return FALSE;
}

//////////////////////
//// Get Template ////
//////////////////////

function get_template ( $TEMPLATE_NAME )
{
    global $FD;

    $index = mysql_query ( '
                            SELECT `'.$TEMPLATE_NAME.'`
                            FROM '.$FD->config('pref')."template
                            WHERE `id` = '".$FD->config('design')."'
    ", $FD->sql()->conn() );
    return stripslashes ( mysql_result ( $index, 0, $TEMPLATE_NAME ) );
}

////////////////////////////
//// get email template ////
////////////////////////////

function get_email_template ( $TEMPLATE_NAME )
{
    global $FD;

    $index = mysql_query ( '
                            SELECT `'.$TEMPLATE_NAME.'`
                            FROM '.$FD->config('pref')."email
                            WHERE `id` = '1'
    ", $FD->sql()->conn() );

    return stripslashes ( mysql_result ( $index, 0, $TEMPLATE_NAME ) );
}

////////////////////
//// send email ////
////////////////////

function send_mail ( $TO, $SUBJECT, $TEXT, $HTML = FALSE, $FROM = FALSE )
{
    global $FD;

    $index = mysql_query ( '
                            SELECT `use_admin_mail`, `email`, `html`
                            FROM '.$FD->config('pref')."email
                            WHERE `id` = '1'
    ", $FD->sql()->conn() );

    if ( $FROM == FALSE ) {
        if ( mysql_result ( $index, 0, 'use_admin_mail' ) == 1 ) {
            $header  = 'From: ' . $FD->config('admin_mail') . "\n";
        } else {
            $header  = 'From: ' . stripslashes ( mysql_result ( $index, 0, 'email' ) ) . "\n";
        }
    } else {
        $header  = 'From: ' . $FROM . "\n";
    }

    $header .= 'X-Mailer: PHP/' . phpversion() . "\n";
    $header .= 'X-Sender-IP: ' . $_SERVER['REMOTE_ADDR'] . "\n";

    if ( $HTML == FALSE || $HTML == 'html' ) {
        if ( mysql_result ( $index, 0, 'html' ) == 1 ) {
            $header .= 'Content-Type: text/html';
            $TEXT = fscode ( $TEXT, true, true, false );
            $TEXT = '<html><body>' . $TEXT . '</body></html>';
        } else {
            $header .= 'Content-Type: text/plain';
        }
    } else  {
        $header .= 'Content-Type: text/plain';
    }

    return @mail ( $TO, $SUBJECT, $TEXT, $header );
}


////////////////////////////////
//// Create textarea        ////
////////////////////////////////

function create_textarea($name, $text='', $width='', $height='', $class='', $all=true, $fs_smilies=0, $fs_b=0, $fs_i=0, $fs_u=0, $fs_s=0, $fs_center=0, $fs_font=0, $fs_color=0, $fs_size=0, $fs_img=0, $fs_cimg=0, $fs_url=0, $fs_home=0, $fs_email=0, $fs_code=0, $fs_quote=0, $fs_noparse=0)
{
    global $FD;

    if ($name != '') {
        $name2 = 'name="'.$name.'" id="'.$name.'"';
    } else {
        return false;
    }

    if ($width != '') {
        $width2 = 'width:'.$width.'px;';
    }

    if ($height != '') {
        $height2 = 'height:'.$height.'px';
    }

    if ($class != '') {
        $class2 = 'class="'.$class.'"';
    }

    $style = $name2.' '.$class2.' style="'.$width2.' '.$height2.'"';

  if ($all==true OR $fs_smilies==1) {
    $smilies_table = '
          <table cellpadding="2" cellspacing="0" border="0">';

    $index = mysql_query ( 'SELECT * FROM `'.$FD->config('pref').'editor_config`', $FD->sql()->conn() );
    $config_arr = mysql_fetch_assoc ( $index );
    $config_arr['num_smilies'] = $config_arr['smilies_rows']*$config_arr['smilies_cols'];

    $zaehler = 0;
    $index = mysql_query ( '
                            SELECT *
                            FROM `'.$FD->config('pref').'smilies`
                            ORDER BY `order` ASC
                            LIMIT 0, '.$config_arr['num_smilies'].'
    ', $FD->sql()->conn() );
    while ( $smilie_arr = mysql_fetch_assoc ( $index ) )
    {
        $smilie_arr['url'] = image_url ( 'images/smilies/', $smilie_arr['id'] );
        $smilie_template = '<td><img src="'.$smilie_arr['url'].'" alt="'.$smilie_arr['replace_string'].'" onClick="insert(\''.$name.'\', \''.$smilie_arr['replace_string'].'\', \'\')" class="editor_smilies"></td>';
        $zaehler += 1;

        switch ( $zaehler )
        {
            case $config_arr['smilies_cols'] == 1:
                $zaehler = 0;
                $smilies_table .= "<tr align=\"center\">\n\r";
                $smilies_table .= $smilie_template;
                $smilies_table .= "</tr>\n\r";
                break;
            case $config_arr['smilies_cols']:
                $zaehler = 0;
                $smilies_table .= $smilie_template;
                $smilies_table .= "</tr>\n\r";
                break;
            case 1:
                $smilies_table .= "<tr align=\"center\">\n\r";
                $smilies_table .= $smilie_template;
                break;
            default:
                $smilies_table .= $smilie_template;
                break;
        }
    }
    $smilies_table .= '</table>';

    // Get Smilie Template
    $smilies = new template();
    $smilies->setFile('0_editor.tpl');
    $smilies->load('SMILIES_BODY');

    $smilies->tag('smilies_table', $smilies_table );

    $smilies = $smilies->display ();
  } else {
    $smilies = '';
  }

$buttons = '';

if ($all==true OR $fs_b==1) {
  $buttons .= create_textarea_button('bold.gif', 'B', 'fett', "insert('$name', '[b]', '[/b]')");
}
if ($all==true OR $fs_i==1) {
  $buttons .= create_textarea_button('italic.gif', 'I', 'kursiv', "insert('$name', '[i]', '[/i]')");
}
if ($all==true OR $fs_u==1) {
  $buttons .= create_textarea_button('underline.gif', 'U', 'unterstrichen', "insert('$name','[u]','[/u]')");
}
if ($all==true OR $fs_s==1) {
  $buttons .= create_textarea_button('strike.gif', 'S', 'durgestrichen', "insert('$name', '[s]', '[/s]')");
}


if ($all==true OR $fs_b==1 OR $fs_i==1 OR $fs_u==1 OR $fs_s==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_center==1) {
  $buttons .= create_textarea_button('center.gif', 'CENTER', 'zentriert', "insert('$name', '[center]', '[/center]')");
}


if ($all==true OR $fs_center==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_font==1) {
  $buttons .= create_textarea_button('font.gif', 'FONT', 'Schriftart', "insert_com('$name', 'font', 'Bitte gib die gewünschte Schriftart ein:', '')");
}
if ($all==true OR $fs_color==1) {
  $buttons .= create_textarea_button('color.gif', 'COLOR', 'Schriftfarbe', "insert_com('$name', 'color', 'Bitte gib die gewünschte Schriftfarbe (englisches Wort) ein:', '')");
}
if ($all==true OR $fs_size==1) {
  $buttons .= create_textarea_button('size.gif', 'SIZE', 'Schriftgröße', "insert_com('$name', 'size', 'Bitte gib die gewünschte Schriftgröße (Zahl von 0-7) ein:', '')");
}


if ($all==true OR $fs_font==1 OR $fs_color==1 OR $fs_size==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_img==1) {
  $buttons .= create_textarea_button('img.gif', 'IMG', 'Bild einfügen', "insert_mcom('$name', '[img]', '[/img]', 'Bitte gib die URL zu der Grafik ein:', 'http://')");
}
if ($all==true OR $fs_cimg==1) {
  $buttons .= create_textarea_button('cimg.gif', 'CIMG', 'Content-Image einfügen', "insert_mcom('$name', '[cimg]', '[/cimg]', 'Bitte gib den Namen des Content-Images (mit Endung) ein:', '')");
}


if ($all==true OR $fs_img==1 OR $fs_cimg==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_url==1) {
  $buttons .= create_textarea_button('url.gif', 'URL', 'Link einfügen', "insert_com('$name', 'url', 'Bitte gib die URL ein:', 'http://')");
}
if ($all==true OR $fs_home==1) {
  $buttons .= create_textarea_button('home.gif', 'HOME', 'Projektinternen Link einfügen', "insert_com('$name', 'home', 'Bitte gib den projektinternen Verweisnamen ein:', '')");
}
if ($all==true OR $fs_email==1) {
  $buttons .= create_textarea_button('email.gif', '@', 'Email-Link einfügen', "insert_com('$name', 'email', 'Bitte gib die Email-Adresse ein:', '')");
}


if ($all==true OR $fs_url==1 OR $fs_home==1 OR $fs_email==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_code==1) {
  $buttons .= create_textarea_button('code.gif', 'C', 'Code-Bereich einfügen', "insert('$name', '[code]', '[/code]')");
}
if ($all==true OR $fs_quote==1) {
  $buttons .= create_textarea_button('quote.gif', 'Q', 'Zitat einfügen', "insert('$name', '[quote]', '[/quote]')");
}
if ($all==true OR $fs_noparse==1) {
  $buttons .= create_textarea_button('nofscode.gif', 'N', 'Nicht umzuwandelnden Bereich einfügen', "insert('$name', '[nofscode]', '[/nofscode]')");
}

    // Get Template
    $textarea = new template();
    $textarea->setFile('0_editor.tpl');
    $textarea->load('BODY');

    $textarea->tag('style', $style );
    $textarea->tag('text', $text );
    $textarea->tag('buttons', $buttons );
    $textarea->tag('smilies', $smilies );

    $textarea = $textarea->display ();

    return $textarea;
}


////////////////////////////////
//// Create textarea Button ////
////////////////////////////////

function create_textarea_button($img_file_name, $alt, $title, $insert)
{
    $javascript = 'onClick="'.$insert.'"';

    // Get Button
    $button = new template();
    $button->setFile('0_editor.tpl');
    $button->load('BUTTON');

    $button->tag('img_file_name', $img_file_name );
    $button->tag('alt', $alt );
    $button->tag('title', $title );
    $button->tag('javascript', $javascript );

    $button = $button->display ();

    return $button;
}


////////////////////////////////////
//// Create textarea  Seperator ////
////////////////////////////////////

function create_textarea_seperator()
{
    // Get Seperator
    $seperator = new template();
    $seperator->setFile('0_editor.tpl');
    $seperator->load('SEPERATOR');
    $seperator = $seperator->display ();

    return $seperator;
}


/////////////////////////
//// System Message ////
/////////////////////////

function sys_message ($TITLE, $MESSAGE, $STATUS = '')
{
    //check for addition HTTP Status
	if (!empty($STATUS) && false !== ($text = http_response_text($STATUS)))
		header($text, true, $STATUS);


    $template = new template();

    $template->setFile ( '0_general.tpl' );
    $template->load ( 'SYSTEMMESSAGE' );

    $template->tag ( 'message_title', $TITLE );
    $template->tag ( 'message', $MESSAGE );

    return (string) $template;
}

/////////////////////////
//// Forward Message ////
/////////////////////////

function forward_message ( $TITLE, $MESSAGE, $URL, $STATUS = '')
{
    global $FD;

    //check for addition HTTP Status
	if (!empty($STATUS) && false !== ($text = http_response_text($STATUS)))
		header($text, true, $STATUS);

    $forward_script = '
<noscript>
    <meta http-equiv="Refresh" content="'.$FD->cfg('auto_forward').'; URL='.$URL.'">
</noscript>
<script type="text/javascript">
    function auto_forward() {
        window.location = "'.$URL.'";
    }
    window.setTimeout("auto_forward()", '.($FD->cfg('auto_forward')*1000).');
</script>
    ';

    $template = new template();

    $template->setFile ( '0_general.tpl' );
    $template->load ( 'FORWARDMESSAGE' );

    $template->tag ( 'message_title', $TITLE );
    $template->tag ( 'message', $MESSAGE );
    $template->tag ( 'forward_url', $URL );
    $template->tag ( 'forward_time', $FD->cfg('auto_forward') );

    $template = $template->display ();
    return $forward_script.$template;
}


////////////////////////////////
/////// Number Format   ////////
////////////////////////////////

function point_number ($zahl)
{
    $zahl = number_format($zahl, 0, ',', '.');
    return $zahl;
}

/////////////////////////////////////////
// String kürzen ohne Wort zuzerstören //  <= BAD FUNCTION HAS TO BE IMPROVED TODO
/////////////////////////////////////////
function truncate_string ($string, $maxlength, $extension)
{

   $cutmarker = "**F3rVRB,YQFrK6qpE**cut_here**cc3Z,7L,jVy9bDWY**";

   if (strlen($string) > $maxlength) {
       $string = wordwrap($string, $maxlength-strlen($extension), $cutmarker);
       $string = explode($cutmarker, $string);
       $string = $string[0] . $extension;
   }
   return $string;
}



////////////////////////////////
///// Download Categories //////
////////////////////////////////

function get_dl_categories (&$IDs, $CAT_ID, $SHOW_SUB = 1, $ID = 0, $LEVEL = -1 )
{
    global $FD;

    $index = mysql_query ( '
                            SELECT * FROM `'.$FD->config('pref')."dl_cat`
                            WHERE `subcat_id` = '".$ID."'
                            ORDER BY `cat_name`
    ", $FD->sql()->conn() );

    while ( $line = mysql_fetch_assoc ( $index ) ) {
        $line['level'] = $LEVEL + 1;
        $IDs[] = $line;
        if ( $SHOW_SUB == 1 || $line['cat_id'] == $CAT_ID || in_array ( $CAT_ID, get_sub_cats ( $line['cat_id'], array () ) ) ) {
            get_dl_categories ( $IDs, $CAT_ID, $SHOW_SUB, $line['cat_id'], $line['level'] );
        }
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
    $index2 = mysql_query('SELECT cat_name FROM '.$FD->config('pref')."news_cat WHERE cat_id = '".$news_arr['cat_id']."'", $FD->sql()->conn() );
    $news_arr['cat_name'] = mysql_result($index2, 0, 'cat_name');
    $news_arr['cat_pic'] = image_url('images/cat/', 'news_'.$news_arr['cat_id']);

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
    $index2 = mysql_query('SELECT user_name FROM '.$FD->config('pref').'user WHERE user_id = '.$news_arr['user_id'].'', $FD->sql()->conn() );
    $news_arr['user_name'] = kill_replacements ( mysql_result($index2, 0, 'user_name'), TRUE );
    $news_arr['user_url'] = url('user', array('id' => $news_arr['user_id']));

    // Kommentare lesen
    $index2 = mysql_query('SELECT comment_id FROM '.$FD->config('pref').'comments WHERE content_id = '.$news_arr['news_id'].' AND content_type=\'news\'', $FD->sql()->conn() );
    $news_arr['kommentare'] = mysql_num_rows($index2);

    // Get Related Links
    $link_tpl = '';
    $index2 = mysql_query('SELECT * FROM '.$FD->config('pref').'news_links WHERE news_id = '.$news_arr['news_id'].' ORDER BY link_id', $FD->sql()->conn() );
    while ($link_arr = mysql_fetch_assoc($index2))
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
    if (mysql_num_rows($index2) > 0) {
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

//////////////////////
// convert filesize //
//////////////////////

function getsize ( $SIZE )
{
    $mb = 1024;
    $gb = 1024 * $mb;
    $tb = 1024 * $gb;

    switch (TRUE)
    {
        case ($SIZE < $mb):
            $SIZE = round ( $SIZE, 1 ) . ' KB';
            break;
        case ($SIZE < $gb):
            $SIZE = round ( $SIZE/$mb, 1 ). ' MB';
            break;
        case ($SIZE < $tb):
            $SIZE = round ( $SIZE/$gb, 1 ). ' GB';
            break;
        case ($SIZE > $tb):
            $SIZE = round ( $SIZE/$tb, 1 ). ' TB';
            break;
    }
    return $SIZE;
}

/////////////////////////
// mark word in a text //  <=== DEPRECATED use highlight
/////////////////////////

function markword($text, $word)
{
    return highlight($word, $text, '', 'color:#FF0000; font-weight:bold;');
}

//////////////////////////////////////////////////////////////
// Inserts HTML line breaks before all newlines in a string //
//////////////////////////////////////////////////////////////

function html_nl2br($TEXT, $is_xhtml = false)
{
    $TEXT = nl2br(convertlinebreaks($TEXT), $is_xhtml);
    return $TEXT;
}
function convertlinebreaks ($text) {
    return preg_replace ("/\015\012|\015|\012/", "\n", $text);
}

//////////////////////////////
// Convert tab \t to &nbsp; //
//////////////////////////////

function tab2space($TEXT, $tabsize = 4, $space = '&nbsp;')
{
    $TEXT = preg_replace("/\t/", str_repeat($space, $tabsize), $TEXT);
    return $TEXT;
}


/////////////////////////////////
// create save strings for sql //
/////////////////////////////////

function savesql ( $TEXT )
{
    global $FD;

    $TEXT = unquote($TEXT);
    if (SLASH)
         $TEXT = addslashes($TEXT);

    if ( !is_numeric ( $TEXT ) ) {
        $TEXT = mysql_real_escape_string($TEXT, $FD->sql()->conn() );
    }
    return $TEXT;
}

/////////////////////////////////
// create save strings for sql //
/////////////////////////////////

function unslash($TEXT)
{
    global $FD;
    if ($FD->env('slash'))
         $TEXT = stripslashes($TEXT);

    return $TEXT;
}


/////////////////////////////////
// create save strings for sql //
/////////////////////////////////

function unquote ($TEXT)
{
    if (get_magic_quotes_gpc()) {
        $TEXT = stripslashes($TEXT);
    }
    return $TEXT;
}

//////////////////////////////
// Format text with FS Code //
//////////////////////////////

function fscode($text, $all=true, $html=false, $para=false, $do_b=0, $do_i=0, $do_u=0, $do_s=0, $do_center=0, $do_url=0, $do_homelink = 0, $do_email=0, $do_img=0, $do_cimg=0, $do_list=0, $do_numlist=0, $do_font=0, $do_color=0, $do_size=0, $do_code=0, $do_quote=0, $do_noparse=0, $do_smilies=0, $do_player=0, $do_fscode=0, $do_html=0, $do_nohtml=0)
{
    $flags = array('html' => $html, 'paragraph' => $para,
    );

    if ($all)
        $fscodes = get_all_fscodes();
    else {
        $fscodes = array();

        if ($do_b==1)           array_push($fscodes, 'b');
        if ($do_i==1)           array_push($fscodes, 'i');
        if ($do_u==1)           array_push($fscodes, 'u');
        if ($do_s==1)           array_push($fscodes, 's');
        if ($do_center==1)      array_push($fscodes, 'center');
        if ($do_url==1)         array_push($fscodes, 'url');
        if ($do_homelink==1)    array_push($fscodes, 'home');
        if ($do_email==1)       array_push($fscodes, 'email');
        if ($do_img==1)         array_push($fscodes, 'img');
        if ($do_cimg==1)        array_push($fscodes, 'cimg');
        if ($do_list==1)        array_push($fscodes, 'list');
        if ($do_numlist==1)     array_push($fscodes, 'numlist');
        if ($do_font==1)        array_push($fscodes, 'font');
        if ($do_color==1)       array_push($fscodes, 'color');
        if ($do_size==1)        array_push($fscodes, 'size');
        if ($do_code==1)        array_push($fscodes, 'code');
        if ($do_quote==1)       array_push($fscodes, 'quote');
        if ($do_nofscode==1)    array_push($fscodes, 'nofscode');
        if ($do_player==1)      array_push($fscodes, 'player');
        if ($do_smilies==1)     array_push($fscodes, 'smilies');
        if ($do_fscode==1)      array_push($fscodes, 'fscode');
        if ($do_html==1)        array_push($fscodes, 'html');
        if ($do_nohtml==1)      array_push($fscodes, 'nohtml');
    }

    return parse_fscode(unslash($text), $flags, $fscodes);

}

//////////////////////////
// kill FS Code in text //
//////////////////////////

function killfs($text)
{
    include_once ( FS2_ROOT_PATH . 'includes/fscode.php');
    return strip_fs($text);
}

///////////////////////////////////////////////////////////////
// Check if the visitor has already voted in the given poll  //
///////////////////////////////////////////////////////////////
function checkVotedPoll($pollid) {

    global $FD;

        settype($pollid, 'integer');

        if (isset($_COOKIE['polls_voted'])) {
            $polls_voted = savesql($_COOKIE['polls_voted']);
            $votes = explode(',', $polls_voted);
            if (in_array($pollid, $votes )) {
                return true;
            }
        }
        $one_day_ago = time()-60*60*24;
        mysql_query('DELETE FROM '.$FD->config('pref')."poll_voters WHERE time <= '".$one_day_ago."'", $FD->sql()->conn() ); //Delete old IPs
        $query_id = mysql_query('SELECT voter_id FROM '.$FD->config('pref')."poll_voters WHERE poll_id = $pollid AND ip_address = '".$_SERVER['REMOTE_ADDR']."' AND time > '".$one_day_ago."'", $FD->sql()->conn() ); //Save IP for 1 Day
        if (mysql_num_rows($query_id) > 0) {
                return true;
        }

        return false;
}

///////////////////////////////////////////////////////////////
//// Register the voter in the db to avoid multiple votes  ////
///////////////////////////////////////////////////////////////
function registerVoter($pollid, $voter_ip) {

        global $FD;

        settype($pollid, 'integer');

        mysql_query('INSERT INTO '.$FD->config('pref')."poll_voters VALUES ('', '$pollid', '$voter_ip', '".time()."')");
        if (!isset($_COOKIE['polls_voted'])) {
                setcookie('polls_voted', $pollid, time()+60*60*24*60); //2 months
        } else {
                setcookie('polls_voted', $_COOKIE['polls_voted'].','.$pollid, time()+60*60*24*60);
        }
}
?>
