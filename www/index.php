<?php
// Start Session
session_start ();

// Disable magic_quotes_runtime
set_magic_quotes_runtime ( FALSE );

// fs2 include path
set_include_path ( '.' );
define ( 'FS2_ROOT_PATH', "./", TRUE );

// Inlcude DB Connection File
require ( FS2_ROOT_PATH . "login.inc.php");

//////////////////////////////////
//// DB Connection etablished ////
//////////////////////////////////
if ( $db ) {
    //Include Functions-Files
    require ( FS2_ROOT_PATH . "includes/functions.php" );
    require ( FS2_ROOT_PATH . "includes/cookielogin.php" );
    require ( FS2_ROOT_PATH . "includes/imagefunctions.php" );
    require ( FS2_ROOT_PATH . "includes/indexfunctions.php" );

    //Include Library-Classes
    require ( FS2_ROOT_PATH . "libs/class_template.php" );
    require ( FS2_ROOT_PATH . "libs/class_fileaccess.php" );
    require ( FS2_ROOT_PATH . "libs/class_langDataInit.php" );
    require ( FS2_ROOT_PATH . "libs/class_search.php" );
    require ( FS2_ROOT_PATH . "libs/class_searchIndex.php" );
    require ( FS2_ROOT_PATH . "libs/class_fscode.php" );

    //Include Phrases-Files
    require ( FS2_ROOT_PATH . "phrases/phrases_".$global_config_arr['language'].".php" );
    $TEXT = new langDataInit ( $global_config_arr['language_text'], "frontend" );

    // Load FS-Codes
    $fscode = new fscode();

    // Constructor Calls
    delete_old_randoms ();
    search_index ();
    set_style ();
    copyright ();
    get_goto ( $_GET['go'] );
    count_all ( $global_config_arr['goto'] );
    save_referer ();
    save_visitors ();

    // Create Index-Template
    $template_general = new template();

    $template_general->setFile("0_general.tpl");
    $template_general->load("MAINPAGE");

    $template_general->tag("content", get_content ( $global_config_arr['goto'] ));
    $template_general->tag("copyright",  get_copyright ());

    $template_general = $template_general->display();

    $template_general = replace_snippets ( $template_general );
    $template_general = replace_navigations ( $template_general );
    $template_general = replace_applets ( $template_general );
    $template_general = replace_navigations ( $template_general );
    $template_general = replace_snippets ( $template_general );

    $template_general = replace_globalvars ( $template_general );

    // Get Main Template
    $template = get_maintemplate ();
    $template = str_replace ( "{..body..}", $template_general, $template);

    // Display Page
    echo $template;

    // Close Connection
    mysql_close ( $db );
}

//////////////////////////////
//// DB Connection failed ////
//////////////////////////////
else {
    // Include German Phrases
    require ( FS2_ROOT_PATH . "libs/class_langDataInit.php");
    $TEXT = new langDataInit ( "de_DE", "frontend" );

    // No-Connection-Page Template
    $template = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>'.$TEXT->get("no_connection").'</title>
    </head>
    <body>
        <b>'.$TEXT->get("no_connection_to_the_server").'</b>
    </body>
</html>
    ';

    // Display No-Connection-Page
    echo $template;
}
?>