<?php

//////////////////////////////////////
//// Tagesstatistik aktualisieren ////
//////////////////////////////////////

if (($_POST[d] && $_POST[m] && $_POST[y] && $_POST[v] && $_POST[h]) AND $_POST['do'] == "day")
{
    settype($_POST[d], 'integer');
    settype($_POST[m], 'integer');
    settype($_POST[y], 'integer');
    settype($_POST[v], 'integer');
    settype($_POST[h], 'integer');
    mysql_query("UPDATE ".$global_config_arr[pref]."counter_stat
                 SET s_visits = $_POST[v],
                     s_hits   = $_POST[h]
                 WHERE s_day   = $_POST[d] AND
                       s_month = $_POST[m] AND
                       s_year  = $_POST[y]", $FD->sql()->conn() );
    systext( $admin_phrases[common][changes_saved], $admin_phrases[common][info] );
}

//////////////////////////////////////
////// Tagesstatistik editieren //////
//////////////////////////////////////

elseif (($_POST[ed] && $_POST[em] && $_POST[ey]) AND $_POST['do'] == "day")
{
	settype($_POST[ed], 'integer');
    settype($_POST[em], 'integer');
    settype($_POST[ey], 'integer');
    $index = mysql_query("SELECT s_visits,
                                 s_hits
                          FROM ".$global_config_arr[pref]."counter_stat
                          WHERE s_day = $_POST[ed] and
                                s_month = $_POST[em] and
                                s_year = $_POST[ey]", $FD->sql()->conn() );
                                
	$_POST['ed'] = date ( "d", mktime ( 0, 0, 0, $_POST['em'], $_POST['ed'], $_POST['ey'] ) );
	$_POST['em'] = date ( "m", mktime ( 0, 0, 0, $_POST['em'], $_POST['ed'], $_POST['ey'] ) );
	$_POST['ey'] = date ( "Y", mktime ( 0, 0, 0, $_POST['em'], $_POST['ed'], $_POST['ey'] ) );

    if (mysql_num_rows($index) == 0)
    {
        systext( $admin_phrases[stats][edit_day_no_data], $admin_phrases[stats][edit_day_title].' ('.$_POST[ed].'. '.$_POST[em].'. '.$_POST[ey].')' );
    }
    else
	{
		$counter_arr = mysql_fetch_assoc($index);
		
        echo'
					<form action="" method="post">
						<input type="hidden" value="stat_edit" name="go">
						<input type="hidden" value="day" name="do">
						<input type="hidden" value="'.$_POST[ed].'" name="d">
						<input type="hidden" value="'.$_POST[em].'" name="m">
						<input type="hidden" value="'.$_POST[ey].'" name="y">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[stats][edit_day_title].' ('.$_POST[ed].'. '.$_POST[em].'. '.$_POST[ey].')</td></tr>
						    <tr>
                                <td class="config">
                                    '.$admin_phrases[stats][edit_day_visits].':<br>
                                    <span class="small">'.$admin_phrases[stats][edit_day_visits_desc].' '.$_POST[ed].'. '.$_POST[em].'. '.$_POST[ey].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="v" maxlength="16" value="'.$counter_arr[s_visits].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[stats][edit_day_hits].':<br>
                                    <span class="small">'.$admin_phrases[stats][edit_day_hits_desc].' '.$_POST[ed].'.'.$_POST[em].'.'.$_POST[ey].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="h" maxlength="16" value="'.$counter_arr[s_hits].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
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

elseif (($_POST[editvisits] != "" &&
        $_POST[edithits] != "" &&
        $_POST[edituser] != "" &&
        $_POST[editnews] != "" &&
        $_POST[editartikel] != "" &&
        $_POST[editcomments] != "")
        AND $_POST['do'] == "edit")
{
    settype($_POST[editvisits], 'integer');
    settype($_POST[edithits], 'integer');
    settype($_POST[edituser], 'integer');
    settype($_POST[editnews], 'integer');
    settype($_POST[editartikel], 'integer');
    settype($_POST[editcomments], 'integer');
    mysql_query("UPDATE ".$global_config_arr[pref]."counter
                 SET visits = '$_POST[editvisits]',
                     hits = '$_POST[edithits]',
                     user = '$_POST[edituser]',
                     news = '$_POST[editnews]',
                     artikel = '$_POST[editartikel]',
                     comments = '$_POST[editcomments]'", $FD->sql()->conn() );
    systext( $admin_phrases[common][changes_saved], $admin_phrases[common][info] );
}

////////////////////////////////////////
/// Gesamtstatistik synchronisieren ////
////////////////////////////////////////

elseif ($_POST['do'] == "sync")
{
    $index = mysql_query("SELECT SUM(s_hits) AS 'hits', SUM(s_visits) AS 'visits' FROM ".$global_config_arr[pref]."counter_stat", $FD->sql()->conn() );
    $sync_arr['hits'] = mysql_result($index,0,"hits");
    $sync_arr['visits'] = mysql_result($index,0,"visits");

    $index = mysql_query("SELECT COUNT(user_id) AS 'user' FROM ".$global_config_arr[pref]."user", $FD->sql()->conn() );
    $sync_arr['user'] = mysql_result($index,0,"user");
    
    $index = mysql_query("SELECT COUNT(news_id) AS 'news' FROM ".$global_config_arr[pref]."news", $FD->sql()->conn() );
    $sync_arr['news'] = mysql_result($index,0,"news");
    
    $index = mysql_query("SELECT COUNT(comment_id) AS 'comments' FROM ".$global_config_arr[pref]."news_comments", $FD->sql()->conn() );
    $sync_arr['comments'] = mysql_result($index,0,"comments");

    $index = mysql_query("SELECT COUNT(article_id) AS 'articles' FROM ".$global_config_arr[pref]."articles", $FD->sql()->conn() );
    $sync_arr['articles'] = mysql_result($index,0,"articles");

    mysql_query("UPDATE ".$global_config_arr[pref]."counter
                 SET visits = '$sync_arr[visits]',
                     hits = '$sync_arr[hits]',
                     user = '$sync_arr[user]',
                     news = '$sync_arr[news]',
                     artikel = '$sync_arr[articles]',
                     comments = '$sync_arr[comments]'", $FD->sql()->conn() );
    systext( $admin_phrases[stats][synchronised], $admin_phrases[common][info] );
}
//////////////////////////////////////
///// Gesamtstatistik editieren //////
//////////////////////////////////////

else
{
    //Zeit-Array für Heute Button
    $heute[d] = date("d");
    $heute[m] = date("m");
    $heute[y] = date("Y");

    $index = mysql_query("SELECT * FROM ".$global_config_arr[pref]."counter", $FD->sql()->conn() );
    $counter_arr = mysql_fetch_assoc($index);
    
    echo'
                    <form action="" method="post">
                        <input type="hidden" value="stat_edit" name="go">
                        <input type="hidden" value="sync" name="do">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$admin_phrases[stats][overall_title].'</td></tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[stats][sync_now].':<br>
                                    <span class="small">'.$admin_phrases[stats][sync_now_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="button" type="submit" value="'.$admin_phrases[stats][sync_now_button].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>

                    </form>


					<form action="" method="post">
						<input type="hidden" value="stat_edit" name="go">
						<input type="hidden" value="edit" name="do">
							<tr>
								<td class="config">
									'.$admin_phrases[stats][overall_visits].':<br>
                                    <span class="small">'.$admin_phrases[stats][overall_visits_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="editvisits" maxlength="16" value="'.$counter_arr[visits].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[stats][overall_hits].':<br>
                                    <span class="small">'.$admin_phrases[stats][overall_hits_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="edithits" maxlength="16" value="'.$counter_arr[hits].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[stats][overall_user].':<br>
                                    <span class="small">'.$admin_phrases[stats][overall_user_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="edituser" maxlength="16" value="'.$counter_arr[user].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[stats][overall_news].':<br>
                                    <span class="small">'.$admin_phrases[stats][overall_news_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="editnews" maxlength="16" value="'.$counter_arr[news].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[stats][overall_articles].':<br>
                                    <span class="small">'.$admin_phrases[stats][overall_articles_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="editartikel" maxlength="16" value="'.$counter_arr[artikel].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[stats][overall_comments].':<br>
                                    <span class="small">'.$admin_phrases[stats][overall_comments_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="16" name="editcomments" maxlength="16" value="'.$counter_arr[comments].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit" value="1">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr><td class="space"></td></tr>
                            

                    </form>
                    <form action="" method="post">
                        <input type="hidden" value="stat_edit" name="go">
                        <input type="hidden" value="day" name="do">
							<tr><td class="line" colspan="2">'.$admin_phrases[stats][edit_day_title].'</td></tr>
                            <tr>
                                <td class="config" width="60%">
                                    '.$admin_phrases[stats][edit_day].':<br>
                                    <span class="small">'.$admin_phrases[stats][edit_day_desc].'</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="1" name="ed" id="ed" maxlength="2"> .
                                    <input class="text" size="1" name="em" id="em"  maxlength="2"> .
                                    <input class="text" size="3" name="ey" id="ey"  maxlength="4">&nbsp;&nbsp;
                                    <input class="button" type="button" value="'.$admin_phrases[common][today].'"
                                           onClick=\'document.getElementById("ed").value="'.$heute[d].'";
                                                     document.getElementById("em").value="'.$heute[m].'";
                                                     document.getElementById("ey").value="'.$heute[y].'";\'><br>
                                    <span class="small">'.$admin_phrases[stats][edit_day_info].'</span>
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="2" class="buttontd">
                                    <button class="button_new" type="submit" value="1">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[stats][edit_day_button].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}
?>
