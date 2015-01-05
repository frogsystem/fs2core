<?php
header('Content-type: application/xml');
require_once(FS2SOURCE . '/libs/class_Feed.php');
include(FS2SOURCE.'/feeds/'.$_GET['xml'].'.php');
exit;
?>
