<?php
// Alle Kategorien angeben, die nicht übermittelt werden sollen
// Durch Komma getrennte IDs, am Ende kein Komma setzen

$dontshow = "";

#######################
#######################

// Set header
header("Content-type: application/rss+xml");

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./../", TRUE );

// Inlcude DB Connection File
require( FS2_ROOT_PATH . "login.inc.php");

if ($db)
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

    //Create WHERE Abfragen
    if ( strlen ( $dontshow ) > 0 ) {
        $where= "AND `cat_id` NOT IN (".$dontshow.")";
    } else {
        $where= "";
    }

    // News Config + Infos
    $index = mysql_query("SELECT `num_news` FROM ".$global_config_arr['pref']."news_config", $db);
    $news_config_arr = mysql_fetch_assoc($index);

    //Feed Header ausgeben
    echo'<?xml version="1.0" encoding="UTF-8"?>
        <!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
        <rss version="0.91">
        <channel>
        <language>de</language>
        <description>'.htmlspecialchars($global_config_arr[description]).'</description>
        <link>'.$global_config_arr[virtualhost].'</link>
        <title>'.htmlspecialchars($global_config_arr[title]).'</title>
    ';

    $index = mysql_query ( "
                            SELECT `news_id`, `news_text`, `news_title`, `news_date`
                            FROM `".$global_config_arr['pref']."news`
                            WHERE `news_date` <= ".time()."
                            AND `news_active` = 1
                            ".$where."
                            ORDER BY `news_date` DESC
                            LIMIT 0,".$news_config_arr['num_news']."
    ", $db );

    while ($news_arr = mysql_fetch_assoc($index)) {
        // Item ausgeben
        echo'
            <item>
              <title>'.htmlspecialchars($news_arr[news_title]).'</title>
              <link>'.$global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id].'</link>
              <pubDate>'.$news_arr[news_date].'</pubDate>
              <description>'.truncate_string(htmlspecialchars($news_arr[news_text]),500," ...").'</description>
              <comments>'.$global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id].'</comments>
            </item>
        ';
     }

    echo'
        </channel>
        </rss>
    ';

mysql_close($db);
}

?>