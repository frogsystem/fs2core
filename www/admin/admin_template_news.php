<?php
    $TEMPLATE_GO = "tpl_news";
    $TEMPLATE_FILE = "0_news.tpl";
    $TEMPLATE_EDIT = null;
    

$TEMPLATE_EDIT[] = array (
    name => "APPLET_LINE",
    title => $TEXT['template']->get("news_applet_line_title"),
    description => $TEXT['template']->get("news_applet_line_desc"),
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "title", text => $TEXT['template']->get("news_applet_line_news_title") ),
        array ( tag => "date", text => $TEXT['template']->get("news_applet_line_date") ),
        array ( tag => "url", text => $TEXT['template']->get("news_applet_line_url") ),
        array ( tag => "news_id", text => $TEXT['template']->get("news_applet_line_news_id") ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "APPLET_BODY",
    title => $TEXT['template']->get("news_applet_body_title"),
    description => $TEXT['template']->get("news_applet_body_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "news_lines", text => $TEXT['template']->get("news_applet_body_news_lines") ),
        array ( tag => "download_lines", text => $TEXT['template']->get("news_applet_body_download_lines") ),
    )
);

    $tmp[name] = "LINKS_LINE";
    $tmp[title] = $admin_phrases[template][news_link][title];
    $tmp[description] = $admin_phrases[template][news_link][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "title";
        $tmp[help][0][text] = $admin_phrases[template][news_link][help_1];
        $tmp[help][2][tag] = "url";
        $tmp[help][2][text] = $admin_phrases[template][news_link][help_3];
        $tmp[help][1][tag] = "target";
        $tmp[help][1][text] = $admin_phrases[template][news_link][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "LINKS_BODY";
    $tmp[title] = $admin_phrases[template][news_related_links][title];
    $tmp[description] = $admin_phrases[template][news_related_links][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "links";
        $tmp[help][0][text] = $admin_phrases[template][news_related_links][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp[name] = "NEWS_BODY";
    $tmp[title] = $admin_phrases[template][news_body][title];
    $tmp[description] = $admin_phrases[template][news_body][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "news_id";
        $tmp[help][0][text] = $admin_phrases[template][news_body][help_1];
        $tmp[help][1][tag] = "titel";
        $tmp[help][1][text] = $admin_phrases[template][news_body][help_2];
        $tmp[help][2][tag] = "date";
        $tmp[help][2][text] = $admin_phrases[template][news_body][help_3];
        $tmp[help][3][tag] = "text";
        $tmp[help][3][text] = $admin_phrases[template][news_body][help_4];
        $tmp[help][4][tag] = "user_name";
        $tmp[help][4][text] = $admin_phrases[template][news_body][help_5];
        $tmp[help][5][tag] = "user_url";
        $tmp[help][5][text] = $admin_phrases[template][news_body][help_6];
        $tmp[help][6][tag] = "cat_name";
        $tmp[help][6][text] = $admin_phrases[template][news_body][help_7];
        $tmp[help][7][tag] = "cat_image";
        $tmp[help][7][text] = $admin_phrases[template][news_body][help_8];
        $tmp[help][8][tag] = "comments_url";
        $tmp[help][8][text] = $admin_phrases[template][news_body][help_9];
        $tmp[help][9][tag] = "comments_number";
        $tmp[help][9][text] = $admin_phrases[template][news_body][help_10];
        $tmp[help][10][tag] = "related_links";
        $tmp[help][10][text] = $admin_phrases[template][news_body][help_11];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp[name] = "BODY";
    $tmp[title] = $admin_phrases[template][news_container][title];
    $tmp[description] = $admin_phrases[template][news_container][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "news";
        $tmp[help][0][text] = $admin_phrases[template][news_body][help_1];
        $tmp[help][1][tag] = "headlines";
        $tmp[help][1][text] = $admin_phrases[template][news_body][help_2];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


$TEMPLATE_EDIT[] = array (
    name => "COMMENT_USER",
    title => $TEXT['template']->get("news_comment_user_title"),
    description => $TEXT['template']->get("news_comment_user_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "name", text => $TEXT['template']->get("news_comment_user_name") ),
        array ( tag => "url", text => $TEXT['template']->get("news_comment_user_url") ),
        array ( tag => "image", text => $TEXT['template']->get("news_comment_user_image") ),
        array ( tag => "rank", text => $TEXT['template']->get("news_comment_user_rank") ),
    )
);


    $tmp[name] = "COMMMENT_ENTRY";
    $tmp[title] = $admin_phrases[template][news_comment_body][title];
    $tmp[description] = $admin_phrases[template][news_comment_body][description];
    $tmp[rows] = "25";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "titel";
        $tmp[help][0][text] = $admin_phrases[template][news_comment_body][help_1];
        $tmp[help][1][tag] = "date";
        $tmp[help][1][text] = $admin_phrases[template][news_comment_body][help_2];
        $tmp[help][2][tag] = "text";
        $tmp[help][2][text] = $admin_phrases[template][news_comment_body][help_3];
        $tmp[help][3][tag] = "user";
        $tmp[help][3][text] = $admin_phrases[template][news_comment_body][help_4];
        $tmp[help][4][tag] = "user_image";
        $tmp[help][4][text] = $admin_phrases[template][news_comment_body][help_5];
        $tmp[help][5][tag] = "user_rank";
        $tmp[help][5][text] = "Benutzerrang";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    
    $tmp[name] = "COMMENT_CAPTCHA";
    $tmp[title] = $admin_phrases[template][news_comment_form_spam][title];
    $tmp[description] = $admin_phrases[template][news_comment_form_spam][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "captcha_url";
        $tmp[help][0][text] = $admin_phrases[template][news_comment_form_spam][help_1];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp[name] = "COMMENT_CAPTCHA_TEXT";
    $tmp[title] = $admin_phrases[template][news_comment_form_spamtext][title];
    $tmp[description] = $admin_phrases[template][news_comment_form_spamtext][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp[name] = "COMMENT_FORM_NAME";
    $tmp[title] = $admin_phrases[template][news_comment_form_name][title];
    $tmp[description] = $admin_phrases[template][news_comment_form_name][description];
    $tmp[rows] = "10";
    $tmp[cols] = "66";
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


$TEMPLATE_EDIT[] = array (
    name => "COMMENT_FORM",
    title => $TEXT['template']->get("news_comment_form_title"),
    description => $TEXT['template']->get("news_comment_form_desc"),
    rows => 20,
    cols => 66,
    help => array (
        array ( tag => "news_id", text => $TEXT['template']->get("news_comment_form_news_id") ),
        array ( tag => "name_input", text => $TEXT['template']->get("news_comment_form_name_input") ),
        array ( tag => "textarea", text => $TEXT['template']->get("news_comment_form_textarea") ),
        array ( tag => "html", text => $TEXT['template']->get("news_comment_form_html") ),
        array ( tag => "fs_code", text => $TEXT['template']->get("news_comment_form_fs_code") ),
        array ( tag => "captcha", text => $TEXT['template']->get("news_comment_form_captcha") ),
        array ( tag => "captcha_text", text => $TEXT['template']->get("news_comment_form_captcha_text") ),
    )
);




    $tmp[name] = "COMMENT_BODY";
    $tmp[title] = $admin_phrases[template][news_comment_container][title];
    $tmp[description] = $admin_phrases[template][news_comment_container][description];
    $tmp[rows] = "15";
    $tmp[cols] = "66";
        $tmp[help][0][tag] = "news";
        $tmp[help][0][text] = $admin_phrases[template][news_comment_container][help_1];
        $tmp[help][1][tag] = "comments";
        $tmp[help][1][text] = $admin_phrases[template][news_comment_container][help_2];;
        $tmp[help][2][tag] = "comment_form";
        $tmp[help][2][text] = $admin_phrases[template][news_comment_container][help_3];
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

$TEMPLATE_EDIT[] = array (
    name => "SEARCH",
    title => $TEXT['template']->get("news_search_title"),
    description => $TEXT['template']->get("news_search_desc"),
    rows => 25,
    cols => 66,
    help => array (
        array ( tag => "years", text => $TEXT['template']->get("news_search_years") ),
        array ( tag => "keyword", text => $TEXT['template']->get("news_search_keyword") ),
    )
);


echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>