<?php if (!defined('ACP_GO')) die('Unauthorized access!');

if (!isset($_GET['s_year']))
{
    $_GET['s_year'] = date('Y');
}
if (!isset($_GET['s_month']))
{
    $_GET['s_month'] = date('m');
}
settype ($_GET['s_year'], 'integer');
settype ($_GET['s_month'], 'integer');

$day_arr = explode(',', $FD->text('frontend', 'week_days_array'));
array_unshift($day_arr, array_pop($day_arr));
$month_arr = explode(',', $FD->text('frontend', 'month_names_array'));

/////////////////////////////////
//// Generate year selection ////
/////////////////////////////////

echo'
                    <table class="configtable" cellpadding="4" cellspacing="0">
                        <tr><td class="line" colspan="3">'.$FD->text('page', 'website_statistics').'</td></tr>
                        <tr>
                            <td width="100%" colspan="2" align="center">
';

// Determine first year
$index = $FD->db()->conn()->query('SELECT s_year FROM '.$FD->config('pref').'counter_stat ORDER BY s_year LIMIT 1');
$dbfirstyear = $index->fetchColumn();

// find first month
$index = $FD->db()->conn()->query('SELECT s_month FROM '.$FD->config('pref')."counter_stat WHERE s_year = $dbfirstyear ORDER BY s_month LIMIT 1");
$dbfirstmonth = $index->fetchColumn();

echo '<a href="?go=stat_view&s_year='.$dbfirstyear.'&s_month='.$dbfirstmonth.'">';
if ( $_GET['s_year'] == $dbfirstyear ) { echo '<b>'; }
echo $dbfirstyear;
if ( $_GET['s_year'] == $dbfirstyear ) { echo '</b>'; }
echo '</a>';


// List all other (later) years
if ($dbfirstyear < date('Y'))
{
    for ($y=$dbfirstyear+1; $y<=date('Y'); $y++)
    {
        echo ' | <a href="?go=stat_view&s_year='.$y.'&s_month=1">';
        if ( $_GET['s_year'] == $y ) { echo '<b>'; }
		echo $y;
        if ( $_GET['s_year'] == $y ) { echo '</b>'; }
		echo '</a>';
    }
}

///////////////////////////////////
/// Generate monthly statistics ///
///////////////////////////////////

$monthname = date('n', mktime(0, 0, 0, $_GET['s_month']+1, 0, 0));
echo'
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
                                    <tr>
                                        <td class="h" colspan="4" align="center">
                                            <b>'.$FD->text('page', 'daily_statistics').' ('.$month_arr[$monthname-1].' '.$_GET['s_year'].')</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="h" align="center">
                                            <b>'.$FD->text('page', 'day').'</b>
                                        </td>
                                        <td class="h" align="center">
                                            <b>'.$FD->text('page', 'visits').'</b>
                                        </td>
                                        <td class="h" align="center">
                                            <b>'.$FD->text('page', 'hits').'</b>
                                        </td>
                                        <td class="h" align="center" width="120">
                                            <b>'.$FD->text('page', 'chart').'</b>
                                        </td>
                                    </tr>
';

// Find highest PI count for month
$index = $FD->db()->conn()->query(
             'SELECT s_hits
              FROM '.$FD->config('pref')."counter_stat
              WHERE s_year  = '".$_GET['s_year']."' AND s_month = '".$_GET['s_month']."'
              ORDER BY s_hits desc
              LIMIT 1" );

if (false == ($dbmaxhits = $index->fetchColumn()))
    $dbmaxhits = 0;

// Display Days
$dcount = 0;
$visitsall = 0;
$hitsall = 0;
for ($d=1; $d<date('t',mktime(0, 0, 0, $_GET['s_month'], 1, $_GET['s_year']))+1; $d++)
{
    $index = $FD->db()->conn()->query(
                 'SELECT *
                  FROM '.$FD->config('pref')."counter_stat
                  WHERE s_year  = '".$_GET['s_year']."' AND
                        s_month = '".$_GET['s_month']."' AND
                        s_day   = '".$d."'" );
    $row = $index->fetch(PDO::FETCH_ASSOC);
    $dayname = date('w', mktime(0, 0, 0, $_GET['s_month'], $d, $_GET['s_year']));
    $class = (($dayname == 0) || ($dayname == 6)) ? 'class="nw"' : 'class="n"';

    // Day exists in DB
    if ($row !== false)
    {
        $dcount = $dcount+1;
        $dbvisits = $row['s_visits'];
        $dbhits = $row['s_hits'];
        $visitsall = $visitsall + $dbvisits;
        $hitsall = $hitsall + $dbhits;
        $visitswidth = $dbvisits / ($dbmaxhits/4) * 100;
        $hitswidth = $dbhits / $dbmaxhits * 100;
        echo'
                                    <tr>
                                        <td '.$class.'align="center">
                                            '.$d.'. '.$day_arr[$dayname].'
                                        </td>
                                        <td '.$class.'align="center">
                                            '.point_number($dbvisits).'
                                        </td>
                                        <td '.$class.'align="center">
                                            '.point_number($dbhits).'
                                        </td>
                                        <td '.$class.'align="left" style="font-size:1pt;">
                                            <img border="0" src="img/cvisits.gif" height="4" width="'.round($visitswidth).'"><br>
                                            <img border="0" src="img/chits.gif" height="4" width="'.round($hitswidth).'">
                                        </td>
                                    </tr>
        ';
    }
    else
    {
        echo'
                                    <tr>
                                        <td '.$class.'align="center">
                                            '.$d.'. '.$day_arr[$dayname].'
                                        </td>
                                        <td '.$class.'align="center">
                                            -
                                        </td>
                                        <td '.$class.'align="center">
                                            -
                                        </td>
                                        <td '.$class.'align="center">
                                            -
                                        </td>
                                    </tr>
        ';
    }
}

if (empty($dcount)) {
    $visitsdurchschnitt = "-";
    $hitsdurchschnitt = "-";
} else {
    $visitsdurchschnitt = round($visitsall / $dcount, 2);
    $hitsdurchschnitt = round($hitsall / $dcount, 2);
}


echo'
                                    <tr>
                                        <td class="h" align="center">
                                            '.$FD->text('page', 'average').'
                                        </td>
                                        <td class="h" align="center">
                                            '.$visitsdurchschnitt.'
                                        </td>
                                        <td class="h" align="center">
                                            '.$hitsdurchschnitt.'
                                        </td>
                                        <td class="h" align="center">
                                            &nbsp
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
                                    <tr>
                                        <td class="h" colspan="4" align="center">
                                               <b>'.$FD->text('page', 'monthly_statistics').' ('.$_GET['s_year'].')</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="h" align="center">
                                            <b>'.$FD->text('page', 'month').'</b>
                                        </td>
                                        <td class="h" align="center">
                                            <b>'.$FD->text('page', 'visits').'</b>
                                        </td>
                                        <td class="h" align="center">
                                            <b>'.$FD->text('page', 'hits').'</b>
                                        </td>
                                        <td class="h" align="center" width="120">
                                            <b>'.$FD->text('page', 'chart').'</b>
                                        </td>
                                    </tr>
';

/////////////////////////////////////////
/// Generate statistics for full year ///
/////////////////////////////////////////

// Find maximum monthly hits for year
$index = $FD->db()->conn()->query(
             'SELECT SUM(s_hits) AS sumhits
              FROM '.$FD->config('pref')."counter_stat
              WHERE s_year = $_GET[s_year]
              GROUP BY s_month
              ORDER BY sumhits DESC" );
$maxhits = $index->fetchColumn();

$mcount = 0;
$supervisits = 0;
$superhits = 0;
for ($m=1; $m<13; $m++)
{
    $index = $FD->db()->conn()->query(
                 'SELECT SUM(s_visits) AS sumvisits, SUM(s_hits) AS sumhits
                  FROM '.$FD->config('pref')."counter_stat
                  WHERE s_year = $_GET[s_year] AND s_month = $m" );
    $sum_arr = $index->fetch(PDO::FETCH_ASSOC);
    if ($sum_arr['sumhits'] > 0)
    {
        $mcount += 1;
        $visitswidth = $sum_arr['sumvisits'] / ($maxhits/4) * 90;
        $hitswidth = $sum_arr['sumhits'] / $maxhits * 90;
        echo'
                                    <tr>
                                        <td class="n" align="center">
                                            <a href="'.$_SERVER['PHP_SELF'].'?go=stat_view&s_year='.$_GET['s_year'].'&s_month='.$m.'">'.$month_arr[$m-1].'</a>
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($sum_arr['sumvisits']).'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($sum_arr['sumhits']).'
                                        </td>
                                        <td class="n" align="left" style="font-size:1pt;" class="bottom">
                                            <img align="left" title="'.$FD->text("page", "show_chart").'" class="bottom"
                                            onClick=\''.openpopup ('?go=statgfx&amp;s_year='.$_GET['s_year'].'&amp;s_month='.$m.'', 520, 330).'\' 
                                            style="cursor:pointer; padding-left:2px; padding-right:2px;" border="0" src="img/cdiag.gif">
                                            <img border="0" src="img/null.gif" height="4" width="1"><br>
                                            <img border="0" src="img/cvisits.gif" height="4" width="'.round($visitswidth).'"><br>
                                            <img border="0" src="img/chits.gif" height="4" width="'.round($hitswidth).'">
                                        </td>
                                    </tr>
        ';
        $supervisits += $sum_arr['sumvisits'];
        $superhits += $sum_arr['sumhits'];
    }
    else
    {
        echo'
                                    <tr>
                                        <td class="n" align="center">
                                            '.$month_arr[$m-1].'
                                        </td>
                                        <td class="n" align="center">
                                            -
                                        </td>
                                        <td class="n" align="center">
                                            -
                                        </td>
                                        <td class="n" align="center">
                                            -
                                        </td>
                                    </tr>
        ';
    }
}

$visitsdurchschnitt = $supervisits / $mcount;
$hitsdurchschnitt = $superhits / $mcount;

echo'
                                    <tr>
                                        <td class="h" align="center">
                                            '.$FD->text('page', 'average').'
                                        </td>
                                        <td class="h" align="center">
                                            '.point_number(round($visitsdurchschnitt)).'
                                        </td>
                                        <td class="h" align="center">
                                            '.point_number(round($hitsdurchschnitt)).'
                                        </td>
                                        <td class="h" align="center">
                                            &nbsp
                                        </td>
                                    </tr>
                                </table>
                                <p>
';

///////////////////////////////
// Generate other statistics //
///////////////////////////////

// Read Counter
$index = $FD->db()->conn()->query( 'SELECT * FROM '.$FD->config('pref').'counter' );
$counterdaten = $index->fetch(PDO::FETCH_ASSOC);

// Users online
$online = get_online_ips();

// Day of most hits
$index = $FD->db()->conn()->query('SELECT * FROM '.$FD->config('pref').'counter_stat ORDER BY s_hits DESC LIMIT 1');
$mosthits = $index->fetch(PDO::FETCH_ASSOC);

// Day of most visits
$index = $FD->db()->conn()->query('SELECT * FROM '.$FD->config('pref').'counter_stat ORDER BY s_visits DESC LIMIT 1');
$mostvisits = $index->fetch(PDO::FETCH_ASSOC);

echo'
                                <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
                                    <tr>
                                        <td class="h" align="center" colspan="2">
                                            '.$FD->text('page', 'other_statistics').'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text('page', 'visits_total').'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($counterdaten['visits']).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text('page', 'hits_total').'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($counterdaten['hits']).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text('page', 'online_visitors').'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($online['all']).'
                                        </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text('page', 'online_guests').'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($online['guests']).'
                                        </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text('page', 'online_registered').'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($online['users']).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            &nbsp;
                                        </td>
                                        <td class="n" align="center">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text('page', 'best_day_visits').'
                                        </td>
                                        <td class="n" align="center">
                                            '.$mostvisits['s_day'].'.'.$mostvisits['s_month'].'.'.$mostvisits['s_year'].' '.$FD->text('admin', 'with').' '.point_number($mostvisits['s_visits']).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text('page', 'best_day_hits').'
                                        </td>
                                        <td class="n" align="center">
                                            '.$mosthits['s_day'].'.'.$mosthits['s_month'].'.'.$mosthits['s_year'].' '.$FD->text('admin', 'with').' '.point_number($mosthits['s_hits']).'
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
';
?>
