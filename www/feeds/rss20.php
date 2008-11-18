<?php
// Set header
header("Content-type: application/rss+xml");

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

// Inlcude DB Connection File
require( FS2_ROOT_PATH . "login.inc.php");

if ($db)
{
    include( FS2_ROOT_PATH . "includes/functions.php");
    include( FS2_ROOT_PATH . "includes/imagefunctions.php");

    if ($global_config_arr[virtualhost] == "") {
        $global_config_arr[virtualhost] = "http://example.com/";
    }

    // News Config + Infos
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."news_config", $db);
    $news_config_arr = mysql_fetch_assoc($index);
    
    //Feed Header ausgeben
    echo'<?xml version="1.0" encoding="utf-8"?>
        <rss version="2.0">
        <channel>
        <language>de</language>
        <description>'.htmlspecialchars($global_config_arr[description]).'</description>
        <link>'.$global_config_arr[virtualhost].'</link>
        <title>'.htmlspecialchars($global_config_arr[title]).'</title>
    ';

    $index = mysql_query("SELECT news_id, news_text, news_title, news_date
                          FROM ".$global_config_arr[pref]."news
                          WHERE news_date <= UNIX_TIMESTAMP()
                          AND news_active = 1
                          ORDER BY news_date DESC
                          LIMIT $news_config_arr[num_news]", $db);
    while ($news_arr = mysql_fetch_assoc($index))
    {


        // Item ausgeben
        echo'
            <item>
            <title>'.utf8_encode(htmlspecialchars($news_arr[news_title])).'</title>
            <link>'.$global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id].'</link>
            <pubDate>'.date("r",$news_arr[news_date]).'</pubDate>
            <description>'.truncate_string(utf8_encode(killfs($news_arr[news_text])),500," ...").'</description>
            <guid>'.$global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id].'</guid>
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
        <rss version="2.0">
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