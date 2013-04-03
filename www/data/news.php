<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('cat'));

////////////////////////////
//// Category-Filter?   ////
////////////////////////////
if (isset($_GET['cat'])) {
	settype($_GET['cat'], 'integer');
	$cat_filter = "AND cat_id = '".$_GET['cat']."'";
} else {
	$cat_filter = '';
}


////////////////////////////
//// News Kopf erzeugen ////
////////////////////////////

// News Konfiguration lesen
$config_arr = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'news'"));
$config_arr = json_array_decode($config_arr['config_data']);
$time = time();

// Headlines erzeugen
$index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."news
                      WHERE news_date <= $time
                      AND news_active = 1
                      ORDER BY news_date DESC
                      LIMIT $config_arr[num_head]");
$news_line_tpl = '';
while ($newshead_arr = $index->fetch(PDO::FETCH_ASSOC))
{
    $newshead_arr['news_date'] = date_loc ( $FD->config('datetime') , $newshead_arr['news_date'] );
    if ( strlen ( $newshead_arr['news_title'] ) > $config_arr['news_headline_lenght'] && $config_arr['news_headline_lenght'] >=0 ) {
        $newshead_arr['news_title'] = substr ( $newshead_arr['news_title'], 0, $config_arr['news_headline_lenght'] ) . $config_arr['news_headline_ext'];
    }

    // Get Template
    $template = new template();
    $template->setFile('0_news.tpl');
    $template->load('APPLET_LINE');

    $template->tag('title', stripslashes ( $newshead_arr['news_title'] ) );
    $template->tag('date', $newshead_arr['news_date'] );
    $template->tag('url', url('comments', array('id' => $newshead_arr['news_id'])));
    $template->tag('news_id', $newshead_arr['news_id'] );

    $template = $template->display ();
    $news_line_tpl .= $template;
}
unset($newshead_arr);

// Neuste Downloads erzeugen
$index = $FD->sql()->conn()->query('SELECT dl_name, dl_id, dl_date
                      FROM '.$FD->config('pref')."dl
                      WHERE dl_open = 1
                      ORDER BY dl_date DESC
                      LIMIT $config_arr[num_head]");
$downloads_tpl = '';
while ($dlhead_arr = $index->fetch(PDO::FETCH_ASSOC))
{
    $dlhead_arr['dl_date'] = date_loc ( $FD->config('datetime') , $dlhead_arr['dl_date'] );
    if ( strlen ( $dlhead_arr['dl_name'] ) > $config_arr['news_headline_lenght'] ) {
        $dlhead_arr['dl_name'] = substr ( $dlhead_arr['dl_name'], 0, $config_arr['news_headline_lenght'] ) . $config_arr['news_headline_ext'];
    }

    // Get Template
    $template = new template();
    $template->setFile('0_downloads.tpl');
    $template->load('APPLET_LINE');

    $template->tag('title', stripslashes ( $dlhead_arr['dl_name'] ) );
    $template->tag('date', $dlhead_arr['dl_date'] );
    $template->tag('url', url('dlfile', array('id' => $dlhead_arr['dl_id'])));
    $template->tag('download_id', $dlhead_arr['dl_id'] );

    $template = $template->display ();
    $downloads_tpl .= $template;
}
unset($dlhead_arr);

// Get Headline Template
$template = new template();
$template->setFile('0_news.tpl');
$template->load('APPLET_BODY');

$template->tag('news_lines', $news_line_tpl );
$template->tag('download_lines', $downloads_tpl );

$template = $template->display ();
$headline_template = $template;

////////////////////////////
////// News ausgeben ///////
////////////////////////////

$index = $FD->sql()->conn()->query('SELECT * FROM '.$FD->config('pref')."news
                      WHERE news_date <= $time
                      AND news_active = 1
                      ".$cat_filter."
                      ORDER BY news_date DESC
                      LIMIT $config_arr[num_news]");
initstr($news_template);
while ($news_arr = $index->fetch(PDO::FETCH_ASSOC))
{
    $news_template .= display_news($news_arr, $config_arr['html_code'], $config_arr['fs_code'], $config_arr['para_handling']);
}
unset($news_arr);

// Get Template
$template = new template();
$template->setFile('0_news.tpl');
$template->load('BODY');

$template->tag('news', $news_template );
$template->tag('headlines', $headline_template );

$template = $template->display ();
?>
