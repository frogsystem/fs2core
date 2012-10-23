<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//////////////////////////////////////
//// Tagesstatistik aktualisieren ////
//////////////////////////////////////

if ((isset($_POST['d']) && isset($_POST['m']) && isset($_POST['y']) && isset($_POST['v']) && isset($_POST['h'])) AND $_POST['do'] == 'day')
{
    settype($_POST['d'], 'integer');
    settype($_POST['m'], 'integer');
    settype($_POST['y'], 'integer');
    settype($_POST['v'], 'integer');
    settype($_POST['h'], 'integer');
    mysql_query('UPDATE '.$FD->config('pref')."counter_stat
                 SET s_visits = $_POST[v],
                     s_hits   = $_POST[h]
                 WHERE s_day   = $_POST[d] AND
                       s_month = $_POST[m] AND
                       s_year  = $_POST[y]", $FD->sql()->conn() );
    systext( $FD->text('page', 'changes_saved'), $FD->text('page', 'info') );
}

//////////////////////////////////////
////// Tagesstatistik editieren //////
//////////////////////////////////////

elseif ((isset($_POST['ed']) && isset($_POST['em']) && isset($_POST['ey'])) AND $_POST['do'] == 'day')
{
    settype($_POST['ed'], 'integer');
    settype($_POST['em'], 'integer');
    settype($_POST['ey'], 'integer');
    $index = mysql_query('SELECT s_visits,
                                 s_hits
                          FROM '.$FD->config('pref')."counter_stat
                          WHERE s_day = $_POST[ed] and
                                s_month = $_POST[em] and
                                s_year = $_POST[ey]", $FD->sql()->conn() );

	$_POST['ed'] = date ( 'd', mktime ( 0, 0, 0, $_POST['em'], $_POST['ed'], $_POST['ey'] ) );
	$_POST['em'] = date ( 'm', mktime ( 0, 0, 0, $_POST['em'], $_POST['ed'], $_POST['ey'] ) );
	$_POST['ey'] = date ( 'Y', mktime ( 0, 0, 0, $_POST['em'], $_POST['ed'], $_POST['ey'] ) );

    if (mysql_num_rows($index) == 0)
    {
        systext( $FD->text('page', 'edit_day_no_data'), $FD->text('page', 'edit_day_title').' ('.$_POST['ed'].'. '.$_POST['em'].'. '.$_POST['ey'].')' );
    }
    else
	{
		$counter_arr = mysql_fetch_assoc($index);

        echo'
					<form action="" method="post">
						<input type="hidden" value="stat_edit" name="go">
						<input type="hidden" value="day" name="do">
						<input type="hidden" value="'.$_POST['ed'].'" name="d">
						<input type="hidden" value="'.$_POST['em'].'" name="m">
						<input type="hidden" value="'.$_POST['ey'].'" name="y">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$FD->text('page', 'edit_day_title').' ('.$_POST['ed'].'. '.$_POST['em'].'. '.$_POST['ey'].')</td></tr>
						    <tr>
                                <td class="config">
                                    '.$FD->text("page", "edit_day_visits").':<br>
                                    <span class="small">'.$FD->text('page', 'edit_day_visits_desc').' '.$_POST['ed'].'. '.$_POST['em'].'. '.$_POST['ey'].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="v" maxlength="16" value="'.$counter_arr['s_visits'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'edit_day_hits').':<br>
                                    <span class="small">'.$FD->text('page', 'edit_day_hits_desc').' '.$_POST['ed'].'.'.$_POST['em'].'.'.$_POST['ey'].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="h" maxlength="16" value="'.$counter_arr['s_hits'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('page', 'save_long').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
        ';
    }
}

//////////////////////////////////////
/// Gesamtstatistik aktualisieren ////
//////////////////////////////////////

elseif ((isset($_POST['editvisits']) && $_POST['editvisits'] != '' &&
        isset($_POST['edithits']) && $_POST['edithits'] != '' &&
        isset($_POST['edituser']) && $_POST['edituser'] != '' &&
        isset($_POST['editnews']) && $_POST['editnews'] != '' &&
        isset($_POST['editartikel']) && $_POST['editartikel'] != '' &&
        isset($_POST['editcomments']) && $_POST['editcomments'] != '')
        AND $_POST['do'] == 'edit')
{
    settype($_POST['editvisits'], 'integer');
    settype($_POST['edithits'], 'integer');
    settype($_POST['edituser'], 'integer');
    settype($_POST['editnews'], 'integer');
    settype($_POST['editartikel'], 'integer');
    settype($_POST['editcomments'], 'integer');
    mysql_query('UPDATE '.$FD->config('pref')."counter
                 SET visits = '$_POST[editvisits]',
                     hits = '$_POST[edithits]',
                     user = '$_POST[edituser]',
                     news = '$_POST[editnews]',
                     artikel = '$_POST[editartikel]',
                     comments = '$_POST[editcomments]'", $FD->sql()->conn() );
    systext( $FD->text('page', 'changes_saved'), $FD->text('page', 'info') );
}

////////////////////////////////////////
/// Gesamtstatistik synchronisieren ////
////////////////////////////////////////

elseif (isset($_POST['do']) && $_POST['do'] == 'sync')
{
    $index = mysql_query("SELECT SUM(s_hits) AS 'hits', SUM(s_visits) AS 'visits' FROM ".$FD->config('pref').'counter_stat', $FD->sql()->conn() );
    $sync_arr['hits'] = mysql_result($index,0,'hits');
    $sync_arr['visits'] = mysql_result($index,0,'visits');

    $index = mysql_query("SELECT COUNT(user_id) AS 'user' FROM ".$FD->config('pref').'user', $FD->sql()->conn() );
    $sync_arr['user'] = mysql_result($index,0,'user');

    $index = mysql_query("SELECT COUNT(news_id) AS 'news' FROM ".$FD->config('pref').'news', $FD->sql()->conn() );
    $sync_arr['news'] = mysql_result($index,0,'news');

    $index = mysql_query("SELECT COUNT(comment_id) AS 'comments' FROM ".$FD->config('pref').'comments', $FD->sql()->conn() );
    $sync_arr['comments'] = mysql_result($index,0,'comments');

    $index = mysql_query("SELECT COUNT(article_id) AS 'articles' FROM ".$FD->config('pref').'articles', $FD->sql()->conn() );
    $sync_arr['articles'] = mysql_result($index,0,'articles');

    mysql_query('UPDATE '.$FD->config('pref')."counter
                 SET visits = '$sync_arr[visits]',
                     hits = '$sync_arr[hits]',
                     user = '$sync_arr[user]',
                     news = '$sync_arr[news]',
                     artikel = '$sync_arr[articles]',
                     comments = '$sync_arr[comments]'", $FD->sql()->conn() );
    systext( $FD->text('page', 'synchronised'), $FD->text('page', 'info') );
}
//////////////////////////////////////
///// Gesamtstatistik editieren //////
//////////////////////////////////////

else
{
    //Zeit-Array für Heute Button
    $heute['d'] = date('d');
    $heute['m'] = date('m');
    $heute['y'] = date('Y');

    $index = mysql_query('SELECT * FROM '.$FD->config('pref').'counter', $FD->sql()->conn() );
    $counter_arr = mysql_fetch_assoc($index);

    echo'
                    <form action="" method="post">
                        <input type="hidden" value="stat_edit" name="go">
                        <input type="hidden" value="sync" name="do">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$FD->text('page', 'overall_title').'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'sync_now').':<br>
                                    <span class="small">'.$FD->text('page', 'sync_now_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="button" type="submit" value="'.$FD->text('page', 'sync_now_button').'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>

                    </form>


					<form action="" method="post">
						<input type="hidden" value="stat_edit" name="go">
						<input type="hidden" value="edit" name="do">
							<tr>
								<td class="config">
									'.$FD->text('page', 'overall_visits').':<br>
                                    <span class="small">'.$FD->text('page', 'overall_visits_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="editvisits" maxlength="16" value="'.$counter_arr['visits'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'overall_hits').':<br>
                                    <span class="small">'.$FD->text('page', 'overall_hits_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="edithits" maxlength="16" value="'.$counter_arr['hits'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'overall_user').':<br>
                                    <span class="small">'.$FD->text('page', 'overall_user_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="edituser" maxlength="16" value="'.$counter_arr['user'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'overall_news').':<br>
                                    <span class="small">'.$FD->text('page', 'overall_news_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="editnews" maxlength="16" value="'.$counter_arr['news'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'overall_articles').':<br>
                                    <span class="small">'.$FD->text('page', 'overall_articles_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="editartikel" maxlength="16" value="'.$counter_arr['artikel'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text('page', 'overall_comments').':<br>
                                    <span class="small">'.$FD->text('page', 'overall_comments_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="editcomments" maxlength="16" value="'.$counter_arr['comments'].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit" value="1">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('page', 'save_long').'
                                    </button>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="space"></td></tr>


                    </form>
                    <form action="" method="post">
                        <input type="hidden" value="stat_edit" name="go">
                        <input type="hidden" value="day" name="do">
							<tr><td class="line" colspan="2">'.$FD->text('page', 'edit_day_title').'</td></tr>
                            <tr>
                                <td class="config" width="60%">
                                    '.$FD->text('page', 'edit_day').':<br>
                                    <span class="small">'.$FD->text('page', 'edit_day_desc').'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="1" name="ed" id="ed" maxlength="2"> .
                                    <input class="text" size="1" name="em" id="em"  maxlength="2"> .
                                    <input class="text" size="3" name="ey" id="ey"  maxlength="4">&nbsp;&nbsp;
                                    <input class="button" type="button" value="'.$FD->text('page', 'today').'"
                                           onClick=\'document.getElementById("ed").value="'.$heute['d'].'";
                                                     document.getElementById("em").value="'.$heute['m'].'";
                                                     document.getElementById("ey").value="'.$heute['y'].'";\'><br>
                                    <span class="small">'.$FD->text('page', 'edit_day_info').'</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit" value="1">
                                        '.$FD->text('admin', 'button_arrow').' '.$FD->text('page', 'edit_day_button').'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
