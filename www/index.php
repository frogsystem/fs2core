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
$index = mysql_query("select main_menu from fs_template where id = '$global_config_arr[design]'", $db);
$template_main_menu = stripslashes(mysql_result($index, 0, "main_menu"));


// Inhalt einfügen
if (!isset($_GET[go]))
{
  $_GET[go] = "news";
}
else
{
  $_GET[go] = savesql($_GET[go]);
  $index = mysql_query("select artikel_url from fs_artikel where artikel_url = '$_GET[go]'");
}
if (file_exists("data/".$_GET[go].".php"))
{
  include("data/".$_GET[go].".php");
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
unset($template);


// Ankündigung laden
include("res/announcement.inc.php");
$template_announcement = $template;
unset($template);

// User Menü laden
include("res/user.inc.php");
$template_user = $template;
unset($template);

// Zufallsbild laden
include("res/randompic.inc.php");
$template_randompic = $template;
unset($template);

// Poll laden
include("res/poll.inc.php");
$template_poll = $template;
unset($template);

// Statistik laden
include("res/stats.inc.php");
$template_stats = $template;
unset($template);

// Shop laden
include("res/shop.inc.php");
$template_shop = $template;
unset($template);

// Partner laden
include("res/partner.inc.php");
$template_partner = $template;
unset($template);

echo'
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <title>'.$global_config_arr[title].'</title>
  <base href="'.$global_config_arr['virtualhost'].'">
  
  <META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <META name="Description" content="'.$global_config_arr[description].'">
  <META name="Keywords" content="'.$global_config_arr[keywords].'">
  <META name="Author" content="'.$global_config_arr[author].'">
  <META name="Content-language" content="de">
  <META name="Revisit-after" content="3 days">
  <META name="Audience" content="Alle">
  <META name="Robots" content="INDEX,FOLLOW">
  ';

if ($global_config_arr[show_favicon] == 1)
  echo '<LINK REL="SHORTCUT ICON" HREF="images/icons/favicon.ico">
  ';

  echo '<link rel="stylesheet" type="text/css" href="css/'.$global_config_arr['design_name'].'.css" />
  <link rel="stylesheet" type="text/css" href="res/editor.css" />
  <script src="res/functions.js" type="text/javascript"></script>';

// <link rel="alternate" type="application/rss+xml" href="rss/rss.php" title="RSS Feed" />';

echo'</head>';

// Template laden
$index = mysql_query("select indexphp from fs_template where id = '$global_config_arr[design]'", $db);
$template_index = stripslashes(mysql_result($index, 0, "indexphp"));

$template_index = str_replace("{main_menu}", $template_main_menu, $template_index);
$template_index = str_replace("{content}", $template_content, $template_index);
$template_index = str_replace("{user}", $template_user, $template_index);
$template_index = str_replace("{randompic}", $template_randompic, $template_index);
$template_index = str_replace("{poll}", $template_poll, $template_index);
$template_index = str_replace("{stats}", $template_stats, $template_index);
$template_index = str_replace("{shop}", $template_shop, $template_index);
$template_index = str_replace("{partner}", $template_partner, $template_index);

if ($global_config_arr[show_announcement]==1)
{
  $template_index = str_replace("{announcement}", $template_announcement, $template_index);
}
elseif ($global_config_arr[show_announcement]==2 AND $_GET[go]=="news")
{
  $template_index = str_replace("{announcement}", $template_announcement, $template_index);
}
else
{
  $template_index = str_replace("{announcement}", "", $template_index);
}

//Includes
$index = mysql_query("select * from fs_includes where include_type = '2'", $db);
while ($include_arr = mysql_fetch_assoc($index))
{
    // Include laden
    include("inc/".$include_arr['replace_thing']);
    $template_include = $template;
    unset($template);
    $template_index = str_replace($include_arr['replace_string'], $template_include, $template_index);
    unset($template_include);
}


//Seitenvariablen
$index = mysql_query("select * from fs_includes where include_type = '1'", $db);
while ($include_arr = mysql_fetch_assoc($index))
{
    // Include-URL laden
    $template_index = str_replace($include_arr['replace_string'], $include_arr['replace_thing'], $template_index);
}


$template_index = str_replace("{virtualhost}", $global_config_arr[virtualhost], $template_index);

echo $template_index;

echo'</html>';
mysql_close($db);
}
else
{
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Frogsystem</title>
</head>
<body>
  <b>Beim Verbindungsaufbau zum Server ist ein Fehler aufgetreten. Bitte versuchen Sie es später nocheinmal.</b>
</body>
</html>
';
}
?>