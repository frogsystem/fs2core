<?php

/////////////////////////
//// Create Articles ////
/////////////////////////

// Load Article Config
$FD->loadConfig('articles');

if ($FD->cfg('goto') == 'articles') {

    // Load Article Data from DB
    $article_arr = $FD->sql()->getById('articles', '*', $_GET['id'], 'article_id');

    // Set canonical parameters
    $FD->setConfig('info', 'canonical', array('id'));

} else {

    // Load Article Data from DB
    $article_arr = $FD->sql()->getRow('articles', '*', array(
        'W' => "`article_url` = '".$FD->cfg('goto')."'", 
        'O' => "`article_id`"));

    // Set canonical parameters
    $FD->setConfig('info', 'canonical', array());
}


// Article doesn't exist
if (empty($article_arr)) {
    $article_arr['template'] = sys_message($FD->text('frontend', 'systemmessage'), $FD->text('frontend', 'article_not_found'), 404 );
}

// Article exists
else {

    // check for article_url parameter
    if (!empty($article_arr['article_url'])) {
        // Set canonical parameters
        $FD->setConfig('info', 'canonical', array());
        // Set goto
        $FD->setConfig('main', 'goto', unslash($article_arr['article_url']));
    }

    // Security Functions
    settype ( $article_arr['article_user'], 'integer' );

    // Get User & Create User Template
    $user_arr = $FD->sql()->getById('user', array('user_id', 'user_name'), $article_arr['article_user'], 'user_id');
    
    // User exists
    if (!empty($user_arr)) {

        settype($user_arr['user_id'], 'integer');
        $user_arr['user_name'] = kill_replacements($user_arr['user_name'], TRUE);
        $user_arr['user_url'] = url('user', array('id' => $user_arr['user_id']));

        // Create Template
        $author_template = new template();
        $author_template->setFile ('0_articles.tpl');
        $author_template->load('AUTHOR');

        $author_template->tag('user_id', $user_arr['user_id']);
        $author_template->tag('user_name', $user_arr['user_name']);
        $author_template->tag('user_url', $user_arr['user_url']);

        $article_arr['author_template'] = $author_template->display();
        
    } else {
        $article_arr['author_template'] = '';
        $user_arr['user_id'] = '';
        $user_arr['user_name'] = '';
        $user_arr['user_url'] = '';
    }

    // Get Date & Create Date Template
    if ($article_arr['article_date'] != 0) {
        $article_arr['date_formated'] = date_loc($FD->cfg('date'), $article_arr['article_date']);
        
        // Create Template
        $date_template = new template();
        $date_template->setFile ('0_articles.tpl');
        $date_template->load ('DATE');
        $date_template->tag ('date', $article_arr['date_formated']);
        $article_arr['date_template'] = $date_template->display();
    } else {
        $article_arr['date_formated'] = '';
        $article_arr['date_template'] = '';
    }

    // Format Article-Text
    $parseflags = array(
        'fscode' => (bool)$article_arr['article_fscode'] ,
        'nofscodeatall' => !oneof($FD->cfg('articles', 'fs_code'), 2, 4),
        'html' => (bool)$article_arr['article_html'],
        'nohtmlatall' => !oneof($FD->cfg('articles', 'html_code'), 2, 4),
        'paragraph' => ($article_arr['article_para'] && oneof($FD->cfg('articles', 'para_handling'), 2, 4)),
    );
    $article_arr['article_text'] = parse_all_fscodes($article_arr['article_text'], $parseflags);
    $article_arr['article_title'] = unslash($article_arr['article_title']);

    // Create Template
    $article_arr['template'] = new template();
    $article_arr['template']->setFile ( '0_articles.tpl' );
    $article_arr['template']->load ( 'BODY' );

    $article_arr['template']->tag ( 'title', $article_arr['article_title'] );
    $article_arr['template']->tag ( 'text', $article_arr['article_text'] );
    $article_arr['template']->tag ( 'date_template', $article_arr['date_template'] );
    $article_arr['template']->tag ( 'date', $article_arr['date_formated'] );
    $article_arr['template']->tag ( 'author_template', $article_arr['author_template'] );
    $article_arr['template']->tag ( 'user_id', $user_arr['user_id'] );
    $article_arr['template']->tag ( 'user_name', $user_arr['user_name'] );
    $article_arr['template']->tag ( 'user_url', $user_arr['user_url'] );

    $article_arr['template'] = $article_arr['template']->display ();

    // Dynamic Title Settings
    $FD->setConfig('info', 'page_title', $article_arr['article_title']);
    $FD->setConfig('info', 'content_author', unslash($user_arr['user_name']));
}

// Display Template
$template = $article_arr['template'];
?>
