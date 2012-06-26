<?php
$TEMPLATE_GO = 'tpl_previewimg';
$TEMPLATE_FILE = '0_previewimg.tpl';
$TEMPLATE_EDIT = array();

$TEMPLATE_EDIT[] = array (
    'name' => 'BODY',
    'title' => $FD->text("template", "previewimg_body_title"),
    'description' => $FD->text("template", "previewimg_body_desc"),
    'rows' => 25,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'previewimg', 'text' => $FD->text("template", "previewimg_body_previewimg") ),
        array ( 'tag' => 'previewimg_url', 'text' => $FD->text("template", "previewimg_body_previewimg_url") ),
        array ( 'tag' => 'image_url', 'text' => $FD->text("template", "previewimg_body_image_url") ),
        array ( 'tag' => 'viewer_url', 'text' => $FD->text("template", "previewimg_body_viewer_url") ),
        array ( 'tag' => 'caption', 'text' => $FD->text("template", "previewimg_body_caption") ),
        array ( 'tag' => 'cat_title', 'text' => $FD->text("template", "previewimg_body_cat_title") ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'NOIMAGE_BODY',
    'title' => $FD->text("template", "previewimg_noimg_body_title"),
    'description' => $FD->text("template", "previewimg_noimg_body_desc"),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
    )
);

// Init Template-Page
echo templatepage_init ( $TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE );
?>
