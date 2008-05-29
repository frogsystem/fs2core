<?php
////////////////////////////////////////
//// Display Comment-Actions-Pages  ////
////////////////////////////////////////
if (
		$_POST['news_id'] && $_POST['news_action'] == "comments" &&
		$_POST['comment_id'] && $_POST['comment_action']
	)
{
	// Edit Comment
	if ( $_POST['comment_action'] == "edit" )
	{
        settype ( $_POST['comment_id'], 'integer' );
	    $index = mysql_query ( "
								SELECT *
								FROM ".$global_config_arr['pref']."news_comments
								WHERE comment_id = ".$_POST['comment_id']."
		", $db);
	    $comment_arr = mysql_fetch_assoc ( $index );

		// Get other Data
		if ( $comment_arr['comment_poster_id'] != 0 ) {
				$index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $db );
				$comment_arr['comment_poster'] = mysql_result ( $index2, 0, "user_name" );
		}
		$comment_arr['comment_date_formated'] = date ( "d.m.Y" , $comment_arr['comment_date'] ) . " um " . date ( "H:i" , $comment_arr['comment_date'] );

	    echo'
                    <form action="" method="post">
						<input type="hidden" name="go" value="newsedit">
						<input type="hidden" name="news_action" value="'.$_POST['news_action'].'">
						<input type="hidden" name="comment_action" value="'.$_POST['comment_action'].'">
						<input type="hidden" name="news_id" value="'.$comment_arr['news_id'].'">
						<input type="hidden" name="comment_id" value="'.$comment_arr['comment_id'].'">
                        <input type="hidden" name="sended" value="edit">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
                        <table class="configtable" cellpadding="4" cellspacing="0">
                            <tr>
                                <td class="config" valign="top">
                                    Datum:<br>
                                    <font class="small">Das Kommentar wurde geschreiben am</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr['comment_date_formated'].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Poster:<br>
                                    <font class="small">Diese Person hat das Komemntar geschreiben</font>
                                </td>
                                <td class="config" valign="top">
                                    '.$comment_arr[comment_poster].'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Titel:<br>
                                    <font class="small">Titel des Kommentars</font>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="33" name="title" value="'.$comment_arr[comment_title].'" maxlength="100">
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    Text:<br>
                                </td>
                                <td valign="top">
                                    '.create_editor("text", killhtml($comment_arr[comment_text]), 330, 130).'
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <br /><br />
                                    <input class="button" type="submit" value="Änderungen speichern">
                                </td>
                            </tr>
                        </table>
                    </form>
	    ';
	}
	
	// Edit Comment
	elseif ( $_POST['comment_action'] == "delete" )
	{
        settype ( $_POST['comment_id'], 'integer' );
	    $index = mysql_query ( "
								SELECT *
								FROM ".$global_config_arr['pref']."news_comments
								WHERE comment_id = ".$_POST['comment_id']."
		", $db);
	    $comment_arr = mysql_fetch_assoc ( $index );

		// Get other Data
		if ( $comment_arr['comment_poster_id'] != 0 ) {
				$index2 = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = ".$comment_arr['comment_poster_id']."", $db );
				$comment_arr['comment_poster'] = mysql_result ( $index2, 0, "user_name" );
		}
		$comment_arr['comment_date_formated'] = date ( "d.m.Y" , $comment_arr['comment_date'] ) . " um " . date ( "H:i" , $comment_arr['comment_date'] );

		echo '
					<form action="" method="post">
						<input type="hidden" name="go" value="newsedit">
						<input type="hidden" name="news_action" value="'.$_POST['news_action'].'">
						<input type="hidden" name="comment_action" value="'.$_POST['comment_action'].'">
						<input type="hidden" name="news_id" value="'.$comment_arr['news_id'].'">
						<input type="hidden" name="comment_id" value="'.$comment_arr['comment_id'].'">
                        <input type="hidden" name="sended" value="delete">
                        <input type="hidden" value="'.session_id().'" name="PHPSESSID">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line">Kommentar löschen</td></tr>
							<tr>
                                <td class="config">
                                    '.$comment_arr['comment_title'].' <span class="small">(#'.$news_arr['news_id'].')</span><br>
                                    <span class="small">gepostet von <b>'.$comment_arr['comment_poster'].'</b>
									'.$comment_arr['comment_date_formated'].' Uhr</b><br><br>
                                    <div class="small">'.killhtml ( $comment_arr['comment_text'] ).'</div>
                                </td>
                            </tr>
							<tr><td class="space"></td></tr>
						</table>
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr>
								<td class="config" style="width: 100%;">
									Soll dieser Kommentar wirklich gelöscht werden:
								</td>
								<td class="config right top" style="padding: 0px;">
		    						<table width="100%" cellpadding="4" cellspacing="0">
										<tr class="bottom pointer" id="tr_yes"
											onmouseover="'.color_list_entry ( "del_yes", "#EEEEEE", "#64DC6A", "this" ).'"
											onmouseout="'.color_list_entry ( "del_yes", "transparent", "#49C24f", "this" ).'"
											onclick="'.color_click_entry ( "del_yes", "#EEEEEE", "#64DC6A", "this", TRUE ).'"
										>
											<td>
												<input class="pointer" type="radio" name="comment_delete" id="del_yes" value="1"
                                                    onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_yes", TRUE ).'"
												>
											</td>
											<td class="config middle">
												'.$admin_phrases[common][yes].'
											</td>
										</tr>
										<tr class="bottom red pointer" id="tr_no"
											onmouseover="'.color_list_entry ( "del_no", "#EEEEEE", "#DE5B5B", "this" ).'"
											onmouseout="'.color_list_entry ( "del_no", "transparent", "#C24949", "this" ).'"
											onclick="'.color_click_entry ( "del_no", "#EEEEEE", "#DE5B5B", "this", TRUE ).'"
										>
											<td>
												<input class="pointer" type="radio" name="comment_delete" id="del_no" value="0" checked="checked"
                                                    onclick="'.color_click_entry ( "this", "#EEEEEE", "#DE5B5B", "tr_no", TRUE ).'"
												>
											</td>
											<td class="config middle">
												'.$admin_phrases[common][no].'
											</td>
										</tr>
										'.color_pre_selected ( "del_no", "tr_no" ).'
									</table>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="2">
									<button class="button_new" type="submit">
										'.$admin_phrases[common][arrow].' '.$admin_phrases[common][do_button_long].'
									</button>
								</td>
							</tr>
						</table>
					</form>
		';
	}
}


/////////////////////////////
//// Kommentar editieren ////
/////////////////////////////

else
{
	systext( "Es trat ein Fehelr auf", $admin_phrases[common][error], TRUE );
}
?>