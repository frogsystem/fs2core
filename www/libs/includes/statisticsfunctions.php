<?php

///////////////////
//// count hit ////
///////////////////
function count_all ( $GOTO )
{
    $hit_year = date ( 'Y' );
    $hit_month = date ( 'm' );
    $hit_day = date ( 'd' );

    visit_day_exists ( $hit_year, $hit_month, $hit_day );
    count_hit ( $GOTO );
}

///////////////////////////////////
//// check if visit day exists ////
///////////////////////////////////
function visit_day_exists ( $YEAR, $MONTH, $DAY )
{
    global $FD;

    // check if visit-day exists
    $daycounter = $FD->db()->conn()->query ('SELECT * FROM '.$FD->env('DB_PREFIX').'counter_stat
                                WHERE s_year = '.$YEAR.' AND s_month = '.$MONTH.' AND s_day = '.$DAY);

    if ( $daycounter->fetch(PDO::FETCH_ASSOC) === false )
    {
        $FD->db()->conn()->exec('INSERT INTO '.$FD->env('DB_PREFIX')."counter_stat (s_year, s_month, s_day, s_visits, s_hits) VALUES ('".$YEAR."', '".$MONTH."', '".$DAY."', '0', '0')" );
    }
}


///////////////////
//// count hit ////
///////////////////
function count_hit ( $GOTO )
{
    global $FD;

    $hit_year = date ( 'Y' );
    $hit_month = date ( 'm' );
    $hit_day = date ( 'd' );

    if ( $GOTO != '404' && $GOTO != '403' ) {
        // count page_hits
        $FD->db()->conn()->exec ( 'UPDATE '.$FD->env('DB_PREFIX').'counter SET hits = hits + 1' );
        $FD->db()->conn()->exec ( 'UPDATE '.$FD->env('DB_PREFIX').'counter_stat
                                    SET s_hits = s_hits + 1
                                    WHERE s_year = '.$hit_year.' AND s_month = '.$hit_month.' AND s_day = '.$hit_day );
    }
}


/////////////////////
//// count visit ////
/////////////////////
function count_visit ()
{
    global $FD;

    $visit_year = date ( 'Y' );
    $visit_month = date( 'm' );
    $visit_day = date ( 'd' );

    $FD->db()->conn()->exec('UPDATE '.$FD->env('DB_PREFIX').'counter SET visits = visits + 1');
    $FD->db()->conn()->exec('UPDATE '.$FD->env('DB_PREFIX').'counter_stat
                              SET s_visits = s_visits + 1
                              WHERE s_year = '.$visit_year.' AND s_month = '.$visit_month.' AND s_day = '.$visit_day);
}


///////////////////////
//// save visitors ////
///////////////////////
function save_visitors ()
{
    global $FD;

    clean_iplist(); // remove old users first

    // get user_id or set user_id=0
    if (is_loggedin() && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        settype($user_id, 'integer');
    } else {
        $user_id = 0;
    }

    // Exisiting user for ip?
    $user = $FD->db()->conn()->prepare('SELECT * FROM '.$FD->env('DB_PREFIX').'useronline WHERE `ip` = ? LIMIT 1');
    $user->execute(array($_SERVER['REMOTE_ADDR']));
    $user = $user->fetch(PDO::FETCH_ASSOC);

    // no user => create new
    if (empty($user)) {
        $stmt = $FD->db()->conn()->prepare('INSERT INTO '.$FD->env('DB_PREFIX').'useronline SET `ip` = ?, user_id='.$user_id.', date='.(int) $FD->env('time'));
        $stmt->execute(array($_SERVER['REMOTE_ADDR']));

        // and count the visit
        count_visit();
    }

    // new user_id (and update time)
    else if ($user['user_id'] != $user_id) {
        $stmt = $FD->db()->conn()->prepare('UPDATE '.$FD->env('DB_PREFIX').'useronline SET user_id = '.$user_id.', date = '.(int) $FD->env('time').' WHERE ip = ? LIMIT 1');
        $stmt->execute(array($_SERVER['REMOTE_ADDR']));
    }

    // we know the user => just update time
    else {
        $stmt = $FD->db()->conn()->prepare('UPDATE '.$FD->env('DB_PREFIX').'useronline SET date = '.(int) $FD->env('time').' WHERE ip = ? LIMIT 1');
        $stmt->execute(array($_SERVER['REMOTE_ADDR']));
    }
}



//////////////////////
//// save referer ////
//////////////////////
function save_referer ()
{
    global $FD;

	if (isset($_SERVER['HTTP_REFERER'])) {

		$time = time(); // timestamp
		// save referer
		$referer = preg_replace ( "=(.*?)\=([0-9a-z]{32})(.*?)=i", "\\1=\\3", $_SERVER['HTTP_REFERER'] );
		$index = $FD->db()->conn()->prepare ( 'SELECT * FROM '.$FD->env('DB_PREFIX').'counter_ref WHERE ref_url = ?' );
		$index->execute(array($referer));

		if ( $index->fetch(PDO::FETCH_ASSOC) === false ) {
			if ( substr_count ( $referer, 'http://' ) >= 1 && substr_count ( $referer, $FD->config('virtualhost') ) < 1 ) {
				$stmt = $FD->db()->conn()->prepare ( 'INSERT INTO '.$FD->env('DB_PREFIX')."counter_ref (ref_url, ref_count, ref_first, ref_last) VALUES (?, '1', '".$time."', '".$time."')" );
				$stmt->execute(array($referer));
			}
		} else {
			if ( substr_count ( $referer, 'http://' ) >= 1 && substr_count ( $referer, $FD->config('virtualhost') ) < 1 ) {
				$stmt = $FD->db()->conn()->prepare ( 'UPDATE '.$FD->env('DB_PREFIX')."counter_ref SET ref_count = ref_count + 1, ref_last = '".$time."' WHERE ref_url = ? LIMIT 1" );
				$stmt->execute(array($referer));
			}
		}
	}
}



/////////////////////////
//// Delete Referrers ///
/////////////////////////
function delete_referrers ($days, $hits, $contact, $age, $amount, $time = null) {

    global $FD;

    // set now
    if (empty($time))
        $time = $FD->cfg('time');

    // get last date
    $del_date = $time - $days * 86400;

    // security and sql prepartion
    settype($hits, 'integer');
    switch ($contact) {
        case 'first': $contact = 'first'; break;
        default: $contact = 'last'; break;
    }
    switch ($age) {
        case 'older': $age = '<'; break;
        default: $age = '>'; break;
    }
    switch ($amount) {
        case 'less': $amount = '<'; break;
        default: $amount = '>'; break;
    }

    return $FD->db()->conn()->exec('DELETE FROM '.$FD->env('DB_PREFIX').'counter_ref WHERE `ref_'.$contact.'` '.$age." '".$del_date."' AND `ref_count` ".$amount." '".$hits."'");
}

//////////////////////////////////////
//// clean up referrers by config ////
//////////////////////////////////////
function clean_referers ($time = null) {
    global $FD;

    // set time
    if (empty($time))
        $time = $FD->env('time');

    if ($FD->cfg('cronjobs', 'ref_cron') == 1) {
        delete_referrers(
            $FD->cfg('cronjobs', 'ref_days'),
            $FD->cfg('cronjobs', 'ref_hits'),
            $FD->cfg('cronjobs', 'ref_contact'),
            $FD->cfg('cronjobs', 'ref_age'),
            $FD->cfg('cronjobs', 'ref_amount'),
            $time);
    }
}





////////////////////
//// IPs Online ///
////////////////////
function get_online_ips () {
    global $FD;

    // init array
    $numbers = array('users' => 0, 'guests' => 0, 'all' => 0);

    // get values from db
    $numbers['users'] = $FD->db()->conn()->query(
                            'SELECT COUNT(user_id) AS users
                             FROM '.$FD->env('DB_PREFIX')."useronline
                             WHERE `date` > '".($FD->env('time')-300)."' AND `user_id` != 0");
    $numbers['users'] = $numbers['users']->fetchColumn();
    $numbers['guests'] = $FD->db()->conn()->query(
                            'SELECT COUNT(user_id) AS guests
                             FROM '.$FD->env('DB_PREFIX')."useronline
                             WHERE `date` > '".($FD->env('time')-300)."' AND `user_id` = 0");
    $numbers['guests'] = $numbers['guests']->fetchColumn();

    //calc all
    $numbers['all'] = $numbers['users'] + $numbers['guests'];

    return $numbers;
}

//////////////////////
//// clean iplist ////
//////////////////////
function clean_iplist()
{
    global $FD;

    $time = strtotime('today');
    $FD->db()->conn()->exec('DELETE FROM '.$FD->env('DB_PREFIX')."useronline WHERE `date` < '".$time."'");
}


?>
