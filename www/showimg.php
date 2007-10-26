<?php
include("config.inc.php");
if ($db)
{
    include("includes/functions.php");

/////////////////////////////
//// Konstruktor aufrufe ////
/////////////////////////////
set_design();


//Template aufbauen
$index = mysql_query("SELECT doctype FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
$template_main = stripslashes(mysql_result($index, 0, "doctype"));
$template_main .= '
<html>
<head>

  <title>'.$global_config_arr[title].'</title>
  <base href="'.$global_config_arr['virtualhost'].'">

  <META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  <META name="Description" content="'.$global_config_arr[description].'">
  <META name="Keywords" content="'.$global_config_arr[keywords].'">
  ';

if ($global_config_arr[show_favicon] == 1)
  $template_main .= '<link rel="shortcut icon" href="images/icons/favicon.ico">
  ';

  $template_main .= '<link rel="stylesheet" type="text/css" href="style_css.php?id='.$global_config_arr['design'].'">
  ';
  $template_main .= '<link rel="stylesheet" type="text/css" href="editor_css.php?id='.$global_config_arr['design'].'">
  ';

$template_main .= '</head>';

//Inhalt erzeugen
settype($_GET[catid], 'integer');
settype($_GET[screenid], 'integer');

//config_arr
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen_config", $db);
$config_arr = mysql_fetch_assoc($index);

if (isset($_GET[screen]))
{
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen WHERE screen_id = $_GET[screenid]", $db);
    $_GET[title] = mysql_result($index, 0, "screen_name");
    $_GET[pic] = image_url("images/screenshots/", $_GET[screenid]);

    // gibt es ein nächstes Bild?
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen
                          WHERE cat_id = $_GET[catid] AND
                                screen_id > $_GET[screenid]
                          ORDER BY screen_id
                          LIMIT 1", $db);
    if (mysql_num_rows($index) > 0)
    {
        $nextid = mysql_result($index, 0, "screen_id");
        $next = '
                     <a href="'.$_SERVER[PHP_SELF].'?screen=1&amp;catid='.$_GET[catid].'&amp;screenid='.$nextid.'">
                         << Vorheriges Bild
                     </a>
                ';
    }

    // Gibt es ein vorheriges Bild?
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."screen
                          WHERE cat_id = $_GET[catid] AND
                                screen_id < $_GET[screenid]
                          ORDER BY screen_id DESC
                          LIMIT 1", $db);
    if (mysql_num_rows($index) > 0)
    {
        $previd = mysql_result($index, 0, "screen_id");
        $prev = '
                     <a href="'.$_SERVER[PHP_SELF].'?screen=1&amp;catid='.$_GET[catid].'&amp;screenid='.$previd.'">
                         Nächstes Bild >>
                     </a>
                ';
    }
}

$max_width = $config_arr[show_img_x];
$max_height = $config_arr[show_img_y];

$_GET[pic_url] = $_GET[pic];

list($width, $height) = getimagesize($_GET[pic]);
$imgratio=$width/$height;
if ($width<=$max_width AND $height<=$max_height)
{
  $_GET[pic] = "<img src='$_GET[pic]' border='0' alt='$_GET[title]'>";
}
elseif ($imgratio>1)   //Querformat
{
  if ($max_width/$imgratio > $max_height)
  {
    $_GET[pic] = "<img src='$_GET[pic]' height='$max_height' border='0' alt='$_GET[title]'>";
  }
  else
  {
    $_GET[pic] = "<img src='$_GET[pic]' width='$max_width' border='0' alt='$_GET[title]'>";
  }
}
else    //Hochformat
{
  $_GET[pic] = "<img src='$_GET[pic]' height='$max_height' border='0' alt='$_GET[title]'>";
}

$close ="&nbsp;&nbsp;&nbsp;<a href='#ank' onclick='self.close();'>[Fenster schlie&szlig;en]</a>&nbsp;&nbsp;&nbsp;";

$index = mysql_query("select pic_viewer from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template_viewer = stripslashes(mysql_result($index, 0, "pic_viewer"));
        
$template_viewer = str_replace("{text}", $_GET[title], $template_viewer);
$template_viewer = str_replace("{weiter_grafik}", $next, $template_viewer);
$template_viewer = str_replace("{zurück_grafik}", $prev, $template_viewer);
$template_viewer = str_replace("{bild}", $_GET[pic], $template_viewer);
$template_viewer = str_replace("{bild_url}", $_GET[pic_url], $template_viewer);
$template_viewer = str_replace("{close}", $close, $template_viewer);


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
    $template_viewer = str_replace($include_arr['replace_string'], $template_include, $template_viewer);
    unset($template_include);
}
unset($include_arr);

//Seitenvariablen
$index = mysql_query("select replace_string, replace_thing from ".$global_config_arr[pref]."includes where include_type = '1' ORDER BY replace_string ASC", $db);
while ($sv_arr = mysql_fetch_assoc($index))
{
    // Include-URL laden
    $sv_arr['replace_thing'] = killsv($sv_arr['replace_thing']);
    $template_viewer = str_replace($sv_arr['replace_string'], stripslashes($sv_arr['replace_thing']), $template_viewer);
}
unset($sv_arr);



$template = $template_main.$template_viewer."</html>";

unset($template_viewer);
unset($template_main);

echo $template;

mysql_close($db);
}
?>