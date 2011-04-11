<?php
// Start Session
session_start();

// Disable magic_quotes_runtime
set_magic_quotes_runtime(FALSE);

// fs2 include path
set_include_path('.');
define('FS2_ROOT_PATH', "./../", TRUE);

// Inlcude DB Connection File
require(FS2_ROOT_PATH."login.inc.php");

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
    $TEXT = new langDataInit ( $global_config_arr['language_text'], "frontend" );


    // Constructor Calls
    set_style ();
    copyright ();

    // Reload Page
    if ( !$_POST['sended'] )
    {
        // Set Number of Links
        $num_links = $_GET['i'];
        settype($num_links, "integer");

        // Reload Page Template
        $template = '
<html>
    <head>
        <title>Frogsystem 2 - Newsvorschau</title>
        <script type="text/javascript" src="../resources/jquery/jquery-1.4.min.js"></script>
        <script>
            function loaddata()
            {
                document.getElementById(\'news_title\').value = $(opener.document).find("#news_title").val();
                document.getElementById(\'news_text\').value = $(opener.document).find("#news_text").val();

                document.getElementById(\'news_user\').value = $(opener.document).find("#userid").val();
                document.getElementById(\'news_user_name\').value = $(opener.document).find("[name=poster]").val();
                
                document.getElementById(\'news_cat_id\').value = $(opener.document).find("[name=cat_id]").val();

                document.getElementById(\'d\').value = $(opener.document).find("[name=d]").val();
                document.getElementById(\'m\').value = $(opener.document).find("[name=m]").val();
                document.getElementById(\'y\').value = $(opener.document).find("[name=y]").val();
                document.getElementById(\'h\').value = $(opener.document).find("[name=h]").val();
                document.getElementById(\'i\').value = $(opener.document).find("[name=i]").val();';

        for($i=0;$i<$num_links;$i++) {
            $template .= '

                document.getElementById(\'linkname_'.$i.'\').value      = $(opener.document).find("[name=linkname['.$i.']]").val();
                document.getElementById(\'linkurl_'.$i.'\').value       = $(opener.document).find("[name=linkurl['.$i.']]").val();
                document.getElementById(\'linktarget_'.$i.'\').value    = $(opener.document).find("[name=linktarget['.$i.']]").val();';
            }

        $template .= '
                document.getElementById(\'form\').submit();
            }
        </script>
    </head>
    <body onLoad="loaddata()">
        <form action="'.$global_config_arr['virtualhost'].'admin/admin_news_prev.php" method="post" id="form">
            <input type="hidden" name="sended" id="sended" value="1">
            <input type="hidden" name="num_links" value="'.$num_links.'">
            
            <input type="hidden" name="news_title" id="news_title" value="">
            <input type="hidden" name="news_text" id="news_text" value="">
            
            <input type="hidden" name="news_user" id="news_user" value="">
            <input type="hidden" name="news_user_name" id="news_user_name" value="">
            
            <input type="hidden" name="news_cat_id" id="news_cat_id" value="">
            
            <input type="hidden" name="d" id="d" value="">
            <input type="hidden" name="m" id="m" value="">
            <input type="hidden" name="y" id="y" value="">
            <input type="hidden" name="h" id="h" value="">
            <input type="hidden" name="i" id="i" value="">';

        for($i=0;$i<$num_links;$i++) {
            $template .= '

            <input type="hidden" name="linkname['.$i.']" id="linkname_'.$i.'" value="">
            <input type="hidden" name="linkurl['.$i.']" id="linkurl_'.$i.'" value="">
            <input type="hidden" name="linktarget['.$i.']" id="linktarget_'.$i.'" value="">';
        }

        $template .= '
        </form>
    </body>
</html>';

        // "Display" Reload Page
        echo $template;
    }

    // Preview Page
    else {
        // Set Number of Links
        settype($_POST['num_links'], "integer");
        
        // Get News Config
        $index = mysql_query("SELECT * FROM `".$global_config_arr['pref']."news_config` WHERE `id` = '1'", $db);
        $config_arr = mysql_fetch_assoc($index);

        // Load Data from $_POST
        $news_arr['comment_url'] = "admin/admin_news_prev.php?i=".$_POST['num_links'];
        $news_arr['kommentare'] = "?";
        
        // Create New-Date
        if (
                ( $_POST['d'] && $_POST['d'] != "" && $_POST['d'] > 0 ) &&
                ( $_POST['m'] && $_POST['m'] != "" && $_POST['m'] > 0 ) &&
                ( $_POST['y'] && $_POST['y'] != "" && $_POST['y'] > 0 ) &&
                ( $_POST['h'] && $_POST['h'] != "" && $_POST['h'] >= 0 ) &&
                ( $_POST['i'] && $_POST['i'] != "" && $_POST['i'] >= 0 ) &&
                ( isset ( $_POST['d'] ) && isset ( $_POST['m'] ) && isset ( $_POST['y'] ) && isset ( $_POST['h'] ) && isset ( $_POST['i'] ))
            )
        {
            settype ( $_POST['d'], "integer" );
            settype ( $_POST['m'], "integer" );
            settype ( $_POST['y'], "integer" );
            settype ( $_POST['h'], "integer" );
            settype ( $_POST['i'], "integer" );
            $news_arr['news_date'] = mktime ( $_POST['h'], $_POST['i'], 0, $_POST['m'], $_POST['d'], $_POST['y'] );
        } else {
            $news_arr['news_date'] = 0;
        }
        $news_arr['news_date'] = date_loc( $global_config_arr['datetime'] , $news_arr['news_date']);

        // Create User Template
        $news_arr['user_name'] = killhtml($_POST['news_user_name']);
        settype($_POST['news_user'], "integer");
        $news_arr['user_url'] = '?go=user&amp;id='.$_POST['news_user'];

        // Text formatieren
        $html = ($config_arr['html_code'] == 2 || $config_arr['html_code'] == 4) ? TRUE : FALSE;
        $fs = ($config_arr['fs_code'] == 2 || $config_arr['fs_code'] == 4) ? TRUE : FALSE;
        $para = ($config_arr['para_handling'] == 2 || $config_arr['para_handling'] == 4) ? TRUE : FALSE;
        
        $news_arr['news_text'] = fscode ( $_POST['news_text'], $fs, $html, $para );
        $news_arr['news_title'] = killhtml ( $_POST['news_title'] );

        // Kategorie lesen
        settype($_POST['news_cat_id'], "integer");
        $index = mysql_query("SELECT `cat_name`, `cat_id` FROM `".$global_config_arr['pref']."news_cat` WHERE `cat_id` = '".$_POST['news_cat_id']."'", $db);
        $cat_arr = mysql_fetch_assoc($index);
        if (!empty($cat_arr)) {
			$cat_arr['cat_name'] = killhtml($cat_arr['cat_name']);
		} else {
			$cat_arr['cat_name'] = "?";
		}
        $cat_arr['cat_pic'] = image_url("images/cat/", "news_".$cat_arr['cat_id']);


        // Get Related Links
        $link_tpl = "";

        if (isset($_POST['linkname'],$_POST['linkurl'],$_POST['linktarget'])) {
            foreach($_POST['linkname'] as $key => $linkname)
            {
                if ( $_POST['linkname'][$key] != "" && $_POST['linkurl'][$key] != "" ) {
                    $link_arr['link_name'] = killhtml ($_POST['linkname'][$key] );
                    $link_arr['link_url'] = killhtml ($_POST['linkurl'][$key]);
                    $link_arr['link_target'] = ( $_POST['linktarget'][$key] == 1 ) ? "_blank" : "_self";

                    // Get Link Line Template
                    $link = new template();
                    $link->setFile("0_news.tpl");
                    $link->load("LINKS_LINE");

                    $link->tag("title", $link_arr['link_name'] );
                    $link->tag("url", $link_arr['link_url'] );
                    $link->tag("target", $link_arr['link_target'] );

                    $link = $link->display ();
                    $link_tpl .= $link;
                }
            }
        }
        if ($link_tpl != "") {
            // Get Links Body Template
            $related_links = new template();
            $related_links->setFile("0_news.tpl");
            $related_links->load("LINKS_BODY");
            $related_links->tag("links", $link_tpl );
            $related_links = $related_links->display ();
        } else {
            $related_links = "";
        }
         
        // Create Template
        $template = new template();
        $template->setFile("0_news.tpl");
        $template->load("NEWS_BODY");

        $template->tag("news_id", 0 );
        $template->tag("titel", $news_arr['news_title'] );
        $template->tag("date", $news_arr['news_date'] );
        $template->tag("text", $news_arr['news_text'] );
        $template->tag("user_name", $news_arr['user_name'] );
        $template->tag("user_url", $news_arr['user_url'] );
        $template->tag("cat_name", $cat_arr['cat_name'] );
        $template->tag("cat_image", $cat_arr['cat_pic'] );
        $template->tag("comments_url", $news_arr['comment_url'] );
        $template->tag("comments_number", $news_arr['kommentare'] );
        $template->tag("related_links", $related_links );
        $template_preview = $template->display();


        // Preview Page Template
        $global_config_arr['dyn_title'] == 1;
        $global_config_arr['dyn_title_ext'] = "{ext}";
        $global_config_arr['dyn_title_page'] = "Frogsystem 2 - Newsvorschau: " . $news_arr['news_title'];

        $theTemplate = new template();
        $theTemplate->setFile("0_general.tpl");
        $theTemplate->load("MAINPAGE");
        $theTemplate->tag("content", $template_preview);
        $theTemplate->tag("copyright",  get_copyright ());

        $template_general = $theTemplate->display();
        $template_general = replace_snippets ( $template_general );
        $template_general = replace_navigations ( $template_general );
        $template_general = replace_applets ( $template_general );
        $template_general = replace_navigations ( $template_general );
        $template_general = replace_snippets ( $template_general );

        $template_general = replace_globalvars ( $template_general );

        // Get Main Template
        $template = get_maintemplate ($global_config_arr['virtualhost'], "../");
        $template = str_replace ( "{..body..}", $template_general, $template);
        echo $template;
    }
    mysql_close ( $db );
}
?>
