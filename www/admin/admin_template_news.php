<?php
    $TEMPLATE_GO = 'tpl_news';
    $TEMPLATE_FILE = '0_news.tpl';
    $TEMPLATE_EDIT = null;


$TEMPLATE_EDIT[] = array (
    'name' => 'APPLET_LINE',
    'title' => $FD->text("template", "news_applet_line_title"),
    'description' => $FD->text("template", "news_applet_line_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'title', 'text' => $FD->text("template", "news_applet_line_news_title") ),
        array ( 'tag' => 'date', 'text' => $FD->text("template", "news_applet_line_date") ),
        array ( 'tag' => 'url', 'text' => $FD->text("template", "news_applet_line_url") ),
        array ( 'tag' => 'news_id', 'text' => $FD->text("template", "news_applet_line_news_id") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'APPLET_BODY',
    'title' => $FD->text("template", "news_applet_body_title"),
    'description' => $FD->text("template", "news_applet_body_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'news_lines', 'text' => $FD->text("template", "news_applet_body_news_lines") ),
        array ( 'tag' => 'download_lines', 'text' => $FD->text("template", "news_applet_body_download_lines") ),
    )
);

    $tmp['name'] = 'LINKS_LINE';
    $tmp['title'] = $FD->text("template", "news_link_title");
    $tmp['description'] = $FD->text("template", "news_link_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'title';
        $tmp['help'][0]['text'] = $FD->text("template", "news_link_help_1");
        $tmp['help'][2]['tag'] = 'url';
        $tmp['help'][2]['text'] = $FD->text("template", "news_link_help_3");
        $tmp['help'][1]['tag'] = 'target';
        $tmp['help'][1]['text'] = $FD->text("template", "news_link_help_2");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'LINKS_BODY';
    $tmp['title'] = $FD->text("template", "news_related_links_title");
    $tmp['description'] = $FD->text("template", "news_related_links_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'links';
        $tmp['help'][0]['text'] = $FD->text("template", "news_related_links_help_1");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp['name'] = 'NEWS_BODY';
    $tmp['title'] = $FD->text("template", "news_body_title");
    $tmp['description'] = $FD->text("template", "news_body_description");
    $tmp['rows'] = '25';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'news_id';
        $tmp['help'][0]['text'] = $FD->text("template", "news_body_help_1");
        $tmp['help'][1]['tag'] = 'titel';
        $tmp['help'][1]['text'] = $FD->text("template", "news_body_help_2");
        $tmp['help'][2]['tag'] = 'date';
        $tmp['help'][2]['text'] = $FD->text("template", "news_body_help_3");
        $tmp['help'][3]['tag'] = 'text';
        $tmp['help'][3]['text'] = $FD->text("template", "news_body_help_4");
        $tmp['help'][4]['tag'] = 'user_name';
        $tmp['help'][4]['text'] = $FD->text("template", "news_body_help_5");
        $tmp['help'][5]['tag'] = 'user_url';
        $tmp['help'][5]['text'] = $FD->text("template", "news_body_help_6");
        $tmp['help'][6]['tag'] = 'cat_name';
        $tmp['help'][6]['text'] = $FD->text("template", "news_body_help_8");
        $tmp['help'][7]['tag'] = 'cat_image';
        $tmp['help'][7]['text'] = $FD->text("template", "news_body_help_7");
        $tmp['help'][8]['tag'] = 'comments_url';
        $tmp['help'][8]['text'] = $FD->text("template", "news_body_help_9");
        $tmp['help'][9]['tag'] = 'comments_number';
        $tmp['help'][9]['text'] = $FD->text("template", "news_body_help_10");
        $tmp['help'][10]['tag'] = 'related_links';
        $tmp['help'][10]['text'] = $FD->text("template", "news_body_help_11");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp['name'] = 'BODY';
    $tmp['title'] = $FD->text("template", "news_container_title");
    $tmp['description'] = $FD->text("template", "news_container_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'news';
        $tmp['help'][0]['text'] = $FD->text("template", "news_body_help_1");
        $tmp['help'][1]['tag'] = 'headlines';
        $tmp['help'][1]['text'] = $FD->text("template", "news_body_help_2");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


$TEMPLATE_EDIT[] = array (
    'name' => 'COMMENT_USER',
    'title' => $FD->text("template", "news_comment_user_title"),
    'description' => $FD->text("template", "news_comment_user_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'name', 'text' => $FD->text("template", "news_comment_user_name") ),
        array ( 'tag' => 'url', 'text' => $FD->text("template", "news_comment_user_url") ),
        array ( 'tag' => 'image', 'text' => $FD->text("template", "news_comment_user_image") ),
        array ( 'tag' => 'rank', 'text' => $FD->text("template", "news_comment_user_rank") ),
    )
);


    $tmp['name'] = 'COMMMENT_ENTRY';
    $tmp['title'] = $FD->text("template", "news_comment_body_title");
    $tmp['description'] = $FD->text("template", "news_comment_body_description");
    $tmp['rows'] = '25';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'titel';
        $tmp['help'][0]['text'] = $FD->text("template", "news_comment_body_help_1");
        $tmp['help'][1]['tag'] = 'date';
        $tmp['help'][1]['text'] = $FD->text("template", "news_comment_body_help_2");
        $tmp['help'][2]['tag'] = 'text';
        $tmp['help'][2]['text'] = $FD->text("template", "news_comment_body_help_3");
        $tmp['help'][3]['tag'] = 'user';
        $tmp['help'][3]['text'] = $FD->text("template", "news_comment_body_help_4");
        $tmp['help'][4]['tag'] = 'user_image';
        $tmp['help'][4]['text'] = $FD->text("template", "news_comment_body_help_5");
        $tmp['help'][5]['tag'] = 'user_rank';
        $tmp['help'][5]['text'] = 'Benutzerrang';
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp['name'] = 'COMMENT_CAPTCHA';
    $tmp['title'] = $FD->text("template", "news_comment_form_spam_title");
    $tmp['description'] = $FD->text("template", "news_comment_form_spam_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'captcha_url';
        $tmp['help'][0]['text'] = $FD->text("template", "news_comment_form_spam_help_1");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

    $tmp['name'] = 'COMMENT_CAPTCHA_TEXT';
    $tmp['title'] = $FD->text("template", "news_comment_form_spamtext_title");
    $tmp['description'] = $FD->text("template", "news_comment_form_spamtext_desc");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


    $tmp['name'] = 'COMMENT_FORM_NAME';
    $tmp['title'] = $FD->text("template", "news_comment_form_name_title");
    $tmp['description'] = $FD->text("template", "news_comment_form_name_description");
    $tmp['rows'] = '10';
    $tmp['cols'] = '66';
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);


$TEMPLATE_EDIT[] = array (
    'name' => 'COMMENT_FORM',
    'title' => $FD->text("template", "news_comment_form_title"),
    'description' => $FD->text("template", "news_comment_form_desc"),
    'rows' => 20,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'news_id', 'text' => $FD->text("template", "news_comment_form_news_id") ),
        array ( 'tag' => 'name_input', 'text' => $FD->text("template", "news_comment_form_name_input") ),
        array ( 'tag' => 'textarea', 'text' => $FD->text("template", "news_comment_form_textarea") ),
        array ( 'tag' => 'html', 'text' => $FD->text("template", "news_comment_form_html") ),
        array ( 'tag' => 'fs_code', 'text' => $FD->text("template", "news_comment_form_fs_code") ),
        array ( 'tag' => 'captcha', 'text' => $FD->text("template", "news_comment_form_captcha") ),
        array ( 'tag' => 'captcha_text', 'text' => $FD->text("template", "news_comment_form_captcha_text") ),
    )
);




    $tmp['name'] = 'COMMENT_BODY';
    $tmp['title'] = $FD->text("template", "news_comment_container_title");
    $tmp['description'] = $FD->text("template", "news_comment_container_description");
    $tmp['rows'] = '15';
    $tmp['cols'] = '66';
        $tmp['help'][0]['tag'] = 'news';
        $tmp['help'][0]['text'] = $FD->text("template", "news_comment_container_help_1");
        $tmp['help'][1]['tag'] = 'comments';
        $tmp['help'][1]['text'] = $FD->text("template", "news_comment_container_help_2");
        $tmp['help'][2]['tag'] = 'comment_form';
        $tmp['help'][2]['text'] = $FD->text("template", "news_comment_container_help_3");
    $TEMPLATE_EDIT[] = $tmp;
    unset($tmp);

$TEMPLATE_EDIT[] = array (
    'name' => 'SEARCH',
    'title' => $FD->text("template", "news_search_title"),
    'description' => $FD->text("template", "news_search_desc"),
    'rows' => 25,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'years', 'text' => $FD->text("template", "news_search_years") ),
        array ( 'tag' => 'keyword', 'text' => $FD->text("template", "news_search_keyword") ),
    )
);


echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
