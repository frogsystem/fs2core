<?php
//////////////////////
// Update Database  //
//////////////////////

// Update Video
if (
		$_POST['video_id']
		&& $_POST['sended'] && $_POST['sended'] == "edit"
		&& $_POST['video_action'] && $_POST['video_action'] == "edit"
		&& $_POST['video_url'] && $_POST['video_url'] != ""
		&& $_POST['video_title'] && $_POST['video_title'] != ""
	)
{
    $_POST['video_url'] = savesql ( $_POST['video_url'] );
	$_POST['video_title'] = savesql ( $_POST['video_title'] );
    $_POST['video_desc'] = savesql ( $_POST['video_desc'] );
    settype ( $_POST['dl_id'], "integer" );

    mysql_query ( "
					UPDATE
						".$global_config_arr['pref']."player
					SET
					    video_url = '".$_POST['video_url']."',
					    video_title = '".$_POST['video_title']."',
					    video_desc = '".$_POST['video_desc']."',
					    dl_id = '".$_POST['dl_id']."'
                 	WHERE
					 	video_id = '".$_POST['video_id']."'
	", $db );

    $message = "Video bearbeitet";

    // Display Message
    systext ( $message, $admin_phrases[common][info] );

    // Unset Vars
    unset ( $_POST );
}

// Delete Video
elseif (
		$_POST['video_id']
		&& $_POST['sended'] && $_POST['sended'] == "delete"
		&& $_POST['video_action'] && $_POST['video_action'] == "delete"
	)
{
	if ( $_POST['video_delete'] == 1 ) {

		// Security-Functions
		settype ( $_POST['video_id'], "integer" );

		// MySQL-Delete-Query
    	mysql_query ("
						DELETE FROM
							".$global_config_arr['pref']."player
                 		WHERE
						 	video_id = '".$_POST['video_id']."'
						LIMIT
						    1
		", $db );
		
		$message = "Video wurde gelöscht";

	} else {
		$message = "Video wurde nicht gelöscht";
	}

    // Display Message
    systext ( $message, $admin_phrases[common][info] );

    // Unset Vars
    unset ( $_POST );
}

///////////////////////////
// Display Action-Pages  //
///////////////////////////

if ( $_POST['video_id'] && $_POST['video_action'] )
{
	// Edit Video
	if ( $_POST['video_action'] == "edit" )
	{
	    settype ( $_POST['video_id'], 'integer');
	    $index = mysql_query ( "
								SELECT
									*
								FROM
									".$global_config_arr['pref']."player
								WHERE
									video_id = '".$_POST['video_id']."'
		", $db );
	    $video_arr = mysql_fetch_assoc ( $index );

		if ( !isset ( $_POST['video_url'] ) ) {
		    $_POST['video_url'] = $video_arr['video_url'];
		}
		if ( !isset ( $_POST['video_title'] ) ) {
		    $_POST['video_title'] = $video_arr['video_title'];
		}
		if ( !isset ( $_POST['video_desc'] ) ) {
		    $_POST['video_desc'] = $video_arr['video_desc'];
		}
		if ( !isset ( $_POST['dl_id'] ) ) {
		    $_POST['dl_id'] = $video_arr['dl_id'];
		}

		// Security Functions
		$_POST['video_url'] = killhtml ( $_POST['video_url'] );
		$_POST['video_title'] = killhtml ( $_POST['video_title'] );
	    $_POST['video_desc'] = killhtml ( $_POST['video_desc'] );
	    settype ( $_POST['dl_id'], "integer" );

		// Display Error Messages
		if ( isset ( $_POST['sended'] ) ) {
			  systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
		}

	    echo'
                    <form action="" method="post">
						<input type="hidden" name="go" value="playeredit">
					    <input type="hidden" name="video_action" value="edit">
						<input type="hidden" name="sended" value="edit">
						<input type="hidden" name="video_id" value="'.$_POST['video_id'].'">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">Video bearbeiten</td></tr>
                            <tr>
                                <td class="config">
                                    Titel:<br>
                                    <span class="small">Der Titel des Videos</span>
                                </td>
                                <td class="config">
                                    <input class="text" size="45" maxlength="100" name="video_title" value="'.$_POST['video_title'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    URL:<br>
                                    <span class="small">URL zur Video-Datei (FLV-Format).</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="45" maxlength="255" name="video_url" value="'.$_POST['video_url'].'">
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Beschreibung: <span class="small">'.$admin_phrases[common][optional].'</span><br>
                                    <span class="small">Text, der das Video beschreibt.</span>
                                </td>
                                <td class="config" valign="top">
                                    <textarea class="text" name="video_desc" rows="5" cols="50" wrap="virtual">'.$_POST['video_desc'].'</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="config">
                                    Download:<br>
                                    <span class="small">Soll das Video mit einem DL verknüpft werden?</span>
                                </td>
                                <td class="config">
                                    <select name="dl_id">
                                        <option value="0" '.getselected(0, $_POST['dl_id']).'>keine Verknüpfung</option>
		';
										// DL auflisten
										$index = mysql_query ( "
																SELECT
																	D.dl_id, D.dl_name, C.cat_name
																FROM
																	".$global_config_arr['pref']."dl D, ".$global_config_arr['pref']."dl_cat AS C
																WHERE
																    D.cat_id = C.cat_id
																ORDER BY
																    D.dl_name ASC
										", $db );

										while ( $dl_arr = mysql_fetch_assoc ( $index ) )
										{
											echo '<option value="'.$dl_arr['dl_id'].'" '.getselected($dl_arr['dl_id'], $_POST['dl_id']).'>'.$dl_arr['dl_name'].' ('.$dl_arr['cat_name'].')</option>';
										}
		echo'
                                    </select>
                                </td>
                            </tr>
							<tr><td class="space"></td></tr>
                            <tr>
                                <td class="buttontd" colspan="2">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
	    ';
	}
	
	// Delte Video
	elseif ( $_POST['video_action'] == "delete" )
	{
		$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."player WHERE video_id = '".$_POST['video_id']."'", $db );
		$video_arr = mysql_fetch_assoc ( $index );

		echo '
					<form action="" method="post">
						<input type="hidden" name="go" value="playeredit">
					    <input type="hidden" name="video_action" value="delete">
						<input type="hidden" name="sended" value="delete">
						<input type="hidden" name="video_id" value="'.$_POST['video_id'].'">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line">Video löschen</td></tr>
							<tr>
                                <td class="config">
                                    '.$video_arr['video_title'].'<br>
                                    <span class="small"><a href="'.$video_arr['video_url'].'" target="_blank">'.$video_arr['video_url'].'</a></span>
                                </td>
							</tr>
							<tr><td class="space"></td></tr>
						</table>
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr>
								<td class="config">
								    Soll das Video wirklich gelöscht werden?
								</td>
								<td class="config right top" style="padding: 0px;">
		    						<table width="100%" cellpadding="4" cellspacing="0">
										<tr class="bottom pointer" id="tr_yes"
											onmouseover="'.color_list_entry ( "del_yes", "#EEEEEE", "#64DC6A", "this" ).'"
											onmouseout="'.color_list_entry ( "del_yes", "transparent", "#49C24f", "this" ).'"
											onclick="'.color_click_entry ( "del_yes", "#EEEEEE", "#64DC6A", "this", TRUE ).'"
										>
											<td>
												<input class="pointer" type="radio" name="video_delete" id="del_yes" value="1"
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
												<input class="pointer" type="radio" name="video_delete" id="del_no" value="0" checked="checked"
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

//////////////////////////
// Display Default-Page //
//////////////////////////

else
{
	// Video Listing
	echo '
					<form action="" method="post">
						<input type="hidden" name="go" value="playeredit">
						<table class="configtable" cellpadding="4" cellspacing="0">
						    <tr><td class="line" colspan="2">Video auswählen</td></tr>
	';

	// Get Videos from DB
	$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."player ORDER BY video_title", $db );
	while ( $video_arr = mysql_fetch_assoc ( $index ) ) {

		// Display each Video
		echo '
							<tr class="pointer" id="tr_'.$video_arr['video_id'].'"
								onmouseover="'.color_list_entry ( "input_".$video_arr['video_id'], "#EEEEEE", "#64DC6A", "this" ).'"
								onmouseout="'.color_list_entry ( "input_".$video_arr['video_id'], "transparent", "#49c24f", "this" ).'"
                                onclick="'.color_click_entry ( "input_".$video_arr['video_id'], "#EEEEEE", "#64DC6A", "this", TRUE ).'"
							>
								<td class="config" style="width: 100%;">
                                    '.$video_arr['video_title'].'<br>
                                    <span class="small"><a href="'.$video_arr['video_url'].'" target="_blank">'.$video_arr['video_url'].'</a></span>
								</td>
								<td class="config" style="text-align: center; vertical-align: middle;">
                                    <input class="pointer" type="radio" name="video_id" id="input_'.$video_arr['video_id'].'" value="'.$video_arr['video_id'].'"
										onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$video_arr['video_id'], TRUE ).'"
									>
								</td>
							</tr>
		';
	}
	
	// No Videos
	if ( mysql_num_rows ( $index ) < 1 ) {
		echo '
                            <tr><td class="space"></td></tr>
							<tr>
								<td class="config center">
									Keine Videos gefunden!
								</td>
							</tr>
                            <tr><td class="space"></td></tr>
						</table>
					</form>
		';
	} else {
		// End of Form & Table incl. Submit-Button
	 	echo '
							<tr><td class="space"></td></tr>
							<tr>
								<td style="text-align:right;" colspan="3">
									<select name="video_action" size="1">
										<option value="edit">'.$admin_phrases[common][selection_edit].'</option>
										<option value="delete">'.$admin_phrases[common][selection_del].'</option>
									</select>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="3">
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
?>