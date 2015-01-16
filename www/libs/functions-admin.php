<?php
    // list of function files
    $list = array(
        'adminfunctions.php',
        'templatepagefunctions.php',
    );
    
    // include the files
    foreach ($list as $file) {
        include_once(FS2SOURCE.'/libs/includes/'.$file);
    }
?>
