<?php
    $TEMPLATE_GO = "style_js";
    $TEMPLATE_FILE = "js";
    $TEMPLATE_EDIT = null;

    $tmp = array (
        name => "JS",
        title => $admin_phrases[template][js_userfunctions][title],
        description => $admin_phrases[template][js_userfunctions][description],
        rows => 35,
        cols => 66,
        help => array (
        )
    );
    $TEMPLATE_EDIT[] = $tmp;

    echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, TRUE, TRUE, 3 );
?>