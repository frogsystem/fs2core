<?php

///////////////////////
//// DB Login Data ////
///////////////////////

$host = "localhost";                //Hostname
$user = "frogsystem";                        //Database User
$data = "frogsystem";                //Database Name
$pass = "frogsystem";                //Password

////////////////////////
////// DB Connect //////
////////////////////////

@$db = mysql_connect($host, $user, $pass);
if ($db)
{
    mysql_select_db($data,$db);


////////////////////////
//// Seitenvariablen ///
////////////////////////


// Allgemeine Config + Infos
$index = mysql_query("SELECT * FROM fs_global_config", $db);
$global_config_arr = mysql_fetch_assoc($index);

if (isset ($_GET['design_id']) AND $global_config_arr[allow_other_designs] == 1)
{
  $index2 = mysql_query("SELECT * FROM fs_template WHERE id = $_GET[design_id]", $db);
  if (mysql_num_rows($index2) > 0)
  {
    $global_config_arr[design] =  $_GET['design_id'];
    settype($global_config_arr[design], "integer");
  }
}
elseif (isset ($_GET['design']) AND $global_config_arr[allow_other_designs] == 1)
{
  $index2 = mysql_query("SELECT id FROM fs_template WHERE name = '$_GET[design]'", $db);
  if (mysql_num_rows($index2) > 0)
  {
    $global_config_arr[design] =  mysql_result($index2, "id");
    settype($global_config_arr[design], "integer");
  }
}

if (isset ($_GET['zone_id']) AND $global_config_arr[allow_other_designs] == 1)
{
  $index2 = mysql_query("SELECT * FROM fs_zones WHERE id = $_GET[zone_id]", $db);
  if (mysql_num_rows($index2) > 0)
  {
    $global_config_arr[design] =  $_GET['design_id'];
    settype($global_config_arr[design], "integer");
  }
}
elseif (isset ($_GET['zone']) AND $global_config_arr[allow_other_designs] == 1)
{
  $index2 = mysql_query("SELECT design_id FROM fs_zones WHERE name = '$_GET[zone]'", $db);
  if (mysql_num_rows($index2) > 0)
  {
    $global_config_arr[design] =  mysql_result($index2, "design_id");
    settype($global_config_arr[design], "integer");
  }
}

$index = mysql_query("select name from fs_template WHERE id = '$global_config_arr[design]'", $db);
$global_config_arr['design_name'] = mysql_result($index, "name");


////////////////////////
//// Counter Script ////
////////////////////////


    $time = time();             // Aktueller Timestamp
    $counttime="86400";         // Zeit die die IPs gespeichert bleiben in sek. (1 Tag = 86400)
    $s_year2 = date("Y");       // Jahr
    $s_month2 = date("m");      // Monat
    $s_day2 = date("d");        // Tag

    // Referer speichern
    $refe = preg_replace("=(.*?)\=([0-9a-z]{32})(.*?)=i", "\\1=\\3",$_SERVER[HTTP_REFERER]);
    if(mysql_num_rows(mysql_query("select * from fs_counter_ref where ref_url = '$refe'", $db)) == 0)
    {
        if(substr_count($refe, "http://") >= 1)
        {
            mysql_query("insert into fs_counter_ref (ref_url, ref_count, ref_date) values ('$refe', 1, $time)", $db);
        }
    }
    else
    {
        mysql_query("update fs_counter_ref set ref_count=ref_count+1 where ref_url = '$refe'", $db);
    }

    // IPs löschen (Tag)
    $deltime = $time - $counttime;
    mysql_query("delete from fs_iplist WHERE deltime < $deltime",$db);

    // User löschen, die nicht mehr online sind
    $deleteuser = mysql_query("delete from fs_useronline where date < ($time - 300)", $db);

    //Tag prüfen
    $daycounter = mysql_query("select * from fs_counter_stat
                               where s_year = $s_year2 and s_month = $s_month2 and s_day = $s_day2", $db);
    $rows = mysql_num_rows($daycounter);
    if ($rows == 0)
    {
        mysql_query("insert into fs_counter_stat (s_year, s_month, s_day, s_visits, s_hits) values ('$s_year2', '$s_month2', '$s_day2', '0', '0')", $db);
    }

    //Hits zählen
    mysql_query("update fs_counter set hits=hits+1", $db);
    mysql_query("update fs_counter_stat
                 set s_hits = s_hits+1
                 where s_year = $s_year2 and s_month = $s_month2 and s_day = $s_day2", $db);

    //IP speichern - Visits zählen
    $ipindex = mysql_query("select * from fs_iplist where ip='$_SERVER[REMOTE_ADDR]'", $db);
    $anzips = mysql_num_rows($ipindex);
    if($anzips == 0)
    {
        mysql_query("update fs_counter set visits=visits+1", $db);
        mysql_query("update fs_counter_stat
                     set s_visits = s_visits+1
                     where s_year = $s_year2 and s_month = $s_month2 and s_day = $s_day2", $db);
        mysql_query("insert into fs_iplist (deltime, ip) values ('$time', '$_SERVER[REMOTE_ADDR]')", $db);
    }

    //
    $useronline = mysql_fetch_row(mysql_query("select * from fs_useronline where ip='$_SERVER[REMOTE_ADDR]'", $db));

    if($useronline == false)
    {
        mysql_query("insert into fs_useronline (ip,host,date) values ('$_SERVER[REMOTE_ADDR]', NULL, '$time')", $db);
    }

}
?>