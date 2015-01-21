<?php




//////////////////////////////
//// Set correct Timezone ////
//////////////////////////////
function setTimezone ($timezone) {
    if (empty($timezone) || $timezone == 'default') {
        $timezone = date_default_timezone_get();
    }
    date_default_timezone_set($timezone);
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
    <script type="text/javascript" src="'.$PATH_PREFIX.'assets/main.js"></script>';

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
    $search_path =  FS2STYLES . '/' . $FD->config('style');
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
    $search_path =  FS2STYLES . '/' . $FD->config('style');
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
    $keywords = killhtml(implode(', ', $keyword_arr));

    $template = '
    <meta name="title" content="'.killhtml(get_title()).'">
    '.get_meta_author().'
    <meta name="publisher" content="'.killhtml($FD->config('publisher')).'">
    <meta name="copyright" content="'.killhtml($FD->config('copyright')).'">
    <meta name="generator" content="Frogsystem 2 [http://www.frogsystem.de]">
    <meta name="description" content="'.killhtml($FD->config('description')).'">
    '.get_meta_abstract().'
    <meta http-equiv="content-language" content="'.killhtml($FD->config('language')).'">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="robots" content="index,follow">
    <meta name="Revisit-after" content="3 days">
    <meta name="DC.Title" content="'.killhtml(get_title()).'">
    '.get_meta_author(TRUE).'
    <meta name="DC.Rights" content="'.killhtml($FD->config('copyright')).'">
    <meta name="DC.Publisher" content="'.killhtml($FD->config('publisher')).'">
    <meta name="DC.Description" content="'.killhtml($FD->config('description')).'">
    <meta name="DC.Language" content="'.killhtml($FD->config('language')).'">
    <meta name="DC.Format" content="text/html">
    <meta name="keywords" lang="'.killhtml($FD->config('language')).'" content="'.$keywords.'">
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
        $output = '<meta name="DC.Creator" content="'.killhtml($author).'">';
    else
        $output = '<meta name="author" content="'.killhtml($author).'">';

    return $output;
}

/////////////////////////////
//// get Abstract Meta Tag ////
/////////////////////////////
function get_meta_abstract ()
{
    global $FD;

    if ($FD->configExists('content_abstract') && $FD->config('content_abstract') != '') {
        return '<meta name="abstract" content="'.killhtml($FD->config('content_abstract')).'">';
    } else {
        return '<meta name="abstract" content="'.killhtml($FD->config('description')).'">';
    }
}


/////////////////////////////////////
//// Get canonical link meta tag ////
/////////////////////////////////////
function get_canonical() {
    $url = get_canonical_url();
	if (!empty($url)) {
        return '<link rel="canonical" href="'.$url.'">';
    }
}

function get_canonical_url() {
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

        return url($goto, $activeparams, true);
    }
    return url($goto, array(), true);
}



/////////////////////
//// get Content ////
/////////////////////
function get_content ($GOTO)
{
    global $FD;

    // Display Content
    initstr($template);

    // Script-File in /data/
    if (file_exists(FS2SOURCE . '/data/'.$GOTO.'.php')) {
        include(FS2SOURCE . '/data/'.$GOTO.'.php');
    } elseif (file_exists (FS2SOURCE . '/data/'.$GOTO)) {
        include(FS2SOURCE . '/data/'.$GOTO );
    } else {

    // Articles from DB
    $stmt = $FD->db()->conn()->prepare(
                  'SELECT COUNT(article_id) FROM '.$FD->env('DB_PREFIX').'articles
                   WHERE `article_url` = ? LIMIT 0,1');
    $stmt->execute(array($GOTO));
    $num = $stmt->fetchColumn();
    if ($num >= 1) {

        // Forward Aliases
        $alias = $FD->db()->conn()->query(
                      'SELECT alias_forward_to FROM '.$FD->env('DB_PREFIX')."aliases
                       WHERE `alias_active` = 1 AND `alias_go` = 'articles.php'");
        $alias = $alias->fetch(PDO::FETCH_ASSOC);
        if (!empty($alias)) {
            $FD->setConfig('env', 'goto', $alias['alias_forward_to']);
            include(FS2SOURCE . '/data/' . $alias['alias_forward_to']);
        } else {
            $FD->setConfig('env', 'goto', 'articles');
            include(FS2SOURCE . '/data/articles.php');
        }

        // File-Download
        } elseif ($GOTO == 'dl' && isset ($_GET['fileid']) && isset ($_GET['dl'])) {

        // 404-Error Page, no content found
        } else {
            $FD->setConfig('goto', '404');
            $FD->setConfig('env', 'goto', '404');
            include(FS2SOURCE . '/data/404.php');
        }
    }

    // Return Content
    return $template;
}




//////////////////////
//// Load Applets ////
//////////////////////
function load_applets()
{
    global $FD;

    // Load Applets from DB
    $applet_data = $FD->db()->conn()->query(
                       'SELECT applet_include, applet_file, applet_output
                        FROM '.$FD->env('DB_PREFIX').'applets
                        WHERE `applet_active` = 1');
    $applet_data = $applet_data->fetchAll(PDO::FETCH_ASSOC);

    // Write Applets into Array & get Applet Template
    initstr($template);
    $new_applet_data = array();
    foreach ($applet_data as $entry) {
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
function load_an_applet($file, $output, $args)
{
	global $FD;
    // Setup $SCRIPT Var
    unset($SCRIPT, $template);
    $SCRIPT['argc'] = array_unshift($args, $file);
    $SCRIPT['argv'] = $args;

    //start output buffering
    ob_start();

    // include applet & load template
    try {
        include(FS2APPLETS.'/'.$file);
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









////////////////////////////////////
//// Init Template Replacements ////
////////////////////////////////////
function tpl_functions_init ($TEMPLATE)
{
    global $NAV, $APP, $FD;

    // data arrays
    $NAV = array();
    //~ $APP = load_applets();

    // Snippets
    $SNP = array();

    return tpl_functions($TEMPLATE, $FD->cfg('system', 'var_loop'), array(), true);
}

///////////////////////////////
//// Template Replacements ////
///////////////////////////////
function tpl_functions ($TEMPLATE, $COUNT, $filter=array(), $loopend_escape = true)
{
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
    // Replace Functions with computed values
    if (!empty($functions)) {
        $PATTERN = '/\$('.implode('|', array_keys($functions)).')\((?|(?:"(.*?)")|(.*?))(?|\[(?|(?:"(.*?)")|(.*?))\]|()){0,1}\)/';
        $REPLACEMENT = create_function('$data', 'return call_tpl_function('.var_export($functions, true).', '.var_export($COUNT, true).', array($data[1], $data[0], $data[2], $data[3]), '.var_export($loopend_escape, true).');');
        $TEMPLATE = preg_replace_callback($PATTERN, $REPLACEMENT, $TEMPLATE);
    }
    if (!empty($snippet_functions)) {
        $PATTERN = '/\[%(.*?)%\]/';
        $REPLACEMENT = create_function('$data', 'return call_tpl_function('.var_export($snippet_functions, true).', '.var_export($COUNT, true).', array("SNP", $data[0], $data[1], ""), '.var_export($loopend_escape, true).');');
        $TEMPLATE = preg_replace_callback($PATTERN, $REPLACEMENT, $TEMPLATE);
    }

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


//////////////////////////
//// Replace Snippets ////
//////////////////////////
function tpl_func_snippets($original, $main_argument, $other_arguments)
{
    global $SNP, $FD;

    // Load Navigation on demand
    if (!isset($SNP[$main_argument])) {
        // Get Snippet and write into Array
        $data = $FD->db()->conn()->prepare(
                    'SELECT snippet_tag, snippet_text FROM '.$FD->db()->getPrefix().'snippets
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
    global $APP;

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
        $STYLE_PATH = '/'.$FD->config('style').'/';
        $ACCESS = new fileaccess();
        $template = $ACCESS->getFileData(FS2STYLES.$STYLE_PATH.$main_argument);

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
        'date_time'                     => date_loc($FD->cfg('datetime'), $FD->cfg('env', 'date')),
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
    // Example:
    // $DATE(d.m.Y) => 03.05.2013 (where today is 03.05.2013)
    // $DATE(d.m.Y [946706400]) => 01.01.2000 (946706400 is timestamp of 01.01.2000)

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

    // compute arguments
    $other_arguments = !empty($other_arguments) ? explode(' ', $other_arguments) : array();

    // check each param
    $params = array(); $full = false; //some default values
    foreach ($other_arguments as $argument) {
        $full = false; // reset $full indicator (because the last one wasn't last of all)
        $param = explode('=', $argument, 2); // explode by =
        if (count($param) < 2) { // only value of param available
            if (strtolower($param[0]) == 'true' || $param[0] == 1) { // param maybe indicating a full url request
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
    return url(trim($main_argument), $params, $full);
}
?>
