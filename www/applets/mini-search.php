<?php
// Get save keyword
$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
$keyword = ( $global_config_arr['goto'] == 'search' ) ? trim ( $keyword ) : '';

// Display Mini Search
$template = new template();
$template->setFile('0_search.tpl');
$template->load('APPLET');
$template->tag('keyword', $keyword );
$template = $template->display();
?>
