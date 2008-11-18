<?php
///////////////////////////
//// Replace Resources ////
///////////////////////////
function veraltet_includes ( $template_index )
{
	global $global_config_arr;
	global $db;

		// Veraltet!!!
		//Includes
		$index = mysql_query("select * from ".$global_config_arr[pref]."includes where include_type = '2'", $db);
		while ($include_arr = mysql_fetch_assoc($index))
		{
		    // Include laden
		    include( FS2_ROOT_PATH . "res/".$include_arr['replace_thing']);
		    $template_include = $template;
		    unset($template);

		    //Seitenvariablen
			$index2 = mysql_query("select replace_string, replace_thing from ".$global_config_arr[pref]."includes where include_type = '1' ORDER BY replace_string ASC", $db);
			while ($sv_arr = mysql_fetch_assoc($index2))
		    {
		        // Include-URL laden
		        $sv_arr['replace_thing'] = killsv($sv_arr['replace_thing']);
		        $template_include = str_replace($sv_arr['replace_string'], stripslashes($sv_arr['replace_thing']), $template_include);
		    }
		    unset($sv_arr);
		    $template_include = killsv($template_include);
		    $template_index = str_replace($include_arr['replace_string'], $template_include, $template_index);
		    unset($template_include);
		}
		unset($include_arr);

		//Seitenvariablen
		$index = mysql_query("select replace_string, replace_thing from ".$global_config_arr[pref]."includes where include_type = '1' ORDER BY replace_string ASC", $db);
		while ($sv_arr = mysql_fetch_assoc($index))
		{
		    // Include-URL laden
		    $sv_arr['replace_thing'] = killsv($sv_arr['replace_thing']);
		    $template_index = str_replace($sv_arr['replace_string'], stripslashes($sv_arr['replace_thing']), $template_index);
		}
		unset($sv_arr);

		// Veraltet Ende!
		
	return $template_index;
}


///////////////////////////
//// get Main-Template ////
///////////////////////////
function get_maintemplate ( $PATH_PREFIX = "" )
{
	global $global_config_arr;
    global $db;

	// Main Template
	$template = '
{doctype}
<html>
	<head>
		{title}{meta}{link}{script}
	</head>

    {body}
</html>
';

	// Create link-Rows
	$template_link = "";
	if ( $global_config_arr['show_favicon'] == 1 ) {
		$template_link .= '
		<link rel="shortcut icon" href="images/icons/favicon.ico">';
	}
	$template_link .= '
		<link rel="stylesheet" type="text/css" href="'.$PATH_PREFIX .'style_css.php?id='.$global_config_arr['design'].'">
		<link rel="stylesheet" type="text/css" href="'.$PATH_PREFIX .'editor_css.php?id='.$global_config_arr['design'].'">
		<link rel="alternate" type="application/rss+xml" href="'.$PATH_PREFIX .'feeds/'.$global_config_arr['feed'].'.php" title="'.$global_config_arr['title'].' News Feed">';

	// Create script-Rows
    $template_script = "";
	$template_script .= '
		<script type="text/javascript" src="'.$PATH_PREFIX .'res/js_functions.js"></script>
		<script type="text/javascript" src="'.$PATH_PREFIX .'res/js_userfunctions.php?id='.$global_config_arr['design'].'"></script>';

	// Replace Placeholders
	$template = str_replace("{doctype}", get_template ( "doctype" ), $template);
	$template = str_replace("{title}", "<title>".$global_config_arr['title']."</title>", $template);
	$template = str_replace("{meta}", get_meta (), $template);
	$template = str_replace("{link}", $template_link, $template);
	$template = str_replace("{script}", $template_script, $template);

	// Return Template
	return $template;
}


///////////////////////
//// get META-Tags ////
///////////////////////
function get_meta ()
{
	global $global_config_arr;

	$keyword_arr = explode ( ",", $global_config_arr['keywords'] );
	foreach ( $keyword_arr as $key => $value ) {
	    $keyword_arr[$key] = trim ( $value );
	}
    $keywords = implode ( ", ", $keyword_arr );

	$template = '
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta name="DC.Identifier" content="'.$global_config_arr['virtualhost'].'">
		<meta name="DC.Creator" content="'.$global_config_arr['author'].'">
		<meta name="DC.Description" content="'.$global_config_arr['description'].'">
		<meta name="DC.Language" content="'.$global_config_arr['language'].'">
		<meta name="title" content="'.$global_config_arr['title'].'">
		<meta name="keywords" content="'.$keywords.'">
		<meta name="robots" content="index,follow">
		<meta name="Revisit-after" content="3 days">
		<meta name="generator" content="Frogsystem 2 [http://www.frogsystem.de]">';

	return $template;
}


/////////////////////
//// get Content ////
/////////////////////
function get_content ( $GOTO )
{
    global $global_config_arr;
    global $db;
    global $phrases;

	$index = mysql_query ( "SELECT COUNT(article_id) AS 'number' FROM ".$global_config_arr['pref']."articles WHERE article_url = '".$GOTO."'", $db );

	// Display Content
	if ( file_exists ( "data/".$GOTO.".php" ) ) {
		include ( FS2_ROOT_PATH . "data/".$GOTO.".php" );
	} elseif ( mysql_result ( $index, 0, "number") >= 1 ) {
		include ( FS2_ROOT_PATH . "data/articles.php" );
	} else {
		include ( FS2_ROOT_PATH . "data/404.php" );
	}

	// Replace Virtualhost & Kill Resources
	$template = killbraces($template);

	// Return Content
	return $template;
}


///////////////////////
//// get main menu ////
///////////////////////
function get_mainmenu ( $PATH_PREFIX = "" )
{
	global $global_config_arr;
    global $db;

	$template = get_template ( "main_menu" );
	$template = replace_resources ( $template, $PATH_PREFIX  );
	$template = killbraces($template);
	return $template;
}

///////////////////////////
//// Replace Resources ////
///////////////////////////
function replace_resources ( $TEMPLATE, $PATH_PREFIX = "" )
{
	global $global_config_arr;
	global $db;

	// Load Resources from DB
	$index = mysql_query ( "
							SELECT *
							FROM ".$global_config_arr['pref']."resources
	", $db );

	// Write Resources into Array & get Resource Template
	for ( $i = 0; $result = mysql_fetch_assoc ( $index ); $i++ ) {
        $resources_arr[$i]['id'] = $result['id'];
        $resources_arr[$i]['resource_name'] = $result['resource_name'];
        $resources_arr[$i]['resource_file'] = $result['resource_file'];
        $resources_arr[$i]['hardcoded'] = $result['hardcoded'];
        $resources_arr[$i]['template'] = get_resource ( $PATH_PREFIX."res/".$result['resource_file'] );
	}

	// Replace Resources in $TEMPLATE
	foreach ( $resources_arr as $resource ) {
		$TEMPLATE = str_replace ( "{".$resource['resource_name']."}",  $resource['template'], $TEMPLATE );
	}

	// Return Content
	return $TEMPLATE;
}


//////////////////////
//// get resource ////
//////////////////////
function get_resource ( $FILE )
{
    global $global_config_arr;
    global $db;

	include( FS2_ROOT_PATH . $FILE );
	$template = killbraces ( $template );
	return $template;
}


///////////////////
//// get $goto ////
///////////////////
function get_goto ( $GETGO )
{
    global $global_config_arr;
    global $db;

	// Check $_GET['go']
	if ( !isset( $GETGO ) || $GETGO == "" ) {
		$goto = $global_config_arr['home_real'];
	} else {
		$goto = savesql ( $GETGO ) ;
	}

	// Forward Aliases
	$goto = forward_aliases ( $goto );

	// write $goto into $global_config_arr['goto']
	$global_config_arr['goto'] = $goto;
}


/////////////////////////
//// forward aliases ////
/////////////////////////
function forward_aliases ( $GOTO )
{
    global $global_config_arr;
    global $db;

    $index = mysql_query ( "
							SELECT *
							FROM ".$global_config_arr['pref']."aliases
	", $db );
	
	while ( $aliases_arr = mysql_fetch_assoc ( $index ) ) {
		if ( $GOTO == $aliases_arr['alias_go'] ) {
            $GOTO = $aliases_arr['alias_forward_to'];
		}
	}
	
	return $GOTO;
}

///////////////////
//// count hit ////
///////////////////
function count_all ( $GOTO )
{
    global $db;
    global $global_config_arr;

    $hit_year = date ( "Y" );
    $hit_month = date ( "m" );
    $hit_day = date ( "d" );

    visit_day_exists ( $hit_year, $hit_month, $hit_day );
	count_hit ( $GOTO );
	count_visit ( $GOTO );
}

///////////////////////////////////
//// check if visit day exists ////
///////////////////////////////////
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
        mysql_query("DELETE FROM ".$global_config_arr['pref']."iplist", $db );
    }
}


///////////////////
//// count hit ////
///////////////////
function count_hit ( $GOTO )
{
    global $db;
    global $global_config_arr;

    $hit_year = date ( "Y" );
    $hit_month = date ( "m" );
    $hit_day = date ( "d" );

	if ( $GOTO != "404" && $GOTO != "403" ) {
		// count page_hits
	    mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET hits = hits + 1", $db );
	    mysql_query ( "UPDATE ".$global_config_arr['pref']."counter_stat
	                   SET s_hits = s_hits + 1
	                   WHERE s_year = ".$hit_year." AND s_month = ".$hit_month." AND s_day = ".$hit_day."", $db );
	}
}


/////////////////////
//// count visit ////
/////////////////////
function count_visit ( $GOTO )
{
    global $db;
    global $global_config_arr;

    $time = time ();             // timestamp
    $counttime = "86400";       // time to save IPs (1 day = 86400)
    $visit_year = date ( "Y" );
    $visit_month = date(  "m" );
    $visit_day = date ( "d" );
    
	// check if errorpage
	if ( $GOTO != "404" && $GOTO != "403" ) {
		// save IP & visit
	    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."iplist WHERE ip = '".$_SERVER['REMOTE_ADDR']."'", $db );

	    if ( mysql_num_rows ( $index ) <= 0 ) {
	        mysql_query ( "UPDATE ".$global_config_arr['pref']."counter SET visits = visits + 1", $db );
	        mysql_query ( "UPDATE ".$global_config_arr['pref']."counter_stat
	                       SET s_visits = s_visits + 1
	                       WHERE s_year = ".$visit_year." AND s_month = ".$visit_month." AND s_day = ".$visit_day."", $db );
	        mysql_query ( "INSERT INTO ".$global_config_arr['pref']."iplist (`ip`) VALUES ('".savesql($_SERVER['REMOTE_ADDR'])."')", $db );
	    }
	}
}


///////////////////////
//// save visitors ////
///////////////////////
function save_visitors ()
{
    global $db;
    global $global_config_arr;

    $time = time(); // timestamp
    $ip = $_SERVER['REMOTE_ADDR']; // IP-Adress

	// get user_id or set user_id=0
	if ( isset ( $_SESSION['user_id'] ) && $_SESSION['user_level'] == "loggedin" ) {
	    $user_id = $_SESSION['user_id'];
	    settype ( $user_id, "integer");
	} else {
	    $user_id = 0;
	}

    // delete offline users
    mysql_query ( "DELETE FROM ".$global_config_arr['pref']."useronline WHERE date < (".$time." - 300)", $db );
    
    // save online users
    $index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."useronline WHERE ip='".$_SERVER['REMOTE_ADDR']."'", $db );

	// update existing users
	if ( mysql_num_rows ( $index ) >= 1 && mysql_result ( $index, 0, "user_id" ) != $user_id ) {
        mysql_query ( "UPDATE ".$global_config_arr['pref']."useronline SET user_id = '".$user_id."' WHERE ip = '".$ip."'", $db );
    }
	if ( mysql_num_rows ( $index ) >= 1 ) {
        mysql_query ( "UPDATE ".$global_config_arr['pref']."useronline SET date = '".$time."' WHERE ip='".$ip."'", $db );
    } else {
        mysql_query ( "INSERT INTO ".$global_config_arr['pref']."useronline (ip, user_id, date) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$user_id."', '".$time."')", $db );
    }
}


//////////////////////
//// save referer ////
//////////////////////
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


///////////////////////////////
//// del old timed randoms ////
///////////////////////////////
function delete_old_randoms ()
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


///////////////////////////////
//// create copyright note ////
///////////////////////////////
function get_copyright ()
{
	return '<span class="small">Powered by <a class="small" href="http://www.frogsystem.de" target="_blank">Frogsystem 2</a> &copy; 2007, 2008 Frogsystem-Team</span>';
}


////////////////////////
/// Designs & Zones ////
////////////////////////
function set_design ()
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
    
    copyright ();
}


//////////////////////////////////
//// copyright security check ////
//////////////////////////////////
function copyright ()
{
    global $db;
    global $global_config_arr;

	if ( strpos ( get_template ( "indexphp" ), "{copyright}" ) == FALSE
			|| strpos ( get_copyright (), "Frogsystem 2" ) == FALSE || strpos ( get_copyright (), "&copy; 2007, 2008 Frogsystem-Team" ) == FALSE
			|| strpos ( get_copyright (), "Powered by" ) == FALSE  || strpos ( get_copyright (), "frogsystem.de" ) == FALSE) {
        $global_config_arr['design'] =  0;
    }
}
?>