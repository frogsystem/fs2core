<?php
//////////////////////////
//// Locale Functions ////
//////////////////////////
function get_user_list_order ( $SORT, $GET_SORT, $GET_ORDER, $DEFAULT = 1 ) {
    $not_get_order = ( $GET_ORDER == 1 ) ? 0 : 1;
    return ( $SORT == $GET_SORT ) ? $not_get_order : $DEFAULT;
}

function get_user_list_arrows ( $SORT, $GET_SORT, $GET_ORDER ) {
    $arrow_direction = ( $GET_ORDER == 0 ) ? "down" : "up";
    return ( $SORT == $GET_SORT ) ? '<img src="$VAR(style_icons)user/arrow-' . $arrow_direction . '.gif" alt="">' : "";
}



///////////////////////////////////////////
//// Security Functions & Config Array ////
///////////////////////////////////////////
$_GET['order'] = ( in_array ( $_GET['order'], array ( "0", "desc", "DESC", "down", "DOWN" ) ) ) ? 0 : 1;
settype ( $_GET['order'], "integer" );

$_GET['sort'] = ( in_array ( $_GET['sort'], array ( "id", "name", "mail", "reg_date", "num_news", "num_comments", "num_articles", "num_downloads" ) ) ) ? $_GET['sort'] : "name";

$index = mysql_query ( "
    SELECT *
    FROM `".$global_config_arr['pref']."user_config`
    WHERE `id` = '1'
", $db );
$config_arr = mysql_fetch_assoc ( $index );


////////////////////////
//// Load User Data ////
////////////////////////
$user_arr = array ();

$index = mysql_query ( " SELECT `user_id`, `user_name`, `user_is_staff`, `user_is_admin`, `user_group`, `user_mail`, `user_show_mail`, `user_reg_date` FROM `".$global_config_arr['pref']."user` ORDER BY `user_name` ASC ", $db );

while ( $temp_arr = mysql_fetch_assoc ( $index ) ) {

    $data = mysql_query ( "
                                SELECT COUNT(`news_id`) AS 'number'
                                FROM `".$global_config_arr['pref']."news`
                                WHERE `user_id` = '".$temp_arr['user_id']."'
    ", $db);
    $temp_arr['user_num_news'] = mysql_result ( $data, 0, "number" );

    $data = mysql_query ( "
                                SELECT COUNT(`comment_id`) AS 'number'
                                FROM `".$global_config_arr['pref']."news_comments`
                                WHERE `comment_poster_id` = '".$temp_arr['user_id']."'
    ", $db);
    $temp_arr['user_num_comments'] = mysql_result ( $data, 0, "number" );

    $data = mysql_query ( "
                                SELECT COUNT(`article_id`) AS 'number'
                                FROM `".$global_config_arr['pref']."articles`
                                WHERE `article_user` = '".$temp_arr['user_id']."'
    ", $db);
    $temp_arr['user_num_articles'] = mysql_result ( $data, 0, "number" );

    $data = mysql_query ( "
                                SELECT COUNT(`dl_id`) AS 'number'
                                FROM `".$global_config_arr['pref']."dl`
                                WHERE `user_id` = '".$temp_arr['user_id']."'
    ", $db);
    $temp_arr['user_num_downloads'] = mysql_result ( $data, 0, "number" );

    $user_arr[] = $temp_arr;
}
foreach ( $user_arr as $key => $row ) {
    $col_id[$key]  = $row['user_id'];
    $col_name[$key] = $row['user_name'];
    $col_staff[$key] = $row['user_is_staff'];
    $col_admin[$key] = $row['user_is_admin'];
    $col_group[$key] = $row['user_group'];
    $col_mail[$key]  = $row['user_mail'];
    $col_show_mail[$key]  = $row['user_show_mail'];
    $col_reg_date[$key]  = $row['user_reg_date'];
    $col_num_news[$key]  = $row['user_num_news'];
    $col_num_comments[$key]  = $row['user_num_comments'];
    $col_num_articles[$key]  = $row['user_num_articles'];
    $col_num_downloads[$key]  = $row['user_num_downloads'];
}
$col_name_low = array_map ( 'strtolower', $col_name );
$col_mail_low = array_map ( 'strtolower', $col_mail );


////////////////////////
//// Sort User Data ////
////////////////////////
switch ( $_GET['sort'] ) {
    case "id": switch ( $_GET['order'] ) {
        case 0: array_multisort ( $col_id, SORT_DESC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_news, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
        default: array_multisort ( $col_id, SORT_ASC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_news, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
    }
    case "name": switch ( $_GET['order'] ) {
        case 0: array_multisort ( $col_name_low, SORT_DESC, SORT_STRING, $col_id, SORT_DESC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_news, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
        default: array_multisort ( $col_name_low, SORT_ASC, SORT_STRING, $col_id, SORT_ASC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_news, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
    }
    case "mail": switch ( $_GET['order'] ) {
        case 0: array_multisort ( $col_show_mail, SORT_ASC, $col_mail_low, SORT_DESC, SORT_STRING, $col_name_low, SORT_DESC, SORT_STRING, $col_id, SORT_DESC, SORT_NUMERIC, $col_mail, $col_name, $col_staff, $col_admin, $col_group, $col_reg_date, $col_num_news, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
        default: array_multisort ( $col_show_mail, SORT_DESC, $col_mail_low, SORT_ASC, SORT_STRING, $col_name_low, SORT_ASC, SORT_STRING, $col_id, SORT_ASC, SORT_NUMERIC, $col_mail, $col_name, $col_staff, $col_admin, $col_group, $col_reg_date, $col_num_news, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
    }
    case "reg_date": switch ( $_GET['order'] ) {
        case 0: array_multisort ( $col_reg_date, SORT_DESC, SORT_NUMERIC, $col_id, SORT_DESC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_num_news, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
        default: array_multisort ( $col_reg_date, SORT_ASC, SORT_NUMERIC, $col_id, SORT_ASC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_num_news, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
    }
    case "num_news": switch ( $_GET['order'] ) {
        case 0: array_multisort ( $col_num_news, SORT_DESC, SORT_NUMERIC, $col_name_low, SORT_DESC, SORT_STRING, $col_id, SORT_DESC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
        default: array_multisort ( $col_num_news, SORT_ASC, SORT_NUMERIC, $col_name_low, SORT_ASC, SORT_STRING, $col_id, SORT_ASC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_comments, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
    }
    case "num_comments": switch ( $_GET['order'] ) {
        case 0: array_multisort ( $col_num_comments, SORT_DESC, SORT_NUMERIC, $col_name_low, SORT_DESC, SORT_STRING, $col_id, SORT_DESC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_news, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
        default: array_multisort ( $col_num_comments, SORT_ASC, SORT_NUMERIC, $col_name_low, SORT_ASC, SORT_STRING, $col_id, SORT_ASC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_news, $col_num_articles, $col_num_downloads, $user_arr ); break 2;
    }
    case "num_articles": switch ( $_GET['order'] ) {
        case 0: array_multisort ( $col_num_articles, SORT_DESC, SORT_NUMERIC, $col_name_low, SORT_DESC, SORT_STRING, $col_id, SORT_DESC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_comments, $col_num_news, $col_num_downloads, $user_arr ); break 2;
        default: array_multisort ( $col_num_articles, SORT_ASC, SORT_NUMERIC, $col_name_low, SORT_ASC, SORT_STRING, $col_id, SORT_ASC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_comments, $col_num_news, $col_num_downloads, $user_arr ); break 2;
    }
    case "num_downloads": switch ( $_GET['order'] ) {
        case 0: array_multisort ( $col_num_downloads, SORT_DESC, SORT_NUMERIC, $col_name_low, SORT_DESC, SORT_STRING, $col_id, SORT_DESC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_comments, $col_num_articles, $col_num_news, $user_arr ); break 2;
        default: array_multisort ( $col_num_downloads, SORT_ASC, SORT_NUMERIC, $col_name_low, SORT_ASC, SORT_STRING, $col_id, SORT_ASC, SORT_NUMERIC, $col_name, $col_staff, $col_admin, $col_group, $col_mail, $col_show_mail, $col_reg_date, $col_num_comments, $col_num_articles, $col_num_news, $user_arr ); break 2;
    }
}


///////////////////////////
//// Display User List ////
///////////////////////////

// Get Number of Users
$config_arr['number_of_users'] = count ( $col_id );
if ( $config_arr['user_per_page'] == -1 ) {
    $config_arr['user_per_page'] = $config_arr['number_of_users'];
}
$config_arr['number_of_pages'] = ceil ( $config_arr['number_of_users'] / $config_arr['user_per_page'] );

$_GET['page'] = ( !isset ( $_GET['page'] ) || $_GET['page'] < 1 ) ? 1 : $_GET['page'];
$_GET['page'] = ( $_GET['page'] > $config_arr['number_of_pages'] ) ? 1 : $_GET['page'];

$config_arr['prev_page'] = $_GET['page']-1;
$config_arr['next_page'] = $_GET['page']+1;
$config_arr['page_start'] = $config_arr['prev_page'] * $config_arr['user_per_page'];

$maximum = $config_arr['page_start'] + $config_arr['user_per_page'];
$maximum = ( $maximum >= $config_arr['number_of_users'] ) ? $config_arr['number_of_users'] : $maximum;

// Get Page Nav
$template_page_nav = get_page_nav ( $_GET['page'], $config_arr['number_of_pages'], $config_arr['user_per_page'], $config_arr['number_of_users'], "?go=user_list&sort=".$_GET['sort']."&order=".$_GET['order']."&page={..page_num..}" );


// Create Sub-Template
$userline_template = new template();
$userline_template->setFile ( "0_user.tpl" );
$userline_template->load ( "USERLIST_USERLINE" );

$staffline_template = new template();
$staffline_template->setFile ( "0_user.tpl" );
$staffline_template->load ( "USERLIST_STAFFLINE" );

$adminline_template = new template();
$adminline_template->setFile ( "0_user.tpl" );
$adminline_template->load ( "USERLIST_ADMINLINE" );

// Get Lines
$lines = array();
for ( $i = $config_arr['page_start']; $i < $maximum; $i++ )
{
    if ( $col_staff[$i] == 1 ) {
        $line_template = $staffline_template;
    } elseif ( $col_admin[$i] == 1 ) {
        $line_template = $adminline_template;
    } else {
        $line_template = $userline_template;
    }

    $temp_rank_data = get_user_rank ( $col_group[$i], $col_admin[$i] );
    $temp_rank_data = $temp_rank_data['user_group_rank'];
    $temp_rank_data = ( $temp_rank_data == "" ) ? "-" : $temp_rank_data;

    $line_template->tag ( "user_id", $col_id[$i] );
    $line_template->tag ( "user_name", stripslashes ( $col_name[$i] ) );
    $line_template->tag ( "user_url", "?go=user&id=".$col_id[$i] );
    $line_template->tag ( "user_image", ( image_exists ( "media/user-images/", $col_id[$i] ) ) ? '<img src="'.image_url ( "media/user-images/", $col_id[$i] ).'" alt="'.$TEXT->get("user_image_of")." ".stripslashes ( $col_name[$i] ).'">' : $TEXT->get("user_image_not_found") );
    $line_template->tag ( "user_image_url", image_url ( "media/user-images/", $col_id[$i] ) );
    $line_template->tag ( "user_mail", ( $col_show_mail[$i] == 1 ) ? stripslashes ( $col_mail[$i] ) : "-" );
    $line_template->tag ( "user_rank", $temp_rank_data );
    $line_template->tag ( "user_reg_date", date_loc ( stripslashes ( $config_arr['user_list_reg_date_format'] ), $col_reg_date[$i] ) );
    $line_template->tag ( "user_num_news", $col_num_news[$i] );
    $line_template->tag ( "user_num_comments", $col_num_comments[$i] );
    $line_template->tag ( "user_num_articles", $col_num_articles[$i] );
    $line_template->tag ( "user_num_downloads", $col_num_downloads[$i] );

    $line_template = $line_template->display ();

    $lines[] = $line_template;
}

// Create Template
$template = new template();

$template->setFile ( "0_user.tpl" );
$template->load ( "USERLIST" );

$template->tag ( "page_nav", $template_page_nav );

$template->tag ( "order_id", get_user_list_order ( "id", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "order_name", get_user_list_order ( "name", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "order_mail", get_user_list_order ( "mail", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "order_reg_date", get_user_list_order ( "reg_date", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "order_num_news", get_user_list_order ( "num_news", $_GET['sort'], $_GET['order'], 0 ) );
$template->tag ( "order_num_comments", get_user_list_order ( "num_comments", $_GET['sort'], $_GET['order'], 0 ) );
$template->tag ( "order_num_articles", get_user_list_order ( "num_articles", $_GET['sort'], $_GET['order'], 0 ) );
$template->tag ( "order_num_downloads", get_user_list_order ( "num_downloads", $_GET['sort'], $_GET['order'], 0 ) );

$template->tag ( "arrow_id", get_user_list_arrows ( "id", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "arrow_name", get_user_list_arrows ( "name", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "arrow_mail", get_user_list_arrows ( "mail", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "arrow_reg_date", get_user_list_arrows ( "reg_date", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "arrow_num_news", get_user_list_arrows ( "num_news", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "arrow_num_comments", get_user_list_arrows ( "num_comments", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "arrow_num_articles", get_user_list_arrows ( "num_articles", $_GET['sort'], $_GET['order'] ) );
$template->tag ( "arrow_num_downloads", get_user_list_arrows ( "num_downloads", $_GET['sort'], $_GET['order'] ) );

$template->tag ( "user_lines", implode ( "
", $lines ) );
$template = $template->display ();
?>