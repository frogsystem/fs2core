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
$TEXT['admin'] = new langDataInit ( "de_DE", "admin" );

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Datei finden</title>
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

            $("tr.pointer.file").click(
                function () {
                    $(opener.document).find("#furl'.$_GET['id'].'").val( $(this).find("input:hidden.url").val() );
                    
                    if($("#size:checked").length >= 1) {
                        $(opener.document).find("#fsize'.$_GET['id'].'").val( $(this).find("input:hidden.size").val() );
                    }
                    
                    self.close();
                }
            );
            
            $("tr.pointer span.folder").click(
                function () {
                    $(opener.document).find("#furl'.$_GET['id'].'").val( $(this).parents("tr.pointer").find("input:hidden.url").val() );
                    
                    if($("#size:checked").length >= 1) {
                        $(opener.document).find("#fsize'.$_GET['id'].'").val( $(this).parents("tr.pointer").find("input:hidden.size").val() );
                    }                    
                    
                    self.close();               
                }
            );
        });
    </script>
    <style type="text/css">
        .folder {
            cursor:pointer;            
        }    
        .folder:hover {
            text-decoration:underline;
        }
    </style>    
</head>
<body id="find_body">
    <div id="find_head">
        &nbsp;<img border="0" src="img/pointer.png" alt="" style="vertical-align:text-top">
        <b>Datei finden</b>
    </div>
    <br>
    <div align="center">
';

//identify directories
function ftp_is_dir($conn, $dir) {
  if (@ftp_chdir($conn, $dir)) {
    @ftp_chdir($conn, '..');
    return true;
  } else {
    return false;
  }
}


$index = mysql_query("SELECT * FROM ".$global_config_arr['pref']."ftp WHERE `ftp_id` = 1 LIMIT 0,1", $db);
if ($index !== FALSE && mysql_num_rows($index) == 1 && $c = mysql_fetch_array($index)) {
    
    // Verbindung aufbauen
    if($c['ftp_ssl']) {
        $_SESSION['ftp_conn'] = ftp_ssl_connect($c['ftp_url']);
    } else {
        $_SESSION['ftp_conn'] = ftp_connect($c['ftp_url']);
    }
    
    // Login mit Benutzername und Passwort
    $login_result = @ftp_login($_SESSION['ftp_conn'], $c['ftp_user'], $c['ftp_pw']);

    // Verbindung überprüfen
    if ((!$_SESSION['ftp_conn']) || (!$login_result)) {
        $content = '
                    <table cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td align="center">
                                FTP-Verbindung ist fehlgeschlagen!
                                Verbindungsaufbau zu <b>'.$c['ftp_url'].'</b> mit Benutzername <b>'.$c['ftp_user'].'</b> versucht.
                            </td>
                        </tr>
                    </table>
        ';
    } else {
        $content = '
                    <table cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="3">
                                Verbunden zu <b>'.$c['ftp_url'].'</b> mit Benutzername <b>'.$c['ftp_user'].'</b>.
                            </td>
                        </tr> 

        ';

    
        $_GET['f'] = isset($_GET['f']) ? $_GET['f'] : "/";
        ftp_chdir($_SESSION['ftp_conn'], $_GET['f']);
        $_GET['f'] = ftp_pwd($_SESSION['ftp_conn']);
        $_GET['f'] = $_GET['f'] == "/" ? $_GET['f'] : $_GET['f']."/";
        $files = ftp_nlist($_SESSION['ftp_conn'], ".");
        
        $furllist = explode("/", $_GET['f']);
        unset($furllinks, $fpath);
        $furllinks = '<a href="?id='.$_GET['id'].'&amp;f=/" title="zum Verzeichnis wechseln">&nbsp;.&nbsp;</a>';
        foreach($furllist as $furl) {
            if (!empty($furl)) {
                $fpath .= "/".$furl;
                $furllinks .= '/<a href="?id='.$_GET['id'].'&amp;f='.$fpath.'" title="zum Verzeichnis wechseln">'.$furl.'</a>';
            }            
        }
    
        $content .= '
                        <tr>
                            <td>
                                <input type="checkbox" id="size" value="1" checked>
                            </td>                        
                            <td colspan="2">
                                Dateigröße mit übertragen
                            </td>
                        </tr>
                        <tr>
                            <td width="30"></td><td width="100%"></td><td width="60"></td>
                        </tr>    
                        <tr>
                            <td colspan="2">
                                <b>Pfad:</b> '.$furllinks.'
                            </td>
                            <td>
                                <b>Dateigröße</b>
                            </td>
                        </tr>
                        <tr class="pointer" style="cursor:default;">
                            <td width="30" align="center"><img src="icons/folder.gif" alt="[Ordner]"></td>
                            <td colspan="2" style="width:100%;">
                                <a href="?id='.$_GET['id'].'&amp;f='.$_GET['f']."..".'">[nach oben]</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                        </tr>                       
                        
        ';    
        
        $file_list = array();
        $folder_list = array();
        
        foreach($files as $file) {
            
            $file_path =  $_GET['f'].$file;
            $http_url = $c['ftp_http_url'].$file_path;
        
            if (ftp_is_dir($_SESSION['ftp_conn'],$file_path)) {
                $folder_list[strtolower($file)] = '
                            <tr class="pointer" style="cursor:default;">
                                <td width="30" align="center"><img src="icons/folder.gif" alt="[Verzeichnis]"></td>
                                <td>
                                    <a href="?id='.$_GET['id'].'&amp;f='.$file_path.'" title="zum Verzeichnis wechseln">'.$file.'</a>
                                    <input class="url" type="hidden" value="'.$http_url.'">
                                    <input class="size" type="hidden" value="0">
                                </td>
                                <td>
                                    <span class="folder">(auswählen)</span>
                                </td>
                            </tr>
                ';
            } else {
                $size = ftp_size($_SESSION['ftp_conn'],$file);
                $size = round($size/1024);
                
                $file_list[strtolower($file)] = '
                            <tr class="pointer file" title="Dateipfad auswählen">
                                <td width="30" align="center"><img src="icons/file.gif" alt="[Datei]"></td>
                                <td>
                                    '.$file.'
                                    <input class="url" type="hidden" value="'.$http_url.'">
                                    <input class="size" type="hidden" value="'.$size.'">
                                </td>
                                <td>
                                '.$size.' KB
                                </td>
                            </tr>
                ';
            }
        }

        ksort($folder_list, SORT_STRING);
        ksort($file_list, SORT_STRING);
        $content .= implode($folder_list).implode($file_list);
    }
    
    $content .= '
                    </table>
    ';    

    // Verbindung schließen
    ftp_close($_SESSION['ftp_conn']);

} else {
    $content = '
                    <table cellpadding="4" cellspacing="0" width="100%">
                        <tr>
                            <td align="center">
                                Keine Verbindung gefunden!
                            </td>
                        </tr>
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
