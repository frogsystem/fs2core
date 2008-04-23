<?php
///////////////////////
// Load News Config  //
///////////////////////

// Create News-Config-Array
$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_config", $db );
$news_config_arr = mysql_fetch_assoc ( $index );



//////////////////////
// Update Database  //
//////////////////////

// Insert Category
if (
		isset ( $_POST['sended'] ) && $_POST['sended'] == "add" &&
		isset ( $_POST['cat_action'] ) && $_POST['cat_action'] == "add" &&
		$_POST['cat_name'] && $_POST['cat_name'] != ""
	)
{
	// Security-Functions
	$_POST['cat_name'] = savesql ( $_POST['cat_name'] );
	$_POST['cat_user'] = $_SESSION['user_id'];
	settype ( $_POST['cat_user'], "integer" );
	$cat_date = time ();

	// MySQL-Update-Query
    $insert_query = mysql_query ("
					INSERT INTO ".$global_config_arr['pref']."news_cat (cat_name, cat_date, cat_user)
					VALUES (
						'".$_POST['cat_name']."',
						'".$cat_date."',
						'".$_POST['cat_user']."'
					)
	", $db );
    $message = "blubb";

	// Image-Operations
    if ( $_FILES['cat_pic']['name'] != "" ) {
      $upload = upload_img ( $_FILES['cat_pic'], "../images/news_cat/", $_POST['cat_id'], $news_config_arr[cat_pic_size]*1024, $news_config_arr[cat_pic_x], $news_config_arr[cat_pic_y] );
      $message .= "<br>" . upload_img_notice ( $upload );
    }

    // Display Message
    systext ( $message, $admin_phrases[common][info] );
    
    // Unset Vars
    unset ( $_POST );

	// Set Vars
	$_POST['cat_action'] = "edit";
	$_POST['cat_id'] = mysql_insert_id ( $db );
}

// Update Category
elseif (
		isset ( $_POST['cat_id'] ) &&
		isset ( $_POST['sended'] ) && $_POST['sended'] == "edit" &&
		isset ( $_POST['cat_action'] ) && $_POST['cat_action'] == "edit" &&
		
		$_POST['d'] && $_POST['d'] != "" && $_POST['d'] > 0 &&
		$_POST['m'] && $_POST['m'] != "" && $_POST['m'] > 0 &&
		$_POST['y'] && $_POST['y'] != "" && $_POST['y'] > 0 &&
		
		$_POST['cat_name'] && $_POST['cat_name'] != "" &&
		isset ( $_POST['cat_user'] )
	)
{
	// Security-Functions
	$_POST['cat_name'] = savesql ( $_POST['cat_name'] );
	$_POST['cat_description'] = savesql ( $_POST['cat_description'] );
	settype ( $_POST['cat_id'], "integer" );
    settype ( $_POST['cat_user'], "integer" );
    $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
	$cat_date = mktime ( 0, 0, 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );

	// MySQL-Update-Query
    mysql_query ("
					UPDATE ".$global_config_arr['pref']."news_cat
                 	SET
					 	cat_name 			= '".$_POST['cat_name']."',
                     	cat_description 	= '".$_POST['cat_description']."',
                     	cat_date 			= '".$cat_date."',
                     	cat_user 			= '".$_POST['cat_user']."'
                 	WHERE
					 	cat_id = '".$_POST['cat_id']."'
	", $db );
    $message = $admin_phrases[common][changes_saved];

	// Image-Operations
    if ( $_POST['cat_pic_delete'] == 1 ) {
      if ( image_delete ("../images/news_cat/", $_POST[cat_id] ) ) {
        $message .= "<br>Das Bild wurde erfolgreich gelöscht!" ;
      } else {
		$message .= "<br>Das Bild konnte nicht gelöscht werden, da es nicht existiert!" ;
      }
    } elseif ( $_FILES['cat_pic']['name'] != "" ) {
      $upload = upload_img ( $_FILES['cat_pic'], "../images/news_cat/", $_POST['cat_id'], $news_config_arr[cat_pic_size]*1024, $news_config_arr[cat_pic_x], $news_config_arr[cat_pic_y] );
      $message .= "<br>" . upload_img_notice ( $upload );
    }
    
    // Display Message
    systext ( $message, $admin_phrases[common][info] );
    
    // Unset Vars
    unset ( $_POST );
}

// Delete Category
elseif ($_POST['cat_id'] AND $_POST['sended'] == "delete")
{
  mysql_query("UPDATE ".$global_config_arr[pref]."news
               SET cat_id = '$_POST[cat_move_to]'
               WHERE cat_id = '$_POST[cat_id]'", $db);

  mysql_query("DELETE FROM ".$global_config_arr[pref]."news_cat
               WHERE cat_id = '$_POST[cat_id]'", $db);

  systext("Die Kategorie wurde gelöscht!");

  if (image_delete("../images/news_cat/", $_POST[cat_id]))
  {
    systext('Das Bild wurde erfolgreich gelöscht!');
  }

	// Unset Vars
	unset ( $_POST );
  
}



///////////////////////////
// Display Action-Pages  //
///////////////////////////

// No Data to write into DB
if ( $_POST['cat_id'] && $_POST['cat_action'] )
{
	// Edit Category
	if ( $_POST['cat_action'] == "edit" )
	{
	
		// Load Data from DB
		$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = '".$_POST['cat_id']."'", $db );
		$cat_arr = mysql_fetch_assoc ( $index );

		// Display Error Messages
		if ( isset ( $_POST['sended'] ) )
		{
            $cat_arr = getfrompost ( $cat_arr );
            systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
		}

		// Security-Functions
		$cat_arr['cat_name'] = killhtml ( $cat_arr['cat_name'] );
		$cat_arr['cat_description'] = killhtml ( $cat_arr['cat_description'] );

    	// Get User
    	$index = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = '".$cat_arr['cat_user']."'", $db );
    	$cat_arr['cat_username'] = killhtml ( mysql_result ( $index, 0, "user_name" ) );

		// Create Date-Arrays
    	if ( !isset ( $_POST['d'] ) )
    	{
    		$_POST['d'] = date ( "d", $cat_arr['cat_date'] );
    		$_POST['m'] = date ( "m", $cat_arr['cat_date'] );
    		$_POST['y'] = date ( "Y", $cat_arr['cat_date'] );
		}
        $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
    	$nowbutton_array = array( "d", "m", "y" );

		// Display Page
		echo '
					<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="sended" value="edit">
						<input type="hidden" name="cat_action" value="'.$_POST['cat_action'].'">
						<input type="hidden" name="cat_id" value="'.$cat_arr['cat_id'].'">
						<input type="hidden" name="go" value="newscat">
						<input type="hidden" name="PHPSESSID" value="'.session_id().'">
						<table class="configtable" cellpadding="4" cellspacing="0">
						    <tr><td class="line" colspan="2">Grundlegende</td></tr>
       						<tr>
           						<td class="config">
               						Name:<br>
               						<span class="small">Name der Kategorie</span>
           						</td>
           						<td>
             						<input class="text" name="cat_name" size="40" maxlength="100" value="'.$cat_arr['cat_name'].'">
           						</td>
       						</tr>
                            <tr>
                                <td class="config">
                                    '.$admin_phrases[news][news_date].':<br>
                                    <span class="small">'.$admin_phrases[news][news_date_desc].'</span>
                                </td>
                                <td class="config" valign="top">
									<span class="small">
										<input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                    	<input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                    	<input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'">&nbsp;
									</span>
									'.js_nowbutton ( $nowbutton_array, $admin_phrases[common][today] ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$admin_phrases[news][news_poster].':<br>
                                    <span class="small">'.$admin_phrases[news][news_poster_desc].'</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="cat_username" value="'.$cat_arr['cat_username'].'">
                                    <input type="hidden" id="userid" name="cat_user" value="'.$cat_arr['cat_user'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( "admin_finduser.php", 400, 400 ).'\' value="'.$admin_phrases[common][change_button].'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
       						<tr><td class="line" colspan="2">zusätzliche</td></tr>
       						<tr>
           						<td class="config">
             						Bild: <span class="small">(optional)</span><br><br>
	 	';
		if ( image_exists ( "../images/news_cat/", $cat_arr['cat_id'] ) ) {
		    echo '
									<img src="'.image_url ( "../images/news_cat/", $cat_arr['cat_id'] ).'" alt="'.$cat_arr['cat_name'].'" border="0">
		    						<table>
										<tr>
											<td>
												<input type="checkbox" name="cat_pic_delete" id="cpd" value="1" onClick=\'delalert ("cpd", "Soll das Kategorie Bild wirklich gelöscht werden?")\'>
											</td>
											<td>
												<span class="small"><b>Bild löschen</b></span>
											</td>
										</tr>
									</table>
			';
		} else {
		    echo '<span class="small">'.$admin_phrases[common][no_image].'</span><br>';
		}
		echo'                   	<br>
								</td>
								<td class="config">
									<input name="cat_pic" type="file" size="40" class="text"><br>
		';
		if ( image_exists ( "../images/news_cat/", $cat_arr['cat_id'] ) ) {
			echo '<span class="small"><b>Nur auswählen, wenn das aktuelle Bild überschrieben werden soll!</b></span><br>';
		}
		echo'
									<span class="small">
										['.$admin_phrases[common][max].' '.$news_config_arr[cat_pic_x].' '.$admin_phrases[common][resolution_x].' '.$news_config_arr[cat_pic_y].' '.$admin_phrases[common][pixel].'] ['.$admin_phrases[common][max].' '.$news_config_arr[cat_pic_size].' '.$admin_phrases[common][kib].']
									</span>
								</td>
							</tr>
							<tr align="left" valign="top">
								<td class="config">
            						Beschreibung: <span class="small">(optional)</span><br>
									<span class="small">Beschreibung der Kategorie</span>
								</td>
								<td class="config">
									<textarea class="text" name="cat_description" rows="5" cols="50" wrap="virtual">'.$cat_arr['cat_description'].'</textarea>
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
					</form>';
	}
	
	// Delete Category
	elseif ( $_POST['cat_action'] == "delete" )
	{
		$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat", $db );

		// Not Last Category
		if ( mysql_num_rows ( $index ) > 1 )
		{

			$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat WHERE cat_id = '".$_POST['cat_id']."'", $db );
			$cat_arr = mysql_fetch_assoc ( $index );

			$cat_arr['cat_name'] = killhtml ( $cat_arr['cat_name'] );

			echo '
					<form action="" method="post">
						<input type="hidden" name="sended" value="delete">
						<input type="hidden" name="cat_action" value="'.$_POST['cat_action'].'">
						<input type="hidden" name="cat_id" value="'.$cat_arr['cat_id'].'">
						<input type="hidden" name="go" value="newscat">
						<input type="hidden" name="PHPSESSID" value="'.session_id().'">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">zusätzliche</td></tr>
							<tr>
								<td class="config">
									Soll die Kategorie "'.$cat_arr['cat_name'].'" wirklich gelöscht werden?
								</td>
								<td class="config" style="text-align: center;">
		    						<table>
										<tr valign="bottom">
											<td>
												<input type="radio" name="" value="">
											</td>
											<td class="config" style="vertical-align: bottom;">
												Ja
											</td>
											<td style="width: 20px;"></td>
											<td>
												<input type="radio" name="" value="" checked="checked">
											</td>
											<td class="config" style="vertical-align: bottom;">
												Nein
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td class="config">
									News der gelöschten Kategorie verschieben nach:
								</td>
								<td style="text-align: center;">
									<select class="text" name="cat_move_to" size="1">
			';

			$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat WHERE cat_id != '".$cat_arr['cat_id']."' ORDER BY cat_name", $db );
			while ( $move_arr = mysql_fetch_assoc ( $index ) ) {
				echo '<option value="'.$move_arr['cat_id'].'">'.killhtml ( $move_arr['cat_name'] ).'</option>';
			}
			echo'
									</select>
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
		
		// Last Category
		else
		{
			echo '
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr>
								<td class="config">
									Die letzte Kategorie kann nicht gelöscht werden.<br>
									Bitte legen Sie zuerst eine neue Kategorie an.
								</td>
								<td>
									<a href="?mid=content&go=newscat" class="button_text">Zurück zur Übersicht</a>
								</td>
							</tr>
						</table>
			';
		}
	}
}



//////////////////////////
// Display Default-Page //
//////////////////////////

// Display New Category & Category Listing
else
{
    // New Caregory
	// Display Error Messages
	if ( isset ( $_POST['sended'] ) )
	{
		$_POST['cat_name'] = killhtml ( $_POST['cat_name'] );
		systext ( $admin_phrases[common][note_notfilled], $admin_phrases[common][error], TRUE );
	}

    // Display Add-Form
	echo '
					<form action="" method="post">
						<input type="hidden" name="sended" value="add">
					    <input type="hidden" name="cat_action" value="add">
						<input type="hidden" name="go" value="newscat">
						<input type="hidden" name="PHPSESSID" value="'.session_id().'">
						<table class="configtable" cellpadding="4" cellspacing="0">
						    <tr><td class="line" colspan="2">'.$admin_phrases[news][settings_title].'</td></tr>
						    <tr>
								<td class="config">
								    <span class="small">Name:</span>
								</td>
								<td class="config">
								    <span class="small">Bild: (optinal)</span>
								</td>
							</tr>
						    <tr valign="top">
								<td class="config">
									<input class="text" name="cat_name" size="40" maxlength="100" value="'.$_POST['cat_name'].'">
								</td>
								<td class="config">
									<input name="cat_pic" type="file" size="40" class="text"><br>
									<span class="small">
										['.$admin_phrases[common][max].' '.$news_config_arr[cat_pic_x].' '.$admin_phrases[common][resolution_x].' '.$news_config_arr[cat_pic_y].' '.$admin_phrases[common][pixel].'] ['.$admin_phrases[common][max].' '.$news_config_arr[cat_pic_size].' '.$admin_phrases[common][kib].']
									</span>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="2">
									<button class="button_new" type="submit">
										'.$admin_phrases[common][arrow].' Hinzufügen und weiter Einstellungen vornehmen
									</button>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
						</table>
					</form>
	';
	

	// Category Listing
	echo '
					<form action="" method="post">
						<input type="hidden" name="go" value="newscat">
						<input type="hidden" name="PHPSESSID" value="'.session_id().'">
						<table class="configtable" cellpadding="4" cellspacing="0">
						    <tr><td class="line" colspan="3">'.$admin_phrases[news][settings_title].'</td></tr>
	';
	
	// Get Categories from DB
	$index = mysql_query ( "SELECT * FROM ".$global_config_arr['pref']."news_cat ORDER BY cat_name", $db );
	while ( $cat_arr = mysql_fetch_assoc ( $index ) )
	{
		$index_username = mysql_query ( "SELECT user_name FROM ".$global_config_arr['pref']."user WHERE user_id = '".$cat_arr['cat_user']."'", $db );
        $cat_arr['cat_user'] = mysql_result ( $index_username, 0, "user_name" );

		// Display each Category
		echo '
							<tr style="cursor:pointer;"
	onmouseover=\'
		colorOver (document.getElementById("input_'.$cat_arr['cat_id'].'"), "#EEEEEE", "#64DC6A", this);\'
	onmouseout=\'
		colorOut (document.getElementById("input_'.$cat_arr['cat_id'].'"), "transparent", "#49c24f", this);\'
	onClick=\'
		createClick (document.getElementById("input_'.$cat_arr['cat_id'].'"));
		resetUnclicked ("transparent", last, lastBox, this);
		colorClick (document.getElementById("input_'.$cat_arr['cat_id'].'"), "#EEEEEE", "#64DC6A", this);\'
							>
								<td class="config">
		';
		if ( image_exists ( "../images/news_cat/", $cat_arr['cat_id'] ) ) {
		    echo '<img src="'.image_url ( "../images/news_cat/", $cat_arr['cat_id'] ).'" alt="'.$admin_cat_arr['cat_name'].'" border="0">';
		}
		echo '
								</td>
								<td class="config" style="width: 100%;">
									'.$cat_arr['cat_name'].' <span class="small">(erstellt von <b>'.$cat_arr['cat_user'].'</b> am <b>'.date ( $global_config_arr['date'], $cat_arr['cat_date'] ).'</b>)</span><br>
									<span class="small">'.$cat_arr['cat_description'].'</span>
								</td>
								<td class="config" style="text-align: center; vertical-align: middle;">
                                    <input type="radio" name="cat_id" id="input_'.$cat_arr['cat_id'].'" value="'.$cat_arr['cat_id'].'" style="cursor:pointer;" onClick=\'createClick(this);\'>
								</td>
							</tr>
		';
	}
	
	// End of Form & Table incl. Submit-Button
 	echo '
							<tr><td class="space"></td></tr>
							<tr>
								<td style="text-align:right;" colspan="3">
									<select name="cat_action" size="1">
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
?>