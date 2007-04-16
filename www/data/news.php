<?php

////////////////////////////
//// News Kopf erzeugen ////
////////////////////////////

// News Konfiguration lesen
$index = mysql_query("select * from fs_news_config", $db);
$config_arr = mysql_fetch_assoc($index);
$time = time();

// Headlines erzeugen
$index = mysql_query("select * from fs_news
                      where news_date <= $time
                      order by news_date desc
                      limit $config_arr[num_head]", $db);
while ($newshead_arr = mysql_fetch_assoc($index))
{
    $index2 = mysql_query("select news_headline from fs_template where id = '$global_config_arr[design]'", $db);
    $headline = stripslashes(mysql_result($index2, 0, "news_headline"));
    $newshead_arr[news_date] = date("d.m.y" , $newshead_arr[news_date]) . " | " . date("H:i" , $newshead_arr[news_date]);
    $headline = str_replace("{datum}", $newshead_arr[news_date], $headline); 
    $headline = str_replace("{url}", "#".$newshead_arr[news_id], $headline); 
    $headline = str_replace("{titel}", $newshead_arr[news_title], $headline); 
    $headline_tpl .= $headline;
}
unset($newshead_arr);

// Neuste Downloads erzeugen
$index = mysql_query("select dl_name, dl_id, dl_date
                      from fs_dl
                      where dl_open = 1
                      order by dl_date desc
                      limit $config_arr[num_head]", $db);
while ($dlhead_arr = mysql_fetch_assoc($index))
{
    $index2 = mysql_query("select dl_quick_links from fs_template where id = '$global_config_arr[design]'", $db);
    $download = stripslashes(mysql_result($index2, 0, "dl_quick_links"));
    $dlhead_arr[dl_date] = date("d.m.y" , $dlhead_arr[dl_date]) . " | " . date("H:i" , $dlhead_arr[dl_date]);
    $download = str_replace("{datum}", $dlhead_arr[dl_date], $download); 
    $download = str_replace("{url}", "?go=dlfile&amp;fileid=".$dlhead_arr[dl_id], $download); 
    $download = str_replace("{name}", $dlhead_arr[dl_name], $download); 
    $downloads_tpl .= $download;
}
unset($dlhead_arr);

// Headline Body aufbauen
$index = mysql_query("select news_headline_body from fs_template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "news_headline_body"));
$template = str_replace("{headlines}", $headline_tpl, $template); 
$template = str_replace("{downloads}", $downloads_tpl, $template); 

////////////////////////////
////// News ausgeben ///////
////////////////////////////

$index = mysql_query("select * from fs_news
                      where news_date <= $time
                      order by news_date desc
                      limit $config_arr[num_news]", $db);
while ($news_arr = mysql_fetch_assoc($index))
{
    $news_template .= display_news($news_arr, $config_arr[html_code], $config_arr[fs_code]);
}
unset($news_arr);

$template .= $news_template;
?>