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
function get_maintemplate ($BODY, $PATH_PREFIX = "", $BASE = FALSE)
{
    global $global_config_arr, $TEXT;

    // Load Template Object
    $theTemplate = new template();
    $theTemplate->setFile("0_main.tpl");

    // Get Doctype
    $theTemplate->load("DOCTYPE");
    $template_doctype = (string) $theTemplate;
    
    // Base for Images
    $template_base = ($BASE !== FALSE) ? '<base href="'.$BASE .'">' : "";
	
	// Get Titel
	$template_title = get_title();
	
    // Create Link-Lines
    $template_favicon = ($global_config_arr['show_favicon'] == 1) ? '<link rel="shortcut icon" href="'.$PATH_PREFIX .'styles/'.$global_config_arr['style'].'/icons/favicon.ico">' : "";
	$template_feed = '<link rel="alternate" type="application/rss+xml" href="'.$PATH_PREFIX .'feeds/'.$global_config_arr['feed'].'.php" title="'.$global_config_arr['title'].' '.$TEXT['frontend']->get("news_feed").'">';

    // Create Script-Lines
    $template_javascript = get_js($PATH_PREFIX).'
    <script type="text/javascript" src="'.$PATH_PREFIX.'includes/js_functions.js"></script>';
    
	// Create jQuery-Lines
    $template_jquery = '<script type="text/javascript" src="'.$PATH_PREFIX .'resources/jquery/jquery.min.js"></script>';
    $template_jquery_ui = '<script type="text/javascript" src="'.$PATH_PREFIX .'resources/jquery/jquery-ui.min.js"></script>';    
    
    // Get HTML-Matrix
    $theTemplate->load("MATRIX");
    $theTemplate->tag("doctype", $template_doctype);
    $theTemplate->tag("language", $global_config_arr['language']);
    $theTemplate->tag("base_tag", $template_base);
    $theTemplate->tag("title", $template_title);
    $theTemplate->tag("title_tag", "<title>".$template_title."</title>");
    $theTemplate->tag("meta_tags", get_meta());
    
    $theTemplate->tag("css_links", get_css($PATH_PREFIX));
    $theTemplate->tag("favicon_link", $template_favicon);
    $theTemplate->tag("feed_link", $template_feed);
    
    $theTemplate->tag("javascript", $template_javascript);
    $theTemplate->tag("jquery", $template_jquery);
    $theTemplate->tag("jquery-ui", $template_jquery_ui);
    
    $theTemplate->tag("body", $BODY);
    
    // Return Template
    return (string) $theTemplate;
}


///////////////////////
//// Get CSS-Links ////
///////////////////////
function get_css ($PATH_PREFIX)
{
    global $global_config_arr;

    // Get List of CSS-Files
    $search_path =  FS2_ROOT_PATH . "styles/" . $global_config_arr['style'];
    $link_path =  $PATH_PREFIX . "styles/" . $global_config_arr['style'];
    $files = scandir_ext($search_path, "css");

    // Filter Go-CSS-Files
    $files_go_css = array_filter($files, create_function('$FILE', '
        if ( preg_match ( "/go_(.+).css/", $FILE ) ) {
            return TRUE;
        }
        return FALSE;
    '));
    
    // Special CSS-Files
    $files_special = array ( "import.css", "noscript.css" );
    $files_all_special = array_merge ( $files_special, $files_go_css );
    
    // Filter special Files
    $files_without_special = array_diff ($files, $files_all_special);

    // Unset template for security reasons
    initstr($template_css);

    // Search for import.css
    if ( in_array ( "import.css", $files ) ) {
        $template_css .= '<link rel="stylesheet" type="text/css" href="'. $link_path .'/import.css">';
    // Else import other CSS-Files
    } else {
        foreach ($files_without_special as $file) {
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
function get_js ($PATH_PREFIX)
{
    global $global_config_arr;

    // Get List of JS-Files
    $search_path =  FS2_ROOT_PATH . "styles/" . $global_config_arr['style'];
    $link_path =  $PATH_PREFIX . "styles/" . $global_config_arr['style'];
    $files = scandir_ext($search_path, "js");
    
    // Get Go-JS-Files
    $files_go_js = array_filter($files, create_function('$FILE', '
        if ( preg_match ( "/go_(.+).js/", $FILE ) ) {
            return TRUE;
        }
        return FALSE;
    '));
    
    // Filter special Files
    $files_without_special = array_diff ($files, $files_go_js);    
    
    // Create Template
    initstr($template_js);
    foreach ($files_without_special as $file) {
        $template_js .= '
                <script type="text/javascript" src="'. $link_path . "/" . $file .'"></script>';
    }
    
    // Go-JS-Files
    $go_js = "go_".$global_config_arr['goto'].".js";
    if (in_array($go_js, $files_go_js)) {
        $template_js .= '
                <script type="text/javascript" src="'. $link_path . "/" . $go_js .'"></script>';        
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

    $keyword_arr = explode(",", $global_config_arr['keywords']);
    foreach ($keyword_arr as $key => $value) {
        $keyword_arr[$key] = trim($value);
    }
    $keywords = implode(", ", $keyword_arr);

    $template = '
    <meta name="title" content="'.get_title().'">
    '.get_meta_author().'
    <meta name="publisher" content="'.$global_config_arr['publisher'].'">
    <meta name="copyright" content="'.$global_config_arr['copyright'].'">
    <meta name="generator" content="Frogsystem 2 [http://www.frogsystem.de]">
    <meta name="description" content="'.$global_config_arr['description'].'">
    '.get_meta_abstract().'
    <meta http-equiv="content-language" content="'.$global_config_arr['language'].'">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="robots" content="index,follow">
    <meta name="Revisit-after" content="3 days">
    <meta name="DC.Title" content="'.get_title().'">
    '.get_meta_author(TRUE).'
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

    settype($global_config_arr['dyn_title'], "integer");

    if ($global_config_arr['dyn_title'] === 1 && isset($global_config_arr['dyn_title_page'])) {
        $dyn_title = str_replace("{..title..}", $global_config_arr['title'], $global_config_arr['dyn_title_ext']);
        $dyn_title = str_replace("{..ext..}", $global_config_arr['dyn_title_page'], $dyn_title);
        return $dyn_title;
    } else {
        return $global_config_arr['title'];
    }
}

/////////////////////////////
//// get Author Meta Tag ////
/////////////////////////////
function get_meta_author ($DC = FALSE)
{
    global $global_config_arr;

    if (isset($global_config_arr['content_author']) && $global_config_arr['content_author'] != "")
        $author = $global_config_arr['content_author'];
    else
        $author = $global_config_arr['publisher'];

    if ($DC)
        $output = '<meta name="DC.Creator" content="'.$author.'">';
    else
        $output = '<meta name="author" content="'.$author.'">';
        
    return $output;
}

/////////////////////////////
//// get Abstract Meta Tag ////
/////////////////////////////
function get_meta_abstract ()
{
    global $global_config_arr;

    if (isset($global_config_arr['content_abstract']) && $global_config_arr['content_abstract'] != "") {
        return '<meta name="abstract" content="'.$global_config_arr['content_abstract'].'">';
    } else {
        return '<meta name="abstract" content="'.$global_config_arr['description'].'">';
    }
}



/////////////////////
//// get Content ////
/////////////////////
function get_content ($GOTO)
{
    global $global_config_arr, $db, $sql, $TEXT;

    // Display Content
    initstr($template);
    
    // Script-File in /data/
    if (file_exists("data/".$GOTO.".php")) {
        include(FS2_ROOT_PATH . "data/".$GOTO.".php");
    } elseif (file_exists ("data/".$GOTO)) {
        include(FS2_ROOT_PATH . "data/".$GOTO );
    } else {

    // Articles from DB
    $num = $sql->num("articles", array("article_id"), array('W' => "`article_url` = '".$GOTO."'", 'L' => "0,1"));
    if ($num >= 1) {
         
        // Forward Aliases
        $alias = $sql->getRow("aliases", array("alias_forward_to"), array('W' => "`alias_active` = 1 AND `alias_go` = 'articles.php'"));
        if (!empty($alias)) {
            include(FS2_ROOT_PATH . "data/" . stripslashes($alias['alias_forward_to']));
        } else {
            include(FS2_ROOT_PATH . "data/articles.php");
        }
        
        // File-Download
        } elseif ($GOTO == "dl" && isset ($_GET['fileid']) && isset ($_GET['dl'])) {

        // 404-Error Page, no content found
        } else {
            $global_config_arr['goto'] = "404";
            include(FS2_ROOT_PATH . "data/404.php");
        }
    }

    // Return Content
    return $template;
}

///////////////////////////////
//// Template Replacements ////
///////////////////////////////
function tpl_replacements ($TEMPLATE)
{
    global $global_config_arr, $sql;
    global $APP, $SNP, $NAV;
    
    $APP = load_applets();
    $SNP = load_snippets();
    $NAV = load_navigations(); 

    $TEMPLATE = replace_x($TEMPLATE, $global_config_arr['system']['var_loop']);
    $TEMPLATE = replace_x_chars($TEMPLATE);
    $TEMPLATE = replace_globalvars($TEMPLATE);
    
    return $TEMPLATE;
}


///////////////////////////////
//// Replace X in Template ////
///////////////////////////////
function replace_x ($TEMPLATE, $COUNT)
{
    $TEMPLATE = replace_applets($TEMPLATE, $COUNT);
    $TEMPLATE = replace_navigations($TEMPLATE, $COUNT);
    $TEMPLATE = replace_snippets($TEMPLATE, $COUNT);
    return $TEMPLATE;
}

/////////////////////////////////////////
//// Replace all special chars for X ////
//// in Templates with htmlentities  ////
/////////////////////////////////////////
function replace_x_chars ($TEMPLATE)
{
    $TEMPLATE = str_replace('$APP(', '&#x24;APP&#x28;', $TEMPLATE);
    $TEMPLATE = str_replace('$NAV(', '&#x24;NAV&#x28;', $TEMPLATE);
    $TEMPLATE = str_replace('[%', '&#x5B;&#x25;', $TEMPLATE);
    $TEMPLATE = str_replace('%]', '&#x25;&#x5D;', $TEMPLATE);

    return $TEMPLATE;
}

//////////////////////
//// Load Applets ////
//////////////////////
function load_applets ()
{
    global $global_config_arr, $sql, $db, $TEXT;

    // Load Applets from DB
    $data = $sql->get("applets", array("applet_file", "applet_output"), array('W' => "`applet_active` = 1"));
    $ld = $data['data'];

    // Write Applets into Array & get Applet Template
    initstr($template);
    foreach ($ld as $ldk => $lde) {
        // prepare data
        $lde['applet_file'] = stripslashes($lde['applet_file']).".php";
        settype($lde['applet_output'], "integer");
        
        // include applets & load template
        include_once(FS2_ROOT_PATH."applets/".$lde['applet_file']);
        $lde['applet_template'] = $template;
        initstr($template);

        $ld[$ldk] = $lde;
    }

    // Return Content
    return $ld;
}


//////////////////////////
//// Load Navigations ////
//////////////////////////
function load_navigations ()
{
    global $global_config_arr;

    $STYLE_PATH = "styles/".$global_config_arr['style']."/";
    
    // Write Navigations into Array
    $ACCESS = new fileaccess();
    $files = scandir_ext(FS2_ROOT_PATH . $STYLE_PATH, "nav");
    $NAV = array();
    foreach ($files as $file) {
        $template = $ACCESS->getFileData(FS2_ROOT_PATH.$STYLE_PATH.$file);
        $NAV[] = array('file' => $file, 'template' => $template);
    }

    // Return Content
    return $NAV;
}

///////////////////////
//// Load Snippets ////
///////////////////////
function load_snippets ()
{
    global $global_config_arr, $sql;
    
    // Load Snippets from DB
    $data = $sql->get("snippets", array("snippet_tag","snippet_text"), array('W' => "`snippet_active` =  1"));
    $ld = $data['data'];
    
    // Write Snippets into Array
    foreach ($ld as $ldk => $lde) {
        $lde['snippet_text'] = stripslashes($lde['snippet_text']);
        $lde['snippet_tag'] = stripslashes($lde['snippet_tag']);
        $ld[$ldk] = $lde;
    }

    return $ld;
}


/////////////////////////
//// Replace Applets ////
/////////////////////////
function replace_applets ($TEMPLATE, $COUNT)
{
    global $APP, $global_config_arr, $sql, $db, $TEXT;
    
    // Replace active Applets in $TEMPLATE
    foreach ($APP as $applet) {
        if ($applet['applet_output'] === 1) {
            $search = '$APP('.$applet['applet_file'].')';
            if ($COUNT > 0 && strpos($TEMPLATE, $search) !== false) {
                $TEMPLATE = str_replace($search, replace_x($applet['applet_template'], $COUNT-1), $TEMPLATE);
            }
        }
    }

    // Return Content
    return $TEMPLATE;
}

/////////////////////////////
//// Replace Navigations ////
/////////////////////////////
function replace_navigations ($TEMPLATE, $COUNT)
{
    global $NAV, $global_config_arr;

    // Replace Navigations in $TEMPLATE
    foreach ($NAV as $navi) {
        $search = '$NAV('.$navi['file'].')';
        if ($COUNT > 0 && strpos($TEMPLATE, $search ) !== false) {
            $TEMPLATE = str_replace($search , replace_x($navi['template'], $COUNT-1), $TEMPLATE);
        }
    }

    // Return Content
    return $TEMPLATE;
}

//////////////////////////
//// Replace Snippets ////
//////////////////////////
function replace_snippets ($TEMPLATE, $COUNT)
{
    global $SNP, $global_config_arr;

    // Replace active Snippets in $TEMPLATE
    foreach ($SNP as $snippet) {
        if ($COUNT > 0 && strpos($TEMPLATE, $snippet['snippet_tag']) !== false) {
            $TEMPLATE = str_replace($snippet['snippet_tag'], replace_x($snippet['snippet_text'], $COUNT-1), $TEMPLATE);
        }
    }
    // Return Content
    return $TEMPLATE;
}


//////////////////////////////////
//// Replace Global Variables ////
//////////////////////////////////
function replace_globalvars ($TEMPLATE)
{
    global $global_config_arr;

    $TEMPLATE = str_replace('$VAR(url)', $global_config_arr['virtualhost'], $TEMPLATE);
    $TEMPLATE = str_replace('$VAR(style_url))', $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/", $TEMPLATE);
    $TEMPLATE = str_replace('$VAR(style_images)', $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/images/", $TEMPLATE);
    $TEMPLATE = str_replace('$VAR(style_icons)', $global_config_arr['virtualhost']."styles/".$global_config_arr['style']."/icons/", $TEMPLATE);
    $TEMPLATE = str_replace('$VAR(page_title)', $global_config_arr['title'], $TEMPLATE);
    $TEMPLATE = str_replace('$VAR(page_dyn_title)', get_title(), $TEMPLATE);
    $TEMPLATE = str_replace('$VAR(date)', date_loc($global_config_arr['date'], time()), $TEMPLATE);
    $TEMPLATE = str_replace('$VAR(time)', date_loc($global_config_arr['time'], time()), $TEMPLATE);
    $TEMPLATE = str_replace('$VAR(date_time)', date_loc($global_config_arr['datetime'], time()), $TEMPLATE);

    return $TEMPLATE;
}


///////////////////
//// get $goto ////
///////////////////
function get_goto ( $GETGO )
{
    global $global_config_arr, $db;

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

	if (isset($_SERVER['HTTP_REFERER'])) {
		
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
}


///////////////////////////////
//// del old timed randoms ////
///////////////////////////////
function delete_old_randoms ()
{
  global $db;
  global $global_config_arr;

  if ($global_config_arr['random_timed_deltime'] != -1) {
    // Alte Zufallsbild-Einträge aus der Datenbank entfernen
    mysql_query("DELETE a
                FROM ".$global_config_arr['pref']."screen_random a, ".$global_config_arr['pref']."global_config b
                WHERE a.end < UNIX_TIMESTAMP()-b.random_timed_deltime", $db);
  }
}


///////////////////////////////
//// create copyright note ////
///////////////////////////////
function get_copyright ()
{
        return '<span class="copyright">Powered by <a class="copyright" href="http://www.frogsystem.de" target="_blank">Frogsystem&nbsp;2</a> &copy; 2007 - 2011 Frogsystem-Team</span>';
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
    global $global_config_arr;

    $template_copyright = new template();
    $template_copyright->setFile("0_main.tpl");
    $template_copyright->load("MAIN");
    $copyright = (string) $template_copyright;

    if (strpos($copyright, $template_copyright->getOpener()."copyright".$template_copyright->getCloser()) == FALSE
        || strpos(get_copyright(), "Frogsystem&nbsp;2" ) == FALSE || strpos(get_copyright(), "&copy; 2007 - 2011 Frogsystem-Team") == FALSE
        || strpos(get_copyright(), "Powered by" ) == FALSE || strpos(get_copyright(), "frogsystem.de") == FALSE )
    {
        $global_config_arr['style'] =  "default";
        $global_config_arr['style_id'] =  0;
    } else {
        $copyright_without_comments = preg_replace("/<!\s*--.*?--\s*>/s", "", $copyright);
        if (preg_match("/\{\.\.copyright\.\.\}/", $copyright_without_comments) <= 0) {
            $global_config_arr['style'] =  "default";
            $global_config_arr['style_id'] =  0;
        }
    }
}
?>
