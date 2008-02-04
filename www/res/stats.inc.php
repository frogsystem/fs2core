<?php
// initialise time variables
$stats_year = date ( "Y" );
$stats_month = date ( "m" );
$stats_day = date ( "d" );


// Statsistiken
$index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."counter", $db);
$counter_arr = mysql_fetch_assoc($index);

// Besucher heute
$index = mysql_query("SELECT s_hits, s_visits FROM ".$global_config_arr[pref]."counter_stat WHERE s_year = $stats_year and s_month = $stats_month and s_day = $stats_day", $db);
$today_arr = mysql_fetch_assoc($index);

// Besucher online
$index = mysql_query("SELECT count(*) AS total FROM ".$global_config_arr[pref]."useronline", $db);
$useronline_arr= mysql_fetch_assoc($index);

$index = mysql_query("SELECT statistik FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
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