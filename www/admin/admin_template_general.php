<?php
$TEMPLATE_GO = 'tpl_general';
$TEMPLATE_FILE = '0_general.tpl';
$TEMPLATE_EDIT = array();


$TEMPLATE_EDIT[] = array (
    'name' => 'SYSTEMMESSAGE',
    'title' => $FD->text("template", "general_systemmessage_title"),
    'description' => $FD->text("template", "general_systemmessage_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'message_title', 'text' => $FD->text("template", "general_message_message_title") ),
        array ( 'tag' => 'message', 'text' => $FD->text("template", "general_message_message") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'FORWARDMESSAGE',
    'title' => $FD->text("template", "general_forwardmessage_title"),
    'description' => $FD->text("template", "general_forwardmessage_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'message_title', 'text' => $FD->text("template", "general_message_message_title") ),
        array ( 'tag' => 'message', 'text' => $FD->text("template", "general_message_message") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'ANNOUNCEMENT',
    'title' => $FD->text("template", "general_announcement_title"),
    'description' => $FD->text("template", "general_announcement_description"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'announcement_text', 'text' => $FD->text("template", "general_announcement_help_1") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'STATISTICS',
    'title' => $FD->text("template", "general_statistics_title"),
    'description' => $FD->text("template", "general_statistics_desc"),
    'rows' => 20,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'visits', 'text' => $FD->text("template", "general_statistics_visits") ),
        array ( 'tag' => 'visits_today', 'text' => $FD->text("template", "general_statistics_visits_today") ),
        array ( 'tag' => 'hits', 'text' => $FD->text("template", "general_statistics_hits") ),
        array ( 'tag' => 'hits_today', 'text' => $FD->text("template", "general_statistics_hits_today") ),
        array ( 'tag' => 'visitors_online', 'text' => $FD->text("template", "general_statistics_visitors_online") ),
        array ( 'tag' => 'registered_online', 'text' => $FD->text("template", "general_statistics_registered_online") ),
        array ( 'tag' => 'guests_online', 'text' => $FD->text("template", "general_statistics_guests_online") ),
        array ( 'tag' => 'num_users', 'text' => $FD->text("template", "general_statistics_num_users") ),
        array ( 'tag' => 'num_news', 'text' => $FD->text("template", "general_statistics_num_news") ),
        array ( 'tag' => 'num_comments', 'text' => $FD->text("template", "general_statistics_num_comments") ),
        array ( 'tag' => 'num_articles', 'text' => $FD->text("template", "general_statistics_num_articles") ),
    )
);

// Init Template-Page
echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
