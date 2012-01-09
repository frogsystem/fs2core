<?php
###################
## Feed Settings ##
###################

$feed_url = "feeds/rss20.php";
$to_html = array('b', 'i', 'u', 's', 'center', 'url', 'home', 'email', 'list', 'numlist');
$to_text = array('img', 'cimg', 'font', 'color', 'size', 'code', 'quote', 'video', 'noparse');
$to_bbcode = array();
$shortening = false;
$extension = "...";
$use_html = true;
$tpl_functions = "softremove";

##################
## Settings End ##
##################
 

// Set header
header("Content-type: application/xml");

// Disable magic_quotes_runtime
ini_set('magic_quotes_runtime', 0);

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

// Inlcude DB Connection File or exit()
require( FS2_ROOT_PATH . "login.inc.php");
 
//Include Functions-Files & Feed-Lib
require_once(FS2_ROOT_PATH . "includes/functions.php");
require_once(FS2_ROOT_PATH . "libs/class_Feed.php");


// compose settings
$settings = array (
        'to_html' => $to_html,
        'to_text' => $to_text,
        'to_bbcode' => $to_bbcode,
        'shortening' => $shortening,
        'extension' => $extension,
        'use_html' => $use_html,
        'tpl_functions' => $tpl_functions,
);

// create feed
$rss20 = new RSS20($FD->cfg('virtualhost').$feed_url, $settings);
echo $rss20;

// Shutdown System
unset($FD);
?>
