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
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "visits", text => $admin_phrases[template][statistik][help_1] ),
        array ( tag => "visits_heute", text => $admin_phrases[template][statistik][help_2] ),
        array ( tag => "hits", text => $admin_phrases[template][statistik][help_3] ),
        array ( tag => "hits_heute", text => $admin_phrases[template][statistik][help_4] ),
        array ( tag => "user_online", text => $admin_phrases[template][statistik][help_5] ),
        array ( tag => "news", text => $admin_phrases[template][statistik][help_6] ),
        array ( tag => "user", text => $admin_phrases[template][statistik][help_7] ),
        array ( tag => "artikel", text => $admin_phrases[template][statistik][help_8] ),
        array ( tag => "kommentare", text => $admin_phrases[template][statistik][help_9] ),
    )
);

// Init Template-Page
echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, ensure_copyright ( "MAINPAGE" ) );
?>