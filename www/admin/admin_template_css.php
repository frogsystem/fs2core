<?php
    $TEMPLATE_GO = "style_css";
    $TEMPLATE_FILE = "css";
    $TEMPLATE_EDIT = null;

    $tmp = array (
        name => "CSS",
        title => $admin_phrases[template][style_css][title],
        description => $admin_phrases[template][style_css][description],
        rows => 35,
        cols => 66,
        help => array (
        )
    );
    $TEMPLATE_EDIT[] = $tmp;

    echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE, TRUE, TRUE, 2 );
?>