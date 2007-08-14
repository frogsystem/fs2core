<?php
include("config.inc.php");

settype($_GET[catid], 'integer');
settype($_GET[screenid], 'integer');

//config_arr
$index = mysql_query("SELECT * FROM fs_screen_config", $db);
$config_arr = mysql_fetch_assoc($index);

if (isset($_GET[screen]))
{
    $index = mysql_query("select * from fs_screen where screen_id = $_GET[screenid]", $db);
    $_GET[title] = mysql_result($index, 0, "screen_name");
    $_GET[pic] = "images/screenshots/" . $_GET[screenid] . ".jpg";

    // gibt es ein nächstes Bild?
    $index = mysql_query("select * from fs_screen
                          where cat_id = $_GET[catid] and
                                screen_id > $_GET[screenid]
                          order by screen_id
                          limit 1", $db);
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
    $index = mysql_query("select * from fs_screen
                          where cat_id = $_GET[catid] and
                                screen_id < $_GET[screenid]
                          order by screen_id desc
                          limit 1", $db);
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

$index = mysql_query("select pic_viewer from fs_template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "pic_viewer"));
        
$template = str_replace("{bannercode}", $bannercode, $template);
$template = str_replace("{text}", $_GET[title], $template);
$template = str_replace("{weiter_grafik}", $next, $template);
$template = str_replace("{zurück_grafik}", $prev, $template);
$template = str_replace("{bild}", $_GET[pic], $template);
$template = str_replace("{bild_url}", $_GET[pic_url], $template);
$template = str_replace("{close}", $close, $template);

echo $template;

mysql_close($db);
?>