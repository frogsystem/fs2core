<?php
// Set header
header("Content-type: application/xml");

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

// Inlcude DB Connection File
require( FS2_ROOT_PATH . "login.inc.php");

if ($FD->sql()->conn() )
{
    //Include Functions-Files
    include( FS2_ROOT_PATH . "includes/functions.php");
    include( FS2_ROOT_PATH . "includes/imagefunctions.php");

    //Include Library-Classes
    require ( FS2_ROOT_PATH . "libs/class_template.php" );
    require ( FS2_ROOT_PATH . "libs/class_fileaccess.php" );
    require ( FS2_ROOT_PATH . "libs/class_langDataInit.php" );

    if ($global_config_arr[virtualhost] == "") {
        $global_config_arr[virtualhost] = "http://example.com/";
    }

    // News Config + Infos
    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."news_config", $FD->sql()->conn() );
    $news_config_arr = mysql_fetch_assoc($index);
    
    //Feed Header ausgeben
    echo'<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN" "http://www.rssboard.org/rss-0.91.dtd">
<rss version="0.91">
    <channel>
        <language>de</language>
        <description>'.utf8_encode(htmlspecialchars($global_config_arr[description])).'</description>
        <link>'.utf8_encode($global_config_arr[virtualhost]).'</link>
        <title>'.utf8_encode(htmlspecialchars($global_config_arr['title'])).'</title>
    ';

    $index = mysql_query("SELECT news_id, news_text, news_title, news_date
                          FROM ".$global_config_arr[pref]."news
                          WHERE news_date <= UNIX_TIMESTAMP()
                          AND news_active = 1
                          ORDER BY news_date DESC
                          LIMIT $news_config_arr[num_news]");
                          
    while ($news_arr = mysql_fetch_assoc($index)) {
        // Item ausgeben
        echo'
        <item>
            <title>'.utf8_encode(killhtml($news_arr[news_title])).'</title>
            <link>'.utf8_encode($global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id]).'</link>
            <pubDate>'.utf8_encode(date("r",$news_arr[news_date])).'</pubDate>
            <description><![CDATA['.utf8_encode(killfs($news_arr[news_text])).']]></description>
        </item>
        ';
     }

    echo'
    </channel>
</rss>
    ';
    
    mysql_close($FD->sql()->conn() );
    
} else {
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
