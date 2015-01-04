<?php
###################
## Feed Settings ##
###################
$feed_url = 'feeds/sitemap.php';
##################
## Settings End ##
##################

class Sitemap extends Feed {

    // Return Header XML
    protected function getHeaderXml() {
        return '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
    }

    // Load Data from DB and parse it
    protected function loadData() {
        global $FD;

        // news
        $news_arr = $FD->sql()->conn()->query(
                        'SELECT `news_id`, `news_date`, `news_search_update`
                         FROM '.$FD->config('pref').'news
                         WHERE `news_active` = 1 AND `news_date` <= '.$FD->env('time').'
                         ORDER BY `news_search_update` DESC');
        $news_arr = $news_arr->fetchAll(PDO::FETCH_ASSOC);
        foreach ($news_arr as $news) {
            $item = array();
            $item['url'] = url('comments', array('id' => $news['news_id']));

            if (!empty($news['news_search_update'])) {
                $item['lastmod'] = date('c', url($news['news_search_update']));
            } else if (!empty($news['news_date'])) {
                $item['lastmod'] = date('c', url($news['news_date']));
            }

            array_push($this->items, $item);
        }

        // articles
        $articles = $FD->sql()->conn()->query(
                        'SELECT `article_id`, `article_url`, `article_date`, `article_search_update`
                         FROM '.$FD->config('pref').'articles
                         WHERE `article_date` <= '.$FD->env('time').'
                         ORDER BY `article_search_update` DESC');
        $articles = $articles->fetchAll(PDO::FETCH_ASSOC);
        foreach ($articles as $article) {
            $item = array();
            if (!empty($article['article_url'])) {
                $item['url'] = url($article['article_url']);
            } else {
                $item['url'] = url('articles', array('id' => $article['article_id']));
            }
            if (!empty($article['article_search_update'])) {
                $item['lastmod'] = date('c', url($article['article_search_update']));
            } else if (!empty($article['article_date'])) {
                $item['lastmod'] = date('c', url($article['article_date']));
            }

            array_push($this->items, $item);
        }

        // downloads
        $downloads = $FD->sql()->conn()->query(
                        'SELECT `dl_id`, `dl_date`, `dl_search_update`
                         FROM '.$FD->config('pref').'dl
                         WHERE `dl_open` = 1 AND `dl_date` <= '.$FD->env('time').'
                         ORDER BY `dl_search_update` DESC');
        $downloads = $downloads->fetchAll(PDO::FETCH_ASSOC);
        foreach ($downloads as $download) {
            $item = array();
            $item['url'] = url('dlfile', array('id' => $download['dl_id']));

            if (!empty($download['dl_search_update'])) {
                $item['lastmod'] = date('c', url($download['dl_search_update']));
            } else if (!empty($download['dl_date'])) {
                $item['lastmod'] = date('c', url($download['dl_date']));
            }

            array_push($this->items, $item);
        }

    }

    // Return XML Representation of an item
    protected function getItemXml($item) {
        global $FD;

        return '
  <url>
    <loc>'.utf8_encode($FD->cfg('virtualhost').$item['url']).'</loc>
    '.(isset($item['lastmod']) ? '<lastmod>'.utf8_encode($item['lastmod']).'</lastmod>' : '').'
  </url>';
    }

    // Return Footer XML
    protected function getFooterXml() {
        return '
</urlset>';
    }
}



// create feed
$sitemap = new Sitemap($FD->cfg('virtualhost').$feed_url, $settings);
echo $sitemap;

?>
