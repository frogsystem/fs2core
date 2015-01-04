<?php
// Getting config
@include_once($_ENV['FS2CONFIG'] ?: realpath(__DIR__.'/../config/main.cfg.php'));
@define('FS2SOURCE', realpath(__DIR__.'/../'));

// Init system
require_once(FS2SOURCE . '/libs/class_Frogsystem2.php');
global $FD;
$FS2 = new Frogsystem2(realpath(__DIR__.'/../'));

// inlcude files
require_once(FS2SOURCE . '/includes/adminfunctions.php');
require_once(FS2SOURCE . '/includes/templatefunctions.php');

//Include Library-Classes
require_once(FS2SOURCE . '/libs/class_adminpage.php');


// Include the main content file
require_once(FS2SOURCE . '/admin/admin.php');

?>
