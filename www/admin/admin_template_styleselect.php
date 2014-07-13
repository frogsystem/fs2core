<?php if (!defined('ACP_GO')) die('Unauthorized access!');

  $TEMPLATE_GO = 'tpl_styleselect';
  $TEMPLATE_FILE = '0_style_select.tpl';
  $TEMPLATE_EDIT = null;

$TEMPLATE_EDIT[] = array (
    'name' => 'BODY',
    'title' => $FD->text('template', 'style_select_body_title'),
    'description' => $FD->text('template', 'style_select_body_desc'),
    'rows' => 15,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'styles', 'text' => $FD->text('template', 'style_select_body_styles') ),
        array ( 'tag' => 'current', 'text' => $FD->text('template', 'style_select_body_current') ),
        array ( 'tag' => 'clear_selection', 'text' => $FD->text('template', 'style_select_body_clear') ),
        array ( 'tag' => 'cookie_hint', 'text' => $FD->text('template', 'style_select_body_cookie_hint') ),
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'ENTRY',
    'title' => $FD->text('template', 'style_select_entry_title'),
    'description' => $FD->text('template', 'style_select_entry_desc'),
    'rows' => 10,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'tag', 'text' => $FD->text('template', 'style_select_entry_tag') ),
        array ( 'tag' => 'name', 'text' => $FD->text('template', 'style_select_entry_name') ),
        array ( 'tag' => 'version', 'text' => $FD->text('template', 'style_select_entry_version') ),
        array ( 'tag' => 'copy', 'text' => $FD->text('template', 'style_select_entry_copy') ),
        array ( 'tag' => 'url', 'text' => $FD->text('template', 'style_select_entry_url') )
    )
);

$TEMPLATE_EDIT[] = array (
    'name' => 'CLEAR',
    'title' => $FD->text('template', 'style_select_clear_title'),
    'description' => $FD->text('template', 'style_select_clear_desc'),
    'rows' => 5,
    'cols' => 66,
    'help' => array (
        array ( 'tag' => 'clear_url', 'text' => $FD->text('template', 'style_select_clear_url') )
    )
);

echo templatepage_init ($TEMPLATE_EDIT, $TEMPLATE_GO, $TEMPLATE_FILE);
?>
