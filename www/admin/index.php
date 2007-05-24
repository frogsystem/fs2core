<?php
session_start(); 
include("config.inc.php");
include("functions.php");
include("adminfunctions.php");
include("phrases.inc.php");
include("phrases.inc.php");

//////////////////////////////
///// Cookie
//////////////////////////////

if ($_POST[stayonline]==1)
{
    admin_set_cookie($_POST[username], $_POST[userpassword]);
}

if ($HTTP_COOKIE_VARS["login"])
{
    $userpassword = substr($HTTP_COOKIE_VARS["login"], 0, 32);
    $username = substr($HTTP_COOKIE_VARS["login"], 32, strlen($HTTP_COOKIE_VARS["login"]));
    admin_login($username, $userpassword, true);
}
else
{
    $session_url = "&amp;sid=" . session_id();
}

if ($_POST[login]==1)
{
    admin_login($_POST[username], $_POST[userpassword], false);
}

//////////////////////////////
///// detect subpage
//////////////////////////////

if ($_GET[go])
{
    $go = $_GET[go];
}
if ($_POST[go])
{
    $go = $_POST[go];
}

$index = mysql_query("SELECT * FROM fs_admin_cp", $db);

$page_created = false;
while ($acp_arr = mysql_fetch_assoc($index))
{
    //create page
    if ($go == $acp_arr['page_call'])
    {
        if ($acp_arr[permission]!=1)
        {
            $acp_arr[permission] = $_SESSION[$acp_arr[permission]];
        }

        createpage($acp_arr['page_title'], $acp_arr[permission], $acp_arr['file']);
        $page_created = true;
        break;
    }
}
    //logout
    if ($go == 'logout')
    {
        createpage('LOGOUT', 1, 'admin_logout.php');
        setcookie ("login", "", time() - 3600, "/");
        $_SESSION=array();
        $page_created = true;
    }

    //pseudo-else
    if ($go == 'login' OR $page_created == false)
    {
        createpage('LOGIN', 1, 'admin_login.php');
    }

//////////////////////////////
///// display html header
//////////////////////////////

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frog System - '.$pagetitle.'</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script src="functions.js" type="text/javascript"></script>
    <script src="../inc/functions.js" type="text/javascript"></script>
</head>
<body>
<noscript>
<style type="text/css">
<!--
 .toggle {
 display: block;
}
-->
</style>
</noscript>
    <div id="menushadow">
        <div id="menu">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="100%" height="78" valign="top">
                        <img border="0" src="img/frogsystem.gif" width="140" height="78">
                    </td>
                </tr>

';

//////////////////////////////
///// explanation of menu creation
//////////////////////////////
/*
$ADMIN_ARR[title] = "title"; //title of menu
$ADMIN_ARR[id] = "id"; //id of menu; has to be unique; important for menu toggle

$ADMIN_ARR[perm][0] = "perm_name1"; //first required permisson to show the menu head
$ADMIN_ARR[perm][1] = "perm_name2"; //second required permisson to show the menu head
$ADMIN_ARR[perm][2] = "perm_name3"; //third required permisson to show the menu head
$ADMIN_ARR[perm][...] = "perm_name..."; //... and so on
//note "$ADMIN_ARR[perm][0] = "true";" (and no other permissions) to show menu always

createmenu($ADMIN_ARR); //creates the head of the menu, with title and toggle link

  createlink('link_name1'); //first link in the menu
  createlink('link_name2'); //second link in the menu
  createlink('link_name3'); //second link in the menu
  createlink('link_name...'); //... and so on

createmenu_end($ADMIN_ARR); //creates the end of the menu, closes tags
unset($ADMIN_ARR); //deletes the variable
*/

//////////////////////////////
///// general
//////////////////////////////

$ADMIN_ARR[title] = "Allgemein";
$ADMIN_ARR[id] = "general";

$ADMIN_ARR[perm][0] = "perm_allconfig";
$ADMIN_ARR[perm][1] = "perm_allannouncement";
$ADMIN_ARR[perm][2] = "perm_allphpinfo";

createmenu($ADMIN_ARR);

  createlink('allconfig');
  createlink('allannouncement');
  createlink('allphpinfo');
  createlink('emailtemplate');
  createlink('alltemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// includes
//////////////////////////////

$ADMIN_ARR[title] = "Includes";
$ADMIN_ARR[id] = "includes";

$ADMIN_ARR[perm][0] = "perm_allconfig";

createmenu($ADMIN_ARR);

  createlink('includes_edit');
  createlink('includes_new');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// designs
//////////////////////////////

$ADMIN_ARR[title] = "Designs";
$ADMIN_ARR[id] = "designs";

$ADMIN_ARR[perm][0] = "perm_templateedit";

createmenu($ADMIN_ARR);

  createlink('template_create');
  createlink('template_manage');
  createlink('csstemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// zones
//////////////////////////////

$ADMIN_ARR[title] = "Zonen";
$ADMIN_ARR[id] = "zones";

$ADMIN_ARR[perm][0] = "perm_templateedit";
$ADMIN_ARR[perm][1] = "perm_allannouncement";
$ADMIN_ARR[perm][2] = "perm_allphpinfo";

createmenu($ADMIN_ARR);

  createlink('zone_create');
  createlink('zone_manage');
  createlink('zone_config');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// news
//////////////////////////////

$ADMIN_ARR[title] = "News";
$ADMIN_ARR[id] = "news";

$ADMIN_ARR[perm][0] = "perm_newsadd";
$ADMIN_ARR[perm][1] = "perm_newsedit";
$ADMIN_ARR[perm][2] = "perm_newscat";
$ADMIN_ARR[perm][3] = "perm_newsnewcat";
$ADMIN_ARR[perm][4] = "perm_newsconfig";

createmenu($ADMIN_ARR);

  createlink('newsadd');
  createlink('newsedit');
  createlink('news_cat_create');
  createlink('news_cat_manage');
  createlink('newsconfig');
  createlink('newstemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);
  
//////////////////////////////
///// articles
//////////////////////////////

$ADMIN_ARR[title] = "Artikel";
$ADMIN_ARR[id] = "articles";

$ADMIN_ARR[perm][0] = "perm_artikeladd";
$ADMIN_ARR[perm][1] = "perm_artikeledit";

createmenu($ADMIN_ARR);

  createlink('artikeladd');
  createlink('artikeledit');
  createlink('cimgadd');
  createlink('cimgdel');
  createlink('artikeltemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);
  
//////////////////////////////
///// press releases
//////////////////////////////

$ADMIN_ARR[title] = "Presseberichte";
$ADMIN_ARR[id] = "press";

$ADMIN_ARR[perm][0] = true;

createmenu($ADMIN_ARR);

  createlink('press_add');
  createlink('press_edit');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// downloads
//////////////////////////////

$ADMIN_ARR[title] = "Download";
$ADMIN_ARR[id] = "downloads";

$ADMIN_ARR[perm][0] = "perm_dladd";
$ADMIN_ARR[perm][1] = "perm_dledit";
$ADMIN_ARR[perm][2] = "perm_dlcat";
$ADMIN_ARR[perm][3] = "perm_dlnewcat";

createmenu($ADMIN_ARR);

  createlink('dladd');
  createlink('dledit');
  createlink('dlcat');
  createlink('dlnewcat');
  createlink('dlconfig');
  createlink('dltemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// polls
//////////////////////////////

$ADMIN_ARR[title] = "Umfrage";
$ADMIN_ARR[id] = "polls";

$ADMIN_ARR[perm][0] = "perm_polladd";
$ADMIN_ARR[perm][1] = "perm_polledit";

createmenu($ADMIN_ARR);

  createlink('polladd');
  createlink('polledit');
  createlink('polltemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// gallery
//////////////////////////////

$ADMIN_ARR[title] = "Galerie";
$ADMIN_ARR[id] = "gallery";

$ADMIN_ARR[perm][0] = "perm_screencat";
$ADMIN_ARR[perm][1] = "perm_screennewcat";

createmenu($ADMIN_ARR);

  createlink('screennewcat');
  createlink('screencat');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);
  
//////////////////////////////
///// screenshots
//////////////////////////////

$ADMIN_ARR[title] = "Screenshots";
$ADMIN_ARR[id] = "screenshots";

$ADMIN_ARR[perm][0] = "perm_screenadd";
$ADMIN_ARR[perm][1] = "perm_screenedit";
$ADMIN_ARR[perm][2] = "perm_screenconfig";

createmenu($ADMIN_ARR);

  createlink('screenadd');
  createlink('screenedit');
  createlink('screenconfig');
  createlink('screenshottemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// wallpaper
//////////////////////////////

$ADMIN_ARR[title] = "Wallpaper";
$ADMIN_ARR[id] = "wallpaper";

$ADMIN_ARR[perm][0] = "perm_screenadd";
$ADMIN_ARR[perm][1] = "perm_screenedit";

createmenu($ADMIN_ARR);

  createlink('wallpaperadd');
  createlink('wallpaperedit');
//  createlink('wallpapertemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);


//////////////////////////////
///// random pic
//////////////////////////////

$ADMIN_ARR[title] = "Zufallsbild";
$ADMIN_ARR[id] = "randompic";

$ADMIN_ARR[perm][0] = "perm_potmadd";
$ADMIN_ARR[perm][1] = "perm_potmedit";

createmenu($ADMIN_ARR);

  createlink('randompic_cat');
  createlink('randompictemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// shop
//////////////////////////////

$ADMIN_ARR[title] = "Shop";
$ADMIN_ARR[id] = "shop";

$ADMIN_ARR[perm][0] = "perm_shopadd";
$ADMIN_ARR[perm][1] = "perm_shopadd";

createmenu($ADMIN_ARR);

  createlink('shopadd');
  createlink('shopedit');
  createlink('shoptemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);
  
//////////////////////////////
///// affiliates
//////////////////////////////

$ADMIN_ARR[title] = "Partnerseiten";
$ADMIN_ARR[id] = "affiliates";

$ADMIN_ARR[perm][0] = "perm_partneradd";
$ADMIN_ARR[perm][1] = "perm_partneredit";

createmenu($ADMIN_ARR);

  createlink('partneradd');
  createlink('partneredit');
  createlink('partnerconfig');
  createlink('partnertemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// community map (german only!)
//////////////////////////////

$ADMIN_ARR[title] = "Community Map";
$ADMIN_ARR[id] = "cmap";

$ADMIN_ARR[perm][0] = "perm_map";

createmenu($ADMIN_ARR);

  createlink('map', 'Deutschland', 'map&amp;landid=1');
  createlink('map', 'Schweiz', 'map&amp;landid=2');
  createlink('map', 'Österreich', 'map&amp;landid=3');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// statistics
//////////////////////////////

$ADMIN_ARR[title] = "Statistik";
$ADMIN_ARR[id] = "stats";

$ADMIN_ARR[perm][0] = "perm_statedit";
$ADMIN_ARR[perm][1] = "perm_statview";
$ADMIN_ARR[perm][2] = "perm_statspace";
$ADMIN_ARR[perm][3] = "perm_statref";

createmenu($ADMIN_ARR);

  createlink('statview');
  createlink('statedit');
  createlink('statref');
  createlink('statspace');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// user
//////////////////////////////

$ADMIN_ARR[title] = "Benutzer";
$ADMIN_ARR[id] = "user";

$ADMIN_ARR[perm][0] = "perm_useradd";
$ADMIN_ARR[perm][1] = "perm_useredit";
$ADMIN_ARR[perm][2] = "perm_userrights";

createmenu($ADMIN_ARR);

  createlink('useradd');
  createlink('useredit');
  createlink('userrights');
  createlink('usertemplate');

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

//////////////////////////////
///// profile/logout
//////////////////////////////

$ADMIN_ARR[title] = "Profil";
$ADMIN_ARR[id] = "profile";

$ADMIN_ARR[perm][0] = true;

createmenu($ADMIN_ARR);

  createlink('profil');
  if ($_SESSION["user_level"] == "authorised") {
  createlink('logout', 'Logout', 'logout'.$session_url, '1');
  } else {
  createlink('login', 'Login', 'login', '1');
  }

createmenu_end($ADMIN_ARR);
unset($ADMIN_ARR);

echo'
    <script type="text/javascript">
        iniMenu();
    </script>
';
###################
### END OF MENU ###
###################

echo'
                <tr>
                    <td width="100%">
                        &nbsp;
                    </td>
                </tr>
            </table>

        </div>
    </div>

    <div id="main">
        <div id="mainshadow">
            <div id="maincontent">
                <img border="0" src="img/pointer.gif" width="5" height="8" alt=""> 
                <font style="font-size:8pt;"><b>'.$pagetitle.'</b></font>
                <div align="center">
                    <p>
';


//////////////////////////////
///// content includes
//////////////////////////////

include($filetoinc);

//////////////////////////////
////// footer
//////////////////////////////

echo'
                </div>
           </div>
       </div>
       <p>
   </div>
</body>
</html>
';

mysql_close($db);

?>