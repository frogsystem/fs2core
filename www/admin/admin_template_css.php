<?php if (!defined('ACP_GO')) die('Unauthorized access!');

    $TEMPLATE_GO = 'style_css';
    $TEMPLATE_FILE = 'css';
    $TEMPLATE_EDIT = null;

    $tmp = array (
        'name' => 'CSS',
        'title' => $FD->text("template", "style_css_title"),
        'description' => $FD->text("template", "style_css_description"),
        'rows' => 35,
        'cols' => 66,
        'help' => array (
        )
    );
    $TEMPLATE_EDIT[] = $tmp;

    echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, TRUE, TRUE, 2 );
?>
