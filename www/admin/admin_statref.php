<?php if (!defined('ACP_GO')) die('Unauthorized access!');

###################
## Page Settings ##
###################
$cronjobs_cols = array('ref_cron', 'ref_days', 'ref_hits', 'ref_contact', 'ref_age', 'ref_amount');

////////////////////////
//// Delete Referer ////
////////////////////////

if (
    has_perm('stat_ref_delete')
    && isset($_POST['delete_referrer']) && $_POST['delete_referrer'] == 1 && isset ( $_POST['del_days'] ) && isset ( $_POST['del_hits'] )
) {
    settype ($_POST['del_cron'], 'integer');
    settype ($_POST['del_days'], 'integer');
    settype ($_POST['del_hits'], 'integer');

	if ( $_POST['del_days'] < 1 )
    {
        systext ( $FD->text('page', 'referrer_not_enough_days'), $FD->text('page', 'error'), TRUE );
    }
	elseif ( $_POST['del_hits'] < 1 )
    {
        systext ( $FD->text('page', 'referrer_not_enough_hits'), $FD->text('page', 'error'), TRUE );
    }
    else
    {

        // Delete Refs now
        if ($_POST['del_cron'] == 42) {
            $rows = delete_referrers ($_POST['del_days'], $_POST['del_hits'], $_POST['del_contact'], $_POST['del_age'], $_POST['del_amount']);

            $message =  $FD->text('page', 'referrer_deleted_entries') . ':<br>' .
                        '"'.$FD->text('page', 'referrer_'.$_POST['del_contact']) . ' ' .
                        $FD->text('page', 'referrer_delete_'.$_POST['del_age']) . ' ' .
                        $_POST['del_days'] . ' ' .
                        $FD->text('page', 'referrer_delete_days') . ' ' .
                        $FD->text('page', 'referrer_delete_and') . ' ' .
                        $FD->text('page', 'referrer_delete_'.$_POST['del_amount']) . ' ' .
                        $_POST['del_hits'] . ' ' .
                        $FD->text('page', 'referrer_delete_hits').'"' . '<br><br>' .
                        $FD->text('page', 'affected_rows') . ': ' .
                        $rows ;
            systext ( $message, $FD->text("page", "info") );

        // save config for referer cronjob
        } else {
            try {
                $config = array(
                    'ref_cron' => $_POST['del_cron'],
                    'ref_days' => $_POST['del_days'],
                    'ref_hits' => $_POST['del_hits'],
                    'ref_contact' => $_POST['del_contact'],
                    'ref_age' => $_POST['del_age'],
                    'ref_amount' => $_POST['del_amount']
                );
                $FD->saveConfig('cronjobs', $config);
                systext($FD->text('admin', 'config_saved'), $FD->text('admin', 'info'), 'green', $FD->text('admin', 'icon_save_ok'));
            } catch (Exception $e) {
                systext($FD->text('admin', 'config_not_saved'), $FD->text('admin', 'error'), 'green', $FD->text('admin', 'icon_save_error'));
            }
        }
    }
}

//////////////////////
/// Define Filter ////
//////////////////////

else
{
    if ( !isset ( $_POST['limit'] ) )
    {
        $_POST['limit'] = 50;
    }

    settype ( $_POST['limit'], 'integer' );
    if (!isset($_POST['filter'])) $_POST['filter'] = '';
    $filter = $_POST['filter'];
    $_POST['filter'] = killhtml ( $_POST['filter'] );

    if (!isset($_POST['order'])) $_POST['order'] = 'f'; //default
    switch ( $_POST['order'] )
    {
        case 'u': $usel = 'selected'; $csel = ''; $lsel = ''; $fsel = ''; break;
        case 'c': $csel = 'selected'; $usel = ''; $lsel = ''; $fsel = ''; break;
        case 'l': $lsel = 'selected'; $usel = ''; $csel = ''; $fsel = ''; break;
        default:
			$fsel = 'selected';
			$usel = ''; $csel = ''; $lsel = '';
			$_POST['order'] = 'f';
			break;
    }

    if (!isset($_POST['sort'])) $_POST['sort'] = 'DESC'; //default
    switch ( $_POST['sort'] )
    {
        case 'ASC':
            $ascsel = 'selected';
            $descsel = '';
            break;
        default:
			$descsel = 'selected';
			$ascsel = '';
			$_POST['sort'] = 'DESC';
			break;
    }

    echo'
					<form action="" method="post">
                        <input type="hidden" value="stat_ref" name="go">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$FD->text('page', 'referrer_filter_title').'</td></tr>
							<tr>
                                <td class="config middle">
                                    '.$FD->text('page', 'referrer_show').':
                                </td>
                                <td class="config" width="100%">
                                    <input name="limit" size="4" maxlength="3" class="text" value="'.$_POST['limit'].'">
                                    '.$FD->text('page', 'referrer_orderby').'
                                    <select name="order">
                                        <option value="c" '.$csel.'>'.$FD->text('page', 'referrer_hits').'</option>
                                        <option value="f" '.$fsel.'>'.$FD->text('page', 'referrer_first').'</option>
                                        <option value="l" '.$lsel.'>'.$FD->text('page', 'referrer_last').'</option>
                                        <option value="u" '.$usel.'>'.$FD->text('page', 'referrer_url').'</option>
                                    </select>,
                                    <select name="sort">
                                        <option value="ASC" '.$ascsel.'>'.$FD->text('page', 'ascending').'</option>
                                        <option value="DESC" '.$descsel.'>'.$FD->text('page', 'descending').'</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="config middle">
                                    '.$FD->text('page', 'referrer_filter').':
                                </td>
                                <td class="config" width="100%">
                                    <input class="text" style="width: 100%;" name="filter" maxlength="255" value="'.$_POST['filter'].'">
                                </td>
                            </tr>
						</table>
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="config">
                                    <span class="small">
										'.$FD->text('page', 'referrer_filter_info1').'<br>
                                    	'.$FD->text('page', 'referrer_filter_info2').'
									</span>
                                </td>
                                <td align="right" valign="bottom">
                                    <input type="submit" value="'.$FD->text('page', 'show_button').'" class="button">
                                </td>
                            </tr>
                        </table>
					</form>
	';

/////////////////////
/// Show Referer ////
/////////////////////

    echo'
						<table class="configtable" cellpadding="4" cellspacing="0">
                            <tr><td class="space"></td></tr>
							<tr><td class="line">'.$FD->text('page', 'referrer_list_title').'</td></tr>
						</table>

						<table class="configtable" style="border-collapse: collapse; border: 1px solid #000000;" cellpadding="1" cellspacing="0" border="1">
						<tr>
                            <td class="h" align="center" colspan="5">
                                <b>'.$FD->text('page', 'referrer_table_title').'</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="h" align="center">
                                <b>'.$FD->text('page', 'referrer_table_url').'</b>
                            </td>
                            <td class="h" align="center">
                                <b>'.$FD->text('page', 'referrer_table_hits').'</b>
                            </td>
                            <td class="h" align="center">
                                <b>'.$FD->text('page', 'referrer_table_first').'</b>
                            </td>
                            <td class="h" align="center">
                                <b>'.$FD->text('page', 'referrer_table_last').'</b>
                            </td>
                        </tr>
	';

    $query = get_filter_where ( $filter, 'ref_url' );

    switch ( $_POST['order'] )
    {
        case 'u':
            $query .= ' ORDER BY ref_url '.$_POST['sort'].' LIMIT '.$_POST['limit'];
            break;
        case 'c':
            $query .= ' ORDER BY ref_count '.$_POST['sort'].' LIMIT '.$_POST['limit'];
            break;
        case 'l':
            $query .= ' ORDER BY ref_last '.$_POST['sort'].' LIMIT '.$_POST['limit'];
            break;
        default:
            $query .= ' ORDER BY ref_first '.$_POST['sort'].' LIMIT '.$_POST['limit'];
            break;
    }

    $index = $FD->db()->conn()->query ( 'SELECT COUNT(*) FROM '.$FD->env('DB_PREFIX').'counter_ref '.$query.'' );
    $referrer_number = $index->fetchColumn();
    if ( $referrer_number <= 0 ) {
    	echo'
                        <tr>
                            <td class="n" align="center" colspan="4">
                                '.$FD->text('page', 'referrer_no_entries').'
                            </td>
                        </tr>
		';
	}

    $index = $FD->db()->conn()->query ( 'SELECT * FROM '.$FD->env('DB_PREFIX').'counter_ref '.$query.'' );
	while ( $referrer_arr = $index->fetch(PDO::FETCH_ASSOC) )
    {
        $dburlfull = $referrer_arr['ref_url'];

		$referrer_arr['ref_url'] = substr ( $referrer_arr['ref_url'], 7 );
		$referrer_maxlenght = 40;
		if (strlen($referrer_arr['ref_url']) > $referrer_maxlenght)
        {
            $referrer_arr['ref_url'] = substr($referrer_arr['ref_url'],0, $referrer_maxlenght) . '...';
        }

		$referrer_arr['ref_first'] = date('d.m.Y H:i', $referrer_arr['ref_first']);
        $referrer_arr['ref_last'] = date('d.m.Y H:i', $referrer_arr['ref_last']);

		if ( $referrer_arr['ref_url'] == '' ) {
            echo'
                        <tr>
                            <td class="n" align="left">
                                '.$FD->text('page', 'referrer_unknown').'
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr['ref_count'].'
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr['ref_first'].'
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr['ref_last'].'
                            </td>
                        </tr>
            ';
        } else {
			echo'
                        <tr>
                            <td class="n" align="left">
                                <a href="'.$dburlfull.'" style="text-decoration:none;" target="_blank" title="'.$dburlfull.'">
                                   '.$referrer_arr['ref_url'].'
                                </a>
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr['ref_count'].'
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr['ref_first'].'
                            </td>
                            <td class="n" align="center">
                                '.$referrer_arr['ref_last'].'
                            </td>
                        </tr>
			';
		}
	}

    echo'
					</table>
	';

//////////////////////
/// Delete Referer ///
//////////////////////
    if (has_perm('stat_ref_delete')) {

        // Get Config data
        $FD->loadConfig('cronjobs');
        $cronjobs = $FD->configObject('cronjobs')->getConfigArray();
        
        $cronjobs = array_filter_keys($cronjobs, $cronjobs_cols);
        putintopost($cronjobs);

        // security functions
        $_POST = array_map('killhtml', $_POST);

        echo'
                    <form action="" method="post">
                        <input type="hidden" value="stat_ref" name="go">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="space"></td></tr>
							<tr><td class="line" colspan="3">'.$FD->text('page', 'referrer_delete_title').'</td></tr>
							<tr>
                                <td class="config">
                                    '.$FD->text('page', 'referrer_delete_entries').'
                                </td>
                            </tr>
							<tr>
                                <td class="config">
                                    '.$FD->text('page', 'referrer_delete_with').'
                                    &nbsp;
                                    <select name="del_contact">
                                        <option value="first" '.getselected($_POST['ref_contact'], 'first').'>'.$FD->text('page', 'referrer_first').'</option>
                                        <option value="last" '.getselected($_POST['ref_contact'], 'last').'>'.$FD->text('page', 'referrer_last').'</option>
                                    </select>
                                    &nbsp;
                              		<select name="del_age">
                                        <option value="older" '.getselected($_POST['ref_age'], 'older').'>'.$FD->text('page', 'referrer_delete_older').'</option>
                                        <option value="younger" '.getselected($_POST['ref_age'], 'younger').'>'.$FD->text('page', 'referrer_delete_younger').'</option>
                                    </select>
                                    &nbsp;
                                    <input class="text" name="del_days" size="3" maxlength="3" value="'.$_POST['ref_days'].'">
                                    '.$FD->text('page', 'referrer_delete_days').'
                                </td>
                            </tr>
							<tr>
                                <td class="config">
                                    '.$FD->text('page', 'referrer_delete_and').'
                                    &nbsp;
                                    <select name="del_amount">
                                        <option value="less" '.getselected($_POST['ref_amount'], 'less').'>'.$FD->text('page', 'referrer_delete_less').'</option>
                                        <option value="more" '.getselected($_POST['ref_amount'], 'more').'>'.$FD->text('page', 'referrer_delete_more').'</option>
                                    </select>
                                    &nbsp;
                                    <input class="text" name="del_hits" size="3" maxlength="3" value="'.$_POST['ref_hits'].'">
                                    '.$FD->text('page', 'referrer_delete_hits').'
                                    &nbsp;
                                    <select name="del_cron">
                                        <option value="42">'.$FD->text('page', 'referrer_delete_oncenow').'</option>
                                        <option value="1">
                                            '.$FD->text('page', 'referrer_delete_daily').
                                            ($_POST['ref_cron'] == 1 ? ' ('.$FD->text('admin', 'active').')' : '').'
                                        </option>
                                        <option value="0">
                                            '.$FD->text('page', 'referrer_delete_only_manually').
                                            ($_POST['ref_cron'] == 0 ? ' ('.$FD->text('admin', 'active').')' : '').'
                                        </option>
                                    </select>&nbsp;.
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd">
                                    <button class="button_new" type="submit" name="delete_referrer" value="1">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('admin', 'save_changes_button').' / '.$FD->text('admin', 'do_action_button_long').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}




//////////////////////////////////////
//// Where Clause for Text-Filter ////
//////////////////////////////////////
function get_filter_where ( $FILTER, $SEARCH_FIELD )
{
    $filterarray = explode ( ',', $FILTER );
    $filterarray = array_map ( 'trim', $filterarray );
    $query = '';
    $and_query = '';
    $or_query = '';

    $first_and = true;
    $first_or = true;

    foreach ( $filterarray as $string )
    {
        if ( substr ( $string, 0, 1 ) == '!' && substr ( $string, 1 ) != '' )
        {
            $like = $SEARCH_FIELD.' NOT LIKE';
            $string = substr ( $string, 1 );
            if ( !$first_and )
            {
                $and_query .= ' AND ';
            }
            $and_query .= $like . " '%" . $string . "%'";
            $first_and = false;
        }
        elseif ( substr ( $string, 0, 1 ) != '!' && $string != '' )
        {
            $like = $SEARCH_FIELD.' LIKE';
            if ( !$first_or )
            {
                $or_query .= ' OR ';
            }
            $or_query .= $like . " '%" . $string . "%'";
            $first_or = false;
        }
    }

    if ( $or_query != '' )
    {
        $or_query = '('.$or_query.')';
        if ( $and_query != '' )
        {
            $and_query = ' AND '.$and_query;
        }
    }

    if ( $or_query != '' || $and_query != '' )
    {
        $query = 'WHERE ';
    }
    $query .= $or_query . $and_query;

    return $query;
}
?>
