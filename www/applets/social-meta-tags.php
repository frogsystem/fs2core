<?php

// load config
$FD->loadConfig('social_meta_tags');
$FD->setConfig('social_meta_tags', 'default_image', $FD->config('social_meta_tags', 'default_image') ?: false);
$FD->setConfig('social_meta_tags', 'site_name', $FD->config('social_meta_tags', 'site_name') ?: $FD->config('title'));

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

        $text = StringCutter::truncate(killhtml($text), $length, $extension, array('word'=>true));  //less than 200 characters
        return $text;
    }

    function getImageFromContent($text) {
        global $FD;

        preg_match_all('#\[(c?img).*\]([^\s]+)\[\/\1\]#', $text, $images, PREG_SET_ORDER);
        foreach ($images as $image) {

            // resolve tpl_functions
            $image[2] = trim(tpl_functions($image[2], 1, array('VAR', 'URL')));            
            
            // content image => all goof
            if ($image[1] == 'cimg') {
                $url = FS2MEDIA.'/content/'.$image[2];
            
            // analyze image url
            } else {

                // internal image, but external include
                if (0 === strpos($image[2], $FD->config('virtualhost'))) {
                    $url = FS2CONTENT.'/'.str_replace($FD->config('virtualhost'), '', $image[2]);
                
                // externes Bild
                } else if (0 === substr_compare($image[2], 'http', 0, 4, true) || 0 === substr_compare($image[2], '//', 0, 2, true)) {
                    if (!$FD->config('social_meta_tags', 'use_external_images')) {
                        continue; 
                    }
                    $url = $image[2];
                } else {
                    $url = FS2CONTENT.'/'.$image[2];
                }
            }
            
            $size = @getimagesize($url);
            if ($size && $size[0] >= 200 && $size[1] >= 200) {
                return $url;
            }
        }
        return false;
    }

    // news
    if ($FD->config('social_meta_tags', 'enable_news') && 'comments' == $FD->env('goto')) {
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
            $content = new stdClass();
            $content->title = killhtml($news_arr['news_title']);
            if ($FD->config('social_meta_tags', 'use_news_cat_prepend')) {
                $content->title = killhtml($news_arr['cat_name']).$FD->config('social_meta_tags', 'news_cat_prepend').$content->title;
            }
            $content->summery = summeryFromContent($news_arr['news_text'], 207, '');
            $content->url = get_canonical_url();
            $content->date = date('c', $news_arr['news_date']);
            $content->last_update = date('c', $news_arr['news_date']?:$news_arr['news_search_update']);
            $content->image = getImageFromContent($news_arr['news_text']);
        }


    // article
    } else if ($FD->config('social_meta_tags', 'enable_articles') && 'articles' == $FD->env('goto')) {
        //load data
        if ($FD->cfg('goto') == 'articles') {
            $article_arr = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX').'articles WHERE article_id = '.intval($_GET['id']));
        } else {
            $article_arr = $FD->db()->conn()->query('SELECT * FROM '.$FD->env('DB_PREFIX')."articles WHERE `article_url` = '".$FD->cfg('goto')."' ORDER BY `article_id` LIMIT 1");
        }
        $article_arr = $article_arr->fetch(PDO::FETCH_ASSOC);

        // set data
        if (!empty($article_arr)) {
            $content = new stdClass();
            $content->title = killhtml($article_arr['article_title']);
            $content->summery = summeryFromContent($article_arr['article_text'], 207, '');
            $content->url = get_canonical_url();
            $content->date = date('c', $article_arr['article_date']?:$article_arr['article_search_update']);
            $content->last_update = date('c', $article_arr['article_date']?:$article_arr['article_search_update']);
            $content->image = getImageFromContent($article_arr['article_text']);
        }


    // download
    } else if ($FD->config('social_meta_tags', 'enable_downloads') && 'dlfile' == $FD->env('goto')) {
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
            $content = new stdClass();
            $content->title = killhtml($downloads['dl_name']);
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

// quit if no content found
if (!isset($content) || empty($content)) {
    return;
}

//todo
// better text filter
//~ $content->tags;
//~ $content->user->twitter;
//~ $content->user->google_plus;
$content->user = (object) array('google_plus' => false, 'twitter' => false);
$content->tag = false;


// image stuff
{
    //Twitter Summary card images must be at least 200x200px
    //Twitter summary card with large image must be at least 280x150px
    $content->image_is_large = false;
    $content->image = $content->image ?: $FD->config('social_meta_tags', 'default_image');

    if (!empty($content->image)) {
        $size = getimagesize($content->image);
        if ($size[0] >= 280 && $size[1] >= 200) {
            $content->image_is_large = true;
        } else if ($size[0] < 200 || $size[1] < 200) {
            $content->image = $FD->config('social_meta_tags', 'default_image');
        }
    }
}


// Display everything
{
    // Google Authorship and Publisher Markup
    if ($FD->config('social_meta_tags', 'use_google_plus')) {
        print $content->user->google_plus ? '<link rel="author" href="https://plus.google.com/'.$content->user->google_plus.'/posts">'.PHP_EOL : '';
        print $FD->config('social_meta_tags', 'google_plus_page') ? '<link rel="publisher" href="https://plus.google.com/'.$FD->config('social_meta_tags', 'google_plus_page').'/">'.PHP_EOL : '';
    }

    // Schema.org markup for Google+
    if ($FD->config('social_meta_tags', 'use_schema_org')) {
        print '<meta itemprop="name" content="'.$content->title.'">'.PHP_EOL;
        print '<meta itemprop="description" content="'.$content->summery.'">'.PHP_EOL;
        print $content->image ? '<meta itemprop="image" content="'.$content->image.'">'.PHP_EOL : '';
    }

    // Twitter Card data
    if ($FD->config('social_meta_tags', 'use_twitter_card')) {
        print '<meta name="twitter:card" content="'.(($content->image && $content->image_is_large) ? 'summary_large_image' : 'summary').'">'.PHP_EOL;
        print $FD->config('social_meta_tags', 'twitter_site') ? '<meta name="twitter:site" content="'.$FD->config('social_meta_tags', 'twitter_site').'">'.PHP_EOL : '';
        print '<meta name="twitter:title" content="'.$content->title.'">'.PHP_EOL;
        print '<meta name="twitter:description" content="'.$content->summery.'">'.PHP_EOL;
        print $content->user->twitter ? '<meta name="twitter:creator" content="'.$content->user->twitter.'">'.PHP_EOL : '';
        print $content->image ? '<meta name="twitter:image:src" content="'.$content->image.'">'.PHP_EOL : '';
    }

    // Open Graph data
    if ($FD->config('social_meta_tags', 'use_open_graph')) {
        print '<meta property="og:title" content="'.$content->title.'">'.PHP_EOL;
        print '<meta property="og:type" content="article">'.PHP_EOL;
        print '<meta property="og:url" content="'.$content->url.'">'.PHP_EOL;
        print $content->image ? '<meta property="og:image" content="'.$content->image.'">'.PHP_EOL : '';
        print '<meta property="og:description" content="'.$content->summery.'">'.PHP_EOL;
        print $FD->config('social_meta_tags', 'site_name') ? '<meta property="og:site_name" content="'.$FD->config('social_meta_tags', 'site_name').'">'.PHP_EOL : '';
        print '<meta property="article:published_time" content="'.$content->date.'">'.PHP_EOL;
        print $content->last_update ? '<meta property="article:modified_time" content="'.$content->last_update.'">'.PHP_EOL : '';
        print $FD->config('social_meta_tags', 'og_section') ? '<meta property="article:section" content="'.$FD->config('social_meta_tags', 'og_section').'">'.PHP_EOL : '';
        print $content->tag ? '<meta property="article:tag" content="'.$content->tag.'">'.PHP_EOL : '';
        foreach (explode(',', $FD->config('social_meta_tags', 'fb_admins')) as $admin) {
            print $admin ? '<meta property="fb:admins" content="'.$admin.'">'.PHP_EOL : '';
        }
    }
}
?>
