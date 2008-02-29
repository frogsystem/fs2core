<?php
////////////////////////////////////
//// check if visit day exists  ////
////////////////////////////////////
function visit_day_exists ( $YEAR, $MONTH, $DAY )
{
    global $db;
    global $global_config_arr;

    // check if visit-day exists
    $daycounter = mysql_query ("SELECT * FROM ".$global_config_arr['pref']."counter_stat
                                WHERE s_year = ".$YEAR." AND s_month = ".$MONTH." AND s_day = ".$DAY."", $db );
                                
    $rows = mysql_num_rows ( $daycounter );

    if ( $rows <= 0 ) {
        mysql_query("INSERT INTO ".$global_config_arr['pref']."counter_stat (s_year, s_month, s_day, s_visits, s_hits) VALUES ('".$YEAR."', '".$MONTH."', '".$DAY."', '0', '0')", $db );
    }
}


////////////////////
//// count hit  ////
////////////////////
function count_hit ()
{
    global $db;
    global $global_config_arr;

    $hit_year = date ( "Y" );
    $hit_month = date ( "m" );
    $hit_day = date ( "d" );
    
    visit_day_exists ( $hit_year, $hit_month, $hit_day );

    // count page_hits
    mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET hits = hits + 1", $db );
    mysql_query ( "UPDATE ".$global_config_arr['pref']."counter_stat
                   SET s_hits = s_hits + 1
                   WHERE s_year = ".$hit_year." AND s_month = ".$hit_month." AND s_day = ".$hit_day."", $db );
}

//////////////////////
//// count visit  ////
//////////////////////
function count_visit ()
{
    global $db;
    global $global_config_arr;

    $time = time ();             // timestamp
    $counttime = "86400";       // time to save IPs (1 day = 86400)
    $visit_year = date ( "Y" );
    $visit_month = date(  "m" );
    $visit_day = date ( "d" );

    visit_day_exists ( $visit_year, $visit_month, $visit_day );

    // delete old IPs
    $deltime = $time - $counttime;
    mysql_query ( "DELETE FROM ".$global_config_arr['pref']."iplist WHERE deltime < ".$deltime."", $db );
    
    // save IP & visit
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."iplist WHERE ip = '".$_SERVER['REMOTE_ADDR']."'", $db );

    if ( mysql_num_rows ( $index ) <= 0 ) {
        mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET visits = visits + 1", $db );
        mysql_query ( "UPDATE ".$global_config_arr['pref']."counter_stat
                       SET s_visits = s_visits + 1
                       WHERE s_year = ".$visit_year." AND s_month = ".$visit_month." AND s_day = ".$visit_day."", $db );
        mysql_query ( "INSERT INTO ".$global_config_arr['pref']."iplist (deltime, ip) VALUES ('".$time."', '".$_SERVER['REMOTE_ADDR']."')", $db );
    }
}

////////////////////////
//// save visitors  ////
////////////////////////
function save_visitors ()
{
    global $db;
    global $global_config_arr;

    $time = time();             // timestamp
    
    // delete offline users
    mysql_query ( "DELETE FROM ".$global_config_arr['pref']."useronline WHERE date < (".$time." - 300)", $db );

    // save online users
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."useronline WHERE ip='".$_SERVER['REMOTE_ADDR']."'", $db );

    if ( mysql_num_rows ( $index ) <= 0 ) {
        mysql_query ( "INSERT INTO ".$global_config_arr['pref']."useronline (ip, host, date) VALUES ('".$_SERVER['REMOTE_ADDR']."', NULL, '".$time."')", $db );
    }
}


///////////////////////
//// save referer  ////
///////////////////////
function save_referer ()
{
    global $db;
    global $global_config_arr;

    $time = time();             // timestamp

    // save referer
    $referer = preg_replace ( "=(.*?)\=([0-9a-z]{32})(.*?)=i", "\\1=\\3", $_SERVER['HTTP_REFERER'] );
    $index =  mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."counter_ref WHERE ref_url = '".$referer."'", $db );
    
    if ( mysql_num_rows ( $index ) <= 0 ) {
        if ( substr_count ( $referer, "http://" ) >= 1 && substr_count ( $referer, $global_config_arr['virtualhost'] ) < 1 ) {
            mysql_query ( "INSERT INTO ".$global_config_arr['pref']."counter_ref (ref_url, ref_count, ref_first, ref_last) VALUES ('".$referer."', '1', '".$time."', '".$time."')", $db );
        }
    } else {
        if ( substr_count ( $referer, "http://" ) >= 1 && substr_count ( $referer, $global_config_arr['virtualhost'] ) < 1 ) {
        	mysql_query ( "UPDATE ".$global_config_arr['pref']."counter_ref SET ref_count = ref_count + 1, ref_last = '".$time."' WHERE ref_url = '".$referer."'", $db );
        }
    }
}


////////////////////////////////
//// del old timed randoms  ////
////////////////////////////////
function delete_old_randoms()
{
  global $db;
  global $global_config_arr;

  if ($global_config_arr[random_timed_deltime] != -1) {
    // Alte Zufallsbild-Einträge aus der Datenbank entfernen
    mysql_query("DELETE a
                FROM ".$global_config_arr[pref]."screen_random a, ".$global_config_arr[pref]."global_config b
                WHERE a.end < UNIX_TIMESTAMP()-b.random_timed_deltime", $db);
  }
}

/////////////////////////////////
//// create copyright note   ////
/////////////////////////////////
function get_copyright ()
{
    return '<span class="small">Powered by <a class="small" href="http://www.frogsystem.de" target="_blank">Frogsystem 2</a> &copy; 2007, 2008 Frogsystem-Team</span>';
}


////////////////////////
/// Designs & Zones ////
////////////////////////
function set_design()
{
    global $db;
    global $global_config_arr;

    if (isset ($_GET['design_id']) AND $global_config_arr[allow_other_designs] == 1)
    {
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."template WHERE id = $_GET[design_id]", $db);
        if (mysql_num_rows($index) > 0)
        {
            $global_config_arr[design] =  $_GET['design_id'];
            settype($global_config_arr[design], "integer");
        }
    }
    elseif (isset ($_GET['design']) AND $global_config_arr[allow_other_designs] == 1)
    {
        $index = mysql_query("SELECT id FROM ".$global_config_arr[pref]."template WHERE name = '$_GET[design]'", $db);
        if (mysql_num_rows($index) > 0)
        {
            $global_config_arr[design] =  mysql_result($index, "id");
            settype($global_config_arr[design], "integer");
        }
    }

    if (isset ($_GET['zone_id']) AND $global_config_arr[allow_other_designs] == 1)
    {
        $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."zones WHERE id = $_GET[zone_id]", $db);
        if (mysql_num_rows($index) > 0)
        {
            $global_config_arr[design] =  $_GET['design_id'];
            settype($global_config_arr[design], "integer");
        }
    }
    elseif (isset ($_GET['zone']) AND $global_config_arr[allow_other_designs] == 1)
    {
        $index = mysql_query("SELECT design_id FROM ".$global_config_arr[pref]."zones WHERE name = '$_GET[zone]'", $db);
        if (mysql_num_rows($index) > 0)
        {
            $global_config_arr[design] =  mysql_result($index2, "design_id");
            settype($global_config_arr[design], "integer");
        }
    }
    
    copyright();
}

///////////////////////////////////
//// copyright security check  ////
///////////////////////////////////
function copyright ()
{
    global $db;
    global $global_config_arr;

	if ( strpos ( get_template ( "indexphp" ), "{copyright}" ) == FALSE
			|| strpos ( get_copyright (), "Frogsystem 2" ) == FALSE || strpos ( get_copyright (), "&copy; 2007, 2008 Frogsystem-Team" ) == FALSE
			|| strpos ( get_copyright (), "Powered by" ) == FALSE  || strpos ( get_copyright (), "frogsystem.de" ) == FALSE) {
        $global_config_arr[design] =  0;
    }
}
?>