<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('id'));

// Load Config Array
$FD->loadConfig('downloads');

if ($FD->cfg('downloads', 'dl_comments') == 1) {
    include_once(FS2_ROOT_PATH.'classes/downloads/dlcomments.php');
} else {
    include_once(FS2_ROOT_PATH.'classes/downloads/dlfile.php');
}

?>
