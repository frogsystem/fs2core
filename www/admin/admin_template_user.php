<?php
$TEMPLATE_GO = 'tpl_user';
$TEMPLATE_FILE = '0_user.tpl';
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
    'name' => 'APPLET_LOGIN',
    'title' => $FD->text("template", "user_applet_login_title"),
    'description' => $FD->text("template", "user_applet_login_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array ()
);

$TEMPLATE_EDIT[] = array (
    'name' => 'APPLET_ADMINLINE',
    'title' => $FD->text("template", "user_applet_adminline_title"),
    'description' => $FD->text("template", "user_applet_adminline_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'admincp_link', 'text' => $FD->text("template", "user_applet_adminline_admincp_link") ),
        array ( 'tag' => 'admincp_url', 'text' => $FD->text("template", "user_applet_adminline_admincp_url") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'APPLET_MENU',
    'title' => $FD->text("template", "user_applet_menu_title"),
    'description' => $FD->text("template", "user_applet_menu_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'user_id', 'text' => $FD->text("template", "user_profile_user_id")),
        array ( 'tag' => 'user_name', 'text' => $FD->text("template", "user_profile_user_name") ),
        array ( 'tag' => 'user_image', 'text' => $FD->text("template", "user_profile_user_image") ),
        array ( 'tag' => 'user_image_url', 'text' => $FD->text("template", "user_profile_user_image_url") ),
        array ( 'tag' => 'admincp_line', 'text' => $FD->text("template", "user_applet_menu_admincp_line") ),
        array ( 'tag' => 'user_edit_url', 'text' => $FD->text("template", "user_applet_menu_user_edit_url") ),
        array ( 'tag' => 'logout_url', 'text' => $FD->text("template", "user_applet_menu_logout_url") ),
    )
);


$TEMPLATE_EDIT[] = array (
    'name' => 'LOGIN',
    'title' => $FD->text("template", "user_login_title"),
    'description' => $FD->text("template", "user_login_desc"),
    'rows' => 30,
    'cols' => 66,
    'help' => array ()
);

$TEMPLATE_EDIT[] = array (
    'name' => 'NEW_PASSWORD',
    'title' => $FD->text("template", "new_password_title"),
    'description' => $FD->text("template", "new_password_desc"),
    'rows' => 30,
    'cols' => 66,
    'help' => array ()
);


$TEMPLATE_EDIT[] = array (
    'name' => 'REGISTER',
    'title' => $FD->text("template", "user_register_title"),
    'description' => $FD->text("template", "user_register_desc"),
    'rows' => 30,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'captcha_line', 'text' => $FD->text("template", "user_register_captcha_line") ),
        array ( 'tag' => 'captcha_url', 'text' => $FD->text("template", "user_register_captcha_url") ),
        array ( 'tag' => 'captcha_text', 'text' => $FD->text("template", "user_register_captcha_text") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'CAPTCHA_LINE',
    'title' => $FD->text("template", "user_captcha_line_title"),
    'description' => $FD->text("template", "user_captcha_line_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'captcha_url', 'text' => $FD->text("template", "user_register_captcha_url") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'CAPTCHA_TEXT',
    'title' => $FD->text("template", "user_captcha_text_title"),
    'description' => $FD->text("template", "user_captcha_text_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array ()
);

$TEMPLATE_EDIT[] = array (
    'name' => 'PROFILE',
    'title' => $FD->text("template", "user_profile_title"),
    'description' => $FD->text("template", "user_profile_desc"),
    'rows' => 30,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'user_id', 'text' => $FD->text("template", "user_profile_user_id") ),
        array ( 'tag' => 'user_name', 'text' => $FD->text("template", "user_profile_user_name") ),
        array ( 'tag' => 'user_image', 'text' => $FD->text("template", "user_profile_user_image") ),
        array ( 'tag' => 'user_image_url', 'text' => $FD->text("template", "user_profile_user_image_url") ),
        array ( 'tag' => 'user_rank', 'text' => $FD->text("template", "user_profile_user_rank") ),
        array ( 'tag' => 'user_mail', 'text' => $FD->text("template", "user_profile_user_mail") ),
        array ( 'tag' => 'user_is_staff', 'text' => $FD->text("template", "user_profile_user_is_staff") ),
        array ( 'tag' => 'user_is_admin', 'text' => $FD->text("template", "user_profile_user_is_admin") ),
        array ( 'tag' => 'user_group', 'text' => $FD->text("template", "user_profile_user_group") ),
        array ( 'tag' => 'user_reg_date', 'text' => $FD->text("template", "user_profile_user_reg_date") ),
        array ( 'tag' => 'user_homepage_link', 'text' => $FD->text("template", "user_profile_user_homepage_link") ),
        array ( 'tag' => 'user_homepage_url', 'text' => $FD->text("template", "user_profile_user_homepage_url") ),
        array ( 'tag' => 'user_icq', 'text' => $FD->text("template", "user_profile_user_icq") ),
        array ( 'tag' => 'user_aim', 'text' => $FD->text("template", "user_profile_user_aim") ),
        array ( 'tag' => 'user_wlm', 'text' => $FD->text("template", "user_profile_user_wlm") ),
        array ( 'tag' => 'user_yim', 'text' => $FD->text("template", "user_profile_user_yim") ),
        array ( 'tag' => 'user_skype', 'text' => $FD->text("template", "user_profile_user_skype") ),
        array ( 'tag' => 'user_num_news', 'text' => $FD->text("template", "user_profile_user_num_news") ),
        array ( 'tag' => 'user_num_comments', 'text' => $FD->text("template", "user_profile_user_num_comments") ),
        array ( 'tag' => 'user_num_articles', 'text' => $FD->text("template", "user_profile_user_num_articles") ),
        array ( 'tag' => 'user_num_downloads', 'text' => $FD->text("template", "user_profile_user_num_downloads") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'USERRANK',
    'title' => $FD->text("template", "user_rank_title"),
    'description' => $FD->text("template", "user_rank_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'group_name', 'text' => $FD->text("template", "user_rank_group_name") ),
        array ( 'tag' => 'group_image', 'text' => $FD->text("template", "user_rank_group_image") ),
        array ( 'tag' => 'group_image_url', 'text' => $FD->text("template", "user_rank_group_image_url") ),
        array ( 'tag' => 'group_title', 'text' => $FD->text("template", "user_rank_group_title") ),
        array ( 'tag' => 'group_title_text_only', 'text' => $FD->text("template", "user_rank_title_text_only") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'PROFILE_EDIT',
    'title' => $FD->text("template", "user_profile_edit_title"),
    'description' => $FD->text("template", "user_profile_edit_desc"),
    'rows' => 30,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'user_id', 'text' => $FD->text("template", "user_profile_user_id") ),
        array ( 'tag' => 'user_name', 'text' => $FD->text("template", "user_profile_user_name") ),
        array ( 'tag' => 'user_image', 'text' => $FD->text("template", "user_profile_user_image") ),
        array ( 'tag' => 'user_image_url', 'text' => $FD->text("template", "user_profile_user_image_url") ),
        array ( 'tag' => 'image_max_width', 'text' => $FD->text("template", "user_profile_edit_image_max_width") ),
        array ( 'tag' => 'image_max_height', 'text' => $FD->text("template", "user_profile_edit_image_max_height") ),
        array ( 'tag' => 'image_max_size', 'text' => $FD->text("template", "user_profile_edit_image_max_size") ),
        array ( 'tag' => 'image_limits_text', 'text' => $FD->text("template", "user_profile_edit_image_limits_text") ),
        array ( 'tag' => 'user_mail', 'text' => $FD->text("template", "user_profile_user_mail") ),
        array ( 'tag' => 'show_mail_checked', 'text' => $FD->text("template", "user_profile_edit_show_mail_checked") ),
        array ( 'tag' => 'user_homepage_url', 'text' => $FD->text("template", "user_profile_user_homepage_url") ),
        array ( 'tag' => 'user_icq', 'text' => $FD->text("template", "user_profile_user_icq") ),
        array ( 'tag' => 'user_aim', 'text' => $FD->text("template", "user_profile_user_aim") ),
        array ( 'tag' => 'user_wlm', 'text' => $FD->text("template", "user_profile_user_wlm") ),
        array ( 'tag' => 'user_yim', 'text' => $FD->text("template", "user_profile_user_yim") ),
        array ( 'tag' => 'user_skype', 'text' => $FD->text("template", "user_profile_user_skype") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'USERLIST',
    'title' => $FD->text("template", "user_list_title"),
    'description' => $FD->text("template", "user_list_desc"),
    'rows' => 30,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'user_lines', 'text' => $FD->text("template", "user_list_lines") ),
        array ( 'tag' => 'page_nav', 'text' => $FD->text("template", "page_nav_help") ),
        /*array ( 'tag' => 'page_nav_2', 'text' => $FD->text("template", "page_nav_2_help") ),
        array ( 'tag' => 'page_nav_3', 'text' => $FD->text("template", "page_nav_3_help") ),
        array ( 'tag' => 'page_nav_4', 'text' => $FD->text("template", "page_nav_4_help") ),
        array ( 'tag' => 'page_nav_5', 'text' => $FD->text("template", "page_nav_5_help") ),     */
        array ( 'tag' => 'order_id', 'text' => $FD->text("template", "user_list_order_id") ),
        array ( 'tag' => 'order_name', 'text' => $FD->text("template", "user_list_order_name") ),
        array ( 'tag' => 'order_mail', 'text' => $FD->text("template", "user_list_order_mail") ),
        array ( 'tag' => 'order_reg_date', 'text' => $FD->text("template", "user_list_order_date") ),
        array ( 'tag' => 'order_num_news', 'text' => $FD->text("template", "user_list_order_news") ),
        array ( 'tag' => 'order_num_comments', 'text' => $FD->text("template", "user_list_order_comments") ),
        array ( 'tag' => 'order_num_articles', 'text' => $FD->text("template", "user_list_order_articles") ),
        array ( 'tag' => 'order_num_downloads', 'text' => $FD->text("template", "user_list_order_downloads") ),
        array ( 'tag' => 'arrow_id', 'text' => $FD->text("template", "user_list_arrow_id") ),
        array ( 'tag' => 'arrow_name', 'text' => $FD->text("template", "user_list_arrow_name") ),
        array ( 'tag' => 'arrow_mail', 'text' => $FD->text("template", "user_list_arrow_mail") ),
        array ( 'tag' => 'arrow_reg_date', 'text' => $FD->text("template", "user_list_arrow_date") ),
        array ( 'tag' => 'arrow_num_news', 'text' => $FD->text("template", "user_list_arrow_news") ),
        array ( 'tag' => 'arrow_num_comments', 'text' => $FD->text("template", "user_list_arrow_comments") ),
        array ( 'tag' => 'arrow_num_articles', 'text' => $FD->text("template", "user_list_arrow_articles") ),
        array ( 'tag' => 'arrow_num_downloads', 'text' => $FD->text("template", "user_list_arrow_downloads") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'USERLIST_USERLINE',
    'title' => $FD->text("template", "user_list_userline_title"),
    'description' => $FD->text("template", "user_list_userline_desc"),
    'rows' => 20,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'user_id', 'text' => $FD->text("template", "user_profile_user_id") ),
        array ( 'tag' => 'user_name', 'text' => $FD->text("template", "user_profile_user_name") ),
        array ( 'tag' => 'user_url', 'text' => $FD->text("template", "user_list_line_user_url") ),
        array ( 'tag' => 'user_image', 'text' => $FD->text("template", "user_profile_user_image") ),
        array ( 'tag' => 'user_image_url', 'text' => $FD->text("template", "user_profile_user_image_url") ),
        array ( 'tag' => 'user_mail', 'text' => $FD->text("template", "user_profile_user_mail") ),
        array ( 'tag' => 'user_rank', 'text' => $FD->text("template", "user_profile_user_rank") ),
        array ( 'tag' => 'user_reg_date', 'text' => $FD->text("template", "user_profile_user_reg_date") ),
        array ( 'tag' => 'user_num_news', 'text' => $FD->text("template", "user_profile_user_num_news") ),
        array ( 'tag' => 'user_num_comments', 'text' => $FD->text("template", "user_profile_user_num_comments") ),
        array ( 'tag' => 'user_num_articles', 'text' => $FD->text("template", "user_profile_user_num_articles") ),
        array ( 'tag' => 'user_num_downloads', 'text' => $FD->text("template", "user_profile_user_num_downloads") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'USERLIST_STAFFLINE',
    'title' => $FD->text("template", "user_list_staffline_title"),
    'description' => $FD->text("template", "user_list_staffline_desc"),
    'rows' => 20,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'user_id', 'text' => $FD->text("template", "user_profile_user_id") ),
        array ( 'tag' => 'user_name', 'text' => $FD->text("template", "user_profile_user_name") ),
        array ( 'tag' => 'user_url', 'text' => $FD->text("template", "user_list_line_user_url") ),
        array ( 'tag' => 'user_image', 'text' => $FD->text("template", "user_profile_user_image") ),
        array ( 'tag' => 'user_image_url', 'text' => $FD->text("template", "user_profile_user_image_url") ),
        array ( 'tag' => 'user_mail', 'text' => $FD->text("template", "user_profile_user_mail") ),
        array ( 'tag' => 'user_rank', 'text' => $FD->text("template", "user_profile_user_rank") ),
        array ( 'tag' => 'user_reg_date', 'text' => $FD->text("template", "user_profile_user_reg_date") ),
        array ( 'tag' => 'user_num_news', 'text' => $FD->text("template", "user_profile_user_num_news") ),
        array ( 'tag' => 'user_num_comments', 'text' => $FD->text("template", "user_profile_user_num_comments") ),
        array ( 'tag' => 'user_num_articles', 'text' => $FD->text("template", "user_profile_user_num_articles") ),
        array ( 'tag' => 'user_num_downloads', 'text' => $FD->text("template", "user_profile_user_num_downloads") ),
    )
);


$TEMPLATE_EDIT[] = array (
    'name' => 'USERLIST_ADMINLINE',
    'title' => $FD->text("template", "user_list_adminline_title"),
    'description' => $FD->text("template", "user_list_adminline_desc"),
    'rows' => 20,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'user_id', 'text' => $FD->text("template", "user_profile_user_id") ),
        array ( 'tag' => 'user_name', 'text' => $FD->text("template", "user_profile_user_name") ),
        array ( 'tag' => 'user_url', 'text' => $FD->text("template", "user_list_line_user_url") ),
        array ( 'tag' => 'user_image', 'text' => $FD->text("template", "user_profile_user_image") ),
        array ( 'tag' => 'user_image_url', 'text' => $FD->text("template", "user_profile_user_image_url") ),
        array ( 'tag' => 'user_mail', 'text' => $FD->text("template", "user_profile_user_mail") ),
        array ( 'tag' => 'user_rank', 'text' => $FD->text("template", "user_profile_user_rank") ),
        array ( 'tag' => 'user_reg_date', 'text' => $FD->text("template", "user_profile_user_reg_date") ),
        array ( 'tag' => 'user_num_news', 'text' => $FD->text("template", "user_profile_user_num_news") ),
        array ( 'tag' => 'user_num_comments', 'text' => $FD->text("template", "user_profile_user_num_comments") ),
        array ( 'tag' => 'user_num_articles', 'text' => $FD->text("template", "user_profile_user_num_articles") ),
        array ( 'tag' => 'user_num_downloads', 'text' => $FD->text("template", "user_profile_user_num_downloads") ),
    )
);

// Init Template-Page
echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE );
?>
