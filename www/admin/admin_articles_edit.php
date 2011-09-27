<?php
/////////////////////
//// Load Config ////
/////////////////////
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_config WHERE `id` = '1'", $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc ( $index );

///////////////////
//// Functions ////
///////////////////
function default_set_filter_data ( $FORM )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

    if ( !isset ( $FORM['order'] ) ) { $FORM['order'] = "article_title"; }
    if ( !isset ( $FORM['sort'] ) ) { $FORM['sort'] = "ASC"; }
    if ( !isset ( $FORM['cat_id'] ) ) { $FORM['cat_id'] = 0; }

    $FORM['order'] = savesql ( $FORM['order'] );
    $FORM['sort'] = savesql ( $FORM['sort'] );
    settype ( $FORM['cat_id'], "integer" );

    return $FORM;
}

function default_display_filter ( $FORM )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

    echo'
                                        <form action="" method="post">
                        <input type="hidden" value="articles_edit" name="go">

                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="3">'.$admin_phrases[articles][edit_filter_title].'</td></tr>
                                                        <tr>
                                <td class="config" width="100%" colspan="2">
                                                                        '.$admin_phrases[articles][edit_filter_from].'
                                    <select name="cat_id">
                                            <option value="0" '.getselected( 0, $FORM['cat_id'] ).'>'.$admin_phrases[articles][edit_filter_all_cat].'</option>
        ';
                                                                            // List Categories
                                                                            $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_cat", $FD->sql()->conn() );
                                                                            while ( $cat_arr = mysql_fetch_assoc ( $index ) )
                                                                            {
                                                                                        settype ( $cat_arr['cat_id'], "integer" );
                                                                                        echo '<option value="'.$cat_arr['cat_id'].'" '.getselected( $cat_arr['cat_id'], $FORM['cat_id'] ).'>'.$cat_arr['cat_name'].'</option>';
                                                                            }
        echo'
                                    </select>
                                                                        <br><br>'.$admin_phrases[articles][edit_filter_sort].'
                                    <select name="order">
                                        <option value="article_id" '.getselected ( "article_id", $FORM['order'] ).'>Artikel-ID</option>
                                        <option value="article_date" '.getselected ( "article_date", $FORM['order'] ).'>'.$admin_phrases[articles][edit_filter_date].'</option>
                                        <option value="article_title" '.getselected ( "article_title", $FORM['order'] ).'>'.$admin_phrases[articles][edit_filter_arttitle].'</option>
                                        <option value="article_url" '.getselected ( "article_url", $FORM['order'] ).'>'.$admin_phrases[articles][edit_filter_url].'</option>
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
        $where_clause = "WHERE article_cat_id = '".$_REQUEST['cat_id']."'";
    }

        // Create Pagenavigation
    $index = mysql_query ( "
                                                        SELECT COUNT(article_id) AS 'number'
                                                        FROM ".$global_config_arr['pref']."articles
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
        $next_page = '<a href="'.$PHP_SELF.'?go=articles_edit&order='.$_REQUEST['order'].'&sort='.$_REQUEST['sort'].'&cat_id='.$_REQUEST['cat_id'].'&start='.$pagenav_arr['new_start'].'">'.$admin_phrases[articles][edit_next_article].' »</a>';
    }
    if ( $pagenav_arr['old_start_exists'] )
    {
        $prev_page = '<a href="'.$PHP_SELF.'?go=articles_edit&order='.$_REQUEST['order'].'&sort='.$_REQUEST['sort'].'&cat_id='.$_REQUEST['cat_id'].'&start='.$pagenav_arr['old_start'].'">« '.$admin_phrases[articles][edit_prev_article].'</a>';
    }

    // Current Range
    $range_begin = $pagenav_arr['cur_start'] + 1;
    $range_end = $pagenav_arr['cur_start'] + $pagenav_arr['entries_per_page'];
        if ( $range_end > $pagenav_arr['total_entries'] )
        {
        $range_end = $pagenav_arr['total_entries'];
        }
    $range = '<span class="small">'.$admin_phrases[articles][edit_show_articles].'<br><b>'.$range_begin.'</b> '.$admin_phrases[common][to].' <b>'.$range_end.'</b></span>';

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
        $pagenav = $admin_phrases[articles][edit_no_articles];
        }

    return $pagenav;
}

function default_get_entry_data ( $articles_arr )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;
        global $config_arr;

        // Load Data From DB
        switch($config_arr['acp_view']) {
            case 1:
                $fields = "`article_id`, `article_title`, `article_date`, `article_text`, `article_user`, `article_url`, `article_cat_id`";
                break;
            case 2:
                $fields = "`article_id`, `article_title`, `article_date`, `article_user`, `article_url`, `article_cat_id`";
                break;
            default:
                $fields = "`article_id`, `article_title`, `article_url`";
                break;
        }
        
        
        $index = mysql_query ( "
                                SELECT ".$fields."
                                FROM ".$global_config_arr['pref']."articles
                                WHERE `article_id` = '".$articles_arr['article_id']."'
                                LIMIT 0,1
        ", $FD->sql()->conn() );     
        $articles_arr = mysql_fetch_assoc($index);

        // Prepare Data
        $articles_arr['article_title'] = killhtml ( $articles_arr['article_title'] );
        
        if ( $articles_arr['article_url'] != "" ) {
                $articles_arr['article_url'] = '?go=' . $articles_arr['article_url'];
        } else {
            $articles_arr['article_url'] = "";
        }        
        
        // Only for full and extended view
        if ($config_arr['acp_view'] == 1 || $config_arr['acp_view'] == 2) {
            if ( $articles_arr['article_date'] != 0 ) {
                $articles_arr['article_date_formated'] = "".$admin_phrases[common][on_date]." <b>" . date ( $admin_phrases[common][date_format] , $articles_arr['article_date'] ) . "</b>,";
            } else {
                $articles_arr['article_date_formated'] = "";
            }
            
            if ( $articles_arr['article_user'] != 0 ) {
                $index2 = mysql_query("SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$articles_arr['article_user']."", $FD->sql()->conn() );
                $articles_arr['user_name'] = $admin_phrases[common][by] .' <b>' . mysql_result ( $index2, 0, "user_name" ) . '</b>,';
            } else {
                $articles_arr['user_name'] = "";
            }
            
             $index2 = mysql_query("SELECT cat_name FROM ".$global_config_arr['pref']."articles_cat WHERE cat_id = ".$articles_arr['article_cat_id']."", $FD->sql()->conn() );
            $articles_arr['cat_name'] = mysql_result ( $index2, 0, "cat_name" );
        }
        
        // Only for full view
        if ($config_arr['acp_view'] == 1) {
            $articles_arr['article_text_short'] = truncate_string ( killfs (  $articles_arr['article_text'] ) , 250, "..." );
        }

        return $articles_arr;
}

function default_display_entry ( $articles_arr )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;
        global $config_arr;

        // Display Article Entry
        $entry = '
                                                        <tr class="pointer" id="tr_'.$articles_arr['article_id'].'"
                                                                onmouseover="'.color_list_entry ( "input_".$articles_arr['article_id'], "#EEEEEE", "#64DC6A", "this" ).'"
                                                                onmouseout="'.color_list_entry ( "input_".$articles_arr['article_id'], "transparent", "#49c24f", "this" ).'"
                                onclick="'.color_click_entry ( "input_".$articles_arr['article_id'], "#EEEEEE", "#64DC6A", "this", TRUE ).'"
                                                        >
                                                                <td>
                                                                    <table cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                        <td class="config" style="width: 100%; padding-right: 25px; padding-bottom: 4px;">
                                                            <span style="float: left;">'.killhtml ( $articles_arr['article_title'] ).'</span>
                                                            <span style="float: right;">'.$articles_arr['article_url'].' (#'.$articles_arr['article_id'].')</span>
        ';
        if ( $config_arr['acp_view'] == 1 || $config_arr['acp_view'] == 2 ) {
                $entry .= '
                                                                                                <br>
                                                            <span class="small">'.$articles_arr['user_name'].'
                                                                                                '.$articles_arr['article_date_formated'].'
                                                                                                '.$admin_phrases[common][in].' <b>'.$articles_arr['cat_name'].'</b></span>
                ';
        }
        $entry .= '
                                                        </td>
                                                        <td class="config middle center" rowspan="2">
                                                            <input class="pointer" type="radio" name="article_id" id="input_'.$articles_arr['article_id'].'" value="'.$articles_arr['article_id'].'"
                                                                                                        onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$articles_arr['article_id'], TRUE ).'"
                                                                                                >
                                                        </td>
                                                                                </tr>
        ';
        if ( $config_arr['acp_view'] == 1 ) {
                $entry .= '
                                                                                <tr>
                                                        <td class="config justify" style="padding-right: 25px;">
                                                            <span class="small">'.$articles_arr['article_text_short'].'</span>
                                                        </td>
                                                                                </tr>
                ';
        }
        $entry .= '
                                                                        </table>
                                                                </td>
                            </tr>
    ';

    return $entry;
}

function default_display_all_entries ( $pagenav_arr )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

        unset ( $entries );

        // Create Where Clause for Category Filter
        unset ( $where_clause );
        if ( $_REQUEST['cat_id'] != 0 )
            {
            $where_clause = "WHERE article_cat_id = '".$_REQUEST['cat_id']."'";
        }

        // Load News From DB
        $index = mysql_query ( "
                                                        SELECT `article_id`
                                                        FROM ".$global_config_arr['pref']."articles
                                                        ".$where_clause."
                                                        ORDER BY ".$_REQUEST['order']." ".$_REQUEST['sort'].", article_title ASC
                                                        LIMIT ".$pagenav_arr['cur_start'].", ".$pagenav_arr['entries_per_page']."
        ", $FD->sql()->conn() );

    while ($articles_arr = mysql_fetch_assoc($index))
    {
                $entries .= default_display_entry ( default_get_entry_data ( $articles_arr ) );
    }

    return $entries;
}

function default_display_page ( $entries, $pagenav_arr, $FORM )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

        // Display News List Header
    echo'
                    <form action="" method="post">
                        <input type="hidden" name="go" value="articles_edit">
                        <input type="hidden" name="order" value="'.$FORM['order'].'" >
                        <input type="hidden" name="sort" value="'.$FORM['sort'].'">
                        <input type="hidden" name="cat_id" value="'.$FORM['cat_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="4">'.$admin_phrases[articles][edit_select_article].' ('.$pagenav_arr['total_entries'].' '.$admin_phrases[articles][edit_entries_found].')</td></tr>

    ';

    echo $entries;

    // Display News List Footer
    echo'
                                                        <tr><td class="space"></td></tr>
                        </table>
                                                '.default_display_pagenav ( default_get_pagenav_data () ).'
           ';

        // End of Form & Table incl. Submit-Button
         echo '
                      <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td class="right">
                                                                        <select name="article_action" size="1">
                                                                                <option value="edit">'.$admin_phrases[common][selection_edit].'</option>
                                                                                <option value="delete">'.$admin_phrases[common][selection_del].'</option>
                                                                        </select>
                                                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
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

function action_edit_get_data ( $ARTICLE_ID )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

    //Load Article
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles WHERE article_id = '".$ARTICLE_ID."' LIMIT 0, 1", $FD->sql()->conn() );
    $articles_arr = mysql_fetch_assoc ( $index );
    $old_url = $articles_arr['article_url'];
    
        // Sended or Link Action
        if ( isset ( $_POST['sended'] ) ) {
        $articles_arr = getfrompost ( $articles_arr );
            $articles_arr['d'] = $_POST['d'];
            $articles_arr['m'] = $_POST['m'];
            $articles_arr['y'] = $_POST['y'];
            
            if (
                isset ($articles_arr['article_url']) &&
                trim($articles_arr['article_url']) != "" &&
                ($index2 = mysql_query("SELECT `article_id` FROM `".$global_config_arr['pref']."articles` WHERE `article_url` = '".savesql($articles_arr['article_url'])."'", $FD->sql()->conn())) !== FALSE &&
                mysql_num_rows($index2) != 0 &&
                mysql_result($index2, 0, "article_id") != $ARTICLE_ID
            ) {
                systext ( $admin_phrases[articles][existing_url], $admin_phrases[common][error], TRUE );
            } else {
                systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
            }
        }
    $articles_arr['article_old_url'] = $old_url;

    // Load Article Config
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_config", $FD->sql()->conn() );
    $config_arr = mysql_fetch_assoc ( $index );

        // Create HTML, FSCode & Para-Handling Vars
    $config_arr[html_code_bool] = ($config_arr[html_code] == 2 || $config_arr[html_code] == 4);
    $config_arr[fs_code_bool] = ($config_arr[fs_code] == 2 || $config_arr[fs_code] == 4);
    $config_arr[para_handling_bool] = ($config_arr[para_handling] == 2 || $config_arr[para_handling] == 4);

    $config_arr[html_code_text] = ( $config_arr[html_code_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];
    $config_arr[fs_code_text] = ( $config_arr[fs_code_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];
    $config_arr[para_handling_text] = ( $config_arr[para_handling_bool] ) ? $admin_phrases[common][on] : $admin_phrases[common][off];

        // Security-Functions
    $articles_arr['article_url'] = killhtml ( $articles_arr['article_url'] );
    $articles_arr['article_title'] = killhtml ( $articles_arr['article_title'] );
        $articles_arr['article_text'] = killhtml ( $articles_arr['article_text'] );
        settype ( $articles_arr['article_user'], "integer" );
    settype ( $articles_arr['article_html'], "integer" );
        settype ( $articles_arr['article_fscode'], "integer" );
    settype ( $articles_arr['article_para'], "integer" );
        settype ( $articles_arr['article_cat_id'], "integer" );

    // Get User
        if ( $articles_arr['article_user'] != 0 ) {
                $index = mysql_query ( "SELECT user_name, user_id FROM ".$global_config_arr['pref']."user WHERE user_id = '".$articles_arr['article_user']."'", $FD->sql()->conn() );
            $articles_arr['article_user_name'] = killhtml ( mysql_result ( $index, 0, "user_name" ) );
        } else {
            $articles_arr['article_user_name'] = "";
        }

        // Create Date-Arrays
    if ( !isset ( $_POST['sended'] ) && $articles_arr['article_date'] != 0 )
    {
            $articles_arr['d'] = date ( "d", $articles_arr['article_date'] );
            $articles_arr['m'] = date ( "m", $articles_arr['article_date'] );
            $articles_arr['y'] = date ( "y", $articles_arr['article_date'] );
        }
        $date_arr = getsavedate ( $articles_arr['d'], $articles_arr['m'], $articles_arr['y'], 0, 0, 0, TRUE );
        $nowbutton_array = array( "d", "m", "y" );

        // Data into Data-Array
        $data_arr['articles'] = $articles_arr;
        $data_arr['date'] = $date_arr;
        $data_arr['nowbutton'] = $nowbutton_array;
        $data_arr['config'] = $config_arr;

        return $data_arr;
}

function action_edit_display_page ( $data_arr )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

        $articles_arr = $data_arr['articles'];
        $date_arr = $data_arr['date'];
        $nowbutton_array = $data_arr['nowbutton'];
        $config_arr = $data_arr['config'];

    // Display Page
    echo'
                                        <form action="" method="post">
                                                <input type="hidden" name="go" value="articles_edit">
                                                <input type="hidden" name="article_action" value="edit">
                                                <input type="hidden" name="article_id" value="'.$articles_arr['article_id'].'">
                                                <input type="hidden" name="article_old_url" value="'.$articles_arr['article_old_url'].'">
                        <input type="hidden" name="sended" value="edit">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="2">'.$admin_phrases[articles][articles_info_title].'</td></tr>
                            <tr>
                                <td class="config" width="250">
                                    '.$admin_phrases[articles][articles_url].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_url_desc].'</span>
                                </td>
                                <td class="config" width="350">
                                    ?go = <input class="text" size="45" maxlength="100" name="article_url" value="'.$articles_arr['article_url'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_cat].':<br>
                                    <span class="small">'.$admin_phrases[articles][articles_cat_desc].'</span>
                                </td>
                                <td class="config">
                                    <select name="article_cat_id">
        ';
        // Kategorien auflisten
        $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_cat", $FD->sql()->conn() );
        while ( $cat_arr = mysql_fetch_assoc ( $index ) )
        {
                    settype ( $cat_arr['cat_id'], "integer" );
                    echo '<option value="'.$cat_arr['cat_id'].'" '.getselected($cat_arr['cat_id'], $articles_arr['article_cat_id']).'>'.$cat_arr['cat_name'].'</option>';
        }
        echo'
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_date].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_date_desc].'</span>
                                </td>
                                <td class="config">
                                                                        <span class="small">
                                                                                <input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                            <input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                            <input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'">&nbsp;
                                                                        </span>
                                                                        '.js_nowbutton ( $nowbutton_array, $admin_phrases[common][today] ).'
                                    <input onClick=\'document.getElementById("d").value="";
                                                     document.getElementById("m").value="";
                                                     document.getElementById("y").value="";\' class="button" type="button" value="'.$admin_phrases[common][delete_button].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[articles][articles_poster].': <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">'.$admin_phrases[articles][articles_poster_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="article_user_name" value="'.$articles_arr['article_user_name'].'">
                                    <input type="hidden" id="userid" name="article_user" value="'.$articles_arr['article_user'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( "?go=find_user", 400, 400 ).'\' value="'.$admin_phrases[common][change_button].'">
                                    <input onClick=\'document.getElementById("username").value="";
                                                     document.getElementById("userid").value="0";\' class="button" type="button" value="'.$admin_phrases[common][delete_button].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                                                        <tr><td class="line" colspan="2">'.$admin_phrases[articles][articles_new_title].'</td></tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.$admin_phrases[articles][articles_title].':
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    <input class="text" size="75" maxlength="255" name="article_title" id="article_title" value="'.$articles_arr['article_title'].'"><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">

                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                                                                        <td class="config">
                                                                                                '.$admin_phrases[articles][articles_text].':
                                                                                        </td>
                                                                                        <td class="config" style="text-align:right;">
        ';

        if ( $config_arr[html_code_bool] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_html" id="article_html" value="1" '.getchecked ( 1, $articles_arr['article_html'] ).'>
                <span class="small middle">'.$admin_phrases[articles][articles_use_html].'</span>&nbsp;&nbsp;';
        } else {
            echo '<input class="middle" type="checkbox" name="article_html" id="article_html" value="0" disabled="disabled">
                <span class="small middle">'.$admin_phrases[common][html].' '.$config_arr[html_code_text].'</span>&nbsp;&nbsp;';
        }
        if ( $config_arr[fs_code_bool] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_fscode" id="article_fscode" value="1" '.getchecked ( 1, $articles_arr['article_fscode'] ).'>
                <span class="small middle">'.$admin_phrases[articles][articles_use_fscode].'</span>&nbsp;&nbsp;';
        } else {
            echo '<input class="middle" type="checkbox" name="article_fscode" id="article_fscode" value="0" disabled="disabled">
                <span class="small middle">'.$admin_phrases[common][fscode].' '.$config_arr[fs_code_text].'</span>&nbsp;&nbsp;';
        }
        if ( $config_arr[para_handling_bool] ) {
            echo '<input class="pointer middle" type="checkbox" name="article_para" id="article_para" value="1" '.getchecked ( 1, $articles_arr['article_para'] ).'>
                <span class="small middle">'.$admin_phrases[articles][articles_use_para].'</span>';
        } else {
            echo '<input class="middle" type="checkbox" name="article_para" id="article_para" value="0" disabled="disabled">
                <span class="small middle">'.$admin_phrases[common][para].' '.$config_arr[para_handling_text].'</span>';
        }

        echo '
                                                                                        </td>
                                                                                </tr>
                                                                        </table>

                                </td>
                            </tr>
                            <tr>
                                <td class="config" colspan="2">
                                    '.create_editor ( "article_text", $articles_arr['article_text'], "100%", "500px", "", FALSE).'
                                </td>
                            </tr>
                            <tr>
                                                                <td class="config" colspan="2">
                                    <input class="button" type="button" onClick=\'popTab("?go=article_preview", "_blank")\' value="'.$admin_phrases[common][preview_button].'">
                                                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit" name="news_edit" value="1">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}

function action_delete_get_data ( $ARTICLE_ID )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

        settype ( $ARTICLE_ID, "integer" );

        $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles WHERE article_id = '".$ARTICLE_ID."'", $FD->sql()->conn() );
        $articles_arr = mysql_fetch_assoc ( $index );

        // Get other Data
        if ( $articles_arr['article_date'] != 0 ) {
        $articles_arr['article_date_formated'] = "".$admin_phrases[common][on]." <b>" . date ( $admin_phrases[common][date_format] , $articles_arr['article_date'] ) . "</b>,";
        } else {
            $articles_arr['article_date_formated'] = "";
        }

    $articles_arr['article_text_short'] = truncate_string ( killfs (  $articles_arr['article_text'] ) , 250, "..." );

        if ( $articles_arr['article_user'] != 0 ) {
            $index2 = mysql_query("SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$articles_arr['article_user']."", $FD->sql()->conn() );
            $articles_arr['user_name'] = $admin_phrases[common][by_posted] .' <b>' . mysql_result ( $index2, 0, "user_name" ) . '</b>,';
        } else {
            $articles_arr['user_name'] = "";
        }
        
        if ( $articles_arr['article_url'] != "" ) {
                $articles_arr['article_url'] = '?go=' . $articles_arr['article_url'];
        } else {
            $articles_arr['article_url'] = "";
        }
        
        $index2 = mysql_query("SELECT cat_name FROM ".$global_config_arr['pref']."articles_cat WHERE cat_id = ".$articles_arr['article_cat_id']."", $FD->sql()->conn() );
    $articles_arr['cat_name'] = mysql_result ( $index2, 0, "cat_name" );
    
    return $articles_arr;
}

function action_delete_display_page ( $articles_arr )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

        echo '
                                        <form action="" method="post">
                                                <input type="hidden" name="sended" value="delete">
                                                <input type="hidden" name="article_action" value="'.$_POST['article_action'].'">
                                                <input type="hidden" name="article_id" value="'.$articles_arr['article_id'].'">
                                                <input type="hidden" name="go" value="articles_edit">
                                                <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line">'.$admin_phrases[articles][delete_title].'</td></tr>
                                                        <tr>
                                <td class="config" width="100%" style="padding-bottom: 4px;">
                                    <span style="float: left;">'.$articles_arr['article_title'].'</span>
                                    <span style="float: right;">'.$articles_arr['article_url'].' (#'.$articles_arr['article_id'].')</span><br>
                                    <span class="small">'.$articles_arr['user_name'].'
                                                                        '.$articles_arr['article_date_formated'].'
                                                                        '.$admin_phrases[common][in].' <b>'.$articles_arr['cat_name'].'</b></span>
                                </td>
                                                        </tr>
                                                        <tr>
                                <td class="config justify">
                                    <span class="small">'.$articles_arr['article_text_short'].'</span>
                                </td>
                                                        </tr>
                                                        <tr>
                                <td class="config right">
                                    <a href="'.$global_config_arr['virtualhost'].'?go=articles&id='.$articles_arr['article_id'].'" target="_blank">» '.$admin_phrases[articles][delete_view_article].'</a></div>
                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                                                </table>
                                                <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr>
                                                                <td class="config" style="width: 100%;">
                                                                        '.$admin_phrases[articles][delete_question].'
                                                                </td>
                                                                <td class="config right top" style="padding: 0px;">
                                                                    <table width="100%" cellpadding="4" cellspacing="0">
                                                                                <tr class="bottom pointer" id="tr_yes"
                                                                                        onmouseover="'.color_list_entry ( "del_yes", "#EEEEEE", "#64DC6A", "this" ).'"
                                                                                        onmouseout="'.color_list_entry ( "del_yes", "transparent", "#49C24f", "this" ).'"
                                                                                        onclick="'.color_click_entry ( "del_yes", "#EEEEEE", "#64DC6A", "this", TRUE ).'"
                                                                                >
                                                                                        <td>
                                                                                                <input class="pointer" type="radio" name="article_delete" id="del_yes" value="1"
                                                    onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_yes", TRUE ).'"
                                                                                                >
                                                                                        </td>
                                                                                        <td class="config middle">
                                                                                                '.$admin_phrases[common][yes].'
                                                                                        </td>
                                                                                </tr>
                                                                                <tr class="bottom red pointer" id="tr_no"
                                                                                        onmouseover="'.color_list_entry ( "del_no", "#EEEEEE", "#DE5B5B", "this" ).'"
                                                                                        onmouseout="'.color_list_entry ( "del_no", "transparent", "#C24949", "this" ).'"
                                                                                        onclick="'.color_click_entry ( "del_no", "#EEEEEE", "#DE5B5B", "this", TRUE ).'"
                                                                                >
                                                                                        <td>
                                                                                                <input class="pointer" type="radio" name="article_delete" id="del_no" value="0" checked="checked"
                                                    onclick="'.color_click_entry ( "this", "#EEEEEE", "#DE5B5B", "tr_no", TRUE ).'"
                                                                                                >
                                                                                        </td>
                                                                                        <td class="config middle">
                                                                                                '.$admin_phrases[common][no].'
                                                                                        </td>
                                                                                </tr>
                                                                                '.color_pre_selected ( "del_no", "tr_no" ).'
                                                                        </table>
                                                                </td>
                                                        </tr>
                                                        <tr><td class="space"></td></tr>
                                                        <tr>
                                                                <td class="buttontd" colspan="2">
                                                                        <button class="button_new" type="submit">
                                                                                '.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
                                                                        </button>
                                                                </td>
                                                        </tr>
                                                </table>
                                        </form>
        ';
}

function db_edit_article ( $DATA )
{
    global $FD, $global_config_arr, $admin_phrases;

    // No User
    if ( !isset ( $DATA['article_user'] ) ) {
        $DATA['article_user'] = 0;
    }

    // Security Functions
    $DATA['article_url'] = savesql ( trim ( $DATA['article_url'] ) );
    $DATA['article_title'] = savesql ( $DATA['article_title'] );
    $DATA['article_text'] = savesql ( $DATA['article_text'] );

    settype ( $DATA['article_cat_id'], "integer" );
    settype ( $DATA['article_html'], "integer" );
    settype ( $DATA['article_user'], "integer" );
    settype ( $DATA['article_fscode'], "integer" );
    settype ( $DATA['article_para'], "integer" );

    // Create Date
    if ( $DATA['d'] != "" && $DATA['m'] != "" && $DATA['y'] != "" ) {
        $date_arr = getsavedate ( $DATA['d'], $DATA['m'], $DATA['y'] );
        $articledate = mktime ( 0, 0, 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );
    } else {
        $articledate = 0;
    }

    // MySQL-Update-Query
    mysql_query ("
                    UPDATE
                            ".$global_config_arr['pref']."articles
                    SET
                            article_url = '".$DATA['article_url']."',
                            article_title = '".$DATA['article_title']."',
                            article_date = '".$articledate."',
                            article_user = '".$DATA['article_user']."',
                            article_text = '".$DATA['article_text']."',
                            article_html = '".$DATA['article_html']."',
                            article_fscode = '".$DATA['article_fscode']."',
                            article_para = '".$DATA['article_para']."',
                            article_cat_id = '".$DATA['article_cat_id']."',
                            article_search_update = '".time()."'
                    WHERE
                        article_id = '".$DATA['article_id']."'
    ", $FD->sql()->conn() );
    
    // Update Search Index (or not)
    if ( $global_config_arr['search_index_update'] === 1 ) {
        // Include searchfunctions.php
        require_once ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
        update_search_index ( "articles" );
    }

    systext( $admin_phrases[common][changes_saved], $admin_phrases[common][info]);
}

function db_delete_article ( $DATA )
{
        global $FD;
        global $global_config_arr;
        global $admin_phrases;

        if  ( $DATA['article_delete'] == 1 ) {
        
            settype ( $DATA['article_id'], "integer" );

            // MySQL-Delete-Query: News
            mysql_query ( "
                            DELETE FROM
                                    ".$global_config_arr['pref']."articles
                            WHERE
                                    article_id = '".$DATA['article_id']."'
                            LIMIT
                                1
            ", $FD->sql()->conn() );
            
            // Delete from Search Index
            require_once ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
            delete_search_index_for_one ( $DATA['article_id'], "articles" );
            

            // Update Counter
            mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET artikel = artikel - 1", $FD->sql()->conn() );

            systext( $admin_phrases[articles][article_deleted], $admin_phrases[common][info]);
        } else {
            systext( $admin_phrases[articles][article_not_deleted], $admin_phrases[common][info]);
        }
}


///////////////////////////////
//// Constructor Functions ////
///////////////////////////////


//////////////////////////
//// Database Actions ////
//////////////////////////

// Edit Article
if (
        isset ( $_POST['article_id'] ) &&
        isset ( $_POST['sended'] ) &&
        isset ( $_POST['article_action'] ) && $_POST['article_action'] == "edit" &&

        isset ( $_POST['article_cat_id'] ) &&
        $_POST['article_title'] && $_POST['article_title'] != "" &&
        
        isset ($_POST['article_url']) &&
        (trim($_POST['article_url']) == "" ||
            (
                settype($_POST['article_id'], "integer") &&
                ($index = mysql_query("SELECT `article_id` FROM `".$global_config_arr['pref']."articles` WHERE `article_url` = '".savesql($_POST['article_url'])."'", $FD->sql()->conn())) !== FALSE &&
                (mysql_num_rows($index) == 0 || mysql_result($index, 0, "article_id") == $_POST['article_id'])
            )
        ) &&

        ( ( $_POST['d'] && $_POST['d'] > 0 && $_POST['d'] <= 31 ) || ( $_POST['d'] == "" && $_POST['m'] == "" && $_POST['y'] == "" ) ) &&
        ( ( $_POST['m'] && $_POST['m'] > 0 && $_POST['m'] <= 12 ) || ( $_POST['d'] == "" && $_POST['m'] == "" && $_POST['y'] == "" ) ) &&
        ( ( $_POST['y'] && $_POST['y'] > 0 ) || ( $_POST['d'] == "" && $_POST['m'] == "" && $_POST['y'] == "" ) )
    )
{
    db_edit_article ( $_POST );

    // Unset Vars
    unset ( $_POST );
    unset ( $_REQUEST );
}

// Delete Article
elseif (
        isset ( $_POST['article_id'] ) &&
        isset ( $_POST['sended'] ) && $_POST['sended'] == "delete" &&
        isset ( $_POST['article_action'] ) && $_POST['article_action'] == "delete" &&
        isset ( $_POST['article_delete'] )
    )
{
    db_delete_article ( $_POST );

    // Unset Vars
    unset ( $_POST );;
    unset ( $_REQUEST );
}

//////////////////////////////
//// Display Action-Pages ////
//////////////////////////////
if ( $_POST['article_id'] && $_POST['article_action'] )
{
    // Edit Article
    if ( $_POST['article_action'] == "edit" )
    {
        action_edit_display_page ( action_edit_get_data ( $_POST['article_id'] ) );
    }

    // Delete Article
    elseif ( $_POST['article_action'] == "delete" )
    {
        $articles_arr = action_delete_get_data ( $_POST['article_id'] );
        action_delete_display_page ( $articles_arr );
    }
}

////////////////////////////////////////////
//// Display Default Articles List Page ////
////////////////////////////////////////////
else
{
    // Filter
    $_REQUEST = default_set_filter_data ( $_REQUEST );
    default_display_filter ( $_REQUEST );

    // Display Page
    default_display_page ( default_display_all_entries ( default_get_pagenav_data () ), default_get_pagenav_data (), $_REQUEST  );
}
?>
