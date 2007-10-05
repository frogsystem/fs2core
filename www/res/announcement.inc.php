<?php

//////////////////////////////
//// Ankündigung anzeigen ////
//////////////////////////////

$index = mysql_query("select * from ".$global_config_arr[pref]."announcement", $db);
$announcement_arr = mysql_fetch_assoc($index);

if ($announcement_arr[text] != "")
{
    $announcement_arr[text] = fscode($announcement_arr[text], true, true, true);
    $index = mysql_query("select announcement from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
    $template = stripslashes(mysql_result($index, 0, "announcement"));
    $template = str_replace("{meldung}", $announcement_arr[text], $template);
}

?>