<?php
// Start Session
session_start();
// Disable magic_quotes_runtime
set_magic_quotes_runtime ( FALSE );

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

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

    //Include Phrases-Files
    require ( FS2_ROOT_PATH . "phrases/phrases_".$global_config_arr['language'].".php" );
    $TEXT = new langDataInit ( $global_config_arr['language_text'], "frontend" );


    // Constructor Calls
    set_style ();
    copyright ();

    // Reload Page
    if ( !$_POST['article_text'] && !$_POST['sended'] )
    {
        // Reload Page Template
     $template = '
<html>
    <head>
        <title>Frogsystem 2 - Artikelvorschau</title>
        <script>
            function loaddata()
            {
                document.getElementById(\'article_title\').value = opener.document.getElementById(\'article_title\').value;
                document.getElementById(\'article_user\').value = opener.document.getElementById(\'userid\').value;
                document.getElementById(\'article_user_name\').value = opener.document.getElementById(\'username\').value;

                document.getElementById(\'d\').value = opener.document.getElementById(\'d\').value;
                document.getElementById(\'m\').value = opener.document.getElementById(\'m\').value;
                document.getElementById(\'y\').value = opener.document.getElementById(\'y\').value;

                if ( opener.document.getElementById(\'article_html\').checked == true ) {
                    document.getElementById(\'article_html\').value = 1;
                } else {
                    document.getElementById(\'article_html\').value = 0;
                }
                if ( opener.document.getElementById(\'article_fscode\').checked == true ) {
                    document.getElementById(\'article_fscode\').value = 1;
                } else {
                    document.getElementById(\'article_fscode\').value = 0;
                }
                if ( opener.document.getElementById(\'article_para\').checked == true ) {
                    document.getElementById(\'article_para\').value = 1;
                } else {
                    document.getElementById(\'article_para\').value = 0;
                }
                
                document.getElementById(\'article_text\').value = opener.document.getElementById(\'article_text\').value;

                document.getElementById(\'form\').submit();
            }
        </script>
    </head>
    <body onLoad="loaddata()">
        <form action="'.$global_config_arr['virtualhost'].'admin/admin_articles_prev.php" method="post" id="form">
            <input type="hidden" name="sended" id="sended" value="1">
            <input type="hidden" name="article_title" id="article_title" value="">
            <input type="hidden" name="article_user" id="article_user" value="">
            <input type="hidden" name="article_user_name" id="article_user_name" value="">
            <input type="hidden" name="d" id="d" value="">
            <input type="hidden" name="m" id="m" value="">
            <input type="hidden" name="y" id="y" value="">
            <input type="hidden" name="article_html" id="article_html" value="">
            <input type="hidden" name="article_fscode" id="article_fscode" value="">
            <input type="hidden" name="article_para" id="article_para" value="">
            <input type="hidden" name="article_text" id="article_text" value="">
        </form>
    </body>
</html>';

        // "Display" Reload Page
        echo $template;
    }

    // Preview Page
    else {

        // Load Data from $_POST
        $article_arr['article_title'] = stripslashes ( $_POST['article_title'] );

        // Create Article-Date
        if (
                ( $_POST['d'] && $_POST['d'] != "" && $_POST['d'] > 0 ) &&
                ( $_POST['m'] && $_POST['m'] != "" && $_POST['m'] > 0 ) &&
                ( $_POST['y'] && $_POST['y'] != "" && $_POST['y'] > 0 ) &&
                ( isset ( $_POST['d'] ) && isset ( $_POST['m'] ) && isset ( $_POST['y'] ) )
            )
        {
            settype ( $_POST['d'], "integer" );
            settype ( $_POST['m'], "integer" );
            settype ( $_POST['y'], "integer" );
            $article_arr['article_date'] = mktime ( 0, 0, 0, $_POST['m'], $_POST['d'], $_POST['y'] );
        } else {
            $article_arr['article_date'] = 0;
        }
        // Get Date & Create Date Template
        if ( $article_arr['article_date'] != 0 ) {
            $article_arr['date_formated'] = date_loc ( $global_config_arr['date'], $article_arr['article_date'] );
            // Create Template
            $date_template = new template();
            $date_template->setFile ( "0_articles.tpl" );
            $date_template->load ( "DATE" );
            $date_template->tag ( "date", $article_arr['date_formated'] );
            $article_arr['date_template'] = $date_template->display ();
        } else {
            $article_arr['date_formated'] = "";
            $article_arr['date_template'] = "";
        }

        // Format Article-Text
        settype ( $_POST['article_html'], "integer" );
        settype ( $_POST['article_fscode'], "integer" );
        settype ( $_POST['article_para'], "integer" );
        $article_arr['article_text'] = fscode ( $_POST['article_text'], $_POST['article_fscode'], $_POST['article_html'], $_POST['article_para'] );

        // Format User
        $article_arr['article_user_name'] = killhtml ( $_POST['article_user_name'] );
        $article_arr['article_user'] = $_POST['article_user'];
        settype ( $article_arr['article_user'], "integer" );

        // Create User Template
        if ( $article_arr['article_user_name'] != "" && $article_arr['article_user'] > 0 ) {
            $user_arr['user_id'] = $article_arr['article_user'];
            $user_arr['user_name'] = $article_arr['article_user_name'];
            $user_arr['user_url'] = '?go=user&id='.$user_arr['user_id'];
            
            // Create Template
            $author_template = new template();
            $author_template->setFile ( "0_articles.tpl" );
            $author_template->load ( "AUTHOR" );

            $author_template->tag ( "user_id", $user_arr['user_id'] );
            $author_template->tag ( "user_name", $user_arr['user_name'] );
            $author_template->tag ( "user_url", $user_arr['user_url'] );

            $article_arr['author_template'] = $author_template->display ();
        } else {
            $article_arr['author_template'] = "";
            $user_arr['user_id'] = "";
            $user_arr['user_name'] = "";
            $user_arr['user_url'] = "";
        }

        // Create Template
        $article_arr['template'] = new template();
        $article_arr['template']->setFile ( "0_articles.tpl" );
        $article_arr['template']->load ( "BODY" );

        $article_arr['template']->tag ( "title", $article_arr['article_title'] );
        $article_arr['template']->tag ( "text", $article_arr['article_text'] );
        $article_arr['template']->tag ( "date_template", $article_arr['date_template'] );
        $article_arr['template']->tag ( "date", $article_arr['date_formated'] );
        $article_arr['template']->tag ( "author_template", $article_arr['author_template'] );
        $article_arr['template']->tag ( "user_id", $user_arr['user_id'] );
        $article_arr['template']->tag ( "user_name", $user_arr['user_name'] );
        $article_arr['template']->tag ( "user_url", $user_arr['user_url'] );
        $template_preview = $article_arr['template']->display ();


        // Preview Page Template
        $global_config_arr['title'] = "Frogsystem 2 - Artikelvorschau: " . $global_config_arr['title'];

        $template_general = new template();
        $template_general->setFile("0_general.tpl");
        $template_general->load("MAINPAGE");
        $template_general->tag("content", $template_preview );
        $template_general->tag("copyright",  get_copyright ());
        $template_general = $template_general->display();

        $template_general = replace_snippets ( $template_general );
        $template_general = replace_navigations ( $template_general );
        $template_general = replace_applets ( $template_general );
        $template_general = replace_navigations ( $template_general );
        $template_general = replace_snippets ( $template_general );
        $template_general = replace_globalvars ( $template_general );

        // Get Main Template
        $template = get_maintemplate ( "../" );
        $template = str_replace ( "{..body..}", $template_general, $template);

        // Display Preview Page
        echo $template;
    }
    mysql_close ( $db );
}
?>