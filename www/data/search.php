<?php
###################
## Page Settings ##
###################
$news_cols = array("news_id", "news_title", "news_date");
$article_cols = array("article_id", "article_url", "article_title", "article_date");
$dl_cols = array("dl_id", "dl_date", "dl_name");
$config_cols = array("search_num_previews", "search_and", "search_or", "search_xor", "search_not", "search_wildcard", "search_min_word_length", "search_allow_phonetic", "search_use_stopwords");
$config_arr = $sql->getById("search_config", $config_cols, 1);


// Security Functions
$_REQUEST['in_news'] = (isset($_REQUEST['in_news']) && $_REQUEST['in_news'] == 1) ? true : false;
$_REQUEST['in_articles'] = (isset($_REQUEST['in_articles']) && $_REQUEST['in_articles'] == 1) ? true : false;
$_REQUEST['in_downloads'] = (isset($_REQUEST['in_downloads']) && $_REQUEST['in_downloads'] == 1) ? true : false;
$_REQUEST['phonetic_search'] = (isset($_REQUEST['phonetic_search']) && $_REQUEST['phonetic_search'] == 1) ? true : false;
$_REQUEST['keyword'] = !isset($_REQUEST['keyword']) ? "" : trim($_REQUEST['keyword']);

initstr($news_template);
initstr($articles_template);
initstr($downloads_template);

    
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


    // try to compute the search
    try {

        // Create News Search
        initstr($news_entries); $news_num_results = 0;
        if ($_REQUEST['in_news']) {
            // do the search
            $search = new Search("news", $_REQUEST['keyword'], $_REQUEST['phonetic_search']);
            $search->setOrder("rank DESC", "news_date DESC", "news_id ASC");
            
            //run through results
            while(($found = $search->next()) && $config_arr['search_num_previews'] > $news_num_results) {

                // get data for entry
                $news = $sql->getRow("news", $news_cols, array(
                    'W' => "`news_id` = ".$found['id']." AND `news_date` <= ".time()." AND `news_active` = 1"
                ));
                
                // entry is ok
                if (!empty($news)) {
                    $news_num_results++;

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
                        initstr($date_formated);
                    }
                    
                    // entry
                    $template->load("RESULT_LINE");
                    $template->tag("id", $news['news_id']);
                    $template->tag("title", $news['news_title']);
                    $template->tag("url", url("comments", array('id' => $news['news_id'])));
                    $template->tag("date", $date_formated);
                    $template->tag("date_template", $date_template);
                    $template->tag("rank", sprintf("%.1F", $found['rank']));

                    $news_entries .= (string) $template;		
                }
            }
            
            //more results
            initstr($news_more);
            if ($search->next()) {
                $news_more = $more_results_template;
                $news_more->tag("main_search_url", url("news_search", array('keyword' => implode("+",$keyword_arr))));
                $news_more = (string) $news_more;
                
            //no results
            } elseif ($news_num_results == 0) {
                $news_entries = $no_results_template;
            }
            
        } //END newssearch
        
        // Create Articles Search
        initstr($articles_entries); $articles_num_results = 0;
        if ($_REQUEST['in_articles']) {
            // do the search
            $search = new Search("articles", $_REQUEST['keyword'], $_REQUEST['phonetic_search']);
            $search->setOrder("rank DESC", "article_date DESC", "article_id ASC");
           
            //run through results
            while(($found = $search->next()) && $config_arr['search_num_previews'] > $articles_num_results) {
                
                // get data for entrie
                $article = $sql->getRow("articles", $article_cols, array(
                    'W' => "`article_id` = ".$found['id']
                ));
                
                // entry is ok
                if (!empty($article)) {
                    $articles_num_results++;

                    // load template
                    $template = new template();
                    $template->setFile("0_search.tpl");

                    // data
                    $date_formated = date_loc($global_config_arr['date'], $article['article_date']);
                    if ($article['article_date'] != 0) {
                        // Get Date Template
                        $template->load("RESULT_DATE_TEMPLATE");
                        $template->tag("date", $date_formated);
                        $date_template = (string) $template;
                    } else {
                        initstr($date_template);
                        initstr($date_formated);
                    }
                    
                    if ($article['article_param'] = array() && empty($article['article_url'])) {
                        $article['article_url'] = "articles";
                        $article['article_param'] = array('id' => $article['article_id']);
                    }
                    
                    // entry
                    $template->load("RESULT_LINE");
                    $template->tag("id", $article['article_id']);
                    $template->tag("title", $article['article_title']);
                    $template->tag("url", url($article['article_url'], $article['article_param']));
                    $template->tag("date", $date_formated);
                    $template->tag("date_template", $date_template);
                    $template->tag("rank", sprintf("%.1F", $found['rank']));

                    $articles_entries .= (string) $template;		
                }
            }
            
            //more results
            initstr($articles_more);
            if ($search->next()) {
                $articles_more = $more_results_template;
                $articles_more->tag("main_search_url", url("foo", array('keyword' => implode("+",$keyword_arr))));
                $articles_more = (string) $articles_more;
                
            //no results
            } elseif ($articles_num_results == 0) {
                $articles_entries = $no_results_template;
            }
            $articles_more = ""; // Remove Line when articles_search implemented
            
        } //END Articlessearch

        // Create News Search
        initstr($downloads_entries); $downloads_num_results = 0;
        if ($_REQUEST['in_downloads']) {
            // do the search
            $search = new Search("dl", $_REQUEST['keyword'], $_REQUEST['phonetic_search']);
            $search->setOrder("rank DESC", "dl_date DESC", "dl_id ASC");
            
            //run through results
            while(($found = $search->next()) && $config_arr['search_num_previews'] > $downloads_num_results) {

                // get data for entrie
                $dl = $sql->getRow("dl", $dl_cols, array(
                    'W' => "`dl_id` = ".$found['id']." AND `dl_open` = 1"
                ));
                
                // entry is ok
                if (!empty($dl)) {
                    $downloads_num_results++;

                    // load template
                    $template = new template();
                    $template->setFile("0_search.tpl");

                    // data
                    $date_formated = date_loc($global_config_arr['date'], $dl['dl_date']);
                    if ($dl['dl_date'] != 0) {
                        // Get Date Template
                        $template->load("RESULT_DATE_TEMPLATE");
                        $template->tag("date", $date_formated);
                        $date_template = (string) $template;
                    } else {
                        initstr($date_template);
                        initstr($date_formated);
                    }
                    
                    // entry
                    $template->load("RESULT_LINE");
                    $template->tag("id", $dl['dl_id']);
                    $template->tag("title", $dl['dl_name']);
                    $template->tag("url", url("dlfile", array('id' => $dl['dl_id'])));
                    $template->tag("date", $date_formated);
                    $template->tag("date_template", $date_template);
                    $template->tag("rank", sprintf("%.1F", $found['rank']));

                    $downloads_entries .= (string) $template;		
                }
            }
            
            //more results
            initstr($downloads_more);
            if ($search->next()) {
                $downloads_more = $more_results_template;
                $downloads_more->tag("main_search_url", url("download", array('cat_id' => "all", 'keyword' => implode("+", $keyword_arr))));
                $downloads_more = (string) $downloads_more;
                
            //no results
            } elseif ($downloads_num_results == 0) {
                $downloads_entries = $no_results_template;
            }
            
        } //END dl-search
        

        // Results Template
        $results_template = new template();
        $results_template->setFile("0_search.tpl");
        $results_template->load("RESULTS_BODY");

        // News Template
        if (!empty($_REQUEST['keyword']) && $_REQUEST['in_news']) {
            // Get Template
            $template = $results_template;
            $template->tag("type_title", $TEXT['frontend']->get("search_news_title") );
            $template->tag("results", $news_entries );
            $template->tag("num_results", $news_num_results );
            $template->tag("more_results", $news_more );
            $news_template = (string) $template;
        }

        // Articles Template
        if (!empty($_REQUEST['keyword']) && $_REQUEST['in_articles']) {
            // Get Template
            $template = $results_template;
            $template->tag("type_title", $TEXT['frontend']->get("search_articles_title") );
            $template->tag("results", $articles_entries );
            $template->tag("num_results", $articles_num_results );
            $template->tag("more_results", $articles_more );
            $articles_template = (string) $template;
        }

        // Downloads Template
        if (!empty($_REQUEST['keyword']) && $_REQUEST['in_downloads']) {
            // Get Template
            $template = $results_template;
            $template->tag("type_title", $TEXT['frontend']->get("search_downloads_title") );
            $template->tag("results", $downloads_entries );
            $template->tag("num_results", $downloads_num_results );
            $template->tag("more_results", $downloads_more );
            $downloads_template = (string) $template;
        }
    
        // no errors
        initstr($error_template);
    
    // catch exeptions
    } catch (Exception $e) {
        $news_template = $articles_template = $downloads_template = "";
        $error_template = sys_message("ERROR", $e->getMessage());
    }
}


// Search Template
$_REQUEST['in_news'] = $_REQUEST['in_news'] ? "checked" : "";
$_REQUEST['in_articles'] = $_REQUEST['in_articles'] ? "checked" : "";
$_REQUEST['in_downloads'] = $_REQUEST['in_downloads'] ? "checked" : "";
$_REQUEST['phonetic_search'] = $_REQUEST['phonetic_search'] ? "checked" : "";
$_REQUEST['keyword'] = usersave($_REQUEST['keyword']);

// Get Default-Operators
// get searchfunctions if not loaded   
require_once(FS2_ROOT_PATH . "includes/searchfunctions.php"); 
$ops = get_default_operators();


// Get Template
$template = new template();
$template->setFile("0_search.tpl");
$template->load("SEARCH");
    $config_cols = array("search_min_word_length", "search_use_stopwords");
    $config_arr = $sql->getById("search_config", $config_cols, 1);
$template->tag("keyword", $_REQUEST['keyword'] );
$template->tag("operators", implode(" ", $ops)) ;
$template->tag("search_in_news", $_REQUEST['in_news'] );
$template->tag("search_in_articles", $_REQUEST['in_articles'] );
$template->tag("search_in_downloads", $_REQUEST['in_downloads'] );
$template->tag("phonetic_search", $_REQUEST['phonetic_search'] );

$search_template = (string) $template;


// Search info or error
if (isset($search)) {
    $template->load("INFO");
    $template->tag("query", $search->getQuery());
    $template->tag("num_results", $news_num_results+$articles_num_results+$downloads_num_results);
    $info = (string) $template;
} else
    $info = "";
$info = !empty($error_template) ? $error_template : $info;


// Get Main Template
$template = new template();
$template->setFile("0_search.tpl");
$template->load("BODY");

$template->tag("search", $search_template );
$template->tag("info", $info);
$template->tag("news", $news_template );
$template->tag("articles", $articles_template );
$template->tag("downloads", $downloads_template );

$template = (string) $template;

?>
