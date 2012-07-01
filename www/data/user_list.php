<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('order', 'sort', 'page'));

/////////////////////////
//// Local Functions ////
/////////////////////////
function get_user_list_order ( $SORT, $GET_SORT, $GET_ORDER, $DEFAULT = 1 ) {
    $not_get_order = ( $GET_ORDER == 1 ) ? 0 : 1;
    $new_order = ( $SORT == $GET_SORT ) ? $not_get_order : $DEFAULT;
    return url('user_list', array('sort' => $SORT, 'order' => $new_order));
}

function get_user_list_arrows ( $SORT, $GET_SORT, $GET_ORDER ) {
    $arrow_direction = ( $GET_ORDER == 0 ) ? 'down' : 'up';
    return ( $SORT == $GET_SORT ) ? '<img src="$VAR(style_icons)arrow-' . $arrow_direction . '.gif" alt="">' : '';
}



///////////////////////////////////////////
//// Security Functions & Config Array ////
///////////////////////////////////////////
$_GET['order'] = ( in_array ( $_GET['order'], array ( '0', 'desc', 'DESC', 'down', 'DOWN' ) ) ) ? 0 : 1;
settype ( $_GET['order'], 'integer' );

$_GET['sort'] = ( in_array ( $_GET['sort'], array ( 'id', 'name', 'mail', 'reg_date', 'num_news', 'num_comments', 'num_articles', 'num_downloads' ) ) ) ? $_GET['sort'] : 'name';

$index = mysql_query ( '
    SELECT *
    FROM `'.$FD->config('pref')."user_config`
    WHERE `id` = '1'
", $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc ( $index );

// Get Number of Users
$index = mysql_query ( 'SELECT COUNT(`user_id`) AS num_users FROM `'.$FD->config('pref').'user`', $FD->sql()->conn() );
$row = mysql_fetch_assoc($index);
$config_arr['number_of_users'] = $row['num_users'];
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
$template_page_nav = get_page_nav ( $_GET['page'], $config_arr['number_of_pages'], $config_arr['user_per_page'], $config_arr['number_of_users'], url('user_list', array('sort' => $_GET['sort'], 'order' => $_GET['order'], 'page' => '{..page_num..}' )));


////////////////////////
//// Load User Data ////
////////////////////////
$pref = $FD->config('pref');
$query = 'SELECT `user_id`, `user_name`, `user_is_staff`, `user_is_admin`, `user_group`, `user_mail`, `user_show_mail`, `user_reg_date`,

  (SELECT COUNT(`news_id`) FROM `'.$pref.'news`
   WHERE `'.$pref.'news`.`user_id` = `'.$pref.'user`.`user_id`) AS user_num_news,

  (SELECT COUNT(`comment_id`) FROM `'.$pref.'news_comments`
   WHERE `comment_poster_id` = `'.$pref.'user`.`user_id`) AS user_num_comments,

  (SELECT COUNT(`article_id`) FROM `'.$pref.'articles`
   WHERE `article_user` = `'.$pref.'user`.`user_id`) AS user_num_articles,

  (SELECT COUNT(`dl_id`) FROM `'.$pref.'dl`
   WHERE `'.$pref.'dl`.`user_id` = `'.$pref.'user`.`user_id`) AS user_num_downloads

 FROM `'.$pref.'user` ORDER BY ';

////////////////////////
//// Sort User Data ////
////////////////////////
switch ( $_GET['sort'] ) {
    case 'id': switch ( $_GET['order'] ) {
        case 0: $query .= '`user_id` DESC'; break 2;
        default: $query .= '`user_id` ASC'; break 2;
    }
    case 'name': switch ( $_GET['order'] ) {
        case 0: $query .= '`user_name` DESC'; break 2;
        default: $query .= '`user_name` ASC'; break 2;
    }
    case 'mail': switch ( $_GET['order'] ) {
        case 0: $query .= '`user_show_mail` DESC, `user_mail` ASC'; break 2;
        default: $query .= '`user_show_mail` DESC, `user_mail` DESC'; break 2;
    }
    case 'reg_date': switch ( $_GET['order'] ) {
        case 0: $query .= '`user_reg_date` DESC'; break 2;
        default: $query .= '`user_reg_date` ASC'; break 2;
    }
    case 'num_news': switch ( $_GET['order'] ) {
        case 0: $query .= 'user_num_news DESC'; break 2;
        default: $query .= 'user_num_news ASC'; break 2;
    }
    case 'num_comments': switch ( $_GET['order'] ) {
        case 0: $query .= 'user_num_comments DESC'; break 2;
        default: $query .= 'user_num_comments ASC'; break 2;
    }
    case 'num_articles': switch ( $_GET['order'] ) {
        case 0: $query .= 'user_num_articles DESC'; break 2;
        default: $query .= 'user_num_articles ASC'; break 2;
    }
    case 'num_downloads': switch ( $_GET['order'] ) {
        case 0: $query .= 'user_num_downloads DESC'; break 2;
        default: $query .= 'user_num_downloads ASC'; break 2;
    }
}

$limit = ' LIMIT '.intval($config_arr['prev_page']*$config_arr['user_per_page']).','.((int)$config_arr['user_per_page']);

/*finally get the data... still may take several seconds for large user base
  and unfavourable sort criterion, but it should take less memory and execute
  faster than the previous code*/
$index = mysql_query ( $query.$limit, $FD->sql()->conn() );

///////////////////////////
//// Display User List ////
///////////////////////////

// Create Sub-Template
$userline_template = new template();
$userline_template->setFile ( '0_user.tpl' );
$userline_template->load ( 'USERLIST_USERLINE' );

$staffline_template = new template();
$staffline_template->setFile ( '0_user.tpl' );
$staffline_template->load ( 'USERLIST_STAFFLINE' );

$adminline_template = new template();
$adminline_template->setFile ( '0_user.tpl' );
$adminline_template->load ( 'USERLIST_ADMINLINE' );

// Get Lines
$lines = array();
while ( $row = mysql_fetch_assoc($index) )
{
    if ( $row['user_is_staff'] == 1 ) {
        $line_template = $staffline_template;
    } elseif ( $row['user_is_admin'] == 1 ) {
        $line_template = $adminline_template;
    } else {
        $line_template = $userline_template;
    }

    $temp_rank_data = get_user_rank ( $row['user_group'], $row['user_is_admin'] );
    $temp_rank_data = $temp_rank_data['user_group_rank'];
    $temp_rank_data = ( $temp_rank_data == '' ) ? '-' : $temp_rank_data;

    $line_template->tag ( 'user_id', $row['user_id'] );
    $line_template->tag ( 'user_name', kill_replacements ( $row['user_name'], TRUE ) );
    $line_template->tag ( 'user_url', url('user', array('id' => $row['user_id'])));
    $line_template->tag ( 'user_image', ( image_exists ( 'media/user-images/', $row['user_id'] ) ) ? '<img src="'.image_url ( 'media/user-images/', $row['user_id'] ).'" alt="'.$FD->text("frontend", "user_image_of").' '.kill_replacements ( $row['user_name'], TRUE ).'">' : $FD->text("frontend", "user_image_not_found") );
    $line_template->tag ( 'user_image_url', image_url ( 'media/user-images/', $row['user_id'] ) );
    $line_template->tag ( 'user_mail', ( $row['user_show_mail'] == 1 ) ? kill_replacements ( $row['user_mail'], TRUE ) : '-' );
    $line_template->tag ( 'user_rank', $temp_rank_data );
    $line_template->tag ( 'user_reg_date', date_loc ( stripslashes ( $config_arr['user_list_reg_date_format'] ), $row['user_reg_date'] ) );
    $line_template->tag ( 'user_num_news', $row['user_num_news'] );
    $line_template->tag ( 'user_num_comments', $row['user_num_comments'] );
    $line_template->tag ( 'user_num_articles', $row['user_num_articles'] );
    $line_template->tag ( 'user_num_downloads', $row['user_num_downloads'] );

    $line_template = $line_template->display ();

    $lines[] = $line_template;
}

// Create Template
$template = new template();

$template->setFile ( '0_user.tpl' );
$template->load ( 'USERLIST' );

$template->tag ( 'page_nav', $template_page_nav );

$template->tag ( 'order_id', get_user_list_order ( 'id', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'order_name', get_user_list_order ( 'name', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'order_mail', get_user_list_order ( 'mail', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'order_reg_date', get_user_list_order ( 'reg_date', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'order_num_news', get_user_list_order ( 'num_news', $_GET['sort'], $_GET['order'], 0 ) );
$template->tag ( 'order_num_comments', get_user_list_order ( 'num_comments', $_GET['sort'], $_GET['order'], 0 ) );
$template->tag ( 'order_num_articles', get_user_list_order ( 'num_articles', $_GET['sort'], $_GET['order'], 0 ) );
$template->tag ( 'order_num_downloads', get_user_list_order ( 'num_downloads', $_GET['sort'], $_GET['order'], 0 ) );

$template->tag ( 'arrow_id', get_user_list_arrows ( 'id', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'arrow_name', get_user_list_arrows ( 'name', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'arrow_mail', get_user_list_arrows ( 'mail', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'arrow_reg_date', get_user_list_arrows ( 'reg_date', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'arrow_num_news', get_user_list_arrows ( 'num_news', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'arrow_num_comments', get_user_list_arrows ( 'num_comments', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'arrow_num_articles', get_user_list_arrows ( 'num_articles', $_GET['sort'], $_GET['order'] ) );
$template->tag ( 'arrow_num_downloads', get_user_list_arrows ( 'num_downloads', $_GET['sort'], $_GET['order'] ) );

$template->tag ( 'user_lines', implode ( '
', $lines ) );
$template = $template->display ();
?>
