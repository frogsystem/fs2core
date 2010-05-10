<?php
///////////////////////////////////
//// Maybe Update Search Index ////
///////////////////////////////////
function search_index ()
{
    global $global_config_arr, $db;

    $today_3am = mktime ( 3, 0, 0, date ( "m" ), date ( "d" ), date ( "Y" ) );
    $today_3am = ( $today_3am > time() ) ? $today_3am - 24*60*60 : $today_3am;
    if ( $global_config_arr['search_index_update'] === 2 &&  $global_config_arr['search_index_time'] < $today_3am) {
        // Include searchfunctions.php
        require ( FS2_ROOT_PATH . "includes/searchfunctions.php" );
        update_search_index ( "news" );
        update_search_index ( "articles" );
        update_search_index ( "dl" );
        
        // Update config Value
        $global_config_arr['search_index_time'] = time();
        mysql_query ( "
                        UPDATE `".$global_config_arr['pref']."global_config`
                        SET
                            `search_index_time` = '".$global_config_arr['search_index_time']."'
                        WHERE `id` = '1'
        ", $db );
    }
}

///////////////////////////
//// get Main-Template ////
///////////////////////////
function get_maintemplate ( $PATH_PREFIX = "", $BASE = FALSE )
{
    global $global_config_arr, $db, $TEXT;

    // Main Template
    $template = '
{..doctype..}
<html lang="'.$global_config_arr['language'].'">
        <head>
                {..base..}{..title..}{..meta..}{..link..}{..script..}
        </head>

        {..body..}
</html>
    ';
    // Get Doctype
    $template_doctype = new template();
    $template_doctype->setFile("0_general.tpl");
    $template_doctype->load("DOCTYPE");
    $template_doctype = $template_doctype->display();
    
    // Base for Images
    if ( $BASE !== FALSE ) {
        $template_base = '<base href="'.$BASE .'">
                ';
    } else {
        $template_base = "";
    }

    // Create link-Rows
    $template_link = "";
    if ( $global_config_arr['show_favicon'] == 1 ) {
                $template_link .= '
                <link rel="shortcut icon" href="styles/'.$global_config_arr['style'].'/icons/favicon.ico">';
    }
    $template_link .= '
                <link rel="alternate" type="application/rss+xml" href="'.$PATH_PREFIX .'feeds/'.$global_config_arr['feed'].'.php" title="'.$global_config_arr['title'].' '.$TEXT->get("news_feed").'">
                '. get_css ( $PATH_PREFIX );

    // Create script-Rows
    $template_script = "";
    $template_script .= '
                <script type="text/javascript" src="'.$PATH_PREFIX .'resources/jquery/jquery-1.4.min.js"></script>'. get_js ( $PATH_PREFIX ) .'
                <script type="text/javascript" src="'.$PATH_PREFIX .'includes/js_functions.js"></script>';

    // Replace Placeholders
    $template = str_replace("{..doctype..}", $template_doctype, $template);
    $template = str_replace("{..base..}", $template_base, $template);
    $template = str_replace("{..title..}", "<title>".get_title()."</title>", $template);
    $template = str_replace("{..meta..}", get_meta (), $template);
    $template = str_replace("{..link..}", $template_link, $template);
    $template = str_replace("{..script..}", $template_script, $template);

    // Return Template
    return $template;
}


///////////////////////
//// Get CSS-Links ////
///////////////////////
function get_css ( $PATH_PREFIX )
{
    global $global_config_arr;

    // Get List of CSS-Files
    $search_path =  FS2_ROOT_PATH . "styles/" . $global_config_arr['style'];
    $link_path =  $PATH_PREFIX . "styles/" . $global_config_arr['style'];
    $files = scandir_ext ( $search_path, "css" );

    // Filter Go-CSS-Files
    $files_go_css = array_filter ( $files, create_function ( '$FILE', '
        if ( preg_match ( "/go_(.+).css/", $FILE ) ) {
            return TRUE;
        }
        return FALSE;
    ') );
    
    // Special CSS-Files
    $files_special = array ( "import.css", "noscript.css" );
    $files_all_special = array_merge ( $files_special, $files_go_css );
    
    // Filter special Files
    $files_without_special = array_diff ( $files, $files_all_special );

    // Unset template for security reasons
    $template_css = "";

    // Search for import.css
    if ( in_array ( "import.css", $files ) ) {
        $template_css .= '<link rel="stylesheet" type="text/css" href="'. $link_path .'/import.css">';
    // Else import other CSS-Files
    } else {
        foreach ( $files_without_special as $file ) {
            $template_css .= '
                <link rel="stylesheet" type="text/css" href="'. $link_path . "/" . $file .'">';
        }
    }
    
    // Other Special CSS
    if ( in_array ( "noscript.css", $files ) ) {
        $template_css .= '
                <link rel="stylesheet" type="text/css" id="noscriptcss" href="'. $link_path . '/noscript.css">';
    }
    
    // Go-CSS-Files
    $go_css = "go_".$global_config_arr['goto'].".css";
    if ( in_array ( $go_css, $files_go_css ) ) {
        $template_css .= '
                <link rel="stylesheet" type="text/css" href="'. $link_path . "/" . $go_css .'">';
        }
    
    // Return Template
    return $template_css;
}

///////////////////////
//// Get JS-Links ////
///////////////////////
function get_js ( $PATH_PREFIX )
{
    global $global_config_arr;

    // Get List of JS-Files
    $search_path =  FS2_ROOT_PATH . "styles/" . $global_config_arr['style'];
    $link_path =  $PATH_PREFIX . "styles/" . $global_config_arr['style'];
    $files = scandir_ext ( $search_path, "js" );

    // Create Template
    $template_js = "";
    foreach ( $files as $file ) {
        $template_js .= '
                <script type="text/javascript" src="'. $link_path . "/" . $file .'"></script>';
    }

    // Return Template
    return $template_js;
}

///////////////////////
//// get META-Tags ////
///////////////////////
function get_meta ()
{
    global $global_config_arr;

    $keyword_arr = explode ( ",", $global_config_arr['keywords'] );
    foreach ( $keyword_arr as $key => $value ) {
        $keyword_arr[$key] = trim ( $value );
    }
    $keywords = implode ( ", ", $keyword_arr );

    $template = '
                <meta name="title" content="'.get_title ().'">'.get_meta_author ().'
                <meta name="publisher" content="'.$global_config_arr['publisher'].'">
                <meta name="copyright" content="'.$global_config_arr['copyright'].'">
                <meta name="generator" content="Frogsystem 2 [http://www.frogsystem.de]">
                <meta name="description" content="'.$global_config_arr['description'].'">'.get_meta_abstract ().'
                <meta http-equiv="content-language" content="'.$global_config_arr['language'].'">
                <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
                <meta name="robots" content="index,follow">
                <meta name="Revisit-after" content="3 days">
                <meta name="DC.Title" content="'.get_title ().'">'.get_meta_author ( TRUE ).'
                <meta name="DC.Rights" content="'.$global_config_arr['copyright'].'">
                <meta name="DC.Publisher" content="'.$global_config_arr['publisher'].'">
                <meta name="DC.Description" content="'.$global_config_arr['description'].'">
                <meta name="DC.Language" content="'.$global_config_arr['language'].'">
                <meta name="DC.Format" content="text/html">
                <meta name="keywords" lang="'.$global_config_arr['language'].'" content="'.$keywords.'">
    ';

    return $template;
}

///////////////////
//// get Title ////
///////////////////
function get_title ()
{
        global $global_config_arr;

        settype ( $global_config_arr['dyn_title'], "integer" );

        if ( $global_config_arr['dyn_title'] == 1 && $global_config_arr['dyn_title_page'] != "" ) {
           $dyn_title = str_replace ( "{title}", $global_config_arr['title'], $global_config_arr['dyn_title_ext'] );
           $dyn_title = str_replace ( "{ext}", $global_config_arr['dyn_title_page'], $dyn_title );
           return $dyn_title;
        } else {
               return $global_config_arr['title'];
        }
}

/////////////////////////////
//// get Author Meta Tag ////
/////////////////////////////
function get_meta_author ( $DC = FALSE )
{
        global $global_config_arr;

        if ( isset ( $global_config_arr['content_author'] ) && $global_config_arr['content_author'] != "" ) {
            $author = $global_config_arr['content_author'];
        } else {
            $author = $global_config_arr['publisher'];
        }
        
        if ( $DC ) {
            $output = '<meta name="DC.Creator" content="'.$author.'">';
        } else {
            $output = '<meta name="author" content="'.$author.'">';
        }
        
        return '
                '.$output;
}

/////////////////////////////
//// get Author Meta Tag ////
/////////////////////////////
function get_meta_abstract ()
{
        global $global_config_arr;

        if ( isset ( $global_config_arr['content_abstract'] ) && $global_config_arr['content_abstract'] != "" ) {
            return '
                <meta name="abstract" content="'.$global_config_arr['content_abstract'].'">';
        } else {
            return '
                <meta name="abstract" content="'.$global_config_arr['description'].'">';
        }
}



/////////////////////
//// get Content ////
/////////////////////
function get_content ( $GOTO )
{
    global $global_config_arr, $db, $TEXT, $sql;
    global $phrases;

    // Display Content
    unset ( $template );
    
    // Script-File in /data/
    if ( file_exists ( "data/".$GOTO.".php" ) ) {
        include ( FS2_ROOT_PATH . "data/".$GOTO.".php" );
    } elseif ( file_exists ( "data/".$GOTO ) ) {
        include ( FS2_ROOT_PATH . "data/".$GOTO );
    } else {

        // Articles from DB
        $index = mysql_query ( "
                                SELECT COUNT(`article_id`) AS 'number'
                                FROM `".$global_config_arr['pref']."articles`
                                WHERE `article_url` = '".$GOTO."'
        ", $db );

        if ( mysql_result ( $index, 0, "number") >= 1 ) {
            $index = mysql_query ( "
                                    SELECT `alias_forward_to`
                                    FROM `".$global_config_arr['pref']."aliases`
                                    WHERE `alias_active` = 1
                                    AND `alias_go` = 'articles.php'
            ", $db );
            if ( mysql_num_rows ( $index ) >= 1 ) {
                include ( FS2_ROOT_PATH . "data/" . stripslashes ( mysql_result ( $index, 0, "alias_forward_to" ) ) );
            } else {
                include ( FS2_ROOT_PATH . "data/articles.php" );
            }
            
        // File-Download
        } elseif ( $GOTO == "dl" && isset ( $_GET['fileid'] ) && isset ( $_GET['dl'] ) ) {
            unset ( $template );

        // 404-Error Page, no content found
        } else {
            $global_config_arr['goto'] = "404";
            include ( FS2_ROOT_PATH . "data/404.php" );
        }
    
    }


    // Return Content
    return $template;
}


//////////////////////////
//// Replace Snippets ////
//////////////////////////
function replace_snippets ( $TEMPLATE )
{
    global $global_config_arr, $db;

    $index = mysql_query ( "
                            SELECT *
                            FROM `".$global_config_arr['pref']."snippets`
                            WHERE `snippet_active` =  1
    ", $db );

    while ( $data_arr = mysql_fetch_assoc ( $index ) ) {
        $data_arr['snippet_text'] = stripslashes ( $data_arr['snippet_text'] );
        $data_arr['snippet_text'] = str_replace ( '[%', '&#x5B;&#x25;', $data_arr['snippet_text'] );
        $data_arr['snippet_text'] = str_replace ( '%]', '&#x25;&#x5D;', $data_arr['snippet_text'] );
        $TEMPLATE = str_replace ( stripslashes ( $data_arr['snippet_tag'] ), $data_arr['snippet_text'], $TEMPLATE );
    }

    return $TEMPLATE;
}


/////////////////////////////
//// Replace Navigations ////
/////////////////////////////
function replace_navigations ( $TEMPLATE, $PATH_PREFIX = "" )
{
    global $global_config_arr;

    $STYLE_PATH = "styles/".$global_config_arr['style']."/";
    
    // Replace Navigation-Files in $TEMPLATE
    $files = scandir_ext ( FS2_ROOT_PATH . $STYLE_PATH, "nav" );
    foreach ( $files as $file ) {
        $nav_template = get_navigation( $PATH_PREFIX . $STYLE_PATH . $file );
        $TEMPLATE = str_replace ( '$NAV('.$file.")", $nav_template, $TEMPLATE );
    }

    // Return Content
    return $TEMPLATE;
}

////////////////////////
//// Get Navigation ////
////////////////////////
function get_navigation( $FILE )
{
    $ACCESS = new fileaccess();
    $template = $ACCESS->getFileData( FS2_ROOT_PATH . $FILE );
    $template = str_replace ( '$NAV(', '&#x24;NAV&#x28;', $template );
    return $template;
}


/////////////////////////
//// Replace Applets ////
/////////////////////////
function replace_applets ( $TEMPLATE, $PATH_PREFIX = "" )
{
    global $global_config_arr, $db, $TEXT;

    // Load Applets from DB
    $index = mysql_query ( "
                            SELECT *
                            FROM ".$global_config_arr['pref']."applets
    ", $db );

    // Write Applets into Array & get Applet Template
    for ( $i = 0; $result = mysql_fetch_assoc ( $index ); $i++ ) {
        $data_arr[$i]['applet_id'] = $result['applet_id'];
        $data_arr[$i]['applet_file'] = stripslashes ( $result['applet_file'] ) . ".php";
        $data_arr[$i]['applet_active'] = $result['applet_active'];
        $data_arr[$i]['applet_output'] = $result['applet_output'];
        $data_arr[$i]['applet_template'] = ( $data_arr[$i]['applet_active'] == 1 ) ? get_applet ( $PATH_PREFIX . "applets/" . $data_arr[$i]['applet_file'] ) : "";
        $data_arr[$i]['applet_template'] = ( $data_arr[$i]['applet_output'] == 1 ) ? $data_arr[$i]['applet_template'] : "";
    }

    // Replace active Applets in $TEMPLATE
    foreach ( $data_arr as $applet ) {
        $TEMPLATE = str_replace ( '$APP('.$applet['applet_file'].")", $applet['applet_template'], $TEMPLATE );
    }

    // Return Content
    return $TEMPLATE;
}

////////////////////
//// Get Applet ////
////////////////////
function get_applet ( $FILE )
{
    global $global_config_arr, $db, $TEXT;
    
    include_once ( FS2_ROOT_PATH . $FILE );
    $template = str_replace ( '$APP(', '&#x24;APP&#x28;', $template );
    return $template;
}


//////////////////////////////////
//// Replace Global Variables ////
//////////////////////////////////
function replace_globalvars ( $TEMPLATE )
{
    global $global_config_arr, $db;

    $TEMPLATE = str_replace ( '$VAR(url)', $global_config_arr['virtualhost'], $TEMPLATE );
    $TEMPLATE = str_replace ( '$VAR(style_url))', $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/", $TEMPLATE );
    $TEMPLATE = str_replace ( '$VAR(style_images)', $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/images/", $TEMPLATE );
    $TEMPLATE = str_replace ( '$VAR(style_icons)', $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/", $TEMPLATE );
    $TEMPLATE = str_replace ( '$VAR(page_title)', $global_config_arr['title'], $TEMPLATE );
    $TEMPLATE = str_replace ( '$VAR(page_dyn_title)', get_title (), $TEMPLATE );
    $TEMPLATE = str_replace ( '$VAR(date)', date_loc ( $global_config_arr['date'], time() ), $TEMPLATE );
    $TEMPLATE = str_replace ( '$VAR(time)', date_loc ( $global_config_arr['time'], time() ), $TEMPLATE );
    $TEMPLATE = str_replace ( '$VAR(date_time)', date_loc ( $global_config_arr['datetime'], time() ), $TEMPLATE );

    return $TEMPLATE;
}


///////////////////
//// get $goto ////
///////////////////
function get_goto ( $GETGO )
{
    global $global_config_arr;
    global $db;

    // Check $_GET['go']
    if ( !isset( $GETGO ) || $GETGO == "" ) {
            $goto = $global_config_arr['home_real'];
    } else {
            $goto = savesql ( $GETGO ) ;
    }
    
    // Forward Aliases
    $goto = forward_aliases ( $goto );

    // write $goto into $global_config_arr['goto']
    $global_config_arr['goto'] = $goto;
}


/////////////////////////
//// forward aliases ////
/////////////////////////
function forward_aliases ( $GOTO )
{
    global $global_config_arr, $db;

    $index = mysql_query ( "
                            SELECT `alias_go`, `alias_forward_to`
                            FROM `".$global_config_arr['pref']."aliases`
                            WHERE `alias_active` = 1
                            AND `alias_go` = '".$GOTO."'
    ", $db );

    while ( $aliases_arr = mysql_fetch_assoc ( $index ) ) {
        if ( $GOTO == $aliases_arr['alias_go'] ) {
            $GOTO = $aliases_arr['alias_forward_to'];
        }
    }

    return $GOTO;
}

///////////////////
//// count hit ////
///////////////////
function count_all ( $GOTO )
{
    global $db;
    global $global_config_arr;

    $hit_year = date ( "Y" );
    $hit_month = date ( "m" );
    $hit_day = date ( "d" );

    visit_day_exists ( $hit_year, $hit_month, $hit_day );
        count_hit ( $GOTO );
        count_visit ( $GOTO );
}

///////////////////////////////////
//// check if visit day exists ////
///////////////////////////////////
function visit_day_exists ( $YEAR, $MONTH, $DAY )
{
    global $db;
    global $global_config_arr;

    // check if visit-day exists
    $daycounter = mysql_query ("SELECT * FROM ".$global_config_arr['pref']."counter_stat
                                WHERE s_year = ".$YEAR." AND s_month = ".$MONTH." AND s_day = ".$DAY."", $db );
                                
    $rows = mysql_num_rows ( $daycounter );

    if ( $rows <= 0 ) {
        mysql_query("INSERT INTO ".$global_config_arr['pref']."counter_stat (s_year, s_month, s_day, s_visits, s_hits) VALUES ('".$YEAR."', '".$MONTH."', '".$DAY."', '0', '0')", $db );
        mysql_query("DELETE FROM ".$global_config_arr['pref']."iplist", $db );
    }
}


///////////////////
//// count hit ////
///////////////////
function count_hit ( $GOTO )
{
    global $db;
    global $global_config_arr;

    $hit_year = date ( "Y" );
    $hit_month = date ( "m" );
    $hit_day = date ( "d" );

        if ( $GOTO != "404" && $GOTO != "403" ) {
                // count page_hits
            mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET hits = hits + 1", $db );
            mysql_query ( "UPDATE ".$global_config_arr['pref']."counter_stat
                           SET s_hits = s_hits + 1
                           WHERE s_year = ".$hit_year." AND s_month = ".$hit_month." AND s_day = ".$hit_day."", $db );
        }
}


/////////////////////
//// count visit ////
/////////////////////
function count_visit ( $GOTO )
{
    global $db;
    global $global_config_arr;

    $time = time ();             // timestamp
    $counttime = "86400";       // time to save IPs (1 day = 86400)
    $visit_year = date ( "Y" );
    $visit_month = date(  "m" );
    $visit_day = date ( "d" );
    
        // check if errorpage
        if ( $GOTO != "404" && $GOTO != "403" ) {
                // save IP & visit
            $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."iplist WHERE ip = '".$_SERVER['REMOTE_ADDR']."'", $db );

            if ( mysql_num_rows ( $index ) <= 0 ) {
                mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET visits = visits + 1", $db );
                mysql_query ( "UPDATE ".$global_config_arr['pref']."counter_stat
                               SET s_visits = s_visits + 1
                               WHERE s_year = ".$visit_year." AND s_month = ".$visit_month." AND s_day = ".$visit_day."", $db );
                mysql_query ( "INSERT INTO ".$global_config_arr['pref']."iplist (`ip`) VALUES ('".savesql($_SERVER['REMOTE_ADDR'])."')", $db );
            }
        }
}


///////////////////////
//// save visitors ////
///////////////////////
function save_visitors ()
{
    global $db;
    global $global_config_arr;

    $time = time(); // timestamp
    $ip = $_SERVER['REMOTE_ADDR']; // IP-Adress

        // get user_id or set user_id=0
        if ( isset ( $_SESSION['user_id'] ) && $_SESSION['user_level'] == "loggedin" ) {
            $user_id = $_SESSION['user_id'];
            settype ( $user_id, "integer");
        } else {
            $user_id = 0;
        }

    // delete offline users
    mysql_query ( "DELETE FROM ".$global_config_arr['pref']."useronline WHERE date < (".$time." - 300)", $db );
    
    // save online users
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."useronline WHERE ip='".$_SERVER['REMOTE_ADDR']."'", $db );

        // update existing users
        if ( mysql_num_rows ( $index ) >= 1 && mysql_result ( $index, 0, "user_id" ) != $user_id ) {
        mysql_query ( "UPDATE ".$global_config_arr['pref']."useronline SET user_id = '".$user_id."' WHERE ip = '".$ip."'", $db );
    }
        if ( mysql_num_rows ( $index ) >= 1 ) {
        mysql_query ( "UPDATE ".$global_config_arr['pref']."useronline SET date = '".$time."' WHERE ip='".$ip."'", $db );
    } else {
        mysql_query ( "INSERT INTO ".$global_config_arr['pref']."useronline (ip, user_id, date) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$user_id."', '".$time."')", $db );
    }
}


//////////////////////
//// save referer ////
//////////////////////
function save_referer ()
{
    global $db;
    global $global_config_arr;

    $time = time();             // timestamp

    // save referer
    $referer = preg_replace ( "=(.*?)\=([0-9a-z]{32})(.*?)=i", "\\1=\\3", $_SERVER['HTTP_REFERER'] );
    $index =  mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."counter_ref WHERE ref_url = '".$referer."'", $db );
    
    if ( mysql_num_rows ( $index ) <= 0 ) {
        if ( substr_count ( $referer, "http://" ) >= 1 && substr_count ( $referer, $global_config_arr['virtualhost'] ) < 1 ) {
            mysql_query ( "INSERT INTO ".$global_config_arr['pref']."counter_ref (ref_url, ref_count, ref_first, ref_last) VALUES ('".$referer."', '1', '".$time."', '".$time."')", $db );
        }
    } else {
        if ( substr_count ( $referer, "http://" ) >= 1 && substr_count ( $referer, $global_config_arr['virtualhost'] ) < 1 ) {
                mysql_query ( "UPDATE ".$global_config_arr['pref']."counter_ref SET ref_count = ref_count + 1, ref_last = '".$time."' WHERE ref_url = '".$referer."'", $db );
        }
    }
}


///////////////////////////////
//// del old timed randoms ////
///////////////////////////////
function delete_old_randoms ()
{
  global $db;
  global $global_config_arr;

  if ($global_config_arr[random_timed_deltime] != -1) {
    // Alte Zufallsbild-Einträge aus der Datenbank entfernen
    mysql_query("DELETE a
                FROM ".$global_config_arr[pref]."screen_random a, ".$global_config_arr[pref]."global_config b
                WHERE a.end < UNIX_TIMESTAMP()-b.random_timed_deltime", $db);
  }
}


///////////////////////////////
//// create copyright note ////
///////////////////////////////
function get_copyright ()
{
        return '<span class="copyright">Powered by <a class="copyright_link" href="http://www.frogsystem.de" target="_blank">Frogsystem 2</a> &copy; 2007 - 2010 Frogsystem-Team</span>';
}


////////////////////////
/// Designs & Zones ////
////////////////////////
function set_style ()
{
    global $db;
    global $global_config_arr;

    if ( isset ( $_GET['style'] ) && $global_config_arr['allow_other_designs'] == 1 ) {
        $index = mysql_query ( "
                                SELECT `style_id`, `style_tag`
                                FROM `".$global_config_arr['pref']."styles`
                                WHERE `style_tag` = '".savesql ( $_GET['style'] )."'
                                AND `style_allow_use` = 1
                                LIMIT 0,1
        ", $db );
        if ( mysql_num_rows ( $index ) == 1 ) {
            $global_config_arr['style'] = stripslashes ( mysql_result($index, 0, "style_tag") );
            $global_config_arr['style_tag'] = stripslashes ( mysql_result($index, 0, "style_tag") );
            $global_config_arr['style_id'] = mysql_result($index, 0, "style_id");
        }
    } elseif ( isset ( $_GET['style_id'] ) && $global_config_arr['allow_other_designs'] == 1 ) {
        settype ( $_GET['style_id'], "integer" );
        $index = mysql_query ( "
                                SELECT `style_id`, `style_tag`
                                FROM `".$global_config_arr['pref']."styles`
                                WHERE `style_id` = '".$_GET['style_id']."'
                                AND `style_allow_use` = 1
                                LIMIT 0,1
        ", $db );
        if ( mysql_num_rows ( $index ) == 1 ) {
            $global_config_arr['style'] = stripslashes ( mysql_result($index, 0, "style_tag") );
            $global_config_arr['style_tag'] = stripslashes ( mysql_result($index, 0, "style_tag") );
            $global_config_arr['style_id'] = mysql_result($index, 0, "style_id");
        }
    }
    copyright ();
}
function set_design ()
{ set_style(); }

//////////////////////////////////
//// copyright security check ////
//////////////////////////////////
function copyright ()
{
    global $db;
    global $global_config_arr;

    $template_copyright = new template();
    $template_copyright->setFile("0_general.tpl");
    $template_copyright->load("MAINPAGE");
    $copyright = $template_copyright->display();

    if ( strpos ( $copyright, $template_copyright->getOpener()."copyright".$template_copyright->getCloser() ) == FALSE
                    || strpos ( get_copyright (), "Frogsystem 2" ) == FALSE || strpos ( get_copyright (), "&copy; 2007 - 2010 Frogsystem-Team" ) == FALSE
                    || strpos ( get_copyright (), "Powered by" ) == FALSE  || strpos ( get_copyright (), "frogsystem.de" ) == FALSE ) {
        $global_config_arr['style'] =  "default";
    } else {
        $copyright_without_comments = preg_replace ( "/<!\s*--.*?--\s*>/s", "", $copyright );
        if ( preg_match ( "/\{\.\.copyright\.\.\}/", $copyright_without_comments ) <= 0 ) {
            $global_config_arr['style'] =  "default";
        }
    }
}
?>