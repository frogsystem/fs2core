<?php

header("Content-type: application/rss+xml");

include("../login.inc.php");

if ($db)
{
    include("../includes/functions.php");
    include("../includes/imagefunctions.php");

    if ($global_config_arr[virtualhost] == "") {
        $global_config_arr[virtualhost] = "http://example.com/";
    }

    // News Config + Infos
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."news_config", $db);
    $news_config_arr = mysql_fetch_assoc($index);
    
    //Feed Header ausgeben
    echo'<?xml version="1.0" encoding="utf-8"?>
        <!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
        <rss version="0.91">
        <channel>
        <language>de</language>
        <description>'.htmlspecialchars($global_config_arr[description]).'</description>
        <link>'.$global_config_arr[virtualhost].'</link>
        <title>'.htmlspecialchars($global_config_arr[title]).'</title>
    ';

    $index = mysql_query("SELECT news_id, news_text, news_title, news_date
                          FROM ".$global_config_arr[pref]."news
                          WHERE news_date <= UNIX_TIMESTAMP()
                          ORDER BY news_date DESC
                          LIMIT $news_config_arr[num_news]");
    while ($news_arr = mysql_fetch_assoc($index))
    {


        // Item ausgeben
        echo'
            <item>
            <title>'.utf8_encode(htmlspecialchars($news_arr[news_title])).'</title>
            <link>'.$global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id].'</link>
            <pubDate>'.date("r",$news_arr[news_date]).'</pubDate>
            <description>'.truncate_string(utf8_encode(killfs($news_arr[news_text])),500," ...").'</description>
            </item>
        ';
     }

    echo'
        </channel>
        </rss>
    ';
    
mysql_close($db);
}
else
{
    //"Keine Verbindung"-Feed
    echo'<?xml version="1.0" encoding="utf-8"?>
        <!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
        <rss version="0.91">
        <channel>
        <language>de</language>
        <description>Fehler: Keine Verbindung zur Datenbank</description>
        <link>http://example.com/</link>
        <title>Fehler</title>
        </channel>
        </rss>
    ';
}

?>