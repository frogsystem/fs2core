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
$news_line_tpl = "";
while ($newshead_arr = mysql_fetch_assoc($index))
{
    $newshead_arr['news_date'] = date_loc ( $global_config_arr['datetime'] , $newshead_arr['news_date'] );
    if ( strlen ( $newshead_arr['news_title'] ) > $config_arr['news_headline_lenght'] && $config_arr['news_headline_lenght'] >=0 ) {
        $newshead_arr['news_title'] = substr ( $newshead_arr['news_title'], 0, $config_arr['news_headline_lenght'] ) . $config_arr['news_headline_ext'];
    }
    
    // Get Template
    $template = new template();
    $template->setFile("0_news.tpl");
    $template->load("APPLET_LINE");

    $template->tag("title", stripslashes ( $newshead_arr['news_title'] ) );
    $template->tag("date", $newshead_arr['news_date'] );
    $template->tag("url", "?go=comments&amp;id=".$newshead_arr['news_id'] );
    $template->tag("news_id", $newshead_arr['news_id'] );

    $template = $template->display ();
    $news_line_tpl .= $template;
}
unset($newshead_arr);

// Neuste Downloads erzeugen
$index = mysql_query("select dl_name, dl_id, dl_date
                      from ".$global_config_arr[pref]."dl
                      where dl_open = 1
                      order by dl_date desc
                      limit $config_arr[num_head]", $db);
$downloads_tpl = "";
while ($dlhead_arr = mysql_fetch_assoc($index))
{
    $dlhead_arr['dl_date'] = date_loc ( $global_config_arr['datetime'] , $dlhead_arr['dl_date'] );
    if ( strlen ( $dlhead_arr['dl_name'] ) > $config_arr['news_headline_lenght'] ) {
        $dlhead_arr['dl_name'] = substr ( $dlhead_arr['dl_name'], 0, $config_arr['news_headline_lenght'] ) . $config_arr['news_headline_ext'];
    }

    // Get Template
    $template = new template();
    $template->setFile("0_downloads.tpl");
    $template->load("APPLET_LINE");

    $template->tag("title", stripslashes ( $dlhead_arr['dl_name'] ) );
    $template->tag("date", $dlhead_arr['dl_date'] );
    $template->tag("url", "?go=dlfile&amp;id=".$dlhead_arr['dl_id'] );
    $template->tag("download_id", $dlhead_arr['dl_id'] );

    $template = $template->display ();
    $downloads_tpl .= $template;
}
unset($dlhead_arr);

// Get Headline Template
$template = new template();
$template->setFile("0_news.tpl");
$template->load("APPLET_BODY");

$template->tag("news_lines", $news_line_tpl );
$template->tag("download_lines", $downloads_tpl );

$template = $template->display ();
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

// Get Template
$template = new template();
$template->setFile("0_news.tpl");
$template->load("BODY");

$template->tag("news", $news_template );
$template->tag("headlines", $headline_template );

$template = $template->display ();
?>