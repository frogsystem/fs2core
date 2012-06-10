<?php
// Initialise Time Variables
$stats_year = date ( 'Y' );
$stats_month = date ( 'm' );
$stats_day = date ( 'd' );


// Overall Data
$index = mysql_query ( 'SELECT * FROM '.$global_config_arr['pref'].'counter', $FD->sql()->conn() );
$counter_arr = mysql_fetch_assoc ( $index ) ;


// Visitors today
$index = mysql_query ( '
                        SELECT
                            `s_hits`, `s_visits`
                        FROM
                            `'.$global_config_arr['pref']."counter_stat`
                        WHERE
                            `s_year` = '".$stats_year."'
                        AND
                            `s_month` = '".$stats_month."'
                        AND
                            `s_day` = '".$stats_day."'
", $FD->sql()->conn() );
$today_arr = mysql_fetch_assoc ( $index );


// Visitors online
$index = mysql_query ( "
                        SELECT
                            count(`ip`) AS 'total'
                        FROM
                            `".$global_config_arr['pref'].'useronline`
', $FD->sql()->conn() );
$useronline_arr['total'] = mysql_result ( $index, 0, 'total' );

// Registered online
$index = mysql_query ( "
                        SELECT
                            count(`ip`) AS 'registered'
                        FROM
                            `".$global_config_arr['pref'].'useronline`
                        WHERE
                            `user_id` != 0
', $FD->sql()->conn() );
$useronline_arr['registered'] = mysql_result ( $index, 0, 'registered' );

// Guests online
$index = mysql_query ( "
                        SELECT
                            count(`ip`) AS 'guests'
                        FROM
                            `".$global_config_arr['pref'].'useronline`
                        WHERE
                            `user_id` = 0
', $FD->sql()->conn() );
$useronline_arr['guests'] = mysql_result ( $index, 0, 'guests' );


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
