<?php

header("Content-type: application/atom+xml");

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

    $index = mysql_query("SELECT news_date
                          FROM ".$pref."news
                          WHERE news_date <= UNIX_TIMESTAMP()
                          ORDER BY news_date DESC
                          LIMIT 1");

    $last_date[news_date] = mysql_result($index,0,"news_date");
    $last_date[old_time_zone] = date("O",$last_date[news_date]);
    $last_date[time_zone] = substr($last_date[old_time_zone],0,strlen($last_date[old_time_zone]-2))
                          .":".substr($last_date[old_time_zone],-2,2);
    $last_date[news_updated] = date("Y-m-d\TH:i:s",$last_date[news_date]);
    $last_date[news_updated] .= $last_date[time_zone];
    
    //Feed Header ausgeben
    echo'<?xml version="1.0" encoding="utf-8"?>
        <feed xmlns="http://www.w3.org/2005/Atom">
        <id>'.$global_config_arr[virtualhost].'</id>
        <title>'.htmlspecialchars($global_config_arr[title]).'</title>
        <updated>'.$last_date[news_updated].'</updated>
        <link rel="self" href="atom10.php" />
    ';

    $index = mysql_query("SELECT news_id, news_text, news_title, news_date, user_id
                          FROM ".$pref."news
                          WHERE news_date <= UNIX_TIMESTAMP()
                          ORDER BY news_date DESC
                          LIMIT $news_config_arr[num_news]");

    while ($news_arr = mysql_fetch_assoc($index))
    {
        $index2 = mysql_query("SELECT user_name FROM ".$pref."user WHERE user_id = $news_arr[user_id]");
        $news_arr[user_name] = mysql_result($index2,0,"user_name");

        $news_arr[old_time_zone] = date("O",$news_arr[news_date]);
        $news_arr[time_zone] = substr($news_arr[old_time_zone],0,2).":".substr($news_arr[old_time_zone],2,2);
        $news_arr[time_zone] = substr($news_arr[old_time_zone],0,strlen($news_arr[old_time_zone]-2))
                             .":".substr($news_arr[old_time_zone],-2,2);
        $news_arr[news_updated] = date("Y-m-d\TH:i:s",$news_arr[news_date]);
        $news_arr[news_updated] .= $news_arr[time_zone];
        
        // Item ausgeben
        echo'
            <entry>
                <id>'.$global_config_arr[virtualhost].'?go=comments&amp;id='.$news_arr[news_id].'</id>
                <title>'.utf8_encode(htmlspecialchars($news_arr[news_title])).'</title>
                <updated>'.$news_arr[news_updated].'</updated>
                <author>
                    <name>'.$news_arr[user_name].'</name>
                </author>
                <content>'.utf8_encode(killfs($news_arr[news_text])).'</content>
                <link rel="alternate" href="'.$global_config_arr[virtualhost].'#'.$news_arr[news_id].'" />
            </entry>
        ';
     }

    echo'
        </feed>
    ';
}
else
{
    //"Keine Verbindung"-Feed
    echo'<?xml version="1.0" encoding="utf-8"?>
        <feed xmlns="http://www.w3.org/2005/Atom">
        <id>http://notfound.com/</id>
        <title>Fehler</title>
        <updated>'.date("r").'</updated>
        </feed>
    ';
}

?>