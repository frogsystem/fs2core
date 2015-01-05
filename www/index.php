<?php
// Getting config
@include_once($_ENV['FS2CONFIG'] ?: __DIR__.'/config/main.cfg.php');
@define('FS2SOURCE', __DIR__);

// Deploy page
require_once(FS2SOURCE . '/libs/class_Frogsystem2.php');
$FS2 = new Frogsystem2(__DIR__);
$FS2->deploy();
?>
