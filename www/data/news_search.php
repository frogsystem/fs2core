<?php
// Set canonical parameters
$FD->setConfig('info', 'canonical', array('keyword', 'year', 'month'));

// Load News Config
$FD->loadConfig('news');

////////////////////////////////
////// Suchfeld erzeugen ///////
////////////////////////////////

$index = $FD->sql()->conn()->query('SELECT news_date FROM '.$FD->config('pref').'news ORDER BY news_date ASC LIMIT 0,1' );
$years_arr = $index->fetch(PDO::FETCH_ASSOC);
if ($years_arr == false) {
    $years = date('Y');
    $years = '<option value="'.$years.'">'.$years.'</option>';
} else {
    $years = '';
    for ($years_arr['i']=date('Y',$years_arr['news_date']);$years_arr['i']<=date('Y');$years_arr['i']++) {
        $years .= '<option value="'.$years_arr['i'].'">'.$years_arr['i'].'</option>';
    }
}

// Get Template
$template = new template();
$template->setFile('0_news.tpl');
$template->load('SEARCH');

$template->tag('years', $years );
$template->tag('keyword', kill_replacements ( isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '' , TRUE ) );

$template = $template->display ();
$searchform_template = $template;
initstr($news_template);

////////////////////////////////
/// News nach Datum anzeigen ///
////////////////////////////////

if (isset($_REQUEST['year']) && isset($_REQUEST['month']))
{
    settype($_REQUEST['year'], 'integer');
    settype($_REQUEST['month'], 'integer');

    $starttime = mktime(0, 0, 0, $_REQUEST['month'], 0, $_REQUEST['year']);
    $endtime = mktime(0, 0, 0, $_REQUEST['month']+1, 0, $_REQUEST['year']);

    // News lesen und ausgeben
    $index = $FD->sql()->conn()->query ( '
                            SELECT COUNT(*)
                            FROM '.$FD->config('pref').'news
                            WHERE news_date > '.$starttime.'
                            AND `news_date` < '.$endtime.'
                            AND `news_active` = 1
                            AND `news_date` <= '.time() );
    $num_rows = $index->fetchColumn();

    if ($num_rows > 0)  // News vorhanden?
    {
        $index = $FD->sql()->conn()->query ( '
                            SELECT *
                            FROM '.$FD->config('pref').'news
                            WHERE news_date > '.$starttime.'
                            AND `news_date` < '.$endtime.'
                            AND `news_active` = 1
                            AND `news_date` <= '.time().'
                            ORDER BY news_date DESC' );

        $news_template = '';
        while ($news_arr = $index->fetch(PDO::FETCH_ASSOC))
        {
            $news_template .= display_news($news_arr, $FD->cfg('news', 'html_code'), $FD->cfg('news', 'fs_code'), $FD->cfg('news', 'para_handling'));
        }
        unset($news_arr);
    }
    else
    {
        $news_template = sys_message($FD->text('frontend', 'sysmessage'), $FD->text('frontend', 'no_result_time'));
    }
}

////////////////////////////////
// News nach Keyword anzeigen //
////////////////////////////////

elseif (isset($_REQUEST['keyword']))
{
    $prepared_keyword = '%'.$_REQUEST['keyword'].'%';

    // News lesen und ausgeben
    $stmt = $FD->sql()->conn()->prepare ( '
                    SELECT COUNT(*)
                    FROM '.$FD->config('pref')."news
                    WHERE ( news_text LIKE ?
                    OR news_title LIKE ? )
                    AND `news_active` = 1
                    AND `news_date` <= ".time().'
                    ORDER BY news_date DESC' );
    $stmt->execute(array($prepared_keyword, $prepared_keyword));
    $num_rows = $stmt->fetchColumn();
    if ($num_rows > 0)  // News vorhanden?
    {
        $stmt = $FD->sql()->conn()->prepare ( '
                    SELECT *
                    FROM '.$FD->config('pref')."news
                    WHERE ( news_text LIKE ?
                    OR news_title LIKE ? )
                    AND `news_active` = 1
                    AND `news_date` <= ".time().'
                    ORDER BY news_date DESC' );
        $stmt->execute(array($prepared_keyword, $prepared_keyword));

        $news_template = '';
        while ($news_arr = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $news_template .= display_news($news_arr, $FD->cfg('news', 'html_code'), $FD->cfg('news', 'fs_code'), $FD->cfg('news', 'para_handling'));
        }
        unset($news_arr);
    }
    else
    {
        $news_template = sys_message($FD->text('frontend', 'sysmessage'), $FD->text('frontend', 'no_result_word'));
    }
}

$template = $searchform_template.$news_template;

?>
