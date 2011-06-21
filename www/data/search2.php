<?php
###################
## Page Settings ##
###################
$news_cols = array("news_id", "news_title", "news_date");
$config_cols = array("search_num_previews");
$config_arr = $sql->getById("search_config", $config_cols, 1);


// Security Functions
$_REQUEST['in_news'] = (isset($_REQUEST['in_news']) && $_REQUEST['in_news'] == 1) ? true : false;
$_REQUEST['in_articles'] = (isset($_REQUEST['in_articles']) && $_REQUEST['in_articles'] == 1) ? true : false;
$_REQUEST['in_downloads'] = (isset($_REQUEST['in_downloads']) && $_REQUEST['in_downloads'] == 1) ? true : false;
$_REQUEST['keyword'] = (isset($_REQUEST['keyword'])) ? trim($_REQUEST['keyword']) : "";


// Check if search will be done
if (empty($_REQUEST['keyword'])) { // keyword empty => no search
    $_REQUEST['in_news'] = true; // set true for default checked checkboxes
    $_REQUEST['in_articles'] = true;
    $_REQUEST['in_downloads'] = true;
  
// There is a search
} else {
	
    // Set Dynamic Title
    $global_config_arr['dyn_title_page'] = $TEXT['frontend']->get("download_search_for") . ' "' . usersave($_REQUEST['keyword']) . '"';

	// More Results Template
	$more_results_template = new template();
	$more_results_template->setFile("0_search.tpl");
	$more_results_template->load("MORE_RESULTS");

	// No Results Template
	$no_results_template = new template();
	$no_results_template->setFile("0_search.tpl");
	$no_results_template->load("NO_RESULTS");
	$no_results_template = $no_results_template->display ();


	// Create SearchQuery
	$sq = new SearchQuery($_REQUEST['keyword']);

	// Create News Search
	if ($_REQUEST['in_news']) {
		// do the search
		$search = new Search("news", $sq);
		
		//run through results
		initstr($news_entries); $num = 0;
		while($found = $search->next() && $config_arr['search_num_previews'] > $num) {
			/*$found['id']
			$found['type']
			$found['matches']*/
			
			// get data for entrie
			$news = $sql->getRow("news", $news_cols, array(
				'W' => "`news_id` = ".$found['id']." AND `news_date` <= ".time()." AND `news_active` = 1"
			));
			
			// entry is ok
			if (!empty($news)) {
				$num++;

				// load template
				$template = new template();
				$template->setFile("0_search.tpl");

				// data
				$date_formated = date_loc($global_config_arr['date'], $news['news_date']);
				if ($news['news_date'] != 0) {
					// Get Date Template
					$template->load("RESULT_DATE_TEMPLATE");
					$template->tag("date", $date_formated);
					$date_template = (string) $template;
				} else {
					initstr($date_template);
				}
				
				// entry
				$template->load("RESULT_LINE");
				$template->tag("id", $news['news_id']);
				$template->tag("title", $news['news_title']);
				$template->tag("url", "?go=comments&amp;id=".$news['news_id']);
				$template->tag("date", $date_formated);
				$template->tag("date_template", $date_template);
				$template->tag("num_matches", $found['matches']);

				$news_entries .= (string) $template;		
			}
		}
		
		
	} //endnewssearch


 else {
    $news_entries = $no_results_template;
    $news_num_results = 0;
    $news_more = "";
}

// Get Articles Entries
if ( isset ( $results_arr['articles'] ) ) {
    // Security Function
    $articles_entries = "";
    $replace_arr = array();
    
    // Get max. num of data sets to select
    $num_data_sets = min ( $config_arr['search_num_previews'], count ( $results_arr['articles'] ) );
    $num_data_sets = count ( $results_arr['articles'] ); // Remove Line when articles_search implemented

    // Get Data from DB
    $index = mysql_query ( "
                            SELECT `article_id`, `article_url`, `article_title`, `article_date`
                            FROM `".$global_config_arr['pref']."articles`
                            WHERE `article_id` IN(" . implode ( ",", get_id_list_from_result_arr ( $results_arr['articles'], $num_data_sets  ) ) . ")
                            ORDER BY `article_date` DESC
    ", $db );
    while ( $data_arr = mysql_fetch_assoc ( $index ) ) {
        settype ( $data_arr['news_id'], "integer" );
        $article_arr['article_url'] = ( $article_arr['article_url'] == "" ) ? "articles&amp;id=".$article_arr['article_id'] : stripslashes ( $article_arr['article_url'] );
        $replace_arr[] = array (
            "id" => $data_arr['article_id'],
            "title" => $data_arr['article_title'],
            "url" => $data_arr['article_url'],
            "date" => $data_arr['article_date'],
            "num_results" => $results_arr['articles'][$data_arr['article_id']],
        );
    }
    
    // Sort Data Array by Counter and Date
    $replace_arr = sort_replace_arr ( $replace_arr );
    
    // Get More Results Template
    if ( count ( $replace_arr ) > $config_arr['search_num_previews'] ) {
        $articles_more = $more_results_template;
        $articles_more->tag("main_search_url", "?go=articles_search&amp;keyword=".implode ( "+", $keyword_arr ) );
        $articles_more = $articles_more->display ();
    } else {
        $articles_more = "";
    }
    $articles_more = ""; // Remove Line when articles_search implemented

    // Create Template for Entries
    $articles_num_results = 0;
    for ( $i = 0; $i < min ( $num_data_sets, count ( $replace_arr ) ); $i++ ) {
        $data = $replace_arr[$i];
        $date_formated = date_loc ( $global_config_arr['date'], $data['date'] );

        if ( $data['date'] != 0 ) {
            // Get Date Template
            $template = new template();
            $template->setFile("0_search.tpl");
            $template->load("RESULT_DATE_TEMPLATE");
            $template->tag("date", $date_formated );
            $date_template = $template->display ();
        } else {
            $date_template = "";
        }

        // Get Template
        $template = new template();
        $template->setFile("0_search.tpl");
        $template->load("RESULT_LINE");

        $template->tag("id", $data['id'] );
        $template->tag("title", stripslashes ( $data['title'] ) );
        $template->tag("url", "?go=" . $data['url'] );
        $template->tag("date", $date_formated );
        $template->tag("date_template", $date_template );
        $template->tag("num_matches", $data['num_results'] );

        $articles_entries .= $template->display ();
        $articles_num_results = $i;
    }
    $articles_entries = ( count ( $replace_arr ) >= 1 ) ? $articles_entries : $no_results_template;
    $articles_num_results++;
} else {
    $articles_entries = $no_results_template;
    $articles_num_results = 0;
    $articles_more = "";
}


// Get Download Entries
if ( isset ( $results_arr['dl'] ) ) {
    // Security Function
    $downloads_entries = "";
    $replace_arr = array();
    
    // Get max. num of data sets to select
    $num_data_sets = min ( $config_arr['search_num_previews'], count ( $results_arr['dl'] ) );

    // Get Data from DB
    $index = mysql_query ( "
                            SELECT `dl_id`, `dl_name`, `dl_date`
                            FROM `".$global_config_arr['pref']."dl`
                            WHERE `dl_id` IN(" . implode ( ",", get_id_list_from_result_arr ( $results_arr['dl'], $num_data_sets  ) ) . ")
                            AND `dl_open` = 1
                            ORDER BY `dl_date` DESC
    ", $db );
    while ( $data_arr = mysql_fetch_assoc ( $index ) ) {
        settype ( $data_arr['dl_id'], "integer" );
        $replace_arr[] = array (
            "id" => $data_arr['dl_id'],
            "title" => $data_arr['dl_name'],
            "date" => $data_arr['dl_date'],
            "num_results" => $results_arr['dl'][$data_arr['dl_id']],
        );
    }

    // Sort Data Array by Counter and Date
    $replace_arr = sort_replace_arr ( $replace_arr );

    // Get More Results Template
    if ( count ( $replace_arr ) > $config_arr['search_num_previews'] ) {
        $downloads_more = $more_results_template;
        $downloads_more->tag("main_search_url", "?go=download&amp;cat_id=all&amp;keyword=".implode ( "+", $keyword_arr ) );
        $downloads_more = $downloads_more->display ();
    } else {
        $downloads_more = "";
    }

    // Create Template for Entries
    $downloads_num_results = 0;
    for ( $i = 0; $i < min ( $num_data_sets, count ( $replace_arr ) ); $i++ ) {
        $data = $replace_arr[$i];
        $date_formated = date_loc ( $global_config_arr['date'], $data['date'] );

        if ( $data['date'] != 0 ) {
            // Get Date Template
            $template = new template();
            $template->setFile("0_search.tpl");
            $template->load("RESULT_DATE_TEMPLATE");
            $template->tag("date", $date_formated );
            $date_template = $template->display ();
        } else {
            $date_template = "";
        }

        // Get Template
        $template = new template();
        $template->setFile("0_search.tpl");
        $template->load("RESULT_LINE");

        $template->tag("id", $data['id'] );
        $template->tag("title", stripslashes ( $data['title'] ) );
        $template->tag("url", "?go=dlfile&amp;id=" . $data['id'] );
        $template->tag("date", $date_formated );
        $template->tag("date_template", $date_template );
        $template->tag("num_matches", $data['num_results'] );

        $downloads_entries .= $template->display ();
        $downloads_num_results = $i;
    }
    $downloads_entries = ( count ( $replace_arr ) >= 1 ) ? $downloads_entries : $no_results_template;
    $downloads_num_results++;
} else {
    $downloads_entries = $no_results_template;
    $downloads_num_results = 0;
    $downloads_more = "";
}


// Results Template
$results_template = new template();
$results_template->setFile("0_search.tpl");
$results_template->load("RESULTS_BODY");

// News Template
if ( trim ( $_REQUEST['keyword'] ) != "" && $_REQUEST['in_news'] === TRUE ) {
    // Get Template
    $template = $results_template;
    $template->tag("type_title", $TEXT['frontend']->get("search_news_title") );
    $template->tag("results", $news_entries );
    $template->tag("num_results", $news_num_results );
    $template->tag("more_results", $news_more );
    $news_template = $template->display ();
} else {
    $news_template = "";
}

// Articles Template
if ( trim ( $_REQUEST['keyword'] ) != "" && $_REQUEST['in_articles'] === TRUE ) {
    // Get Template
    $template = $results_template;
    $template->tag("type_title", $TEXT['frontend']->get("search_articles_title") );
    $template->tag("results", $articles_entries );
    $template->tag("num_results", $articles_num_results );
    $template->tag("more_results", $articles_more );
    $articles_template = $template->display ();
} else {
    $articles_template = "";
}

// Downloads Template
if ( trim ( $_REQUEST['keyword'] ) != "" && $_REQUEST['in_downloads'] === TRUE ) {
    // Get Template
    $template = $results_template;
    $template->tag("type_title", $TEXT['frontend']->get("search_downloads_title") );
    $template->tag("results", $downloads_entries );
    $template->tag("num_results", $downloads_num_results );
    $template->tag("more_results", $downloads_more );
    $downloads_template = $template->display ();
} else {
    $downloads_template = "";
}


// Search Template
$_REQUEST['in_news'] = ( $_REQUEST['in_news'] ) ? "checked" : "";
$_REQUEST['in_articles'] = ( $_REQUEST['in_articles'] ) ? "checked" : "";
$_REQUEST['in_downloads'] = ( $_REQUEST['in_downloads'] ) ? "checked" : "";
$_REQUEST['keyword'] = kill_replacements ( $_REQUEST['keyword'], TRUE );

// Get Template
$template = new template();
$template->setFile("0_search.tpl");
$template->load("SEARCH");

$template->tag("keyword", $_REQUEST['keyword'] );
$template->tag("search_in_news", $_REQUEST['in_news'] );
$template->tag("search_in_articles", $_REQUEST['in_articles'] );
$template->tag("search_in_downloads", $_REQUEST['in_downloads'] );

$search_template = $template->display ();


// Get Main Template
$template = new template();
$template->setFile("0_search.tpl");
$template->load("BODY");

$template->tag("search", $search_template );
$template->tag("news", $news_template );
$template->tag("articles", $articles_template );
$template->tag("downloads", $downloads_template );

$template = $template->display ();
}?>
