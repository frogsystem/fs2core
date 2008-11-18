<?php
// Start Session
session_start();

// fs2 include path
set_include_path ( '.' );
define ( FS2_ROOT_PATH, "./", TRUE );

// Inlcude DB Connection File
require( FS2_ROOT_PATH . "login.inc.php");

//////////////////////////////////
//// DB Connection etablished ////
//////////////////////////////////
if ($db)
{
	//Include DL Catch
	require( FS2_ROOT_PATH . "res/dl.inc.php");
    
    //Include Functions-Files
    require( FS2_ROOT_PATH . "includes/functions.php");
    require( FS2_ROOT_PATH . "includes/cookielogin.php");
    require( FS2_ROOT_PATH . "includes/imagefunctions.php");
    require( FS2_ROOT_PATH . "includes/indexfunctions.php");

	//Include Phrases-Files
    require( FS2_ROOT_PATH . "phrases/phrases_".$global_config_arr['language'].".php");

	// Constructor Calls
	delete_old_randoms ();
	set_design ();
	copyright ();
	get_goto ( $_GET['go'] );
	count_all ( $global_config_arr['goto'] );
	save_referer ();
	save_visitors ();

	// Create Index-Template
	$template_index = get_template ( "indexphp" );
	$template_index = str_replace ( "{main_menu}", get_mainmenu (), $template_index );
	$template_index = str_replace ( "{content}", get_content ( $global_config_arr['goto'] ), $template_index );
	$template_index = str_replace ( "{copyright}", get_copyright (), $template_index );
	$template_index = replace_resources ( $template_index );
	$template_index = veraltet_includes ( $template_index ); // wird später zu seitenvariablen funktion, mit virtualhost umwandlung
	$template_index = str_replace ( "{virtualhost}", $global_config_arr['virtualhost'], $template_index );
	//$template_index = killbraces ( $template_index );
	
	// Get Main Template
	$template = get_maintemplate ();
	$template = str_replace ( "{body}", $template_index, $template);

	// Display Page
	echo $template;

	// Close Connection
	mysql_close ( $db );
}

//////////////////////////////
//// DB Connection failed ////
//////////////////////////////
else
{
	// Include German Phrases
	require( FS2_ROOT_PATH . "phrases/phrases_de.php");

	// No-Connection-Page Template
	$template = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>'.$phrases[no_connection].'</title>
	</head>
	<body>
		<b>'.$phrases[no_con_title].'</b>
	</body>
</html>
	';

	// Display No-Connection-Page
	echo $template;
}
?>