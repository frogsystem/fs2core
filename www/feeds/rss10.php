<?php

header("Content-type: application/rss+xml");

include("login.inc.php");

@$db = mysql_connect($host, $user, $pass);
if ($db)
{
    include("functions.php");
    mysql_select_db($data,$db);

    // Allgemeine Config + Infos
    $index = mysql_query("SELECT * FROM ".$pref."global_config", $db);
    $global_config_arr = mysql_fetch_assoc($index);
    if ($global_config_arr[virtualhost] == "") {
        $global_config_arr[virtualhost] = "http://notfound.com/";
    }

    // News Config + Infos
    $index = mysql_query("SELECT * FROM ".$pref."news_config", $db);
    $news_config_arr = mysql_fetch_assoc($index);
    
    //Feed Header ausgeben
    echo'<?xml version="1.0" encoding="utf-8"?>
        <rdf:RDF
            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
            xmlns="http://purl.org/rss/1.0/"
        >
        <channel rdf:about="'.$global_config_arr[virtualhost].'feeds/rss10.php">
        <title>'.htmlspecialchars($global_config_arr[title]).'</title>
        <link>'.$global_config_arr[virtualhost].'</link>
        <description>'.htmlspecialchars($global_config_arr[description]).'</description>
        <items>
            <rdf:Seq>
    ';

    $index = mysql_query("SELECT news_id, news_text, news_title, news_date
                          FROM ".$pref."news
                          WHERE news_date <= UNIX_TIMESTAMP()
                          ORDER BY news_date DESC
                          LIMIT $news_config_arr[num_news]");
                          
    while ($news_arr = mysql_fetch_assoc($index))
    {
        // <items> ausgeben
        echo'
            <rdf:li resource="'.$global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id].'" />
        ';
    }
    
    echo'
            </rdf:Seq>
        </items>
        </channel>
    ';




    while ($news_arr = mysql_fetch_assoc($index))
    {
        // Item ausgeben
        echo'
            <item rdf:about="'.$global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id].'">
            <title>'.utf8_encode(htmlspecialchars($news_arr[news_title])).'</title>
            <link>'.$global_config_arr[virtualhost].'#'.$news_arr[news_id].'</link>
            <description>'.truncate_string(utf8_encode(killfs($news_arr[news_text])),500," ...").'</description>
            </item>
        ';
     }

    echo'
        </rdf:RDF>
    ';
}
else
{
    //"Keine Verbindung"-Feed
    echo'<?xml version="1.0" encoding="utf-8"?>
        <rdf:RDF
            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
            xmlns="http://purl.org/rss/1.0/"
        >
        <channel>
        <language>de</language>
        <description>Fehler: Keine Verbindung zur Datenbank</description>
        <link>http://notfound.com/</link>
        <title>Fehler</title>
        </channel>
        </rdf:RDF>
    ';
}

?>