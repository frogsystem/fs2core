<?php
require_once(FS2SOURCE . '/libs/class_Feed.php');
$feed = FS2SOURCE.'/classes/feeds/'.$_GET['xml'].'.php';
if (file_exists($feed)) {
    header('Content-type: application/xml');
    include($feed);
    exit;
} else {
    $template = sys_message($FD->text('frontend', 'systemmessage'), $FD->text('frontend', 'file_not_found'), 404 );
}
?>
