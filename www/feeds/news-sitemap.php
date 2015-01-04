<?php
###################
## Feed Settings ##
###################
$feed_url = 'feeds/google-news.php';
$news_settings = array (
    'name' => 'Frogsystem',
    'language' => 'de',
    'days' => 2,
    'cat_filter' => array(),
    'cat_prepend' => false
);
##################
## Settings End ##
##################

class NewsSitemap extends NewsFeed {

    protected $days = 2;

    /**
     * Constructor of class Feed.
     *
     * @return void
     */
    public function __construct($feedUrl, $news_settings) {
        parent::__construct($feedUrl, array());
        $this->title = $news_settings['name'];
        $this->language = $news_settings['language'];
        $this->days = $news_settings['days']?:$this->days;
        $this->setSettings($news_settings);
    }

    protected function loadData() {
       global $FD;

        // Include functions & libs
        require_once(FS2_ROOT_PATH . 'includes/fscode.php');

        // Load virtualhost
        if (is_empty($virtualhost = $FD->cfg('virtualhost'))) {
            $virtualhost = 'http://'.$_SERVER['HTTP_HOST'];
        }

        // Set Header Data
        $this->fsUrl = $virtualhost;

        // News Config + Infos
        $FD->loadConfig('news');

        // Get News from DB
        $news_arr = $FD->sql()->conn()->query(
                        'SELECT N.news_id, N.news_text, N.news_title, N.news_date, N.user_id, C.cat_name
                         FROM '.$FD->config('pref').'news N
                         LEFT JOIN '.$FD->config('pref').'news_cat C
                         ON N.cat_id = C.cat_id
                         WHERE N.`news_active` = 1
                         AND N.`news_date` <= '.$FD->env('time').'
                         AND N.`news_date` > '.(strtotime('today') - 60*60*24*$this->days).'
                         '.(!empty($this->settings['cat_filter']) ? 'AND N.`cat_id` NOT IN ('.implode(',', $this->settings['cat_filter']).')' : '').'
                         ORDER BY N.`news_date` DESC');
        $news_arr = $news_arr->fetchAll(PDO::FETCH_ASSOC);

        // Parse News items
        foreach ($news_arr as $news) {
            array_push($this->items, $this->parseNews($news));
        }
    }

    // Return Header XML
    protected function getHeaderXml() {
        return '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';
    }

    // Return XML Representation of an item
    protected function getItemXml($item) {
        return '
  <url>
    <loc>'.utf8_encode(url('comments', array('id' => $item['news_id']), true)).'</loc>
    <news:news>
      <news:publication>
        <news:name>'.$this->title.'</news:name>
        <news:language>'.$this->language.'</news:language>
      </news:publication>
      <news:publication_date>'.date("c", $item['news_date']).'</news:publication_date>
      <news:title>'.utf8_encode(htmlspecialchars($item['news_title'])).'</news:title>
      <news:keywords>Entertainment, Video Games</news:keywords>
    </news:news>
  </url>';
    }

    // Return Footer XML
    protected function getFooterXml() {
        return '
</urlset>';
    }
}



// create feed
$sitemap = new NewsSitemap($FD->cfg('virtualhost').$feed_url, $news_settings);
echo $sitemap;
?>
