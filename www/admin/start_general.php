<?php
// On since
$index = mysql_query ( "
                                                SELECT s_year, s_month, s_day
                                                FROM ".$global_config_arr['pref']."counter_stat
                                                ORDER BY s_year ASC, s_month ASC, s_day ASC
                                                LIMIT 0,1
", $db );
$page_on = mysql_result ( $index, 0, "s_day" ) . ". " . mysql_result ( $index, 0, "s_month" ) . ". " . mysql_result ( $index, 0, "s_year" );

// initialise time variables
$stats_year = date ( "Y" );
$stats_month = date ( "m" );
$stats_day = date ( "d" );

// Statsistiken
$index = mysql_query("SELECT visits, hits FROM ".$global_config_arr[pref]."counter", $db);
$visits_all = mysql_result ( $index, 0, "visits" );
$hits_all = mysql_result ( $index, 0, "hits" );

// Besucher heute
$today_arr = $sql->getData("counter_stat", "s_hits,s_visits", "WHERE `s_year` = '".$stats_year."' AND `s_month` = '".$stats_month."' AND `s_day` = '".$stats_day."'", 1);
$today_arr = $sql->isUsefulGet() ? $today_arr : array("s_visits" => 0, "s_hits" => 0);

// Besucher online
$index = mysql_query("SELECT count(*) AS visitors_on FROM ".$global_config_arr[pref]."useronline", $db);
$visitors_on = mysql_result ( $index, 0, "visitors_on" );

// Registrierte online
$index = mysql_query("SELECT count(*) AS user_on FROM ".$global_config_arr[pref]."useronline WHERE user_id != 0", $db);
$user_on = mysql_result ( $index, 0, "user_on" );

// Gäste online
$guest_on = $visitors_on - $user_on;

// Referrer Num
$index = mysql_query ( "
                                                SELECT COUNT(`ref_url`) AS 'ref_num'
                                                FROM ".$global_config_arr['pref']."counter_ref
                                                LIMIT 0,1
", $db);
$ref_num = mysql_result ( $index, 0, "ref_num" );

if ( $ref_num  > 0) {
        // last Ref
        $index = mysql_query ( "
                                                        SELECT ref_url, ref_last
                                                        FROM ".$global_config_arr['pref']."counter_ref
                                                        ORDER BY ref_last DESC
                                                        LIMIT 0,1
        ", $db );
        $ref_last = stripslashes ( mysql_result ( $index, 0, "ref_url" ) );
        $ref_last_long = $ref_last;
        $referrer_maxlenght = 55;
        if ( strlen ( $ref_last ) > $referrer_maxlenght ) {
            $ref_last = substr ( $ref_last , 0, $referrer_maxlenght ) . "...";
        }
        $ref_date = date_loc ( "d. m. Y", mysql_result ( $index, 0, "ref_last" ) );
        $ref_time = date_loc ( "H:i", mysql_result ( $index, 0, "ref_last" ) );
}

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="2">Informationen & Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Titel:</td>
                                <td class="configthin"><b>'.$global_config_arr['title'].'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">URL:</td>
                                <td class="configthin"><a href="'.$global_config_arr['virtualhost'].'" target="_blank"><b>'.$global_config_arr['virtualhost'].'</b></a></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Online seit:</td>
                                <td class="configthin"><b>'.$page_on.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Besucher online:</td>
                                <td class="configthin"><b>'.$visitors_on.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">davon Gäste:</td>
                                <td class="configthin"><b>'.$guest_on.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">davon registrierte:</td>
                                <td class="configthin"><b>'.$user_on.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Besucher gesamt:</td>
                                <td class="configthin"><b>'.$visits_all.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Besucher heute:</td>
                                <td class="configthin"><b>'.$today_arr['s_visits'].'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Hits gesamt:</td>
                                <td class="configthin"><b>'.$hits_all.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Hits heute:</td>
                                <td class="configthin"><b>'.$today_arr['s_hits'].'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Referrer:</td>
                                <td class="configthin"><b>'.$ref_num.'</b></td>
                            </tr>

';

if ( $ref_num  > 0) {
        echo '
                            <tr>
                                <td class="configthin" width="200">Letzter Kontakt von:</td>
                                <td class="configthin"><a href="'.$ref_last_long.'" target="_blank"><b>'.$ref_last.'</b></a><br>
                                am <b>'.$ref_date.'</b> um <b>'.$ref_time.'</b> Uhr</td>
                            </tr>
        ';
}

echo '
                                                </table>
';
?>