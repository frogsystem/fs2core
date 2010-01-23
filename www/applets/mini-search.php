<?php
// Get save keyword
$keyword = $_REQUEST['keyword'];
$keyword = ( $_REQUEST['go'] == "search" ) ? trim ( $keyword ) : "";

// Display Mini Search
$template = new template();
$template->setFile("0_search.tpl");
$template->load("APPLET");
$template->tag("keyword", $keyword );
$template = $template->display();
?>