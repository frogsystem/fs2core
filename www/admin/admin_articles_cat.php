<?php if (!defined('ACP_GO')) die('Unauthorized access!');

//////////////////////////
// Load Articles Config //
//////////////////////////

// Create Articles-Config-Array
$config_arr = $sql->getRow('config', array('config_data'), array('W' => "`config_name` = 'articles'"));
$articles_config_arr = json_array_decode($config_arr['config_data']);
$showdefault = TRUE;


//////////////////////
// Update Database  //
//////////////////////

// Insert Category
if (
		isset ( $_POST['sended'] ) && $_POST['sended'] == 'add' &&
		isset ( $_POST['cat_action'] ) && $_POST['cat_action'] == 'add' &&
		isset ( $_POST['cat_name'] ) && $_POST['cat_name'] != ''
	)
{
    // Security-Functions
    $_POST['cat_user'] = $_SESSION['user_id'];
    settype ( $_POST['cat_user'], 'integer' );
    $cat_date = time ();

    // SQL-Insert-Query
    $stmt = $FD->sql()->conn()->prepare('
				INSERT INTO '.$FD->config('pref')."articles_cat (cat_name, cat_date, cat_user)
				VALUES (
					?,
					'".$cat_date."',
					'".$_POST['cat_user']."')");
    $stmt->execute(array($_POST['cat_name']));
    $id = $FD->sql()->conn()->lastInsertId();
    $message = $FD->text('page', 'new_cat_added');

	// Image-Operations
    if ( $_FILES['cat_pic']['name'] != '' ) {
      $upload = upload_img ( $_FILES['cat_pic'], 'images/cat/', 'articles_'.$id, $articles_config_arr['cat_pic_size']*1024, $articles_config_arr['cat_pic_x'], $articles_config_arr['cat_pic_y'] );
      $message .= '<br>' . upload_img_notice ( $upload );
    }

    // Display Message
    systext ( $message, $FD->text('admin', 'info') );

    // Unset Vars
    unset ( $_POST );

    // Set Vars
    $_POST['cat_action'] = 'edit';
    $_POST['cat_id'] = $FD->sql()->conn()->lastInsertId();
}

// Update Category
elseif (
		isset ( $_POST['cat_id'] ) &&
		isset ( $_POST['sended'] ) && $_POST['sended'] == 'edit' &&
		isset ( $_POST['cat_action'] ) && $_POST['cat_action'] == 'edit' &&

		isset($_POST['d']) && $_POST['d'] != '' && $_POST['d'] > 0 &&
		isset($_POST['m']) && $_POST['m'] != '' && $_POST['m'] > 0 &&
		isset($_POST['y']) && $_POST['y'] != '' && $_POST['y'] > 0 &&

		isset($_POST['cat_name']) && $_POST['cat_name'] != '' &&
		isset ( $_POST['cat_user'] )
	)
{
    // Security-Functions
    settype ( $_POST['cat_id'], 'integer' );
    settype ( $_POST['cat_user'], 'integer' );
    $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
    $cat_date = mktime ( 0, 0, 0, $date_arr['m'], $date_arr['d'], $date_arr['y'] );

    // SQL-Update-Query
    $stmt = $FD->sql()->conn()->prepare('
				UPDATE '.$FD->config('pref')."articles_cat
                SET
				 	cat_name 		= ?,
                   	cat_description = ?,
                   	cat_date 		= '".$cat_date."',
                   	cat_user 		= '".$_POST['cat_user']."'
                WHERE
				 	cat_id 			= '".$_POST['cat_id']."'
	");
	$stmt->execute(array($_POST['cat_name'], $_POST['cat_description']));
    $message = $FD->text('admin', 'changes_saved');

	// Image-Operations
    if ( isset($_POST['cat_pic_delete']) && $_POST['cat_pic_delete'] == 1 ) {
      if ( image_delete ( 'images/cat/', 'articles_'.$_POST['cat_id'] ) ) {
        $message .= '<br>' . $FD->text("admin", "image_deleted");
      } else {
		$message .= '<br>' . $FD->text("admin", "image_not_deleted");
      }
    } elseif ( $_FILES['cat_pic']['name'] != '' ) {
      image_delete ( 'images/cat/', 'articles_'.$_POST['cat_id'] );
	  $upload = upload_img ( $_FILES['cat_pic'], 'images/cat/', 'articles_'.$_POST['cat_id'], $articles_config_arr['cat_pic_size']*1024, $articles_config_arr['cat_pic_x'], $articles_config_arr['cat_pic_y'] );
      $message .= '<br>' . upload_img_notice ( $upload );
    }

    // Display Message
    systext ( $message, $FD->text("admin", "info") );

    // Unset Vars
    unset ( $_POST );
    $showdefault = FALSE;
}

// Delete Category
elseif (
		isset ( $_POST['cat_id'] ) &&
		isset ( $_POST['sended'] ) && $_POST['sended'] == 'delete' &&
		isset ( $_POST['cat_action'] ) && $_POST['cat_action'] == 'delete' &&
		isset ( $_POST['cat_move_to'] ) &&
		isset ( $_POST['cat_delete'] )
	)
{
    if ( $_POST['cat_delete'] == 1 ) {

        // Security-Functions
        settype ( $_POST['cat_id'], 'integer' );
        settype ( $_POST['cat_move_to'], 'integer' );

        // SQL-Query moves Articles to other Category
        $FD->sql()->conn()->exec ('
				UPDATE '.$FD->config('pref')."articles
    	        SET
				 	cat_id = '".$_POST['cat_move_to']."'
            	WHERE
					cat_id = '".$_POST['cat_id']."'" );

		// SQL-Delete-Query
    	$FD->sql()->conn()->exec ('
				DELETE FROM '.$FD->config('pref')."articles_cat
                WHERE
					cat_id = '".$_POST['cat_id']."'" );
		$message = $FD->text('page', 'cat_deleted');

		// Delete Category Image
		if ( image_delete ( 'images/cat/', 'articles_'.$_POST['cat_id'] ) ) {
			$message .= '<br>' . $FD->text('admin', 'image_deleted');
		}

    } else {
        $message = $FD->text('page', 'cat_not_deleted');
    }

    // Display Message
    systext ( $message, $FD->text('admin', 'info') );

    // Unset Vars
    unset ( $_POST );
    $showdefault = FALSE;
}



///////////////////////////
// Display Action-Pages  //
///////////////////////////

// No Data to write into DB
if ( isset($_POST['cat_id']) && isset($_POST['cat_action']) )
{
    settype ($_POST['cat_id'], 'integer');
    // Edit Category
    if ( $_POST['cat_action'] == 'edit' )
    {

		// Load Data from DB
		$index = $FD->sql()->conn()->query ( 'SELECT * FROM '.$FD->config('pref')."articles_cat WHERE cat_id = '".$_POST['cat_id']."'" );
		$cat_arr = $index->fetch(PDO::FETCH_ASSOC);

		// Display Error Messages
		if ( isset ( $_POST['sended'] ) ) {
            $cat_arr = getfrompost ( $cat_arr );
            systext ( $FD->text("admin", "form_not_filled"), $FD->text("admin", "error"), TRUE );
		}

		// Security-Functions
		$cat_arr['cat_name'] = killhtml ( $cat_arr['cat_name'] );
		$cat_arr['cat_description'] = killhtml ( $cat_arr['cat_description'] );

    	// Get User
    	$index = $FD->sql()->conn()->query ( 'SELECT user_name FROM '.$FD->config('pref')."user WHERE user_id = '".$cat_arr['cat_user']."'" );
    	$cat_arr['cat_username'] = killhtml ( $index->fetchColumn() );

		// Create Date-Arrays
    	if ( !isset ( $_POST['d'] ) ) {
    		$_POST['d'] = date ( 'd', $cat_arr['cat_date'] );
    		$_POST['m'] = date ( 'm', $cat_arr['cat_date'] );
    		$_POST['y'] = date ( 'Y', $cat_arr['cat_date'] );
		}
        $date_arr = getsavedate ( $_POST['d'], $_POST['m'], $_POST['y'] );
    	$nowbutton_array = array( 'd', 'm', 'y' );

		// Display Page
		echo '
					<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="sended" value="edit">
						<input type="hidden" name="cat_action" value="'.$_POST['cat_action'].'">
						<input type="hidden" name="cat_id" value="'.$cat_arr['cat_id'].'">
						<input type="hidden" name="go" value="articles_cat">
						<table class="configtable" cellpadding="4" cellspacing="0">
						    <tr><td class="line" colspan="2">'.$FD->text("page", "edit_cat_title").'</td></tr>
       						<tr>
           						<td class="config">
               						'.$FD->text("page", "edit_cat_name").':<br>
               						<span class="small">'.$FD->text("page", "edit_cat_name_desc").'</span>
           						</td>
           						<td>
             						<input class="text" name="cat_name" size="40" maxlength="100" value="'.$cat_arr['cat_name'].'">
           						</td>
       						</tr>
                            <tr>
                                <td class="config">
                                    '.$FD->text("page", "edit_cat_date").':<br>
                                    <span class="small">'.$FD->text("page", "edit_cat_date_desc").'</span>
                                </td>
                                <td class="config" valign="top">
									<span class="small">
										<input class="text" size="3" maxlength="2" id="d" name="d" value="'.$date_arr['d'].'"> .
                                    	<input class="text" size="3" maxlength="2" id="m" name="m" value="'.$date_arr['m'].'"> .
                                    	<input class="text" size="5" maxlength="4" id="y" name="y" value="'.$date_arr['y'].'">&nbsp;
									</span>
									'.js_nowbutton ( $nowbutton_array, $FD->text("admin", "today") ).'
                                </td>
                            </tr>
                            <tr>
                                <td class="config" valign="top">
                                    '.$FD->text("page", "edit_cat_by").':<br>
                                    <span class="small">'.$FD->text("page", "edit_cat_by_desc").'</span>
                                </td>
                                <td class="config" valign="top">
                                    <input class="text" size="30" maxlength="100" readonly="readonly" id="username" name="cat_username" value="'.$cat_arr['cat_username'].'">
                                    <input type="hidden" id="userid" name="cat_user" value="'.$cat_arr['cat_user'].'">
                                    <input class="button" type="button" onClick=\''.openpopup ( '?go=find_user', 400, 400 ).'\' value="'.$FD->text("admin", "change").'">
                                </td>
                            </tr>
                            <tr><td class="space"></td></tr>
       						<tr><td class="line" colspan="2">'.$FD->text("page", "edit_cat_title_optional").'</td></tr>
       						<tr>
           						<td class="config">
             						'.$FD->text("page", "edit_cat_image").': <span class="small">('.$FD->text("admin", "optional").')</span><br><br>
	 	';
		if ( image_exists ( 'images/cat/', 'articles_'.$cat_arr['cat_id'] ) ) {
		    echo '
									<img src="'.image_url ( 'images/cat/', 'articles_'.$cat_arr['cat_id'] ).'" alt="'.$cat_arr['cat_name'].'" border="0">
		    						<table>
										<tr>
											<td>
												<input type="checkbox" name="cat_pic_delete" id="cpd" value="1" onClick=\'delalert ("cpd", "'.$FD->text("admin", "js_delete_image").'")\'>
											</td>
											<td>
												<span class="small"><b>'.$FD->text("admin", "delete_image").'</b></span>
											</td>
										</tr>
									</table>
			';
		} else {
		    echo '<span class="small">'.$FD->text("admin", "no_image_found").'</span><br>';
		}
		echo'                   	<br>
								</td>
								<td class="config">
									<input name="cat_pic" type="file" size="40" class="text"><br>
		';
		if ( image_exists ( 'images/cat/', 'articles_'.$cat_arr['cat_id'] ) ) {
			echo '<span class="small"><b>'.$FD->text("admin", "replace_img").'</b></span><br>';
		}
		echo'
									<span class="small">
										['.$FD->text("admin", "max").' '.$articles_config_arr['cat_pic_x'].' '.$FD->text("admin", "resolution_x").' '.$articles_config_arr['cat_pic_y'].' '.$FD->text("admin", "pixel").'] ['.$FD->text("admin", "max").' '.$articles_config_arr['cat_pic_size'].' '.$FD->text("admin", "kib").']
									</span>
								</td>
							</tr>
							<tr align="left" valign="top">
								<td class="config">
            						'.$FD->text("page", "edit_cat_desc").': <span class="small">('.$FD->text("admin", "optional").')</span><br>
									<span class="small">'.$FD->text("page", "edit_cat_desc_desc").'</span>
								</td>
								<td class="config">
									<textarea class="text" name="cat_description" rows="5" cols="50" wrap="virtual">'.$cat_arr['cat_description'].'</textarea>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="2">
									<button class="button_new" type="submit">
										'.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "save_changes_button").'
									</button>
								</td>
							</tr>
						</table>
					</form>';
	}

	// Delete Category
	elseif ( $_POST['cat_action'] == 'delete' )
	{
		$index = $FD->sql()->conn()->query ( 'SELECT COUNT(*) FROM '.$FD->config('pref').'articles_cat' );

		// Not Last Category
		if ( $index->fetchColumn() > 1 ) {

			$index = $FD->sql()->conn()->query ( 'SELECT * FROM '.$FD->config('pref')."articles_cat WHERE cat_id = '".$_POST['cat_id']."'" );
			$cat_arr = $index->fetch(PDO::FETCH_ASSOC);

			$cat_arr['cat_name'] = killhtml ( $cat_arr['cat_name'] );

			echo '
					<form action="" method="post">
						<input type="hidden" name="sended" value="delete">
						<input type="hidden" name="cat_action" value="'.$_POST['cat_action'].'">
						<input type="hidden" name="cat_id" value="'.$cat_arr['cat_id'].'">
						<input type="hidden" name="go" value="articles_cat">
						<table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="2">'.$FD->text("page", "delete_cat_title").'</td></tr>
							<tr>
								<td class="config" style="width: 100%;">
									'.$FD->text("page", "delete_cat_question").': "'.$cat_arr['cat_name'].'"
								</td>
								<td class="config right"">
								    '.get_yesno_table ( 'cat_delete' ).'
								</td>
							</tr>
							<tr>
								<td class="config">
									'.$FD->text("page", "delete_cat_move_to").':
								</td>
								<td style="text-align: right;">
									<select class="text" name="cat_move_to" size="1">
			';

			$index = $FD->sql()->conn()->query ( 'SELECT * FROM '.$FD->config('pref')."articles_cat WHERE cat_id != '".$cat_arr['cat_id']."' ORDER BY cat_name" );
			while ( $move_arr = $index->fetch(PDO::FETCH_ASSOC) ) {
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
										'.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "do_action_button_long").'
									</button>
								</td>
							</tr>
						</table>
					</form>
			';
		}

		// Last Category
		else {
		    systext ( $FD->text("page", "delete_cat_last"), $FD->text("admin", "error"), TRUE );
		    echo '
						<table class="configtable" cellpadding="4" cellspacing="0">
       						<tr>
           						<td class="config">
									<a class="link_button" href="?go=articles_cat">'.$FD->text("admin", "button_arrow").' '.$FD->text("page", "delete_back_link").'</a>
								</td>
							</tr>
						</table>';
		}
	}
}



//////////////////////////
// Display Default-Page //
//////////////////////////

// Display New Category & Category Listing
elseif ( $showdefault == TRUE )
{
    // New Category
    if (!isset($_POST['cat_name']))
      $_POST['cat_name'] = '';
    $_POST['cat_name'] = killhtml ( $_POST['cat_name'] );
	// Display Error Messages
	if ( isset ( $_POST['sended'] ) ) {
		systext ( $FD->text('admin', 'form_not_filled'), $FD->text('admin', 'error'), TRUE );
	}

    // Display Add-Form
	echo '
					<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="sended" value="add">
					    <input type="hidden" name="cat_action" value="add">
						<input type="hidden" name="go" value="articles_cat">
						<table class="configtable" cellpadding="4" cellspacing="0">
						    <tr><td class="line" colspan="2">'.$FD->text('page', 'new_cat_title').'</td></tr>
						    <tr>
								<td class="config">
								    <span class="small">'.$FD->text('page', 'new_cat_name').':</span>
								</td>
								<td class="config">
								    <span class="small">'.$FD->text('page', 'new_cat_image').': ('.$FD->text('admin', 'optional').')</span>
								</td>
							</tr>
						    <tr valign="top">
								<td class="config">
									<input class="text" name="cat_name" size="40" maxlength="100" value="'.$_POST['cat_name'].'">
								</td>
								<td class="config">
									<input name="cat_pic" type="file" size="30" class="text"><br>
									<span class="small">
										['.$FD->text('admin', 'max').' '.$articles_config_arr['cat_pic_x'].' '.$FD->text('admin', 'resolution_x').' '.$articles_config_arr['cat_pic_y'].' '.$FD->text('admin', 'pixel').'] ['.$FD->text('admin', 'max').' '.$articles_config_arr['cat_pic_size'].' '.$FD->text('admin', 'kib').']
									</span>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="2">
									<button class="button_new" type="submit">
										'.$FD->text('admin', 'button_arrow').' '.$FD->text('page', 'new_cat_add_button').'
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
						<input type="hidden" name="go" value="articles_cat">
						<table class="configtable" cellpadding="4" cellspacing="0">
						    <tr><td class="line" colspan="3">'.$FD->text('page', 'list_cat_title').'</td></tr>
	';

	// Get Categories from DB
	$index = $FD->sql()->conn()->query ( 'SELECT * FROM '.$FD->config('pref').'articles_cat ORDER BY cat_name' );
	while ( $cat_arr = $index->fetch(PDO::FETCH_ASSOC) )
	{
		$index_username = $FD->sql()->conn()->query ( 'SELECT user_name FROM '.$FD->config('pref')."user WHERE user_id = '".$cat_arr['cat_user']."'" );
        $cat_arr['cat_user'] = $index_username->fetchColumn();

		// Display each Category
		echo '
							<tr class="pointer" id="tr_'.$cat_arr['cat_id'].'"
								onmouseover="'.color_list_entry ( 'input_'.$cat_arr['cat_id'], '#EEEEEE', '#64DC6A', 'this' ).'"
								onmouseout="'.color_list_entry ( 'input_'.$cat_arr['cat_id'], 'transparent', '#49c24f', 'this' ).'"
                                onclick="'.color_click_entry ( 'input_'.$cat_arr['cat_id'], '#EEEEEE', '#64DC6A', 'this', TRUE ).'"
							>
								<td class="config">
		';
		if ( image_exists ( 'images/cat/', 'articles_'.$cat_arr['cat_id'] ) ) {
		    echo '<img src="'.image_url ( 'images/cat/', 'articles_'.$cat_arr['cat_id'] ).'" alt="'.$cat_arr['cat_name'].'" border="0">';
		}
		echo '
								</td>
								<td class="config" style="width: 100%;">
									'.$cat_arr['cat_name'].' <span class="small">('.$FD->text("page", "list_cat_created_by").' <b>'.$cat_arr['cat_user'].'</b> '.$FD->text("page", "list_cat_created_on").' <b>'.date ( $FD->config('date'), $cat_arr['cat_date'] ).'</b>)</span><br>
									<span class="small">'.$cat_arr['cat_description'].'</span>
								</td>
								<td class="config" style="text-align: center; vertical-align: middle;">
                                    <input class="pointer" type="radio" name="cat_id" id="input_'.$cat_arr['cat_id'].'" value="'.$cat_arr['cat_id'].'"
										onclick="'.color_click_entry ( 'this', '#EEEEEE', '#64DC6A', 'tr_'.$cat_arr['cat_id'], TRUE ).'"
									>
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
										<option value="edit">'.$FD->text("admin", "selection_edit").'</option>
										<option value="delete">'.$FD->text("admin", "selection_delete").'</option>
									</select>
								</td>
							</tr>
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="3">
									<button class="button_new" type="submit">
										'.$FD->text("admin", "button_arrow").' '.$FD->text("admin", "do_action_button_long").'
									</button>
								</td>
							</tr>
						</table>
					</form>
	';
}
?>
