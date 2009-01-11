<?php

////////////////////////////
//// News Kopf erzeugen ////
////////////////////////////

// News Konfiguration lesen
$index = mysql_query("select * from ".$global_config_arr[pref]."news_config", $db);
$config_arr = mysql_fetch_assoc($index);
$time = time();

// Headlines erzeugen
$index = mysql_query("select * from ".$global_config_arr[pref]."news
                      where news_date <= $time
                      AND news_active = 1
                      order by news_date desc
                      limit $config_arr[num_head]", $db);
while ($newshead_arr = mysql_fetch_assoc($index))
{
    $newshead_arr['news_date'] = date("d.m.y" , $newshead_arr['news_date']) . " | " . date("H:i" , $newshead_arr['news_date']);
    if ( strlen ( $newshead_arr['news_title'] ) > $config_arr['news_headline_lenght'] && $config_arr['news_headline_lenght'] >=0 ) {
        $newshead_arr['news_title'] = substr ( $newshead_arr['news_title'], 0, $config_arr['news_headline_lenght'] ) . $config_arr['news_headline_ext'];
    }
    
    $headline = get_template ( "news_headline" );
    $headline = str_replace("{datum}", $newshead_arr['news_date'], $headline);
    $headline = str_replace("{url}", "#".$newshead_arr['news_id'], $headline);
    $headline = str_replace("{titel}", stripslashes ( $newshead_arr['news_title'] ), $headline);
    $headline_tpl .= $headline;
}
unset($newshead_arr);

// Neuste Downloads erzeugen
$index = mysql_query("select dl_name, dl_id, dl_date
                      from ".$global_config_arr[pref]."dl
                      where dl_open = 1
                      order by dl_date desc
                      limit $config_arr[num_head]", $db);
while ($dlhead_arr = mysql_fetch_assoc($index))
{
    $dlhead_arr['dl_date'] = date("d.m.y" , $dlhead_arr['dl_date']) . " | " . date("H:i" , $dlhead_arr['dl_date']);
    if ( strlen ( $dlhead_arr['dl_name'] ) > $config_arr['news_headline_lenght'] ) {
        $dlhead_arr['dl_name'] = substr ( $dlhead_arr['dl_name'], 0, $config_arr['news_headline_lenght'] ) . $config_arr['news_headline_ext'];
    }

    $download = get_template ( "dl_quick_links" );
    $download = str_replace("{datum}", $dlhead_arr['dl_date'], $download);
    $download = str_replace("{url}", "?go=dlfile&fileid=".$dlhead_arr['dl_id'], $download);
    $download = str_replace("{name}", stripslashes ( $dlhead_arr['dl_name'] ), $download);
    $downloads_tpl .= $download;
}
unset($dlhead_arr);

// Headline Body aufbauen
$index = mysql_query("select news_headline_body from ".$global_config_arr[pref]."template where id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "news_headline_body"));
$template = str_replace("{headlines}", $headline_tpl, $template); 
$template = str_replace("{downloads}", $downloads_tpl, $template); 

$headline_template = $template;

////////////////////////////
////// News ausgeben ///////
////////////////////////////

$index = mysql_query("select * from ".$global_config_arr[pref]."news
                      where news_date <= $time
                      AND news_active = 1
                      order by news_date desc
                      limit $config_arr[num_news]", $db);
while ($news_arr = mysql_fetch_assoc($index))
{
    $news_template .= display_news($news_arr, $config_arr[html_code], $config_arr[fs_code], $config_arr[para_handling]);
}
unset($news_arr);

$index = mysql_query("SELECT news_container FROM ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
$template = stripslashes(mysql_result($index, 0, "news_container"));
$template = str_replace("{news}", $news_template, $template);
$template = str_replace("{headlines}", $headline_template, $template);

?>