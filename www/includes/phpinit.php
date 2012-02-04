<?php
function phpinit ($session = true, $header = false, $libloader = null) {
    
    // Header?
    if ($header !== false) {
        // Set header
        header($header);        
    }
    
    // Start Session
    if ($session)
        session_start();
        
    // Disable magic_quotes_runtime
    ini_set('magic_quotes_runtime', 0);
    
    // Default libloader
    if (is_null($libloader)) {
        $libloader = function ($classname) {
            @include_once(FS2_ROOT_PATH . "libs/class_".$classname.".php");
        };
    }
    
    // no libloader?
    if ($libloader === false)
        spl_autoload_register();
    else
        spl_autoload_register($libloader);
}

?>
