<?php
    // list of function files
    $list = array(
        'functions.php',
        'newfunctions.php',
        'cookielogin.php',
        'fscode.php',
        'imagefunctions.php',
        'indexfunctions.php',
        'searchfunctions.php',
    );
    
    // include the files
    foreach ($list as $file) {
        include_once(FS2SOURCE.'/includes/'.$file);
    }
?>
