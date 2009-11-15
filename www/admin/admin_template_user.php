<?php
    $TEMPLATE_GO = "tpl_user";
    $TEMPLATE_FILE = "0_user.tpl";
    $TEMPLATE_EDIT = null;
    
    $tmp[name] = "APPLET_LOGIN";
    $tmp[title] = $admin_phrases[template][user_mini_login][title];
    $tmp[description] = $admin_phrases[template][user_mini_login][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "APPLET_MENU";
    $tmp[title] = $admin_phrases[template][user_user_menu][title];
    $tmp[description] = $admin_phrases[template][user_user_menu][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "user_name";
        $tmp[help][0][text] = $admin_phrases[template][user_user_menu][help_1] ;
        $tmp[help][1][tag] = "user_id";
        $tmp[help][2][tag] = "user_image";
        $tmp[help][3][tag] = "user_image_url";
        $tmp[help][4][tag] = "admincp_line";
        $tmp[help][4][text] = "" ;
        $tmp[help][5][tag] = "user_edit_url";
        $tmp[help][5][text] = "" ;
        $tmp[help][6][tag] = "logout_url";
        $tmp[help][6][text] = "" ;



    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "APPLET_ADMINLINK";
    $tmp[title] = $admin_phrases[template][user_admin_link][title];
    $tmp[description] = $admin_phrases[template][user_admin_link][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][][tag] = "admincp_link";
        $tmp[help][1][tag] = "admincp_url";
        $tmp[help][1][text] = $admin_phrases[template][user_admin_link][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp[name] = "LOGIN";
    $tmp[title] = $admin_phrases[template][user_login][title];
    $tmp[description] = $admin_phrases[template][user_login][description];
    $tmp[rows] = "30";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "REGISTER";
    $tmp[title] = $admin_phrases[template][user_register][title];
    $tmp[description] = $admin_phrases[template][user_register][description];
    $tmp[rows] = "30";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "captcha_line";
        $tmp[help][0][text] = $admin_phrases[template][user_register][help_1];
        $tmp[help][1][tag] = "captcha_url";
        $tmp[help][1][text] = $admin_phrases[template][user_register][help_1];
        $tmp[help][2][tag] = "captcha_text";
        $tmp[help][2][text] = $admin_phrases[template][user_register][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);



    $tmp[name] = "CAPTCHA_LINE";
    $tmp[title] = $admin_phrases[template][user_spam][title];
    $tmp[description] = $admin_phrases[template][user_spam][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "captcha_url";
        $tmp[help][0][text] = $admin_phrases[template][user_spam][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "CAPTCHA_TEXT";
    $tmp[title] = $admin_phrases[template][user_spamtext][title];
    $tmp[description] = $admin_phrases[template][user_spamtext][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp = array (
        name => "PROFILE",
        title => $admin_phrases[template][user_profil][title],
        description => $admin_phrases[template][user_profil][description],
        rows => 30,
        cols => 66,
        help => array (
            array ( tag => "user_id", text => $TEXT['template']->get("user_profile_user_id") ),
            array ( tag => "user_name", text => $TEXT['template']->get("user_profile_user_name") ),
            array ( tag => "user_image", text => $TEXT['template']->get("user_profile_user_image") ),
            array ( tag => "user_image_url", text => $TEXT['template']->get("user_profile_user_image_url") ),
            array ( tag => "user_rank", text => $TEXT['template']->get("user_profile_user_rank") ),
            array ( tag => "user_mail", text => $TEXT['template']->get("user_profile_user_mail") ),
            array ( tag => "user_is_staff", text => $TEXT['template']->get("user_profile_user_is_staff") ),
            array ( tag => "user_is_admin", text => $TEXT['template']->get("user_profile_user_is_admin") ),
            array ( tag => "user_group", text => $TEXT['template']->get("user_profile_user_group") ),
            array ( tag => "user_reg_date", text => $TEXT['template']->get("user_profile_user_reg_date") ),
            array ( tag => "user_homepage_link", text => $TEXT['template']->get("user_profile_user_homepage_link") ),
            array ( tag => "user_homepage_url", text => $TEXT['template']->get("user_profile_user_homepage_url") ),
            array ( tag => "user_icq", text => $TEXT['template']->get("user_profile_user_icq") ),
            array ( tag => "user_aim", text => $TEXT['template']->get("user_profile_user_aim") ),
            array ( tag => "user_wlm", text => $TEXT['template']->get("user_profile_user_wlm") ),
            array ( tag => "user_yim", text => $TEXT['template']->get("user_profile_user_yim") ),
            array ( tag => "user_skype", text => $TEXT['template']->get("user_profile_user_skype") ),
            array ( tag => "user_num_news", text => $TEXT['template']->get("user_profile_user_num_news") ),
            array ( tag => "user_num_comments", text => $TEXT['template']->get("user_profile_user_num_comments") ),
            array ( tag => "user_num_articles", text => $TEXT['template']->get("user_profile_user_num_articles") ),
            array ( tag => "user_num_downloads", text => $TEXT['template']->get("user_profile_user_num_downloads") ),
        )
    );
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $tmp = array (
        name => "USERRANK",
        title => $TEXT['template']->get("user_rank_title"),
        description => $TEXT['template']->get("user_rank_description"),
        rows => 10,
        cols => 66,
        help => array (
            array ( tag => "group_name", text => $TEXT['template']->get("user_rank_group_name") ),
            array ( tag => "group_image", text => $TEXT['template']->get("user_rank_group_image") ),
            array ( tag => "group_image_url", text => $TEXT['template']->get("user_rank_group_image_url") ),
            array ( tag => "group_title", text => $TEXT['template']->get("user_rank_group_title") ),
            array ( tag => "group_title_text_only", text => $TEXT['template']->get("user_rank_title_text_only") ),
        )
    );
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "PROFILE_EDIT";
    $tmp[title] = $admin_phrases[template][user_profiledit][title];
    $tmp[description] = $admin_phrases[template][user_profiledit][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][][tag] = "user_name";
        $tmp[help][][tag] = "user_id";
        $tmp[help][][tag] = "user_image";
        $tmp[help][][tag] = "user_image_url";
        $tmp[help][][tag] = "image_max_width";
        $tmp[help][][tag] = "image_max_height";
        $tmp[help][][tag] = "image_max_size";
        $tmp[help][][tag] = "image_limits_text";
        $tmp[help][][tag] = "user_mail";
        $tmp[help][][tag] = "show_mail_checked";
        
        $tmp[help][][tag] = "user_homepage_url";
        $tmp[help][][tag] = "user_icq";
        $tmp[help][][tag] = "user_aim";
        $tmp[help][][tag] = "user_wlm";
        $tmp[help][][tag] = "user_yim";
        $tmp[help][][tag] = "user_skype";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    
    $tmp[name] = "MEMBERSLIST";
    $tmp[title] = $admin_phrases[template][user_memberlist_body][title];
    $tmp[description] = $admin_phrases[template][user_memberlist_body][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{members}";
        $tmp[help][0][text] = $admin_phrases[template][user_memberlist_body][help_1];
        $tmp[help][1][tag] = "{page}";
        $tmp[help][1][text] = $admin_phrases[template][user_memberlist_body][help_2];
        $tmp[help][2][tag] = "{order_name}";
        $tmp[help][2][text] = $admin_phrases[template][user_memberlist_body][help_3];
        $tmp[help][3][tag] = "{arrow_name}";
        $tmp[help][3][text] = $admin_phrases[template][user_memberlist_body][help_4];
        $tmp[help][4][tag] = "{order_regdate}";
        $tmp[help][4][text] = $admin_phrases[template][user_memberlist_body][help_5];
        $tmp[help][5][tag] = "{arrow_regdate}";
        $tmp[help][5][text] = $admin_phrases[template][user_memberlist_body][help_6];
        $tmp[help][6][tag] = "{order_news}";
        $tmp[help][6][text] = $admin_phrases[template][user_memberlist_body][help_7];
        $tmp[help][7][tag] = "{arrow_news}";
        $tmp[help][7][text] = $admin_phrases[template][user_memberlist_body][help_8];
        $tmp[help][8][tag] = "{order_articles}";
        $tmp[help][8][text] = $admin_phrases[template][user_memberlist_body][help_9];
        $tmp[help][9][tag] = "{arrow_articles}";
        $tmp[help][9][text] = $admin_phrases[template][user_memberlist_body][help_10];
        $tmp[help][10][tag] = "{order_comments}";
        $tmp[help][10][text] = $admin_phrases[template][user_memberlist_body][help_11];
        $tmp[help][11][tag] = "{arrow_comments}";
        $tmp[help][11][text] = $admin_phrases[template][user_memberlist_body][help_12];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
    
    $tmp[name] = "MEMBERSLIST_USERLINE";
    $tmp[title] = $admin_phrases[template][user_memberlist_userline][title];
    $tmp[description] = $admin_phrases[template][user_memberlist_userline][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{username}";
        $tmp[help][0][text] = $admin_phrases[template][user_memberlist_adminline][help_1];
        $tmp[help][1][tag] = "{userlink}";
        $tmp[help][1][text] = $admin_phrases[template][user_memberlist_adminline][help_2];
        $tmp[help][2][tag] = "{avatar}";
        $tmp[help][2][text] = $admin_phrases[template][user_memberlist_adminline][help_3];
        $tmp[help][3][tag] = "{email}";
        $tmp[help][3][text] = $admin_phrases[template][user_memberlist_adminline][help_4];
        $tmp[help][4][tag] = "{reg_date}";
        $tmp[help][4][text] = $admin_phrases[template][user_memberlist_adminline][help_5];
        $tmp[help][5][tag] = "{news}";
        $tmp[help][5][text] = $admin_phrases[template][user_memberlist_adminline][help_6];
        $tmp[help][6][tag] = "{articles}";
        $tmp[help][6][text] = $admin_phrases[template][user_memberlist_adminline][help_7];
        $tmp[help][7][tag] = "{comments}";
        $tmp[help][7][text] = $admin_phrases[template][user_memberlist_adminline][help_8];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "MEMBERSLIST_ADMINLINE";
    $tmp[title] = $admin_phrases[template][user_memberlist_adminline][title];
    $tmp[description] = $admin_phrases[template][user_memberlist_adminline][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{username}";
        $tmp[help][0][text] = $admin_phrases[template][user_memberlist_adminline][help_1];
        $tmp[help][1][tag] = "{userlink}";
        $tmp[help][1][text] = $admin_phrases[template][user_memberlist_adminline][help_2];
        $tmp[help][2][tag] = "{avatar}";
        $tmp[help][2][text] = $admin_phrases[template][user_memberlist_adminline][help_3];
        $tmp[help][3][tag] = "{email}";
        $tmp[help][3][text] = $admin_phrases[template][user_memberlist_adminline][help_4];
        $tmp[help][4][tag] = "{reg_date}";
        $tmp[help][4][text] = $admin_phrases[template][user_memberlist_adminline][help_5];
        $tmp[help][5][tag] = "{news}";
        $tmp[help][5][text] = $admin_phrases[template][user_memberlist_adminline][help_6];
        $tmp[help][6][tag] = "{articles}";
        $tmp[help][6][text] = $admin_phrases[template][user_memberlist_adminline][help_7];
        $tmp[help][7][tag] = "{comments}";
        $tmp[help][7][text] = $admin_phrases[template][user_memberlist_adminline][help_8];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);
        
//////////////////////////
//// Intialise Editor ////
//////////////////////////

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>