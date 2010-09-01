<?php
$TEMPLATE_GO = "tpl_main";
$TEMPLATE_FILE = "0_main.tpl";
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
    name => "MAIN",
    title => $TEXT['template']->get("general_mainpage_title"),
    description => $TEXT['template']->get("general_mainpage_desc"),
    rows => 30,
    cols => 66,
    help => array (
        array ( tag => "content", text => $TEXT['template']->get("general_mainpage_content") ),
        array ( tag => "copyright", text => $TEXT['template']->get("general_mainpage_copyright") ),
    )
);

$TEMPLATE_EDIT[] = array (
    name => "MATRIX",
    title => $TEXT['template']->get("main_matrix_title"),
    description => $TEXT['template']->get("main_matrix_desc"),
    rows => 20,
    cols => 66,
    help => array (
    )
);

$TEMPLATE_EDIT[] = array (
    name => "DOCTYPE",
    title => $TEXT['template']->get("general_doctype_title"),
    description => $TEXT['template']->get("general_doctype_desc"),
    rows => 10,
    cols => 66,
    help => array (
    )
);



// Init Template-Page
echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, ensure_copyright ( "MAIN" ) );
?>