<?php
// Start Session
session_start();

// Disable magic_quotes_runtime
set_magic_quotes_runtime ( FALSE );

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

// inlcude files
require( FS2_ROOT_PATH . "login.inc.php");
require( FS2_ROOT_PATH . "includes/functions.php");
require( FS2_ROOT_PATH . "includes/adminfunctions.php");

//Include Library-Classes
require ( FS2_ROOT_PATH . "libs/class_langDataInit.php");

//Include Phrases-Files
require ( FS2_ROOT_PATH . "phrases/phrases_".$global_config_arr['language'].".php" );
require ( FS2_ROOT_PATH . "phrases/admin_phrases_".$global_config_arr['language'].".php" );
$TEXT['admin'] = new langDataInit ( "de_DE", "admin" );

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>'.$TEXT["admin"]->get("applets_find_pagetitle").'</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script src="../resources/jquery/jquery-1.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            $("tr.pointer").hover(
                function () {
                    $(this).css("background-color", "#EEEEEE");
                },
                function () {
                    $(this).css("background-color", "transparent");
                }
            );
            $("tr.pointer").click(
                function () {
                    $(opener.document).find("#applet_file").val( $(this).find("input:hidden").val() );
                    self.close();
                }
            );
        });
    </script>
</head>
<body id="find_body">
    <div id="find_head">
        &nbsp;<img border="0" src="img/pointer.png" alt="" style="vertical-align:text-top">
        <b>'.$TEXT["admin"]->get("applets_find_title").'</b>
    </div>
    <br>
    <div align="center">
';


$files = scandir_ext ( FS2_ROOT_PATH . "applets", "php" );
if ( count ( $files ) < 1 ) {
    $content = '
                    <table cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td align="center">
                                '.$TEXT["admin"]->get("applets_not_found").'
                            </td>
                        </tr>
                    </table>
    ';
} else {
    $content = '
                    <table cellpadding="4" cellspacing="0" width="100%">
    ';
    foreach ( $files as $file ) {
        $filename = basename ( $file, ".php" );
        $content .= '
                        <tr class="pointer">
                            <td>
                                &raquo; '.$file.'
                                <input type="hidden" value="'.$filename.'">
                            </td>
                        </tr>
        ';
    }
    $content .= '
                    </table>
    ';
}

echo get_content_container ( "&raquo; ".$TEXT["admin"]->get("file_select_button"), $content, "width:100%;", "font-weight:bold; text-align:left; padding-left:20px; padding-top:20px;", "margin-left:25px; margin-right:33px; padding:0px;"  );

echo'
    </div>
</body>
</html>
';

?>