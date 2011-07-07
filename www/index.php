<?php
// Start Session
session_start();

// Disable magic_quotes_runtime
ini_set('magic_quotes_runtime', 0);

// fs2 include path
set_include_path('.');
define('FS2_ROOT_PATH', "./", TRUE);

// Inlcude DB Connection File
require(FS2_ROOT_PATH . "login.inc.php");

//////////////////////////////////
//// DB Connection etablished ////
//////////////////////////////////
if (isset($db) && $db !== false && isset($global_config_arr)) {
    
    //Include Functions-Files
    require(FS2_ROOT_PATH . "includes/functions.php");
    require(FS2_ROOT_PATH . "includes/newfunctions.php");    
    require(FS2_ROOT_PATH . "includes/cookielogin.php");
    require(FS2_ROOT_PATH . "includes/imagefunctions.php");
    require(FS2_ROOT_PATH . "includes/indexfunctions.php");

    //Include Library-Classes
    require(FS2_ROOT_PATH . "libs/class_template.php");
    require(FS2_ROOT_PATH . "libs/class_fileaccess.php");
    require(FS2_ROOT_PATH . "libs/class_lang.php");
    require(FS2_ROOT_PATH . "libs/class_search.php");
    require(FS2_ROOT_PATH . "libs/class_searchquery.php");
    

    // Load Text 
    $TEXT['frontend'] = new lang ($global_config_arr['language_text'], "frontend");


    // Constructor Calls
    delete_old_randoms();
    search_index();
    set_style();
    copyright();
    get_goto($_GET['go']);
    count_all($global_config_arr['goto']);
    save_referer();
    save_visitors();


    // Get Body-Template
    $theTemplate = new template();
    $theTemplate->setFile("0_main.tpl");
    $theTemplate->load("MAIN");
    $theTemplate->tag("content", get_content($global_config_arr['goto']));
    $theTemplate->tag("copyright", get_copyright());
    
    $template_general = (string) $theTemplate;
    $template_general = tpl_replacements($template_general);
    
    // Display Page
    echo get_maintemplate($template_general);
}

// Close Connection
unset($db, $sql);
?>
