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
    if (get_magic_quotes_gpc() || get_magic_quotes_runtime()) {
        ini_set('magic_quotes_gpc', 0);
        ini_set('magic_quotes_runtime', 0);
    }

    // Default libloader
    if (is_null($libloader)) {
        $libloader = create_function ('$classname', '
            $class = explode("\\\\", $classname);
            $filename = \'libs/class_\'.end($class).\'.php\';
            if (file_exists(FS2_ROOT_PATH . $filename)) {
                include_once(FS2_ROOT_PATH . $filename);
            } else {
                return false;
            }
        ');
    }

    // no libloader?
    if ($libloader === false)
        spl_autoload_register();
    else
        spl_autoload_register($libloader);
}

?>
