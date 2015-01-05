<?php
// Initialise Time Variables
$stats_year = date ( 'Y' );
$stats_month = date ( 'm' );
$stats_day = date ( 'd' );


// Overall Data
$index = $FD->sql()->conn()->query ( 'SELECT * FROM '.$FD->config('pref').'counter' );
$counter_arr = $index->fetch( PDO::FETCH_ASSOC ) ;


// Visitors today
$index = $FD->sql()->conn()->query ( '
                        SELECT
                            `s_hits`, `s_visits`
                        FROM
                            `'.$FD->config('pref')."counter_stat`
                        WHERE
                            `s_year` = '".$stats_year."'
                        AND
                            `s_month` = '".$stats_month."'
                        AND
                            `s_day` = '".$stats_day."'" );
$today_arr = $index->fetch( PDO::FETCH_ASSOC );


// Any users online
$online = get_online_ips();

$useronline_arr['total'] = $online['all'];
$useronline_arr['registered'] = $online['users'];
$useronline_arr['guests'] = $online['guests'];


// Create Template
$template = new template();

$template->setFile('0_general.tpl');
$template->load('STATISTICS');

$template->tag('visits', point_number ( $counter_arr['visits'] ) );
$template->tag('visits_today', point_number ( $today_arr['s_visits'] ) );
$template->tag('hits', point_number ( $counter_arr['hits'] ) );
$template->tag('hits_today', point_number ( $today_arr['s_hits'] ) );
$template->tag('visitors_online', point_number ( $useronline_arr['total'] ) );
$template->tag('registered_online', point_number ( $useronline_arr['registered'] ) );
$template->tag('guests_online', point_number ( $useronline_arr['guests'] ) );

$template->tag('num_users', point_number ( $counter_arr['user'] ) );
$template->tag('num_news', point_number ( $counter_arr['news'] ) );
$template->tag('num_comments', point_number ( $counter_arr['comments'] ) );
$template->tag('num_articles', point_number ( $counter_arr['artikel'] ) );

$template = $template->display();
?>
