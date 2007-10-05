<?php

include("login.inc.php");

////////////////////////
////// DB Connect //////
////////////////////////

@$db = mysql_connect($host, $user, $pass);
if ($db)
{
    mysql_select_db($data,$db);

unset($host);
unset($user);
unset($pass);

////////////////////////
//// Seitenvariablen ///
////////////////////////


// Allgemeine Config + Infos
$index = mysql_query("SELECT * FROM ".$pref."global_config", $db);
$global_config_arr = mysql_fetch_assoc($index);

//write $pref into $global_config_arr[pref]
$global_config_arr[pref] = $pref;
unset($pref);

if (isset ($_GET['design_id']) AND $global_config_arr[allow_other_designs] == 1)
{
  $index2 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."template WHERE id = $_GET[design_id]", $db);
  if (mysql_num_rows($index2) > 0)
  {
    $global_config_arr[design] =  $_GET['design_id'];
    settype($global_config_arr[design], "integer");
  }
}
elseif (isset ($_GET['design']) AND $global_config_arr[allow_other_designs] == 1)
{
  $index2 = mysql_query("SELECT id FROM ".$global_config_arr[pref]."template WHERE name = '$_GET[design]'", $db);
  if (mysql_num_rows($index2) > 0)
  {
    $global_config_arr[design] =  mysql_result($index2, "id");
    settype($global_config_arr[design], "integer");
  }
}

if (isset ($_GET['zone_id']) AND $global_config_arr[allow_other_designs] == 1)
{
  $index2 = mysql_query("SELECT * FROM ".$global_config_arr[pref]."zones WHERE id = $_GET[zone_id]", $db);
  if (mysql_num_rows($index2) > 0)
  {
    $global_config_arr[design] =  $_GET['design_id'];
    settype($global_config_arr[design], "integer");
  }
}
elseif (isset ($_GET['zone']) AND $global_config_arr[allow_other_designs] == 1)
{
  $index2 = mysql_query("SELECT design_id FROM ".$global_config_arr[pref]."zones WHERE name = '$_GET[zone]'", $db);
  if (mysql_num_rows($index2) > 0)
  {
    $global_config_arr[design] =  mysql_result($index2, "design_id");
    settype($global_config_arr[design], "integer");
  }
}

$index = mysql_query("select name from ".$global_config_arr[pref]."template WHERE id = '$global_config_arr[design]'", $db);
$global_config_arr['design_name'] = mysql_result($index, "name");


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
            mysql_query("insert into ".$global_config_arr[pref]."counter_ref (ref_url, ref_count, ref_date) values ('$refe', 1, $time)", $db);
        }
    }
    else
    {
        mysql_query("update ".$global_config_arr[pref]."counter_ref set ref_count=ref_count+1 where ref_url = '$refe'", $db);
    }

    // IPs löschen (Tag)
    $deltime = $time - $counttime;
    mysql_query("delete from ".$global_config_arr[pref]."iplist WHERE deltime < $deltime",$db);

    // User löschen, die nicht mehr online sind
    $deleteuser = mysql_query("delete from ".$global_config_arr[pref]."useronline where date < ($time - 300)", $db);

    //Tag prüfen
    $daycounter = mysql_query("select * from ".$global_config_arr[pref]."counter_stat
                               where s_year = $s_year2 and s_month = $s_month2 and s_day = $s_day2", $db);
    $rows = mysql_num_rows($daycounter);
    if ($rows == 0)
    {
        mysql_query("insert into ".$global_config_arr[pref]."counter_stat (s_year, s_month, s_day, s_visits, s_hits) values ('$s_year2', '$s_month2', '$s_day2', '0', '0')", $db);
    }

    //Hits zählen
    mysql_query("update ".$global_config_arr[pref]."counter set hits=hits+1", $db);
    mysql_query("update ".$global_config_arr[pref]."counter_stat
                 set s_hits = s_hits+1
                 where s_year = $s_year2 and s_month = $s_month2 and s_day = $s_day2", $db);

    //IP speichern - Visits zählen
    $ipindex = mysql_query("select * from ".$global_config_arr[pref]."iplist where ip='$_SERVER[REMOTE_ADDR]'", $db);
    $anzips = mysql_num_rows($ipindex);
    if($anzips == 0)
    {
        mysql_query("update ".$global_config_arr[pref]."counter set visits=visits+1", $db);
        mysql_query("update ".$global_config_arr[pref]."counter_stat
                     set s_visits = s_visits+1
                     where s_year = $s_year2 and s_month = $s_month2 and s_day = $s_day2", $db);
        mysql_query("insert into ".$global_config_arr[pref]."iplist (deltime, ip) values ('$time', '$_SERVER[REMOTE_ADDR]')", $db);
    }

    //
    $useronline = mysql_fetch_row(mysql_query("select * from ".$global_config_arr[pref]."useronline where ip='$_SERVER[REMOTE_ADDR]'", $db));

    if($useronline == false)
    {
        mysql_query("insert into ".$global_config_arr[pref]."useronline (ip,host,date) values ('$_SERVER[REMOTE_ADDR]', NULL, '$time')", $db);
    }

}
?>