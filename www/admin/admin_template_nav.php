<?php
    $TEMPLATE_GO = 'style_nav';
    $TEMPLATE_FILE = 'nav';
    $TEMPLATE_EDIT = null;

    $tmp = array (
        'name' => 'NAV',
        'title' => $FD->text("template", "nav_files_title"),
        'description' => $FD->text("template", "nav_files_desc"),
        'rows' => 35,
        'cols' => 66,
        'help' => array (
        )
    );
    $TEMPLATE_EDIT[] = $tmp;

    echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, TRUE, TRUE );
?>
