<?php if (!defined('ACP_GO')) die('Unauthorized access!');

    $TEMPLATE_GO = 'style_js';
    $TEMPLATE_FILE = 'js';
    $TEMPLATE_EDIT = null;

    $tmp = array (
        'name' => 'JS',
        'title' => $FD->text("template", "js_userfunctions_title"),
        'description' => $FD->text("template", "js_userfunctions_description"),
        'rows' => 35,
        'cols' => 66,
        'help' => array (
        )
    );
    $TEMPLATE_EDIT[] = $tmp;

    echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, TRUE, TRUE, 3 );
?>
