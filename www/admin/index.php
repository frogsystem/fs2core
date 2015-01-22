<?php
// Getting config
@include_once(getenv('FS2CONFIG') ?: realpath(__DIR__.'/../config/main.cfg.php'));
@define('FS2SOURCE', realpath(__DIR__.'/../'));

// Init system
require_once(FS2SOURCE . '/libs/class_Frogsystem2.php');
$FS2 = new Frogsystem2(realpath(__DIR__.'/../'));
$FS2->deploy(true);
?>
