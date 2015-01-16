<?php if (!defined('ACP_GO')) die('Unauthorized access!');

$TEMPLATE_GO = 'tpl_main';
$TEMPLATE_FILE = '0_main.tpl';
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
    'name' => 'MAIN',
    'title' => $FD->text("template", "general_mainpage_title"),
    'description' => $FD->text("template", "general_mainpage_desc"),
    'rows' => 30,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'content', 'text' => $FD->text("template", "general_mainpage_content") ),
        array ( 'tag' => 'copyright', 'text' => $FD->text("template", "general_mainpage_copyright") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'MATRIX',
    'title' => $FD->text("template", "main_matrix_title"),
    'description' => $FD->text("template", "main_matrix_desc"),
    'rows' => 20,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'doctype', 'text' => $FD->text("template", "matrix_help_doctype") ),
        array ( 'tag' => 'language', 'text' => $FD->text("template", "matrix_help_language") ),
        array ( 'tag' => 'base_tag', 'text' => $FD->text("template", "matrix_help_base_tag") ),
        array ( 'tag' => 'title', 'text' => $FD->text("template", "matrix_help_title") ),
        array ( 'tag' => 'title_tag', 'text' => $FD->text("template", "matrix_help_title_tag") ),
        array ( 'tag' => 'meta_tags', 'text' => $FD->text("template", "matrix_help_meta_tags") ),

        array ( 'tag' => 'css_links', 'text' => $FD->text("template", "matrix_help_css_links") ),
        array ( 'tag' => 'favicon_link', 'text' => $FD->text("template", "matrix_help_favicon_link") ),
        array ( 'tag' => 'feed_link', 'text' => $FD->text("template", "matrix_help_feed_link") ),

        array ( 'tag' => 'javascript', 'text' => $FD->text("template", "matrix_help_javascript") ),

        array ( 'tag' => 'body', 'text' => $FD->text("template", "matrix_help_body") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'DOCTYPE',
    'title' => $FD->text("template", "general_doctype_title"),
    'description' => $FD->text("template", "general_doctype_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
    )
);



// Init Template-Page
echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, ensure_copyright ( 'MAIN' ) );
?>
