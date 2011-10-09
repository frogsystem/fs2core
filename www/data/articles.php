<?php

/////////////////////////
//// Create Articles ////
/////////////////////////

// Load Article Config
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."articles_config", $FD->sql()->conn() );
$config_arr = mysql_fetch_assoc ( $index );

if ($global_config_arr['goto'] == "articles") {
    
    settype($_GET['id'], "integer");
    
     // Load Article Data from DB
    $index = mysql_query ( "
                            SELECT *
                            FROM `".$global_config_arr['pref']."articles`
                            WHERE `article_id` = '".$_GET['id']."'
                            ORDER BY `article_id`
                            LIMIT 0,1
    ", $FD->sql()->conn() ); 
    
    // Set canonical parameters
    $FD->setConfig('info', 'canonical', array('id'));
    
} else {
 
    // Load Article Data from DB
    $index = mysql_query ( "
                            SELECT *
                            FROM `".$global_config_arr['pref']."articles`
                            WHERE `article_url` = '".$_GET['go']."'
                            ORDER BY `article_id`
                            LIMIT 0,1
    ", $FD->sql()->conn() );
    
    // Set canonical parameters
    $FD->setConfig('info', 'canonical', array());
}


// Article doesn't exist
if ( mysql_num_rows ( $index ) != 1 ) {
    $article_arr['template'] = sys_message ( $TEXT['frontend']->get("systemmessage"), $TEXT['frontend']->get("article_not_found"), 404 );
}

// Article exists
else
{
    // Get Aricle Data
    $article_arr = mysql_fetch_assoc ( $index );
    
    // check for article_url parameter
    if (!empty($article_arr['article_url'])) {
        // Set canonical parameters
        $FD->setConfig('info', 'canonical', array());
        // Set goto
        $FD->setConfig('main', 'goto', unslash($article_arr['article_url']));
    }

    // Security Functions
    settype ( $article_arr['article_user'], "integer" );

    // Get User & Create User Template
    $index = mysql_query ( "
                            SELECT `user_id`, `user_name`
                            FROM `".$global_config_arr['pref']."user`
                            WHERE `user_id` = '".$article_arr['article_user']."'
                            LIMIT 0,1
    ", $FD->sql()->conn() );
    // User exists
    if ( mysql_num_rows ( $index ) == 1 ) {
        // Get User Data
        $user_arr = mysql_fetch_assoc ( $index );

        settype ( $user_arr['user_id'], "integer" );
        $user_arr['user_name'] = kill_replacements ( $user_arr['user_name'], TRUE );
        $user_arr['user_url'] = url("user", array('id' => $user_arr['user_id']));
        
        // Create Template
        $author_template = new template();
        $author_template->setFile ( "0_articles.tpl" );
        $author_template->load ( "AUTHOR" );
        
        $author_template->tag ( "user_id", $user_arr['user_id'] );
        $author_template->tag ( "user_name", $user_arr['user_name'] );
        $author_template->tag ( "user_url", $user_arr['user_url'] );

        $article_arr['author_template'] = $author_template->display ();
    } else {
        $article_arr['author_template'] = "";
        $user_arr['user_id'] = "";
        $user_arr['user_name'] = "";
        $user_arr['user_url'] = "";
    }

    // Get Date & Create Date Template
    if ( $article_arr['article_date'] != 0 ) {
        $article_arr['date_formated'] = date_loc ( $global_config_arr['date'], $article_arr['article_date'] );
        // Create Template
        $date_template = new template();
        $date_template->setFile ( "0_articles.tpl" );
        $date_template->load ( "DATE" );
        $date_template->tag ( "date", $article_arr['date_formated'] );
        $article_arr['date_template'] = $date_template->display ();
    } else {
        $article_arr['date_formated'] = "";
        $article_arr['date_template'] = "";
    }

    // Create FSCode, HTML & Para Boolean-Values
    $article_arr['fscode_bool'] = $article_arr['article_fscode'] && ( $config_arr['fs_code'] == 2 || $config_arr['fs_code'] == 4 );
    $article_arr['html_bool'] = $article_arr['article_html'] && ( $config_arr['html_code'] == 2 || $config_arr['html_code'] == 4 );
    $article_arr['para_bool'] = $article_arr['article_para'] && ( $config_arr['para_handling'] == 2 || $config_arr['para_handling'] == 4 );

    // Format Article-Text
    $article_arr['article_text'] = fscode ( $article_arr['article_text'], $article_arr['fscode_bool'], $article_arr['html_bool'], $article_arr['para_bool'] );
    $article_arr['article_title'] = stripslashes ( $article_arr['article_title'] );

    // Create Template
    $article_arr['template'] = new template();
    $article_arr['template']->setFile ( "0_articles.tpl" );
    $article_arr['template']->load ( "BODY" );
    
    $article_arr['template']->tag ( "title", $article_arr['article_title'] );
    $article_arr['template']->tag ( "text", $article_arr['article_text'] );
    $article_arr['template']->tag ( "date_template", $article_arr['date_template'] );
    $article_arr['template']->tag ( "date", $article_arr['date_formated'] );
    $article_arr['template']->tag ( "author_template", $article_arr['author_template'] );
    $article_arr['template']->tag ( "user_id", $user_arr['user_id'] );
    $article_arr['template']->tag ( "user_name", $user_arr['user_name'] );
    $article_arr['template']->tag ( "user_url", $user_arr['user_url'] );

    $article_arr['template'] = $article_arr['template']->display ();
    
    // Dynamic Title Settings
    $global_config_arr['dyn_title_page'] = $article_arr['article_title'];
    $global_config_arr['content_author'] = stripslashes ( $user_arr['user_name'] );
}

// Display Template
$template =  $article_arr['template'];
?>
