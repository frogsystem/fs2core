<?php
///////////////////////////////////////////
//// Security Functions & Config Array ////
///////////////////////////////////////////
if ( isset ($_GET['userid']) && !isset($_GET['id']) ) {
    $_GET['id'] = $_GET['userid'];
}

$_GET['id'] = ( isset ( $_GET['id'] ) ? $_GET['id'] : $_GET['id'] );
$_GET['id'] = ( !$_GET['id'] && $_SESSION['user_id'] ? $_SESSION['user_id'] : $_GET['id'] );
settype ( $_GET['id'], "integer");

$index = mysql_query ( "
    SELECT *
    FROM `".$global_config_arr['pref']."user_config`
    WHERE `id` = '1'
", $db );
$config_arr = mysql_fetch_assoc ( $index );

$index = mysql_query ( "
    SELECT *
    FROM `".$global_config_arr['pref']."user`
    WHERE `user_id` = '".$_GET['id']."'
", $db );

//////////////////////
//// Show Profile ////
//////////////////////
if ( mysql_num_rows ( $index ) > 0 ) {
    $user_arr = mysql_fetch_assoc ( $index );

    $user_arr['user_name'] = stripslashes ( $user_arr['user_name'] );
    $user_arr['user_image'] = ( image_exists ( "media/user-images/", $user_arr['user_id'] ) ? '<img src="'.image_url ( "media/user-images/", $user_arr['user_id'] ).'" alt="'.$TEXT->get("user_image_of")." ".$user_arr['user_name'].'">' : $TEXT['frontend']->get("user_image_not_found") );
    $user_arr['user_mail'] = ( $user_arr['user_show_mail'] == 1 ? stripslashes ( $user_arr['user_mail'] ) : "-" );
    $user_arr['user_is_staff_text'] = ( $user_arr['user_is_staff'] == 1 || $user_arr['user_is_admin'] == 1 ? $phrases['yes'] : $phrases['no'] );
    $user_arr['user_is_admin_text'] = ( $user_arr['user_is_admin'] == 1 ? $phrases['yes'] : $phrases['no'] );
    
    $user_arr['rank_data'] = get_user_rank ( $user_arr['user_group'] );
    $user_arr['user_rank'] = $user_arr['rank_data']['user_group_rank'];
    if ( $user_arr['user_group'] != 0 || ( $user_arr['user_group'] == 0 && $user_arr['user_is_admin'] == 1 ) ) {
        $user_arr['user_group_text'] = $user_arr['rank_data']['user_group_name'];
    } else {
        $user_arr['user_group_text'] = "-";
    }
    
    $user_arr['user_reg_date_text'] = date_loc ( stripslashes ( $config_arr['reg_date_format'] ), $user_arr['user_reg_date'] );

    if (  $user_arr['user_homepage'] &&  trim ( $user_arr['user_homepage'] ) != "http://" ) {
        $user_arr['user_homepage_link'] = '<a href="'.stripslashes ( $user_arr['user_homepage'] ).'" target="_blank">'.$user_arr['user_homepage'].'</a>';
    } else {
        $user_arr['user_homepage_link'] = "-";
    }
    
    $user_arr['user_icq'] = ( $user_arr['user_icq'] != "" ? stripslashes ( $user_arr['user_icq'] ) : "-" );
    $user_arr['user_aim'] = ( $user_arr['user_aim'] != "" ? stripslashes ( $user_arr['user_aim'] ) : "-" );
    $user_arr['user_wlm'] = ( $user_arr['user_wlm'] != "" ? stripslashes ( $user_arr['user_wlm'] ) : "-" );
    $user_arr['user_yim'] = ( $user_arr['user_yim'] != "" ? stripslashes ( $user_arr['user_yim'] ) : "-" );
    $user_arr['user_skype'] = ( $user_arr['user_skype'] != "" ? stripslashes ( $user_arr['user_skype'] ) : "-" );

    $index = mysql_query ( "
        SELECT COUNT(`news_id`) AS `number`
        FROM `".$global_config_arr['pref']."news`
        WHERE `user_id` = '".$user_arr['user_id']."'
    ", $db );
    $user_arr['user_num_news'] = mysql_result ( $index, 0, "number" );
    
    $index = mysql_query ( "
        SELECT COUNT(`comment_id`) AS `number`
        FROM `".$global_config_arr['pref']."news_comments`
        WHERE `comment_poster_id` = '".$user_arr['user_id']."'
    ", $db );
    $user_arr['user_num_comments'] = mysql_result ( $index, 0, "number" );

    $index = mysql_query ( "
        SELECT COUNT(`article_id`) AS `number`
        FROM `".$global_config_arr['pref']."articles`
        WHERE `article_user` = '".$user_arr['user_id']."'
    ", $db );
    $user_arr['user_num_articles'] = mysql_result ( $index, 0, "number" );

    $index = mysql_query ( "
        SELECT COUNT(`dl_id`) AS `number`
        FROM `".$global_config_arr['pref']."dl`
        WHERE `user_id` = '".$user_arr['user_id']."'
    ", $db );
    $user_arr['user_num_downloads'] = mysql_result ( $index, 0, "number" );


    // Create Template
    $template = new template();

    $template->setFile ( "0_user.tpl" );
    $template->load ( "PROFILE" );

    $template->tag ( "user_id", $user_arr['user_id'] );
    $template->tag ( "user_name", $user_arr['user_name'] );
    $template->tag ( "user_image", $user_arr['user_image'] );
    $template->tag ( "user_image_url", image_url ( "media/user-images/", $user_arr['user_id'] ) );
    $template->tag ( "user_rank", $user_arr['user_rank'] );
    $template->tag ( "user_mail", $user_arr['user_mail'] );

    $template->tag ( "user_is_staff", $user_arr['user_is_staff_text'] );
    $template->tag ( "user_is_admin", $user_arr['user_is_admin_text'] );
    $template->tag ( "user_group", $user_arr['user_group_text'] );
    $template->tag ( "user_reg_date", $user_arr['user_reg_date_text'] );

    $template->tag ( "user_homepage_link", $user_arr['user_homepage_link'] );
    $template->tag ( "user_homepage_url", stripslashes ( $user_arr['user_homepage'] ) );
    $template->tag ( "user_icq", $user_arr['user_icq'] );
    $template->tag ( "user_aim", $user_arr['user_aim'] );
    $template->tag ( "user_wlm", $user_arr['user_wlm'] );
    $template->tag ( "user_yim", $user_arr['user_yim'] );
    $template->tag ( "user_skype", $user_arr['user_skype'] );

    $template->tag ( "user_num_news", $user_arr['user_num_news'] );
    $template->tag ( "user_num_comments", $user_arr['user_num_comments'] );
    $template->tag ( "user_num_articles", $user_arr['user_num_articles'] );
    $template->tag ( "user_num_downloads", $user_arr['user_num_downloads'] );

    $template = $template->display ();
}

///////////////////////////
//// User ID not found ////
///////////////////////////
else {
    $template = sys_message ( $TEXT->get("systemmessage"), $TEXT->get("user_not_found") );
}
?>