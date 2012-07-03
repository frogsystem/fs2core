<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$TEMPLATE_GO = 'tpl_search';
$TEMPLATE_FILE = '0_search.tpl';
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
	'name' => 'APPLET',
    'title' => $FD->text("template", "search_applet_title"),
    'description' => $FD->text("template", "search_applet_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'keyword', 'text' => $FD->text("template", "search_applet_keyword") ),
    )
);


$TEMPLATE_EDIT[] = array (
    'name' => 'SEARCH',
    'title' => $FD->text("template", "search_search_title"),
    'description' => $FD->text("template", "search_search_desc"),
    'rows' => 25,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'keyword', 'text' => $FD->text("template", "search_search_keyword") ),
        array ( 'tag' => 'operators', 'text' => $FD->text("template", "search_operators") ),
        array ( 'tag' => 'search_in_news', 'text' => $FD->text("template", "search_search_in_news") ),
        array ( 'tag' => 'search_in_articles', 'text' => $FD->text("template", "search_search_in_articles") ),
        array ( 'tag' => 'search_in_downloads', 'text' => $FD->text("template", "search_search_in_downloads") ),
        array ( 'tag' => 'phonetic_search', 'text' => $FD->text("template", "search_phonetic_search") ),
    )
);


$TEMPLATE_EDIT[] = array (
    'name' => 'RESULT_DATE_TEMPLATE',
    'title' => $FD->text("template", "search_result_date_template_title"),
    'description' => $FD->text("template", "search_result_date_template_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'date', 'text' => $FD->text("template", "search_result_line_date") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'RESULT_LINE',
    'title' => $FD->text("template", "search_result_line_title"),
    'description' => $FD->text("template", "search_result_line_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'id', 'text' => $FD->text("template", "search_result_line_id") ),
        array ( 'tag' => 'title', 'text' => $FD->text("template", "search_result_line_found_title") ),
        array ( 'tag' => 'url', 'text' => $FD->text("template", "search_result_line_url") ),
        array ( 'tag' => 'date', 'text' => $FD->text("template", "search_result_line_date") ),
        array ( 'tag' => 'date_template', 'text' => $FD->text("template", "search_result_line_date_template") ),
        array ( 'tag' => 'rank', 'text' => $FD->text("template", "search_result_line_rank") ),
    )
);


$TEMPLATE_EDIT[] = array (
    'name' => 'NO_RESULTS',
    'title' => $FD->text("template", "search_no_results_title"),
    'description' => $FD->text("template", "search_no_results_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'MORE_RESULTS',
    'title' => $FD->text("template", "search_more_results_title"),
    'description' => $FD->text("template", "search_more_results_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'main_search_url', 'text' => $FD->text("template", "search_more_results_main_search_url") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'RESULTS_BODY',
    'title' => $FD->text("template", "search_results_body_title"),
    'description' => $FD->text("template", "search_results_body_desc"),
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'type_title', 'text' => $FD->text("template", "search_results_body_type_title") ),
        array ( 'tag' => 'results', 'text' => $FD->text("template", "search_results_body_results") ),
        array ( 'tag' => 'num_results', 'text' => $FD->text("template", "search_results_body_num_results") ),
        array ( 'tag' => 'more_results', 'text' => $FD->text("template", "search_results_body_more_results") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'INFO',
    'title' => $FD->text("template", "search_info_title"),
    'description' => $FD->text("template", "search_info_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'query', 'text' => $FD->text("template", "search_info_query") ),
        array ( 'tag' => 'num_results', 'text' => $FD->text("template", "search_info_num_results") ),
    )
);


$TEMPLATE_EDIT[] = array (
    'name' => 'BODY',
    'title' => $FD->text("template", "search_body_title"),
    'description' => $FD->text("template", "search_body_desc"),
    'rows' => 25,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'search', 'text' => $FD->text("template", "search_body_search") ),
        array ( 'tag' => 'info', 'text' => $FD->text("template", "search_body_info") ),
        array ( 'tag' => 'news', 'text' => $FD->text("template", "search_body_news") ),
        array ( 'tag' => 'articles', 'text' => $FD->text("template", "search_body_articles") ),
        array ( 'tag' => 'downloads', 'text' => $FD->text("template", "search_body_downloads") ),
    )
);


// Init Template-Page
echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
