<?php
/* Main source files of the Frogsystem 2 */
define('FS2SOURCE', '/var/usr/bin/fs2');

/* Debugging and enviroment */
define('FS2_DEBUG', true); // enables debugging output
define('FS2_ENV', 'stage'); // enables env specific config files (e.g. env-stage.cfg.php)

/* Installation is a satellite of a multi-site network */
define('IS_SATELLITE', false);

/* Main content location (webserver root) */
define('FS2CONTENT', '/var/usr/www/user');

/* Specific content locations */
define('FS2LANG', FS2SOURCE.'/lang');
define('FS2APPLETS', FS2CONTENT.'/applets');
define('FS2CONFIG', FS2CONTENT.'/config');
define('FS2MEDIA', FS2CONTENT.'/media');
define('FS2STYLES', FS2CONTENT.'/styles');
define('FS2UPLOAD', FS2CONTENT.'/upload');
?>
