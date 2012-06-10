<?php
    $TEMPLATE_GO = 'style_nav';
    $TEMPLATE_FILE = 'nav';
    $TEMPLATE_EDIT = null;

    $tmp = array (
        'name' => 'NAV',
        'title' => $TEXT['template']->get('nav_files_title'),
        'description' => $TEXT['template']->get('nav_files_desc'),
        'rows' => 35,
        'cols' => 66,
        'help' => array (
        )
    );
    $TEMPLATE_EDIT[] = $tmp;

    echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, TRUE, TRUE );
?>
