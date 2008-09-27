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
$index = mysql_query("SELECT s_hits, s_visits FROM ".$global_config_arr[pref]."counter_stat WHERE s_year = $stats_year and s_month = $stats_month and s_day = $stats_day", $db);
$visits_today = mysql_result ( $index, 0, "s_visits" );
$hits_today = mysql_result ( $index, 0, "s_hits" );

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

// last Ref
$index = mysql_query ( "
						SELECT ref_url, ref_last
						FROM ".$global_config_arr['pref']."counter_ref
						ORDER BY ref_last DESC
						LIMIT 0,1
", $db );
$ref_last = stripslashes ( mysql_result ( $index, 0, "ref_url" ) );
$ref_date = date ( "d. m. Y", mysql_result ( $index, 0, "ref_last" ) );
$ref_time = date ( "h:i", mysql_result ( $index, 0, "ref_last" ) );

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Informationen & Statistik</td></tr>
                            <tr>
                                <td class="configthin" width="200">Titel:</td>
                                <td class="configthin"><b>'.$global_config_arr['title'].'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">URL:</td>
                                <td class="configthin"><b>'.$global_config_arr['virtualhost'].'</b></td>
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
                                <td class="configthin"><b>'.$visits_today.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Hits gesamt:</td>
                                <td class="configthin"><b>'.$hits_all.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Hits heute:</td>
                                <td class="configthin"><b>'.$hits_today.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">Anzahl Referrer:</td>
                                <td class="configthin"><b>'.$ref_num.'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">Letzter Kontakt von:</td>
                                <td class="configthin"><b>'.$ref_last.'</b><br>
								am <b>'.$ref_date.'</b> um <b>'.$ref_time.'</b> Uhr</td>
                            </tr>
						</table>
';
?>