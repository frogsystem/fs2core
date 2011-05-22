<?php
// Start Session
session_start ();

// Disable magic_quotes_runtime
ini_set('magic_quotes_runtime', 0);

// fs2 include path
set_include_path('.');
define('FS2_ROOT_PATH', "./../", TRUE);

// inlcude files
require(FS2_ROOT_PATH . "login.inc.php");
require(FS2_ROOT_PATH . "includes/functions.php");
require(FS2_ROOT_PATH . "includes/newfunctions.php");
require(FS2_ROOT_PATH . "includes/adminfunctions.php");
require(FS2_ROOT_PATH . "includes/imagefunctions.php");
require(FS2_ROOT_PATH . "includes/templatefunctions.php");
require(FS2_ROOT_PATH . "includes/indexfunctions.php");

//Include Library-Classes
require(FS2_ROOT_PATH . "libs/class_template.php");
require(FS2_ROOT_PATH . "libs/class_fileaccess.php");
require(FS2_ROOT_PATH . "libs/class_lang.php");

//Include Phrases-Files
require(FS2_ROOT_PATH . "lang/de_DE/admin/admin_phrases_de.php");
$TEXT['admin'] = new lang($global_config_arr['language_text'], "admin");
$TEXT['frontend'] = new lang($global_config_arr['language_text'], "frontend");
$TEXT['template'] = new lang($global_config_arr['language_text'], "template");
$TEXT['menu']     = new lang($global_config_arr['language_text'], "menu");

######################
### START OF LOGIN ###
######################

if (isset($_POST['stayonline']) && $_POST['stayonline'] == 1) {
    admin_set_cookie ( $_POST['username'], $_POST['userpassword'] );
}

if (isset($_COOKIE['login']) && $_COOKIE['login'] && !is_authorized()) {
    $userpassword = substr ($_COOKIE['login'], 0, 32);
    $username = substr($_COOKIE['login'], 32, strlen ($_COOKIE['login']));
    admin_login($username, $userpassword, TRUE);
}

if (isset($_POST['login']) && $_POST['login'] == 1 && !is_authorized()) {
    admin_login($_POST['username'], $_POST['userpassword'], false);
}

####################
### END OF LOGIN ###
####################


##################################
### START OF DETECTING SUBPAGE ###
##################################

// security functions
$go = isset($_REQUEST['go']) ? savesql($_REQUEST['go']) : "";

// get page-data from database
$acp_arr = $sql->getRow(
    array('P' => "admin_cp", 'G' => "admin_groups"),
    array(
        'P' => array("page_id", "page_file", "group_id"),
        'G' => array("menu_id")
    ),
    array('W' => "P.`group_id` = G.`group_id` AND P.`page_id` = '".$go."' AND P.`page_int_sub_perm` != 1")
);

/* array (
 * 	array (
 * 		'COL' => "fieldname",
 * 		'FROM' => "P",
 * 		'AS' => "alias",
 * 		'FUNC' => "count",
 * 		'ARG' => "last_name,', ',first_name"
 * 	)
 * );
 * 
 * => SEL = COL
 * => SEL = FROM.SEL  // if FROM
 * => SEL = FUNC(ARG) // if FUNC && ARG
 * => SEL = FUNC(SEL) // if FUNC
 * => SEL = SEL AS "AS" // if AS
 */

// if page exisits
if (!empty($acp_arr)) {
    
    // if page is start page
    if ( $acp_arr['group_id'] == -1 ) {
        $acp_arr['menu_id'] = $acp_arr['page_file'];
        $acp_arr['page_file'] = $acp_arr['page_id'].".php";
    }
    // get the page-data
    $PAGE_DATA_ARR = createpage($TEXT['menu']->get("group_".$acp_arr['group_id'])." &#187; ".$TEXT['menu']->get("page_title_".$acp_arr['page_id']), has_perm($acp_arr['page_id']), $acp_arr['page_file'], $acp_arr['menu_id']);
    // initialise templatesystem
    // $adminpage = new adminpage($acp_arr['page_file']);
    // Get Special Page Lang-Text-Files
    $TEXT['page'] = new lang($global_config_arr['language_text'], "admin/".substr($acp_arr['page_file'], 0, -4));
} else {
    $PAGE_DATA_ARR['created'] = false;
}

// logout
if ( $PAGE_DATA_ARR['created'] === false && $go == "logout" ) {
    setcookie ("login", "", time() - 3600, "/");
    $_SESSION = array();
    $PAGE_DATA_ARR = createpage($TEXT['menu']->get("admin_logout_text"), true, 'admin_logout.php', "none");
}

// login
if ( $PAGE_DATA_ARR['created'] === false ) {
    $go = "login";
    $PAGE_DATA_ARR = createpage($TEXT['menu']->get("admin_login_text"), true, 'admin_login.php', "none");
}

// Define Constant
define('ACP_GO', $go);

################################
### END OF DETECTING SUBPAGE ###
################################


############################
### START OF HTML HEADER ###
############################

echo'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<!-- HTML Head -->
<head>
    <title>Frogsystem 2 - '.$PAGE_DATA_ARR['title'].'</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    
    <link rel="stylesheet" type="text/css" href="admin_old.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="editor.css">
    <link rel="stylesheet" type="text/css" href="html-editor.css">
    
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <link rel="stylesheet" type="text/css" href="css/noscript.css" id="noscriptcss">
    
    <script src="../resources/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="functions.js" type="text/javascript"></script>
    <script src="../includes/js_functions.js" type="text/javascript"></script>
    <script src="js/admin.js" type="text/javascript"></script>
</head>
<!-- /HTML Head -->

<body>

<!-- Page Head -->
<div id="head">
     <h1>'.$global_config_arr['title'].'</h1>
     <div id="head_version">
         version '.$global_config_arr['version'].'
     </div>
     <div id="head_link">
         <a href="'.$global_config_arr['virtualhost'].'" target="_self" class="head_link">» '.$TEXT['menu']->get("admin_link_to_page").'</a>
     </div>
</div>
<!-- /Page Head -->';

##########################
### END OF HTML HEADER ###
##########################

##############################
### START OF NAVI CREATION ###
##############################

// get navi from DB
$template_navi = get_leftmenu($PAGE_DATA_ARR['menu'], ACP_GO);

############################
### END OF NAVI CREATION ###
############################


##################################
### START OF MENU/NAVI DISPLAY ###
##################################
echo'

<!-- Top Menu -->
<div id="topmenu_left"></div>
<div id="topmenu_loop">
    '.get_topmenu($PAGE_DATA_ARR['menu']); //creates the menu-list
echo '
</div>

<div id="topmenu_login">';

if (is_authorized()) {
    $log_link = "logout";
    $log_image = "logout.gif";
    $log_text = $TEXT['menu']->get("admin_logout_text");
} else {
    $log_link = "login";
    $log_image = "login.gif";
    $log_text = $TEXT['menu']->get("admin_login_text");
}

echo'
    <table cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td id="topmenu_login_image">
                <a href="?go='.$log_link.'" target="_self" class="small">
                    <img src="icons/'.$log_image.'" alt="" title="'.$log_text.'" border="0">
                </a>
            </td>
            <td>
                <a href="?go='.$log_link.'" target="_self" class="small">
                    '.$log_text.'
                </a>
            </td>
        </tr>
    </table>
</div>
<!-- /Top Menu -->

<!-- Main Container -->
<div id="bg"><div id="bg_padding">

    <!-- Left Menu -->
    <div id="navi_container">';

if ($template_navi == "") {
    $template_navi = '
        <div class="navi_top" style="height:43px;">
            <img src="img/pointer.png" alt="" style="vertical-align:text-bottom">&nbsp;<b>Hallo Admin!</b>
            <div class="navi_link">
               Herzlich Willkommen
               im Admin-CP des Frogsystem 2!
            </div>
        </div>';
}

echo $template_navi;
echo '
    </div>
    <!-- /Left Menu -->
';
################################
### END OF MENU/NAVI DISPLAY ###
################################


################################
### START OF CONTENT DISPLAY ###
################################
// Include Content File
ob_start();
require ( FS2_ROOT_PATH . "admin/".$PAGE_DATA_ARR['file'] );
$content = ob_get_clean();
$top = '<h2 class="cb-text">('.$PAGE_DATA_ARR['title'].')</h2>';
echo '
    <!-- Content Container -->
    <div id="content_container">';
    
echo get_content_container($top, $content);

echo '
    </div>
    <!-- /Content Container -->

</div></div>
<!-- /Main Container -->

</body>
</html>
';

##############################
### END OF CONTENT DISPLAY ###
##############################

unset($sql);

?>
