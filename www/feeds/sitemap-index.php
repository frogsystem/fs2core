<?php
###################
## Feed Settings ##
###################
$feed_url = 'feeds/sitemap-index.php';
$sitemaps = array (
    'feeds/news-sitemap.php',
    'feeds/sitemap.php',
);

##################
## Settings End ##
##################


/* FS2 PHP Init */
set_include_path('.');
define('FS2_ROOT_PATH', './../', true);
require_once(FS2_ROOT_PATH . 'includes/phpinit.php');
phpinit(false, 'Content-type: application/xml');
/* End of FS2 PHP Init */


// Inlcude DB Connection File or exit()
require( FS2_ROOT_PATH . 'login.inc.php');

//Include Functions-Files & Feed-Lib
require_once(FS2_ROOT_PATH . 'libs/class_Feed.php');


class SitemapIndex extends Feed {

    protected $sitemaps;

    /**
     * Constructor of class Feed.
     *
     * @return void
     */
    public function __construct($feedUrl, array $sitemaps) {
        parent::__construct($feedUrl, array());
        $this->sitemaps = $sitemaps;
    }

    // Return Header XML
    protected function getHeaderXml() {
        global $FD;

        return '<?xml version="1.0" encoding="UTF-8"?>
   <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    }

    // Load Data from DB and parse it
    protected function loadData() {
        global $FD;
        foreach ($this->sitemaps as $url) {
            array_push($this->items, array('url' => $FD->cfg('virtualhost').$url));
        }
    }

    // Return XML Representation of an item
    protected function getItemXml($item) {
        return '
   <sitemap>
      <loc>'.$item['url'].'</loc>
   </sitemap>';
    }

    // Return Footer XML
    protected function getFooterXml() {
        return '
</sitemapindex>';
    }
}



// create feed
$sitemap = new SitemapIndex($FD->cfg('virtualhost').$feed_url, $sitemaps);
echo $sitemap;

// Shutdown System
unset($FD);

?>
