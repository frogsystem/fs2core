<?php
///////////////////////////////////
//// PATH_SEPARATOR definieren ////
///////////////////////////////////
if ( ! defined( "PATH_SEPARATOR" ) ) {
  if ( strpos( $_ENV[ "OS" ], "Win" ) !== false )
    define( "PATH_SEPARATOR", ";" );
  else define( "PATH_SEPARATOR", ":" );
}


////////////////////////////
//// Konstruktoraufrufe ////
////////////////////////////
session_start();
set_magic_quotes_runtime ( FALSE );
set_include_path( substr(__FILE__, 0, -10) );
$FILEPATH = dirname(__FILE__) . "/";

//////////////////////
//// set language ////
//////////////////////
$lang = $_REQUEST['lang'];
switch ($lang) {
/*  case "en":
    include("lang/en.php");
    break;
  case "de":
    include("lang/de.php");
    break;*/
  default:
    include("lang/de.php");
    $lang = "de";
    break;
}


//////////////////
//// Includes ////
//////////////////
include("inc/functions.php");


////////////////////////
//// detect subpage ////
////////////////////////

$go = $_REQUEST['go'];
if ($go == "") {$go = "start";}
$go_lang = $go;
unset($pagetitle);
unset($contenttitle);
unset($filetoinc);

if (file_exists("steps/".$go.".php")) {
  createpage("steps/".$go.".php", $_LANG[steps][$go][progress], $_LANG[steps][$go][title]);
} else {
  createpage("inc/404.php", $_LANG[error][title], $_LANG[error][title]);
  $go = "404";
  $go_lang = "start";
}

$step = $_REQUEST['step'];

include($filetoinc);
$template_include = $template;
unset($template);
unset($filetoinc);

/////////////////////////////
//// display html header ////
/////////////////////////////

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>'.$_LANG[main][title].' - '.$pagetitle.'</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>

<div id="head">
     '.$_LANG[main][title].'
     <div id="head_version">
         version '.file_get_contents("inc/version.txt").'
     </div>
</div>';



##############################
### START OF NAVI CREATION ###
##############################
unset($template_navi);


$NAVI_ARR[title] = $_LANG[steps][start][navi];
$NAVI_ARR[menu_id] = "start";
$NAVI_ARR[start] = 1;

$NAVI_ARR[link][] = link2navi($_LANG[steps][start][step][1][title], 1, true);
$NAVI_ARR[link][] = link2navi($_LANG[steps][start][step][2][title], 2, true);
$NAVI_ARR[link][] = link2navi($_LANG[steps][start][step][3][title], 3, true);
$NAVI_ARR[link][] = link2navi($_LANG[steps][start][step][4][title], 4, true);

$template_navi .= createnavi($NAVI_ARR, createnavi_first($template_navi));
unset($NAVI_ARR);


$NAVI_ARR[title] = $_LANG[steps][ftp][navi];
$NAVI_ARR[menu_id] = "ftp";
$NAVI_ARR[start] = 1;

$NAVI_ARR[link][] = link2navi($_LANG[steps][ftp][step][1][title], 1, false);
$NAVI_ARR[link][] = link2navi($_LANG[steps][ftp][step][2][title], 2, false);
$NAVI_ARR[link][] = link2navi($_LANG[steps][ftp][step][3][title], 3, false);

$template_navi .= createnavi($NAVI_ARR, createnavi_first($template_navi));
unset($NAVI_ARR);


$NAVI_ARR[title] = $_LANG[steps][database][navi];
$NAVI_ARR[menu_id] = "database";
$NAVI_ARR[start] = 1;

$NAVI_ARR[link][] = link2navi($_LANG[steps][database][step][1][title], 1, false);
$NAVI_ARR[link][] = link2navi($_LANG[steps][database][step][2][title], 2, false);
$NAVI_ARR[link][] = link2navi($_LANG[steps][database][step][3][title], 3, false);

$template_navi .= createnavi($NAVI_ARR, createnavi_first($template_navi));
unset($NAVI_ARR);


$NAVI_ARR[title] = $_LANG[steps][files][navi];
$NAVI_ARR[menu_id] = "files";
$NAVI_ARR[start] = 1;

$NAVI_ARR[link][] = link2navi($_LANG[steps][files][step][1][title], 1, false);
$NAVI_ARR[link][] = link2navi($_LANG[steps][files][step][2][title], 2, false);
#$NAVI_ARR[link][] = link2navi($_LANG[steps][files][step][3][title], 3, false);

$template_navi .= createnavi($NAVI_ARR, createnavi_first($template_navi));
unset($NAVI_ARR);


$NAVI_ARR[title] = $_LANG[steps][settings][navi];
$NAVI_ARR[menu_id] = "settings";
$NAVI_ARR[start] = 1;

$NAVI_ARR[link][] = link2navi($_LANG[steps][settings][step][1][title], 1, false);
$NAVI_ARR[link][] = link2navi($_LANG[steps][settings][step][2][title], 2, false);

$template_navi .= createnavi($NAVI_ARR, createnavi_first($template_navi));
unset($NAVI_ARR);


$NAVI_ARR[title] = $_LANG[steps][end][navi];
$NAVI_ARR[menu_id] = "end";
$NAVI_ARR[start] = 1;

$NAVI_ARR[link][] = link2navi($_LANG[steps][end][step][1][title], 1, true);
//$NAVI_ARR[link][] = link2navi($_LANG[steps][end][step][2][title], 2, true);

$template_navi .= createnavi($NAVI_ARR, createnavi_first($template_navi));
unset($NAVI_ARR);
############################
### END OF NAVI CREATION ###
############################


##############################
### START OF MENU CREATION ###
##############################
unset($MENU_ARR);


$tmp_arr[title] = $_LANG[steps][start][progress]; //title of menu
$tmp_arr[id] = "start"; //id of menu, has to be unique
$tmp_arr[show] = true; //show menu?
$MENU_ARR[] = $tmp_arr;
unset($tmp_arr);

$tmp_arr[title] = $_LANG[steps][ftp][progress]; //title of menu
$tmp_arr[id] = "ftp"; //id of menu, has to be unique
$tmp_arr[show] = true; //show menu?
$MENU_ARR[] = $tmp_arr;
unset($tmp_arr);

$tmp_arr[title] = $_LANG[steps][database][progress]; //title of menu
$tmp_arr[id] = "database"; //id of menu, has to be unique
$tmp_arr[show] = true; //show menu?
$MENU_ARR[] = $tmp_arr;
unset($tmp_arr);

$tmp_arr[title] = $_LANG[steps][settings][progress]; //title of menu
$tmp_arr[id] = "settings"; //id of menu, has to be unique
$tmp_arr[show] = true; //show menu?
$MENU_ARR[] = $tmp_arr;
unset($tmp_arr);

$tmp_arr[title] = $_LANG[steps][files][progress]; //title of menu
$tmp_arr[id] = "files"; //id of menu, has to be unique
$tmp_arr[show] = true; //show menu?
$MENU_ARR[] = $tmp_arr;
unset($tmp_arr);

$tmp_arr[title] = $_LANG[steps][end][progress]; //title of menu
$tmp_arr[id] = "end"; //id of menu, has to be unique
$tmp_arr[show] = true; //show menu?
$MENU_ARR[] = $tmp_arr;
unset($tmp_arr);

############################
### END OF MENU CREATION ###
############################


##################################
### START OF MENU/NAVI DISPLAY ###
##################################
echo'<div id="menu_top_left"></div>
<div id="menu_top_loop">';

echo insert_tt($_LANG[help][steps][title],$_LANG[help][steps][text]).'&nbsp;&nbsp;';
createmenu($MENU_ARR); //creates the menu-list

unset($MENU_ARR); //deletes the variable

echo '</div>
<div id="menu_top_right">';

if ($go == "start" && FALSE) {
    echo '
        <a href="'.$PHP_SELF.'?go='.$go_lang.'&step='.$step.'&lang=de" target="_self" class="menu_link">
        <img src="img/flag_de.gif" alt="deutsch" border="0" align="top"></a>
        <a href="'.$PHP_SELF.'?go='.$go_lang.'&step='.$step.'&lang=en" target="_self" class="menu_link">
        <img src="img/flag_en.gif" alt="english" border="0" align="top"></a>';
    echo insert_tt($_LANG[help][lang][title],$_LANG[help][lang][text],-50, 160);
}

//Fehler - Navigation
if ($template_navi == "") {
    $template_navi = '
        <div id="navi_top" style="height:43px;">
            <img src="img/pointer.png" alt="" style="vertical-align:text-bottom">
            <b>'.$_LANG[error][navi_title].'</b>
            <div id="navi_link">
               '.$_LANG[error][navi_text].'
               <br><br>'.$_LANG[main][arrow].'
               <a href="index.php" class="navi">'.$_LANG[error][navi_startlink].'</a>
            </div>

    </div>';
}

echo '&nbsp;</div>

<div id="bg"><div id="bg_padding">

    <div id="navi_container">
        '.$template_navi.'
    </div>
';
################################
### END OF MENU/NAVI DISPLAY ###
################################


################################
### START OF CONTENT DISPLAY ###
################################
echo '
     <div id="content_container">
         <div id="content_top">
           <img border="0" src="img/pointer.png" alt="" style="vertical-align:text-top">
           <b>'.$contenttitle.'</b>
         </div>
         <div id="content_padding">
             <div align="center"><div align="left">
                 '.$template_include.'
             </div></div>
         </div>
         <div id="content_foot"></div>
     </div>
';
##############################
### END OF CONTENT DISPLAY ###
##############################


echo '
</div></div>

</body>
</html>
';

?>