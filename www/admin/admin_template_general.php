<?php
$TEMPLATE_GO = "tpl_general";
$TEMPLATE_FILE = "0_general.tpl";
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
    name => "SYSTEMMESSAGE",
    title => $admin_phrases[template][error][title],
    description => $admin_phrases[template][error][description],
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "message_title", text => $admin_phrases[template][error][help_1] ),
        array ( tag => "message", text => $admin_phrases[template][error][help_2] ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "FORWARDMESSAGE",
    title => $TEXT['template']->get("general_forwardmessage_title"),
    description => $admin_phrases[template][error][description],
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "message_title", text => $admin_phrases[template][error][help_1] ),
        array ( tag => "message", text => $admin_phrases[template][error][help_2] ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "DOCTYPE",
    title => $admin_phrases[template][doctype][title],
    description => $admin_phrases[template][doctype][description],
    rows => 5,
    cols => 66,
    help => array (
    )
);


$TEMPLATE_EDIT[] = array (
    name => "MAINPAGE",
    title => $admin_phrases[template][indexphp][title],
    description => $admin_phrases[template][indexphp][description],
    rows => 30,
    cols => 66,
    help => array (
        array ( tag => "main_menu", text => $admin_phrases[template][indexphp][help_1] ),
        array ( tag => "announcement", text => $admin_phrases[template][indexphp][help_2] ),
        array ( tag => "content", text => $admin_phrases[template][indexphp][help_3] ),
        array ( tag => "user", text => $admin_phrases[template][indexphp][help_4] ),
        array ( tag => "randompic", text => $admin_phrases[template][indexphp][help_5] ),
        array ( tag => "poll", text => $admin_phrases[template][indexphp][help_6] ),
        array ( tag => "stats", text => $admin_phrases[template][indexphp][help_7] ),
        array ( tag => "shop", text => $admin_phrases[template][indexphp][help_8] ),
        array ( tag => "partner", text => $TEXT['template']->get("general_mainpage_partner") ),
        array ( tag => "copyright", text => $TEXT['template']->get("general_mainpage_copyright") ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "POPUPVIEWER",
    title => $admin_phrases[template][pic_viewer][title],
    description => $admin_phrases[template][pic_viewer][description],
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "image", text => $TEXT['template']->get("general_popupviewer_") ),
        array ( tag => "image_url", text => $TEXT['template']->get("general_popupviewer_") ),
        array ( tag => "", text => $TEXT['template']->get("general_popupviewer_") ),
        
    
        array ( tag => "next_img", text => $admin_phrases[template][pic_viewer][help_1] ),
        array ( tag => "prev_img", text => $admin_phrases[template][pic_viewer][help_2] ),
        array ( tag => "image", text => $admin_phrases[template][pic_viewer][help_3] ),
        array ( tag => "title", text => $admin_phrases[template][pic_viewer][help_4] ),
    )
);
    
$TEMPLATE_EDIT[] = array (
    name => "ANNOUNCEMENT",
    title => $admin_phrases[template][announcement][title],
    description => $admin_phrases[template][announcement][description],
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "announcement_text", text => $admin_phrases[template][announcement][help_1] ),
    )
);
        
$TEMPLATE_EDIT[] = array (
    name => "STATISTICS",
    title => $admin_phrases[template][statistik][title],
    description => $admin_phrases[template][statistik][description],
    rows => 20,
    cols => 66,
    help => array (
        array ( tag => "visits", text => $TEXT['template']->get("general_statistics_visits") ),
        array ( tag => "visits_today", text => $TEXT['template']->get("general_statistics_visits_today") ),
        array ( tag => "hits", text => $TEXT['template']->get("general_statistics_hits") ),
        array ( tag => "hits_today", text => $TEXT['template']->get("general_statistics_hits_today") ),
        array ( tag => "visitors_online", text => $TEXT['template']->get("general_statistics_visitors_online") ),
        array ( tag => "registered_online", text => $TEXT['template']->get("general_statistics_registered_online") ),
        array ( tag => "guests_online", text => $TEXT['template']->get("general_statistics_guests_online") ),
        array ( tag => "num_users", text => $TEXT['template']->get("general_statistics_num_users") ),
        array ( tag => "num_news", text => $TEXT['template']->get("general_statistics_num_news") ),
        array ( tag => "num_comments", text => $TEXT['template']->get("general_statistics_num_comments") ),
        array ( tag => "num_articles", text => $TEXT['template']->get("general_statistics_num_articles") ),
    )
);

// Init Template-Page
echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, ensure_copyright ( "MAINPAGE" ) );
?>