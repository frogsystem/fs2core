<?php
// Online since
$online_since = $sql->getRow("counter_stat", array("s_year", "s_month", "s_day"), array('O' => "`s_year`, `s_month`, `s_day`"));
$online_since = date_loc($global_config_arr['date'], strtotime($online_since['s_year']."-".$online_since['s_month']."-".$online_since['s_day']));

// Total
$total = $sql->getRow("counter", array("visits", "hits"));

// Today
$today = $sql->getRow("counter_stat", array("s_hits", "s_visits"), array('W' => "`s_year` = '".$global_config_arr['env']['year']."' AND `s_month` = '".(int) $global_config_arr['env']['month']."' AND `s_day` = '".(int) $global_config_arr['env']['day']."'"));


// Visitors online
$index = $sql->doQuery("SELECT count(user_id) AS visitors_on FROM {..pref..}useronline");
$online['visitors'] = mysql_result($index, 0, "visitors_on");

// Users online
$index = $sql->doQuery("SELECT count(user_id) AS user_on FROM {..pref..}useronline WHERE user_id != 0");
$online['users'] = mysql_result($index, 0, "user_on");

// Guests online
$online['guests'] = $online['visitors'] - $online['users'];

// Referrer Num
$index = $sql->doQuery("SELECT COUNT(`ref_url`) AS 'ref_num' FROM {..pref..}counter_ref");
$ref['num'] = mysql_result($index, 0, "ref_num");

if ($ref['num'] > 0) {
	// last Ref
	$index = $sql->doQuery("SELECT ref_url, ref_last FROM {..pref..}counter_ref ORDER BY ref_last DESC LIMIT 0,1");
	$ref['url'] = stripslashes(mysql_result($index, 0, "ref_url"));
	$ref['shorturl'] = cut_in_string($ref['url'], 50, "...");

	$ref['date_time'] = date_loc($TEXT['admin']->get("date_time"), mysql_result($index, 0, "ref_last"));
}

echo '
                        <table class="configtable" cellpadding="4" cellspacing="0">
                                                        <tr><td class="line" colspan="2">'.$TEXT['admin']->get("informations_and_statistics").'</td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("title").':</td>
                                <td class="configthin"><b>'.$global_config_arr['title'].'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("url").':</td>
                                <td class="configthin"><a href="'.$global_config_arr['virtualhost'].'" target="_blank"><b>'.$global_config_arr['virtualhost'].'</b></a></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("online_since").':</td>
                                <td class="configthin"><b>'.$online_since.'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("online_visitors").':</td>
                                <td class="configthin"><b>'.$online['visitors'].'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("online_guests").':</td>
                                <td class="configthin"><b>'.$online['guests'].'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("online_registered").':</td>
                                <td class="configthin"><b>'.$online['users'].'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("visits_total").':</td>
                                <td class="configthin"><b>'.$total['visits'].'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("visits_today").':</td>
                                <td class="configthin"><b>'.$today['s_visits'].'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("hits_total").':</td>
                                <td class="configthin"><b>'.$total['hits'].'</b></td>
                            </tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("hits_today").':</td>
                                <td class="configthin"><b>'.$today['s_hits'].'</b></td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("num_of_refs").':</td>
                                <td class="configthin"><b>'.$ref['num'].'</b></td>
                            </tr>

';

if ($ref['num'] > 0) {
        echo '
                            <tr>
                                <td class="configthin" width="200">'.$TEXT['page']->get("last_ref").':</td>
                                <td class="configthin"><a href="'.$ref['url'].'" target="_blank"><b>'.$ref['shorturl'].'</b></a><br>
                                <strong>'.$ref['date_time'].'</strong></td>
                            </tr>
        ';
}

echo '
                                                </table>
';
?>
