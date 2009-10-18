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
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "user_name";
        $tmp[help][0][text] = $admin_phrases[template][user_user_menu][help_1] ;
        $tmp[help][1][tag] = "user_id";
        $tmp[help][2][tag] = "user_image";
        $tmp[help][3][tag] = "user_image_url";
        $tmp[help][4][tag] = "admincp_line";
        $tmp[help][4][text] = $admin_phrases[template][user_user_menu][help_2] ;
        $tmp[help][5][tag] = "logout_url";
        $tmp[help][5][text] = $admin_phrases[template][user_user_menu][help_3] ;



    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "APPLET_ADMINLINK";
    $tmp[title] = $admin_phrases[template][user_admin_link][title];
    $tmp[description] = $admin_phrases[template][user_admin_link][description];
    $tmp[rows] = "5";
    $tmp[cols] = "66";
        $tmp[help][][tag] = "admincp_link";
        $tmp[help][1][tag] = "admincp_url";
        $tmp[help][1][text] = $admin_phrases[template][user_admin_link][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp[name] = "LOGIN";
    $tmp[title] = $admin_phrases[template][user_login][title];
    $tmp[description] = $admin_phrases[template][user_login][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "REGISTER";
    $tmp[title] = $admin_phrases[template][user_register][title];
    $tmp[description] = $admin_phrases[template][user_register][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{antispam}";
        $tmp[help][0][text] = $admin_phrases[template][user_register][help_1];
        $tmp[help][1][tag] = "{antispamtext}";
        $tmp[help][1][text] = $admin_phrases[template][user_register][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);



    $tmp[name] = "CAPTCHA_LINE";
    $tmp[title] = $admin_phrases[template][user_spam][title];
    $tmp[description] = $admin_phrases[template][user_spam][description];
    $tmp[rows] = "7";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{captcha_url}";
        $tmp[help][0][text] = $admin_phrases[template][user_spam][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "CAPTCHA_TEXT";
    $tmp[title] = $admin_phrases[template][user_spamtext][title];
    $tmp[description] = $admin_phrases[template][user_spamtext][description];
    $tmp[rows] = "7";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);



    $tmp[name] = "PROFILE";
    $tmp[title] = $admin_phrases[template][user_profil][title];
    $tmp[description] = $admin_phrases[template][user_profil][description];
    $tmp[rows] = "20";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "{username}";
        $tmp[help][0][text] = $admin_phrases[template][user_profil][help_1];
        $tmp[help][1][tag] = "{avatar}";
        $tmp[help][1][text] = $admin_phrases[template][user_profil][help_2];
        $tmp[help][2][tag] = "{email}";
        $tmp[help][2][text] = $admin_phrases[template][user_profil][help_3];
        $tmp[help][3][tag] = "{reg_datum}";
        $tmp[help][3][text] = $admin_phrases[template][user_profil][help_4];
        $tmp[help][4][tag] = "{news}";
        $tmp[help][4][text] = $admin_phrases[template][user_profil][help_5];
        $tmp[help][5][tag] = "{artikel}";
        $tmp[help][5][text] = $admin_phrases[template][user_profil][help_6];
        $tmp[help][6][tag] = "{kommentare}";
        $tmp[help][6][text] = $admin_phrases[template][user_profil][help_7];
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