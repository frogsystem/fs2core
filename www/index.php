<?php
// Start Session
session_start();

// Disable magic_quotes_runtime
ini_set('magic_quotes_runtime', 0);

// fs2 include path
set_include_path('.');
define('FS2_ROOT_PATH', "./", TRUE);

//autoloader
function libloader ($classname) {
    @include_once(FS2_ROOT_PATH . "libs/class_".$classname.".php");
}
spl_autoload_register("libloader");


// Inlcude DB Connection File
require_once(FS2_ROOT_PATH . "includes/functions.php");       
require_once(FS2_ROOT_PATH . "libs/class_GlobalData.php");
require_once(FS2_ROOT_PATH . "login.inc.php");

//////////////////////////////////
//// DB Connection etablished ////
//////////////////////////////////
if (isset($sql) && $sql->conn() !== false) {
        
    //Include Functions-Files
    require_once(FS2_ROOT_PATH . "includes/cookielogin.php");
    require_once(FS2_ROOT_PATH . "includes/imagefunctions.php");
    require_once(FS2_ROOT_PATH . "includes/indexfunctions.php");

    //Include Library-Classes
    require_once(FS2_ROOT_PATH . "libs/class_HashMapper.php");
    require_once(FS2_ROOT_PATH . "libs/class_template.php");
    require_once(FS2_ROOT_PATH . "libs/class_fileaccess.php");
    require_once(FS2_ROOT_PATH . "libs/class_lang.php");
    require_once(FS2_ROOT_PATH . "libs/class_search.php");
    require_once(FS2_ROOT_PATH . "libs/class_searchquery.php");
    require_once(FS2_ROOT_PATH . "libs/class_Mail.php");
    require_once(FS2_ROOT_PATH . "libs/class_MailManager.php");
    

    // Load Text TODO: backwards compatibiliy
    $TEXT['frontend'] = $FD->getOldTetxt();


    // Constructor Calls
    setTimezone($FD->cfg("timezone"));
    delete_old_randoms();
    search_index();
    set_style();
    copyright();
    get_goto($_GET['go']);
    count_all($FD->cfg('goto'));
    save_referer();
    save_visitors();
    


    // Get Body-Template
    $theTemplate = new template();
    $theTemplate->setFile("0_main.tpl");
    $theTemplate->load("MAIN");
    $theTemplate->tag("content", get_content($FD->cfg('goto')));
    $theTemplate->tag("copyright", get_copyright());
    
    $template_general = (string) $theTemplate;
    $template_general = tpl_functions_init($template_general);
    
    // Display Page
    echo get_maintemplate($template_general);
}

// Close Connection
unset($sql); // TODO
?>
