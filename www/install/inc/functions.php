<?php
////////////////////////////////////
//// [FS]/ an den Anfang setzen ////
////////////////////////////////////
function add_fs ( $ARRAY )
{
    unset($folder_arr);
    foreach ($ARRAY as $value) {
        $folder_arr[] = "[FS2]/".$value;
    }
    return $folder_arr;
}

//////////////////////////////////
//// ../ an den Anfang setzen ////
//////////////////////////////////
function add_dotdotslash ( $ARRAY )
{
    unset($folder_arr);
    foreach ($ARRAY as $value) {
        $folder_arr[] = "../".$value;
    }
    return $folder_arr;
}


//////////////////////////////////
//// Text am Anfang der Seite ////
//////////////////////////////////

function systext ( $MESSAGE, $TITLE , $RED = FALSE, $SPACE = TRUE )
{
    if ( $RED == TRUE ) {
        $class = "line_red";
    } else {
        $class = "line";
    }
    
    if ( $SPACE == TRUE ) {
        $space = '<tr><td class="space"></td></tr>';
    } else {
        $space = '';
    }


    return '
                    <table class="configtable" cellpadding="4" cellspacing="0">
                        <tr><td class="'.$class.'">'.$TITLE.'</td></tr>
                        <tr><td class="config"><div class="normal">'.$MESSAGE.'</div></td></tr>
                        '.$space .'
                    </table>
    ';
}

/////////////////////////
//// fs_is_writeable ////
/////////////////////////

function is_writable_array ( $array )
{
    foreach ( $array as $value ) {
        if ( !fs_is_writable ( $value ) ) {
            return false;
        }
    }
    return true;
}


/////////////////////////
//// fs_is_writeable ////
/////////////////////////

function fs_is_writable ( $path )
{
    if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
        return fs_is_writable($path.uniqid(mt_rand()).'.tmp');
    else if (is_dir($path))
        return fs_is_writable($path.'/'.uniqid(mt_rand()).'.tmp');
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f = @fopen($path, 'a');
    if ($f===false)
        return false;
    fclose($f);
    if (!$rm)
        unlink($path);
    return true;
}

////////////////////////////////////
//// Zahlen-Differnez berechnen ////
////////////////////////////////////

function dif ( $a, $b )
{
    return abs ( $a - $b );
}


//////////////////////////////////
//// get MySQL-Server Version ////
//////////////////////////////////

function easy_mysql_server_version ()
{
    ob_start ();
    phpinfo ( INFO_MODULES );
    $info = ob_get_contents ();
    ob_end_clean ();
    $info = stristr ( $info, 'Client API version' );
    $native = strpos ( $info, 'MySQL Native Driver' );
    preg_match ( '/[1-9].[0-9].[1-9][0-9]/', $info, $match );
    $version = $match[0];
    $version = substr ( $version, 0, 1 );
    if ( $native <= 100 ) {
        return "4";
    }
    settype ( $version, "integer" );
    return $version;
}

///////////////////////////////
//// ftp_chmod replacement ////
///////////////////////////////

if (!function_exists('ftp_chmod')) {
    function ftp_chmod($ftp_stream, $mode, $filename) {
        return ftp_site($ftp_stream, sprintf('CHMOD %o %s', $mode, $filename));
    }
}


///////////////////////////////////////
//// file_put_contents replacement ////
///////////////////////////////////////

if (!function_exists('file_put_contents')) {
    function file_put_contents($filename, $data) {
        if (is_array($data)) {
            $data = implode("", $data);
        }
        if (is_writable($filename)) {
            if (!$handle = fopen($filename, "w")) {
                return false;
            }
            if (!fwrite($handle, $data)) {
                return false;
            }
            fclose($handle);
            return true;
        } else {
            return false;
        }
    }
}


////////////////////////////
//// file_write_content ////
////////////////////////////

function file_write_contents($filename, $data, $FTP = FALSE )
{
    if ( file_put_contents($filename, $data) ) { // Ohne FTP
        return true;
    } elseif ( !$FTP ) {
        include("inc/ftp_login.php");
        if ( @ftp_chmod($conn, 0777, $root."install/".$filename) ) {  // Mit FTP
            if ( file_put_contents($filename, $data) ) {
                @ftp_chmod($conn, 0644, $root."install/".$filename);
                ftp_close($conn);
                return true;
            }
            @ftp_chmod($conn, 0644, $root."install/".$filename);
        }
        ftp_close($conn);
    }
    return false;
}


/////////////////////////////////
// create save strings for sql //
/////////////////////////////////

function savesql ( $TEXT )
{
    global $db;

    if ( !is_numeric ( $TEXT ) ) {
        $TEXT = mysql_real_escape_string ( addslashes ( unquote ( $TEXT ) ), $db );
    }
    return $TEXT;
}

/////////////////////////////////
// create save strings for sql //
/////////////////////////////////

function unquote ( $TEXT )
{
    if ( get_magic_quotes_gpc () ) {
        $TEXT = stripslashes ( $TEXT );
    }
    return $TEXT;
}


//////////////////////////////////
// kill html in textareas, etc. //
//////////////////////////////////

function killhtml ( $TEXT )
{
    $TEXT = htmlspecialchars ( $TEXT );
    return $TEXT;
}


/////////////////////////////////
//// Anti-Spam Code erzeugen ////
/////////////////////////////////

function generate_spamcode($length = 10)
{
    $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $real_strlen = strlen($charset) - 1;
    mt_srand ((double)microtime()*1001000);
    
    while (strlen($code) < $length) {
        $code .= $charset[mt_rand(0,$real_strlen)];
    }
    return $code;
}


/////////////////////////////////
//// MySQL Fehler überprüfen ////
/////////////////////////////////

function check_mysqlerror($error)
{
    global $_LANG;

    if ($error != "") {
        return "".$_LANG[main][error_img]."<br><i>".$error."</i>";
    }
    return $_LANG[main][ok_img];
}


//////////////////////////////
//// Existiert ein Präfix ////
//////////////////////////////

function check_pref()
{
    include("inc/install_login.php");
    mysql_close();
    
    if ($pref != "") {
        return $pref;
    }
    return false;
}


///////////////////////////
//// Verbindung prüfen ////
///////////////////////////

function check_dbcon()
{
    include("inc/install_login.php");
    if ($db !== FALSE)
    {
        if (mysql_select_db($data, $db))
        {
            mysql_close();
            return true;
        }
        mysql_close();
    }

    return false;
}


///////////////////////////
//// Verbindung prüfen ////
///////////////////////////

function check_ftpcon ()
{
    include ("inc/ftp_data.php");

    $conn = @ftp_connect( $host, $port, 7 );
    if ( $conn != FALSE ) {
        $login = @ftp_login ( $conn, $user, $pass );
        if ( $login == TRUE)
        {
            ftp_close ( $conn );
            return true;
        }
        ftp_close ( $conn );
    }
    return false;
}


//////////////////////////////////
//// Datenbankename ermitteln ////
//////////////////////////////////

function getdbname()
{
    include("inc/install_login.php");
    return $data;
}


/////////////////////////////
//// Datenbanken checken ////
/////////////////////////////

function list_db()
{
    global $_LANG;
    
    include("inc/install_login.php");

    //verfügbare Datenbanken
    unset($db_arr);

    if ($db)
    {
        $db_list = mysql_list_dbs($db);

        while ($row = mysql_fetch_object($db_list)) {
            $db_arr[] = $row->Database;
        }
    }

    if ( count ( $db_arr ) == 0 ) {
        unset($db_arr);
        $db_arr[] = $_LANG[steps][database][step][1][error2][4];
    }

    return $db_arr;
}


//////////////////////////
//// Tabellen checken ////
//////////////////////////

function check_dbtables($prefix)
{
    include("inc/install_login.php");

    //doppelte Tabellen
    unset($double_arr);

    if ($db)
    {
        //Table-Array
        unset($table_arr);
        $table_arr = fill_table_arr($prefix);
        //vorhandene Tabellen
        $existing_tables = mysql_list_tables($data, $db);

        while ($row = mysql_fetch_row($existing_tables)) {
            if (in_array($row[0], $table_arr)) {
                $double_arr[] = $row[0];
            }
        }
        return $double_arr;
    }
    else
    {
        return $double_arr;
    }
}


//////////////////////////
//// table_arr füllen ////
//////////////////////////

function fill_table_arr($prefix)
{
    unset($table_arr);
    $table_arr[] = $prefix."admin_cp";
    $table_arr[] = $prefix."admin_groups";
    $table_arr[] = $prefix."aliases";
    $table_arr[] = $prefix."announcement";
    $table_arr[] = $prefix."articles";
    $table_arr[] = $prefix."articles_cat";
    $table_arr[] = $prefix."articles_config";
    $table_arr[] = $prefix."counter";
    $table_arr[] = $prefix."counter_ref";
    $table_arr[] = $prefix."counter_stat";
    $table_arr[] = $prefix."dl";
    $table_arr[] = $prefix."dl_cat";
    $table_arr[] = $prefix."dl_config";
    $table_arr[] = $prefix."dl_files";
    $table_arr[] = $prefix."editor_config";
    $table_arr[] = $prefix."email";
    $table_arr[] = $prefix."global_config";
    $table_arr[] = $prefix."includes";
    $table_arr[] = $prefix."iplist";
    $table_arr[] = $prefix."news";
    $table_arr[] = $prefix."news_cat";
    $table_arr[] = $prefix."news_comments";
    $table_arr[] = $prefix."news_config";
    $table_arr[] = $prefix."news_links";
    $table_arr[] = $prefix."partner";
    $table_arr[] = $prefix."partner_config";
    $table_arr[] = $prefix."player";
    $table_arr[] = $prefix."player_config";
    $table_arr[] = $prefix."poll";
    $table_arr[] = $prefix."poll_answers";
    $table_arr[] = $prefix."poll_config";
    $table_arr[] = $prefix."poll_voters";
    $table_arr[] = $prefix."press";
    $table_arr[] = $prefix."press_admin";
    $table_arr[] = $prefix."press_config";
    $table_arr[] = $prefix."resources";
    $table_arr[] = $prefix."screen";
    $table_arr[] = $prefix."screen_cat";
    $table_arr[] = $prefix."screen_config";
    $table_arr[] = $prefix."screen_random";
    $table_arr[] = $prefix."screen_random_config";
    $table_arr[] = $prefix."shop";
    $table_arr[] = $prefix."smilies";
    $table_arr[] = $prefix."template";
    $table_arr[] = $prefix."user";
    $table_arr[] = $prefix."useronline";
    $table_arr[] = $prefix."user_config";
    $table_arr[] = $prefix."user_groups";
    $table_arr[] = $prefix."user_permissions";
    $table_arr[] = $prefix."wallpaper";
    $table_arr[] = $prefix."wallpaper_sizes";
    $table_arr[] = $prefix."zones";

    return $table_arr;
}


////////////////////////////////
//// Seitentitel generieren ////
////////////////////////////////

function createpage($page, $title, $content)
{
 global $pagetitle;
 global $contenttitle;
 global $filetoinc;
 $pagetitle = $title;
 $contenttitle = $content;
 $filetoinc = $page;
}


////////////////////////
//// Insert Tooltip ////
////////////////////////

function insert_tt($title,$text,$left=0,$width=150,$top=25)
{
   return '
<a class="tooltip" href="#?">
    <img border="0" src="img/help.png" align="top" alt="?">
    <span style="left:'.$left.'; width:'.$width.'; top:'.$top.';">
        <img border="0" src="img/pointer.png" align="top" alt="->"> <b>'.$title.'</b><br>'.$text.'
    </span>
</a>
   ';
}

////////////////////////////////
//// Menü erzeugen           ///
////////////////////////////////

function createmenu($menu_arr)
{
    global $go;

    end ($menu_arr);
    $end = key($menu_arr);
    reset ($menu_arr);

    foreach ($menu_arr as $key => $value)
    {
        if ($value[show] == true)
        {
            $menu_class = "menu_step";
            if ($go==$value[id]) {
                $menu_class = "menu_step_selected";
            }
            $template .= '<span class="'.$menu_class.'">'.$value[title].'</span>';
            if ($key != $end) {
                $template .= "&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        }
    }

    echo $template;
    unset($template);
}

////////////////////////////////
//// Navi erzeugen           ///
////////////////////////////////

function createnavi($navi_arr, $first)
{
    global $go;
    
    unset($template);

    if ($navi_arr[menu_id] == $go) {
        foreach ($navi_arr[link] as $value)
        {
            $template .= createlink($value);
        }

        if ($first == true) {
            $headline_img = "navi_top";
        } else {
            $headline_img = "navi_headline";
        }
    }

    if ($template != "") {
        $template = '
            <div id="'.$headline_img.'">
                <img src="img/pointer.png" alt="" style="vertical-align:text-bottom">&nbsp;<b>'.$navi_arr[title].'</b>
                <div id="navi_link">
                    '.$template.'
                </div>
            </div>';
    }

    return $template;
}


////////////////////////////////
//// Seitenlink generieren   ///
//// und Berechtigung prüfen ///
////////////////////////////////

function createlink($arr)
{
  global $go;
  global $step;
  global $lang;

  $link_class = "navi";
  if ($step == $arr[url]) {
    $link_class = "navi_selected";
  }

  if ($arr[link] == true) {
    return'- <a href="'.$PHP_SELF.'?go='.$go.'&step='.$arr[url].'&lang='.$lang.'" class="'.$link_class.'">
          '.$arr[title].'</a><br />';
  } else {
    return $arr[url].'. <span class="'.$link_class.'">'.$arr[title].'</span><br />';
  }



}

////////////////////////////////
//// Navi first              ///
////////////////////////////////

function createnavi_first($template)
{
    if (strlen($template) == 0) {
        return true;
    } else {
        return false;
    }
}


////////////////////////////////
//// Add Link to navi Array  ///
////////////////////////////////

function link2navi($title, $url, $link)
{
    unset($tmp);
    
    $tmp[title] = $title;
    $tmp[url] = $url;
    $tmp[link] = $link;

    return $tmp;
}

?>