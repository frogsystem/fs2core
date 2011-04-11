<?php

unset($template);

switch ($step) {
#  case 2:
#    $contenttitle = $_LANG[steps][end][step][2][title];
#    $template .= $_LANG[steps][end][step][2][text];
#    break;
  default:
    $step = 1;
    $contenttitle = $_LANG[steps][end][step][1][long_title];
    $template .= $_LANG[steps][end][step][1][text];
    break;
}

include("inc/install_login.php");
$index = mysql_query("SELECT `virtualhost` FROM `".$pref."global_config` WHERE `id` = '1'", $db);
$page_link = stripslashes(mysql_result($index, 0, "virtualhost"));

$template .= '<br><br>
'.$_LANG[steps][end][link_admin].'<br>
<a href="'.$page_link.'admin/" target="_blank">» '.$page_link.'admin/</a><br><br>
'.$_LANG[steps][end][link_info].'<br><br>
<a href="'.$page_link.'" class="link_button">'.$_LANG[main][arrow].' '.$_LANG[steps][end][link].'</a>';

$lfs = 0;

?>