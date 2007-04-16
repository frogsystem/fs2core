<?php

//////////////////////////////
//// Ankündigung anzeigen ////
//////////////////////////////

$index = mysql_query("select * from fs_announcement", $db);
$announcement_arr = mysql_fetch_assoc($index);

if ($announcement_arr[text] != "")
{
    $index = mysql_query("select announcement from fs_template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "announcement"));
    $template = str_replace("{meldung}", $announcement_arr[text], $template);
}

?>