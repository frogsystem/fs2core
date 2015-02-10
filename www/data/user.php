<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('id'));

///////////////////////////////////////////
//// Security Functions & Config Array ////
///////////////////////////////////////////
if ( isset ($_GET['userid']) && !isset($_GET['id']) ) {
    $_GET['id'] = $_GET['userid'];
}

$_GET['id'] = ( isset ( $_GET['id'] ) ? $_GET['id'] : $_GET['id'] );
$_GET['id'] = ( !$_GET['id'] && $_SESSION['user_id'] ? $_SESSION['user_id'] : $_GET['id'] );
settype ( $_GET['id'], 'integer');

$FD->loadConfig('users');
$config_arr = $FD->configObject('users')->getConfigArray();

//////////////////////
//// Show Profile ////
//////////////////////
$index = $FD->db()->conn()->query ( '
    SELECT *
    FROM `'.$FD->env('DB_PREFIX')."user`
    WHERE `user_id` = '".$_GET['id']."'" );
$user_arr = $index->fetch( PDO::FETCH_ASSOC );

if ( $user_arr!==false ) {
    $user_arr['user_name'] = kill_replacements ( $user_arr['user_name'], TRUE );
    $user_arr['user_image'] = ( image_exists ( '/user-images', $user_arr['user_id'] ) ? '<img src="'.image_url ( '/user-images', $user_arr['user_id'] ).'" alt="'.$FD->text('frontend', 'user_image_of').' '.$user_arr['user_name'].'">' : $FD->text('frontend', 'user_image_not_found') );
    $user_arr['user_mail'] = ( $user_arr['user_show_mail'] == 1 ? kill_replacements ( $user_arr['user_mail'], TRUE ) : '-' );
    $user_arr['user_is_staff_text'] = ( $user_arr['user_is_staff'] == 1 || $user_arr['user_is_admin'] == 1 ? $FD->text('frontend', "'yes'") : $FD->text('frontend', "'no'") );
    $user_arr['user_is_admin_text'] = ( $user_arr['user_is_admin'] == 1 ? $FD->text('frontend', "'yes'") : $FD->text('frontend', "'no'") );

    $user_arr['rank_data'] = get_user_rank ( $user_arr['user_group'], $user_arr['user_is_admin'] );
    $user_arr['user_rank'] = $user_arr['rank_data']['user_group_rank'];
    $user_arr['user_rank'] = ( $user_arr['user_rank'] == '' ) ? '-' : $user_arr['user_rank'];
    if ( $user_arr['user_group'] != 0 || ( $user_arr['user_group'] == 0 && $user_arr['user_is_admin'] == 1 ) ) {
        $user_arr['user_group_text'] = $user_arr['rank_data']['user_group_name'];
    } else {
        $user_arr['user_group_text'] = '-';
    }

    $user_arr['user_reg_date_text'] = date_loc ( $config_arr['reg_date_format'], $user_arr['user_reg_date'] );

    if (  $user_arr['user_homepage'] &&  trim ( $user_arr['user_homepage'] ) != 'http://' ) {
        $user_arr['user_homepage_link'] = '<a href="'.kill_replacements ( $user_arr['user_homepage']).'" target="_blank">'.kill_replacements ( $user_arr['user_homepage'], TRUE ).'</a>';
    } else {
        $user_arr['user_homepage_link'] = '-';
    }

    $user_arr['user_icq'] = ( $user_arr['user_icq'] != '' ? kill_replacements ( $user_arr['user_icq'], TRUE ) : '-' );
    $user_arr['user_aim'] = ( $user_arr['user_aim'] != '' ? kill_replacements ( $user_arr['user_aim'], TRUE ) : '-' );
    $user_arr['user_wlm'] = ( $user_arr['user_wlm'] != '' ? kill_replacements ( $user_arr['user_wlm'], TRUE ) : '-' );
    $user_arr['user_yim'] = ( $user_arr['user_yim'] != '' ? kill_replacements ( $user_arr['user_yim'], TRUE ) : '-' );
    $user_arr['user_skype'] = ( $user_arr['user_skype'] != '' ? kill_replacements ( $user_arr['user_skype'], TRUE ) : '-' );

    $index = $FD->db()->conn()->query ( '
        SELECT COUNT(`news_id`) AS `number`
        FROM `'.$FD->env('DB_PREFIX')."news`
        WHERE `user_id` = '".$user_arr['user_id']."'" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $user_arr['user_num_news'] = $row['number'];

    $index = $FD->db()->conn()->query ( '
        SELECT COUNT(`comment_id`) AS `number`
        FROM `'.$FD->env('DB_PREFIX')."comments`
        WHERE `comment_poster_id` = '".$user_arr['user_id']."'" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $user_arr['user_num_comments'] = $row['number'];

    $index = $FD->db()->conn()->query ( '
        SELECT COUNT(`article_id`) AS `number`
        FROM `'.$FD->env('DB_PREFIX')."articles`
        WHERE `article_user` = '".$user_arr['user_id']."'" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $user_arr['user_num_articles'] = $row['number'];

    $index = $FD->db()->conn()->query ( '
        SELECT COUNT(`dl_id`) AS `number`
        FROM `'.$FD->env('DB_PREFIX')."dl`
        WHERE `user_id` = '".$user_arr['user_id']."'" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $user_arr['user_num_downloads'] = $row['number'];


    // Create Template
    $template = new template();

    $template->setFile ( '0_user.tpl' );
    $template->load ( 'PROFILE' );

    $template->tag ( 'user_id', $user_arr['user_id'] );
    $template->tag ( 'user_name', $user_arr['user_name'] );
    $template->tag ( 'user_image', $user_arr['user_image'] );
    $template->tag ( 'user_image_url', image_url ( '/user-images', $user_arr['user_id'] ) );
    $template->tag ( 'user_rank', $user_arr['user_rank'] );
    $template->tag ( 'user_mail', $user_arr['user_mail'] );

    $template->tag ( 'user_is_staff', $user_arr['user_is_staff_text'] );
    $template->tag ( 'user_is_admin', $user_arr['user_is_admin_text'] );
    $template->tag ( 'user_group', $user_arr['user_group_text'] );
    $template->tag ( 'user_reg_date', $user_arr['user_reg_date_text'] );

    $template->tag ( 'user_homepage_link', $user_arr['user_homepage_link'] );
    $template->tag ( 'user_homepage_url', kill_replacements ( $user_arr['user_homepage'] ) );
    $template->tag ( 'user_icq', $user_arr['user_icq'] );
    $template->tag ( 'user_aim', $user_arr['user_aim'] );
    $template->tag ( 'user_wlm', $user_arr['user_wlm'] );
    $template->tag ( 'user_yim', $user_arr['user_yim'] );
    $template->tag ( 'user_skype', $user_arr['user_skype'] );

    $template->tag ( 'user_num_news', $user_arr['user_num_news'] );
    $template->tag ( 'user_num_comments', $user_arr['user_num_comments'] );
    $template->tag ( 'user_num_articles', $user_arr['user_num_articles'] );
    $template->tag ( 'user_num_downloads', $user_arr['user_num_downloads'] );

    $template = $template->display ();
}

///////////////////////////
//// User ID not found ////
///////////////////////////
else {
    $template = sys_message ( $FD->text('frontend', 'systemmessage'), $FD->text('frontend', 'user_not_found'), 404);
}
?>
