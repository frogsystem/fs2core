<?php
###############################
## Social Meta Tags Settings ##
###############################
$settings = array (
    // meta tag types
    'use_google_plus' => true,
    'use_schema_org' => true,
    'use_twitter_card' => true,
    'use_open_graph' => true,

    // use for content types
    'for_news' => true,
    'for_articles' => true,
    'for_downloads' => true,

    // minimal info, this is a MUST
    'site_name' => '',
    'default_image' => '', // min. 200x200px, better 280x200px, no https!

    // extended settings, strongly RECOMMENDED
    // set to false if you don't want use them
    'news_cat_prepend' => ': ', // false or delimiter string
    'google_plus_page' => '', // with +
    'twitter_site' => '', // with @
    'fb_admins' => '', // CSV => http://findmyfacebookid.com/
    'og_section' => '', // A high-level section name. E.g. Technology
);

/**
 * IMPORTANT!
 *
 * Update your html tag to include the itemscope and itemtype attributes:
 * <html itemscope itemtype="http://schema.org/Article">
 */

/**
 * Debuggers:
 *
 * Twitter: https://dev.twitter.com/docs/cards/validation/validator
 * Facebook: https://developers.facebook.com/tools/debug
 * Google: http://www.google.com/webmasters/tools/richsnippets
 */

######################
## SMT Settings End ##
######################


/**
 * DO NOT EDIT BELOW HERE
 */
$settings = (object) $settings;


// Detect page type
{
    // should be less than 200 characters
    function summeryFromContent($text, $length, $extension) {

        $text = parse_fscode($text, array(
            'nohtmlatall' => true,
            'paragraph' => false,
        ), array(), array(
            'b', 'i', 'u', 's', 'font', 'color', 'size',
            'center',
            'url', 'home', 'email',
            'list', 'numlist',
            'code', 'quote',
            'nofscode', 'fscode',
            'smilies',
            'html', 'nohtml'
        ), array(), array(
            'img', 'cimg',
            'video',
        ));

        $text = preg_replace("/[\n\r]/", '', $text);

        $text = StringCutter::truncate(htmlspecialchars($text), $length, $extension, array('word'=>true));  //less than 200 characters
        return $text;
    }

    function getImageFromContent($text) {
        global $FD;

        preg_match_all('#\[(c?img).*\]([^\s]+)\[\/\1\]#', $text, $images, PREG_SET_ORDER);
        foreach ($images as $image) {
            if ($image[1] == 'cimg') {
                $url = FS2MEDIA.'/content/'.$image[2];
            } else {
                $url = $image[2];
            }

            // resolve tpl_functions
            $url = tpl_functions($url, 1, array('VAR', 'URL'));

            $size = getimagesize($url);
            if ($size[0] >= 200 && $size[1] >= 200) {
                return $url;
            }
        }
        return false;
    }

    // news
    if ($settings->for_news && 'comments' == $FD->env('goto')) {
        // load data
        $news_arr = $FD->db()->conn()->query(
                        'SELECT N.*, C.cat_name
                         FROM '.$FD->env('DB_PREFIX').'news N
                         LEFT JOIN '.$FD->env('DB_PREFIX').'news_cat C
                         ON N.cat_id = C.cat_id
                         WHERE N.`news_id` = '.intval($_GET['id']).'
                         AND N.`news_date` <= '.$FD->env('time').' AND N.`news_active` = 1
                         LIMIT 0,1');
        $news_arr = $news_arr->fetch(PDO::FETCH_ASSOC);

        // set data
        if (!empty($news_arr)) {
            $content->title = htmlspecialchars($news_arr['news_title']);
            if (false !== $settings->news_cat_prepend) {
                $content->title = htmlspecialchars($news_arr['cat_name']).$settings->news_cat_prepend.$content->title;
            }
            $content->summery = summeryFromContent($news_arr['news_text'], 207, '');
            $content->url = get_canonical_url();
            $content->date = date('c', $news_arr['news_date']);
            $content->last_update = date('c', $news_arr['news_date']?:$news_arr['news_search_update']);
            $content->image = getImageFromContent($news_arr['news_text']);
        }


    // article
    } else if ($settings->for_articles && 'articles' == $FD->env('goto')) {
        //load data
        if ($FD->cfg('goto') == 'articles') {
            $article_arr = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'articles WHERE article_id = '.intval($_GET['id']));
        } else {
            $article_arr = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX')."articles WHERE `article_url` = '".$FD->cfg('goto')."' ORDER BY `article_id` LIMIT 1");
        }
        $article_arr = $article_arr->fetch(PDO::FETCH_ASSOC);

        // set data
        if (!empty($article_arr)) {
            $content->title = htmlspecialchars($article_arr['article_title']);
            $content->summery = summeryFromContent($article_arr['article_text'], 207, '');
            $content->url = get_canonical_url();
            $content->date = date('c', $article_arr['article_date']?:$article_arr['article_search_update']);
            $content->last_update = date('c', $article_arr['article_date']?:$article_arr['article_search_update']);
            $content->image = getImageFromContent($article_arr['article_text']);
        }


    // download
    } else if ($settings->for_downloads && 'dlfile' == $FD->env('goto')) {
        // load data
        $downloads = $FD->db()->conn()->query(
                        'SELECT `dl_id`, `dl_name`, `dl_text`, `dl_date`, `dl_search_update`
                         FROM '.$FD->env('DB_PREFIX').'dl
                         WHERE `dl_id` = '.intval($_GET['id']).'
                         AND `dl_open` = 1 AND `dl_date` <= '.$FD->env('time').'
                         ORDER BY `dl_search_update` DESC');
        $downloads = $downloads->fetch(PDO::FETCH_ASSOC);

        // set data
        if (!empty($downloads)) {
            $content->title = htmlspecialchars($downloads['dl_name']);
            $content->summery = summeryFromContent($downloads['dl_text'], 207, '');
            $content->url = get_canonical_url();
            $content->date = date('c', $downloads['dl_date']?:$downloads['dl_search_update']);
            $content->last_update = date('c', $downloads['dl_date']?:$downloads['dl_search_update']);
            if (image_exists('/downloads', $downloads['dl_id'])) {
                $content->image = image_url('/downloads', $downloads['dl_id']);
            }
        }
    }
}

//todo
// better text filter
//~ $content->tags;
//~ $content->user->twitter;
//~ $content->user->google_plus;

// quit if no content found
if (!isset($content) || empty($content)) {
    return;
}

// image stuff
{
    //Twitter Summary card images must be at least 200x200px
    //Twitter summary card with large image must be at least 280x150px
    $content->image_is_large = false;
    if (!$content->image) {
        $content->image = $settings->default_image;
    }
    $size = getimagesize($content->image);
    if ($size[0] >= 280 && $size[1] >= 200) {
        $content->image_is_large = true;
    } else if ($size[0] < 200 || $size[1] < 200) {
        $content->image = $settings->default_image;
    }
}


// Display everything
{
    // Google Authorship and Publisher Markup
    if ($settings->use_google_plus) {
        print $content->user->google_plus ? '<link rel="author" href="https://plus.google.com/'.$content->user->google_plus.'/posts">'.PHP_EOL : '';
        print $settings->google_plus_page ? '<link rel="publisher" href="https://plus.google.com/'.$settings->google_plus_page.'/">'.PHP_EOL : '';
    }

    // Schema.org markup for Google+
    if ($settings->use_schema_org) {
        print '<meta itemprop="name" content="'.$content->title.'">'.PHP_EOL;
        print '<meta itemprop="description" content="'.$content->summery.'">'.PHP_EOL;
        print $content->image ? '<meta itemprop="image" content="'.$content->image.'">'.PHP_EOL : '';
    }

    // Twitter Card data
    if ($settings->use_twitter_card) {
        print '<meta name="twitter:card" content="'.(($content->image && $content->image_is_large) ? 'summary_large_image' : 'summary').'">'.PHP_EOL;
        print $settings->twitter_site ? '<meta name="twitter:site" content="'.$settings->twitter_site.'">'.PHP_EOL : '';
        print '<meta name="twitter:title" content="'.$content->title.'">'.PHP_EOL;
        print '<meta name="twitter:description" content="'.$content->summery.'">'.PHP_EOL;
        print $content->user->twitter ? '<meta name="twitter:creator" content="'.$content->user->twitter.'">'.PHP_EOL : '';
        print $content->image ? '<meta name="twitter:image:src" content="'.$content->image.'">'.PHP_EOL : '';
    }

    // Open Graph data
    if ($settings->use_open_graph) {
        print '<meta property="og:title" content="'.$content->title.'">'.PHP_EOL;
        print '<meta property="og:type" content="article">'.PHP_EOL;
        print '<meta property="og:url" content="'.$content->url.'">'.PHP_EOL;
        print $content->image ? '<meta property="og:image" content="'.$content->image.'">'.PHP_EOL : '';
        print '<meta property="og:description" content="'.$content->summery.'">'.PHP_EOL;
        print $settings->site_name ? '<meta property="og:site_name" content="'.$settings->site_name.'">'.PHP_EOL : '';
        print '<meta property="article:published_time" content="'.$content->date.'">'.PHP_EOL;
        print $content->last_update ? '<meta property="article:modified_time" content="'.$content->last_update.'">'.PHP_EOL : '';
        print $settings->og_section ? '<meta property="article:section" content="'.$settings->og_section.'">'.PHP_EOL : '';
        print $content->tag ? '<meta property="article:tag" content="'.$content->tag.'">'.PHP_EOL : '';
        foreach (explode(',', $settings->fb_admins) as $admin) {
            print $admin ? '<meta property="fb:admins" content="'.$admin.'">'.PHP_EOL : '';
        }
    }
}
?>
