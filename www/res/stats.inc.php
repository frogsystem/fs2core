<?php

// Statsistiken
$index = mysql_query("select * from ".$global_config_arr[pref]."counter", $db);
$counter_arr = mysql_fetch_assoc($index);

// Besucher heute
$index = mysql_query("select s_hits, s_visits from ".$global_config_arr[pref]."counter_stat where s_year = $s_year2 and s_month = $s_month2 and s_day = $s_day2", $db);
$today_arr = mysql_fetch_assoc($index);

// Besucher online
$index = mysql_query("select count(*) as total from ".$global_config_arr[pref]."useronline", $db);
$useronline_arr= mysql_fetch_assoc($index);

$index = mysql_query("select statistik from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "statistik"));
$template = str_replace("{visits}", point_number($counter_arr[visits]), $template); 
$template = str_replace("{visits_heute}", point_number($today_arr[s_visits]), $template); 
$template = str_replace("{hits}", point_number($counter_arr[hits]), $template); 
$template = str_replace("{hits_heute}", point_number($today_arr[s_hits]), $template); 
$template = str_replace("{user_online}", $useronline_arr[total], $template); 
$template = str_replace("{news}", $counter_arr[news], $template); 
$template = str_replace("{artikel}", $counter_arr[artikel], $template); 
$template = str_replace("{user}", $counter_arr[user], $template); 
$template = str_replace("{kommentare}", $counter_arr[comments], $template); 
?>