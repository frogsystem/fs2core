<?php
include("config.inc.php");

settype($_GET[catid], 'integer');
settype($_GET[screenid], 'integer');

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
                         <img border="0" src="images/design/pfeil_r.gif">
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
                         <img border="0" src="images/design/pfeil_l.gif">
                     </a>
                ';
    }
}

$index = mysql_query("select template_code from fs_template where template_name = 'pic_viewer'", $db);
$template = stripslashes(mysql_result($index, 0, "template_code"));
$template = str_replace("{bannercode}", $bannercode, $template); 
$template = str_replace("{text}", $_GET[title], $template); 
$template = str_replace("{weiter_grafik}", $next, $template); 
$template = str_replace("{zurück_grafik}", $prev, $template); 
$template = str_replace("{bild}", $_GET[pic], $template); 

echo $template;

mysql_close($db);
?>