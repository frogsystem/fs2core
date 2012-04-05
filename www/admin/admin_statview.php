<?php if (!defined("ACP_GO")) die("Unauthorized access!");

if (!isset($_GET['s_year']))
{
    $_GET['s_year'] = date("Y");
}
if (!isset($_GET['s_month']))
{
    $_GET['s_month'] = date("m");
}
settype ($_GET['s_year'], 'integer');
settype ($_GET['s_month'], 'integer');

$day_arr = explode(",", $FD->text("frontend", "week_days_array"));
$month_arr = explode(",", $FD->text("frontend", "month_names_array"));

//////////////////////////////////
//// Jahresauswahl generieren ////
//////////////////////////////////

echo'
                    <table border="0" cellpadding="10" cellspacing="0" width="600" align="center">
                        <tr>
                            <td width="100%" colspan="2" align="center">
';

// Erstes Jahr ermitteln
$index = mysql_query("SELECT s_year FROM ".$global_config_arr['pref']."counter_stat ORDER BY s_year LIMIT 1", $FD->sql()->conn() );
$dbfirstyear = mysql_result($index, 0, "s_year");

// Ersten Monat ermitteln
$index = mysql_query("SELECT s_month FROM ".$global_config_arr['pref']."counter_stat WHERE s_year = $dbfirstyear ORDER BY s_month LIMIT 1", $FD->sql()->conn() );
$dbfirstmonth = mysql_result($index, 0, "s_month");

echo '<a href="'.$_SERVER['PHP_SELF'].'?mid='.$_GET['mid'].'&go=stat_view&s_year='.$dbfirstyear.'&s_month='.$dbfirstmonth.'&PHPSESSID='.session_id().'">';
if ( $_GET['s_year'] == $dbfirstyear ) { echo '<b>'; }
echo $dbfirstyear;
if ( $_GET['s_year'] == $dbfirstyear ) { echo '</b>'; }
echo '</a>';


// Alle weiteren Jahre auflisten
if ($dbfirstyear < date("Y"))
{
    for ($y=$dbfirstyear+1; $y<=date("Y"); $y++)
    {
        echo ' | <a href="'.$_SERVER['PHP_SELF'].'?mid='.$_GET['mid'].'&go=stat_view&s_year='.$y.'&s_month=1&PHPSESSID='.session_id().'">';
        if ( $_GET['s_year'] == $y ) { echo '<b>'; }
		echo $y;
        if ( $_GET['s_year'] == $y ) { echo '</b>'; }
		echo '</a>';
    }
}

//////////////////////////////////
/// Monatsstatistik generieren ///
//////////////////////////////////

$monthname = date("n", mktime(0, 0, 0, $_GET['s_month']+1, 0, 0));
echo'
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
                                    <tr>
                                        <td class="h" colspan="4" align="center">
                                            <b>'.$FD->text("page", "daily_statistics").' ('.$month_arr[$monthname-1].')</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="h" align="center">
                                            <b>'.$FD->text("page", "day").'</b>
                                        </td>
                                        <td class="h" align="center">
                                            <b>'.$FD->text("page", "visits").'</b>
                                        </td>
                                        <td class="h" align="center">
                                            <b>'.$FD->text("page", "hits").'</b>
                                        </td>
                                        <td class="h" align="center" width="120">
                                            <b>'.$FD->text("page", "chart").'</b>
                                        </td>
                                    </tr>
';

// Höchste PI diesen Monat ermitteln
$index = mysql_query("SELECT s_hits
                      FROM ".$global_config_arr['pref']."counter_stat
                      WHERE s_year  = $_GET[s_year] AND s_month = $_GET[s_month]
                      ORDER BY s_hits desc
                      LIMIT 1", $FD->sql()->conn() );

$dbmaxhits = mysql_result($index, 0, "s_hits");

// Tage ausgeben
for ($d=1; $d<date("t",mktime(0, 0, 0, $s_month, 1, $s_year))+1; $d++)
{
    $index = mysql_query("SELECT *
                          FROM ".$global_config_arr['pref']."counter_stat
                          WHERE s_year  = $_GET[s_year] AND
                                s_month = $_GET[s_month] AND
                                s_day   = $d", $FD->sql()->conn() );
    $rows = mysql_num_rows($index);
    $dayname = date("w", mktime(0, 0, 0, $_GET['s_month'], $d, $_GET['s_year']));
    $class = (($dayname == 0) || ($dayname == 6)) ? 'class="nw"' : 'class="n"';

    // Tag vorhanden
    if ($rows > 0)
    {
        $dcount = $dcount+1;
        $dbvisits = mysql_result($index, 0, "s_visits");
        $dbhits = mysql_result($index, 0, "s_hits");
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

$visitsdurchschnitt = $visitsall / $dcount;
$hitsdurchschnitt = $hitsall / $dcount;

echo'
                                    <tr>
                                        <td class="h" align="center">
                                            '.$FD->text("page", "average").'
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
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
                                    <tr>
                                        <td class="h" colspan="4" align="center">
                                               <b>'.$FD->text("page", "monthly_statistics").' ('.$_GET['s_year'].')</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="h" align="center">
                                            <b>'.$FD->text("page", "month").'</b>
                                        </td>
                                        <td class="h" align="center">
                                            <b>'.$FD->text("page", "visits").'</b>
                                        </td>
                                        <td class="h" align="center">
                                            <b>'.$FD->text("page", "hits").'</b>
                                        </td>
                                        <td class="h" align="center" width="120">
                                            <b>'.$FD->text("page", "chart").'</b>
                                        </td>
                                    </tr>
';

//////////////////////////////////
/// Jahresstatistik generieren ///
//////////////////////////////////

// Maximale Montaszahl ermitteln
$index = mysql_query("SELECT SUM(s_hits) AS sumhits
                      FROM ".$global_config_arr['pref']."counter_stat
                      WHERE s_year = $_GET[s_year]
                      GROUP BY s_month
                      ORDER BY sumhits desc", $FD->sql()->conn() );
$maxhits = mysql_result($index, 0, "sumhits");

for ($m=1; $m<13; $m++)
{
    $index = mysql_query("SELECT SUM(s_visits) AS sumvisits, SUM(s_hits) AS sumhits
                          FROM ".$global_config_arr['pref']."counter_stat
                          WHERE s_year = $_GET[s_year] AND s_month = $m", $FD->sql()->conn() );
    $sum_arr = mysql_fetch_assoc($index);
    if ($sum_arr['sumhits'] > 0)
    {
        $mcount += 1;
        $visitswidth = $sum_arr['sumvisits'] / ($maxhits/4) * 90;
        $hitswidth = $sum_arr['sumhits'] / $maxhits * 90;
        echo'
                                    <tr>
                                        <td class="n" align="center">
                                            <a href="'.$_SERVER['PHP_SELF'].'?mid='.$_GET['mid'].'&go=stat_view&s_year='.$_GET['s_year'].'&s_month='.$m.'">'.$month_arr[$m-1].'</a>
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($sum_arr['sumvisits']).'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($sum_arr['sumhits']).'
                                        </td>
                                        <td class="n" align="left" style="font-size:1pt;" class="bottom">
                                            <img align="left" title="'.$FD->text("page", "show_chart").'" class="bottom" onClick=\'open("admin_statgfx.php?s_year='.$_GET['s_year'].'&s_month='.$m.'","Picture","width=520,height=330,screenX=200,screenY=150")\' style="cursor:pointer; padding-left:2px; padding-right:2px;" border="0" src="img/cdiag.gif">
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
                                            '.$FD->text("page", "average").'
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

//////////////////////////////////
// sonstige Statistik generieren /
//////////////////////////////////

// Counter lesen
$index=mysql_query('select * from '.$global_config_arr['pref'].'counter', $FD->sql()->conn() );
$counterdaten = mysql_fetch_assoc($index);

// User online
$index = mysql_query('select count(*) as total from '.$global_config_arr['pref'].'useronline', $FD->sql()->conn() );
$anzuseronline= mysql_fetch_assoc($index);

// Best frequentierter Tag
$index = mysql_query('select * from '.$global_config_arr['pref'].'counter_stat order by s_hits desc limit 1', $FD->sql()->conn() );
$mosthits = mysql_fetch_assoc($index);

// Best besuchter Tag
$index = mysql_query('select * from '.$global_config_arr['pref'].'counter_stat order by s_visits desc limit 1', $FD->sql()->conn() );
$mostvisits = mysql_fetch_assoc($index);

echo'
                                <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
                                    <tr>
                                        <td class="h" align="center" colspan="2">
                                            '.$FD->text("page", "other_statistics").'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text("page", "visits_total").'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($counterdaten['visits']).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text("page", "hits_total").'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($counterdaten['hits']).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text("page", "user_online").'
                                        </td>
                                        <td class="n" align="center">
                                            '.point_number($anzuseronline['total']).'
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
                                            '.$FD->text("page", "best_day_visits").'
                                        </td>
                                        <td class="n" align="center">
                                            '.$mostvisits['s_day'].'.'.$mostvisits['s_month'].'.'.$mostvisits['s_year'].' '.$FD->text("admin", "with").' '.point_number($mostvisits['s_visits']).'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="n" align="center">
                                            '.$FD->text("page", "best_day_hits").'
                                        </td>
                                        <td class="n" align="center">
                                            '.$mosthits['s_day'].'.'.$mosthits['s_month'].'.'.$mosthits['s_year'].' '.$FD->text("admin", "with").' '.point_number($mosthits['s_hits']).'
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
';
?>
