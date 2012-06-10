<?php
$TEMPLATE_GO = 'tpl_main';
$TEMPLATE_FILE = '0_main.tpl';
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
    'name' => 'MAIN',
    'title' => $TEXT['template']->get('general_mainpage_title'),
    'description' => $TEXT['template']->get('general_mainpage_desc'),
    'rows' => 30,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'content', 'text' => $TEXT['template']->get('general_mainpage_content') ),
        array ( 'tag' => 'copyright', 'text' => $TEXT['template']->get('general_mainpage_copyright') ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'MATRIX',
    'title' => $TEXT['template']->get('main_matrix_title'),
    'description' => $TEXT['template']->get('main_matrix_desc'),
    'rows' => 20,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'doctype', 'text' => $TEXT['page']->get('matrix_help_doctype') ),
        array ( 'tag' => 'language', 'text' => $TEXT['page']->get('matrix_help_language') ),
        array ( 'tag' => 'base_tag', 'text' => $TEXT['page']->get('matrix_help_base_tag') ),
        array ( 'tag' => 'title', 'text' => $TEXT['page']->get('matrix_help_title') ),
        array ( 'tag' => 'title_tag', 'text' => $TEXT['page']->get('matrix_help_title_tag') ),
        array ( 'tag' => 'meta_tags', 'text' => $TEXT['page']->get('matrix_help_meta_tags') ),

        array ( 'tag' => 'css_links', 'text' => $TEXT['page']->get('matrix_help_css_links') ),
        array ( 'tag' => 'favicon_link', 'text' => $TEXT['page']->get('matrix_help_favicon_link') ),
        array ( 'tag' => 'feed_link', 'text' => $TEXT['page']->get('matrix_help_feed_link') ),

        array ( 'tag' => 'javascript', 'text' => $TEXT['page']->get('matrix_help_javascript') ),
        array ( 'tag' => 'jquery', 'text' => $TEXT['page']->get('matrix_help_jquery') ),
        array ( 'tag' => 'jquerytools', 'text' => $TEXT['page']->get('matrix_help_jquerytools') ),

        array ( 'tag' => 'body', 'text' => $TEXT['page']->get('matrix_help_body') ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'DOCTYPE',
    'title' => $TEXT['template']->get('general_doctype_title'),
    'description' => $TEXT['template']->get('general_doctype_desc'),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
    )
);



// Init Template-Page
echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, ensure_copyright ( 'MAIN' ) );
?>
