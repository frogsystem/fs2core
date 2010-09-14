<?php
////////////////////////////
//// Get any Cat-System ////
////////////////////////////
function get_cat_system(&$IDs, $SQL, $CAT_ID = -1, $SHOW_SUB = 1, $ID = 0, $LEVEL = -1)
{
    global $sql;

    // Load SQL Data
    $lines = $sql->getData($SQL['table'], $SQL['select'], "WHERE `".$SQL['sub']."` = '".$ID."' ".$SQL['ext']." ".$SQL['order']);
    $lines = $sql->lastUseful() ? $lines : array();

    foreach ($lines as $line) {
        $line['level'] = $LEVEL + 1;
        $IDs[] = $line;
        if ( $SHOW_SUB == 1 || $line['cat_id'] == $CAT_ID || in_array( $CAT_ID, get_all_sub_cats($line['cat_id'], $SQL, array()) ) ) {
            get_cat_system($IDs, $SQL, $CAT_ID, $SHOW_SUB, $line['cat_id'], $line['level']);
        }
    }
}

///////////////////////////////////////////////
//// Get IDs of Sub-Cats of any Cat-System ////
///////////////////////////////////////////////
function get_all_sub_cats($CAT_ID, $SQL, &$REC_SUB_CAT_ARRAY)
{
    global $sql;

    $subcats = $sql->getData($SQL['table'], $SQL['id'], "WHERE `".$SQL['sub']."` = '".$CAT_ID."'");
    $subcats = $sql->lastUseful() ? $subcats : array();

    foreach ($subcats as $subcat) {
        $REC_SUB_CAT_ARRAY[] = $subcat['cat_id'];
        get_all_sub_cats($subcat['cat_id'], $SQL, $REC_SUB_CAT_ARRAY);
    }
    return $REC_SUB_CAT_ARRAY;
}


////////////////////////////////
//// highlight part of text ////
////////////////////////////////
function highlight_part ( $TEXT, $PART, $KILLHTML = FALSE, $STRIPSLASHES = FALSE )
{
    if ( $KILLHTML === TRUE ) {
        $TEXT = killhtml ( $TEXT );
        $PART = killhtml ( $PART );
    } elseif ( $STRIPSLASHES === TRUE ) {
        $TEXT = stripslashes ( $TEXT );
        $PART = stripslashes ( $PART );
    }
    return str_ireplace_use ( $PART, '<span class="highlight">$1</span>', $TEXT );
}

//////////////////////////////////////////////////////////////////////////
//// Repleace String Case-insensetive with option to use found phrase ////
//// Use $1 for the search string like found in the subject           ////
//////////////////////////////////////////////////////////////////////////
function str_ireplace_use ( $SEARCH, $REPLACE, $SUBJECT )
{
    $startpos = stripos ( $SUBJECT, $SEARCH );
    if ( $startpos !== FALSE ) {
        $search_length = strlen ( $SEARCH ); // length of search string
        $start = substr ( $SUBJECT, 0, $startpos ); // get part before $SEARCH
        $rest = substr ( $SUBJECT, $startpos+$search_length ); // get part after $SEARCH
        $r1 = substr ( $SUBJECT, $startpos, $search_length ); // get $SEARCH for use as $1
        // concat String and go recursive over the rest
        return $start.str_replace ( '$1', $r1, $REPLACE ).str_ireplace_use ( $SEARCH, $REPLACE, $rest );
    }
    // Nothing found
    return $SUBJECT;
}


////////////////////////////
//// Validate Form Data ////
////////////////////////////
function validateFormData ( $DATA, $TYPE, $CHECK = FALSE ) {
    // Global Validation State
    $validation_state = TRUE;

    // more than one type is possible
    $TYPE  = ( is_array ( $TYPE ) ) ? $TYPE : explode ( ",", $TYPE );

    // $DATA is Array
    if ( is_array($DATA) && ( !$CHECK || ( is_array($CHECK) && count($DATA) == count($CHECK) ) ) ) {
        foreach ( $DATA as $key => $value ) {
            $validation_state = $validation_state && validateFormData ( $value, $TYPE, $REQUIRED, $CHECK[$key] );
        }
        return $validation_state;
    // $DATA is $value
    } else {

        // trim spaces
        $DATA = trim($DATA);

        // mandatory field
        if ( in_array("required", $TYPE) ) {
            $validation_state = $validation_state && isset($DATA) && $DATA != "";
        }
        
        // E-Mail, kein zusäzlicher Check erlaubt
        if ( in_array("email", $TYPE) ) {
            // Quelle: http://fightingforalostcause.net/misc/2006/compare-email-regex.php
            $regexp = '/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i';
            $validation_state = $validation_state && preg_match ( $regexp, $DATA );
        }
        
        // Integer Value
        if ( in_array("integer", $TYPE) ) {
            $regexp = "/^[-]?[\d]+$/";
            $validation_state = $validation_state && preg_match ( $regexp, $DATA );
        }
        // Float Value
        if ( in_array("float", $TYPE) ) {
            $regexp = "/^[-]?[\d]+[\.]?[\d]*$/";
            $validation_state = $validation_state && preg_match ( $regexp, $DATA );
        }
        // Number between 2 Values
        if ( in_array("between", $TYPE) && ( ( is_array($CHECK) && count($CHECK) >= 1 ) || is_numeric($CHECK) ) ) {
            $DATA = floatval ( $DATA );
            $CHECK = is_numeric($CHECK) ? array($CHECK) : $CHECK;
            $CHECK = count($CHECK) == 2 ? $CHECK : array(0, $CHECK[0]);
            return ( $DATA >= $CHECK[0] && $DATA <= $CHECK[1] );
        }
        // Value is not 0
        if ( in_array("notzero", $TYPE) ) {
            $validation_state = $validation_state && floatval ( $DATA ) != 0;
        }
        // Positive Value (incl. 0)
        if ( in_array("positive", $TYPE) ) {
            $validation_state = $validation_state && floatval ( $DATA ) >= 0;
        }
        // Negative Value
        if ( in_array("negative", $TYPE) ) {
            $validation_state = $validation_state && floatval ( $DATA ) < 0;
        }
        
        // Check Free-Text against RegExpression Pattern
        if ( in_array("text", $TYPE) ) {
            $validation_state = $validation_state && preg_match ( $CHECK, $DATA );
        }
        
        // Check Free-Text against RegExpression Pattern
        if ( in_array("oneof", $TYPE) ) {
            $validation_state = $validation_state && in_array($DATA, $CHECK);
        }

        // weitere Daten-Arten (z.B. URL, ...) sollten implementiert werden
        
        // sonst
        return $validation_state;
    }
}


////////////////////////////////////////////////////////
//// remove all kinds of replacements from a string ////
////////////////////////////////////////////////////////
function kill_replacements ( $TEXT, $KILLHTML = FALSE, $STRIPSLASHES = FALSE )
{
    $TEXT = str_replace ( '{..', '&#x7B;&#x2E;&#x2E;', $TEXT );
    $TEXT = str_replace ( '..}', '&#x2E;&#x2E;&#x7D;', $TEXT );
    $TEXT = str_replace ( '[%', '&#x5B;&#x25;', $TEXT );
    $TEXT = str_replace ( '%]', '&#x25;&#x5D;', $TEXT );
    $TEXT = str_replace ( '$NAV(', '&#x24;NAV&#x28;', $TEXT );
    $TEXT = str_replace ( '$APP(', '&#x24;APP&#x28;', $TEXT );
    $TEXT = str_replace ( '$VAR(', '&#x24;VAR&#x28;', $TEXT );

    if ( $KILLHTML === TRUE ) {
        return killhtml ( $TEXT );
    } elseif ( $STRIPSLASHES === TRUE ) {
        return stripslashes ( $TEXT );
    }
    return $TEXT;
}


//////////////////////////
//// get old page nav ////
//////////////////////////
function get_page_nav ( $PAGE, $NUM_OF_PAGES, $PER_PAGE, $NUM_OF_ENTRIES, $URL_TEMPLATE )
{
    global $global_config_arr;

    // Security Functions
    settype ( $PAGE, "integer" );
    settype ( $NUM_OF_PAGES, "integer" );
    settype ( $PER_PAGE, "integer" );
    settype ( $NUM_OF_ENTRIES, "integer" );

    // Prev Template
    $template_prev = "";
    $prev_url = str_replace ( "{..page_num..}", $PAGE-1, $URL_TEMPLATE );
    if ( $PAGE > 1 ) {
        $template_prev = str_replace ( "{..url..}", $prev_url, $global_config_arr['page_prev'] );
    }

    // Next Template
    $template_next = "";
    $next_url = str_replace ( "{..page_num..}", $PAGE+1, $URL_TEMPLATE );
    if ( ( $PAGE*$PER_PAGE ) < $NUM_OF_ENTRIES ) {
        $template_next = str_replace ( "{..url..}", $next_url, $global_config_arr['page_next'] );
    }

    // Main Template
    $template = str_replace ( "{..page_number..}", $PAGE, $global_config_arr['page'] );
    $template = str_replace ( "{..total_pages..}", $NUM_OF_PAGES, $template );
    $template = str_replace ( "{..prev..}", $template_prev, $template );
    $template = str_replace ( "{..next..}", $template_next, $template );
    
    return $template;
}


/////////////////////////////////
//// validation of lang dirs ////
/////////////////////////////////
function is_language_text ( $TEXT )
{
    if ( preg_match ( "/[a-z]{2}_[A-Z]{2}/", $TEXT ) === 1 ) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//////////////////////////////////
//// validation of a hexcolor ////
//////////////////////////////////
function hex2dec_color( $COLOR )
{
    if ( is_hexcolor( $COLOR ) ) {
        $return['r'] = hexdec ( substr ( $COLOR, 0, 2 ) );
        $return['g'] = hexdec ( substr ( $COLOR, 2, 2 ) );
        $return['b'] = hexdec ( substr ( $COLOR, 4, 2 ) );
        return $return;
    } else {
        return FALSE;
    }
}


//////////////////////////////////
//// validation of a hexcolor ////
//////////////////////////////////
function is_hexcolor( $COLOR )
{
    $COLOR = substr ( $COLOR, 0, 6 );
    return preg_match ( '/[0-9a-fA-F]{6}$/', $COLOR );
}


/////////////////////////////
//// scandir with filter ////
/////////////////////////////

function scandir_filter ( $FOLDER, $EXTRA = array(), $BAD = array ( ".", "..", ".DS_Store", "_notes", "Thumbs.db", ".svn" ) )
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

function scandir_ext ( $FOLDER, $FILE_EXT, $EXTRA = array(), $BAD = array ( ".", "..", ".DS_Store", "_notes", "Thumbs.db", ".svn" ) )
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
    global $db, $global_config_arr, $TEXT;

    if ( $GROUP_ID == 0 && $IS_ADMIN != 1 ) {
        $retrun_arr['user_group_id'] = 0;
        $retrun_arr['user_group_name'] = "";
        $retrun_arr['user_group_title'] = "";
        $retrun_arr['user_group_rank'] = "";
    } else {
        $index = mysql_query ( "
            SELECT *
            FROM `".$global_config_arr['pref']."user_groups`
            WHERE `user_group_id` = '".$GROUP_ID."'
        ", $db );
        $group_arr = mysql_fetch_assoc ( $index );

        settype ( $group_arr['user_group_id'], integer );
        $group_arr['user_group_name'] = stripslashes ( $group_arr['user_group_name'] );
        $group_arr['user_group_title'] = stripslashes ( $group_arr['user_group_title'] );
        $group_arr['user_group_image'] = ( image_exists ( "media/group-images/staff_", $group_arr['user_group_id'] ) ? '<img src="'.image_url ( "media/group-images/staff_", $group_arr['user_group_id'] ).'" alt="'.$TEXT->get("group_image_of")." ".$group_arr['user_group_name'].'">' : "" );

        unset ( $title_style );
        $title_style .= ( $group_arr['user_group_color'] != -1 ? 'color:#'.stripslashes ( $group_arr['user_group_color'] ).';' : "" );
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
        $title_style .= ( $highlight_css != "" ? $highlight_css : "" );
        $group_arr['user_group_title_colored'] = '<span style="'.$title_style.'">'.$group_arr['user_group_title'].'</span>';

        $rank_template = new template();
        $rank_template->setFile ( "0_user.tpl" );
        $rank_template->load ( "USERRANK" );
        $rank_template->tag ( "group_name", $group_arr['user_group_name'] );
        $rank_template->tag ( "group_image", $group_arr['user_group_image'] );
        $rank_template->tag ( "group_image_url", image_url ( "media/group-images/staff_", $group_arr['user_group_id'] ) );
        $rank_template->tag ( "group_title", $group_arr['user_group_title_colored'] );
        $rank_template->tag ( "group_title_text_only", $group_arr['user_group_title'] );
        $rank_template = $rank_template->display ();

        $retrun_arr['user_group_id'] = $group_arr['user_group_id'];
        $retrun_arr['user_group_name'] = $group_arr['user_group_name'];
        $retrun_arr['user_group_title'] = $group_arr['user_group_title'];
        $retrun_arr['user_group_rank'] = $rank_template;
    }
    return $retrun_arr;
}

///////////////////////
//// Localize Date ////
///////////////////////
function date_loc ( $DATE_STRING, $TIMESTAMP )
{
    global $db, $global_config_arr, $phrases;

    $week_en = array ( "Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday" );
    $month_en = array ( "January","February","March","April","May","June","July","August","September","October","November","December" );
    
    $localized_date = str_replace ( $week_en, explode ( ",", $phrases['week_days'] ), date ( $DATE_STRING, $TIMESTAMP ) );
    $localized_date = str_replace ( $month_en, explode ( ",", $phrases['month_names'] ), $localized_date );

    return $localized_date;
}

//////////////////////////////
//// Get IDs of DL-Subcat ////
//////////////////////////////
function get_sub_cats ( $CAT_ID, $REC_SUB_CAT_ARRAY )
{
    global $sql;
    static $sub_cat_ids = array();
    $sub_cat_ids = $REC_SUB_CAT_ARRAY;

    $subcats = $sql->getData("dl_cat", "cat_id", "WHERE `subcat_id` = '".$CAT_ID."'");
    $subcats = $sql->lastUseful() ? $subcats : array();

    foreach ($subcats as $subcat) {
        $sub_cat_ids[] = $subcat['cat_id'];
        get_sub_cats ( $subcat['cat_id'], $sub_cat_ids );
    }
    return $sub_cat_ids;
}

/////////////////////////////////
//// Create DL-Folder-System ////
/////////////////////////////////
function create_dl_cat ($CAT_ID, $GET_ID, $NAVI_TEMPLATE) {
    global $db, $global_config_arr;
    static $navi;
    static $i = 0;
    
    $i++;
    $data[$CAT_ID] = mysql_query ( "
        SELECT *
        FROM `".$global_config_arr['pref']."dl_cat`
        WHERE `subcat_id` = '".$CAT_ID."'
    ", $db );

    while ( $array = mysql_fetch_assoc ( $data[$CAT_ID] ) ) {
        $index = mysql_query ( "
            SELECT `cat_id`
            FROM `".$global_config_arr['pref']."dl_cat`
            WHERE `subcat_id` = '".$array['cat_id']."'
        ", $db );
        $num_subcat = mysql_num_rows ( $index );

        unset ( $ids );
        $ids = get_sub_cats ( $array['cat_id'], array() );

        $template = $NAVI_TEMPLATE;
        $cat_url = '?go=download&catid='.$array['cat_id'];
        $top_url = '?go=download&catid='.$array['subcat_id'];
        $folder = ( $array['cat_id'] == $GET_ID ? "folder_open.gif" : "folder.gif" );
        $open = ( ( $array['cat_id'] == $GET_ID || in_array ( $GET_ID, $ids ) ) ? "minus.gif" : "plus.gif" );
        $open_url = ( ( $array['cat_id'] == $GET_ID || in_array ( $GET_ID, $ids ) ) ? $top_url : $cat_url );
        $nbsp = str_repeat( '&nbsp;', $i-1);

        $template = str_repeat( '<img class="textmiddle" src="images/design/null.gif" alt="" border="0" align="absmiddle" width="16" height="0">', $i-1) . $template;

        if ( $num_subcat <= 0 ) {
            $template = str_replace( "{open_link}", $nbsp.'<img class="textmiddle" src="images/design/null.gif" alt="" width="16" height="0">', $template );
        }
        $template = str_replace( "{open_link}", $nbsp.'<a class="textmiddle" href="'.$open_url.'"><img class="textmiddle" style="margin-left:4px; margin-right:3px;" src="images/icons/dl/'.$open.'" alt="" border="0" align="absmiddle"></a>', $template );
        $template = str_replace( "{folder_link}", '&nbsp;<a class="textmiddle" href="'.$cat_url.'"><img class="textmiddle" src="images/icons/dl/'.$folder.'" alt="" border="0" align="absmiddle"></a>', $template );

        $template = str_replace( "{cat_url}", $cat_url, $template);
        $template = str_replace( "{cat_name}", $array['cat_name'], $template );
        $template = str_replace( "{class}", ( $array['cat_id'] == $GET_ID ? " active" : "" ), $template);

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
    global $global_config_arr;
    global $db;

    $time = time();
    $index = mysql_query ( "
                            SELECT COUNT(R.`screen_id`) AS 'images'
                            FROM `".$global_config_arr['pref']."screen_random` R
                            WHERE R.`start` <= ".$time." AND R.`end` >= ".$time."
    ", $db);

    $num_images = mysql_result ( $index, 0, "images" );
    if ( $num_images > 0 ) {
        // Get random number
        $rand = rand ( 0, $num_images - 1 );
        $index = mysql_query ( "
                                SELECT S.`screen_id`, S.`screen_name`, C.`cat_id`, C.`cat_name`
                                FROM `".$global_config_arr['pref']."screen_random` R, `".$global_config_arr['pref']."screen` S, `".$global_config_arr['pref']."screen_cat` C
                                WHERE R.`start` <= ".$time." AND R.`end` >= ".$time."
                                AND R.`screen_id` = S.`screen_id`
                                LIMIT ".$rand.",1
        ", $db);

        $dbscreen['id'] = mysql_result ( $index, 0, "screen_id" );
        settype ( $dbscreen['id'], "integer" );
        $dbscreen['caption'] = stripslashes ( mysql_result ( $index, 0, "screen_name" ) );
        $dbscreen['cat_id'] = mysql_result ( $index, 0, "cat_id" );
        settype ( $dbscreen['cat_id'], "integer" );
        $dbscreen['cat_title'] = stripslashes ( mysql_result ( $index, 0, "cat_name" ) );
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
    global $global_config_arr, $db;

    // Get number of possible Screens
    $index = mysql_query ( "
                            SELECT COUNT(S.`screen_id`) AS 'images'
                            FROM `".$global_config_arr['pref']."screen` S, `".$global_config_arr['pref']."screen_cat` C
                            WHERE C.`randompic` = 1
                            AND C.`cat_id` = S.`cat_id`
    ", $db);

    $num_images = mysql_result ( $index, 0, "images" );
    if ( $num_images > 0 ) {
        // Get random number
        $rand = rand ( 0, $num_images - 1 );
        $index = mysql_query ( "
                                SELECT S.`screen_id`, S.`screen_name`, C.`cat_id`, C.`cat_name`
                                FROM `".$global_config_arr['pref']."screen` S, `".$global_config_arr['pref']."screen_cat` C
                                WHERE C.`randompic` = 1
                                AND C.`cat_id` = S.`cat_id`
                                LIMIT ".$rand.",1
        ", $db);
        
        $dbscreen['id'] = mysql_result ( $index, 0, "screen_id" );
        settype ( $dbscreen['id'], "integer" );
        $dbscreen['caption'] = stripslashes ( mysql_result ( $index, 0, "screen_name" ) );
        $dbscreen['cat_id'] = mysql_result ( $index, 0, "cat_id" );
        settype ( $dbscreen['cat_id'], "integer" );
        $dbscreen['cat_title'] = stripslashes ( mysql_result ( $index, 0, "cat_name" ) );
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
    $filterarray = explode ( ",", $FILTER );
    $filterarray = array_map ( "trim", $filterarray );
    unset ( $query );
    unset ( $and_query );
    unset ( $or_query );

    $first_and = true;
    $first_or = true;

    foreach ( $filterarray as $string )
    {
        if ( substr ( $string, 0, 1 ) == "!" && substr ( $string, 1 ) != "" )
        {
            $like = $SEARCH_FIELD." NOT LIKE";
            $string = substr ( $string, 1 );
            if ( !$first_and )
            {
                $and_query .= " AND ";
            }
            $and_query .= $like . " '%" . $string . "%'";
            $first_and = false;
        }
        elseif ( substr ( $string, 0, 1 ) != "!" && $string != "" )
        {
            $like = $SEARCH_FIELD." LIKE";
            if ( !$first_or )
            {
                $or_query .= " OR ";
            }
            $or_query .= $like . " '%" . $string . "%'";
            $first_or = false;
        }
        $i++;
    }

    if ( $or_query != "" )
    {
        $or_query = "(".$or_query.")";
        if ( $and_query != "" )
        {
            $and_query = " AND ".$and_query;
        }
    }

    if ( $or_query != "" || $and_query != "" )
    {
        $query = "WHERE ";
    }
    $query .= $or_query . $and_query;
    
    return $query;
}

///////////////////////////
//// Passwort erzeugen ////
///////////////////////////

function generate_pwd ( $LENGHT = 10 )
{
    $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $real_strlen = strlen ( $charset ) - 1;
    mt_srand ( (double)microtime () * 1001000 );

    while ( strlen ( $code ) < $LENGHT ) {
        $code .= $charset[mt_rand ( 0,$real_strlen ) ];
    }
    return $code;
}

/////////////////////////////////
//// Check Anti-Spam Captcha ////
/////////////////////////////////

function check_captcha ( $SOLUTION, $ACTIVATION )
{
    global $global_config_arr;
    global $db;

    session_start();

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

    $sicherheits_eingabe = encrypt_captcha ( $SOLUTION, $global_config_arr['spam'] );
    $sicherheits_eingabe = str_replace ("=", "", $sicherheits_eingabe );

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
    global $global_config_arr;
    global $db;
    
    settype ( $USER_ID, "integer" );
    
    if ( $USER_ID ) {
        $index = mysql_query ( "
                                SELECT user_id, user_is_staff, user_is_admin
                                FROM ".$global_config_arr['pref']."user
                                WHERE user_id = '".$USER_ID."'
                                LIMIT 0,1
        ", $db );
        if ( mysql_num_rows ( $index ) > 0 ) {
            if ( mysql_result ( $index, 0, "user_is_staff" ) == 1 || mysql_result ( $index, 0, "user_is_admin" ) == 1 || mysql_result ( $index, 0, "user_id" ) == 1 ) {
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
    global $global_config_arr;
    global $db;

    settype ( $USER_ID, "integer" );

    if ( $USER_ID ) {
        $index = mysql_query ( "
                                SELECT user_id, user_is_admin
                                FROM ".$global_config_arr['pref']."user
                                WHERE user_id = '".$USER_ID."'
                                LIMIT 0,1
        ", $db );
        if ( mysql_num_rows ( $index ) > 0 ) {
            if ( mysql_result ( $index, 0, "user_is_admin" ) == 1 || mysql_result ( $index, 0, "user_id" ) == 1 ) {
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
    global $global_config_arr;
    global $db;
    
    $index = mysql_query ( "
                            SELECT `".$TEMPLATE_NAME."`
                            FROM ".$global_config_arr['pref']."template
                            WHERE `id` = '".$global_config_arr['design']."'
    ", $db );
    return stripslashes ( mysql_result ( $index, 0, $TEMPLATE_NAME ) );
}

////////////////////////////
//// get email template ////
////////////////////////////

function get_email_template ( $TEMPLATE_NAME )
{
    global $global_config_arr;
    global $db;

    $index = mysql_query ( "
                            SELECT `".$TEMPLATE_NAME."`
                            FROM ".$global_config_arr['pref']."email
                            WHERE `id` = '1'
    ", $db );

    return stripslashes ( mysql_result ( $index, 0, $TEMPLATE_NAME ) );
}

////////////////////
//// send email ////
////////////////////

function send_mail ( $TO, $SUBJECT, $TEXT, $HTML = FALSE, $FROM = FALSE )
{
    global $global_config_arr;
    global $db;

    $index = mysql_query ( "
                            SELECT `use_admin_mail`, `email`, `html`
                            FROM ".$global_config_arr['pref']."email
                            WHERE `id` = '1'
    ", $db );

    if ( $FROM == FALSE ) {
        if ( mysql_result ( $index, 0, "use_admin_mail" ) == 1 ) {
            $header  = "From: " . $global_config_arr['admin_mail'] . "\n";
        } else {
            $header  = "From: " . stripslashes ( mysql_result ( $index, 0, "email" ) ) . "\n";
        }
    } else {
        $header  = "From: " . $FROM . "\n";
    }

    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Sender-IP: " . $REMOTE_ADDR . "\n";
    
    if ( $HTML == FALSE || $HTML == "html" ) {
        if ( mysql_result ( $index, 0, "html" ) == 1 ) {
            $header .= "Content-Type: text/html";
            $TEXT = fscode ( $TEXT, true, true, false );
            $TEXT = "<html><body>" . $TEXT . "</body></html>";
        } else {
            $header .= "Content-Type: text/plain";
        }
    } else  {
        $header .= "Content-Type: text/plain";
    }

    return @mail ( $TO, $SUBJECT, $TEXT, $header );
}


////////////////////////////////
//// Create textarea        ////
////////////////////////////////

function create_textarea($name, $text="", $width="", $height="", $class="", $all=true, $fs_smilies=0, $fs_b=0, $fs_i=0, $fs_u=0, $fs_s=0, $fs_center=0, $fs_font=0, $fs_color=0, $fs_size=0, $fs_img=0, $fs_cimg=0, $fs_url=0, $fs_home=0, $fs_email=0, $fs_code=0, $fs_quote=0, $fs_noparse=0)
{
    global $global_config_arr;
    global $db;

    if ($name != "") {
        $name2 = 'name="'.$name.'" id="'.$name.'"';
    } else {
        return false;
    }
    
    if ($width != "") {
        $width2 = 'width:'.$width.'px;';
    }
    
    if ($height != "") {
        $height2 = 'height:'.$height.'px';
    }
    
    if ($class != "") {
        $class2 = 'class="'.$class.'"';
    }

    $style = $name2.' '.$class2.' style="'.$width2.' '.$height2.'"';

  if ($all==true OR $fs_smilies==1) {
    $smilies_table = '
          <table cellpadding="2" cellspacing="0" border="0">';

    $index = mysql_query ( " SELECT * FROM `".$global_config_arr['pref']."editor_config` ", $db );
    $config_arr = mysql_fetch_assoc ( $index );
    $config_arr['num_smilies'] = $config_arr['smilies_rows']*$config_arr['smilies_cols'];
            
    $zaehler = 0;
    $index = mysql_query ( "
                            SELECT *
                            FROM `".$global_config_arr['pref']."smilies`
                            ORDER BY `order` ASC
                            LIMIT 0, ".$config_arr['num_smilies']."
    ", $db);
    while ( $smilie_arr = mysql_fetch_assoc ( $index ) )
    {
        $smilie_arr['url'] = image_url ( "images/smilies/", $smilie_arr['id'] );
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
    $smilies->setFile("0_editor.tpl");
    $smilies->load("SMILIES_BODY");

    $smilies->tag("smilies_table", $smilies_table );

    $smilies = $smilies->display ();
  } else {
    $smilies = "";
  }

$buttons = "";
  
if ($all==true OR $fs_b==1) {
  $buttons .= create_textarea_button('bold.gif', "B", "fett", "insert('$name', '[b]', '[/b]')");
}
if ($all==true OR $fs_i==1) {
  $buttons .= create_textarea_button('italic.gif', "I", "kursiv", "insert('$name', '[i]', '[/i]')");
}
if ($all==true OR $fs_u==1) {
  $buttons .= create_textarea_button('underline.gif', "U", "unterstrichen", "insert('$name','[u]','[/u]')");
}
if ($all==true OR $fs_s==1) {
  $buttons .= create_textarea_button('strike.gif', "S", "durgestrichen", "insert('$name', '[s]', '[/s]')");
}


if ($all==true OR $fs_b==1 OR $fs_i==1 OR $fs_u==1 OR $fs_s==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_center==1) {
  $buttons .= create_textarea_button('center.gif', "CENTER", "zentriert", "insert('$name', '[center]', '[/center]')");
}


if ($all==true OR $fs_center==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_font==1) {
  $buttons .= create_textarea_button('font.gif', "FONT", "Schriftart", "insert_com('$name', 'font', 'Bitte gib die gewünschte Schriftart ein:', '')");
}
if ($all==true OR $fs_color==1) {
  $buttons .= create_textarea_button('color.gif', "COLOR", "Schriftfarbe", "insert_com('$name', 'color', 'Bitte gib die gewünschte Schriftfarbe (englisches Wort) ein:', '')");
}
if ($all==true OR $fs_size==1) {
  $buttons .= create_textarea_button('size.gif', "SIZE", "Schriftgröße", "insert_com('$name', 'size', 'Bitte gib die gewünschte Schriftgröße (Zahl von 0-7) ein:', '')");
}


if ($all==true OR $fs_font==1 OR $fs_color==1 OR $fs_size==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_img==1) {
  $buttons .= create_textarea_button('img.gif', "IMG", "Bild einfügen", "insert_mcom('$name', '[img]', '[/img]', 'Bitte gib die URL zu der Grafik ein:', 'http://')");
}
if ($all==true OR $fs_cimg==1) {
  $buttons .= create_textarea_button('cimg.gif', "CIMG", "Content-Image einfügen", "insert_mcom('$name', '[cimg]', '[/cimg]', 'Bitte gib den Namen des Content-Images (mit Endung) ein:', '')");
}


if ($all==true OR $fs_img==1 OR $fs_cimg==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_url==1) {
  $buttons .= create_textarea_button('url.gif', "URL", "Link einfügen", "insert_com('$name', 'url', 'Bitte gib die URL ein:', 'http://')");
}
if ($all==true OR $fs_home==1) {
  $buttons .= create_textarea_button('home.gif', "HOME", "Projektinternen Link einfügen", "insert_com('$name', 'home', 'Bitte gib den projektinternen Verweisnamen ein:', '')");
}
if ($all==true OR $fs_email==1) {
  $buttons .= create_textarea_button('email.gif', "@", "Email-Link einfügen", "insert_com('$name', 'email', 'Bitte gib die Email-Adresse ein:', '')");
}


if ($all==true OR $fs_url==1 OR $fs_home==1 OR $fs_email==1) {
  $buttons .= create_textarea_seperator();
}


if ($all==true OR $fs_code==1) {
  $buttons .= create_textarea_button('code.gif', "C", "Code-Bereich einfügen", "insert('$name', '[code]', '[/code]')");
}
if ($all==true OR $fs_quote==1) {
  $buttons .= create_textarea_button('quote.gif', "Q", "Zitat einfügen", "insert('$name', '[quote]', '[/quote]')");
}
if ($all==true OR $fs_noparse==1) {
  $buttons .= create_textarea_button('noparse.gif', "N", "Nicht umzuwandelnden Bereich einfügen", "insert('$name', '[noparse]', '[/noparse]')");
}

    // Get Template
    $textarea = new template();
    $textarea->setFile("0_editor.tpl");
    $textarea->load("BODY");
    
    $textarea->tag("style", $style );
    $textarea->tag("text", $text );
    $textarea->tag("buttons", $buttons );
    $textarea->tag("smilies", $smilies );
    
    $textarea = $textarea->display ();

    return $textarea;
}


////////////////////////////////
//// Create textarea Button ////
////////////////////////////////

function create_textarea_button($img_file_name, $alt, $title, $insert)
{
    global $global_config_arr;
    $javascript = 'onClick="'.$insert.'"';

    // Get Button
    $button = new template();
    $button->setFile("0_editor.tpl");
    $button->load("BUTTON");
    
    $button->tag("img_file_name", $img_file_name );
    $button->tag("alt", $alt );
    $button->tag("title", $title );
    $button->tag("javascript", $javascript );
    
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
    $seperator->setFile("0_editor.tpl");
    $seperator->load("SEPERATOR");
    $seperator = $seperator->display ();

    return $seperator;
}


/////////////////////////
//// System Message ////
/////////////////////////

function sys_message ( $TITLE, $MESSAGE )
{
    global $db, $global_config_arr;

    $template = new template();

    $template->setFile ( "0_general.tpl" );
    $template->load ( "SYSTEMMESSAGE" );

    $template->tag ( "message_title", $TITLE );
    $template->tag ( "message", $MESSAGE );

    $template = $template->display ();
    return $template;
}

/////////////////////////
//// Forward Message ////
/////////////////////////

function forward_message ( $TITLE, $MESSAGE, $URL)
{
    global $db, $global_config_arr;

    $forward_script = '
<noscript>
    <meta http-equiv="Refresh" content="'.$global_config_arr['auto_forward'].'; URL='.$URL.'">
</noscript>
<script type="text/javascript">
    function auto_forward() {
        window.location = "'.$URL.'";
    }
    window.setTimeout("auto_forward()", '.($global_config_arr['auto_forward']*1000).');
</script>
    ';

    $template = new template();

    $template->setFile ( "0_general.tpl" );
    $template->load ( "FORWARDMESSAGE" );

    $template->tag ( "message_title", $TITLE );
    $template->tag ( "message", $MESSAGE );
    $template->tag ( "forward_url", $URL );
    $template->tag ( "forward_time", $global_config_arr['auto_forward'] );
    
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
// String kürzen ohne Wort zuzerstören //  <= BAD FUNCTION HAS TO BE IMPROVED
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

/////////////////////////////////////////
// String innerhalb sich selbst kürzen //
/////////////////////////////////////////
function shortening_in_string($STRING, $MAXLENGTH, $REPLACEMENT)
{
    if (strlen($STRING) > $MAXLENGTH) {
        $part_lenght = ceil($MAXLENGTH/2) - ceil(strlen($REPLACEMENT)/2);
        $string_start = substr($STRING, 0, $part_lenght);
        $string_end = substr($STRING, -1*$part_lenght);
        $STRING = $string_start . $REPLACEMENT . $string_end;
    }
    return $STRING;
}
function cut_in_string ($string, $maxlength, $replacement)
{
   return shortening_in_string ($string, $maxlength, $replacement);
}

///////////////////////
//// String kürzen ////
///////////////////////
function shortening_string($STRING, $MAXLENGTH, $EXTENSION)
{
    if (strlen($STRING) > $MAXLENGTH) {
        $STRING = substr($STRING, 0, $MAXLENGTH) . $EXTENSION;
    }
    return $STRING;
}



////////////////////////////////
///// Download Categories //////
////////////////////////////////

function get_dl_categories (&$IDs, $CAT_ID, $SHOW_SUB = 0, $ID = 0, $LEVEL = -1 )
{
    global $global_config_arr, $db;

    $index = mysql_query ( "
                            SELECT * FROM `".$global_config_arr['pref']."dl_cat`
                            WHERE `subcat_id` = '".$ID."'
                            ORDER BY `cat_name`
    ", $db );

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
    global $db, $global_config_arr;

    $news_arr[news_date] = date_loc( $global_config_arr['datetime'] , $news_arr[news_date]);
    $news_arr[comment_url] = "?go=comments&amp;id=".$news_arr[news_id];

    // Kategorie lesen
    $index2 = mysql_query("select cat_name from ".$global_config_arr[pref]."news_cat where cat_id = '".$news_arr['cat_id']."'", $db);
    $news_arr[cat_name] = mysql_result($index2, 0, "cat_name");
    $news_arr[cat_pic] = image_url("images/cat/", "news_".$news_arr[cat_id]);

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

    $news_arr[news_text] = fscode ( $news_arr[news_text], $fs, $html, $para );
    $news_arr[news_title] = killhtml ( $news_arr[news_title] );

    // User auslesen
    $index2 = mysql_query("select user_name from ".$global_config_arr[pref]."user where user_id = $news_arr[user_id]", $db);
    $news_arr[user_name] = kill_replacements ( mysql_result($index2, 0, "user_name"), TRUE );
    $news_arr[user_url] = "?go=user&amp;id=".$news_arr[user_id];

    // Kommentare lesen
    $index2 = mysql_query("select comment_id from ".$global_config_arr[pref]."news_comments where news_id = $news_arr[news_id]", $db);
    $news_arr[kommentare] = mysql_num_rows($index2);

    // Get Related Links
    $link_tpl = "";
    $index2 = mysql_query("select * from ".$global_config_arr[pref]."news_links where news_id = $news_arr[news_id] order by link_id", $db);
    while ($link_arr = mysql_fetch_assoc($index2))
    {
        $link_arr[link_name] = killhtml ( $link_arr[link_name] );
        $link_arr[link_url] = killhtml ( $link_arr[link_url] );
        $link_arr[link_target] = ( $link_arr[link_target] == 1 ) ? "_blank" : "_self";

        // Get Link Line Template
        $link = new template();
        $link->setFile("0_news.tpl");
        $link->load("LINKS_LINE");

        $link->tag("title", $link_arr[link_name] );
        $link->tag("url", $link_arr[link_url] );
        $link->tag("target", $link_arr[link_target] );

        $link = $link->display ();
        $link_tpl .= $link;
    }
    if (mysql_num_rows($index2) > 0) {
        // Get Links Body Template
        $related_links = new template();
        $related_links->setFile("0_news.tpl");
        $related_links->load("LINKS_BODY");
        $related_links->tag("links", $link_tpl );
        $related_links = $related_links->display ();
    } else {
        $related_links = "";
    }

    // Template lesen und füllen
    $template = new template();
    $template->setFile("0_news.tpl");
    $template->load("NEWS_BODY");

    $template->tag("news_id", $news_arr[news_id] );
    $template->tag("titel", $news_arr[news_title] );
    $template->tag("date", $news_arr[news_date] );
    $template->tag("text", $news_arr[news_text] );
    $template->tag("user_name", $news_arr[user_name] );
    $template->tag("user_url", $news_arr[user_url] );
    $template->tag("cat_name", $news_arr[cat_name] );
    $template->tag("cat_image", $news_arr[cat_pic] );
    $template->tag("comments_url", $news_arr[comment_url] );
    $template->tag("comments_number", $news_arr[kommentare] );
    $template->tag("related_links", $related_links );

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
            $SIZE = round ( $SIZE, 1 ) . " KB";
            break;
        case ($SIZE < $gb):
            $SIZE = round ( $SIZE/$mb, 1 ). " MB";
            break;
        case ($SIZE < $tb):
            $SIZE = round ( $SIZE/$gb, 1 ). " GB";
            break;
        case ($SIZE > $tb):
            $SIZE = round ( $SIZE/$tb, 1 ). " TB";
            break;
    }
    return $SIZE;
}

/////////////////////////
// mark word in a text //  <=== DEPRECATED
/////////////////////////

function markword($text, $word)
{
    return highlight_part($text, $word);
}

//////////////////////////////////////////////////////////////
// Inserts HTML line breaks before all newlines in a string //
//////////////////////////////////////////////////////////////

function html_nl2br ( $TEXT )
{
    $TEXT = str_replace ( array ( "\r\n", "\r", "\n" ), "<br>", $TEXT );
    return $TEXT;
}

/////////////////////////////////
// create save strings for sql //
/////////////////////////////////

function savesql ( $TEXT )
{
    global $db;

    if ( !is_numeric ( $TEXT ) ) {
        $TEXT = mysql_real_escape_string ( addslashes ( unquote ( $TEXT ) ), $db );
    }
    return $TEXT;
}

/////////////////////////////////
// create save strings for sql //
/////////////////////////////////

function unquote ( $TEXT )
{
    global $global_config_arr;

    if ( get_magic_quotes_gpc () ) {
        $TEXT = stripslashes ( $TEXT );
    }
    return $TEXT;
}

//////////////////////////////////
// kill html in textareas, etc. //
//////////////////////////////////

function killhtml ( $TEXT )
{
    $TEXT = stripslashes ( $TEXT );
    $TEXT = htmlspecialchars ( $TEXT, ENT_COMPAT );
    return $TEXT;
}


//////////////////////////////
// Format text with FS Code //
//////////////////////////////

function fscode($text, $all=true, $html=false, $para=false, $do_b=0, $do_i=0, $do_u=0, $do_s=0, $do_center=0, $do_url=0, $do_homelink = 0, $do_email=0, $do_img=0, $do_cimg=0, $do_list=0, $do_numlist=0, $do_font=0, $do_color=0, $do_size=0, $do_code=0, $do_quote=0, $do_noparse=0, $do_smilies=0, $do_player=0)
{
        include_once ( FS2_ROOT_PATH . 'includes/bbcodefunctions.php');
        $bbcode = new StringParser_BBCode ();

        $bbcode->addFilter (STRINGPARSER_FILTER_PRE, 'convertlinebreaks');

        if ($html==false) {
            #$bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'strip_tags');
            $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'killhtml');
        }
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'stripslashes');
        if ($all==true) {
              $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'html_nl2br');
        }
        $bbcode->addParser ('list', 'bbcode_stripcontents');

        if ($all==true OR $do_smilies==1)
        $bbcode->addParser (array ('block', 'inline', 'link', 'listitem'), 'do_bbcode_smilies');

        if ($all==true OR $do_b==1)
        $bbcode->addCode ('b', 'simple_replace', null, array ('start_tag' => '<b>', 'end_tag' => '</b>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_i==1)
        $bbcode->addCode ('i', 'simple_replace', null, array ('start_tag' => '<i>', 'end_tag' => '</i>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_u==1)
        $bbcode->addCode ('u', 'simple_replace', null, array ('start_tag' => '<span style="text-decoration:underline">', 'end_tag' => '</span>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_s==1)
        $bbcode->addCode ('s', 'simple_replace', null, array ('start_tag' => '<span style="text-decoration:line-through">', 'end_tag' => '</span>'),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_center==1) {
            $bbcode->addCode ('center', 'simple_replace', null, array ('start_tag' => '<p align="center">', 'end_tag' => '</p>'),
                              'inline', array ('listitem', 'block', 'inline', 'link'), array ());
            $bbcode->setCodeFlag ('center', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
        }

        if ($all==true OR $do_url==1)
        $bbcode->addCode ('url', 'usecontent?', 'do_bbcode_url', array ('usecontent_param' => 'default'),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));

        if ($all==true OR $do_homelink==1)
        $bbcode->addCode ('home', 'usecontent?', 'do_bbcode_homelink', array ('usecontent_param' => 'default'),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));

        if ($all==true OR $do_email==1)
        $bbcode->addCode ('email', 'usecontent?', 'do_bbcode_email', array ('usecontent_param' => 'default'),
                          'link', array ('listitem', 'block', 'inline'), array ('link'));

        if ($all==true OR $do_img==1)
        $bbcode->addCode ('img', 'usecontent?', 'do_bbcode_img', array (),
                          'image', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_cimg==1)
        $bbcode->addCode ('cimg', 'usecontent?', 'do_bbcode_cimg', array (),
                          'image', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_player==1)
        $bbcode->addCode ('player', 'usecontent?', 'do_bbcode_player', array (),
                          'block', array ('block', 'inline'), array ('listitem', 'link'));

        if ($all==true OR $do_list==1)
        $bbcode->addCode ('list', 'simple_replace', null, array ('start_tag' => '<ul>', 'end_tag' => '</ul>'),
                          'list', array ('block', 'listitem'), array ('link'));

        if ($all==true OR $do_numlist==1)
        $bbcode->addCode ('numlist', 'simple_replace', null, array ('start_tag' => '<ol>', 'end_tag' => '</ol>'),
                          'list', array ('block', 'listitem'), array ('link'));

        if ($all==true OR $do_list==1 OR $do_numlist==1) {
            $bbcode->addCode ('*', 'simple_replace', null, array ('start_tag' => '<li>', 'end_tag' => '</li>'),
                              'listitem', array ('list'), array ());
            $bbcode->setCodeFlag ('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
            $bbcode->setCodeFlag ('*', 'paragraphs', false);
            $bbcode->setCodeFlag ('list', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
            $bbcode->setCodeFlag ('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
            $bbcode->setCodeFlag ('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
        }


        if ($all==true OR $do_font==1)
        $bbcode->addCode ('font', 'callback_replace', 'do_bbcode_font', array (),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_color==1)
        $bbcode->addCode ('color', 'callback_replace', 'do_bbcode_color', array (),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_size==1)
        $bbcode->addCode ('size', 'callback_replace', 'do_bbcode_size', array (),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($all==true OR $do_code==1) {
            $bbcode->addCode ('code', 'callback_replace', 'do_bbcode_code', array (),
                              'block', array ('listitem', 'block', 'inline'), array ('link'));
            $bbcode->setCodeFlag ('code', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
            $bbcode->setCodeFlag ('code', 'paragraph_type', BBCODE_PARAGRAPH_ALLOW_INSIDE);
        }
        
        if ($all==true OR $do_quote==1) {
            $bbcode->addCode ('quote', 'callback_replace', 'do_bbcode_quote', array (),
                              'block', array ('listitem', 'block', 'inline'), array ('link'));
            $bbcode->setCodeFlag ('quote', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
            $bbcode->setCodeFlag ('quote', 'paragraph_type', BBCODE_PARAGRAPH_ALLOW_INSIDE);
        }

        if ($all==true OR $do_noparse==1)
        $bbcode->addCode ('noparse', 'usecontent', 'do_bbcode_noparse', array (),
                          'inline', array ('listitem', 'block', 'inline', 'link'), array ());

        if ($para==true) {
            $bbcode->setRootParagraphHandling (true);
        }

        $bbcode->setGlobalCaseSensitive (false);
        $parsedtext = $bbcode->parse ($text);
        unset($bbcode);

        return $parsedtext;
}

//////////////////////////
// kill FS Code in text //
//////////////////////////

function killfs($text)
{
    $text = fscode ( $text, TRUE, TRUE, TRUE );
    $text = strip_tags($text);
    return $text;
}

///////////////////////////////////////////////////////////////
// Check if the visitor has already voted in the given poll  //
///////////////////////////////////////////////////////////////
function checkVotedPoll($pollid) {

    global $global_config_arr;
    global $db;

        settype($pollid, 'integer');

        if (isset($_COOKIE['polls_voted'])) {
            $polls_voted = savesql($_COOKIE['polls_voted']);
            $votes = explode(',', $polls_voted);
            if (in_array($pollid, $votes )) {
                return true;
            }
        }
        $one_day_ago = time()-60*60*24;
        mysql_query("DELETE FROM ".$global_config_arr[pref]."poll_voters WHERE time <= '".$one_day_ago."'", $db); //Delete old IPs
        $query_id = mysql_query("SELECT voter_id FROM ".$global_config_arr[pref]."poll_voters WHERE poll_id = $pollid AND ip_address = '".$_SERVER['REMOTE_ADDR']."' AND time > '".$one_day_ago."'", $db); //Save IP for 1 Day
        if (mysql_num_rows($query_id) > 0) {
                return true;
        }

        return false;
}

///////////////////////////////////////////////////////////////
//// Register the voter in the db to avoid multiple votes  ////
///////////////////////////////////////////////////////////////
function registerVoter($pollid, $voter_ip) {

        global $global_config_arr;

        settype($pollid, 'integer');

        mysql_query("INSERT INTO ".$global_config_arr[pref]."poll_voters VALUES ('', '$pollid', '$voter_ip', '".time()."')");
        if (!isset($_COOKIE['polls_voted'])) {
                setcookie('polls_voted', $pollid, time()+60*60*24*60); //2 months
        } else {
                setcookie('polls_voted', $_COOKIE['polls_voted'].','.$pollid, time()+60*60*24*60);
        }
}
?>