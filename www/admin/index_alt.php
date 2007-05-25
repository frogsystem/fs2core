<?php
session_start(); 
include("config.inc.php");
include("functions.php");
include("adminfunctions.php");
include("phrases.inc.php");

///////////////////////////
///////// Cookie //////////
///////////////////////////

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

///////////////////////////
// Unterseite festlegen ///
///////////////////////////

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
    //Seiten erstellen
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
    //Logout
    if ($go == 'logout')
    {
        createpage('LOGOUT', 1, 'admin_logout.php');
        setcookie ("login", "", time() - 3600, "/");
        $_SESSION=array();
        $page_created = true;
    }

    //Pseudo-Else
    if ($page_created == false)
    {
        createpage('LOGIN', 1, 'admin_login.php');
    }

///////////////////////////
// HTML Header ausgeben ///
///////////////////////////

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Frog System - '.$pagetitle.'</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script type="text/javascript" src="functions.js"></script>

</head>
<body>

    <div id="menushadow">
        <div id="menu">
        	<div width="100%" height="100" valign="top" ondblclick="toggleDivs()">
            	<img border="0" src="img/frogsystem.gif" width="140" height="78">
			</div>

';

///////////////////////////
///// Allgemein Menü //////
///////////////////////////

if (
       ($_SESSION[perm_allconfig] == 1) ||
       ($_SESSION[perm_allannouncement] == 1) ||
       ($_SESSION[perm_allphpinfo] == 1)
   )
{
     echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'allgemein\')">Allgemein</a>
                    </div>
     ';
}

  echo '<div width="100%" id="allgemein" class="hiddencat">';
  createlink('allconfig');
  createlink('allannouncement');
  createlink('allphpinfo');
  createlink('emailtemplate');
  createlink('alltemplate');
  echo '</div>';

///////////////////////////
///// Includes Menü //////
///////////////////////////

if (
       ($_SESSION[perm_allconfig] == 1)
   )
{
     echo'
                    <div width="100%" class="menuhead">
                        <img border="0" name="closed" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'includes\')">Includes</a>
                    </div>
     ';
}

  echo '<div width="100%" id="includes" class="hiddencat">';
  createlink('includes_edit');
  createlink('includes_new');
  echo '</div>';

///////////////////////////
////// Design Menü ////////
///////////////////////////

if ($_SESSION[perm_templateedit] == 1)
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'designs\')">Designs</a>
                    </div>
    ';
}

  echo '<div width="100%" id="designs" class="hiddencat">';
  createlink('template_create');
  createlink('template_manage');
  createlink('csstemplate');
  echo '</div>';




///////////////////////////
//////// News Menü ////////
///////////////////////////

if (
       ($_SESSION[perm_newsadd] == 1) ||
       ($_SESSION[perm_newsedit] == 1) ||
       ($_SESSION[perm_newscat] == 1) ||
       ($_SESSION[perm_newsnewcat] == 1) ||
       ($_SESSION[perm_newsconfig] == 1)
   )
{
     echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'news\')">News</a>
                    </div>
     ';
}

  echo '<div width="100%" id="news" class="hiddencat">';
  createlink('newsadd');
  createlink('newsedit');
  createlink('news_cat_create');
  createlink('news_cat_manage');
  createlink('newsconfig');
  createlink('newstemplate');
  echo '</div>';
  
///////////////////////////
////// Artikel Menü ///////
///////////////////////////

if (
       ($_SESSION[perm_artikeladd] == 1) ||
       ($_SESSION[perm_artikeledit] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'artikel\')">Artikel</a>
                    </div>
    ';
}
  echo '<div width="100%" id="artikel" class="hiddencat">';
  createlink('artikeladd');
  createlink('artikeledit');
  createlink('cimgadd');
  createlink('cimgdel');
  createlink('artikeltemplate');
  echo '</div>';

///////////////////////////
////// Download Menü //////
///////////////////////////

if (
       ($_SESSION[perm_dladd] == 1) ||
       ($_SESSION[perm_dledit] == 1) ||
       ($_SESSION[perm_dlcat] == 1) ||
       ($_SESSION[perm_dlnewcat] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'download\')">Download</a>
                    </div>
    ';
}
  echo '<div width="100%" id="download" class="hiddencat">';
  createlink('dladd');
  createlink('dledit');
  createlink('dlcat');
  createlink('dlnewcat');
  createlink('dlconfig');
  createlink('dltemplate');
  echo '</div>';

///////////////////////////
////// Umfrage Menü ///////
///////////////////////////

if (
       ($_SESSION[perm_polladd] == 1) ||
       ($_SESSION[perm_polledit] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'umfrage\')">Umfrage</a>
                    </div>
    ';
}
  echo '<div width="100%" id="umfrage" class="hiddencat">';
  createlink('polladd');
  createlink('polledit');
  createlink('polltemplate');
  echo '</div>';

////////////////////////
///// Galerie Menü /////
////////////////////////

if (
       ($_SESSION[perm_screencat] == 1) ||
       ($_SESSION[perm_screennewcat] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'galerie\')">Galerie</a>
                    </div>
   ';
}
  echo '<div width="100%" id="galerie" class="hiddencat">';
  createlink('screennewcat');
  createlink('screencat');
  echo '</div>';
  
///////////////////////////
///// Screenshot Menü /////
///////////////////////////

if (
       ($_SESSION[perm_screenadd] == 1) ||
       ($_SESSION[perm_screenedit] == 1) ||
       ($_SESSION[perm_screenconfig] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'screenshots\')">Screenshots</a>
                    </div>
   ';
}
  echo '<div width="100%" id="screenshots" class="hiddencat">';
  createlink('screenadd');
  createlink('screenedit');
  createlink('screenconfig');
  createlink('screenshottemplate');
  echo '</div>';

//////////////////////////
///// Wallpaper Menü /////
//////////////////////////

if (
       ($_SESSION[perm_screenadd] == 1) ||
       ($_SESSION[perm_screenedit] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'wallpaper\')">Wallpaper</a>
                    </div>
   ';
}
  echo '<div width="100%" id="wallpaper" class="hiddencat">';
  createlink('wallpaperadd');
  createlink('wallpaperedit');
//  createlink('wallpapertemplate');
  echo '</div>';


///////////////////////////
///// Zufallsbild Menü ////
///////////////////////////

if (
       ($_SESSION[perm_potmadd] == 1) ||
       ($_SESSION[perm_potmedit] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'zufallsbild\')">Zufallsbild</a>
                    </div>
    ';
}
  echo '<div width="100%" id="zufallsbild" class="hiddencat">';
  createlink('randompic_cat');
  createlink('randompictemplate');
  echo '</div>';

///////////////////////////
//////// Shop Menü ////////
///////////////////////////

if (
       ($_SESSION[perm_shopadd] == 1) ||
       ($_SESSION[perm_shopedit] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'shop\')">Shop</a>
                    </div>
    ';
}
  echo '<div width="100%" id="shop" class="hiddencat">';
  createlink('shopadd');
  createlink('shopedit');
  createlink('shoptemplate');
  echo '</div>';
  
///////////////////////////
///// Partner Menü ////////
///////////////////////////

if (
       ($_SESSION[perm_partneradd] == 1) ||
       ($_SESSION[perm_partneredit] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'partnerseiten\')">Partnerseiten</a>
                    </div>
    ';
}
  echo '<div width="100%" id="partnerseiten" class="hiddencat">';
  createlink('partneradd');
  createlink('partneredit');
  createlink('partnerconfig');
  createlink('partnertemplate');
  echo '</div>';

///////////////////////////
/// Community Map Menü ////
///////////////////////////

if ($_SESSION[perm_map] == 1)
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'community\')">Community Map</a>
                    </div>
    ';
}
  echo '<div width="100%" id="community" class="hiddencat">';
  createlink('map', 'Deutschland', 'map&amp;landid=1');
  createlink('map', 'Schweiz', 'map&amp;landid=2');
  createlink('map', 'Österreich', 'map&amp;landid=3');
  echo '</div>';

///////////////////////////
///// Statistik Menü //////
///////////////////////////

if (
       ($_SESSION[perm_statedit] == 1) ||
       ($_SESSION[perm_statview] == 1) ||
       ($_SESSION[perm_statspace] == 1) ||
       ($_SESSION[perm_statref] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'statistik\')">Statistik</a>
                    </div>
    ';
}
  echo '<div width="100%" id="statistik" class="hiddencat">';
  createlink('statview');
  createlink('statedit');
  createlink('statref');
  createlink('statspace');
  echo '</div>';

///////////////////////////
//////// User Menü ////////
///////////////////////////

if (
       ($_SESSION[perm_useradd] == 1) ||
       ($_SESSION[perm_useredit] == 1) ||
       ($_SESSION[perm_userrights] == 1)
   )
{
    echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'benutzer\')">Benutzer</a>
                    </div>
    ';
}
  echo '<div width="100%" id="benutzer" class="hiddencat">';
  createlink('useradd');
  createlink('useredit');
  createlink('userrights');
  createlink('usertemplate');
  echo '</div>';

///////////////////////////
///// Standard Menüs //////
///////////////////////////

echo'
                    <div width="100%" class="menuhead">
                        <img border="0" src="img/pointer.gif" width="5" height="8" alt="">
                        <a class="menu" href="#" onclick="hideDiv(\'profil\')">Profil</a>
                    </div>
                ';
  echo '<div width="100%" id="profil" class="hiddencat">';
  createlink('profil');

echo'
                    <div width="100%" class="menu">
                        <a class="menu" href="'.$PHP_SELF.'?go=logout'.$session_url.'">
                            Logout
                        </a>
                    </div>
                ';
  echo '</div>';
                
/////////////////////
///// ENDE MENÜ /////
/////////////////////

echo'
                    <div width="100%">
                        &nbsp;
                    </div>

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


///////////////////////////
///// Inhalt Include //////
///////////////////////////

include($filetoinc);

///////////////////////////
///////// Footer //////////
///////////////////////////

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