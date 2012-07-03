<?php if (!defined('ACP_GO')) die('Unauthorized access!');

// Online since
$online_since = $sql->getRow('counter_stat', array('s_year', 's_month', 's_day'), array('O' => '`s_year`, `s_month`, `s_day`'));
$online_since = date_loc($FD->config('date'), strtotime($online_since['s_year'].'-'.$online_since['s_month'].'-'.$online_since['s_day']));

// Total
$total = $sql->getRow('counter', array('visits', 'hits'));

// Today
$today = $sql->getRow('counter_stat', array('s_hits', 's_visits'), array('W' => "`s_year` = '".$FD->env('year')."' AND `s_month` = '".(int) $FD->env('month')."' AND `s_day` = '".(int) $FD->env('day')."'"));


// Any users online
$online = get_online_ips();

// Referrer Num
$index = $sql->doQuery("SELECT COUNT(`ref_url`) AS 'ref_num' FROM {..pref..}counter_ref");
$ref['num'] = mysql_result($index, 0, 'ref_num');

if ($ref['num'] > 0) {
	// last Ref
	$index = $sql->doQuery('SELECT ref_url, ref_last FROM {..pref..}counter_ref ORDER BY ref_last DESC LIMIT 0,1');
	$ref['url'] = stripslashes(mysql_result($index, 0, 'ref_url'));
	$ref['shorturl'] = cut_in_string($ref['url'], 50, '...');

	$ref['date_time'] = date_loc($FD->text('admin', 'date_time'), mysql_result($index, 0, 'ref_last'));
}

// Conditions
$adminpage->addCond('ref_link',($ref['num'] > 0));
$adminpage->addCond('hans', true);
$adminpage->addCond('wurst', false);
$adminpage->addCond('thomas', false);

// Values
$adminpage->addText('title', $FD->config('title'));
$adminpage->addText('url', $FD->config('virtualhost'));
$adminpage->addText('online_since', $online_since);
$adminpage->addText('online_visitors', $online['all']);
$adminpage->addText('online_guests', $online['guests']);
$adminpage->addText('online_registered', $online['users']);
$adminpage->addText('visits_total', $total['visits']);
$adminpage->addText('visits_today', $today['s_visits']);
$adminpage->addText('hits_total', $total['hits']);
$adminpage->addText('hits_today', $today['s_hits']);
$adminpage->addText('num_of_refs', $ref['num']);
$adminpage->addText('ref_url', $ref['url']);
$adminpage->addText('ref_shorturl', $ref['shorturl']);
$adminpage->addText('ref_date', $ref['date_time']);

echo $adminpage->get('main');

?>
