<?php
session_start();
include("config.inc.php");
if ($db)
{
    include("res/dl.inc.php");
    include("functions.php");
    include("cookielogin.php");
    include("phrases/phrases.de.php");

/////////////////////////////
//// Konstruktor aufrufe ////
/////////////////////////////

delete_old_randoms ();



// Hauptmenü aufbauen
$index = mysql_query("select main_menu from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template_main_menu = stripslashes(mysql_result($index, 0, "main_menu"));
$template_main_menu = killbraces($template_main_menu);

// Inhalt einfügen
if (!isset($_GET[go]))
{
  $goto = "news";
}
else
{
  $goto = savesql($_GET[go]);
  $index = mysql_query("select artikel_url from ".$global_config_arr[pref]."artikel where artikel_url = '$goto'");
}

//Go-Aliase
if ($goto == "screenshots" OR $goto == "wallpaper")
{
  $goto = "gallery";
}

//Ausgabe einbinden
if (file_exists("data/".$goto.".php"))
{
  include("data/".$goto.".php");
}
elseif (mysql_num_rows($index) == 1)
{
  include("res/artikel.inc.php");
}
else
{
  include("data/404.php");
}
$template_content = $template;
$template_content = killbraces($template_content);
unset($template);


// Ankündigung laden
include("res/announcement.inc.php");
$template_announcement = $template;
$template_announcement = killbraces($template_announcement);
unset($template);

// User Menü laden
include("res/user.inc.php");
$template_user = $template;
$template_user = killbraces($template_user);
unset($template);

// Zufallsbild laden
include("res/randompic.inc.php");
$template_randompic = $template;
$template_randompic = killbraces($template_randompic);
unset($template);

// Poll laden
include("res/poll.inc.php");
$template_poll = $template;
$template_poll = killbraces($template_poll);
unset($template);

// Statistik laden
include("res/stats.inc.php");
$template_stats = $template;
$template_stats = killbraces($template_stats);
unset($template);

// Shop laden
include("res/shop.inc.php");
$template_shop = $template;
$template_shop = killbraces($template_shop);
unset($template);

// Partner laden
include("res/partner.inc.php");
$template_partner = $template;
$template_partner = killbraces($template_partner);
unset($template);

$index = mysql_query("select doctype from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template_main = stripslashes(mysql_result($index, 0, "doctype"));
$template_main .= '
<html>
<head>

  <title>'.$global_config_arr[title].'</title>
  <base href="'.$global_config_arr['virtualhost'].'">
  
  <META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <META name="Description" content="'.$global_config_arr[description].'">
  <META name="Keywords" content="'.$global_config_arr[keywords].'">
  <META name="Author" content="'.$global_config_arr[author].'">
  <META name="Content-language" content="de">
  <META name="Revisit-after" content="3 days">
  <META name="Audience" content="Alle">
  <META name="Robots" content="INDEX,FOLLOW">
  ';

if ($global_config_arr[show_favicon] == 1)
  $template_main .= '<link rel="shortcut icon" href="images/icons/favicon.ico">';

  $template_main .= '<link rel="stylesheet" type="text/css" href="style_css.php">';
  $template_main .= '<link rel="stylesheet" type="text/css" href="editor_css.php">';
  $template_main .= '<link rel="alternate" type="application/rss+xml" href="feeds/'.$global_config_arr['feed'].'.php" title="'.$global_config_arr[title].' News Feed" />';

  $template_main .= '<script type="text/javascript" src="res/js_functions.js"></script>';
  $template_main .= '<script type="text/javascript" src="res/js_userfunctions.php"></script>';

$template_main .= '</head>';

// Template laden
$index = mysql_query("select indexphp from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template_index = stripslashes(mysql_result($index, 0, "indexphp"));

$template_index = str_replace("{user}", $template_user, $template_index);
$template_index = str_replace("{randompic}", $template_randompic, $template_index);
$template_index = str_replace("{poll}", $template_poll, $template_index);
$template_index = str_replace("{stats}", $template_stats, $template_index);
$template_index = str_replace("{shop}", $template_shop, $template_index);
$template_index = str_replace("{partner}", $template_partner, $template_index);
$template_index = str_replace("{main_menu}", $template_main_menu, $template_index);
$template_index = str_replace("{content}", $template_content, $template_index);

if ($global_config_arr[show_announcement]==1)
{
  $template_index = str_replace("{announcement}", $template_announcement, $template_index);
}
elseif ($global_config_arr[show_announcement]==2 AND $goto=="news")
{
  $template_index = str_replace("{announcement}", $template_announcement, $template_index);
}
else
{
  $template_index = str_replace("{announcement}", "", $template_index);
}

//Includes
$index = mysql_query("select * from ".$global_config_arr[pref]."includes where include_type = '2'", $db);
while ($include_arr = mysql_fetch_assoc($index))
{
    // Include laden
    include("res/".$include_arr['replace_thing']);
    $template_include = $template;
    unset($template);
    
    //Seitenvariablen
    $index = mysql_query("select replace_string, replace_thing from ".$global_config_arr[pref]."includes where include_type = '1' ORDER BY replace_string ASC", $db);
    while ($sv_arr = mysql_fetch_assoc($index))
    {
        // Include-URL laden
        $sv_arr['replace_thing'] = killsv($sv_arr['replace_thing']);
        $template_include = str_replace($sv_arr['replace_string'], stripslashes($sv_arr['replace_thing']), $template_include);
    }
    unset($sv_arr);
    $template_include =  killsv($template_include);
    $template_index = str_replace($include_arr['replace_string'], $template_include, $template_index);
    unset($template_include);
}
unset($include_arr);

//Seitenvariablen
$index = mysql_query("select replace_string, replace_thing from ".$global_config_arr[pref]."includes where include_type = '1' ORDER BY replace_string ASC", $db);
while ($sv_arr = mysql_fetch_assoc($index))
{
    // Include-URL laden
    $sv_arr['replace_thing'] = killsv($sv_arr['replace_thing']);
    $template_index = str_replace($sv_arr['replace_string'], stripslashes($sv_arr['replace_thing']), $template_index);
}
unset($sv_arr);

$template_index = str_replace("{virtualhost}", $global_config_arr[virtualhost], $template_index);

$template_main .=  $template_index;
$template_main .= '</html>';

echo $template_main;

mysql_close($db);
}
else
{
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Keine Verbindung!</title>
</head>
<body>
  <b>Beim Verbindungsaufbau zum Server ist ein Fehler aufgetreten. Bitte versuchen Sie es später nocheinmal.</b>
</body>
</html>
';
}
?>