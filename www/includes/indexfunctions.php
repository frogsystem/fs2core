<?php
///////////////////////////////
//// start pseudo cronjobs ////
///////////////////////////////
function run_cronjobs ($time = null, $save_time = true) {
    global $FD;

    // set now
    if (empty($time))
        $time = $FD->env('time');

    // calc 3am
    $today_3am = mktime(3, 0, 0, date('m', $time), date ('d', $time), date ('Y', $time));
    $today_3am = ($today_3am > $FD->cfg('time')) ? $today_3am - 24*60*60 : $today_3am;

    // calc next hour
    $last_hour = $time-(date('i', $time)*60)-date('s', $time); // now - min and sec of this hour

    // Run Cronjobs or not
    if ($FD->cfg('cronjobs', 'last_cronjob_time_daily') < $today_3am)
        cronjobs_daily($time);
    if ($FD->cfg('cronjobs', 'last_cronjob_time_hourly') < $last_hour)
        cronjobs_hourly($time);
    if (($FD->cfg('cronjobs', 'last_cronjob_time')+5*60) < $time)
        cronjobs_instantly_bufferd($time);
}

////////////////////////
//// daily cronjobs ////
////////////////////////
function cronjobs_daily ($save_time = null) {
    global $FD;

    // Run Cronjobs
    search_index();
    clean_referers();
    HashMapper::deleteByTime();

    // save time
    if (!empty($save_time))
        $FD->saveConfig('cronjobs', array('last_cronjob_time_daily' => $save_time));
}

/////////////////////////
//// hourly cronjobs ////
/////////////////////////
function cronjobs_hourly ($save_time = null) {
    global $FD;

    // Run Cronjobs

    // save time
    if (!empty($save_time))
        $FD->saveConfig('cronjobs', array('last_cronjob_time_hourly' => $save_time));
}

/////////////////////////////////////////
//// instant tasks, bufferd for 5min ////
/////////////////////////////////////////
function cronjobs_instantly_bufferd ($save_time = null) {
    global $FD;

    // Run Cronjobs
    clean_timed_preview_images();

    // save time
    if (!empty($save_time))
        $FD->saveConfig('cronjobs', array('last_cronjob_time' => $save_time));
}


//////////////////////////////////////
//// clean up referrers by config ////
//////////////////////////////////////
function clean_referers ($time = null) {
    global $FD;

    // set time
    if (empty($time))
        $time = $FD->env('time');

    if ($FD->cfg('cronjobs', 'ref_cron') == 1) {
        delete_referrers(
            $FD->cfg('cronjobs', 'ref_days'),
            $FD->cfg('cronjobs', 'ref_hits'),
            $FD->cfg('cronjobs', 'ref_contact'),
            $FD->cfg('cronjobs', 'ref_age'),
            $FD->cfg('cronjobs', 'ref_amount'),
            $time);
    }
}


//////////////////////////////
//// Set correct Timezone ////
//////////////////////////////
function setTimezone ($timezone) {
    if (empty($timezone) || $timezone == 'default')
        date_default_timezone_get();
    date_default_timezone_set($timezone);
}


///////////////////////////////////
//// Maybe Update Search Index ////
///////////////////////////////////
function search_index ()
{
    global $FD;

    if ($FD->cfg('cronjobs', 'search_index_update') == 2) {
        // Include searchfunctions.php
        require ( FS2_ROOT_PATH . 'includes/searchfunctions.php' );
        update_search_index('news');
        update_search_index('articles');
        update_search_index('dl');
    }
}

///////////////////////////
//// get Main-Template ////
///////////////////////////
function get_maintemplate ($BODY, $PATH_PREFIX = '', $BASE = FALSE)
{
    global $FD;

    // Load Template Object
    $theTemplate = new template();
    $theTemplate->setFile('0_main.tpl');

    // Get Doctype
    $theTemplate->load('DOCTYPE');
    $template_doctype = (string) $theTemplate;

    // Base for Images
    $template_base = ($BASE !== FALSE) ? '<base href="'.$BASE .'">' : '';

	// Get Titel
	$template_title = get_title();

    // Create Link-Lines
    $template_favicon = ($FD->config('show_favicon') == 1) ? '<link rel="shortcut icon" href="'.$PATH_PREFIX .'styles/'.$FD->config('style').'/icons/favicon.ico">' : '';
	$template_feed = '<link rel="alternate" type="application/rss+xml" href="'.$PATH_PREFIX .'feeds/'.$FD->config('feed').'.php" title="'.$FD->config('title').' '.$FD->text('frontend', 'news_feed').'">';

    // Create Script-Lines
    $template_javascript = get_js($PATH_PREFIX).'
    <script type="text/javascript" src="'.$PATH_PREFIX.'includes/js_functions.js"></script>';

	// Create jQuery-Lines
    $template_jquery = '<script type="text/javascript" src="'.$PATH_PREFIX .'resources/jquery/jquery.min.js"></script>';
    $template_jquery_ui = '<script type="text/javascript" src="'.$PATH_PREFIX .'resources/jquery/jquery-ui.min.js"></script>';

    // Get HTML-Matrix
    $theTemplate->load('MATRIX');
    $theTemplate->tag('doctype', $template_doctype);
    $theTemplate->tag('language', $FD->config('language'));
    $theTemplate->tag('base_tag', $template_base);
    $theTemplate->tag('title', $template_title);
    $theTemplate->tag('title_tag', '<title>'.$template_title.'</title>');
    $theTemplate->tag('meta_tags', get_meta());

    $theTemplate->tag('css_links', get_css($PATH_PREFIX));
    $theTemplate->tag('favicon_link', $template_favicon);
    $theTemplate->tag('feed_link', $template_feed);

    $theTemplate->tag('javascript', $template_javascript);
    $theTemplate->tag('jquery', $template_jquery);
    //~ $theTemplate->tag('jquery-ui', $template_jquery_ui);

    $theTemplate->tag('body', $BODY);

    // Return Template
    return (string) $theTemplate;
}


///////////////////////
//// Get CSS-Links ////
///////////////////////
function get_css ($PATH_PREFIX)
{
    global $FD;

    // Get List of CSS-Files
    $search_path =  FS2_ROOT_PATH . 'styles/' . $FD->config('style');
    $link_path =  $PATH_PREFIX . 'styles/' . $FD->config('style');
    $files = scandir_ext($search_path, 'css');

    // Filter Go-CSS-Files
    $files_go_css = array_filter($files, create_function('$FILE', '
        if ( preg_match ( "/go_(.+).css/", $FILE ) ) {
            return TRUE;
        }
        return FALSE;
    '));

    // Special CSS-Files
    $files_special = array ( 'import.css', 'noscript.css' );
    $files_all_special = array_merge ( $files_special, $files_go_css );

    // Filter special Files
    $files_without_special = array_diff ($files, $files_all_special);

    // Unset template for security reasons
    initstr($template_css);

    // Search for import.css
    if ( in_array ( 'import.css', $files ) ) {
        $template_css .= '<link rel="stylesheet" type="text/css" href="'. $link_path .'/import.css">';
    // Else import other CSS-Files
    } else {
        foreach ($files_without_special as $file) {
            $template_css .= '
                <link rel="stylesheet" type="text/css" href="'. $link_path . '/' . $file .'">';
        }
    }

    // Other Special CSS
    if ( in_array ( 'noscript.css', $files ) ) {
        $template_css .= '
                <link rel="stylesheet" type="text/css" id="noscriptcss" href="'. $link_path . '/noscript.css">';
    }

    // Go-CSS-Files
    $go_css = 'go_'.$FD->config('goto').'.css';
    if ( in_array ( $go_css, $files_go_css ) ) {
        $template_css .= '
                <link rel="stylesheet" type="text/css" href="'. $link_path . '/' . $go_css .'">';
    }

    // Return Template
    return $template_css;
}

///////////////////////
//// Get JS-Links ////
///////////////////////
function get_js ($PATH_PREFIX)
{
    global $FD;

    // Get List of JS-Files
    $search_path =  FS2_ROOT_PATH . 'styles/' . $FD->config('style');
    $link_path =  $PATH_PREFIX . 'styles/' . $FD->config('style');
    $files = scandir_ext($search_path, 'js');

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
    $go_js = 'go_'.$FD->config('goto').'.js';
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
    global $FD;

    $keyword_arr = explode(',', $FD->config('keywords'));
    foreach ($keyword_arr as $key => $value) {
        $keyword_arr[$key] = trim($value);
    }
    $keywords = implode(', ', $keyword_arr);

    $template = '
    <meta name="title" content="'.get_title().'">
    '.get_meta_author().'
    <meta name="publisher" content="'.$FD->config('publisher').'">
    <meta name="copyright" content="'.$FD->config('copyright').'">
    <meta name="generator" content="Frogsystem 2 [http://www.frogsystem.de]">
    <meta name="description" content="'.$FD->config('description').'">
    '.get_meta_abstract().'
    <meta http-equiv="content-language" content="'.$FD->config('language').'">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="robots" content="index,follow">
    <meta name="Revisit-after" content="3 days">
    <meta name="DC.Title" content="'.get_title().'">
    '.get_meta_author(TRUE).'
    <meta name="DC.Rights" content="'.$FD->config('copyright').'">
    <meta name="DC.Publisher" content="'.$FD->config('publisher').'">
    <meta name="DC.Description" content="'.$FD->config('description').'">
    <meta name="DC.Language" content="'.$FD->config('language').'">
    <meta name="DC.Format" content="text/html">
    <meta name="keywords" lang="'.$FD->config('language').'" content="'.$keywords.'">
    '.get_canonical().'
    ';

    return $template;
}

///////////////////
//// get Title ////
///////////////////
function get_title ()
{
    global $FD;

    if ($FD->cfg('dyn_title') == 1 && $FD->configExists('info', 'page_title')) {
        $dyn_title = str_replace('{..title..}', $FD->cfg('title'), $FD->cfg('dyn_title_ext'));
        $dyn_title = str_replace('{..ext..}', $FD->info('page_title'), $dyn_title);
        return $dyn_title;
    } else {
        return $FD->cfg('title');
    }
}

/////////////////////////////
//// get Author Meta Tag ////
/////////////////////////////
function get_meta_author ($DC = FALSE)
{
    global $FD;

    if ($FD->configExists('content_author') && $FD->config('content_author') != '')
        $author = $FD->config('content_author');
    else
        $author = $FD->config('publisher');

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
    global $FD;

    if ($FD->configExists('content_abstract') && $FD->config('content_abstract') != '') {
        return '<meta name="abstract" content="'.$FD->config('content_abstract').'">';
    } else {
        return '<meta name="abstract" content="'.$FD->config('description').'">';
    }
}


/////////////////////////////////////
//// Get canonical link meta tag ////
/////////////////////////////////////
function get_canonical()
{
    global $FD;

	// Check for homepage and in case don't use any paramter (including go) at all
    $goto = $FD->cfg('goto');
	if ($goto == $FD->cfg('home_real'))
		$goto = '';

    // get canoncial parameters
	if (!is_null($canonparams = $FD->info('canonical'))) {
        $activeparams = array();

        if (count($canonparams) > 0) {
            ksort($canonparams);
            foreach ($canonparams as $key)
            {
                // List only canoncial parameters with any value
                // Also we don't use original user values, but values checked by FS2
                if ((isset($_GET[$key]))) {
                    $activeparams[$key] = $_GET[$key];
                }
            }
        }

        return '<link rel="canonical" href="'.url($goto, $activeparams, true).'">';
    }
}



/////////////////////
//// get Content ////
/////////////////////
function get_content ($GOTO)
{
    global $FD, $sql;

    // Display Content
    initstr($template);

    // Script-File in /data/
    if (file_exists('data/'.$GOTO.'.php')) {
        include(FS2_ROOT_PATH . 'data/'.$GOTO.'.php');
    } elseif (file_exists ('data/'.$GOTO)) {
        include(FS2_ROOT_PATH . 'data/'.$GOTO );
    } else {

    // Articles from DB
    $stmt = $FD->sql()->conn()->prepare(
                  'SELECT COUNT(article_id) FROM '.$FD->config('pref').'articles
                   WHERE `article_url` = ? LIMIT 0,1');
    $stmt->execute(array($GOTO));
    $num = $stmt->fetchColumn();
    if ($num >= 1) {

        // Forward Aliases
        $alias = $FD->sql()->conn()->query(
                      'SELECT alias_forward_to FROM '.$FD->config('pref')."aliases
                       WHERE `alias_active` = 1 AND `alias_go` = 'articles.php'");
        $alias = $alias->fetch(PDO::FETCH_ASSOC);
        if (!empty($alias)) {
            include(FS2_ROOT_PATH . 'data/' . stripslashes($alias['alias_forward_to']));
        } else {
            include(FS2_ROOT_PATH . 'data/articles.php');
        }

        // File-Download
        } elseif ($GOTO == 'dl' && isset ($_GET['fileid']) && isset ($_GET['dl'])) {

        // 404-Error Page, no content found
        } else {
            $FD->setConfig('goto', '404');
            $FD->setConfig('env', 'goto', '404');
            include(FS2_ROOT_PATH . 'data/404.php');
        }
    }

    // Return Content
    return $template;
}


////////////////////////////////////
//// Init Template Replacements ////
////////////////////////////////////
function tpl_functions_init ($TEMPLATE)
{
    global $sql, $NAV, $APP, $FD;

    // data arrays
    $NAV = array();
    $APP = load_applets();

    // Snippets
    $SNP = array();

    return tpl_functions($TEMPLATE, $FD->cfg('system', 'var_loop'), array(), true);
}

///////////////////////////////
//// Template Replacements ////
///////////////////////////////
function tpl_functions ($TEMPLATE, $COUNT, $filter=array(), $loopend_escape = true)
{
    global $sql;

    // hardcoded functions
    // this is the only way atm
    $functions = array(
        'APP'   => array('tpl_func_applets',        true),
        'NAV'   => array('tpl_func_navigations',    true),
        'DATE'  => array('tpl_func_date',           false),
        'VAR'   => array('tpl_func_globalvars',     false),
        'URL'   => array('tpl_func_url',            false),
    );
    //Snippet
    $snippet_functions = array(
        'SNP'   => array('tpl_func_snippets',       true)
    );

    //Filter functions
    if (!empty($filter)) {
        $functions = array_filter_keys($functions, $filter);
        $snippet_functions = array_filter_keys($snippet_functions, $filter);
    }


    // Set Pattern and Replacment Code
    $PATTERN = $REPLACEMENT = array();
    if (!empty($functions)) {
        array_push($PATTERN, '/\$('.implode('|', array_keys($functions)).')\((?|(?:"(.*?)")|(.*?))(?:\[(?|(?:"(.*?)")|(.*?))\]){0,1}\)/e');
        array_push($REPLACEMENT, 'call_tpl_function($functions, $COUNT, array(\'$1\', \'$0\', \'$2\', \'$3\'), $loopend_escape);');
    }
    if (!empty($snippet_functions)) {
        array_push($PATTERN, '/\[%(.*?)%\]/e');
        array_push($REPLACEMENT, 'call_tpl_function($snippet_functions, $COUNT, array("SNP", "$0", "$1", ""), $loopend_escape);');
    }

    // Replace Functions with computed values
    $TEMPLATE = preg_replace($PATTERN, $REPLACEMENT, $TEMPLATE);

    return $TEMPLATE;
}


function call_tpl_function ($functions, $COUNT, $called_function, $loopend_escape = true)
{
    // call function with arguments
    $replacement = call_user_func($functions[$called_function[0]][0], $called_function[1], $called_function[2], $called_function[3]);

    // only for recursive functions & recursion-counter > 0
    if($functions[$called_function[0]][1] && $COUNT > 0) {
        $replacement = tpl_functions($replacement, $COUNT-1);
    } else {
        if ($loopend_escape)
            $replacement = escape_tpl_functions($replacement, array_keys($functions));
        else
            $replacement = remove_tpl_functions($replacement, array_keys($functions));
    }
    return $replacement;
}


/////////////////////////////////////////
//// Replace all special chars for X ////
//// in Templates with htmlentities  ////
/////////////////////////////////////////
function escape_tpl_functions ($TEMPLATE, $FUNCTIONS)
{
    $PATTERNS = array(
        '/\[%/',
        '/%\]/',
        '/\$('.implode("|", $FUNCTIONS).')\(/',
    );

    $REPLACEMENTS = array(
        '&#x5B;&#x25;',
        '&#x25;&#x5D;',
        '&#x24;$1&#x28;'
    );

    return preg_replace($PATTERNS, $REPLACEMENTS, $TEMPLATE);
}

///////////////////////////////////
//// Remove Template Functions ////
///////////////////////////////////
function remove_tpl_functions ($TEMPLATE, $FUNCTIONS)
{
    $PATTERN = $REPLACEMENT = array();

    // Snippet?
    if (in_array('SNP', $FUNCTIONS)) {
        $FUNCTIONS = array_diff($FUNCTIONS, array('SNP'));
        array_push($PATTERN, '/\[%(.*?)%\]/');
        array_push($REPLACEMENT, '');
    }

    // Normal TPL Functions
    array_push($PATTERN, '/\$('.implode('|', $FUNCTIONS).')\((?|(?:"(.*?)")|(.*?))(?:\[(?|(?:"(.*?)")|(.*?))\]){0,1}\)/');
    array_push($REPLACEMENT, '');

    // Remove them
    return preg_replace($PATTERN, $REPLACEMENT, $TEMPLATE);
}

////////////////////////////////////////////////
//// Return an array with all tpl functions ////
////////////////////////////////////////////////
function get_all_tpl_functions()
{
    return array('APP', 'NAV', 'DATE', 'VAR', 'URL', 'SNP');
}

//////////////////////
//// Load Applets ////
//////////////////////
function load_applets()
{
    global $sql, $FD;

    // Load Applets from DB
    $applet_data = $FD->sql()->conn()->query(
                       'SELECT applet_include, applet_file, applet_output
                        FROM '.$FD->config('pref').'applets
                        WHERE `applet_active` = 1');
    $applet_data = $applet_data->fetchAll(PDO::FETCH_ASSOC);

    // Write Applets into Array & get Applet Template
    initstr($template);
    $new_applet_data = array();
    foreach ($applet_data as $key => $entry) {
        // prepare data
        $entry['applet_file'] .= '.php';
        settype($entry['applet_output'], 'boolean');

        // include applets & load template
        if ($entry['applet_include'] == 1) {
            $entry['applet_template'] = load_an_applet($entry['applet_file'], $entry['applet_output'], array());
        }

        $new_applet_data[$entry['applet_file']] = $entry;
    }

    // Return Content
    return $new_applet_data;
}

//////////////////////
//// Load Applets ////
//////////////////////
function load_an_applet($file, $output, $args) {

    global $FD;
    global $sql;

    // Setup $SCRIPT Var
    unset($SCRIPT, $template);
    $SCRIPT['argc'] = array_unshift($args, $file);
    $SCRIPT['argv'] = $args;

    //start output buffering
    ob_start();

    // include applet & load template
    try {
        include(FS2_ROOT_PATH.'applets/'.$file);
    } catch (Exception $e) {}

    //end & clean output buffering
    $return_data = ob_get_clean();

    // set empty str
    if (!isset($template)) {
		initstr($template);
    }

    //create return value
    if ($output) {
        return($return_data.$template);
    }
    return '';
}


//////////////////////////
//// Replace Snippets ////
//////////////////////////
function tpl_func_snippets($original, $main_argument, $other_arguments)
{
    global $SNP, $sql;

    // Load Navigation on demand
    if (!isset($SNP[$main_argument])) {
        // Get Snippet and write into Array
        $data = $sql->conn()->prepare(
                    'SELECT snippet_tag, snippet_text FROM '.$sql->getPrefix().'snippets
                     WHERE `snippet_tag` = ? AND `snippet_active` = 1 LIMIT 1');
        $data->execute(array($original));
        $data = $data->fetch(PDO::FETCH_ASSOC);
        // Snippet not found?
        if (empty($data)) {
            $data['snippet_text'] = $original;
        }

        $SNP[$main_argument] = $data['snippet_text'];
    }

    // Return Content
    return $SNP[$main_argument];
}


/////////////////////////
//// Replace Applets ////
/////////////////////////
function tpl_func_applets($original, $main_argument, $other_arguments)
{
    global $APP, $sql, $FD;

    // Applet does not exists
    if (!isset($APP[$main_argument])) {
        return $original;
    }

    // compute Arguments
    if (!empty($other_arguments)) {
        $other_arguments = explode(' ', $other_arguments);
    } else {
        $other_arguments = array();
    }

    // Maybe load Applet on demand
    if ($APP[$main_argument]['applet_include'] != 1 || count($other_arguments) > 0) {
        // Return Content
        return load_an_applet($main_argument, $APP[$main_argument]['applet_output'], $other_arguments);
    } else {
        // Return Content
        return $APP[$main_argument]['applet_template'];
    }
}


/////////////////////////////
//// Replace Navigations ////
/////////////////////////////
function tpl_func_navigations($original, $main_argument, $other_arguments)
{
    global $NAV, $FD;

    // Load Navigation on demand
    if (!isset($NAV[$main_argument])) {
        // Write navigation into Array
        $STYLE_PATH = 'styles/'.$FD->config('style').'/';
        $ACCESS = new fileaccess();
        $template = $ACCESS->getFileData(FS2_ROOT_PATH.$STYLE_PATH.$main_argument);

        // File not found?
        if ($template === false) {
            //$template = 'Error: Navi File not found!';
            $template = $original;
        }

        $NAV[$main_argument] = $template;
    }

    // Return Content
    return $NAV[$main_argument];
}

//////////////////////////////////
//// Replace Global Variables ////
//////////////////////////////////
function tpl_func_globalvars($original, $main_argument, $other_arguments)
{
    global $FD;

    // hardcoded list of global vars
    $var_data = array (
        'url'                           => $FD->cfg('virtualhost'),
        'style_url'                     => $FD->cfg('virtualhost').'styles/'.$FD->cfg('style').'/',
        'style_images'                  => $FD->cfg('virtualhost').'styles/'.$FD->cfg('style').'/images/',
        'style_icons'                   => $FD->cfg('virtualhost').'styles/'.$FD->cfg('style').'/icons/',
        'page_title'                    => $FD->cfg('title'),
        'page_dyn_title'                => get_title(),
        'date'                          => date_loc($FD->cfg('date'), $FD->cfg('env', 'date')),
        'time'                          => date_loc($FD->cfg('time'), $FD->cfg('env', 'date')),
        'page_dyndate_time_title'       => date_loc($FD->cfg('datetime'), $FD->cfg('env', 'date')),
    );

    //set error msg
    //$error = 'Error: Unknown global Var!';
    $error = $original;

    //return var or false
    return (isset($var_data[$main_argument])) ? $var_data[$main_argument] : $error;
}

/////////////////////////////////////
//// Template Function for Dates ////
/////////////////////////////////////
function tpl_func_date($original, $main_argument, $other_arguments)
{
    // current timestamp if no other timestamp is passed
    if (empty($other_arguments))
        $other_arguments = time();

    //return var or false
    return date_loc($main_argument, intval($other_arguments));
}


/////////////////////
//// Replace URL ////
/////////////////////
function tpl_func_url($original, $main_argument, $other_arguments)
{
    // Example:
    // $URL(download[cat_id=4 keyword=test 1])

    global $FD;

    // compute Arguments
    $other_arguments = !empty($other_arguments) ? explode(' ', $other_arguments) : array();

    // check each param
    $params = array(); $full = false; //some default values
    foreach ($other_arguments as $argument) {
        $full = false; // reset $full indicator (because the last one wasn't last of all)
        $param = explode('=', $argument, 2); // explode by =
        if (count($param) < 2) { // only value of param available
            if ($param[0] == 'true' || $param[0] == 1) { // param maybe indicating a full url request
                $full = true; // but only if it's the last one
                break;
            } else {
                $params[] = $param[0];
            }
        } else {
            $params[$param[0]] = $param[1];
        }
    }

    // finally create URL
    return url($main_argument, $params, $full);
}

// fs2seourl Version 1.01 (27.08.2001)
function get_seo () {

    global $FD;

    // Anzahl der mittel ? übergegebenen Parameter speichern
    if (isset($_GET))
        $numparams = count($_GET);
    else
        $numparams = 0;

    $redirect = false;

    // Wurde dieser Skript direkt aufgrufen werden oder indirekt ueber mod_rewrite?
    $calledbyrewrite = isset($_SERVER['REDIRECT_QUERY_STRING']);

    // mod_rewrite schreibt in seoq den Dateinamen der fiktiven HTML-Datei (ohne die .html-Dateiendung).
    // Dieser Name muss nun zerlegt und in die Parameter uebersetzt werden, welche das FrogSystem erwaretet.
    if ((isset($_GET['seoq'])) && ($calledbyrewrite)) {
        // seoq wurde von mod_rewrite eingefuegt und ist daher kein echter Parameter
        $numparams--;

        // Drei oder mehr Bindestriche temporaer durch zwei weniger \x1 ersetzen, um sie von Seperatoren unterscheiden zu koennen
        $_GET['seoq'] = preg_replace_callback('/---+/', create_function('$matches', 'return str_repeat("\x1", strlen($matches[0]) - 2);'), $_GET['seoq']);

        $paramdelim = strpos($_GET['seoq'], '--');

        if ($numparams > 0) {
            //Wurden hinter das .html noch Parameter gepackt, sind diese massgeblich => Den Rest verwerfen und weiterleiten
            $redirect =	true;
        }
        else if ($paramdelim === false) {
            // Kein -- => Keine Parameter => Der komplette Dateiname ist der go-Parameter
            if (!isset($_GET['go']))
                $_GET['go'] = str_replace("\x1", '-', $_GET['seoq']);
        }
        else {
            // -- vorhanden => Alles davor ist der go-Parameter, alles dahinter sind weitere Parameter.
            // Diese muessen allerdings ein bestimmtes Format einhalten, ansonsten wird auf das richtige Format weitergeleitet

            if (!isset($_GET['go']))
                $_GET['go'] = substr($_GET['seoq'], 0, $paramdelim);

            $seoparamstr = substr($_GET['seoq'], $paramdelim + 2);

            // Hinter dem -- muss noch etwas kommen, sonst Weiterleitung
            if (strlen($seoparamstr) > 0)
            {
                $seoparams = explode('-', $seoparamstr);
                for ($i = 0; $i < count($seoparams); $i++)
                    $seoparams[$i] = str_replace("\x1", '-', $seoparams[$i]);

                // Die Anzahl der mit "-" getrennten Werte muss gerade sein, sonst Weiterleitung
                if ((count($seoparams) % 2 != 0) && (count($seoparams) > 0))
                    $redirect = true;

                for ($i = 0; $i < count($seoparams); $i += 2)
                {
                    // i ist der Name des Parameters, i+1 ist der Wert des Parameters
                    if (!isset($_GET[$seoparams[$i]]))
                        $_GET[$seoparams[$i]] = $seoparams[$i+1];

                    // Die Parameter muessen alphabetisch sortiert sein, sonst Weiterleitung
                    if (($i >= 2) && (strcmp($seoparams[$i - 2], $seoparams[$i]) >= 0))
                        $redirect = true;
                }
            }
            else {
                $redirect = true;
            }
        }

        unset($seoparams);
        unset($seoparamstr);
        unset($paramdelim);
    }
    elseif ($numparams > 0) {
        $redirect = true;
    }

    unset($_GET['seoq']);
    unset($_REQUEST['seoq']);

    // Expliziter Aufruf von index.php bzw. indexseo.php => Weiterleitung erzwingen
    if ((!$calledbyrewrite) && (substr($_SERVER['REQUEST_URI'], -1) != '/')) {
        $redirect = true;
    }
    // Bei Bedarf Weiterleitung auf die neue URL im richtigen Format
    if ($redirect) {
        header('Location: ' . $FD->cfg('virtualhost') . url_seo($_GET['go'], $_GET, true), true, 301);
        die();
    }

    // Inhalt von $_GET nach $_REQUEST kopieren
    foreach ($_GET as $k => $v)
        $_REQUEST[$k] = $v;

    // Query-String anpassen
    $_SERVER['QUERY_STRING'] = '';
    foreach ($_GET as $k => $v)
        $_SERVER['QUERY_STRING'] .= urlencode($k) . '=' . urlencode($v) . '&';
    $_SERVER['REQUEST_URI'] = '/index.php?' . $_SERVER['QUERY_STRING'];

    // Falls noetig, Verhalten von register_globals nachahmen
    if (in_array(ini_get('register_globals') == 'on', array('0', 'on', 'true')))
        extract($_REQUEST);

    // Hotlinkingschutz vom FS2 zufrieden stellen
    if (isset($_SERVER['HTTP_REFERER']))
      if (preg_match('/\/dlfile--.*\.html$/', $_SERVER['HTTP_REFERER']))
          $_SERVER['HTTP_REFERER'] .= '?go=dlfile';
}





///////////////////
//// get $goto ////
///////////////////
function get_goto ()
{
    global $FD;

    //check seo
    if ($FD->cfg('url_style') == 'seo') {
        get_seo();
    }

    // Check $_GET['go']
    $FD->setConfig('env', 'get_go_raw', $_GET['go']);
    $goto = empty($_GET['go']) ? $FD->cfg('home_real') : savesql($_GET['go']);
    $FD->setConfig('env', 'get_go', $goto);

    // Forward Aliases
    $goto = forward_aliases($goto);

    // write $goto into $global_config_arr['goto']
    $FD->setConfig('goto', $goto);
    $FD->setConfig('env', 'goto', $goto);
}


/////////////////////////
//// forward aliases ////
/////////////////////////
function forward_aliases ( $GOTO )
{
    global $FD;

    $aliases = $FD->sql()->conn()->prepare(
                     'SELECT alias_go, alias_forward_to FROM '.$FD->config('pref').'aliases
                      WHERE `alias_active` = 1 AND `alias_go` = ?');
    $aliases->execute(array($GOTO));
    $aliases = $aliases->fetchAll(PDO::FETCH_ASSOC);

    foreach ($aliases as $alias) {
        if ($GOTO == $alias['alias_go']) {
            $GOTO = $alias['alias_forward_to'];
        }
    }

    return $GOTO;
}

///////////////////
//// count hit ////
///////////////////
function count_all ( $GOTO )
{
    global $FD;

    $hit_year = date ( 'Y' );
    $hit_month = date ( 'm' );
    $hit_day = date ( 'd' );

    visit_day_exists ( $hit_year, $hit_month, $hit_day );
    count_hit ( $GOTO );
}

///////////////////////////////////
//// check if visit day exists ////
///////////////////////////////////
function visit_day_exists ( $YEAR, $MONTH, $DAY )
{
    global $FD;

    // check if visit-day exists
    $daycounter = $FD->sql()->conn()->query ('SELECT * FROM '.$FD->config('pref').'counter_stat
                                WHERE s_year = '.$YEAR.' AND s_month = '.$MONTH.' AND s_day = '.$DAY);

    if ( $daycounter->fetch(PDO::FETCH_ASSOC) === false )
    {
        $FD->sql()->conn()->exec('INSERT INTO '.$FD->config('pref')."counter_stat (s_year, s_month, s_day, s_visits, s_hits) VALUES ('".$YEAR."', '".$MONTH."', '".$DAY."', '0', '0')" );
    }
}


///////////////////
//// count hit ////
///////////////////
function count_hit ( $GOTO )
{
    global $FD;

    $hit_year = date ( 'Y' );
    $hit_month = date ( 'm' );
    $hit_day = date ( 'd' );

    if ( $GOTO != '404' && $GOTO != '403' ) {
        // count page_hits
        $FD->sql()->conn()->exec ( 'UPDATE '.$FD->config('pref').'counter SET hits = hits + 1' );
        $FD->sql()->conn()->exec ( 'UPDATE '.$FD->config('pref').'counter_stat
                                    SET s_hits = s_hits + 1
                                    WHERE s_year = '.$hit_year.' AND s_month = '.$hit_month.' AND s_day = '.$hit_day );
    }
}


/////////////////////
//// count visit ////
/////////////////////
function count_visit ()
{
    global $FD;

    $visit_year = date ( 'Y' );
    $visit_month = date( 'm' );
    $visit_day = date ( 'd' );

    $FD->sql()->conn()->exec('UPDATE '.$FD->config('pref').'counter SET visits = visits + 1');
    $FD->sql()->conn()->exec('UPDATE '.$FD->config('pref').'counter_stat
                              SET s_visits = s_visits + 1
                              WHERE s_year = '.$visit_year.' AND s_month = '.$visit_month.' AND s_day = '.$visit_day);
}


///////////////////////
//// save visitors ////
///////////////////////
function save_visitors ()
{
    global $FD;

    clean_iplist(); // remove old users first

    // get user_id or set user_id=0
    if (is_loggedin() && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        settype($user_id, 'integer');
    } else {
        $user_id = 0;
    }

    // Exisiting user for ip?
    $user = $FD->sql()->conn()->prepare('SELECT * FROM '.$FD->config('pref').'useronline WHERE `ip` = ? LIMIT 1');
    $user->execute(array($_SERVER['REMOTE_ADDR']));
    $user = $user->fetch(PDO::FETCH_ASSOC);

    // no user => create new
    if (empty($user)) {
        $stmt = $FD->sql()->conn()->prepare('INSERT INTO '.$FD->config('pref').'useronline SET `ip` = ?, user_id='.$user_id.', date='.(int) $FD->env('time'));
        $stmt->execute(array($_SERVER['REMOTE_ADDR']));

        // and count the visit
        count_visit();
    }

    // new user_id (and update time)
    else if ($user['user_id'] != $user_id) {
        $stmt = $FD->sql()->conn()->prepare('UPDATE '.$FD->config('pref').'useronline SET user_id = '.$user_id.', date = '.(int) $FD->env('time').' WHERE ip = ? LIMIT 1');
        $stmt->execute(array($_SERVER['REMOTE_ADDR']));
    }

    // we know the user => just update time
    else {
        $stmt = $FD->sql()->conn()->prepare('UPDATE '.$FD->config('pref').'useronline SET date = '.(int) $FD->env('time').' WHERE ip = ? LIMIT 1');
        $stmt->execute(array($_SERVER['REMOTE_ADDR']));
    }
}

//////////////////////
//// clean iplist ////
//////////////////////
function clean_iplist()
{
    global $FD;

    $time = strtotime('today');
    $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref')."useronline WHERE `date` < '".$time."'");
}


//////////////////////
//// save referer ////
//////////////////////
function save_referer ()
{
    global $FD;

	if (isset($_SERVER['HTTP_REFERER'])) {

		$time = time(); // timestamp
		// save referer
		$referer = preg_replace ( "=(.*?)\=([0-9a-z]{32})(.*?)=i", "\\1=\\3", $_SERVER['HTTP_REFERER'] );
		$index = $FD->sql()->conn()->prepare ( 'SELECT * FROM '.$FD->config('pref').'counter_ref WHERE ref_url = ?' );
		$index->execute(array($referer));

		if ( $index->fetch(PDO::FETCH_ASSOC) === false ) {
			if ( substr_count ( $referer, 'http://' ) >= 1 && substr_count ( $referer, $FD->config('virtualhost') ) < 1 ) {
				$stmt = $FD->sql()->conn()->prepare ( 'INSERT INTO '.$FD->config('pref')."counter_ref (ref_url, ref_count, ref_first, ref_last) VALUES (?, '1', '".$time."', '".$time."')" );
				$stmt->execute(array($referer));
			}
		} else {
			if ( substr_count ( $referer, 'http://' ) >= 1 && substr_count ( $referer, $FD->config('virtualhost') ) < 1 ) {
				$stmt = $FD->sql()->conn()->prepare ( 'UPDATE '.$FD->config('pref')."counter_ref SET ref_count = ref_count + 1, ref_last = '".$time."' WHERE ref_url = ? LIMIT 1" );
				$stmt->execute(array($referer));
			}
		}
	}
}


//////////////////////////////////////////////////////////
//// clean database from expired timed preview_images ////
//////////////////////////////////////////////////////////
function clean_timed_preview_images () {
    global $FD;
    $FD->loadConfig('preview_images');

    // do we want to remove old entries?
    if ($FD->config('preview_images', 'random_timed_deltime') != -1) {
        // remove old entries
        $FD->sql()->conn()->query('DELETE FROM '.$FD->config('pref')."screen_random WHERE `end` < '".($FD->env('time')-$FD->config('preview_images', 'random_timed_deltime'))."'");
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
    global $FD;

    if ( isset ( $_GET['style'] ) && $FD->cfg('allow_other_designs') == 1 ) {
        $index = $FD->sql()->conn()->prepare ( '
                        SELECT `style_id`, `style_tag`
                        FROM `'.$FD->config('pref')."styles`
                        WHERE `style_tag` = ?
                        AND `style_allow_use` = 1
                        LIMIT 0,1");
        $index->execute(array($_GET['style']));
        $row = $index->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) {
            $FD->setConfig('style', stripslashes ( $row['style_tag'] ) );
            $FD->setConfig('style_tag', stripslashes ( $row['style_tag'] ) );
            $FD->setConfig('style_id', $row['style_id'] );
        }
    } elseif ( isset ( $_GET['style_id'] ) && $FD->config('allow_other_designs') == 1 ) {
        settype ( $_GET['style_id'], 'integer' );
        $index = $FD->sql()->conn()->query ( '
                        SELECT `style_id`, `style_tag`
                        FROM `'.$FD->config('pref')."styles`
                        WHERE `style_id` = '".$_GET['style_id']."'
                        AND `style_allow_use` = 1
                        LIMIT 0,1" );
        $row = $index->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) {
            $FD->setConfig('style', stripslashes ( $row['style_tag'] ) );
            $FD->setConfig('style_tag', stripslashes ( $row['style_tag'] ) );
            $FD->setConfig('style_id', $row['style_id'] );
        }
    }
    copyright ();
}

//////////////////////////////////
//// copyright security check ////
//////////////////////////////////
function copyright ()
{
    global $FD;

    $template_copyright = new template();
    $template_copyright->setFile('0_main.tpl');
    $template_copyright->load('MAIN');
    $copyright = (string) $template_copyright;

    if (strpos($copyright, $template_copyright->getOpener().'copyright'.$template_copyright->getCloser()) == FALSE
        || strpos(get_copyright(), 'Frogsystem&nbsp;2' ) == FALSE || strpos(get_copyright(), '&copy; 2007 - 2011 Frogsystem-Team') == FALSE
        || strpos(get_copyright(), 'Powered by' ) == FALSE || strpos(get_copyright(), 'frogsystem.de') == FALSE )
    {
        $FD->setConfig('style',  'default');
        $FD->setConfig('style_id', 0);
    } else {
        $copyright_without_comments = preg_replace("/<!\s*--.*?--\s*>/s", "", $copyright);
        if (preg_match("/\{\.\.copyright\.\.\}/", $copyright_without_comments) <= 0) {
            $FD->setConfig('style', 'default');
            $FD->setConfig('style_id', 0);
        }
    }
}
?>
