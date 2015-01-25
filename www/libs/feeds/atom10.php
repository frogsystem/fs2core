<?php
###################
## Feed Settings ##
###################
$feed_url = 'feeds/atom10.php';
$settings = array (
    'to_html' => array(),
    'to_text' => array('b', 'i', 'u', 's', 'center', 'url', 'home', 'email', 'list', 'numlist', 'img', 'cimg', 'font', 'color', 'size', 'code', 'quote', 'video', 'nofscode', 'fscode', 'html', 'nohtml'),
    'to_bbcode' => array(),
	'truncate' => false, // Set to length if you want to cut!
	'truncate_extension' => ' &hellip;',
	'truncate_awareness' => array('word' => true, 'html' => true, 'bbcode' => false),
	'truncate_options' => array('count_html' => false, 'count_bbcode' => false, 'below' => true),
    'use_html' => true,
    'tpl_functions' => 'softremove',
    'cat_filter' => array(),
    'cat_prepend' => false
);
##################
## Settings End ##
##################

// create feed
header('Content-type: application/atom+xml');
$atom10 = new Atom10($FD->cfg('virtualhost').$feed_url, $settings);
echo $atom10;
?>
