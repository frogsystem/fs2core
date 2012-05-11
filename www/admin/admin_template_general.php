<?php
$TEMPLATE_GO = 'tpl_general';
$TEMPLATE_FILE = '0_general.tpl';
$TEMPLATE_EDIT = array();


$TEMPLATE_EDIT[] = array (
    'name' => 'SYSTEMMESSAGE',
    'title' => $TEXT['template']->get('general_systemmessage_title'),
    'description' => $TEXT['template']->get('general_systemmessage_desc'),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'message_title', 'text' => $TEXT['template']->get('general_message_message_title') ),
        array ( 'tag' => 'message', 'text' => $TEXT['template']->get('general_message_message') ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'FORWARDMESSAGE',
    'title' => $TEXT['template']->get('general_forwardmessage_title'),
    'description' => $TEXT['template']->get('general_forwardmessage_desc'),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'message_title', 'text' => $TEXT['template']->get('general_message_message_title') ),
        array ( 'tag' => 'message', 'text' => $TEXT['template']->get('general_message_message') ),
    )
);    

$TEMPLATE_EDIT[] = array (
    'name' => 'ANNOUNCEMENT',
    'title' => $admin_phrases['template']['announcement']['title'],
    'description' => $admin_phrases['template']['announcement']['description'],
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'announcement_text', 'text' => $admin_phrases['template']['announcement']['help_1'] ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'STATISTICS',
    'title' => $TEXT['template']->get('general_statistics_title'),
    'description' => $TEXT['template']->get('general_statistics_desc'),
    'rows' => 20,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'visits', 'text' => $TEXT['template']->get('general_statistics_visits') ),
        array ( 'tag' => 'visits_today', 'text' => $TEXT['template']->get('general_statistics_visits_today') ),
        array ( 'tag' => 'hits', 'text' => $TEXT['template']->get('general_statistics_hits') ),
        array ( 'tag' => 'hits_today', 'text' => $TEXT['template']->get('general_statistics_hits_today') ),
        array ( 'tag' => 'visitors_online', 'text' => $TEXT['template']->get('general_statistics_visitors_online') ),
        array ( 'tag' => 'registered_online', 'text' => $TEXT['template']->get('general_statistics_registered_online') ),
        array ( 'tag' => 'guests_online', 'text' => $TEXT['template']->get('general_statistics_guests_online') ),
        array ( 'tag' => 'num_users', 'text' => $TEXT['template']->get('general_statistics_num_users') ),
        array ( 'tag' => 'num_news', 'text' => $TEXT['template']->get('general_statistics_num_news') ),
        array ( 'tag' => 'num_comments', 'text' => $TEXT['template']->get('general_statistics_num_comments') ),
        array ( 'tag' => 'num_articles', 'text' => $TEXT['template']->get('general_statistics_num_articles') ),
    )
);

// Init Template-Page
echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
