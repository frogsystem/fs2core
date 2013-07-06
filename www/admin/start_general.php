<?php if (!defined('ACP_GO')) die('Unauthorized access!');

// Online since
$online_since = $sql->conn()->query('SELECT s_year, s_month, s_day FROM `'.$FD->config('pref').'counter_stat` ORDER BY `s_year`, `s_month`, `s_day` LIMIT 1');
$online_since = $online_since->fetch(PDO::FETCH_ASSOC);
$online_since = date_loc($FD->config('date'), strtotime($online_since['s_year'].'-'.$online_since['s_month'].'-'.$online_since['s_day']));

// Total
$total = $sql->conn()->query('SELECT visits, hits FROM `'.$FD->config('pref').'counter` LIMIT 1');
$total = $total->fetch(PDO::FETCH_ASSOC);
// Today
$today = $sql->conn()->query('SELECT s_hits, s_visits FROM `'.$FD->config('pref').'counter_stat` WHERE `s_year` = \''.(int) $FD->env('year')."' AND `s_month` = '".(int) $FD->env('month')."' AND `s_day` = '".(int) $FD->env('day')."' LIMIT 1");
$today = $today->fetch(PDO::FETCH_ASSOC);


// Any users online
$online = get_online_ips();

// Referrer Num
$index = $sql->conn()->query("SELECT COUNT(`ref_url`) AS 'ref_num' FROM ".$FD->config('pref')."counter_ref");
$ref['num'] = $index->fetchColumn();

if ($ref['num'] > 0) {
	// last Ref
	$index = $sql->conn()->query('SELECT ref_url, ref_last FROM '.$FD->config('pref').'counter_ref ORDER BY ref_last DESC LIMIT 0,1');
	$row = $index->fetch(PDO::FETCH_ASSOC);
	$ref['url'] = $row['ref_url'];
	$ref['shorturl'] = cut_in_string($ref['url'], 50, '...');

	$ref['date_time'] = date_loc($FD->text('admin', 'date_time'), $row['ref_last']);
}

// Conditions
$adminpage->addCond('ref_link',($ref['num'] > 0));

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
