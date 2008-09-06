<?php
///////////////////
//// functions ////
///////////////////

function get_user_rights_array ( $USER_ID )
{
    global $global_config_arr;
    global $db;

    unset ( $user_rights );

	$index = mysql_query ( "
							SELECT `perm_id`
							FROM ".$global_config_arr['pref']."user_permissions
							WHERE `x_id` = '".$USER_ID."'
							AND`perm_for_group` = '0'
	", $db);
	while ( $temp_arr = mysql_fetch_assoc ( $index ) ) {
		    $user_rights[] = $temp_arr['perm_id'];
	}
	if ( !is_array ( $user_rights ) ) {
	    $user_rights = array ();
	}
	
	return $user_rights;
}

function get_group_rights_array ( $GROUP_ID, $IS_USER = FALSE )
{
    global $global_config_arr;
    global $db;

    unset ( $group_rights );

	if ( $IS_USER == TRUE ) {
		$index = mysql_query ( "
								SELECT `user_group`
								FROM ".$global_config_arr['pref']."user
								WHERE `user_id` = '".$GROUP_ID."'
		", $db);
        $GROUP_ID = mysql_result ( $index, 0, "user_group" );
	}

	$index = mysql_query ( "
							SELECT `perm_id`
							FROM ".$global_config_arr['pref']."user_permissions
							WHERE `x_id` = '".$GROUP_ID."'
							AND`perm_for_group` = '1'
	", $db);
	while ( $temp_arr = mysql_fetch_assoc ( $index ) ) {
		    $group_rights[] = $temp_arr['perm_id'];
	}
	if ( !is_array ( $group_rights ) ) {
	    $group_rights = array ();
	}

	return $group_rights;
}



////////////////////////////
//// save changes to db ////
////////////////////////////

if ( isset( $_POST['user_id'] ) ) {

	// security functions
	settype ( $_POST['user_id'], 'integer' );
 	unset ( $user_rights );
 	
	// if user is not s-admin and not himself
	if ( $_POST['user_id'] != 1 && $_POST['user_id'] != $_SESSION['user_id'] ) {

		// get already granted rights
		$user_rights = get_user_rights_array ( $_POST['user_id'] );

		// get pages
		$pageaction = mysql_query ( "
			                    		SELECT `page_id`
			                    		FROM `".$global_config_arr['pref']."admin_cp`
			                    		WHERE `group_id` > '0'
		", $db );
		while ( $page_arr = mysql_fetch_assoc ( $pageaction ) ) {
		    // permission is not longer granted
			if ( $_POST[$page_arr['page_id']] == 0 && in_array ( $page_arr['page_id'], $user_rights ) ) {
            	mysql_query ( "
								DELETE
								FROM `".$global_config_arr['pref']."user_permissions`
								WHERE `perm_id` = '".$page_arr['page_id']."'
								AND `x_id` = '".$_POST['user_id']."'
								AND `perm_for_group` = '0'
				", $db );
				
			// permission is now granted
			} elseif ( $_POST[$page_arr['page_id']] == 1
						&& !in_array ( $page_arr['page_id'], $user_rights )
						&& !in_array ( $page_arr['page_id'], get_group_rights_array ( $_POST['user_id'], TRUE ) )
			) {
            	mysql_query ( "
								INSERT
								INTO `".$global_config_arr['pref']."user_permissions` (`perm_id`, `x_id`, `perm_for_group`)
								VALUES ('".$page_arr['page_id']."', '".$_POST['user_id']."', 0)
				", $db );
			}
		}

        systext ( $admin_phrases[common][changes_saved], $admin_phrases[common][info] );
    }
    else {
		systext ( "Dieser User kann nicht bearbeitet werden", $admin_phrases[common][error], TRUE );
    }

    // Unset Vars
    unset ( $_POST );
}


  
//////////////////////////
//// edit permissions ////
//////////////////////////

if ( isset ( $_POST['edit_user_id'] ) )
{
	// security functions
	settype ( $_POST['edit_user_id'], "integer" );
	
	// get user data
    $index = mysql_query ( "
							SELECT `user_name`, `user_id`, `user_group`, `user_is_staff`, `user_is_admin`
							FROM ".$global_config_arr['pref']."user
							WHERE `user_id` = '".$_POST['edit_user_id']."'
							LIMIT 0,1
	", $db);
    $user_arr = mysql_fetch_assoc ( $index );

	// get granted rights
    $user_rights = get_user_rights_array ( $user_arr['user_id'] );
	$group_rights = get_group_rights_array ( $user_arr['user_group'] );

	// security functions
	unset ( $DATA_ARR );
    $entries = 0;
    
    // get groups
	$groupaction = mysql_query ( "
		                            SELECT `group_id`, `group_title`
		                            FROM `".$global_config_arr['pref']."admin_groups`
		                            WHERE `group_id` > 0
		                            ORDER BY `group_title` ASC
	", $db );
	while ( $group_arr = mysql_fetch_assoc ( $groupaction ) ) {
		$DATA_ARR[$group_arr['group_id']]['title'] = $group_arr['group_title'];
		
		// get pages
		$pageaction = mysql_query ( "
			                    		SELECT `page_id`, `page_link`
			                    		FROM `".$global_config_arr['pref']."admin_cp`
			                    		WHERE `group_id` = '".$group_arr['group_id']."'
			                    		ORDER BY `page_pos` ASC, `page_id` ASC
		", $db );
		// count number of entries
		$entries = $entries + mysql_num_rows ( $pageaction );
		while ( $page_arr = mysql_fetch_assoc ( $pageaction ) ) {
			$DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['page_link'] = $page_arr['page_link'];

			// is permission granted?
			if ( $user_arr['user_is_admin'] == 1 || $user_arr['user_id'] == 1 ) {
				$DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = "group";
			} elseif ( in_array ( $page_arr['page_id'], $group_rights ) ) {
				$DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = "group";
			} elseif ( in_array ( $page_arr['page_id'], $user_rights  ) ) {
				$DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = "user";
			} else {
				$DATA_ARR[$group_arr['group_id']]['links'][$page_arr['page_id']]['granted'] = false;
			}
		}
	}

	// start display
    echo'
					<form action="" method="post">
						<input type="hidden" name="go" value="user_rights">
						<input type="hidden" name="user_id" value="'.$_POST['edit_user_id'].'">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="3">Benutzerrechte �ndern f�r: '.$user_arr['user_name'].'</td></tr>
							<tr><td align="left">
							    <span class="small"><b>Hinweis:</b> Deaktivierte Felder markieren Rechte, die der User durch die Mitgliedschaft in einer Gruppe erhalten hat.</span>
							    <table cellpadding="4" cellspacing="0" align="center">
							        <tr><td class="config">
	';

	// get data for col-divisor
    $per_col = ceil ( $entries/3 ) + 2; // +2 makes it more flexible
    $i = 0;
    
    // display data from data array
    foreach ( $DATA_ARR as $GROUP_ARR ) {
        if ( is_array ( $GROUP_ARR['links'] ) ) {
	        if ( $per_col < $i + count ( $GROUP_ARR['links'] ) ) {
				echo '</td><td width="30" class="config"></td><td class="config">';
				$i = 1;
			}
			echo '<br>'.$GROUP_ARR['title'].'<br>';
			foreach ( $GROUP_ARR['links'] as $PAGE_ID => $PAGE_ARR ) {
                echo '<input class="pointer" type="checkbox" style="vertical-align: middle;" name="'.$PAGE_ID.'" value="1"
				'.getchecked ( $PAGE_ARR['granted'], "group" ).'
				'.getdisabled ( $PAGE_ARR['granted'], "group" ).'
				'.getchecked ( $PAGE_ARR['granted'], "user" ).'
				><span class="small">'.$PAGE_ARR['page_link'].'</span><br>';
 				$i++;
			}
        }
    }
              
    echo'
									</td></tr>
								</table>
							</td></tr>
                            <tr><td class="space"></td></tr>
                            <tr>
                                <td colspan="3" class="buttontd">
                                    <button class="button_new" type="submit">
                                        '.$admin_phrases[common][arrow].' '.$admin_phrases[common][save_long].'
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
    ';
}



/////////////////////
//// select user ////
/////////////////////

else
{
	// start display
	echo '
					<form action="" method="post">
						<input type="hidden" name="go" value="user_rights">
                        <table class="configtable" cellpadding="4" cellspacing="0">
							<tr><td class="line" colspan="4">Benutzer ausw�hlen</td></tr>
	';
	
	// get staff-users from db
    $index = mysql_query ( "
							SELECT `user_id`, `user_name`, `user_mail`, `user_group`, `user_is_admin`
							FROM ".$global_config_arr['pref']."user
							WHERE `user_is_staff` = '1' AND `user_id` != '1' AND `user_id` != '".$_SESSION['user_id']."'
                          	ORDER BY user_name
	", $db );
	
	// users found
    if ( mysql_num_rows ( $index ) > 0 ) {
		// display table head
		echo '
							<tr>
							    <td class="config">Name</td>
							    <td class="config">E-Mail</td>
							    <td class="config">Gruppe</td>
							    <td class="config" width="20"></td>
							</tr>
		';
		
		// display users
	    while ( $user_arr = mysql_fetch_assoc ( $index ) )
	    {
			// get user group
			if ( $user_arr['user_group'] != 0 ) {
				$groupindex = mysql_query ( "
												SELECT `user_group_name`
												FROM ".$global_config_arr['pref']."user_groups
												WHERE `user_group_id` = '".$user_arr['user_group']."'
	                               				LIMIT 0,1
				", $db );
				$user_arr['user_group_name'] = killhtml ( mysql_result ( $groupindex, 0, "user_group_name" ) );
			} elseif ( $user_arr['user_is_admin'] == 1 ) {
			    $user_arr['user_group_name'] = "Administrator";
			} else {
			    $user_arr['user_group_name'] = "";
			}

			// user entry
	        echo '
							<tr class="pointer" id="tr_'.$user_arr['user_id'].'"
								onmouseover="'.color_list_entry ( "input_".$user_arr['user_id'], "#EEEEEE", "#64DC6A", "this" ).'"
								onmouseout="'.color_list_entry ( "input_".$user_arr['user_id'], "transparent", "#49c24f", "this" ).'"
                                onclick="'.color_click_entry ( "input_".$user_arr['user_id'], "#EEEEEE", "#64DC6A", "this", TRUE ).'"
							>
								<td class="configthin middle">'.killhtml($user_arr['user_name']).'</td>
								<td class="configthin middle">'.killhtml($user_arr['user_mail']).'</td>
								<td class="configthin middle">'.killhtml($user_arr['user_group_name']).'</td>
								<td class="config top center">
									<input class="pointer" type="radio" name="edit_user_id" id="input_'.$user_arr['user_id'].'" value="'.$user_arr['user_id'].'"
													onclick="'.color_click_entry ( "this", "#EEEEEE", "#64DC6A", "tr_".$user_arr['user_id'], TRUE ).'"
								</td>
							</tr>
			';
	    }

	    // display footer with button
	    echo'
							<tr><td class="space"></td></tr>
							<tr>
								<td class="buttontd" colspan="4">
									<button class="button_new" type="submit">
										'.$admin_phrases[common][arrow].' '."Benutzerrechte �ndern".'
									</button>
								</td>
							</tr>
		';
		
	// no users found
    } else {

		echo'
                            <tr><td class="space"></td></tr>
							<tr>
								<td class="config center" colspan="4">Keine Mitarbeiter gefunden!</td>
							</tr>
							<tr><td class="space"></td></tr>
        ';
    }
    
	echo '
						</table>
					</form>
	';
}
?>