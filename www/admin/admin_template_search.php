<?php
$TEMPLATE_GO = "tpl_search";
$TEMPLATE_FILE = "0_search.tpl";
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
    name => "APPLET",
    title => $TEXT['template']->get("search_applet_title"),
    description => $TEXT['template']->get("search_applet_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "keyword", text => $TEXT['template']->get("search_applet_keyword") ),
    )
);


$TEMPLATE_EDIT[] = array (
    name => "SEARCH",
    title => $TEXT['template']->get("search_search_title"),
    description => $TEXT['template']->get("search_search_desc"),
    rows => 25,
    cols => 66,
    help => array (
        array ( tag => "keyword", text => $TEXT['template']->get("search_search_keyword") ),
        array ( tag => "search_in_news", text => $TEXT['template']->get("search_search_in_news") ),
        array ( tag => "search_in_articles", text => $TEXT['template']->get("search_search_in_articles") ),
        array ( tag => "search_in_downloads", text => $TEXT['template']->get("search_search_in_downloads") ),
    )
);


$TEMPLATE_EDIT[] = array (
    name => "RESULT_DATE_TEMPLATE",
    title => $TEXT['template']->get("search_result_date_template_title"),
    description => $TEXT['template']->get("search_result_date_template_desc"),
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "date", text => $TEXT['template']->get("search_result_line_date") ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "RESULT_LINE",
    title => $TEXT['template']->get("search_result_line_title"),
    description => $TEXT['template']->get("search_result_line_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "id", text => $TEXT['template']->get("search_result_line_id") ),
        array ( tag => "title", text => $TEXT['template']->get("search_result_line_found_title") ),
        array ( tag => "url", text => $TEXT['template']->get("search_result_line_url") ),
        array ( tag => "date", text => $TEXT['template']->get("search_result_line_date") ),
        array ( tag => "date_template", text => $TEXT['template']->get("search_result_line_date_template") ),
        array ( tag => "num_results", text => $TEXT['template']->get("search_result_line_num_results") ),
    )
);


$TEMPLATE_EDIT[] = array (
    name => "NO_RESULTS",
    title => $TEXT['template']->get("search_no_results_title"),
    description => $TEXT['template']->get("search_no_results_desc"),
    rows => 10,
    cols => 66,
    help => array (
    )
);

$TEMPLATE_EDIT[] = array (
    name => "MORE_RESULTS",
    title => $TEXT['template']->get("search_more_results_title"),
    description => $TEXT['template']->get("search_more_results_desc"),
    rows => 10,
    cols => 66,
    help => array (
        array ( tag => "main_search_url", text => $TEXT['template']->get("search_more_results_main_search_url") ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "RESULTS_BODY",
    title => $TEXT['template']->get("search_results_body_title"),
    description => $TEXT['template']->get("search_results_body_desc"),
    rows => 15,
    cols => 66,
    help => array (
        array ( tag => "type_title", text => $TEXT['template']->get("search_results_body_type_title") ),
        array ( tag => "results", text => $TEXT['template']->get("search_results_body_results") ),
        array ( tag => "num_results", text => $TEXT['template']->get("search_results_body_num_results") ),
        array ( tag => "more_results", text => $TEXT['template']->get("search_results_body_more_results") ),
    )
);


$TEMPLATE_EDIT[] = array (
    name => "BODY",
    title => $TEXT['template']->get("search_body_title"),
    description => $TEXT['template']->get("search_body_desc"),
    rows => 25,
    cols => 66,
    help => array (
        array ( tag => "search", text => $TEXT['template']->get("search_body_search") ),
        array ( tag => "news", text => $TEXT['template']->get("search_body_news") ),
        array ( tag => "articles", text => $TEXT['template']->get("search_body_articles") ),
        array ( tag => "downloads", text => $TEXT['template']->get("search_body_downloads") ),
    )
);


// Init Template-Page
echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>