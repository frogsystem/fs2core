<?php

include("login.inc.php");

if ($db)
{
////////////////////////
//// Counter Script ////
////////////////////////
    $time = time();             // Aktueller Timestamp
    $counttime = "86400";       // Zeit die die IPs gespeichert bleiben in sek. (1 Tag = 86400)
    $s_year2 = date("Y");       // Jahr
    $s_month2 = date("m");      // Monat
    $s_day2 = date("d");        // Tag

    // Referer speichern
    $refe = preg_replace("=(.*?)\=([0-9a-z]{32})(.*?)=i", "\\1=\\3",$_SERVER[HTTP_REFERER]);
    if(mysql_num_rows(mysql_query("select * from ".$global_config_arr[pref]."counter_ref where ref_url = '$refe'", $db)) == 0)
    {
        if(substr_count($refe, "http://") >= 1)
        {
            mysql_query("INSERT INTO ".$global_config_arr[pref]."counter_ref (ref_url, ref_count, ref_date) VALUES ('$refe', 1, $time)", $db);
        }
    }
    else
    {
        mysql_query("UPDATE ".$global_config_arr[pref]."counter_ref SET ref_count=ref_count+1 WHERE ref_url = '$refe'", $db);
    }

    // IPs löschen (Tag)
    $deltime = $time - $counttime;
    mysql_query("DELETE FROM ".$global_config_arr[pref]."iplist WHERE deltime < $deltime",$db);

    // User löschen, die nicht mehr online sind
    $deleteuser = mysql_query("DELETE FROM ".$global_config_arr[pref]."useronline WHERE date < ($time - 300)", $db);

    //Tag prüfen
    $daycounter = mysql_query("SELECT * FROM ".$global_config_arr[pref]."counter_stat
                               WHERE s_year = $s_year2 AND s_month = $s_month2 AND s_day = $s_day2", $db);
    $rows = mysql_num_rows($daycounter);
    if ($rows == 0)
    {
        mysql_query("INSERT INTO ".$global_config_arr[pref]."counter_stat (s_year, s_month, s_day, s_visits, s_hits) values ('$s_year2', '$s_month2', '$s_day2', '0', '0')", $db);
    }

    //Hits zählen
    mysql_query("UPDATE ".$global_config_arr[pref]."counter SET hits=hits+1", $db);
    mysql_query("UPDATE ".$global_config_arr[pref]."counter_stat
                 SET s_hits = s_hits+1
                 WHERE s_year = $s_year2 AND s_month = $s_month2 AND s_day = $s_day2", $db);

    //IP speichern - Visits zählen
    $ipindex = mysql_query("SELECT * FROM ".$global_config_arr[pref]."iplist WHERE ip='$_SERVER[REMOTE_ADDR]'", $db);
    $anzips = mysql_num_rows($ipindex);
    if($anzips == 0)
    {
        mysql_query("UPDATE ".$global_config_arr[pref]."counter SET visits=visits+1", $db);
        mysql_query("UPDATE ".$global_config_arr[pref]."counter_stat
                     SET s_visits = s_visits+1
                     WHERE s_year = $s_year2 AND s_month = $s_month2 AND s_day = $s_day2", $db);
        mysql_query("INSERT INTO ".$global_config_arr[pref]."iplist (deltime, ip) VALUES ('$time', '$_SERVER[REMOTE_ADDR]')", $db);
    }

    $useronline = mysql_fetch_row(mysql_query("SELECT * FROM ".$global_config_arr[pref]."useronline WHERE ip='$_SERVER[REMOTE_ADDR]'", $db));

    if($useronline == false)
    {
        mysql_query("INSERT INTO ".$global_config_arr[pref]."useronline (ip,host,date) VALUES ('$_SERVER[REMOTE_ADDR]', NULL, '$time')", $db);
    }

}
?>