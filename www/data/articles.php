<?php
/////////////////////////
//// Create Articles ////
/////////////////////////

// Load Article Config
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_config", $db);
$config_arr = mysql_fetch_assoc ( $index );

// Get article_id from artcle_url
if ( $_GET['go'] != "articles" ) {
    $_GET['go'] = savesql ( $_GET['go'] );
	$index = mysql_query ( "SELECT article_id FROM ".$global_config_arr['pref']."articles WHERE article_url = '".$_GET['go']."' LIMIT 0,1", $db );
	$_GET['id'] = mysql_result( $index, 0, "article_id" );
}

// Create $_GET['id'] if not exists
if ( !isset ( $_GET['id'] ) ) {
	$_GET['id'] = 0;
}

// Security-Functions for $_GET-Vars
settype ( $_GET['id'], "integer" );

// Check if Artilce exists
$index = mysql_query ( "SELECT COUNT(article_id) AS 'number' FROM ".$global_config_arr['pref']."articles WHERE article_id = '".$_GET['id']."' LIMIT 0,1", $db);

// Article not exists
if ( mysql_result ( $index, 0, "number" ) < 1 ) {
	$article_arr['template'] = sys_message ( $phrases[sysmessage], $phrases[article_not_found] );
}

// Article exists
else
{

	// Load Article Data from DB
	$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles WHERE article_id = '".$_GET['id']."' LIMIT 0,1", $db );
	$article_arr = mysql_fetch_assoc ( $index );

	// Get User & Create User Template
	$index = mysql_query ( "SELECT user_id, user_name FROM ".$global_config_arr['pref']."user WHERE user_id = '".$article_arr['article_user']."' LIMIT 0,1", $db);
	if ( mysql_num_rows ( $index ) == 1 ) {
    	$user_arr = mysql_fetch_assoc ( $index );
    	$user_arr['user_link'] = '?go=profil&userid='.$user_arr['user_id'];

    	$user_arr['template'] = get_template ( "artikel_autor" );
	    $user_arr['template'] = str_replace ( "{profile_url}", $user_arr['user_link'], $user_arr['template'] );
    	$user_arr['template'] = str_replace ( "{user_name}", $user_arr['user_name'], $user_arr['template'] );
    	$user_arr['template'] = str_replace ( "{user_id}", $user_arr['user_id'], $user_arr['template'] );
	}

	// Create Article-Date
	if ( $article_arr['article_date'] != 0 ) {
	    $article_arr['article_date_formated'] = date ( $global_config_arr['date'], $article_arr['article_date'] );
	} else {
	    $article_arr['article_date_formated'] = "";
	}

	// Create FSCode, HTML & Para Boolean-Values
	$article_arr['fscode_bool'] = $article_arr['article_fscode'] && ( $config_arr['fs_code'] == 2 || $config_arr['fs_code'] == 4 );
	$article_arr['html_bool'] = $article_arr['article_html'] && ( $config_arr['html_code'] == 2 || $config_arr['html_code'] == 4 );
	$article_arr['para_bool'] = $article_arr['article_para'] && ( $config_arr['para_handling'] == 2 || $config_arr['para_handling'] == 4 );

	// Format Article-Text
	$article_arr['article_text'] = fscode ( $article_arr['article_text'], $article_arr['fscode_bool'], $article_arr['html_bool'], $article_arr['para_bool'] );

	// Create Template
	$article_arr['template'] = get_template ( "artikel_body" );
	$article_arr['template'] = str_replace ( "{title}", $article_arr['article_title'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{date}", $article_arr['article_date_formated'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{text}", $article_arr['article_text'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{user_name}", $user_arr['user_name'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{user_id}", $user_arr['user_id'], $article_arr['template'] );
	$article_arr['template'] = str_replace ( "{author_template}", $user_arr['template'], $article_arr['template'] );

}

// Display Template
$template =  $article_arr['template'];
?>