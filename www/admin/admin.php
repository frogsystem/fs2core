<?php

// inlcude files
require_once(FS2SOURCE . '/includes/adminfunctions.php');
require_once(FS2SOURCE . '/includes/templatefunctions.php');

//Include Library-Classes
require_once(FS2SOURCE . '/libs/class_adminpage.php');


global $FD;

// Constructor Calls
setTimezone($FD->cfg('timezone'));
run_cronjobs();


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
!isset($_REQUEST['go']) ? $_REQUEST['go'] = null : 1;
$go = $_REQUEST['go'];

// get page-data from database
$acp_arr = $FD->db()->conn()->prepare(
               'SELECT page_id, page_file, P.group_id AS group_id, menu_id
                FROM '.$FD->env('pref').'admin_cp P, '.$FD->env('pref').'admin_groups G
                WHERE P.`group_id` = G.`group_id` AND P.`page_id` = ? AND P.`page_int_sub_perm` != 1');
$acp_arr->execute(array($go));
$acp_arr = $acp_arr->fetch(PDO::FETCH_ASSOC);

// if page exisits
if (!empty($acp_arr)) {

    // if page is start page
    if ($acp_arr['group_id'] == -1) {
        $acp_arr['menu_id'] = $acp_arr['page_file'];
        $acp_arr['page_file'] = $acp_arr['page_id'].'.php';
    }

    //if popup
    if ($acp_arr['group_id'] == 'popup') {
        define('POPUP', true);
        $title = $FD->text("menu", 'page_title_'.$acp_arr['page_id']);
    } else {
        define('POPUP', false);
        $title = $FD->text("menu", 'group_'.$acp_arr['group_id']).' &#187; '.$FD->text("menu", 'page_title_'.$acp_arr['page_id']);
    }

    // get the page-data
    $PAGE_DATA_ARR = createpage($title, has_perm($acp_arr['page_id']), $acp_arr['page_file'], $acp_arr['menu_id']);

    // initialise templatesystem
    $adminpage = new adminpage($acp_arr['page_file']);

    // Get Special Page Lang-Text-Files
    $page_lang = new lang($FD->config('language_text'), 'admin/'.substr($acp_arr['page_file'], 0, -4));
    $FD->setPageText($page_lang);
    unset ($page_lang);

} else {
    $PAGE_DATA_ARR['created'] = false;
    define('POPUP', false);
}

// logout
if ( $PAGE_DATA_ARR['created'] === false && $go == 'logout' ) {
    setcookie ('login', '', time() - 3600, '/');
    $_SESSION = array();
    $PAGE_DATA_ARR = createpage($FD->text("menu", "admin_logout_text"), true, 'admin_logout.php', 'dash');
}

// login
elseif ( $PAGE_DATA_ARR['created'] === false && ($go == 'login' || empty($go)) ) {
    $go = 'login';
    $PAGE_DATA_ARR = createpage($FD->text("menu", "admin_login_text"), true, 'admin_login.php', 'dash');
}

// error
elseif ( $PAGE_DATA_ARR['created'] === false ) {
    $go = '404';
    $PAGE_DATA_ARR = createpage($FD->text("menu", "admin_error_page_title"), true, 'admin_404.php', 'error');
}



// Define Constant
define('ACP_GO', $go);

################################
### END OF DETECTING SUBPAGE ###
################################


##########################
### START OF HTML HEAD ###
##########################
ob_start();
echo'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<!-- HTML Head -->
<head>
    <title>Frogsystem 2 - '.$PAGE_DATA_ARR['title'].'</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

    <link rel="stylesheet" type="text/css" href="css/admin_old.css">
    <link rel="stylesheet" type="text/css" href="css/editor.css">

    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/noscript.css" id="noscriptcss">

    <link rel="shortcut icon" href="icons/favicon.ico">

    <script src="../resources/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="../resources/jquery/jquery-ui.min.js" type="text/javascript"></script>
    <script src="functions.js" type="text/javascript"></script>
    <script src="../includes/js_functions.js" type="text/javascript"></script>
    <script src="js/admin.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="../resources/colorpicker/css/colorpicker.css">
    <script type="text/javascript" src="../resources/colorpicker/js/colorpicker.js"></script>
    <script type="text/javascript" src="js/colorpicker.js"></script>
</head>
<!-- /HTML Head -->
';
$head = ob_get_clean();
########################
### END OF HTML HEAD ###
########################

if (POPUP !== true) {
##########################
### START OF PAGE HEAD ###
##########################
echo $head;
echo'
<body>

<!-- Page Head -->
<div id="head">
     <h1>'.$FD->config('title').'</h1>
     <div id="head_version">
         version '.$FD->config('version').'
     </div>
     <div id="head_link">
         <a href="'.$FD->config('virtualhost').'" target="_self" class="head_link">&raquo; '.$FD->text('menu', 'admin_link_to_page').'</a>
     </div>
</div>
<!-- /Page Head -->';
########################
### END OF PAGE HEAD ###
########################


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
    '.get_topmenu($PAGE_DATA_ARR['menu']); //creates the menu list
echo '
</div>

<div id="topmenu_login">';

if (is_authorized()) {
    $log_link = 'logout';
    $log_image = 'logout.gif';
    $log_text = $FD->text("menu", "admin_logout_text");
} else {
    $log_link = 'login';
    $log_image = 'login.gif';
    $log_text = $FD->text("menu", "admin_login_text");
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

if ($template_navi == '') {
    $template_navi = '
        <div class="leftmenu top" style="height:43px;">
            <img src="icons/arrow.gif" alt="->">&nbsp;<b>Hallo Admin!</b>
            <div><br>
               Herzlich<br>Willkommen
               im<br>Admin-CP des<br>Frogsystem 2!
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


echo '
    <!-- Content Container -->
    <div id="content_container">';

ob_start();
require(FS2_ROOT_PATH . 'admin/'.$PAGE_DATA_ARR['file']);
$content = ob_get_clean();

$top = '<h2 class="cb-text">('.$PAGE_DATA_ARR['title'].')</h2>';
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

} else {
######################################
### START OF DISPLAY POPUP CONTENT ###
######################################
$JUST_CONTENT = false;

ob_start();
require(FS2_ROOT_PATH . 'admin/'.$PAGE_DATA_ARR['file']);
$popup = ob_get_clean();

if ($JUST_CONTENT !== true) {

echo $head;
echo'
<body id="find_body">
    <div id="find_head">
        &nbsp;<img border="0" src="img/pointer.png" alt="->" class="middle">&nbsp;
        <strong>'.$PAGE_DATA_ARR['title'].'</strong>
    </div>
    <div align="left">
';

echo $popup;

echo'
    </div>
</body>
</html>
';
} else {
    echo $popup;
}

####################################
### END OF DISPLAY POPUP CONTENT ###
####################################
}

?>
