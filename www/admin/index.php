<?php
// Start Session
session_start ();

// Disable magic_quotes_runtime
set_magic_quotes_runtime ( FALSE );

// fs2 include path
set_include_path ( '.' );
define ( 'FS2_ROOT_PATH', "./../", TRUE );

// inlcude files
require ( FS2_ROOT_PATH . "login.inc.php" );
require ( FS2_ROOT_PATH . "includes/functions.php" );
require ( FS2_ROOT_PATH . "includes/adminfunctions.php" );
require ( FS2_ROOT_PATH . "includes/imagefunctions.php" );
require ( FS2_ROOT_PATH . "includes/templatefunctions.php" );
require ( FS2_ROOT_PATH . "includes/indexfunctions.php" );

//Include Library-Classes
require ( FS2_ROOT_PATH . "libs/class_template.php");
require ( FS2_ROOT_PATH . "libs/class_fileaccess.php");
require ( FS2_ROOT_PATH . "libs/class_langDataInit.php");
require ( FS2_ROOT_PATH . "libs/class_adminpage.php");
require ( FS2_ROOT_PATH . "libs/class_search.php");
require ( FS2_ROOT_PATH . "libs/class_admin_selectlist.php");

//Include Phrases-Files
require ( FS2_ROOT_PATH . "phrases/phrases_".$global_config_arr['language'].".php" );
require ( FS2_ROOT_PATH . "phrases/admin_phrases_".$global_config_arr['language'].".php" );

$TEXT['admin']    = new langDataInit ( $global_config_arr['language_text'], "admin" );
$TEXT['menu']     = new langDataInit ( $global_config_arr['language_text'], "menu" );
$TEXT['frontend'] = new langDataInit ( $global_config_arr['language_text'], "frontend" );
$TEXT['template'] = new langDataInit ( $global_config_arr['language_text'], "template" );


######################
### START OF LOGIN ###
######################

if ( isset ( $_POST['stayonline'] ) && $_POST['stayonline'] == 1 ) {
    admin_set_cookie ( $_POST['username'], $_POST['userpassword'] );
}

if ( isset ( $_COOKIE['login'] ) && $_COOKIE['login'] && $_SESSION["user_level"] != "authorised" )
{
    $userpassword = substr ( $_COOKIE['login'], 0, 32 );
    $username = substr ( $_COOKIE['login'], 32, strlen ( $_COOKIE['login'] ) );
    admin_login ( $username, $userpassword, TRUE );
}

if ( isset ( $_POST['login'] ) && $_POST['login'] == 1 && $_SESSION["user_level"] != "authorised" )
{
    admin_login ( $_POST['username'], $_POST['userpassword'], FALSE );
}

####################
### END OF LOGIN ###
####################


##################################
### START OF DETECTING SUBPAGE ###
##################################

// security functions
$go = isset ( $_REQUEST['go'] ) ? savesql ( $_REQUEST['go'] ) : "";

// get page-data from database
$index = mysql_query ( "
                        SELECT P.`page_id`, P.`page_file`, P.`group_id`, G.`menu_id`
                        FROM `".$global_config_arr['pref']."admin_cp` P, `".$global_config_arr['pref']."admin_groups` G
                        WHERE P.`group_id` = G.`group_id`
                        AND P.`page_id` = '".$go."'
                        AND P.`page_int_sub_perm` != 1
                        LIMIT 0,1
", $db );

// if page exisits
if ( mysql_num_rows ( $index ) == 1 ) {
    $acp_arr = mysql_fetch_assoc ( $index );
    $acp_arr['permission'] = $_SESSION[$acp_arr['page_id']];

    // if page is start page
    if ( $acp_arr['group_id'] == -1 ) {
        $acp_arr['menu_id'] = $acp_arr['page_file'];
        $acp_arr['page_file'] = $acp_arr['page_id'].".php";
    }
    // get the page-data
    $PAGE_DATA_ARR = createpage ( $TEXT['menu']->get("group_".$acp_arr['group_id'])." &#187; ".$TEXT['menu']->get("page_title_".$acp_arr['page_id']), $acp_arr['permission'], $acp_arr['page_file'], $acp_arr['menu_id'] );
    // initialise templatesystem
    $adminpage = new adminpage($acp_arr['page_file']);
} else {
    $PAGE_DATA_ARR['created'] = FALSE;
}

// logout
if ( $PAGE_DATA_ARR['created'] == FALSE && $go == 'logout' ) {
    setcookie ( "login", "", time() - 3600, "/" );
    $_SESSION = array();
    $PAGE_DATA_ARR = createpage( $TEXT['menu']->get("admin_logout_text"), 1, 'admin_logout.php', "none" );
}

// login
if ( $PAGE_DATA_ARR['created'] == FALSE ) {
    $go = "login";
    $PAGE_DATA_ARR = createpage( $TEXT['menu']->get("admin_login_text"), 1, 'admin_login.php', "none" );
}

// Define Constant
define ( ACP_GO, $go );

################################
### END OF DETECTING SUBPAGE ###
################################



//////////////////////////////
///// display html header
//////////////////////////////

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Frogsystem 2 - '.$PAGE_DATA_ARR['title'].'</title>
    <META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" type="text/css" href="editor.css">
    <link rel="stylesheet" type="text/css" href="html-editor.css">
    <script src="../resources/jquery/jquery.tools.min.js" type="text/javascript"></script>
    <script src="functions.js" type="text/javascript"></script>
    <script src="../includes/js_functions.js" type="text/javascript"></script>
</head>
<body>


<div id="head">
     '.$global_config_arr['title'].'
     <div id="head_version">
         version '.$global_config_arr['version'].'
     </div>
     <div id="head_link">
         <a href="'.$global_config_arr['virtualhost'].'" target="_self" class="head_link">» '.$TEXT['menu']->get("admin_link_to_page").'</a>
     </div>
</div>';



##############################
### START OF NAVI CREATION ###
##############################

// get navi from DB
$template_navi = create_navi ( $PAGE_DATA_ARR['menu'], ACP_GO );

############################
### END OF NAVI CREATION ###
############################


##################################
### START OF MENU/NAVI DISPLAY ###
##################################
echo'<div id="menu_top_left"></div>
<div id="menu_top_loop">';

echo create_menu ( $PAGE_DATA_ARR['menu'] ); //creates the menu-list

echo '
</div>
<div id="menu_top_log">';

if ( $_SESSION["user_level"] == "authorised" )
{
    $log_link = "logout";
    $log_image = "logout.gif";
    $log_text = $TEXT['menu']->get("admin_logout_text");
}
else
{
    $log_link = "login";
    $log_image = "login.gif";
    $log_text = $TEXT['menu']->get("admin_login_text");
}

echo'
    <table cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td id="menu_top_log_image_td">
                   <a href="?go='.$log_link.'" target="_self" class="small">
                    <img src="img/'.$log_image.'" alt="" title="'.$log_text.'" border="0">
                </a>
            </td>
            <td>
                   <a href="?go='.$log_link.'" target="_self" class="small">
                     '.$log_text.'
                </a>
            </td>
        </tr>
    </table>
';

unset ( $log_link );
unset ( $log_image );
unset ( $log_text );

echo '</div>
<div id="bg"><div id="bg_padding">

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
echo '</div>';
################################
### END OF MENU/NAVI DISPLAY ###
################################


echo'
     <div id="content_container">
         <div id="content_top">
           <img border="0" src="img/pointer.png" alt="" style="vertical-align:text-top">
           <b>'.$PAGE_DATA_ARR['title'].'</b>
         </div>
         <div id="content_padding">
             <div align="center">
';


//////////////////////////////
///// content includes
//////////////////////////////

require ( FS2_ROOT_PATH . "admin/".$PAGE_DATA_ARR['file'] );

//////////////////////////////
////// footer
//////////////////////////////

echo'
             </div>
         </div>
         <div id="content_foot"></div>
     </div>

</div></div>

</body>
</html>
';

mysql_close ( $db );

?>