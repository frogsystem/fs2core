<?php
/////////////////////
//// File Config ////
/////////////////////
$FILE_SHOW_START = TRUE;

/////////////////////
//// Load Config ////
/////////////////////
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_config WHERE `id` = '1'", $db );
$config_arr = mysql_fetch_assoc ( $index );

///////////////////
//// Functions ////
///////////////////
function default_set_filter_data ( $FORM )
{
    global $db;
    global $global_config_arr;
    global $admin_phrases;
        
    if ( !isset ( $FORM['order'] ) ) { $FORM['order'] = "news_date"; }
    if ( !isset ( $FORM['sort'] ) ) { $FORM['sort'] = "DESC"; }
    if ( !isset ( $FORM['cat_id'] ) ) { $FORM['cat_id'] = 0; }
    
    $FORM['order'] = savesql ( $FORM['order'] );
    $FORM['sort'] = savesql ( $FORM['sort'] );
    settype ( $FORM['cat_id'], "integer" );
    
    return $FORM;
}

function default_display_filter ( $FORM )
{
        global $db;
        global $global_config_arr;
        global $admin_phrases;

    echo'
                                        <form action="?go=news_edit" method="post">
                        <input type="hidden" value="news_edit" name="go">

                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="3">'.$admin_phrases[news][news_edit_filter_title].'</td></tr>
                                                        <tr>
                                <td class="config" width="100%" colspan="2">
                                                                        '.$admin_phrases[news][news_edit_filter_from].'
                                    <select name="cat_id">
                                            <option value="0" '.getselected( 0, $FORM['cat_id'] ).'>'.$admin_phrases[news][news_edit_filter_all_cat].'</option>
        ';
                                                                            // List Categories
                                                                            $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat", $db );
                                                                            while ( $cat_arr = mysql_fetch_assoc ( $index ) )
                                                                            {
                                                                                        settype ( $cat_arr['cat_id'], "integer" );
                                                                                        echo '<option value="'.$cat_arr['cat_id'].'" '.getselected( $cat_arr['cat_id'], $FORM['cat_id'] ).'>'.$cat_arr['cat_name'].'</option>';
                                                                            }
        echo'
                                    </select>
                                                                        <br><br>'.$admin_phrases[news][news_edit_filter_sort].'
                                    <select name="order">
                                        <option value="news_id" '.getselected ( "news_id", $FORM['order'] ).'>'.$admin_phrases[news][news_edit_filter_id].'</option>
                                        <option value="news_date" '.getselected ( "news_date", $FORM['order'] ).'>'.$admin_phrases[news][news_edit_filter_date].'</option>
                                        <option value="news_title" '.getselected ( "news_title", $FORM['order'] ).'>'.$admin_phrases[news][news_edit_filter_newstitle].'</option>
                                    </select>,
                                    <select name="sort">
                                        <option value="ASC" '.getselected ( "ASC", $FORM['sort'] ).'>'.$admin_phrases[common][ascending].'</option>
                                        <option value="DESC" '.getselected ( "DESC", $FORM['sort'] ).'>'.$admin_phrases[common][descending].'</option>
                                    </select>

                                </td>
                                <td class="right">
                                    <input type="submit" value="'.$admin_phrases[common][apply_button].'" class="button">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                                                </table>
                                        </form>
        ';
}

function default_get_pagenav_data ()
{
        global $db;
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
        ", $db);
        
        $pagenav_arr = get_pagenav_start ( mysql_result ( $index, 0, "number" ), $limit, $_GET['start'] );

        return $pagenav_arr;
}

function default_display_pagenav ( $pagenav_arr )
{
        global $db;
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

function default_get_entry_data ( $news_arr )
{
        global $db;
        global $global_config_arr;
        global $admin_phrases;

        // Get other Data
        $news_arr['news_date_formated'] = "".$admin_phrases[common][on_date]." <b>" . date ( $admin_phrases[common][date_format] , $news_arr['news_date'] ) . "</b> ".$admin_phrases[common][at_time]." <b>" . date ( $admin_phrases[common][time_format] , $news_arr['news_date'] ) . "</b>";
    $news_arr['news_text_short'] = truncate_string ( killfs (  $news_arr['news_text'] ) , 250, "..." );

    $index2 = mysql_query("SELECT COUNT(comment_id) AS 'number' FROM ".$global_config_arr['pref']."news_comments WHERE news_id = ".$news_arr['news_id']."", $db );
    $news_arr['num_comments'] = mysql_result ( $index2, 0, "number" );
    
    $index2 = mysql_query("SELECT COUNT(link_id) AS 'number' FROM ".$global_config_arr['pref']."news_links WHERE news_id = ".$news_arr['news_id']."", $db );
    $news_arr['num_links'] = mysql_result ( $index2, 0, "number" );

    $index2 = mysql_query("SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$news_arr['user_id']."", $db );
    $news_arr['user_name'] = mysql_result ( $index2, 0, "user_name" );

        $index2 = mysql_query("SELECT cat_name FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = ".$news_arr['cat_id']."", $db );
    $news_arr['cat_name'] = mysql_result ( $index2, 0, "cat_name" );
    
    return $news_arr;
}

function default_display_entry ( $news_arr )
{
        global $db;
        global $global_config_arr;
        global $admin_phrases;
        global $config_arr;

        // Display News Entry
        $entry = '
                            <tr class="select_entry">
                                <td class="config justify" style="width: 375px; padding-right: 25px;">
                                    #'.$news_arr['news_id'].' '.killhtml ( $news_arr['news_title'] ).'
        ';
        if ( $config_arr['acp_view'] == 1 ) {
                $entry .= '
                                    <br><span class="small">'.$news_arr['news_text_short'].'</span>
                ';
        } elseif ( $config_arr['acp_view'] == 2 ) {
                $entry .= '
                                    <br>
                                    <span class="small">'.$admin_phrases[common][by].' <b>'.$news_arr['user_name'].'</b>,
                                                                        '.$admin_phrases[common][in].' <b>'.$news_arr['cat_name'].'</b>,
                                                                        <b>'.$news_arr['num_comments'].'</b> '.$admin_phrases[common][comments].',
                                                                        <b>'.$news_arr['num_links'].'</b> '.$admin_phrases[common][links].'</span>
                ';
        }
        $entry .= '
                                </td>
                                <td class="config middle" style="width: 180x;">
        ';
        if ( $config_arr['acp_view'] == 1 ) {
                $entry .= '
                                    <span class="small">'.$admin_phrases[common][by].' <b>'.$news_arr['user_name'].'</b><br>
                                                                        '.$news_arr['news_date_formated'].'<br>
                                                                        '.$admin_phrases[common][in].' <b>'.$news_arr['cat_name'].'</b><br>
                                                                        <b>'.$news_arr['num_comments'].'</b> '.$admin_phrases[common][comments].',
                                                                        <b>'.$news_arr['num_links'].'</b> '.$admin_phrases[common][links].'</span>
                ';
        } else {
                $entry .= '
                                                                        <span class="small">'.$news_arr['news_date_formated'].'</span>
                ';
        }
        $entry .= '
                                </td>
                                <td class="config middle center">
                                    <input class="pointer select_box" type="checkbox" name="news_id[]" value="'.$news_arr['news_id'].'">
                                </td>
                            </tr>
    ';
    
    return $entry;
}

function default_display_all_entries ( $pagenav_arr )
{
        global $db;
        global $global_config_arr;
        global $admin_phrases;

        unset ( $entries );

        // Create Where Clause for Category Filter
        unset ( $where_clause );
    if ( $_REQUEST['cat_id'] != 0 )
        {
        $where_clause = "WHERE cat_id = '".$_REQUEST['cat_id']."'";
    }

        // Load News From DB
        $index = mysql_query ( "
                                                        SELECT *
                                                        FROM ".$global_config_arr['pref']."news
                                                        ".$where_clause."
                                                        ORDER BY ".$_REQUEST['order']." ".$_REQUEST['sort'].", news_id ASC
                                                        LIMIT ".$pagenav_arr['cur_start'].", ".$pagenav_arr['entries_per_page']."
        ", $db);

    while ($news_arr = mysql_fetch_assoc($index))
    {
                $entries .= default_display_entry ( default_get_entry_data ( $news_arr ) );
    }
    
    return $entries;
}

function default_display_page ( $entries, $pagenav_arr, $FORM )
{
        global $global_config_arr, $db, $TEXT;
        global $admin_phrases;

        // Display News List Header
    echo'
                    <form action="?go=news_edit" method="post">
                        <input type="hidden" name="go" value="news_edit">
                        <input type="hidden" name="order" value="'.$FORM['order'].'" >
                        <input type="hidden" name="sort" value="'.$FORM['sort'].'">
                        <input type="hidden" name="cat_id" value="'.$FORM['cat_id'].'">
                        <table class="configtable select_list" cellpadding="4" cellspacing="0">
                            <tr><td class="line" colspan="4">'.$admin_phrases[news][news_edit_select_news].' ('.$pagenav_arr['total_entries'].' '.$admin_phrases[news][news_edit_entries_found].')</td></tr>

    ';

    echo $entries;

    // Display News List Footer
    echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="4">'.default_display_pagenav ( default_get_pagenav_data () ).'</td>
                            </tr>
                            <tr><td class="space"></td></tr>
    ';

    // End of Form & Table incl. Submit-Button
    echo '
         

                            <tr>
                                <td class="right" colspan="4">
                                    <select class="select_type" name="news_action" size="1">
                                        <option class="select_one" value="edit">'.$admin_phrases[common][selection_edit].'</option>
    ';
    echo ( $_SESSION['news_delete'] ) ? '<option class="select_red" value="delete" '.getselected ( "delete", $_POST['news_action'] ).'>'.$TEXT["admin"]->get("selection_delete").'</option>' : "";
    echo ( $_SESSION['news_comments'] ) ? '<option class="select_one" value="comments" '.getselected ( "comments", $_POST['news_action'] ).'>'.$TEXT["admin"]->get("news_edit_selection_comments").'</option>' : "";
    echo '
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

function action_edit_get_data ( $NEWS_ID )
{
        global $db;
        global $global_config_arr;
        global $admin_phrases;

    //Load News
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news WHERE news_id = '".$NEWS_ID."' LIMIT 0, 1", $db );
        $news_arr = mysql_fetch_assoc ( $index );

        // Sended or Link Action
         if ( isset ( $_POST['sended'] ) )
    {
        $news_arr = getfrompost ( $news_arr );
            $news_arr['d'] = $_POST['d'];
            $news_arr['m'] = $_POST['m'];
            $news_arr['y'] = $_POST['y'];
            $news_arr['h'] = $_POST['h'];
            $news_arr['i'] = $_POST['i'];
             if ( isset ( $_POST['editnews'] ) )
            {
                systext($admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE);
            }
    }

    // News Konfiguration lesen
    $index = mysql_query ( "SELECT html_code, fs_code FROM ".$global_config_arr['pref']."news_config", $db );
    $config_arr = mysql_fetch_assoc ( $index );
    $config_arr[html_code] = ($config_arr[html_code] == 2 OR $config_arr[html_code] == 4) ? $admin_phrases[common][on] : $admin_phrases[common][off];
    $config_arr[fs_code] = ($config_arr[fs_code] == 2 OR $config_arr[fs_code] == 4) ? $admin_phrases[common][on] : $admin_phrases[common][off];
    $config_arr[para_handling] = ($config_arr[para_handling] == 2 OR $config_arr[para_handling] == 4) ? $admin_phrases[common][on] : $admin_phrases[common][off];

        // User ID ermittlen
        if ( !isset ( $news_arr['user_id'] ) )
    {
        $news_arr['user_id'] = $_SESSION['user_id'];
    }

        // Security-Functions
        $news_arr['news_text'] = killhtml ( $news_arr['news_text'] );
    $news_arr['news_title'] = killhtml ( $news_arr['news_title'] );
        settype ( $news_arr['cat_id'], "integer" );
    settype ( $news_arr['user_id'], "integer" );
    settype ( $news_arr['news_active'], "integer" );
    settype ( $news_arr['news_comments_allowed'], "integer" );

    // Get User
    $index = mysql_query ( "SELECT user_name, user_id FROM ".$global_config_arr['pref']."user WHERE user_id = '".$news_arr['user_id']."'", $db );
    $news_arr['poster'] = killhtml ( mysql_result ( $index, 0, "user_name" ) );

        // Create Date-Arrays
    if ( !isset ( $news_arr['d'] ) )
    {
            $news_arr['d'] = date ( "d", $news_arr['news_date'] );
            $news_arr['m'] = date ( "m", $news_arr['news_date'] );
            $news_arr['y'] = date ( "Y", $news_arr['news_date'] );
            $news_arr['h'] = date ( "H", $news_arr['news_date'] );
            $news_arr['i'] = date ( "i", $news_arr['news_date'] );
        }
        $date_arr = getsavedate ( $news_arr['d'], $news_arr['m'], $news_arr['y'], $news_arr['h'], $news_arr['i'] );
        $nowbutton_array = array( "d", "m", "y", "h", "i" );
        
        $data_arr['news'] = $news_arr;
        $data_arr['date'] = $date_arr;
        $data_arr['nowbutton'] = $nowbutton_array;
        $data_arr['config'] = $config_arr;
        
        return $data_arr;
}

function action_edit_display_links ( $NEWS_ID, $FORM )
{
        global $db;
        global $global_config_arr;
        global $admin_phrases;
        
        // Load Links from DB
         if ( !isset ( $FORM['sended'] ) )
    {
                $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_links WHERE news_id = '".$NEWS_ID."' ORDER BY link_id ASC", $db );
                while ( $link_arr = mysql_fetch_assoc ( $index ) ) {
            $FORM['linkname'][] = $link_arr['link_name'];
                          $FORM['linkurl'][] = $link_arr['link_url'];
            $FORM['linktarget'][] = $link_arr['link_target'];
            $FORM['linknew'][] = 0;
                }
        }

        //Zu löschende Links löschen
        if ( isset ( $FORM['sended'] ) &&  isset ( $FORM['dolinkbutton'] ) && $FORM['do_links'] == "del" && count ( $FORM['dolink'] ) > 0 )
        {
                foreach ( $FORM['dolink'] as $key => $value )
            {
                        if ( $value == 1 )
                        {
                                $FORM['linkname'][$key] = "";
                        $FORM['linkurl'][$key] = "";
                        $FORM['linktarget'][$key] = "";
                        }
            }
        }

        //Links nach oben verschieben
        if ( isset ( $FORM['sended'] ) &&  isset ( $FORM['dolinkbutton'] ) && $FORM['do_links'] == "up" && count ( $FORM['dolink'] ) > 0 )
        {
                foreach ( $FORM['dolink'] as $key => $value )
            {
                        if ( $value == 1 && $key != 0 )
                        {
                                $up_name = $FORM['linkname'][$key];
                        $up_url = $FORM['linkurl'][$key];
                        $up_target = $FORM['linktarget'][$key];
                        $FORM['linkname'][$key] = $FORM['linkname'][$key-1];
                        $FORM['linkurl'][$key] = $FORM['linkurl'][$key-1];
                        $FORM['linktarget'][$key] = $FORM['linktarget'][$key-1];
                        $FORM['linkname'][$key-1] = $up_name;
                        $FORM['linkurl'][$key-1] = $up_url;
                        $FORM['linktarget'][$key-1] = $up_target;
                        }
            }
        }

        //Links nach unten verschieben
        if ( isset ( $FORM['sended'] ) &&  isset ( $FORM['dolinkbutton'] ) && $FORM['do_links'] == "down" && count ( $FORM['dolink'] ) > 0 )
        {
                foreach ( $FORM['dolink'] as $key => $value )
            {
                        if ( $value == 1 && $key != count ( $DATA['linkname'] ) - 1 )
                        {
                                $down_name = $FORM['linkname'][$key];
                        $down_url = $FORM['linkurl'][$key];
                        $down_target = $FORM['linktarget'][$key];
                        $FORM['linkname'][$key] = $FORM['linkname'][$key+1];
                        $FORM['linkurl'][$key] = $FORM['linkurl'][$key+1];
                        $FORM['linktarget'][$key] = $FORM['linktarget'][$key+1];
                        $FORM['linkname'][$key+1] = $down_name;
                        $FORM['linkurl'][$key+1] = $down_url;
                        $FORM['linktarget'][$key+1] = $down_target;
                        }
            }
        }

        //Zu bearbeitende Links löschen & Daten sichern
        unset ( $edit_name );
        unset ( $edit_url );
        unset ( $edit_target );

        if ( isset ( $FORM['sended'] ) &&  isset ( $FORM['dolinkbutton'] ) && $FORM['do_links'] == "edit" && count ( $FORM['dolink'] ) > 0 )
        {
                foreach ( $FORM['dolink'] as $key => $value )
            {
                        if ( $value == 1 )
                        {
                                $edit_name = $FORM['linkname'][$key];
                        $edit_url = $FORM['linkurl'][$key];
                        $edit_target = $FORM['linktarget'][$key];
                                $FORM['linkname'][$key] = "";
                        $FORM['linkurl'][$key] = "";
                        $FORM['linktarget'][$key] = "";
                        }
            }
        }

        // Erstellte Linkfelder ausgeben
        if ( !isset ($FORM['linkname']) )
         {
        $FORM['linkname'][0] = "";
        }
        $linkid = 0;

    foreach ( $FORM['linkname'] as $key => $value )
    {
        if ( $FORM['linkname'][$key] != "" && $FORM['linkurl'][$key] != ""  && ( $FORM['linknew'][$key] == 0 || isset ( $FORM['addlink'] ) ) )
        {
                        $counter = $linkid + 1;

                        $link_name = killhtml ( $FORM['linkname'][$key] );

                        $link_maxlenght = 60;
            $FORM['linkurl'][$key] = killhtml ( $FORM['linkurl'][$key] );
                        $link_fullurl = $FORM['linkurl'][$key];
                        if ( strlen ( $FORM['linkurl'][$key] ) > $link_maxlenght )
                {
                    $FORM['linkurl'][$key] = substr ( $link_fullurl, 0, $link_maxlenght ) . "...";
                }

                        switch ( $FORM['linktarget'][$key] )
                    {
                        case 1: $link_target = $admin_phrases[news][news_link_blank]; break;
                        default:
                                        $FORM['linktarget'][$key] = 0;
                                        $link_target = $admin_phrases[news][news_link_self];
                                        break;
                    }

            echo'
                                                                        <tr class="pointer" id="tr_'.$linkid.'"
                                                                                        onmouseover="'.color_list_entry ( "input_".$linkid, "#EEEEEE", "#64DC6A", "this" ).'"
                                                                                        onmouseout="'.color_list_entry ( "input_".$linkid, "transparent", "#49C24f", "this" ).'"
                                                                                        onclick="'.color_click_entry ( "input_".$linkid, "#EEEEEE", "#64DC6A", "this", TRUE ).'"
                                                    >
                                                                                        <td class="config" style="padding-left: 7px; padding-right: 7px; padding-bottom: 2px; padding-top: 2px;">
                                                                                                #'.$counter.'
                                                                                        </td>
                                                                                        <td class="config" width="100%" style="padding-right: 5px; padding-bottom: 2px; padding-top: 2px;">
                                                             '.$link_name.' <span class="small">('.$link_target.')</span><br>
                                                            <a href="'.$link_fullurl.'" target="_blank" title="'.$link_fullurl.'">'.$FORM['linkurl'][$key].'</a>
                                                            <input type="hidden" name="linkname['.$linkid.']" value="'.$link_name.'">
                                                            <input type="hidden" name="linkurl['.$linkid.']" value="'.$link_fullurl.'">
                                                            <input type="hidden" name="linktarget['.$linkid.']" value="'.$FORM['linktarget'][$key].'">
                                                            <input type="hidden" name="linknew['.$linkid.']" value="0">
                                                                                        </td>

                                                        <td align="center">
                                                                                                <input class="pointer" type="radio" name="dolink['.$linkid.']" id="input_'.$linkid.'" value="1"
                                                    onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$linkid, TRUE ).'"
                                                                                                >
                                                                                        </td>
                                                                                </tr>
            ';
                        $linkid++;
        }
        }
        
    $data_arr['num_links'] = $linkid;
    $data_arr['edit']['name'] = killhtml ( $edit_name );
    $data_arr['edit']['url'] = killhtml ( $edit_url );
    $data_arr['edit']['target'] = killhtml ( $edit_target );

        return $data_arr;
}

function action_edit_display_new_link ( $NUM_LINKS, $EDIT )
{
        global $db;
        global $global_config_arr;
        global $admin_phrases;

        if ( $NUM_LINKS > 0 )
        {
                echo'
                                                                                <tr valign="top">
                                                                                        <td style="padding-right: 5px; padding-top: 11px;" align="right" colspan="2">
                                                                                            <select name="do_links" size="1">
                                                    <option value="0">'.$admin_phrases[news][news_link_no].'</option>
                                                    <option value="del">'.$admin_phrases[news][news_link_delete].'</option>
                                                    <option value="up">'.$admin_phrases[news][news_link_up].'</option>
                                                    <option value="down">'.$admin_phrases[news][news_link_down].'</option>
                                                                                                        <option value="edit">'.$admin_phrases[news][news_link_edit].'</option>
                                                                                                </select>
                                                                                        </td>
                                                                                        <td style="padding-top: 11px;" align="center">
                                                <input class="button" type="submit" name="dolinkbutton" value="'.$admin_phrases[common][do_button].'">
                                                                                        </td>
                                                                                </tr>
                ';
        }

        if ( $EDIT['url'] == "" ) {
            $EDIT['url'] = "http://";
        }

        settype ( $EDIT['target'], "integer" );

        echo'
                                                                        </table>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                                                        <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[news][news_link_add].':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                                                                <tr>
                                                                                        <td class="config" style="padding-right: 5px;">
                                                '.$admin_phrases[news][news_link_title].':
                                                                                        </td>
                                                                                        <td class="config" style="padding-bottom: 4px;" width="100%">
                                                <input class="text" style="width: 100%;" maxlength="100" name="linkname['.$linkid.']" value="'.$EDIT['name'].'">
                                                                                        </td>
                                                                                        <td class="config"style="padding-left: 5px;">
                                                '.$admin_phrases[news][news_link_open].':
                                                                                        </td>
                                                                                </tr>
                                                                                <tr>
                                                                                        <td class="config">
                                                '.$admin_phrases[news][news_link_url].':
                                                                                        </td>
                                                                                        <td class="config" style="padding-bottom: 4px;">
                                                <input class="text" style="width: 100%;" maxlength="255" name="linkurl['.$linkid.']" value="'.$EDIT['url'].'">
                                                                                        </td>
                                                                                        <td style="padding-left: 5px;" valign="top">
                                                                                                <select name="linktarget['.$linkid.']" size="1">
                                                    <option value="0" '.getselected( 0, $EDIT['target'] ).'>'.$admin_phrases[news][news_link_self].'</option>
                                                    <option value="1" '.getselected( 1, $EDIT['target'] ).'>'.$admin_phrases[news][news_link_blank].'</option>
                                                                                                </select>
                                                                                        </td>
                                                                                        <td align="right" valign="top" style="padding-left: 10px;">
                                                                                                <input type="hidden" name="linknew['.$linkid.']" value="1">
                                                <input class="button" type="submit" name="addlink" value="'.$admin_phrases[common][add_button].'">
                                                                                        </td>
                                                                                </tr>
                                                                        </table>
                                                                </td>
                            </tr>
        ';
}

function action_edit_display_page ( $data_arr )
{
        global $db;
        global $global_config_arr;
        global $admin_phrases;

        $news_arr = $data_arr['news'];
        $date_arr = $data_arr['date'];
        $nowbutton_array = $data_arr['nowbutton'];
        $config_arr = $data_arr['config'];

    // Display Page
    echo'
                                        <form action="" method="post">
                                                <input type="hidden" name="go" value="news_edit">
                                                <input type="hidden" name="news_action" value="edit">
                                                <input type="hidden" name="news_id[]" value="'.$news_arr['news_id'].'">
                                                <input type="hidden" name="sended" value="edit">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="2">'.$admin_phrases[news][news_information_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][news_cat].':<br>
                                    <span class="small">'.$admin_phrases[news][news_cat_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="cat_id">
        ';
        // Kategorien auflisten
        $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat", $db );
        while ( $cat_arr = mysql_fetch_assoc ( $index ) )
        {
                settype ( $cat_arr['cat_id'], "integer" );
                echo '<option value="'.$cat_arr['cat_id'].'" '.getselected($cat_arr['cat_id'], $news_arr['cat_id']).'>'.$cat_arr['cat_name'].'</option>';
        }
        echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][news_date].':<br>
                                    <span class="small">'.$admin_phrases[news][news_date_desc].'</span>
                                </td>
                                <td class="config" valign="top">
                                                                        <span class="small">
                                                                                <input class="text center" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                            <input class="text center" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                            <input class="text center" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'"> '.$admin_phrases[common][at_time].'
                                            <input class="text center" size="3" maxlength="2" id="h" name="h" value="'.$date_arr['h'].'"> :
                                            <input class="text center" size="3" maxlength="2" id="i" name="i" value="'.$date_arr['i'].'"> '.$admin_phrases[common][time_appendix].'&nbsp;
                                                                        </span>
                                                                        '.js_nowbutton ( $nowbutton_array, $admin_phrases[common][now_button] ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[news][news_poster].':<br>
                                    <span class="small">'.$admin_phrases[news][news_poster_desc].'</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="poster" value="'.$news_arr['poster'].'">
                                    <input type="hidden" id="userid" name="user_id" value="'.$news_arr['user_id'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( "admin_finduser.php", 400, 400 ).'\' value="'.$admin_phrases[common][change_button].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                                                        <tr><td class="line" colspan="2">'.$admin_phrases[news][news_new_title].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[news][news_title].':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <input class="text" size="75" maxlength="255" id="news_title" name="news_title" value="'.$news_arr['news_title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                                                        
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                                                                        <td class="config top">
                                                '.$admin_phrases[news][news_text].':<br>
                                                                                                <span class="small">'.
                                                                                                $admin_phrases[common][html].' '.$config_arr[html_code].'. '.
                                                                                                $admin_phrases[common][fscode].' '.$config_arr[fs_code].'. '.
                                                                                                $admin_phrases[common][para].' '.$config_arr[para_handling].'.</span>
                                                                                        </td>
                                                                                        <td class="config right bottom">
                                                                                            <input class="pointer middle" type="checkbox" name="news_active" value="1" '.getchecked ( $news_arr['news_active'], 1 ).'>
                                                                                            <span class="small middle">'.$admin_phrases[news][news_active].'</span>&nbsp;&nbsp;
                                                                                            <input class="pointer middle" type="checkbox" name="news_comments_allowed" value="1" '.getchecked ( $news_arr['news_comments_allowed'], 1 ).'>
                                                                                            <span class="small middle">'.$admin_phrases[news][news_comments_allowed].'</span>
                                                                                        </td>
                                                                                </tr>
                                                                        </table>
                                                                        
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( "news_text", $news_arr['news_text'], "100%", "250px", "", FALSE).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <table cellpadding="0" cellspacing="0" width="100%">
    ';

        //Links
        $linkdata_arr = action_edit_display_links ( $news_arr['news_id'], $_POST );
        action_edit_display_new_link ( $linkdata_arr['num_links'], $linkdata_arr['edit'] );

        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <input class="button" type="button" onClick=\''.open_fullscreenpopup ( "admin_news_prev.php?i=".$linkdata_arr['num_links'] ).'\' value="'.$admin_phrases[common][preview_button].'">
                                </td>
                            </tr>
        ';

        echo'
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit" name="news_edit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

function action_delete_get_data ( $IDS )
{
    global $db;
    global $global_config_arr;
    global $admin_phrases;

    unset ($return_arr);

    foreach ( $IDS as $NEWS_ID ) {
        unset ($news_arr);
        settype ( $NEWS_ID, "integer" );

        $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news WHERE news_id = '".$NEWS_ID."'", $db );
        $news_arr = mysql_fetch_assoc ( $index );

        $news_arr['news_date_formated'] = "".$admin_phrases[common][on]." <b>" . date ( $admin_phrases[common][date_format] , $news_arr['news_date'] ) . "</b> ".$admin_phrases[common][at]." <b>" . date ( $admin_phrases[common][time_format] , $news_arr['news_date'] ) . "</b>";

        $index2 = mysql_query("SELECT COUNT(comment_id) AS 'number' FROM ".$global_config_arr['pref']."news_comments WHERE news_id = ".$news_arr['news_id']."", $db );
        $news_arr['num_comments'] = mysql_result ( $index2, 0, "number" );

        $index2 = mysql_query("SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$news_arr['user_id']."", $db );
        $news_arr['user_name'] = mysql_result ( $index2, 0, "user_name" );

        $index2 = mysql_query("SELECT cat_name FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = ".$news_arr['cat_id']."", $db );
        $news_arr['cat_name'] = mysql_result ( $index2, 0, "cat_name" );
        
        $return_arr[] = $news_arr;
    }
    
    return $return_arr;
}

function action_delete_display_page ( $return_arr )
{
        global $db;
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
        global $global_config_arr, $db, $TEXT;
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
                  $index = mysql_query ( "SELECT COUNT(comment_id) AS 'number' FROM ".$global_config_arr['pref']."news_comments WHERE news_id = ".$DATA['news_id']."", $db );
                  $number = mysql_result ( $index, 0, "number" );

                  if ( $number >= 1 ) {
                        $index = mysql_query ( "
                                                                        SELECT *
                                                                        FROM ".$global_config_arr['pref']."news_comments
                                                                        WHERE news_id = ".$DATA['news_id']."
                                                                        ORDER BY comment_date DESC
                        ", $db);

                        // Display Comment-List
                        while ( $comment_arr = mysql_fetch_assoc ( $index ) ) {

                                // Get other Data
                                if ( $comment_arr['comment_poster_id'] != 0 ) {
                                        $index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $db );
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
        global $db;
        global $global_config_arr;
        global $admin_phrases;

    settype ( $_POST['comment_id'], 'integer' );
    $index = mysql_query ( "
                                                        SELECT *
                                                        FROM ".$global_config_arr['pref']."news_comments
                                                        WHERE comment_id = ".$_POST['comment_id']."
        ", $db);
    $comment_arr = mysql_fetch_assoc ( $index );

        // Get other Data
        if ( $comment_arr['comment_poster_id'] != 0 ) {
                        $index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $db );
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
        global $global_config_arr, $db, $TEXT;
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
        ", $db);

        while ( $comment_arr = mysql_fetch_assoc ( $index ) ) {

            // Get other Data
            if ( $comment_arr['comment_poster_id'] != 0 ) {
                            $index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $db );
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

function db_edit_news ( $DATA )
{
    global $db;
    global $global_config_arr;
    global $admin_phrases;
    
    $DATA['news_text'] = savesql ( $DATA['news_text'] );
    $DATA['news_title'] = savesql ( $DATA['news_title'] );

    $DATA['news_id'] = $DATA['news_id'][0];
    settype ( $DATA['news_id'], "integer" );
    settype ( $DATA['cat_id'], "integer" );
    settype ( $DATA['user_id'], "integer" );
    settype ( $DATA['news_active'], "integer" );
    settype ( $DATA['news_comments_allowed'], "integer" );

    $date_arr = getsavedate ( $DATA['d'], $DATA['m'], $DATA['y'], $DATA['h'], $DATA['i'] );
    $newsdate = mktime ( $date_arr['h'], $date_arr['i'], 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );


    // MySQL-Update-Query
    mysql_query ( "
                    UPDATE
                            ".$global_config_arr['pref']."news
                    SET
                            cat_id = '".$DATA['cat_id']."',
                            user_id = '".$DATA['user_id']."',
                            news_date = '".$newsdate."',
                            news_title = '".$DATA['news_title']."',
                            news_text = '".$DATA['news_text']."',
                            news_active = '".$DATA['news_active']."',
                            news_comments_allowed = '".$DATA['news_comments_allowed']."',
                            news_search_update = '".time()."'
                    WHERE
                            news_id = '".$DATA['news_id']."'
    ", $db );
    
    // Update Search Index (or not)
    if ( $global_config_arr['search_index_update'] === 1 ) {
        // Include searchfunctions.php
        require_once ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
        update_search_index ( "news" );
    }
    

    // Delete all Links
    mysql_query ( "
                    DELETE FROM
                            ".$global_config_arr['pref']."news_links
                    WHERE
                            news_id = '".$DATA['news_id']."'
    ", $db );
                                 
    // Write Links into DB
    foreach ( $DATA['linkname'] as $key => $value ) {
        if ( $DATA['linkname'][$key] != "" && $DATA['linkurl'][$key] != "" ) {
            $DATA['linkname'][$key] = savesql ( $DATA['linkname'][$key] );
            $DATA['linkurl'][$key] = savesql ( $DATA['linkurl'][$key] );
            switch ( $DATA['linktarget'][$key] ) {
                case 1: settype ( $$DATA['linktarget'][$key], "integer" ); break;
                default: $DATA['linktarget'][$key] = 0; break;
            }

            mysql_query ( "
                INSERT INTO
                        ".$global_config_arr['pref']."news_links
                        (news_id, link_name, link_url, link_target)
                VALUES (
                        '".$DATA['news_id']."',
                        '".$DATA['linkname'][$key]."',
                        '".$DATA['linkurl'][$key]."',
                        '".$DATA['linktarget'][$key]."'
                )
            ", $db );
        }
    }

    systext( $admin_phrases[common][changes_saved], $admin_phrases[common][info], FALSE, $admin_phrases[icons][save_ok] );
}

function db_delete_news ( $DATA )
{
    global $db;
    global $global_config_arr;
    global $admin_phrases;

    if  ( $DATA['news_delete'] == 1 ) {
        foreach ( $DATA['news_id'] as $news_id ) {
            settype ( $news_id, "integer" );

            // MySQL-Delete-Query: News
            mysql_query ( "
                            DELETE FROM
                                    ".$global_config_arr['pref']."news
                            WHERE
                                    news_id = '".$news_id."'
                            LIMIT
                                    1
            ", $db );
            
            // Delete from Search Index
            require_once ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
            delete_search_index_for_one ( $news_id, "news" );

            // MySQL-Delete-Query: Links
            mysql_query ( "
                            DELETE FROM
                                    ".$global_config_arr['pref']."news_links
                            WHERE
                                    news_id = '".$news_id."'
            ", $db );

            // MySQL-Delete-Query: Comments
            mysql_query ( "
                            DELETE FROM
                                    ".$global_config_arr['pref']."news_comments
                            WHERE
                                    news_id = '".$news_id."'
            ", $db );
            $affacted_rows = mysql_affected_rows ( $db );

            // Update Counter
            mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET news = news - 1", $db );
            mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET comments = comments - ".$affacted_rows."", $db );
        }
        systext( $admin_phrases[news][news_deleted], $admin_phrases[common][info], FALSE, $admin_phrases[icons][trash_ok] );
    } else {
        systext( $admin_phrases[news][news_not_deleted], $admin_phrases[common][info], FALSE, $admin_phrases[icons][trash_error] );
    }
}

function db_edit_comment ( $DATA )
{
    global $db;
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
    ", $db );

    systext( $admin_phrases[common][changes_saved], $admin_phrases[common][info], FALSE, $admin_phrases[icons][save_ok] );
}

function db_delete_comment ( $DATA )
{
    global $db;
    global $global_config_arr;
    global $admin_phrases;

    $DATA['comment_id'] = array_map ( "intval", explode ( ",", $DATA['comment_id'] ) );

    // MySQL-Delete-Query: Comment
    mysql_query ( "
                    DELETE FROM
                            ".$global_config_arr['pref']."news_comments
                    WHERE
                            `comment_id` IN (".implode ( ",", $DATA['comment_id'] ).")
    ", $db );
    mysql_query ( "
                    UPDATE `".$global_config_arr['pref']."counter`
                    SET `comments` = `comments` - ".mysql_affected_rows ()."
    ", $db );

    systext( $admin_phrases[news][news_comment_deleted], $admin_phrases[common][info], FALSE, $admin_phrases[icons][trash_ok] );
}

//////////////////////////
//// Database Actions ////
//////////////////////////

// Edit News
if (
                isset ( $_POST['news_id'] ) &&
                count ( $_POST['news_id'] ) == 1 &&
                isset ( $_POST['sended'] ) && $_POST['sended'] == "edit" &&
                isset ( $_POST['news_action'] ) && $_POST['news_action'] == "edit" &&
                isset ( $_POST['news_edit'] ) &&

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
    db_edit_news ( $_POST );

    // Unset Vars
    unset ( $_POST );
    unset ( $_REQUEST );
}

// Delete News
elseif (
                isset ( $_POST['news_id'] ) &&
                isset ( $_POST['sended'] ) && $_POST['sended'] == "delete" &&
                isset ( $_POST['news_action'] ) && $_POST['news_action'] == "delete" &&
                isset ( $_POST['news_delete'] )
        )
{
    db_delete_news ( $_POST );

    // Unset Vars
    unset ( $_POST );
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
        $_POST['news_id'] = $_POST['news_id'][0];
        action_edit_display_page ( action_edit_get_data ( $_POST['news_id'] ) );
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
if ( $FILE_SHOW_START == TRUE )
{
        // Filter
        $_REQUEST = default_set_filter_data ( $_REQUEST );
        default_display_filter ( $_REQUEST );
        
        // Display Page
        default_display_page ( default_display_all_entries ( default_get_pagenav_data () ), default_get_pagenav_data (), $_REQUEST  );
}
?>
